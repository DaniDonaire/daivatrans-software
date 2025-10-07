@extends('layouts.master')

@section('title', isset($lead) ? 'Editar Lead ' : 'Crear Lead ')

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
                        </div>
                    </fieldset>
                    
                    <button type="submit" class="btn btn-success">{{ isset($lead) ? 'Actualizar' : 'Crear' }}</button>
                    <a href="{{ route('leads.index') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
