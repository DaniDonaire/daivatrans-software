<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Worker;
//use App\Models\Direccion;
//use App\Http\Requests\StoreUpdateTrabajadorRequest;

class WorkerController extends Controller
{
    public function index(Request $request)
{
    $perPage = $request->input('perPage', 10);
    $search = $request->input('search');

    $query = Worker::query();

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('surname', 'like', "%{$search}%")
              ->orWhere('dni', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }

    $trabajadores = $query->paginate($perPage);

    return view('workers.index', compact('trabajadores'));
}

    public function create()
    {
        return view('workers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:2|max:255',
            'surname' => 'required|min:2|max:255',
            'dni' => 'required|unique:workers,dni|min:9|max:9',
            'telefono' => 'nullable|min:9|max:15',
            'email' => 'nullable|email|unique:workers,email|max:255',
            'seguridad_social' => 'required|unique:workers,seguridad_social|min:12|max:12',
            'cuenta_bancaria' => 'nullable|min:20|max:34', // Para IBAN
            'observaciones' => 'nullable|max:1000',
        ]);

        Worker::create($validated);

        return redirect()->route('workers.index')
            ->with('sweetalert', [
                'title' => __('workers.created'),
                'text' => '',
                'type' => 'success'
            ]);
    }

    public function show(Worker $trabajador)
    {
        return view('workers.show', compact('trabajador'));
    }

    public function edit(Worker $trabajador)
    {
        return view('workers.edit', compact('trabajador'));
    }

   public function update(Request $request, Worker $trabajador)
    {
        $data = $request->validate([
            'name'              => ['required','string','max:120'],
            'surname'           => ['required','string','max:150'],
            'dni'               => ['required','string','max:20','unique:workers,dni,'.$trabajador->id],
            'telefono'          => ['nullable','string','max:30'],
            'email'             => ['nullable','email','max:255','unique:workers,email,'.$trabajador->id],
            'seguridad_social'  => ['required','string','max:30','unique:workers,seguridad_social,'.$trabajador->id],
            'cuenta_bancaria'   => ['required','string','max:34'],
            'observaciones'     => ['nullable','string'],
        ]);

        $trabajador->update($data);

        return redirect()->route('workers.show', $trabajador)->with('ok','Trabajador actualizado.');
    }

    public function destroy(Worker $trabajador)
    {
        $trabajador->delete();

        return redirect()->route('workers.index')->with('ok', 'Trabajador eliminado.');
    }

}
