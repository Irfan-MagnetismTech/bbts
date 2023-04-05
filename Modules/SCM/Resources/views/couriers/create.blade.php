@extends('layouts.backend-layout')
@section('title', 'Couriers')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title', 'Couriers')

@section('breadcrumb-button')
@endsection

@section('sub-title')
@endsection
@section('content')
    @if ($formType == 'edit')
        {!! Form::open(['url' => "scm/couriers/$courier->id", 'method' => 'PUT']) !!}
        <input type="hidden" name="id"
            value="{{ old('id') ? old('id') : (!empty($courier->id) ? $courier->id : null) }}">
    @else
        {!! Form::open(['url' => 'scm/couriers', 'method' => 'POST']) !!}
    @endif
    <div class="row">
        <div class="col-md-5 pr-md-1 my-1 my-md-0">
            {{ Form::text('name', old('name') ? old('name') : (!empty($courier->name) ? $courier->name : null), ['class' => 'form-control form-control-sm', 'id' => 'name', 'placeholder' => 'Enter Courier Name', 'autocomplete' => 'off']) }}
        </div>

        <div class="col-md-5 pr-md-1 my-1 my-md-0">
            {{ Form::text('address', old('address') ? old('address') : (!empty($courier->address) ? $courier->address : null), ['class' => 'form-control form-control-sm', 'id' => 'address', 'placeholder' => 'Enter Courier Name', 'autocomplete' => 'off']) }}
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
                    <th>Courier Name</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>Courier Name</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($couriers as $key => $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-center">{{ $data->name }}</td>
                        <td class="text-center">{{ $data->address }}</td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ url("scm/couriers/$data->id/edit") }}" data-toggle="tooltip"
                                        title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                    {!! Form::open([
                                        'url' => "scm/couriers/$data->id",
                                        'method' => 'delete',
                                        'class' => 'd-inline',
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Delete',
                                    ]) !!}
                                    {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete']) }}
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
