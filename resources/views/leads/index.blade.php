@extends('layouts.master')

@section('title')
Leads
@endsection


@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="ri-check-double-line me-1 align-middle"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="ri-error-warning-line me-1 align-middle"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row g-4 mb-4">
    <div class="d-flex align-items-center flex-wrap gap-2">
        
        <a href="{{ route('leads.create') }}" class="btn btn-success">
            <i class="ri-add-line align-bottom me-1"></i>Crear lead
        </a>        
        
        <button class="btn btn-primary add-btn" data-bs-toggle="modal" data-bs-target="#changeColorModal">
            <i class="ri-palette-line align-bottom me-1"></i>Cambiar color
        </button>

        <div class="dropdown">
            <button class="btn btn-primary " type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="ri-file-excel-line"></i> Exportar Clientes
            </button>
            <div class="dropdown-menu" aria-labelledby="exportDropdown">
                <a class="dropdown-item" href="{{ route('clientes.export.all') }}">Exportar Todos</a>
                <a class="dropdown-item" href="{{ route('clientes.export.webcoding') }}">Exportar Clientes Webcoding</a>
            </div>
        </div>
        
        <form action="{{ route('leads.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Campo de archivo oculto -->
            <input type="file" id="fileInput" name="file" accept=".xlsx, .xls, .csv" required style="display: none;">
            
            <!-- Botón estilizado -->
            <button type="button" class="btn btn-primary" id="uploadButton">
                <i class="ri-upload-line align-bottom me-1"></i> Importar Clientes
            </button>
        </form>
        
        
        
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card" id="invoiceList">
            
            <div class="card-header border-0">
                <div class="d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">Leads</h5>
                </div>
            </div>

            <div class="card-body bg-light-subtle border border-dashed border-start-0 border-end-0">
                <form method="GET" action="{{ route('leads.index') }}">
                    @csrf
                    <div class="row g-3">

                        <div class="col-xxl-3 col-sm-12">
                            
                            <div class="search-box">
                                <input type="text" id="search" name="search" class="form-control search bg-light border-light" 
                                    placeholder="Buscar por nombre, email, teléfono..." value="{{ request('search') }}" 
                                    data-live-search>
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>

                        <div class="col-xxl-2 col-sm-4">
                            <input type="date" class="form-control bg-light border-light" id="contact_date" name="contact_date" placeholder="Seleccionar fecha" value="{{ request('contact_date') }}">
                        </div>

                        <div class="col-xxl-2 col-sm-4">
                            <div class="input-light">
                                <select class="form-control form-control bg-light border-light" data-choices data-choices-search-false name="status_id" id="idStatus">
                                    <option {{ request('status_id') == '' ? 'selected' : '' }} value="">Estado</option>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status->id }}" {{ request('status_id') == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-xxl-2 col-sm-4">
                            <div class="input-light">
                                <select class="form-control form-control bg-light border-light" data-choices data-choices-search-false name="service_id" id="idService">
                                    <option {{ request('service_id') == '' ? 'selected' : '' }} value="">Servicio</option>
                                    @isset($services)
                                        @foreach($services as $service)
                                            <option value="{{ $service->id }}" {{ request('service_id') == $service->id ? 'selected' : '' }}>{{ $service->name }}</option>
                                        @endforeach
                                    @endisset
                                </select>
                            </div>
                        </div>

                        <div class="col-xxl-2 col-sm-4">
                            <div class="input-light">
                                <select class="form-control" data-choices data-choices-search-false name="perPage" id="perPage">
                                    <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10 registros</option>
                                    <option value="20" {{ request('perPage') == 20 ? 'selected' : '' }}>20 registros</option>
                                    <option value="30" {{ request('perPage') == 30 ? 'selected' : '' }}>30 registros</option>
                                    <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50 registros</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xxl-1 col-sm-4">
                            <button type="submit" class="btn btn-primary mr-2"><i class="ri-search-line"></i></button>
                            <a href="{{ route('leads.index') }}" class="btn btn-secondary pl-2"><i class="ri-delete-back-2-fill"></i></a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card-body">
                <div>
                    <div id="table-container">
                        @include('leads.table', ['leads' => $leads])
                    </div>

                    {{-- Paginación --}}
                    <div class="align-items-center mt-4 pt-2 justify-content-between row text-center text-sm-start">
                        <div class="d-flex justify-content-center">
                            <div class="pagination-wrap hstack gap-2">
                                {{ $leads->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal para cambiar colores de los estados -->
                <div class="modal fade flip" id="changeColorModal" tabindex="-1" aria-labelledby="changeColorModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0">
                            <div class="modal-header bg-info-subtle p-3">
                                <h5 class="modal-title" id="changeColorModalLabel">Cambiar color de estado</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form method="POST" action="{{ route('status.updateColors') }}" autocomplete="off">
                                @csrf
                                <div class="modal-body">
                                    <div class="row g-3">
                                        @foreach($statuses as $status)
                                            <div class="col-lg-12">
                                                <div style="display:flex;">
                                                    <label style="width:50%;" for="status_{{ $status->id }}" class="form-label">{{ $status->name }}</label>
                                                    <input style="width:25%;" value="{{ $status->color }}" type="color" id="status_{{ $status->id }}" name="colors[{{ $status->id }}]" class="form-control"/> 
                                                    <input style="width:25%;" value="{{ $status->text_color }}" type="color" id="status_{{ $status->id }}" name="text_colors[{{ $status->id }}]" class="form-control"/>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-success">Cambiar Colores</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Fin del modal para cambiar colores de los estados -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Helper: CSRF token
        function getCsrfToken() {
            var meta = document.querySelector('meta[name="csrf-token"]');
            return meta ? meta.getAttribute('content') : '{{ csrf_token() }}';
        }

        // Bind inline status change handlers
        function bindStatusHandlers(scope) {
            var container = scope || document;
            var selects = container.querySelectorAll('.lead-status-select');
            selects.forEach(function(sel) {
                if (sel._bound) return; // Prevent double-binding
                sel._bound = true;
                sel.addEventListener('change', function() {
                    var updateUrl = this.getAttribute('data-update-url');
                    var row = this.closest('.lead-row');
                    var selectedOption = this.options[this.selectedIndex];

                    fetch(updateUrl, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': getCsrfToken(),
                        },
                        body: JSON.stringify({ status_id: this.value })
                    })
                    .then(function(res){ if(!res.ok) throw new Error('Error al actualizar estado'); return res.json(); })
                    .then(function(data){
                        if (row && data && data.status) {
                            row.style.backgroundColor = data.status.color || '';
                            row.style.color = data.status.text_color || '';
                        } else if (row && selectedOption) {
                            // fallback to option data attributes
                            row.style.backgroundColor = selectedOption.getAttribute('data-color') || '';
                            row.style.color = selectedOption.getAttribute('data-text-color') || '';
                        }
                    })
                    .catch(function(err){ console.error(err); });
                });
            });
        }

        // Evento para el botón de seleccionar archivo
        var selectFileBtn = document.getElementById('selectFileBtn');
        if (selectFileBtn) {
            selectFileBtn.addEventListener('click', function() {
                var fileInput = document.getElementById('fileInput');
                if (fileInput) {
                    fileInput.click();
                }
            });
        }

        // Lista de IDs de los campos que deben activar el envío del formulario al cambiar
        ['idStatus', 'idService', 'contact_date', 'perPage'].forEach(function(id) {
            var element = document.getElementById(id);
            if (element) { // Verifica que el elemento existe
                element.addEventListener('change', function() {
                    if (this.form) {
                        this.form.submit();
                    }
                });
            }
        });

        // Campo 'search' con evento 'keyup' usando debounce
        var searchField = document.getElementById('search');
        if (searchField) {
            let debounceTimer;
            searchField.addEventListener('keyup', function() {
                clearTimeout(debounceTimer); // Limpia cualquier temporizador previo
                debounceTimer = setTimeout(() => {
                    if (this.form) {
                        this.form.submit(); // Envía el formulario después de la pausa
                    }
                }, 300); // Espera 300 ms antes de enviar
            });
        }

        // Evento para el botón de subir archivo
        var uploadButton = document.getElementById('uploadButton');
        if (uploadButton) {
            uploadButton.addEventListener('click', function () {
                var fileInput = document.getElementById('fileInput');
                if (fileInput) {
                    fileInput.click(); // Simula el clic en el campo oculto
                }
            });
        }

        // Evento para el campo de archivo
        var fileInput = document.getElementById('fileInput');
        if (fileInput) {
            fileInput.addEventListener('change', function () {
                if (this.form) {
                    this.form.submit(); // Envía el formulario automáticamente al seleccionar el archivo
                }
            });
        }

        // Initial bind for status selects
        bindStatusHandlers();
    });

    document.addEventListener('DOMContentLoaded', function() {
        const searchField = document.querySelector('[data-live-search]');
        const tableContainer = document.getElementById('table-container');

        let debounceTimer;

        if (searchField) {
            searchField.addEventListener('keyup', function() {
                clearTimeout(debounceTimer); // Limpia el temporizador anterior
                debounceTimer = setTimeout(() => {
                    const query = this.value.trim();
                    
                    // Realiza la solicitud AJAX solo si hay texto
                    fetch(`{{ route('leads.index') }}?search=${encodeURIComponent(query)}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest', // Identifica la solicitud como AJAX
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error al cargar los datos.');
                        }
                        return response.text(); // Procesa la respuesta como HTML parcial
                    })
                    .then(html => {
                        tableContainer.innerHTML = html; // Inserta la nueva tabla
                        // Re-bind handlers after table refresh
                        (function(){
                            // Reuse the binder defined in the other DOMContentLoaded block
                            if (typeof bindStatusHandlers === 'function') {
                                bindStatusHandlers(tableContainer);
                            } else {
                                // If not in scope, quickly bind here
                                var selects = tableContainer.querySelectorAll('.lead-status-select');
                                selects.forEach(function(sel){ sel._bound = false; });
                                var evt = new Event('DOMContentLoaded'); // trigger earlier block if needed
                            }
                        })();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        tableContainer.innerHTML = '<p>Error al buscar resultados.</p>';
                    });
                }, 300); // Tiempo de debounce
            });
        }
    });
</script>




@endsection
