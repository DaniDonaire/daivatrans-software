@extends('layouts.master')

@section('title', 'Estatus ')

@section('content')
<div class="row g-4 mb-4">
    <div class="flex-grow-1">
        <a href="{{ route('status.create') }}" class="btn btn-success"><i class="ri-add-line align-bottom me-1"></i> Crear Estatus</a>        
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Estatus</h5>
            </div>
            <div class="card-body">
                <!-- <form method="GET" action="{{ route('status.index') }}">
                    <div class="row g-3">
                        <div class="col-xxl-12 col-sm-12">
                            <div class="search-box">
                                <input type="text" name="search" class="form-control search bg-light border-light" placeholder="Buscar por nombre" value="{{ request('search') }}">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
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
                </form> -->
                
                <div class="table-responsive mt-4">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Acciones</th>
                                <th>Nombre</th>
                                <th>Color</th>
                                <th>Color Texto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($status as $stat)
                                <tr>
                                    <td class="text-nowrap">
                                        <a href="{{ route('status.edit', $stat->id) }}" class="btn btn-primary btn-sm">
                                            <i class="ri-edit-line"></i>
                                        </a>

                                        <form action="{{ route('status.destroy', $stat->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro?')">
                                                <i class="ri-delete-bin-line"></i>

                                            </button>
                                        </form>
                                    </td>
                                    <td>{{ $stat->name }}</td>
                                    <td>{{ $stat->color }}</td>
                                    <td>{{ $stat->text_color }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection