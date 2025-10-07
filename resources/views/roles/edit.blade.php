@extends('layouts.master')

@section('title')
    @lang('roles.edit_role')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('roles.breadcrumb')
        @endslot
        @slot('title')
            @lang('roles.edit_role')
        @endslot
    @endcomponent

    <form action="{{ route('roles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header bg-light border-bottom">
                        <h4 class="card-title mb-0 text-primary">@lang('roles.edit_role'): {{ $role->name }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <!-- Campo de Nombre del Rol -->
                            <div class="col-md-6">
                                <label for="name" class="form-label text-primary">@lang('roles.role_name')</label>
                                <input type="text" name="name" id="name" class="form-control border-primary" value="{{ old('name', $role->name) }}" required>
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            </div>

                            <!-- Selector de Permisos -->
                            <div class="col-lg-12">
                                <label for="permissions" class="form-label text-primary">@lang('roles.permissions')</label>
                                <div class="row g-3">
                                    @php
                                        $groupedPermissions = $permissions->groupBy(function($permission) {
                                            return explode('_', $permission->name)[0]; // Agrupar por prefijo
                                        });
                                    @endphp

                                    @foreach ($groupedPermissions as $group => $groupPermissions)
                                        <div class="col-lg-6">
                                            <div class="card border-primary mb-3">
                                                <div class="card-header bg-primary text-white">{{ ucfirst($group) }}</div>
                                                <div class="card-body">
                                                    @foreach ($groupPermissions as $permission)
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission{{ $permission->id }}"
                                                                {{ in_array($permission->id, old('permissions', $rolePermissions)) ? 'checked' : '' }}>
                                                            <label for="permission{{ $permission->id }}" class="form-check-label">
                                                                <strong>{{ __('permissions.'.$permission->name.'.display_name') }}</strong><br>
                                                                <small class="text-muted">{{ __('permissions.'.$permission->name.'.description') }}</small>
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Botón de Actualizar -->
                            <div class="col-lg-12 text-end">
                                <button type="submit" class="btn btn-primary">@lang('roles.update')</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script src="{{ URL::asset('build/libs/prismjs/prismjs.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
