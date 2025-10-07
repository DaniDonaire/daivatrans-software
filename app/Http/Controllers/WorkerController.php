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
        $q = trim($request->get('q', ''));

       
        $trabajadores = Worker::query()
            ->when($q, function ($query) use ($q) {
                $query->where(function ($w) use ($q) {
                    $w->where('nombre', 'like', "%{$q}%")
                      ->orWhere('apellidos', 'like', "%{$q}%")
                      ->orWhere('dni_nie', 'like', "%{$q}%");
                });
            })
            ->with('direccion')                  
            ->orderBy('apellidos')               
            ->orderBy('nombre')
            ->paginate(15)                       
            ->withQueryString();                 

        return view('trabajadores.index', compact('trabajadores', 'q'));
    }
}
