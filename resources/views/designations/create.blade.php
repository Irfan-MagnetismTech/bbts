@extends('layouts.backend-layout')
@section('title', 'Designations')

@section('breadcrumb-title', 'Designations')

@section('breadcrumb-button')
{{--    <a href="{{ route('designations.index')}}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>--}}
@endsection

@section('sub-title')
    {{--<span class="text-danger">*</span> Marked are required.--}}
@endsection
@section('content')
    {{-- @can('designation-create') --}}
        @if($formType == 'edit')
            {!! Form::open(array('url' => "dataencoding/designations/$designation->id",'method' => 'PUT')) !!}
        @else
            {!! Form::open(array('url' => "dataencoding/designations",'method' => 'POST')) !!}
        @endif
        <div class="row">
            <div class="col-md-5 pr-md-1 my-1 my-md-0">
                {{Form::text('name', old('name') ? old('name') : (!empty($designation->name) ? $designation->name : null),['class' => 'form-control form-control-sm','id' => 'name', 'placeholder' => 'Enter Designation Name', 'autocomplete'=>"off"] )}}
            </div>
            <div class="col-md-2 pl-md-1 my-1 my-md-0">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success btn-sm btn-block">Submit</button>
                </div>
            </div>
        </div><!-- end form row -->

        {!! Form::close() !!}
    {{-- @endcan --}}
        <hr class="my-2 bg-success">
        <div class="table-responsive">
            <table id="dataTable" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>Designation</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>SL</th>
                    <th>Designation</th>
                    <th>Action</th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($designations as $key => $data)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td class="text-left">{{$data->name}}</td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    {{-- @can('designation-edit') --}}
                                        <a href="{{ url("dataencoding/designations/$data->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                    {{-- @endcan --}}
                                    {{-- @can('designation-delete') --}}
                                        {!! Form::open(array('url' => "dataencoding/designations/$data->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
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
