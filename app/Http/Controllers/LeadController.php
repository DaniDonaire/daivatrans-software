<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Status;
use App\Models\User;
use App\Models\Service;
use App\Models\ContactMethod;
use App\Models\LeadNote;
use App\Exports\ClientesExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel; 
use App\Imports\LeadsImport;


class LeadController extends Controller
{
    /**
     * Display a listing of the leads.
     */
    public function index(Request $request)
{
    $query = Lead::query();

    // Apply search filter
    if ($request->has('search')) {
        $search = $request->input('search');
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('phone', 'like', "%{$search}%");
        });
    }

    // Apply status filter
    if ($request->has('status_id')) {
        $statusId = $request->input('status_id');
        if ($statusId) {
            $query->where('status_id', $statusId);
        }
    }

    // Apply service filter
    if ($request->has('service_id')) {
        $serviceId = $request->input('service_id');
        if ($serviceId) {
            $query->where('service_id', $serviceId);
        }
    }

    // Apply contact date filter
    if ($request->has('contact_date')) {
        $contactDate = $request->input('contact_date');
        if ($contactDate) {
            $query->whereDate('contact_date', $contactDate);
        }
    }

    // Apply pagination
    $perPage = $request->input('perPage', 10);
    $leads = $query->with('status', 'user')->orderBy('contact_date', 'DESC')->paginate($perPage);

    // Get all statuses for the filters
    $statuses = Status::all();
    $services = Service::all();

    if ($request->ajax()) {
        return view('leads.table', compact('leads', 'statuses'));
    }
    

    // Renderizamos la vista completa si no es AJAX
    return view('leads.index', compact('leads', 'statuses', 'services'));
}


    /**
     * Show the form for creating a new lead.
     */
    public function create()
    {

        $statuses = Status::all();
        $services = Service::all();  
        $contactMethods = ContactMethod::all();

        return view('leads.create', compact('statuses', 'services', 'contactMethods'));
    }

    /**
     * Store a newly created lead in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:leads,email',
            'phone' => 'nullable|string|max:20',
            'status_id' => 'nullable|exists:status,id',
            'service_id' => 'nullable|exists:services,id',
            'contact_method_id' => 'nullable|exists:contact_methods,id',
            'contact_date' => 'nullable|date',
            'documents_link' => 'nullable|url',
            'mortgage_amount' => 'nullable|numeric',
            'purchase_amount' => 'nullable|numeric',
            'signing_date' => 'nullable|date',
            'category' => 'nullable',
        ]);

        Lead::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'status_id' => $request->input('status_id'),
            'service_id' => $request->input('service_id'),
            'contact_method_id' => $request->input('contact_method_id'),
            'contact_date' => $request->input('contact_date'),
            'documents_link' => $request->input('documents_link'),
            'mortgage_amount' => $request->input('mortgage_amount'),
            'purchase_amount' => $request->input('purchase_amount'),
            'signing_date' => $request->input('signing_date'),
            'category' => $request->input('category'),
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('leads.index')->with('success', 'Lead creado con éxito.');

    }

    /**
     * Show the form for editing the specified lead.
     */
    public function edit($id)
    {
        $lead = Lead::findOrFail($id);
        $statuses = Status::all(); 
        $users = User::all(); 
        $services = Service::all();
        $contactMethods = ContactMethod::all();


        return view('leads.edit', compact('lead', 'statuses', 'services', 'contactMethods'));
    }

    /**
     * Update the specified lead in storage.
     */
    public function update(Request $request, Lead $lead)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:leads,email,' . $lead->id,
            'phone' => 'nullable|string|max:20',
            'status_id' => 'nullable|exists:status,id',
            'service_id' => 'nullable|exists:services,id',
            'contact_method_id' => 'nullable|exists:contact_methods,id',
            'contact_date' => 'nullable|date',
            'documents_link' => 'nullable|url',
            'mortgage_amount' => 'nullable|numeric',
            'purchase_amount' => 'nullable|numeric',
            'signing_date' => 'nullable|date',
            'category' => 'nullable',
        ]);

        $lead->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'status_id' => $request->input('status_id'),
            'service_id' => $request->input('service_id'),
            'contact_method_id' => $request->input('contact_method_id'),
            'contact_date' => $request->input('contact_date'),
            'documents_link' => $request->input('documents_link'),
            'mortgage_amount' => $request->input('mortgage_amount'),
            'purchase_amount' => $request->input('purchase_amount'),
            'signing_date' => $request->input('signing_date'),
            'category' => $request->input('category'),
        ]);

        return redirect()->route('leads.index')->with('success', 'Lead actualizado con éxito.');
    }

    /**
     * Remove the specified lead from storage.
     */
    public function destroy(Lead $lead)
    {
        $lead->delete();
        return redirect()->route('leads.index')->with('success', 'Lead eliminado con éxito.');
    }

    public function show($id)
    {
        $lead = Lead::with(['status','service','contactMethod','notes'])->findOrFail($id);
        return view('leads.show', compact('lead'));
    }

    public function storeNote(Request $request, $id)
    {
        $request->validate([
            'note' => 'required|string',
            'reminder' => 'nullable|date',
        ]);

        $lead = Lead::findOrFail($id);
        $lead->notes()->create([
            'note' => $request->input('note'),
            'reminder' => $request->input('reminder'),
        ]);

        //Redirige a la vista correcta, respetando el flujo del usuario
        $redirectTo = $request->input('redirect_to', 'show');

        if ($redirectTo === 'edit') {
            return redirect()
                ->route('leads.edit', $id)
                ->with('success', 'Nota añadida con éxito');
        }

        return redirect()->route('leads.show', $id)
            ->with('active_tab', 'notes')
            ->with('success', 'Nota añadida con éxito');
            
    }

    public function updateNote(Request $request, $id, $noteId)
    {
        $request->validate([
            'note' => 'required|string',
            'reminder' => 'nullable|date',
        ]);

        $note = LeadNote::findOrFail($noteId);
        $note->update([
            'note' => $request->input('note'),
            'reminder' => $request->input('reminder'),
        ]);

        $redirectTo = $request->input('redirect_to', 'show');

        if ($redirectTo === 'edit') {
            return redirect()
                ->route('leads.edit', $id)
                ->with('success','Nota actualizada con éxito');
        }

        return redirect()->route('leads.show', $id)
            ->with('active_tab', 'notes')
            ->with('success', 'Nota actualizada con éxito');
    }

    public function destroyNote(Request $request, $id, $noteId)
    {
        $note = LeadNote::findOrFail($noteId);
        $note->delete();

        $redirectTo = $request->input('redirect_to', 'show');

        if ($redirectTo === 'edit') {
            return redirect()
                ->route('leads.edit', $id)
                ->with('success', 'Nota eliminada con éxito');
        }

        return redirect()->route('leads.show', $id)
            ->with('active_tab', 'notes')
            ->with('success', 'Nota eliminada con éxito');
    }


    /**
     * Update only the status of a lead (AJAX-friendly).
     */
    public function updateStatus(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'status_id' => 'required|exists:status,id',
        ]);

        $lead->update(['status_id' => $validated['status_id']]);

        // Return minimal data for UI updates (new status colors and name)
        $status = Status::find($validated['status_id']);

        return response()->json([
            'success' => true,
            'status' => [
                'id' => $status->id,
                'name' => $status->name,
                'color' => $status->color,
                'text_color' => $status->text_color,
            ],
        ]);
    }

    // Método para exportar los clientes de Webcoding
    public function exportWebcoding()
    {
        return Excel::download(new ClientesExport(['Webcoding']), 'clientes_webcoding.xlsx');
    }

    // Método para exportar todos los leads
    public function exportAll()
    {
        return Excel::download(new ClientesExport(), 'clientes_todos.xlsx');
    }

    public function importLeads(Request $request)
    {
        \Log::info('Método importLeads invocado.');

        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        if ($request->hasFile('file')) {
            \Log::info('Archivo recibido: ' . $request->file('file')->getClientOriginalName());

            try {
                // Contar leads antes de la importación
                $leadsBefore = Lead::count();
                
                Excel::import(new LeadsImport, $request->file('file'));
                
                // Contar leads después de la importación
                $leadsAfter = Lead::count();
                $importedCount = $leadsAfter - $leadsBefore;
                
                \Log::info('Proceso de importación completado. Leads importados: ' . $importedCount);
                
                if ($importedCount > 0) {
                    return redirect()->route('leads.index')->with('success', 'Se importaron ' . $importedCount . ' leads con éxito.');
                } else {
                    return redirect()->route('leads.index')->with('error', 'No se importaron nuevos leads. Verifique que el archivo contenga datos válidos y que no haya emails duplicados.');
                }
            } catch (\Exception $e) {
                \Log::error('Error al importar leads: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Error al importar los leads: ' . $e->getMessage());
            }

        } else {
            \Log::error('No se recibió ningún archivo.');
            return redirect()->back()->with('error', 'No se recibió ningún archivo.');
        }
    }




    
}