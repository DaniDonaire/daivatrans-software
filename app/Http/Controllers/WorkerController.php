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
        return view('trabajadores.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:120'],
            'surname'=> ['required','string','max:150'],
            'dni'=> ['required','string','max:20','unique:workers,dni'],
            'telefono'=> ['nullable','string','max:30'],
            'email'=> ['nullable','email','max:255','unique:workers,email'],
            'seguridad_social'=> ['required','string','max:30','unique:workers,seguridad_social'],
            'cuenta_bancaria'=> ['required','string','max:34'],
            'observaciones'=> ['nullable','string'],
        ]);
        $worker = Worker::create($data);

        return redirect()->route('trabajadores.show', $worker)->with('ok', 'Trabajador creado.'); 
    }

    public function show(Worker $trabajador)
    {
        return view('trabajadores.show', compact('trabajador'));
    }

    public function edit(Worker $trabajador)
    {
        return view('trabajadores.edit', compact('trabajador'));
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

        return redirect()->route('trabajadores.show', $trabajador)->with('ok','Trabajador actualizado.');
    }

    public function destroy(Worker $trabajador)
    {
        $trabajador->delete();

        return redirect()->route('workers.index')->with('ok', 'Trabajador eliminado.');
    }

}
