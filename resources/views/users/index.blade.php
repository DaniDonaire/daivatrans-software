@extends('layouts.master')
@section('title')
    @lang('users.title')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('users.breadcrumb')
        @endslot
        @slot('title')
            @lang('users.title')
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header bg-light border-bottom">
                    <h4 class="card-title mb-0 text-primary">@lang('users.title')</h4>
                </div>

                <div class="card-body">
                    <div class="listjs-table" id="customerList">
                        <div class="row g-3 mb-4 align-items-center">
                            <!-- Botón Añadir Usuario -->
                            <div class="col-12 col-md-auto">
                                @can('users_create')
                                    <a href="{{ route('users.create') }}">
                                        <button type="button" class="btn btn-primary w-100 w-md-auto">
                                            <i class="ri-add-line align-bottom me-1"></i> @lang('users.add_user')
                                        </button>
                                    </a>
                                @endcan
                            </div>

                            <!-- Formulario de Filtros -->
                            <div class="col-12 col-md d-flex justify-content-end">
                                <form method="GET" action="{{ route('users.index') }}" class="row g-2 align-items-center justify-content-end w-100">
                                    <!-- Selector de registros por página -->
                                    <div class="col-12 col-sm-auto">
                                        <select class="form-select bg-light border-primary" name="perPage" id="perPage">
                                            <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10 @lang('users.records_per_page')</option>
                                            <option value="20" {{ request('perPage') == 20 ? 'selected' : '' }}>20 @lang('users.records_per_page')</option>
                                            <option value="30" {{ request('perPage') == 30 ? 'selected' : '' }}>30 @lang('users.records_per_page')</option>
                                            <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50 @lang('users.records_per_page')</option>
                                        </select>
                                    </div>

                                    <!-- Campo de búsqueda -->
                                    <div class="col-12 col-sm" style="min-width: 200px; max-width: 350px;">
                                        <input 
                                            type="text" 
                                            id="search" 
                                            name="search" 
                                            class="form-control search bg-light border-primary" 
                                            placeholder="@lang('users.search_placeholder')" 
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
                                        <a href="{{ route('users.index') }}" class="btn btn-secondary w-100 w-sm-auto">
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
                                        <th>@lang('users.id')</th>
                                        <th>@lang('users.name')</th>
                                        <th>@lang('users.email')</th>
                                        <th>@lang('users.role')</th>
                                        <th class="text-end pe-3">@lang('users.actions')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td class="text-muted">{{ $user->id }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @foreach($user->getRoleNames() as $role)
                                                    <span class="badge bg-secondary">{{ $role }}</span>
                                                @endforeach
                                            </td>
                                            <td class="text-end pe-3">
                                                <div class="d-inline-flex gap-2 justify-content-end">
                                                    @if(Auth::id() == $user->id && Auth::user()->can('users_edit_own'))
                                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">@lang('users.edit_own_profile')</a>
                                                    @elseif(Auth::user()->can('users_edit_all'))
                                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-success">@lang('users.edit')</a>
                                                    @endif

                                                    @if(Auth::user()->can('users_delete') && Auth::id() !== $user->id)
                                                        <form id="deleteForm{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                        <button onclick="confirmDelete({{ $user->id }})" class="btn btn-sm btn-danger">@lang('users.delete')</button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="noresult text-center py-4" style="display: none">
                            <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
                            <h5 class="mt-3">@lang('users.no_results')</h5>
                            <p class="text-muted">@lang('users.try_searching')</p>
                        </div>

                        <div class="d-flex justify-content-center mt-3">
                            <nav aria-label="Pagination">
                                {{ $users->appends(request()->query())->links() }}
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Manejar el cambio en el selector de registros por página
            var perPageElement = document.getElementById('perPage');
            if (perPageElement) {
                perPageElement.addEventListener('change', function () {
                    this.form.submit();
                });
            }
        });

        function confirmDelete(activeId) {
            Swal.fire({
                title: '@lang('users.confirm_delete_title')',
                text: '@lang('users.confirm_delete_text')',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '@lang('users.confirm_delete_yes')',
                cancelButtonText: '@lang('users.confirm_delete_cancel')'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm' + activeId).submit();
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
                confirmButtonText: '@lang('users.accept')',
            });
        @endif
    </script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
