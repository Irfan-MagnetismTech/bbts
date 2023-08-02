@extends('layouts.backend-layout')
@section('title', 'Client Connectivities')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">

    <style>
        .checkbox-fade .cr {
            height: 10px;
            width: 10px;
        }

        .noWrapStyle {
            white-space: normal;
            min-width: 12rem;
        }
    </style>
@endsection

@section('breadcrumb-title')
    Client Connectivities
@endsection


@section('breadcrumb-button')
    <a href="{{ route('physical-connectivities.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i
            class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($salesDetails) }}
@endsection

@section('content')
    <!-- put search form here -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Client Name</th>
                    <th>FR No</th>
                    <th>Connectivity Point</th>
                    <th>New/Existing</th>
                    <th>Delivery Date</th>
                    <th>Commissioning Date</th> 
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($salesDetails as $key => $details)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $details->client->client_name }}</td>
                        <td>{{ $details->fr_no }}</td>
                        <td class="noWrapStyle">{{ $details->frDetails->connectivity_point }}</td>
                        <td></td>
                        <td>{{ $details->delivery_date }}</td>
                        <td></td>   
                        <td>
                            <span class="badge badge-info">
                                <a href="{{ url("networking/connectivities/create/$details->fr_no") }}"
                                    class="text-white" target="_blank">Details</a>
                            </span> 
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