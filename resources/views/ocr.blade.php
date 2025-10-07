@extends('layouts.master')

@section('title')
    OCR
@endsection

@section('content')
    <form action="{{ route('ocr.process') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- Encabezado con pestañas -->
                    <div class="card-header">
                        <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#ocrTab" role="tab">
                                    <i class="fas fa-file-alt"></i>
                                    OCR
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Cuerpo de la tarjeta -->
                    <div class="card-body p-4">
                        <div class="tab-content">
                            <!-- Pestaña para la carga de imagen -->
                            <div class="tab-pane active" id="ocrTab" role="tabpanel">
                                <div class="row g-3">
                                    <div class="col-lg-6">
                                        <label for="image" class="form-label">Selecciona una imagen</label>
                                        <input 
                                            type="file" 
                                            id="image" 
                                            name="file"  
                                            class="form-control" 
                                            onchange="previewImage(this, 'preview-image')" 
                                            required
                                        >
                                    </div>

                                    <div class="col-lg-6 text-center">
                                        <label class="form-label">Vista Previa</label>
                                        <div class="card">
                                            <div class="card-body">
                                                <img 
                                                    id="preview-image" 
                                                    src="{{ isset($uploadedImage) ? asset('storage/' . $uploadedImage) : URL::asset('build/images/placeholder.png') }}" 
                                                    class="rounded img-thumbnail"
                                                    style="max-width: 250px; object-fit: cover;"
                                                    alt="Sin imagen"
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>

                    <!-- Pie de tarjeta -->
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">Procesar Imagen</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Mostrar el resultado del OCR si existe -->
    @if(isset($text))
        <div class="row mt-3">
            <div class="col-12">
                <div class="alert alert-info">
                    <h5>Resultado del OCR</h5>
                    <p>{{ $text }}</p>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('script')
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        @if (session('success'))
            Swal.fire({
                title: 'Éxito',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'Aceptar',
            });
        @elseif (session('error'))
            Swal.fire({
                title: 'Error',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonText: 'Aceptar',
            });
        @endif
    </script>
    <script>
        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById(previewId);
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
