@extends('layouts.master')
@section('title', __('Acceso denegado'))

@section('content')
<div class="d-flex justify-content-center align-items-center text-center">
    <div class="text-center">
        <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" 
                   colors="primary:#f5222d,secondary:#ffc107" 
                   style="width:120px;height:120px">
        </lord-icon>
        <h1 class="mt-4 text-danger fw-bold">Acceso denegado</h1>
        <p class="text-muted fs-5">No tienes permisos para acceder a esta página.</p>
        <a href="/" class="btn btn-outline-danger mt-3">
            <i class="ri-arrow-left-line align-middle me-1"></i> Volver
        </a>
    </div>
</div>
@endsection
