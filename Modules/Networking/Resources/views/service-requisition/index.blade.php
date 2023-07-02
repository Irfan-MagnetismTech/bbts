@extends('layouts.backend-layout')
@section('title', 'ERR')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of ERR
@endsection


@section('breadcrumb-button')
    <a href="{{ route('errs.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($datas) }} 
    <x-warning-paragraph name="ERR" />
@endsection

@section('content')
    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Type</th>
                    <th>From Pop</th>
                    <th>To Pop</th>
                    <th>Capacity Type</th>
                    <th>Capacity</th>
                    <th>Client</th>
                    <th>Date</th>
                    <th>Required Date</th>
                    <th>Vendor</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datas as $key => $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->type }}</td>
                        <td>{{ $item->fromPop->name }}</td>
                        <td>{{ $item->toPop->name }}</td>
                        <td>{{ $item->capacity_type }}</td>
                        <td>{{ $item->capacity }}</td>
                        <td>{{ $item->client->client_name }}</td>
                        <td>{{ $item->date }}</td>
                        <td>{{ $item->required_date }}</td>
                        <td>{{ $item->vendor->name }}</td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                        <a href="{{ route('service-requisitions.edit', $item->id) }}" data-toggle="tooltip" title="Edit"
                                            class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                        {!! Form::open([
                                            'url' => route('service-requisitions.destroy', $item->id),
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
    <script>
        $(document).ready(function() {});
    </script>
@endsection
