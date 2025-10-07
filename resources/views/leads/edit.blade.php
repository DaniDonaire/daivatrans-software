@extends('layouts.master')

@section('title', isset($lead) ? 'Editar Lead' : 'Crear Lead')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">{{ isset($lead) ? 'Editar Lead' : 'Crear Lead' }}</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ isset($lead) ? route('leads.update', $lead->id) : route('leads.store') }}">
                    @csrf
                    @if(isset($lead))
                        @method('PUT')
                    @endif

                    <fieldset>
                        <legend>Contacto</legend>
                        <div class="row">
                        
                            <!-- Nombre -->
                            <div class="col-md-4 mb-3">
                                <label for="name" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $lead->name ?? '') }}" placeholder="Introduce el nombre">
                            </div>

                            <!-- Email -->
                            <div class="col-md-4 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $lead->email ?? '') }}" placeholder="Introduce el email">
                            </div>

                            <!-- Teléfono -->
                            <div class="col-md-4 mb-3">
                                <label for="phone" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $lead->phone ?? '') }}" placeholder="Introduce el teléfono">
                            </div>

                            <!-- Estado -->
                            <div class="col-md-4 mb-3">
                                <label for="status_id" class="form-label">Estado</label>
                                <select class="form-control" id="status_id" name="status_id">
                                    <option value="">Selecciona un estado</option>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status->id }}" {{ old('status_id', $lead->status_id ?? '') == $status->id ? 'selected' : '' }}>
                                            {{ $status->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                             <!-- Método de contacto -->
                             <div class="col-md-4 mb-3">
                                <label for="contact_method_id" class="form-label">Método de Contacto</label>
                                <select class="form-control" id="contact_method_id" name="contact_method_id">
                                    <option value="">Selecciona un método de contacto</option>
                                    @foreach($contactMethods as $contactMethod)
                                        <option value="{{ $contactMethod->id }}" {{ old('contact_method_id', $lead->contact_method_id ?? '') == $contactMethod->id ? 'selected' : '' }}>
                                            {{ $contactMethod->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Fecha de contacto -->
                            <div class="col-md-4 mb-3">
                                <label for="contact_date" class="form-label">Fecha de Contacto</label>
                                <input type="date" class="form-control" id="contact_date" name="contact_date" value="{{ old('contact_date', $lead->contact_date ?? '') }}" placeholder="Introduce la fecha">
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="my-4">
                        <legend>Servicio</legend>
                        <div class="row">
                        
                            <!-- Servicio -->
                            <div class="col-md-4 mb-3">
                                <label for="service_id" class="form-label">Servicio</label>
                                <select class="form-control" id="service_id" name="service_id">
                                    <option value="">Selecciona un servicio</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}" {{ old('service_id', $lead->service_id ?? '') == $service->id ? 'selected' : '' }}>
                                            {{ $service->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Categoria -->
                            <div class="col-md-4 mb-3">
                                <label for="status_id" class="form-label">Categoria</label>
                                <select id="category" name="category" class="form-control">
                                    <option value="Basic" {{ (old('category') ?? $lead->category) == 'Basic' ? 'selected' : '' }}>Basic</option>
                                    <option value="Standard" {{ (old('category') ?? $lead->category) == 'Standard' ? 'selected' : '' }}>Standard</option>
                                    <option value="Premium" {{ (old('category') ?? $lead->category) == 'Premium' ? 'selected' : '' }}>Premium</option>
                                </select>

                            </div>
                        </div>
                    </fieldset>

                    <button type="submit" class="btn btn-success">{{ isset($lead) ? 'Actualizar' : 'Crear' }}</button>
                    <a href="{{ route('leads.index') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Notes Tab -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="ri-sticky-note-line me-1"></i> Notas del lead</h5>
        <span class="badge bg-primary">{{ $lead->notes->count() }} notas</span>
    </div>
    <div class="card-body">
        <ul class="list-unstyled">
            @forelse($lead->notes as $note)
                <li class="mb-3">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-2">
                        <p class="mb-0">{{ $note->note }}</p>
                        <div class="d-flex align-items-center">
                            <small class="text-muted me-3">({{ $note->created_at->format('d/m/Y') }})</small>

                            @if($note->reminder)
                                <small class="text-info me-3">
                                    <i class="ri-notification-line"></i>
                                    Recordatorio: {{ \Carbon\Carbon::parse($note->reminder)->format('d/m/Y H:i') }}
                                </small>
                            @endif

                            <a href="#" class="text-warning me-2" data-bs-toggle="modal" data-bs-target="#editNoteModal{{ $note->id }}">
                                <i class="ri-edit-line"></i>
                            </a>
                            <form action="{{ route('leads.destroyNote', [$lead->id, $note->id]) }}" method="POST" class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="redirect_to" value="{{ request()->routeIs('leads.edit') ? 'edit' : 'show' }}">
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
                                <input type="hidden" name="redirect_to" value="{{ request()->routeIs('leads.edit') ? 'edit' : 'show' }}">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editNoteModalLabel{{ $note->id }}">Editar Nota</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <textarea class="form-control" name="note" rows="3">{{ $note->note }}</textarea>
                                    <div class="mb-3 mt-3">
                                        <label for="reminder" class="form-label">Recordatorio (opcional)</label>
                                        <input type="datetime-local" class="form-control" id="reminder" name="reminder" 
                                            value="{{ $note->reminder ? $note->reminder->format('Y-m-d\TH:i') : '' }}">
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
            @empty
                <li class="text-muted">No hay notas registradas.</li>
            @endforelse
        </ul>
    </div>
    <div class="card-footer">
        <!-- Formulario para añadir nueva nota -->
        <form method="POST" action="{{ route('leads.storeNote', $lead->id) }}">
            @csrf
            <input type="hidden" name="redirect_to" value="{{ request()->routeIs('leads.edit') ? 'edit' : 'show' }}">
            <div class="mb-3">
                <h6><strong>Añadir nueva nota</strong></h6>
                <textarea class="form-control" id="newNote" name="note" rows="2"></textarea>
            </div>
            <div class="mb-3">
                <label for="reminder" class="form-label">Recordatorio (opcional)</label>
                <input type="datetime-local" class="form-control" id="reminder" name="reminder">
            </div>
            <button type="submit" class="btn btn-success btn-sm">
                <i class="ri-add-line"></i> Añadir Nota
            </button>
        </form>
    </div>
</div>


<!-- End Notes Tab -->

@endsection
