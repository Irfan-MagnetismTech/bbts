@extends('layouts.backend-layout')
@section('title', 'Active Clients Report')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    Active Clients Report
@endsection

@section('style')
    <style>
    </style>
@endsection

@section('content')
    <form
        action="{{ url("scm/scm-material-stock-report") }}"
        method="get" class="custom-form">
        @csrf
        <div class="dt-responsive table-responsive">
            <table id="dataTable" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Client</th>
                    <th>Connectivity Point</th>
                    <th>Products</th>
                    <th>Thana</th>
                    <th>Branch</th>
                    <th>Contact Person</th>
                    <th>Contact Number</th>
                    <th>Commission Date</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($activations as $activationKey => $activation)
                    <tr>
                        <td>{{ $activation->client->client_name ?? ''}}</td>

                        <td>{{ $activation->frDetails->connectivity_point ?? ''}}
                            ({{$activation->frDetails->fr_no ?? ''}})
                        </td>
                        <td>
                            @foreach ($products as $product)
                                {{ $product ?? '' }}
                                @unless($loop->last)
                                    ,
                                @endunless
                            @endforeach
                        </td>
                        <td>{{ $activation->client->thana->name ?? ''}}</td>
                        <td>{{ $activation->client->branch->name ?? ''}}</td>
                        <td>{{ $activation->client->contact_person ?? ''}}</td>
                        <td>{{ $activation->client->contact_no ?? ''}}</td>
                        <td>{{ $activation->connectivities->commissioning_date ?? '' }}</td>

                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ route('active-clients-report-details', $activation->fr_no) }}"
                                       data-toggle="tooltip" title="Details" class="btn btn-outline-primary"><i
                                            class="fas fa-eye"></i></a>
                                </nobr>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </form>
@endsection

