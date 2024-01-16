@extends('layouts.backend-layout')
@section('title', 'Costing List')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    Costing List
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    {{-- <a href="{{ route('connectivity-requirement.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-plus"></i></a> --}}
@endsection
@section('sub-title')
    Total: {{ count($inactive_requests) }}
@endsection


@section('content')
    <form action="" method="get" class="my-4">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="date_from" class="font-weight-bold">From Date:</label>
                    <input type="text" class="form-control date" id="from_date" name="from_date"
                        aria-describedby="from_date" value="{{ old('from_date') ?? (request()?->from_date ?? null) }}"
                        readonly>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="date_to" class="font-weight-bold">To Date:</label>
                    <input type="text" class="form-control date" id="to_date" name="to_date" aria-describedby="date_to"
                        value="{{ old('to_date') ?? (request()?->to_date ?? null) }}" readonly>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group my-4 row">
                    <div class="col-md-6">
                        <input type="button" onclick="resetForm()" value="Reset"
                            class="btn btn-outline-warning btn-sm col-12">
                    </div>
                    <div class="col-md-6">
                        <input type="submit" value="Search" class="btn btn-outline-primary btn-sm col-12">
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#SL</th>
                    <th>Client Name</th>
                    <th>Client No</th>
                    <th>Address</th>
                    <th>MQ No</th>
                    <th>FR No</th>
                    <th>Connectivity Point</th>
                    <th>Request Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#SL</th>
                    <th>Client Name</th>
                    <th>Client No</th>
                    <th>Address</th>
                    <th>MQ No</th>
                    <th>FR No</th>
                    <th>Connectivity Point</th>
                    <th>Request Date</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($inactive_requests as $key => $inactive_request)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $inactive_request->client->client_name }}</td>
                        <td>{{ $inactive_request->client_no }}</td>
                        <td>{{ $inactive_request->client->location }}</td>
                        <td>{{ $inactive_request->feasibilityRequirementDetail->feasibilityRequirement->mq_no }}</td>
                        <td>{{ $inactive_request->fr_no }} </td>
                        <td>{{ $inactive_request->feasibilityRequirementDetail->connectivity_point }}</td>
                        <td>{{ $inactive_request->created_at->format('d-m-Y') }}</td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ url("networking/modify-connectivities/create/$inactive_request->fr_no") }}"
                                        class="text-white" target="_blank">Commissioning</a>
                                </nobr>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
