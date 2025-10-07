<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use thiagoalessio\TesseractOCR\TesseractOCR;

class OcrController extends Controller
{
    // Muestra el formulario para subir el archivo
    public function index()
    {
        return view('ocr');
    }

    // Procesa el archivo (imagen o PDF) y muestra el resultado del OCR
    public function process(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf'
        ]);

        $file = $request->file('file');
        $extension = strtolower($file->getClientOriginalExtension());
        $text = '';
        $uploadedFile = null;

        if ($extension === 'pdf') {
            // Almacena el PDF en el disco 'public' (en la carpeta "pdfs")
            $path = $file->store('pdfs', 'public');
            $fullPdfPath = storage_path('app/public/' . $path);
            $uploadedFile = $path;

            try {
                $client = new Client();
                // Endpoint de Stirling para convertir PDF a imagen
                $stirlingUrl = 'https://stirling-pdf-production-815b.up.railway.app/api/v1/convert/pdf/img';

                // Enviar el PDF con los parámetros que requiere la API e incluyendo autenticación
                $response = $client->post($stirlingUrl, [
                    'headers' => [
                        'Accept' => '*/*',
                        'X-API-KEY' => 'nrNtvM51oq8DMn9YKQsc3ouMMwuPAIpBPrT0z58wnriV9RpK29PuJpwKALWxwHFV5RoewVXeMTdMsKSgCiYR5KqSo2sxK187seJTU2IlQuuwio6fp1RNqN4B4ipqC3PG'
                    ],
                    'multipart' => [
                        [
                            'name'     => 'fileInput',
                            'contents' => fopen($fullPdfPath, 'r'),
                            'filename' => 'input.pdf',
                            'headers'  => [
                                'Content-Type' => 'application/pdf',
                                'X-API-KEY' => 'nrNtvM51oq8DMn9YKQsc3ouMMwuPAIpBPrT0z58wnriV9RpK29PuJpwKALWxwHFV5RoewVXeMTdMsKSgCiYR5KqSo2sxK187seJTU2IlQuuwio6fp1RNqN4B4ipqC3PG'
                            ]
                        ],
                        [
                            'name'     => 'imageFormat',
                            'contents' => 'png'
                        ],
                        [
                            'name'     => 'singleOrMultiple',
                            'contents' => 'multiple'
                        ],
                        [
                            'name'     => 'pageNumbers',
                            'contents' => ''  // Vacío para procesar todas las páginas
                        ],
                        [
                            'name'     => 'colorType',
                            'contents' => 'color'
                        ],
                        [
                            'name'     => 'dpi',
                            'contents' => '300'
                        ]
                    ]
                ]);

                // Capturamos el contenido crudo de la respuesta
                $rawResponse = $response->getBody()->getContents();
                if (empty($rawResponse)) {
                    dd('La respuesta de Stirling está vacía.');
                }

                // Si la respuesta comienza con "PK", es un archivo ZIP
                if (substr($rawResponse, 0, 2) === "PK") {
                    // Guardar el contenido en un archivo ZIP temporal
                    $tempZipPath = storage_path('app/public/temp_stirling.zip');
                    file_put_contents($tempZipPath, $rawResponse);

                    $zip = new \ZipArchive;
                    if ($zip->open($tempZipPath) === TRUE) {
                        // Directorio temporal para extraer las imágenes
                        $extractPath = storage_path('app/public/temp_stirling');
                        if (!file_exists($extractPath)) {
                            mkdir($extractPath, 0777, true);
                        }
                        $zip->extractTo($extractPath);
                        $zip->close();

                        // Obtener todos los archivos extraídos (se asume que son imágenes)
                        $files = glob($extractPath . '/*');
                        foreach ($files as $filePath) {
                            if (is_file($filePath)) {
                                $imageName = basename($filePath);
                                // Aplicar OCR a cada imagen
                                $ocrText = (new TesseractOCR($filePath))
                                    ->lang('eng')   // Ajusta según el idioma
                                    ->psm(4)        // Experimenta con distintos modos
                                    ->config('tessedit_char_blacklist', '!@#$%^&*()')
                                    ->run();
                                $text .= "Archivo $imageName:\n" . $ocrText . "\n\n";
                                // Eliminar la imagen una vez procesada
                                unlink($filePath);
                            }
                        }
                        // Eliminar el directorio temporal y el ZIP
                        rmdir($extractPath);
                        unlink($tempZipPath);
                    } else {
                        dd("No se pudo abrir el archivo ZIP descargado.");
                    }
                } else {
                    dd('La respuesta de Stirling no es un ZIP válido.');
                }
            } catch (\Exception $e) {
                return 'Error procesando el PDF con Stirling: ' . $e->getMessage();
            }
        } else {
            // Procesamiento directo para imágenes
            $path = $file->store('images', 'public');
            $uploadedFile = $path;
            $fullImagePath = storage_path('app/public/' . $path);
            $text .= (new TesseractOCR($fullImagePath))
                ->lang('eng')    // Ajusta el idioma según corresponda
                ->psm(4)         // Experimenta con distintos modos
                ->config('tessedit_char_blacklist', '!@#$%^&*()')
                ->run() . "\n";
        }

        return view('ocr', [
            'text'         => $text,
            'uploadedFile' => $uploadedFile,
            'extension'    => $extension
        ]);
    }
}
