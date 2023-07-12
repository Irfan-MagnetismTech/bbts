@extends('layouts.backend-layout')
@section('title', 'VAS Service')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of VAS Service
@endsection


@section('breadcrumb-button')
    <a href="{{ route('vas-services.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($datas) }} 
@endsection

@section('content')
    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Client</th>
                    <th>Vendor</th>
                    <th>FR NO</th>
                    <th>Refercnce No</th>
                    <th>Date</th>
                    <th>Required Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datas as $key => $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->client->client_name }}</td>
                        <td>{{ $item->vendor->name }}</td>
                        <td>{{ $item->fr_no }}</td>
                        <td>{{ $item->reference_no }}</td>
                        <td>{{ $item->date }}</td>
                        <td>{{ $item->required_date }}</td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                        <a href="{{ route('vas-services.edit', $item->id) }}" data-toggle="tooltip" title="Edit"
                                            class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                        {!! Form::open([
                                            'url' => route('vas-services.destroy', $item->id),
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
    </script>
@endsection
