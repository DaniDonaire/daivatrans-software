@extends('layouts.master')

@section('title')
    @lang('auditoria.title')
@endsection

@section('css')
    <!-- Cargar Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Ajustar la apariencia del Select2 con icono */
        .select2-with-icon + .select2-container .select2-selection {
            background: url('https://cdn.jsdelivr.net/npm/remixicon@latest/icons/User/user-line.svg') no-repeat 10px center;
            background-size: 15px;
            padding-left: 35px !important;
            border: 1px solid #5EA3CB !important;
        }
    </style>
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') @lang('auditoria.breadcrumb') @endslot
        @slot('title') @lang('auditoria.audit_list') @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header bg-light border-bottom">
                    <h4 class="card-title mb-0 text-primary">@lang('auditoria.audit_list')</h4>
                </div>

                <div class="card-body">
                    <div class="listjs-table" id="auditList">
                        <div class="row g-3 mb-4 align-items-center">
                            <!-- Formulario de Filtros -->
                            <div class="col-12 d-flex justify-content-end">
                                <form method="GET" action="{{ route('audit.index') }}" class="row g-2 align-items-center justify-content-end w-100">
                                    <!-- Selector de registros por página -->
                                    <div class="col-12 col-sm-auto">
                                        <select class="form-select bg-light border-primary" name="perPage" id="perPage">
                                            <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10 @lang('auditoria.records_per_page')</option>
                                            <option value="20" {{ request('perPage') == 20 ? 'selected' : '' }}>20 @lang('auditoria.records_per_page')</option>
                                            <option value="30" {{ request('perPage') == 30 ? 'selected' : '' }}>30 @lang('auditoria.records_per_page')</option>
                                            <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50 @lang('auditoria.records_per_page')</option>
                                        </select>
                                    </div>

                                    <!-- Filtro por Usuario (Select2 con Búsqueda) -->
                                    <div class="col-12 col-sm-auto">
                                        <select name="user" id="user" class="form-select border-primary select2">
                                            <option value="" disabled selected>Selecciona un usuario</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}" {{ request('user') == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Filtro por Acción -->
                                    <div class="col-12 col-sm-auto">
                                        <select name="action" id="action" class="form-select bg-light border-primary">
                                            <option value="">@lang('auditoria.all')</option>
                                            <option value="created" {{ request('action') == 'created' ? 'selected' : '' }}>@lang('auditoria.created')</option>
                                            <option value="updated" {{ request('action') == 'updated' ? 'selected' : '' }}>@lang('auditoria.updated')</option>
                                            <option value="deleted" {{ request('action') == 'deleted' ? 'selected' : '' }}>@lang('auditoria.deleted')</option>
                                        </select>
                                    </div>

                                    <!-- Filtro por Fecha -->
                                    <div class="col-12 col-sm-auto">
                                        <input type="date" name="date" class="form-control bg-light border-primary" value="{{ request('date') }}">
                                    </div>

                                    <!-- Botón Buscar -->
                                    <div class="col-12 col-sm-auto">
                                        <button type="submit" class="btn btn-primary w-100 w-sm-auto">
                                            <i class="ri-search-line"></i>
                                        </button>
                                    </div>

                                    <!-- Botón Limpiar -->
                                    <div class="col-12 col-sm-auto">
                                        <a href="{{ route('audit.index') }}" class="btn btn-secondary w-100 w-sm-auto">
                                            <i class="ri-delete-back-2-fill"></i>
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de Auditorías -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle table-borderless">
                            <thead class="table-primary">
                                <tr>
                                    <th>@lang('auditoria.user')</th>
                                    <th>@lang('auditoria.model')</th>
                                    <th>@lang('auditoria.action')</th>
                                    <th>@lang('auditoria.old_values')</th>
                                    <th>@lang('auditoria.new_values')</th>
                                    <th>@lang('auditoria.date')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($audits as $audit)
                                    <tr>
                                        <td>{{ optional($audit->user)->name ?? 'Sistema' }}</td>
                                        <td>{{ class_basename($audit->auditable_type) }} #{{ $audit->auditable_id }}</td>
                                        <td>{{ ucfirst($audit->event) }}</td>
                                        <td>{{ json_encode($audit->old_values) }}</td>
                                        <td>{{ json_encode($audit->new_values) }}</td>
                                        <td>{{ $audit->created_at->format('d-m-Y H:i') }}</td>
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

@section('script')

    <!-- Cargar Select2 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Inicializar Select2 en Usuario
            $('#user').select2({
                placeholder: "Selecciona un usuario",
                allowClear: true,
                minimumResultsForSearch: 1,
                width: '100%',
                dropdownParent: $('#user').parent()
            });

            // Aplicar borde azul cuando Select2 está activo
            $('#user').on("select2:open", function () {
                $(".select2-selection").addClass("border-primary");
            }).on("select2:close", function () {
                $(".select2-selection").removeClass("border-primary");
            });
        });
    </script>

    <!-- Cargar SweetAlert -->
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Manejar mensajes de validación con SweetAlert
            @if (session('sweetalert'))
                Swal.fire({
                    title: "{{ session('sweetalert.title') }}",
                    text: "{{ session('sweetalert.text') }}",
                    icon: "{{ session('sweetalert.type') }}",
                    confirmButtonText: '@lang('auditoria.accept')',
                });
            @endif

            @if ($errors->any())
                Swal.fire({
                    title: 'Error de Validación',
                    html: `<ul style="text-align: left;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>`,
                    icon: 'error',
                    confirmButtonText: 'Aceptar',
                });
            @endif

            // Búsqueda en vivo en el select de usuario (evita múltiples submits)
            let userSelectElement = document.getElementById('user');
            if (userSelectElement) {
                let searchTimeout;
                userSelectElement.addEventListener('change', function () {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(function () {
                        userSelectElement.form.submit();
                    }, 1000);
                });
            }

            // Manejar el cambio en el selector de registros por página
            let perPageElement = document.getElementById('perPage');
            if (perPageElement) {
                perPageElement.addEventListener('change', function () {
                    this.form.submit();
                });
            }
        });
    </script>

    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection