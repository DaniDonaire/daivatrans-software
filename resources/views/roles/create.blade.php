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
                    <div class="card-header bg-light border-bottom">
                        <h4 class="card-title mb-0">@lang('roles.new_role')</h4>
                    </div>
                    <div class="card-body">
                        <div class="row gy-4">
                            <!-- Campo de Nombre del Rol -->
                            <div class="col-md-6">
                                <label for="name" class="form-label">@lang('roles.role_name')</label>
                                <input type="text" name="name" id="name" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Selector de Permisos -->
                            <div class="col-lg-12">
                                <label class="form-label">@lang('roles.permissions')</label>
                                <div class="table-responsive">
                                    <table class="table table-nowrap mb-0">
                                        <tbody>
                                            @foreach($permissions as $permission)
                                                <tr>
                                                    <td style="width: 50px;">
                                                        <div class="form-check">
                                                            <input class="form-check-input" 
                                                                   type="checkbox" 
                                                                   name="permissions[]"
                                                                   id="permission{{ $permission->id }}"
                                                                   value="{{ $permission->id }}"
                                                                   {{ is_array(old('permissions')) && in_array($permission->id, old('permissions')) ? 'checked' : '' }}>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <label class="form-check-label" for="permission{{ $permission->id }}">
                                                            @lang("permissions.{$permission->name}.display_name")
                                                        </label>
                                                        <br>
                                                        <small class="text-muted">
                                                            @lang("permissions.{$permission->name}.description")
                                                        </small>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Botones -->
                            <div class="col-lg-12 text-end">
                                <a href="{{ route('roles.index') }}" class="btn btn-secondary me-2">@lang('roles.cancel')</a>
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
    <script src="{{ URL::asset('build/libs/prismjs/prismjs.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
