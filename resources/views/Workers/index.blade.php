{{-- resources/views/trabajadores/index.blade.php --}}
@extends('layouts.master')

@section('title', 'Trabajadores')

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Trabajadores @endslot
        @slot('title') Lista de Trabajadores @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header bg-light border-bottom">
                    <h4 class="card-title mb-0 text-primary">Trabajadores</h4>
                </div>

                <div class="card-body">
                    @if($trabajadores->isEmpty())
                        <p class="text-muted mb-0">No hay trabajadores.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-primary">
                                    <tr>
                                        <th>Apellidos</th>
                                        <th>Nombre</th>
                                        <th>DNI</th>
                                        <th>Teléfono</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($trabajadores as $t)
                                        <tr>
                                            <td>{{ $t->surname }}</td>
                                            <td>{{ $t->name }}</td>
                                            <td>{{ $t->dni }}</td>
                                            <td>{{ $t->telefono ?? '—' }}</td>
                                            <td>{{ $t->email ?? '—' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div>
    </div>
@endsection
