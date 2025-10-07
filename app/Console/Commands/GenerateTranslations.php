<?php


namespace App\Console\Commands;


use Illuminate\Console\Command;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\File;


class GenerateTranslations extends Command
{
   protected $signature = 'translate:generate';
   protected $description = 'Autogenera archivos de traducción desde el inglés para todos los idiomas';


   public function handle()
   {
       $sourceLang = 'en'; // Idioma base (inglés)
       $targetLangs = ['es', 'fr', 'de', 'it', 'ru', 'zh', 'ar']; // Idiomas destino
       $sourcePath = resource_path("lang/{$sourceLang}"); // Ruta de archivos base


       if (!is_dir($sourcePath)) {
           $this->error("❌ No se encontró la carpeta: $sourcePath");
           return;
       }


       $tr = new GoogleTranslate();
       $tr->setSource($sourceLang);
      
       // Buscar todos los archivos PHP dentro de la carpeta en inglés
       $files = File::files($sourcePath);


       foreach ($files as $file) {
           $filename = $file->getFilename();
           $this->info("📂 Procesando archivo: $filename");


           // Leer el archivo en inglés
           $originalTexts = require $file->getRealPath();


           foreach ($targetLangs as $lang) {
               $tr->setTarget($lang);
               $langPath = resource_path("lang/{$lang}");
               $targetFilePath = "{$langPath}/{$filename}";


               // Crear carpeta del idioma si no existe
               if (!is_dir($langPath)) {
                   mkdir($langPath, 0777, true);
               }


               // Leer el archivo destino si ya existe
               $existingTranslations = [];
               if (file_exists($targetFilePath)) {
                   $existingTranslations = require $targetFilePath;
               }


               // Traducir solo las claves que aún no existen
               $translated = $existingTranslations;
               $newTranslations = 0;


               foreach ($originalTexts as $key => $text) {
                   if (!isset($existingTranslations[$key])) {
                       $translated[$key] = is_string($text) ? $tr->translate($text) : $text;
                       $this->info("[$lang] Traducido: $text → {$translated[$key]}");
                       $newTranslations++;
                   }
               }


               // Guardar solo si hay nuevas traducciones
               if ($newTranslations > 0) {
                   file_put_contents(
                       $targetFilePath,
                       "<?php\n\nreturn " . var_export($translated, true) . ";\n"
                   );
                   $this->info("✅ Archivo actualizado: lang/{$lang}/{$filename}");
               } else {
                   $this->info("⏩ No hay nuevas traducciones para $lang/$filename");
               }
           }
       }


       $this->info('🎉 Traducciones generadas solo para claves nuevas.');
   }
}
