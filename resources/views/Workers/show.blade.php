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
                            <a class="nav-link" data-bs-toggle="tab" href="#notes" role="tab">
                                <i class="ri-sticky-note-line me-1"></i> Notas
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
                                                <span class="text-muted">—</span>
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
                                                <span class="text-muted">—</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Información Bancaria -->
                                <div class="col-lg-12">
                                    <div class="border rounded p-3 h-100">
                                        <div class="text-muted mb-1"><i class="ri-bank-card-line me-1"></i> Cuenta Bancaria</div>
                                        <div class="fw-semibold">{{ $worker->cuenta_bancaria ?? '—' }}</div>
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
                        <div class="tab-pane" id="notes" role="tabpanel">
                            <div class="text-center text-muted">
                                <p>Próximamente disponible</p>
                            </div>
                        </div>
                        <!-- End Notes Tab -->
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
@endsection