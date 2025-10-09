@extends('layouts.master')
@section('title', 'Detalle del Trabajador')

@section('content')
    <!-- Start Profile Background -->
    <div class="position-relative mx-n4 mt-n4">
        <div class="profile-wid-bg profile-setting-img">
            <img src="{{ URL::asset('images/logo.png') }}" class="profile-wid-img" alt="">
        </div>
    </div>
    <!-- End Profile Background -->

    <div class="row">
        <div class="col-xxl-3">
            <div class="card mt-n5">
                <div class="card-body p-4 text-center">
                    <h5 class="fs-17 mb-1">{{ $worker->name }} {{ $worker->surname }}</h5>
                    <p class="text-muted mb-0">{{ $worker->dni }}</p>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('workers.index') }}" class="btn btn-secondary">
                    <i class="ri-arrow-left-line"></i> Volver
                </a>
                @can('workers_edit')
                    <a href="{{ route('workers.edit', $worker->id) }}" class="btn btn-success">
                        Editar
                    </a>
                @endcan
            </div>
        </div>
        <!-- End Col -->

        <!-- Main Details Section -->
        <div class="col-xxl-9">
            <div class="card mt-xxl-n5">
                <div class="card-header">
                    <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#workerDetails" role="tab">
                                <i class="ri-user-line me-1"></i> Detalles
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#observaciones" role="tab">
                                <i class="ri-file-text-line me-1"></i> Observaciones
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#seguimiento" role="tab">
                                <i class="ri-file-text-line me-1"></i> Seguimiento
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#documentos" role="tab">
                                <i class="ri-file-text-line me-1"></i> Documentos
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="card-body p-4">
                    <div class="tab-content">
                        <!-- Worker Details Tab -->
                        <div class="tab-pane active" id="workerDetails" role="tabpanel">
                            <div class="row g-3">
                                <!-- Información Personal -->
                                <div class="col-lg-6">
                                    <div class="border rounded p-3 h-100">
                                        <div class="text-muted mb-1"><i class="ri-user-line me-1"></i> Nombre</div>
                                        <div class="fw-semibold">{{ $worker->name }}</div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="border rounded p-3 h-100">
                                        <div class="text-muted mb-1"><i class="ri-user-line me-1"></i> Apellidos</div>
                                        <div class="fw-semibold">{{ $worker->surname }}</div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="border rounded p-3 h-100">
                                        <div class="text-muted mb-1"><i class="ri-admin-line me-1"></i> DNI</div>
                                        <div class="fw-semibold">{{ $worker->dni }}</div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="border rounded p-3 h-100">
                                        <div class="text-muted mb-1"><i class="ri-shield-user-line me-1"></i> Número de Seguridad Social</div>
                                        <div class="fw-semibold">{{ $worker->seguridad_social }}</div>
                                    </div>
                                </div>

                                <!-- Información de Contacto -->
                                <div class="col-lg-6">
                                    <div class="border rounded p-3 h-100">
                                        <div class="text-muted mb-1"><i class="ri-phone-line me-1"></i> Teléfono</div>
                                        <div class="fw-semibold">
                                            @if($worker->telefono)
                                                <a href="tel:{{ $worker->telefono }}">{{ $worker->telefono }}</a>
                                            @else
                                                <span class="text-muted"></span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="border rounded p-3 h-100">
                                        <div class="text-muted mb-1"><i class="ri-mail-line me-1"></i> Correo Electrónico</div>
                                        <div class="fw-semibold">
                                            @if($worker->email)
                                                <a href="mailto:{{ $worker->email }}">{{ $worker->email }}</a>
                                            @else
                                                <span class="text-muted"></span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Información Bancaria -->
                                <div class="col-lg-12">
                                    <div class="border rounded p-3 h-100">
                                        <div class="text-muted mb-1"><i class="ri-bank-card-line me-1"></i> Cuenta Bancaria</div>
                                        <div class="fw-semibold">{{ $worker->cuenta_bancaria ?? '' }}</div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="border rounded p-3 h-100">
                                        <div class="text-muted mb-2"><i class="ri-map-pin-line me-1"></i> Dirección</div>

                                        @if($worker->address)
                                            <div class="fw-semibold mb-1">
                                                {{ $worker->address->street ?? '' }}
                                            </div>
                                            <div class="text-muted small">
                                                {{ $worker->address->postal_code ?? '' }}
                                                {{ $worker->address->city ?? '' }} 
                                                @if($worker->address->province)
                                                    ({{ $worker->address->province }})
                                                @endif
                                                <br>
                                                {{ $worker->address->country ?? '' }}
                                            </div>
                                        @else
                                            <div class="text-muted"></div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Observaciones -->
                                @if($worker->observaciones)
                                    <div class="col-12">
                                        <div class="border rounded p-3 h-100">
                                            <div class="text-muted mb-1"><i class="ri-file-text-line me-1"></i> Observaciones</div>
                                            <div class="bg-light p-3 rounded">
                                                <pre style="white-space: pre-wrap; font-family: inherit; margin: 0;">{{ $worker->observaciones }}</pre>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                        <!-- End Worker Details Tab -->

                        <!-- Notes Tab -->
                        <div class="tab-pane" id="observaciones" role="tabpanel">
                            <form id="observacionesForm" action="{{ route('workers.update', $worker->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="observaciones" class="form-label">Observaciones del trabajador</label>
                                            <textarea class="form-control" 
                                                id="observaciones" 
                                                name="observaciones" 
                                                rows="6" 
                                                style="resize: none;">{{ $worker->observaciones }}</textarea>
                                        </div>
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="ri-save-line align-bottom me-1"></i> Guardar Observaciones
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- End Notes Tab -->
                        <!-- seguimiento Tab -->
                        <div class="tab-pane" id="seguimiento" role="tabpanel">
                            <div class="row">
                                <h5>Aqui veremos el seguimiento de los trabajadores</h5>
                            </div>
                        </div>
                        <!-- End seguimiento Tab -->
                        <!-- documentos Tab -->
                        <div class="tab-pane" id="documentos" role="tabpanel">
                            <div class="row">
                                <h5>Aqui veremos los documentos de los trabajadores</h5>
                            </div>
                        </div>
                        <!-- End documentos Tab -->
                    </div>
                </div>
            </div>
        </div>
        <!-- End Col -->
    </div>
    <!-- End Row -->
@endsection

@section('script')
    <script src="{{ URL::asset('build/js/app.js') }}"></script>

    <script>
        document.getElementById('observacionesForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    Swal.fire({
                        title: 'Éxito',
                        text: 'Las observaciones se han guardado correctamente',
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    title: 'Error',
                    text: 'Ha ocurrido un error al guardar las observaciones',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            });
        });
    </script>
@endsection