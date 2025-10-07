@extends('layouts.master')

@section('title', 'Métodos de Contacto')

@section('content')
<div class="row g-4 mb-4">
    <div class="flex-grow-1">
        <a href="{{ route('contact-methods.create') }}" class="btn btn-success"><i class="ri-add-line align-bottom me-1"></i> Crear Método de Contacto</a>        
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Métodos de Contacto</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('contact-methods.index') }}">
                    <div class="row g-3">
                        <!-- <div class="col-xxl-12 col-sm-12">
                            <div class="search-box">
                                <input type="text" name="search" class="form-control search bg-light border-light" placeholder="Buscar por nombre" value="{{ request('search') }}">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div> -->
                        <div class="col-xxl-2 col-sm-4">
                            <div class="input-light">

                                <select class="form-control" data-choices data-choices-search-false name="perPage" id="perPage" onchange="this.form.submit()">
                                    <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10 registros</option>
                                    <option value="20" {{ request('perPage') == 20 ? 'selected' : '' }}>20 registros</option>
                                    <option value="30" {{ request('perPage') == 30 ? 'selected' : '' }}>30 registros</option>
                                    <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50 registros</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
                
                <div class="table-responsive mt-4">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Acciones</th>
                                <th>Nombre</th>
                                <th>Fecha de Creación</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contactMethods as $contactMethod)
                                <tr>
                                    <td  class="text-nowrap">
                                        <a href="{{ route('contact-methods.edit', $contactMethod->id) }}" class="btn btn-primary btn-sm">
                                            <i class="ri-edit-line"></i>
                                        </a>
                                        <form action="{{ route('contact-methods.destroy', $contactMethod->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro?')">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td>{{ $contactMethod->name }}</td>
                                    <td>{{ $contactMethod->created_at->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {!! $contactMethods->links('vendor.pagination.bootstrap-4') !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

