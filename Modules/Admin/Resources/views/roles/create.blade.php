@extends('layouts.backend-layout')
@section('title', 'Permission')

@section('breadcrumb-title')
    @if ($formType == 'edit')
        Edit
    @else
        Create
    @endif
    Role
@endsection

@section('style')
    <style>
        .input-group-addon {
            // min-width: 110px;
        }
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('roles.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection
@section('content')

    @if ($formType == 'edit')
        {!! Form::open(['url' => "admin/roles/$role->id", 'method' => 'PUT', 'class' => 'custom-form']) !!}
    @else
        {!! Form::open(['url' => 'admin/roles', 'method' => 'POST', 'class' => 'custom-form']) !!}
    @endif



    <div class="row">
        <div class="col-12 my-1">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon"> Role Name <span class="text-danger">*</span></label>
                {{ Form::text('name', old('name') ? old('name') : (!empty($role->name) ? $role->name : null), ['class' => 'form-control', 'id' => 'name', 'placeholder' => '']) }}
            </div>
        </div>
        <div class="col-12 my-1">
            <label class="col-12 px-0"> <strong>Permissions</strong> <span class="text-danger">*</span></label>
            <div class="input-group input-group-sm input-group-primary">
                <div class="border-checkbox-section col-12">
                    <div class="row">
                        @foreach ($permissions as $permission)
                            <div class="col-3">
                                <div class="border-checkbox-group border-checkbox-group-primary">
                                    <input class="border-checkbox" type="checkbox" name="permission[]"
                                        id="{{ $permission->name }}" value="{{ $permission->name }}"
                                        {{ !empty($role) && in_array($permission->id, $role->permissions->pluck('id')->toArray()) ? 'checked' : null }} />
                                    <label class="border-checkbox-label"
                                        for="{{ $permission->name }}">{{ $permission->name }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div> <!-- end row -->
                </div> <!-- end border-checkbox-section -->
            </div>
        </div>
    </div><!-- end row -->
    <div class="row">
        <div class="offset-md-4 col-md-4 mt-2">
            <div class="input-group input-group-sm ">
                <button class="btn btn-success btn-round btn-block py-2">Submit</button>
            </div>
        </div>
    </div> <!-- end row -->
    {!! Form::close() !!}
@endsection
