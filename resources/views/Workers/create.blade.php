@extends('layouts.master')

@section('title') @lang('workers.create_title') @endsection

@section('css')
  <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
  @component('components.breadcrumb')
      @slot('li_1') @lang('workers.breadcrumb') @endslot
      @slot('title') @lang('workers.create_title') @endslot
  @endcomponent

  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header bg-light border-bottom">
          <h4 class="card-title mb-0 text-primary">@lang('workers.create_title')</h4>
        </div>

        <div class="card-body">
          <form action="{{ route('workers.store') }}" method="POST">
            @csrf

            {{-- Fila 1: Nombre / Apellidos --}}
            <div class="row g-3">
              <div class="col-md-6">
                <label for="name" class="form-label">@lang('workers.name_label')</label>
                <input type="text" id="name" name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}"
                       placeholder="@lang('workers.name_placeholder')">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="col-md-6">
                <label for="surname" class="form-label">@lang('workers.surname_label')</label>
                <input type="text" id="surname" name="surname"
                       class="form-control @error('surname') is-invalid @enderror"
                       value="{{ old('surname') }}"
                       placeholder="@lang('workers.surname_placeholder')">
                @error('surname') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>

            {{-- Fila 2: DNI / Teléfono --}}
            <div class="row g-3 mt-0">
              <div class="col-md-6">
                <label for="dni" class="form-label">@lang('workers.dni_label')</label>
                <input type="text" id="dni" name="dni"
                       class="form-control @error('dni') is-invalid @enderror"
                       value="{{ old('dni') }}"
                       placeholder="@lang('workers.dni_placeholder')"
                       minlength="9" maxlength="9" pattern=".{9}">
                @error('dni') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="col-md-6">
                <label for="telefono" class="form-label">@lang('workers.phone_label')</label>
                <input type="tel" id="telefono" name="telefono"
                       class="form-control @error('telefono') is-invalid @enderror"
                       value="{{ old('telefono') }}"
                       placeholder="@lang('workers.phone_placeholder')">
                @error('telefono') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>

            {{-- Fila 3: Email (ocupa toda la fila) --}}
            <div class="row g-3 mt-0">
              <div class="col-12">
                <label for="email" class="form-label">@lang('workers.email_label')</label>
                <input type="email" id="email" name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email') }}"
                       placeholder="@lang('workers.email_placeholder')">
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>

            {{-- Fila 4: Seguridad Social / Cuenta Bancaria --}}
            <div class="row g-3 mt-0">
              <div class="col-md-6">
                <label for="seguridad_social" class="form-label">@lang('workers.seguridad_social_label')</label>
      <input type="text" id="seguridad_social" name="seguridad_social"
        class="form-control @error('seguridad_social') is-invalid @enderror"
        value="{{ old('seguridad_social') }}"
        placeholder="@lang('workers.seguridad_social_placeholder')"
        title="Debe tener exactamente 12 caracteres">
                @error('seguridad_social') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="col-md-6">
                <label for="cuenta_bancaria" class="form-label">@lang('workers.cuenta_bancaria_label')</label>
                <input type="text" id="cuenta_bancaria" name="cuenta_bancaria"
                       class="form-control @error('cuenta_bancaria') is-invalid @enderror"
                       value="{{ old('cuenta_bancaria') }}"
                       placeholder="@lang('workers.cuenta_bancaria_placeholder')">
                @error('cuenta_bancaria') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>

             {{-- 🏠 Fila 5: Dirección del trabajador --}}
             <hr class="my-4">
             <h5 class="text-primary">Dirección del trabajador</h5>
 
             <div class="row g-3 mt-0">
               <div class="col-md-6">
                 <label for="street" class="form-label">Calle y número</label>
                 <input type="text" id="street" name="address[street]"
                        class="form-control @error('address.street') is-invalid @enderror"
                        value="{{ old('address.street') }}"
                        placeholder="Ej. Calle Mayor 15">
                 @error('address.street') <div class="invalid-feedback">{{ $message }}</div> @enderror
               </div>
 
               <div class="col-md-6">
                 <label for="postal_code" class="form-label">Código postal</label>
                 <input type="text" id="postal_code" name="address[postal_code]"
                        class="form-control @error('address.postal_code') is-invalid @enderror"
                        value="{{ old('address.postal_code') }}"
                        placeholder="Ej. 08800">
                 @error('address.postal_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
               </div>
             </div>
 
             <div class="row g-3 mt-0">
               <div class="col-md-4">
                 <label for="city" class="form-label">Ciudad</label>
                 <input type="text" id="city" name="address[city]"
                        class="form-control @error('address.city') is-invalid @enderror"
                        value="{{ old('address.city') }}"
                        placeholder="Ej. Vilanova i la Geltrú">
                 @error('address.city') <div class="invalid-feedback">{{ $message }}</div> @enderror
               </div>
 
               <div class="col-md-4">
                 <label for="province" class="form-label">Provincia</label>
                 <input type="text" id="province" name="address[province]"
                        class="form-control @error('address.province') is-invalid @enderror"
                        value="{{ old('address.province') }}"
                        placeholder="Ej. Barcelona">
                 @error('address.province') <div class="invalid-feedback">{{ $message }}</div> @enderror
               </div>
 
               <div class="col-md-4">
                 <label for="country" class="form-label">País</label>
                 <input type="text" id="country" name="address[country]"
                        class="form-control @error('address.country') is-invalid @enderror"
                        value="{{ old('address.country') }}"
                        placeholder="Ej. España">
                 @error('address.country') <div class="invalid-feedback">{{ $message }}</div> @enderror
               </div>
             </div>

             <hr class="my-4">
             <h5 class="text-primary">Observaciones</h5>
            {{-- Fila 5: Observaciones (toda la fila) --}}
            <div class="row g-3 mt-0">
              <div class="col-12">
                <label for="observaciones" class="form-label">@lang('workers.observaciones_label')</label>
                <textarea id="observaciones" name="observaciones" rows="3"
                          class="form-control @error('observaciones') is-invalid @enderror"
                          placeholder="@lang('workers.observaciones_placeholder')">{{ old('observaciones') }}</textarea>
                @error('observaciones') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>

            {{-- Botones --}}
            <div class="text-end mt-3">
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
  <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
