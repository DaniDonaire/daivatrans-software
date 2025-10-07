<?php
namespace App\Exports;

use App\Models\Lead;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClientesExport implements FromCollection, WithHeadings
{
    protected $empresas;

    // Constructor para recibir múltiples empresas o exportar todo
    public function __construct($empresas = [])
    {
        $this->empresas = $empresas;
    }

    // Recuperamos los datos a exportar
    public function collection()
{
    $query = Lead::with(['company', 'status', 'user', 'contactMethod', 'service']);

    if (!empty($this->empresas)) {
        // Filtramos por las empresas específicas
        $query->whereHas('company', function ($subQuery) {
            $subQuery->whereIn('name', $this->empresas);
        });
    }

    return $query->get()->map(function ($lead) {
        return [
            'name' => $lead->name,
            'email' => $lead->email,
            'phone' => $lead->phone,
            'contact_date' => $lead->contact_date,
            'mortgage_amount' => $lead->mortgage_amount,
            'purchase_amount' => $lead->purchase_amount,
            'signing_date' => $lead->signing_date,
            'documents_link' => $lead->documents_link,
            'category' => $lead->category,
            'status' => $lead->status?->name ?? 'Sin estado',
            'user' => $lead->user?->name ?? 'Sin usuario',
            'company' => $lead->company?->name ?? 'Sin empresa', // Este debe cargar correctamente
            'contact_method_id' => $lead->contactMethod?->name ?? 'Sin método de contacto',
            'service_id' => $lead->service?->name ?? 'Sin servicio',
            'created_at' => $lead->created_at,
        ];
    });
}

    // Definimos las cabeceras para el archivo Excel
    public function headings(): array
    {
        return [
            'Nombre', 
            'Email', 
            'Teléfono', 
            'Fecha de Contacto', 
            'Monto de la Hipoteca', 
            'Monto de Compra', 
            'Fecha de Firma', 
            'Enlace de Documentos', 
            'Categoría',
            'Estado', 
            'Usuario', 
            'Empresa', 
            'Método de Contacto', 
            'Servicio', 
            'Fecha de Creación'
        ];
    }
}
