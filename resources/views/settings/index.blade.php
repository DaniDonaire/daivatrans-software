@extends('layouts.master')
@section('title')
    @lang('settings.title')
@endsection
@section('content')

    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#textSettings" role="tab">
                                    <i class="fas fa-file-alt"></i>
                                    @lang('settings.text_settings')
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#fileSettings" role="tab">
                                    <i class="fas fa-image"></i>
                                    @lang('settings.image_settings')
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body p-4">
                        <div class="tab-content">
                            <!-- Pestaña: Configuraciones de Texto -->
                            <div class="tab-pane active" id="textSettings" role="tabpanel">
                                <div class="row g-3">
                                    @foreach ($settings as $key => $setting)
                                        @if ($setting->type === 'text')
                                            <div class="col-lg-6">
                                                <label for="{{ $key }}" class="form-label">{{ ucfirst(str_replace('_', ' ', $key)) }}</label>
                                                <input type="text" 
                                                    id="{{ $key }}" 
                                                    name="{{ $key }}" 
                                                    class="form-control" 
                                                    value="{{ old($key, $setting->value) }}" 
                                                    placeholder="Introduce {{ str_replace('_', ' ', $key) }}">
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            <!-- Pestaña: Configuraciones de Imágenes -->
                            <div class="tab-pane" id="fileSettings" role="tabpanel">
                                <div class="row g-4 justify-content-center">
                                    @foreach (['favicon', 'logo_rectangular', 'logo_square'] as $key)
                                        @if (isset($settings[$key]) && $settings[$key]->type === 'file')
                                            <div class="col-xxl-3 col-lg-4 col-md-6">
                                                <div class="card text-center">
                                                    <div class="card-body d-flex flex-column align-items-center">
                                                        <div class="profile-user position-relative mb-4">
                                                            <!-- Imagen actual o por defecto -->
                                                            <img id="preview-{{ $key }}" 
                                                                src="
                                                                @if ($key === 'favicon' && empty($settings[$key]->value))
                                                                    {{ URL::asset('build/images/favicon.ico') }}
                                                                @elseif ($key === 'logo_rectangular' && empty($settings[$key]->value))
                                                                    {{ URL::asset('build/images/WCD_White.png') }}
                                                                @elseif ($key === 'logo_square' && empty($settings[$key]->value))
                                                                    {{ URL::asset('build/images/WCD_TG_White.png') }}
                                                                @else
                                                                    {{ URL::asset('storage/' . $settings[$key]->value) }}
                                                                @endif" 
                                                                class="rounded-circle avatar-xl img-thumbnail user-profile-image" 
                                                                alt="{{ ucfirst(str_replace('_', ' ', $key)) }} no disponible" 
                                                                style="width: 150px; height: 150px; object-fit: cover;">
                                                            <!-- Input de archivo -->
                                                            <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                                                <input id="file-input-{{ $key }}" 
                                                                    type="file" 
                                                                    name="{{ $key }}" 
                                                                    class="profile-img-file-input" 
                                                                    accept="image/*"
                                                                    onchange="previewImage(this, 'preview-{{ $key }}')">
                                                                <label for="file-input-{{ $key }}" 
                                                                    class="profile-photo-edit avatar-xs">
                                                                    <span class="avatar-title rounded-circle bg-light text-body">
                                                                        <i class="ri-camera-fill"></i>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <h5 class="fs-17 mb-1">{{ ucfirst(str_replace('_', ' ', $key)) }}</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">@lang('settings.save_changes')</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        @if (session('success'))
            Swal.fire({
                title: '@lang('settings.success')',
                text: '@lang('settings.success_message')',
                icon: 'success',
                confirmButtonText: '@lang('settings.accept')',
            });
        @elseif (session('error'))
            Swal.fire({
                title: '@lang('settings.error')',
                text: '@lang('settings.error_message')',
                icon: 'error',
                confirmButtonText: '@lang('settings.accept')',
            });
        @endif
    </script>
    <script>
        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById(previewId);
                    preview.src = e.target.result; // Actualiza la imagen con la nueva URL
                };
                reader.readAsDataURL(input.files[0]); // Lee el archivo como una URL de datos
            }
        }
    </script>    
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
