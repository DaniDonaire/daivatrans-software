@extends('layouts.master')
@section('title')
    @lang('users.basic_elements')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('users.breadcrumb')
        @endslot
        @slot('title')
            @lang('users.basic_elements')
        @endslot
    @endcomponent

<form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-xxl-3">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">@lang('users.create_avatar')</h4>
                </div>
                <div class="card-body p-4">
                    <div class="text-center">
                        <div class="profile-user position-relative d-inline-block mx-auto my-4">
                            <div class="profile-user position-relative d-inline-block mx-auto ">
                                <img src="{{ URL::asset('build/images/users/avatar-1.jpg') }}"
                                    class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="User profile">
                                <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                    <input id="profile-img-file-input" type="file" class="profile-img-file-input" accept="image/*">
                                    <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                        <span class="avatar-title rounded-circle bg-light text-body">
                                            <i class="ri-camera-fill"></i>
                                        </span>
                                    </label>
                                    <input type="file" name="avatar" id="hidden-avatar-input" style="display: none;">
                                </div>
                            </div>
                            <span class="text-danger">{{ $errors->first('avatar') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>                 
        <div class="col-xxl-9">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">@lang('users.create_user')</h4>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="live-preview">
                        <div class="row gy-4">
                            <!-- Campo de Nombre -->
                            <div class="col-xxl-6 col-md-6">
                                <div>
                                    <label for="nombre" class="form-label">@lang('users.name')</label>
                                    <input type="text" class="form-control" id="nombre" placeholder="@lang('users.name') *" name="nombre" value="{{ old('nombre') }}">
                                    <span class="text-danger">{{ $errors->first('nombre') }}</span>
                                </div>
                            </div>

                            <!-- Campo de Email -->
                            <div class="col-xxl-6 col-md-6">
                                <div>
                                    <label for="email" class="form-label">@lang('users.email')</label>
                                    <div class="form-icon">
                                        <input type="email" class="form-control form-control-icon" id="email"
                                            placeholder="@lang('users.email') *" name="email" value="{{ old('email') }}">
                                        <i class="ri-mail-unread-line"></i>
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Campo de Contraseña -->
                            <div class="col-xxl-6 col-md-6">
                                <div>
                                    <label for="password" class="form-label">@lang('users.password')</label>
                                    <div class="input-group mb-3">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="@lang('users.password') *">
                                        <button class="btn btn-outline-success" type="button" id="show-password" onclick="togglePasswordVisibility()">
                                            <i id="icon-password" class="bx bx-show"></i>
                                        </button>
                                    </div>
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                </div>
                            </div>

                            <!-- Campo de Confirmar Contraseña -->
                            <div class="col-xxl-6 col-md-6">
                                <div>
                                    <label for="password-confirm" class="form-label">@lang('users.confirm_password')</label>
                                    <input type="password" class="form-control" id="password-confirm" name="password_confirmation" placeholder="@lang('users.confirm_password') *">
                                    <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                </div>
                            </div>

                            <!-- Selector de Roles -->
                            <div class="col-xxl-6 col-md-6">
                                <div>
                                    <label for="roles" class="form-label">@lang('users.role')</label>
                                    <select name="roles" id="roles" class="form-select">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}" 
                                                {{ old('roles') == $role->name ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">{{ $errors->first('roles') }}</span>
                                </div>
                            </div>                            

                            <!-- Botón de Enviar -->
                            <div class="col-lg-12">
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">@lang('users.submit')</button>
                                </div>
                            </div>
                        </div>
                        <!--end row-->
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
    </div>
</form>
@endsection
@section('script')
    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("password");
            var passwordConfirmInput = document.getElementById("password-confirm");
            var showPasswordButton = document.getElementById("show-password");
            var icon = showPasswordButton.querySelector("i"); // Busca el ícono dentro del botón

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                passwordConfirmInput.type = "text"; 
                
                icon.classList.remove("bx-show");
                showPasswordButton.classList.remove("btn-outline-success");
                icon.classList.add("bxs-hide");
                showPasswordButton.classList.add("btn-outline-danger");
            } else {
                passwordInput.type = "password";
                passwordConfirmInput.type = "password";
                icon.classList.add("bx-show");
                showPasswordButton.classList.add("btn-outline-success");
                icon.classList.remove("bxs-hide");
                showPasswordButton.classList.remove("btn-outline-danger");

            }
        }
    
    </script>
    <script>
        document.getElementById('profile-img-file-input').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const hiddenInput = document.getElementById('hidden-avatar-input');
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                hiddenInput.files = dataTransfer.files;
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.querySelector('.user-profile-image').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
    <script>
        @if (session('sweetalert'))
            Swal.fire({
                title: "{{ session('sweetalert.title') }}",
                text: "{{ session('sweetalert.text') }}",
                icon: "{{ session('sweetalert.type') }}",
                confirmButtonText: "@lang('users.accept')",
            });
        @endif
    </script>

    <script src="{{ URL::asset('build/libs/prismjs/prismjs.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/profile-setting.init.js') }}"></script>
    
@endsection

