@extends('layouts.backend-layout')
@section('title', 'Pyhsical Connectivity')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Pyhsical Connectivity
@endsection


@section('breadcrumb-button')
    <a href="{{ route('physical-connectivities.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($physicalConnectivities) }} 
@endsection

@section('content')
    <!-- put search form here -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>FR No</th>
                    <th>Client Name</th>                    
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($physicalConnectivities as $key => $physicalConnectivitie)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $physicalConnectivitie->fr_no }}</td>
                        <td>{{ $physicalConnectivitie->client->client_name }}</td>
                        
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ route('physical-connectivities.show', $physicalConnectivitie->id) }}" data-toggle="tooltip" title="Show"
                                        class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                    
                                        <a href="{{ route('physical-connectivities.edit', $physicalConnectivitie->id) }}" data-toggle="tooltip" title="Edit"
                                            class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                        {!! Form::open([
                                            'url' => route('physical-connectivities.destroy', $physicalConnectivitie->id),
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
