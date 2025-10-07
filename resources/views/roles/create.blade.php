@extends('layouts.master')
@section('title')
    @lang('roles.create_role')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            @lang('roles.breadcrumb')
        @endslot
        @slot('title')
            @lang('roles.create_role')
        @endslot
    @endcomponent

    <form action="{{ route('roles.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">@lang('roles.new_role')</h4>
                    </div>
                    <div class="card-body">
                        <div class="row gy-4">
                            <!-- Campo de Nombre del Rol -->
                            <div class="col-md-6">
                                <label for="name" class="form-label">@lang('roles.role_name')</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            </div>
                            
                            <!-- Selector de Permisos -->
                            <div class="col-lg-12">
                                <label for="permissions" class="form-label">@lang('roles.permissions')</label>
                                <div>
                                    @foreach ($permissions as $permission)
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" role="switch" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission{{ $permission->id }}"
                                                {{ is_array(old('permissions')) && in_array($permission->id, old('permissions')) ? 'checked' : '' }}>
                                            <label for="permission{{ $permission->id }}" class="form-check-label">
                                                <strong>{{ $permission->display_name }}</strong> <br>
                                                <small class="text-muted">{{ $permission->description }}</small>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Botón de Guardar -->
                            <div class="col-lg-12 text-end">
                                <button type="submit" class="btn btn-primary">@lang('roles.save')</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('script')
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
