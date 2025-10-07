<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EjemploController extends Controller
{
    // Aqui va el nombre del permiso y que acceso tiene este permiso
    // Ejemplo de uso: el usuario que tenga permiso de ejemplo.index, podrá acceder a la función index del controlador
    public function __construct()
    {
        $this->middleware(['auth:web', 'permission:ejemplo_list'])->only(['index']);
        $this->middleware(['auth:web', 'permission:ejemplo_create'])->only(['create', 'store']);
        $this->middleware(['auth:web', 'permission:ejemplo_edit'])->only(['edit', 'update']);
        $this->middleware(['auth:web', 'permission:ejemplo_show'])->only('show');
        $this->middleware(['auth:web', 'permission:ejemplo_destroy'])->only('destroy');
    }

    public function index()
    {
        $ejemplos = Ejemplo::all();
        return view('ejemplos.index', compact('ejemplos'));
    }
}
