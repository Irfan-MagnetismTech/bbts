@extends('layouts.backend-layout')
@section('title', 'User')

@section('breadcrumb-title')
    @if ($formType == 'edit')
        Edit
    @else
        Create
    @endif
    User Info
@endsection

@section('style')
    <style>
        .input-group-addon {
            min-width: 120px;
        }

        .input-group-info .input-group-addon {
            /*background-color: #04748a!important;*/
        }
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('users.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
    @if ($formType == 'create')
        {!! Form::open(['url' => 'admin/users', 'method' => 'POST', 'class' => 'custom-form']) !!}
    @else
        {!! Form::open(['url' => "admin/users/$user->id", 'method' => 'PUT', 'class' => 'custom-form']) !!}
    @endif
    <div class="row">
        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="name">Department</label>
                {{ Form::select('department_id', $departments, old('department_id') ? old('department_id') : (!empty($user->employee) ? $user->employee->department_id : null), ['class' => 'form-control select2', 'id' => 'department_id', 'placeholder' => 'Select Department']) }}
                @error('department_id')
                    <p class="text-danger">{{ $errors->first('department_id') }}</p>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="name">Employee</label>
                {{ Form::select('employee_id', $employees, old('employee_id') ? old('employee_id') : (!empty($user) ? $user->employee_id : null), ['class' => 'form-control select2', 'id' => 'employee_id', 'placeholder' => 'Select Name', 'onchange' => 'getEmployeeInfo(this)']) }}
            </div>
        </div>
        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="name">User Name <span class="text-danger">*</span></label>
                {{ Form::text('name', old('name') ? old('name') : (!empty($user->name) ? $user->name : null), ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Enter User Name Here', 'required']) }}
                @error('name')
                    <p class="text-danger">{{ $errors->first('name') }}</p>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="name">User Email<span class="text-danger">*</span></label>
                {{ Form::text('email', old('email') ? old('email') : (!empty($user->email) ? $user->email : null), ['class' => 'form-control', 'id' => 'email', 'placeholder' => 'Enter User email Here', 'required']) }}
                @error('email')
                    <p class="text-danger">{{ $errors->first('email') }}</p>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="name">Password<span class="text-danger">*</span></label>
                {{ Form::password('password', ['class' => 'form-control', 'id' => 'password', 'placeholder' => 'Enter User password Here', empty($user) ? 'required' : '']) }}
                @error('password')
                    <p class="text-danger">{{ $errors->first('password') }}</p>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="name">Conf. Pass<span class="text-danger">*</span></label>
                {{ Form::password('confirm-password', ['class' => 'form-control', 'id' => 'confirm-password', 'placeholder' => 'Enter User password Here', empty($user) ? 'required' : '']) }}
                @error('confirm-password')
                    <p class="text-danger">{{ $errors->first('confirm-password') }}</p>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="name">User Role<span class="text-danger">*</span></label>
                {{ Form::select('role', $roles, old('role') ? old('role') : (!empty($user) ? $user->roles : null), ['class' => 'form-control', 'id' => 'role', 'placeholder' => 'Select User Role', 'required']) }}
                @error('role')
                    <p class="text-danger">{{ $errors->first('role') }}</p>
                @enderror
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
@section('script')
    <script>
        function getEmployeeInfo(employeeid) {
            let eid = $(employeeid).val();
            let url = '{{ url('employeeAutoComplete') }}/' + eid;
            fetch(url)
                .then((resp) => resp.json())
                .then(function(einfo) {
                    $("#name").val(einfo.fname + ' ' + einfo.lname);
                    $("#email").val(einfo.email);
                })
                .catch(function() {});
        }

        function getDepartmentEmployee() {
            let dropdown = $('#employee_id');
            dropdown.empty();
            dropdown.append('<option selected="true" disabled>Select Name</option>');
            dropdown.prop('selectedIndex', 0);
            const url = '{{ url('getDepartmentEmployee') }}/' + $("#department_id").val();
            // Populate dropdown with list of provinces
            $.getJSON(url, function(employee) {
                $.each(employee, function(key, entry) {
                    dropdown.append($('<option></option>').attr('value', key).text(entry));
                })
            });
        }

        $(function() {
            getDepartmentEmployee();
            $("#department_id").on('change', function() {
                getDepartmentEmployee();
            });

        }); //document.ready



        }
    </script>

@endsection
