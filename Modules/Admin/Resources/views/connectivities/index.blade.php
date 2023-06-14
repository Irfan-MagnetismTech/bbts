@extends('layouts.backend-layout')
@section('title', 'link')

@section('breadcrumb-title')
   List of  Link
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('connectivity.create')}}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-plus"></i></a>
@endsection

@section('content')
<div class="table-responsive">
    <table id="dataTable" class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>SL</th>
            <th>BBTS Link Id</th>
            <th>From</th>
            <th>To</th>
            <th>Action</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>SL</th>
            <th>BBTS Link Id</th>
            <th>From</th>
            <th>To</th>
            <th>Action</th>
        </tr>
        </tfoot>
        <tbody>
        @foreach(@$datas as $key => $data)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td class="text-center">{{$data->bbts_link_id}}</td>
                <td class="text-center">{{$data->from_location}}</td>
                <td class="text-center">{{$data->to_location}}</td>
                <td>
                    <div class="icon-btn">
                        <nobr>
                            <a href="{{ url("admin/connectivity/$data->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                            {!! Form::open(array('url' => "admin/connectivity/$data->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
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
