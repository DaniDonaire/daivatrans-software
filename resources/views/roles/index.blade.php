@extends('layouts.master')
@section('title')
    @lang('roles.title')
@endsection
@section('css')
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('roles.breadcrumb')
        @endslot
        @slot('title')
            @lang('roles.list')
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header bg-light border-bottom">
                    <h4 class="card-title mb-0 text-primary">@lang('roles.title')</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="listjs-table" id="customerList">
                        <div class="row g-3 mb-4 align-items-center">
                            <!-- Botón Añadir Rol -->
                            <div class="col-12 col-md-auto">
                                @can('roles_create')
                                    <a href="{{ route('roles.create') }}">
                                        <button type="button" class="btn btn-primary w-100 w-md-auto">
                                            <i class="ri-add-line align-bottom me-1"></i> @lang('roles.add_role')
                                        </button>
                                    </a>
                                @endcan
                            </div>

                            <!-- Formulario de Filtros -->
                            <div class="col-12 col-md d-flex justify-content-end">
                                <form method="GET" action="{{ route('roles.index') }}" class="row g-2 align-items-center justify-content-end w-100">
                                    <!-- Selector de registros por página -->
                                    <div class="col-12 col-sm-auto">
                                        <select class="form-select bg-light border-primary" name="perPage" id="perPage">
                                            <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10 @lang('roles.records_per_page')</option>
                                            <option value="20" {{ request('perPage') == 20 ? 'selected' : '' }}>20 @lang('roles.records_per_page')</option>
                                            <option value="30" {{ request('perPage') == 30 ? 'selected' : '' }}>30 @lang('roles.records_per_page')</option>
                                            <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50 @lang('roles.records_per_page')</option>
                                        </select>
                                    </div>

                                    <!-- Campo de búsqueda -->
                                    <div class="col-12 col-sm" style="min-width: 200px; max-width: 350px;">
                                        <input 
                                            type="text" 
                                            id="search" 
                                            name="search" 
                                            class="form-control search bg-light border-primary" 
                                            placeholder="@lang('roles.search_placeholder')" 
                                            value="{{ request('search') }}"
                                            style="font-size: 0.9rem;"
                                        >
                                    </div>

                                    <!-- Botón Buscar -->
                                    <div class="col-12 col-sm-auto">
                                        <button type="submit" class="btn btn-primary w-100 w-sm-auto">
                                            <i class="ri-search-line"></i>
                                        </button>
                                    </div>

                                    <!-- Botón Limpiar -->
                                    <div class="col-12 col-sm-auto">
                                        <a href="{{ route('roles.index') }}" class="btn btn-secondary w-100 w-sm-auto">
                                            <i class="ri-delete-back-2-fill"></i>
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle table-borderless">
                                <thead class="table-primary">
                                    <tr>
                                        <th>@lang('roles.id')</th>
                                        <th>@lang('roles.name')</th>
                                        <th class="text-end pe-3">@lang('roles.actions')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $role)
                                        <tr>
                                            <td class="text-muted">{{ $role->id }}</td>
                                            <td>{{ $role->name }}</td>
                                            <td class="text-end pe-3">
                                                <div class="d-inline-flex gap-2 justify-content-end">
                                                    @can('roles_edit')
                                                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-success">@lang('roles.edit')</a>
                                                    @endcan
                                                    @can('roles_destroy')
                                                        <form id="deleteForm{{ $role->id }}" action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                        <button onclick="confirmDelete({{ $role->id }})" class="btn btn-sm btn-danger">@lang('roles.delete')</button>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <div class="noresult text-center py-4" style="display: none">
                            <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
                            <h5 class="mt-3">@lang('roles.no_results')</h5>
                            <p class="text-muted">@lang('roles.try_searching')</p>
                        </div>

                        <div class="d-flex justify-content-center mt-3">
                            <nav aria-label="Pagination">
                                {{ $roles->appends(request()->query())->links('pagination::bootstrap-4') }}
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        // Obtener el elemento del campo de búsqueda
        var searchElement = document.getElementById('search');
        
        if (searchElement) {  // Verificar si el campo existe
            searchElement.addEventListener('input', function () {
                // Obtener el formulario al que pertenece el campo
                var form = this.form;
                
                // Crear un temporizador para evitar enviar demasiadas solicitudes
                clearTimeout(this.searchTimeout);
                this.searchTimeout = setTimeout(function () {
                    form.submit(); // Enviar el formulario
                }, 1000); // Retraso de 1000 ms para evitar demasiadas solicitudes
            });
        }

        // Manejar el cambio en el selector de registros por página
        var perPageElement = document.getElementById('perPage');
        if (perPageElement) {
            perPageElement.addEventListener('change', function () {
                this.form.submit(); // Enviar el formulario
            });
        }
    });
    </script>

    <script>
        function confirmDelete(roleId) {
            Swal.fire({
                title: '@lang('roles.confirm_delete_title')',
                text: '@lang('roles.confirm_delete_text')',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '@lang('roles.confirm_delete_yes')',
                cancelButtonText: '@lang('roles.confirm_delete_cancel')'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm' + roleId).submit();
                }
            });
        }
    </script>

    <script>
        @if (session('sweetalert'))
            Swal.fire({
                title: "{{ session('sweetalert.title') }}",
                text: "{{ session('sweetalert.text') }}",
                icon: "{{ session('sweetalert.type') }}",
                confirmButtonText: '@lang('roles.accept')',
            });
        @endif
    </script>

    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
