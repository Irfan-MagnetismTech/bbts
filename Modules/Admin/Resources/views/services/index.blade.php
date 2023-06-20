@extends('layouts.backend-layout')
@section('title', 'Services')

@section('breadcrumb-title')
    List of Services
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('services.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-plus"></i></a>
@endsection

@section('content')

    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Reference No</th>
                    <th>BBTS LINK ID</th>
                    <th>Service Type</th>
                    <th>Service Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>Reference No</th>
                    <th>BBTS LINK ID</th>
                    <th>Service Type</th>
                    <th>Service Status</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach (@$services as $key => $data)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $data->reference }}</td>
                        <td>{{ $data->bbts_link_id }}</td>
                        <td>{{ $data->service_type }}</td>
                        <td>{{ $data->service_status }}</td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ url("admin/services/$data->id/edit") }}" data-toggle="tooltip" title="Edit"
                                        class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                    {{-- <a href="{{ route('services.show', $data->id) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a> --}}
                                    {!! Form::open([
                                        'url' => "admin/services/$data->id",
                                        'method' => 'delete',
                                        'class' => 'd-inline',
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Delete',
                                    ]) !!}
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
