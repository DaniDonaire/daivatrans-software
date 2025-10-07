{{-- resources/views/trabajadores/index.blade.php --}}
@extends('layouts.master')

@section('title')
    @lang('workers.title')
@endsection

@section('css')
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('workers.breadcrumb')
        @endslot
        @slot('title')
            @lang('workers.list')
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header bg-light border-bottom">
                    <h4 class="card-title mb-0 text-primary">@lang('workers.title')</h4>
                </div>

                <div class="card-body">
                    <div class="listjs-table" id="customerList">
                        <div class="row g-3 mb-4 align-items-center">
                            <!-- Botón Añadir Trabajador -->
                            <div class="col-12 col-md-auto">
                                @can('workers_create')
                                    <a href="{{ route('workers.create') }}">
                                        <button type="button" class="btn btn-primary w-100 w-md-auto">
                                            <i class="ri-add-line align-bottom me-1"></i> @lang('workers.add_worker')
                                        </button>
                                    </a>
                                @endcan
                            </div>

                            <!-- Formulario de Filtros -->
                            <div class="col-12 col-md d-flex justify-content-end">
                                <form method="GET" action="{{ route('workers.index') }}" class="row g-2 align-items-center justify-content-end w-100">
                                    <!-- Selector de registros por página -->
                                    <div class="col-12 col-sm-auto">
                                        <select class="form-select bg-light border-primary" name="perPage" id="perPage">
                                            <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10 @lang('workers.records_per_page')</option>
                                            <option value="20" {{ request('perPage') == 20 ? 'selected' : '' }}>20 @lang('workers.records_per_page')</option>
                                            <option value="30" {{ request('perPage') == 30 ? 'selected' : '' }}>30 @lang('workers.records_per_page')</option>
                                            <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50 @lang('workers.records_per_page')</option>
                                        </select>
                                    </div>

                                    <!-- Campo de búsqueda -->
                                    <div class="col-12 col-sm" style="min-width: 200px; max-width: 350px;">
                                        <input 
                                            type="text" 
                                            id="search" 
                                            name="search" 
                                            class="form-control search bg-light border-primary" 
                                            placeholder="@lang('workers.search_placeholder')" 
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
                                        <a href="{{ route('workers.index') }}" class="btn btn-secondary w-100 w-sm-auto">
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
                                        <th>@lang('workers.surname')</th>
                                        <th>@lang('workers.name')</th>
                                        <th>@lang('workers.dni')</th>
                                        <th>@lang('workers.phone')</th>
                                        <th>@lang('workers.email')</th>
                                        <th class="text-end pe-3">@lang('workers.actions')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($trabajadores as $trabajador)
                                        <tr>
                                            <td>{{ $trabajador->surname }}</td>
                                            <td>{{ $trabajador->name }}</td>
                                            <td>{{ $trabajador->dni }}</td>
                                            <td>{{ $trabajador->telefono ?? '—' }}</td>
                                            <td>{{ $trabajador->email ?? '—' }}</td>
                                            <td class="text-end pe-3">
                                                <div class="d-inline-flex gap-2 justify-content-end">
                                                    @can('workers_edit')
                                                        <a href="{{ route('workers.edit', $trabajador->id) }}" class="btn btn-sm btn-success">@lang('workers.edit')</a>
                                                    @endcan
                                                    @can('workers_destroy')
                                                        <form id="deleteForm{{ $trabajador->id }}" action="{{ route('workers.destroy', $trabajador->id) }}" method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                        <button onclick="confirmDelete({{ $trabajador->id }})" class="btn btn-sm btn-danger">@lang('workers.delete')</button>
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
                            <h5 class="mt-3">@lang('workers.no_results')</h5>
                            <p class="text-muted">@lang('workers.try_searching')</p>
                        </div>

                        <div class="d-flex justify-content-center mt-3">
                            <nav aria-label="Pagination">
                                {{ $trabajadores->appends(request()->query())->links('pagination::bootstrap-4') }}
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
            var searchElement = document.getElementById('search');
            
            if (searchElement) {
                searchElement.addEventListener('input', function () {
                    var form = this.form;
                    clearTimeout(this.searchTimeout);
                    this.searchTimeout = setTimeout(function () {
                        form.submit();
                    }, 1000);
                });
            }

            var perPageElement = document.getElementById('perPage');
            if (perPageElement) {
                perPageElement.addEventListener('change', function () {
                    this.form.submit();
                });
            }
        });
    </script>

    <script>
        function confirmDelete(workerId) {
            Swal.fire({
                title: '@lang('workers.confirm_delete_title')',
                text: '@lang('workers.confirm_delete_text')',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '@lang('workers.confirm_delete_yes')',
                cancelButtonText: '@lang('workers.confirm_delete_cancel')'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm' + workerId).submit();
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
                confirmButtonText: '@lang('workers.accept')',
            });
        @endif
    </script>

    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
