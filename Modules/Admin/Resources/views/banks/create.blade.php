@extends('layouts.backend-layout')
@section('title', 'Banks')
 
@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title', "Banks")

@section('breadcrumb-button')
@endsection

@section('sub-title') 
@endsection
@section('content')
        @if($formType == 'edit')
            {!! Form::open(array('url' => "admin/banks/$bank->id",'method' => 'PUT')) !!}
            <input type="hidden" name="id" value="{{old('id') ? old('id') : (!empty($bank->id) ? $bank->id : null)}}">

        @else
            {!! Form::open(array('url' => "admin/banks",'method' => 'POST')) !!}
        @endif
        <div class="row">
            <div class="col-md-5 pr-md-1 my-1 my-md-0">
                {{Form::text('name', old('name') ? old('name') : (!empty($bank->name) ? $bank->name : null),['class' => 'form-control form-control-sm','id' => 'name', 'placeholder' => 'Enter Bank Name', 'autocomplete'=>"off"] )}}
            </div>
            <div class="col-md-2 pl-md-1 my-1 my-md-0">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success btn-sm btn-block">Submit</button>
                </div>
            </div>
        </div><!-- end form row -->

        {!! Form::close() !!}
        <hr class="my-2 bg-success">
        <div class="table-responsive">
            <table id="dataTable" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>Bank Name</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>SL</th>
                    <th>Bank Name</th>
                    <th>Action</th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($banks as $key => $data)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td class="text-center">{{$data->name}}</td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ url("admin/banks/$data->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                    {!! Form::open(array('url' => "admin/banks/$data->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                    {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
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


@section('script')
@endsection

