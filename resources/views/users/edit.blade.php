@extends('layouts.master')
@section('title')
    @lang('profile.title')
@endsection
@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            @lang('profile.success')
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            @lang('profile.error')
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="position-relative mx-n4 mt-n4">
        <div class="profile-wid-bg profile-setting-img">
            <div class="overlay-content">
                <div class="text-end p-3">
                    <span class="sr-only">@lang('profile.user_profile')</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xxl-3">
            <div class="card mt-n5">
                <div class="card-body p-4">
                    <div class="text-center">
                        <div class="profile-user position-relative d-inline-block mx-auto mb-4">
                            <img src="@if ($user->avatar) {{ URL::asset('storage/' . $user->avatar) }} @else {{ URL::asset('build/images/users/avatar-1.jpg') }} @endif"
                                class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="@lang('profile.profile_picture')">
                            <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                <input id="profile-img-file-input" type="file" class="profile-img-file-input" accept="image/*">
                                <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                    <span class="avatar-title rounded-circle bg-light text-body">
                                        <i class="ri-camera-fill"></i>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <h5 class="fs-17 mb-1">{{ $user->name }}</h5>
                        <p class="text-muted mb-0">{{ $user->email }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-9">
            <div class="card mt-xxl-n5">
                <div class="card-header">
                    <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                <i class="fas fa-home"></i>
                                @lang('profile.personal_details')
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab">
                                <i class="far fa-user"></i>
                                @lang('profile.change_password')
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-4">
                    <div class="tab-content">
                        <div class="tab-pane active" id="personalDetails" role="tabpanel">
                            <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row g-2">
                                    <div class="col-lg-4">
                                        <label for="name" class="form-label">@lang('profile.name')</label>
                                        <input type="text" name="name" class="form-control" id="name"
                                            placeholder="@lang('profile.name')" value="{{ $user->name }}">
                                    </div>

                                    <div class="col-lg-4">
                                        <label for="emailInput" class="form-label">@lang('profile.email')</label>
                                        <input type="email" name="email" class="form-control" id="emailInput"
                                            placeholder="@lang('profile.email')" value="{{ $user->email }}">
                                    </div>

                                    @if($canEditRoles)
                                        <div class="col-lg-4">
                                            <label for="role" class="form-label">@lang('profile.role')</label>
                                            <select name="role" id="role" class="form-select">
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->name }}" 
                                                        {{ $user->roles->first()->name === $role->name ? 'selected' : '' }}>
                                                        {{ $role->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @else
                                        <div class="col-lg-4">
                                            <label for="role" class="form-label">@lang('profile.role')</label>
                                            <input type="text" class="form-control" value="{{ $user->roles->first()->name }}" disabled>
                                        </div>
                                    @endif

                                    <input type="file" name="avatar" id="hidden-avatar-input" style="display: none;">

                                    <div class="col-lg-12 text-end">
                                        <button type="submit" class="btn btn-primary">@lang('profile.update_profile')</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane" id="changePassword" role="tabpanel">
                            <form action="{{ route('users.update-password', $user->id) }}" method="POST">
                                @csrf
                                <div class="row g-2">
                                    @if($currentUser->id === $user->id && !$currentUser->can('users.edit.all'))
                                        <div class="col-lg-4">
                                            <label for="currentPassword" class="form-label">@lang('profile.current_password')</label>
                                            <input type="password" name="current_password" class="form-control" id="currentPassword" required>
                                        </div>
                                    @endif

                                    <div class="col-lg-4">
                                        <label for="newPassword" class="form-label">@lang('profile.new_password')</label>
                                        <input type="password" name="password" class="form-control" id="newPassword" required>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="confirmPassword" class="form-label">@lang('profile.confirm_password')</label>
                                        <input type="password" name="password_confirmation" class="form-control" id="confirmPassword" required>
                                    </div>

                                    <div class="col-lg-12 text-end">
                                        <button type="submit" class="btn btn-primary">@lang('profile.update_password')</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
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
                confirmButtonText: '@lang('users.accept')',
            });
        @endif
    </script>
    <script src="{{ URL::asset('build/js/pages/profile-setting.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
