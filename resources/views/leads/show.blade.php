@extends('layouts.master')
@section('title', 'Detalle del Lead')

@section('content')
    <!-- Start Profile Background -->
    <div class="position-relative mx-n4 mt-n4">
        <div class="profile-wid-bg profile-setting-img">
            <img src="{{ URL::asset('images/logo.png') }}" class="profile-wid-img" alt="">
            <div class="overlay-content">
                <div class="text-end p-3">
                    <!-- Puedes añadir algún control aquí -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Profile Background -->

    <div class="row">
        <div class="col-xxl-3">
            <div class="card mt-n5">
                <div class="card-body p-4 text-center">
                    <h5 class="fs-17 mb-1">{{ $lead->name }}</h5>
                    @if($lead->status)
                        <span class="badge" style="background-color: {{ $lead->status->color }};">
                            {{ $lead->status->name }}
                        </span>
                    @else
                        <p>No especificada</p>
                    @endif
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('leads.index') }}" class="btn btn-secondary">
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
                        @php
                            $activeTab = session('active_tab', 'leadDetails');
                            if ($errors->any()) {
                                $activeTab = 'property';
                            }
                        @endphp

                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center {{ $activeTab == 'leadDetails' ? 'active' : '' }}" 
                            data-bs-toggle="tab" href="#leadDetails" role="tab">
                                <i class="ri-user-search-line me-1"></i> Detalles del Lead
                            </a>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center {{ $activeTab == 'notes' ? 'active' : '' }}" 
                            data-bs-toggle="tab" href="#notes" role="tab">
                                <i class="ri-sticky-note-line me-1"></i> Notas
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-4">
                    <div class="tab-content">
                        <!-- Lead Details Tab -->
                        <div class="tab-pane {{ $activeTab == 'leadDetails' ? 'active' : '' }}" id="leadDetails" role="tabpanel">
                            <div class="row g-3">
                                <div class="col-lg-6">
                                    <div class="border rounded p-3 h-100">
                                        <div class="text-muted mb-1"><i class="ri-id-card-line me-1"></i> Nombre</div>
                                        <div class="fw-semibold">{{ $lead->name }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="border rounded p-3 h-100">
                                        <div class="text-muted mb-1"><i class="ri-mail-line me-1"></i> Email</div>
                                        <div class="fw-semibold"><a href="mailto:{{ $lead->email }}">{{ $lead->email }}</a></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="border rounded p-3 h-100">
                                        <div class="text-muted mb-1"><i class="ri-phone-line me-1"></i> Teléfono</div>
                                        <div class="fw-semibold"><a href="tel:{{ $lead->phone }}">{{ $lead->phone }}</a></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="border rounded p-3 h-100">
                                        <div class="text-muted mb-1"><i class="ri-customer-service-2-line me-1"></i> Servicio</div>
                                        <div class="fw-semibold">{{ $lead->service->name ?? 'No especificado' }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="border rounded p-3 h-100">
                                        <div class="text-muted mb-1"><i class="ri-chat-1-line me-1"></i> Método de Contacto</div>
                                        <div class="fw-semibold">{{ $lead->contactMethod->name ?? 'No especificada' }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="border rounded p-3 h-100">
                                        <div class="text-muted mb-1"><i class="ri-calendar-line me-1"></i> Fecha de Contacto</div>
                                        <div class="fw-semibold">{{ $lead->contact_date ?? 'No especificada' }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="border rounded p-3 h-100">
                                        <div class="text-muted mb-1"><i class="ri-price-tag-3-line me-1"></i> Categoria</div>
                                        <div class="fw-semibold">{{ $lead->category ?? 'No especificada' }}</div>
                                    </div>
                                </div>
                                @if($lead->description)
                                <div class="col-12">
                                    <div class="border rounded p-3 h-100">
                                        <div class="text-muted mb-1 d-flex align-items-center"><i class="ri-information-line me-1"></i> Información Adicional</div>
                                        <div class="bg-light p-3 rounded">
                                            <pre style="white-space: pre-wrap; font-family: inherit; margin: 0;">{{ $lead->description }}</pre>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        <!-- End Lead Details Tab -->

                        <!-- Financial Details Tab -->
                        <div class="tab-pane {{ $activeTab == 'financialDetails' ? 'active' : '' }}" id="financialDetails" role="tabpanel">
                            <div class="row g-3">
                                <div class="col-lg-6">
                                    <div class="border rounded p-3 h-100">
                                        <div class="text-muted mb-1"><i class="ri-bank-card-line me-1"></i> Importe Hipoteca</div>
                                        <div class="fw-semibold">{{ $lead->mortgage_amount !== null ? number_format($lead->mortgage_amount, 2, ',', '.') . ' €' : 'N/A' }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="border rounded p-3 h-100">
                                        <div class="text-muted mb-1"><i class="ri-shopping-bag-3-line me-1"></i> Importe Compra</div>
                                        <div class="fw-semibold">{{ $lead->purchase_amount !== null ? number_format($lead->purchase_amount, 2, ',', '.') . ' €' : 'N/A' }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="border rounded p-3 h-100">
                                        <div class="text-muted mb-1"><i class="ri-calendar-check-line me-1"></i> Fecha de Firma</div>
                                        <div class="fw-semibold">{{ $lead->signing_date ? \Carbon\Carbon::parse($lead->signing_date)->format('d/m/Y') : 'N/A' }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="border rounded p-3 h-100 d-flex align-items-center justify-content-between">
                                        <div>
                                            <div class="text-muted mb-1"><i class="ri-folder-2-line me-1"></i> Documentos</div>
                                            <div class="small text-muted">Enlace a documentación aportada</div>
                                        </div>
                                        <div>
                                            @if ($lead->documents_link)
                                                <a href="{{ $lead->documents_link }}" target="_blank" class="btn btn-sm btn-primary"><i class="ri-external-link-line me-1"></i> Ver</a>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary"><i class="ri-close-line me-1"></i> No especificado</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Financial Details Tab -->

                        <!-- Notes Tab -->
                        <div class="tab-pane {{ $activeTab == 'notes' ? 'active' : '' }}" id="notes" role="tabpanel">
                            <ul class="list-unstyled">
                                @foreach($lead->notes as $note)
                                    <li class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center border-bottom  border-2">
                                            <p class="mb-0">{{ $note->note }}</p>
                                            <div class="d-flex align-items-center">
                                                <small class="text-muted me-3">({{ $note->created_at->format('d/m/Y') }})</small>

                                                @if($note->reminder)
                                                    <small class="text-info me-3"><i class="ri-notification-line"></i> Recordatorio: {{ \Carbon\Carbon::parse($note->reminder)->format('d/m/Y H:i') }}</small>
                                                @endif

                                                <a href="#" class="text-warning me-2" data-bs-toggle="modal" data-bs-target="#editNoteModal{{ $note->id }}"><i class="ri-edit-line"></i></a>
                                                <form action="{{ route('leads.destroyNote', [$lead->id, $note->id]) }}" method="POST" class="d-inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link text-danger p-0" onclick="return confirm('¿Seguro que quieres eliminar esta nota?')">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </li>

                                    <!-- Modal para editar nota -->
                                    <div class="modal fade" id="editNoteModal{{ $note->id }}" tabindex="-1" aria-labelledby="editNoteModalLabel{{ $note->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form method="POST" action="{{ route('leads.updateNote', [$lead->id, $note->id]) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editNoteModalLabel{{ $note->id }}">Editar Nota</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <textarea class="form-control" name="note" rows="3">{{ $note->note }}</textarea>
                                                        <div class="mb-3 mt-3">
                                                            <label for="reminder" class="form-label">Recordatorio (opcional)</label>
                                                            <input type="datetime-local" class="form-control" id="reminder" name="reminder" value="{{ $note->reminder ? $note->reminder->format('Y-m-d\TH:i') : '' }}">

                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Fin modal editar nota -->
                                @endforeach
                            </ul>

                            <!-- Formulario para añadir nueva nota -->
                            <form method="POST" action="{{ route('leads.storeNote', $lead->id) }}">
                                @csrf
                                <div class="mb-3">
                                    <h6><strong>Añadir nueva nota</strong></h6>
                                    <textarea class="form-control" id="newNote" name="note" rows="2"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="reminder" class="form-label">Recordatorio (opcional)</label>
                                    <input type="datetime-local" class="form-control" id="reminder" name="reminder">
                                </div>
                                <button type="submit" class="btn btn-success btn-sm"><i class="ri-add-line"></i> Añadir Nota</button>
                            </form>
                        </div>
                        <!-- End Notes Tab -->

                        <!-- Property Tab -->
                        <div class="tab-pane {{ $activeTab == 'property' ? 'active' : '' }}" id="property" role="tabpanel">
                            <div class="row g-4">
                                @if ($errors->any())
                                    <div class="col-12">
                                        <div class="alert alert-danger">
                                            <strong>Hay errores en el formulario:</strong>
                                            <ul class="mb-0">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- End Col -->
    </div>
    <!-- End Row -->
@endsection

