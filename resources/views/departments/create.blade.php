@extends('layouts.backend-layout')
@section('title', 'Departments')

@section('breadcrumb-title', 'Departments')

@section('breadcrumb-button')
{{--    <a href="{{ route('departments.index')}}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>--}}
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection
@section('content')
    {{-- @can('department-create') --}}
        @if(!empty($department))
            {!! Form::open(array('url' => "dataencoding/departments/$department->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
        @else
            {!! Form::open(array('url' => "dataencoding/departments",'method' => 'POST', 'class'=>'custom-form')) !!}
        @endif

        <div class="row">
            <div class="col-md-5 pr-md-1 my-1 my-md-0">
                {{Form::text('name', old('name') ? old('name') : (!empty($department->name) ? $department->name : null),['class' => 'form-control form-control-sm','id' => 'name', 'placeholder' => 'Enter Department Name', 'autocomplete'=>"off"] )}}
                <input type="hidden" name="id" value="{{old('id') ? old('id') : (!empty($department->id) ? $department->id : null)}}">
            </div>
            <div class="col-md-2 pl-md-1 my-1 my-md-0">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success btn-sm btn-block">Submit</button>
                </div>
            </div>
        </div><!-- end form row -->
        {!! Form::close() !!}
    {{-- @endcan --}}
        <br>
        <hr class="my-2 bg-success">
        <div class="table-responsive">
            <table id="dataTable" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>Department Name</th>
                    <th>Employees</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>SL</th>
                    <th>Department Name</th>
                    <th>Employees</th>
                    <th>Action</th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($departments as $key => $data)
                    <tr>
                        <td>{{$key  + $departments->firstItem()}}</td>
                        <td class="text-left">{{$data->name}}</td>
                        <td>
                            {{$data->employees_count}}
                        </td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    {{-- @can('department-edit') --}}
                                        <a href="{{ url("dataencoding/departments/$data->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                    {{-- @endcan --}}
                                    {{-- @can('department-delete') --}}
                                        {!! Form::open(array('url' => "dataencoding/departments/$data->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                        {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                    {{-- @endcan --}}
                                        {!! Form::close() !!}
                                </nobr>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
@endsection
