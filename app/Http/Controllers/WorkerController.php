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
            'name'              => 'nullable|string',
            'surname'           => 'nullable|string',
            'dni'               => 'nullable|string|unique:workers,dni',
            'telefono'          => 'nullable|string',
            'email'             => 'required|email|max:255|unique:workers,email',
            'address.street' => 'nullable|string|max:255',
            'address.city' => 'nullable|string|max:255',
            'address.province' => 'nullable|string|max:255',
            'address.postal_code' => 'nullable|string|max:20',
            'address.country' => 'nullable|string|max:100',
        ],
        [
            'email.email'              => 'Introduce un correo válido.',
            'email.required'           => 'El correo es obligatorio.',
            'email.unique'             => 'Este correo ya está registrado.',
            'dni.unique'               => 'Este DNI ya existe.',
            'seguridad_social.unique'  => 'Ese Nº de Seguridad Social ya existe.',
            'name.required'            => 'El nombre es obligatorio.',
            'surname.required'         => 'Los apellidos son obligatorios.',
        ]);

        $worker = Worker::create($data);

        // Crear dirección si se introdujo algún dato
        if (!empty(array_filter($data['address'] ?? []))) {
            $worker->address()->create($data['address']);
        }

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

        //Actualizar observaciones con Ajax
        if($request->ajax()) {
            $data = $request->validate([
                'observaciones' => 'nullable|string|max:1000'
            ]);

            $worker->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Observaciones actualizadas correctamente'
            ]);
        }

        $data = $request->validate([
            'name'              => 'nullable|string',
            'surname'           => 'nullable|string',
            'dni'               => 'nullable|string|unique:workers,dni,' . $worker->id,
            'telefono'          => 'nullable|string',
            'email'             => 'required|email|max:255|unique:workers,email,' . $worker->id,
            'seguridad_social'  => 'nullable|string|unique:workers,seguridad_social,' . $worker->id,
            'cuenta_bancaria'   => 'nullable|string', // IBAN opcional
            'observaciones'     => 'nullable|string|max:1000',
            'address.street' => 'nullable|string|max:255',
            'address.city' => 'nullable|string|max:255',
            'address.province' => 'nullable|string|max:255',
            'address.postal_code' => 'nullable|string|max:20',
            'address.country' => 'nullable|string|max:100',
        ],
        [
            'email.email'              => 'Introduce un correo válido.',
            'email.required'           => 'El correo es obligatorio.',
            'email.unique'             => 'Este correo ya está registrado.',
            'dni.unique'               => 'Este DNI ya existe.',
            'seguridad_social.unique'  => 'Ese Nº de Seguridad Social ya existe.',
            'name.required'            => 'El nombre es obligatorio.',
            'surname.required'         => 'Los apellidos son obligatorios.',
        ]);

        $worker->update($data);

        $addressData = $data['address'] ?? [];

        if ($worker->address) {
            $worker->address->update($addressData);
        } else {
            $worker->address()->create($addressData);
        }
        

        return redirect()->route('workers.show', ['worker' => $worker])->with('ok', __('workers.updated'));
    }


    public function destroy(Worker $worker)
    {
        $worker->delete();
        return redirect()->route('workers.index')->with('ok', __('workers.deleted'));
    }
}
