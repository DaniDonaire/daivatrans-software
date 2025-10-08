<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Worker;

class WorkerController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->input('perPage', 10);
        $search  = $request->input('search');

        $query = Worker::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('surname', 'like', "%{$search}%")
                  ->orWhere('dni', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $trabajadores = $query->orderBy('surname')->orderBy('name')->paginate($perPage);

        return view('workers.index', compact('trabajadores'));
    }

    public function create()
    {
        return view('workers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            /*'name'              => 'required|string|min:2|max:255',
            'surname'           => 'required|string|min:2|max:255',
            'dni'               => 'required|string|size:9|unique:workers,dni',
            'telefono'          => 'nullable|string|min:9|max:15',*/
            'email'             => 'required|email|max:255|unique:workers,email',
            /*'seguridad_social'  => 'required|string|size:12|unique:workers,seguridad_social',
            'cuenta_bancaria'   => 'nullable|string|min:20|max:34', // IBAN opcional
            'observaciones'     => 'nullable|string|max:1000',*/
        ],
        [
            /*'dni.size'                 => 'El DNI debe tener :size caracteres.',
            'dni.required'              => 'El DNI es obligatorio.',
            'seguridad_social.size'    => 'El Nº de Seguridad Social debe tener :size dígitos.',
            'telefono.min'             => 'El teléfono debe tener al menos :min caracteres.',
            'telefono.max'             => 'El teléfono no puede superar :max caracteres.',
            'cuenta_bancaria.min'      => 'El IBAN debe tener al menos :min caracteres.',
            'cuenta_bancaria.max'      => 'El IBAN no puede superar :max caracteres.',*/
            'email.email'              => 'Introduce un correo válido.',
            'email.required'           => 'El correo es obligatorio.',
            'email.unique'             => 'Este correo ya está registrado.',
            /*'dni.unique'               => 'Este DNI ya existe.',
            'seguridad_social.unique'  => 'Ese Nº de Seguridad Social ya existe.',
            'seguridad_social.required' => 'El Nº de Seguridad Social es obligatorio.',
            'name.required'            => 'El nombre es obligatorio.',
            'surname.required'         => 'Los apellidos son obligatorios.',*/
        ]);

        Worker::create($data);

        return redirect()->route('workers.index')->with('ok', __('workers.created'));
    }

    public function show(Worker $worker)
    {
        return view('workers.show', compact('worker'));
    }

    public function edit(Worker $worker)
    {
        return view('workers.edit', compact('worker'));
    }

    public function update(Request $request, Worker $worker)
    {
        $data = $request->validate(
        [
            'name'              => 'required|string|max:255',
            'surname'           => 'required|string|max:255',
            'dni'               => 'required|string|size:9|unique:workers,dni,' . $worker->id,
            'telefono'          => 'nullable|string|min:9|max:15',
            'email'             => 'required|email|max:255|unique:workers,email,' . $worker->id,
            'seguridad_social'  => 'required|string|size:12|unique:workers,seguridad_social,' . $worker->id,
            'cuenta_bancaria'   => 'nullable|string|min:20|max:34', // igual que en store
            'observaciones'     => 'nullable|string|max:1000',
        ],
        [
            'dni.size'                 => 'El DNI debe tener :size caracteres.',
            'dni.required'              => 'El DNI es obligatorio.',
            'seguridad_social.size'    => 'El Nº de Seguridad Social debe tener :size dígitos.',
            'seguridad_social.required' => 'El Nº de Seguridad Social es obligatorio.',
            'telefono.min'             => 'El teléfono debe tener al menos :min caracteres.',
            'telefono.max'             => 'El teléfono no puede superar :max caracteres.',
            'cuenta_bancaria.min'      => 'El IBAN debe tener al menos :min caracteres.',
            'cuenta_bancaria.max'      => 'El IBAN no puede superar :max caracteres.',
            'email.email'              => 'Introduce un correo válido.',
            'email.required'           => 'El correo es obligatorio.',
            'email.unique'             => 'Este correo ya está registrado.',
            'dni.unique'               => 'Este DNI ya existe.',
            'seguridad_social.unique'  => 'Ese Nº de Seguridad Social ya existe.',
            'name.required'            => 'El nombre es obligatorio.',
            'surname.required'         => 'Los apellidos son obligatorios.',
        ]
    );

        $worker->update($data);

        return redirect()->route('workers.index', ['worker' => $worker])->with('ok', __('workers.updated'));
    }

    public function destroy(Worker $worker)
    {
        $worker->delete();
        return redirect()->route('workers.index')->with('ok', __('workers.deleted'));
    }
}
