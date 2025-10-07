@extends('layouts.master')

@section('title', 'Subir Logos')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Subir Logos</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('logos.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <!-- Logo Cuadrado -->
                        <div class="col-md-6 mb-3">
                            <label for="square_logo" class="form-label">Logo Cuadrado</label>
                            <input type="file" class="form-control @error('square_logo') is-invalid @enderror" id="square_logo" name="square_logo" accept=".jpg,.jpeg,.png,image/jpeg,image/png">
                            <small class="text-muted">Recomendado: 1081x1081 px, ajuste la imagen segun como se vea en la pagina</small>
                            @error('square_logo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Logo Rectangular -->
                        <div class="col-md-6 mb-3">
                            <label for="rectangular_logo" class="form-label">Logo Rectangular</label>
                            <input type="file" class="form-control @error('rectangular_logo') is-invalid @enderror" id="rectangular_logo" name="rectangular_logo" accept=".jpg,.jpeg,.png,image/jpeg,image/png">
                            <small class="text-muted">Recomendado: 1386x310 px, ajuste la imagen segun como se vea en la pagina</small>
                            @error('rectangular_logo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">Subir Logos</button>
                    <a href="{{ route('settings.index') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
