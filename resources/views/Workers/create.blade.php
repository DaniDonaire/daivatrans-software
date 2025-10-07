@extends('layouts.master')

@section('title')
    @lang('workers.create_title')
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
            @lang('workers.create_title')
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header bg-light border-bottom">
                    <h4 class="card-title mb-0 text-primary">@lang('workers.create_title')</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('workers.store') }}" method="POST" class="row g-3">
                        @csrf

                        <!-- Nombre -->
                        <div class="col-md-6">
                            <label for="name" class="form-label">@lang('workers.name_label')</label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   placeholder="@lang('workers.name_placeholder')">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Apellidos -->
                        <div class="col-md-6">
                            <label for="surname" class="form-label">@lang('workers.surname_label')</label>
                            <input type="text" 
                                   class="form-control @error('surname') is-invalid @enderror" 
                                   id="surname" 
                                   name="surname" 
                                   value="{{ old('surname') }}"
                                   placeholder="@lang('workers.surname_placeholder')">
                            @error('surname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- DNI -->
                        <div class="col-md-4">
                            <label for="dni" class="form-label">@lang('workers.dni_label')</label>
                            <input type="text" 
                                   class="form-control @error('dni') is-invalid @enderror" 
                                   id="dni" 
                                   name="dni" 
                                   value="{{ old('dni') }}"
                                   placeholder="@lang('workers.dni_placeholder')">
                            @error('dni')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Teléfono -->
                        <div class="col-md-4">
                            <label for="phone" class="form-label">@lang('workers.phone_label')</label>
                            <input type="text" 
                                   class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone') }}"
                                   placeholder="@lang('workers.phone_placeholder')">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="col-md-4">
                            <label for="email" class="form-label">@lang('workers.email_label')</label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                   placeholder="@lang('workers.email_placeholder')">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Seguridad Social -->
                        <div class="col-md-6">
                            <label for="seguridad_social" class="form-label">@lang('workers.seguridad_social_label')</label>
                            <input type="text" 
                                class="form-control @error('seguridad_social') is-invalid @enderror" 
                                id="seguridad_social" 
                                name="seguridad_social" 
                                value="{{ old('seguridad_social') }}"
                                placeholder="@lang('workers.seguridad_social_placeholder')">
                            @error('seguridad_social')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Cuenta Bancaria -->
                        <div class="col-md-6">
                            <label for="cuenta_bancaria" class="form-label">@lang('workers.cuenta_bancaria_label')</label>
                            <input type="text" 
                                class="form-control @error('cuenta_bancaria') is-invalid @enderror" 
                                id="cuenta_bancaria" 
                                name="cuenta_bancaria" 
                                value="{{ old('cuenta_bancaria') }}"
                                placeholder="@lang('workers.cuenta_bancaria_placeholder')">
                            @error('cuenta_bancaria')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Observaciones -->
                        <div class="col-12">
                            <label for="observaciones" class="form-label">@lang('workers.observaciones_label')</label>
                            <textarea class="form-control @error('observaciones') is-invalid @enderror" 
                                    id="observaciones" 
                                    name="observaciones" 
                                    rows="3"
                                    placeholder="@lang('workers.observaciones_placeholder')">{{ old('observaciones') }}</textarea>
                            @error('observaciones')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Botones -->
                        <div class="col-12 text-end">
                            <a href="{{ route('workers.index') }}" class="btn btn-secondary me-2">@lang('workers.back')</a>
                            <button type="submit" class="btn btn-primary">@lang('workers.save')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection