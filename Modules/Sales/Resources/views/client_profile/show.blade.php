@extends('layouts.backend-layout')
@section('title', 'Client')

@section('breadcrumb-title')
    Client Information
@endsection

@section('breadcrumb-button')
    <a href="{{ route('client-profile.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('style')
    <style>
        .table_header{
            background-color:#057097!important;
            font-size: 12px;
            color: white;
            font-size: 14px;
        }
        .table_header_td{
            background-color: #ecf4f7;
            text-align: left;
            border: 1px solid rgb(205, 207, 208) !important
        }
    </style>
@endsection

@section('content-grid', null)
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <!-- table  -->
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered" style="">
                                <tr class="table_header">
                                    <td colspan="4" style="text-align: center" style=""><b>Client Information</b></td>
                                </tr>
                                <tr>
                                    <td class="table_header_td">Client Name</td>
                                    <td><b>{{ $client->client_name ?? '' }}</b></td>
                                    <td class="table_header_td">Client Type</td>
                                    <td><b>{{ $client->client_type ?? '' }}</b></td>
                                </tr>
                                <tr>
                                    <td class="table_header_td">Registration No</td>
                                    <td><b>{{ $client->reg_no ?? '' }}</b></td>
                                    <td class="table_header_td">Business Type</td>
                                    <td><b>{{ $client->business_type ?? '' }}</b></td>
                                </tr>
                                <tr>
                                    <td class="table_header_td">Thana</td>
                                    <td><b>{{ $client->thana->name ?? '' }}</b></td>
                                    <td class="table_header_td">District</td>
                                    <td><b>{{ $client->district->name ?? '' }}</b></td>
                                </tr>
                                <tr>
                                    <td class="table_header_td">Division</td>
                                    <td><b>{{ $client->division->name ?? '' }}</b></td>
                                    <td class="table_header_td">Location</td>
                                    <td><b>{{ $client->location ?? '' }}</b></td>
                                </tr>
                                <tr>
                                    <td class="table_header_td">Contact Person</td>
                                    <td><b>{{ $client->contact_person ?? ''}}</b></td>
                                    <td class="table_header_td">Designation</td>
                                    <td><b>{{ $client->designation ?? '' }}</b></td>
                                </tr>
                                <tr>
                                    <td class="table_header_td">Contact No</td>
                                    <td>{{ $client->contact_no ?? '' }}</td>
                                    <td class="table_header_td">Email</td>
                                    <td>{{ $client->email ?? '' }}</td>
                                </tr>
                                <tr class="table_header">
                                    <td colspan="4" style="text-align: center" style=""><b>Billing Information</b></td>
                                </tr>
                                <tr>
                                    <td class="table_header_td">Contact Person</td>
                                    <td>{{ $client->billingAddress[0]->contact_person ?? '' }}</td>
                                    <td class="table_header_td">Designation</td>
                                    <td>{{ $client->billingAddress[0]->designation ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td class="table_header_td">Contact No</td>
                                    <td>{{ $client->billingAddress[0]->phone ?? '' }}</td>
                                    <td class="table_header_td">Email</td>
                                    <td>{{ $client->billingAddress[0]->email ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td class="table_header_td">Division</td>
                                    <td>{{ $client->billingAddress[0]->division->name ?? '' }}</td>
                                    <td class="table_header_td">District</td>
                                    <td>{{ $client->billingAddress[0]->district->name ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td class="table_header_td">Thana</td>
                                    <td>{{ $client->billingAddress[0]->thana->name ?? '' }}</td>
                                    <td class="table_header_td">Billing Address</td>
                                    <td> {{ $client->billingAddress[0]->address ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td class="table_header_td">
                                        Bill to be submission by</td>
                                    <td>{{ $client->billingAddress[0]->submission_by ?? '' }}</td>
                                    <td class="table_header_td">
                                        Bill Submission Date</td>
                                    <td>{{ $client->billingAddress[0]->submission_date ?? '' }}</td>
                                </tr>
                                <tr class="table_header">
                                    <td colspan="4" style="text-align: center" style=""><b>Collection Information</b></td>
                                </tr>
                                <tr>
                                    <td class="table_header_td">Contact Person</td>
                                    <td>{{ $client->collectionAddress[0]->contact_person ?? '' }}</td>
                                    <td class="table_header_td">Designation</td>
                                    <td>{{ $client->collectionAddress[0]->designation ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td class="table_header_td">Contact No</td>
                                    <td>{{ $client->collectionAddress[0]->phone ?? '' }}</td>
                                    <td class="table_header_td">Email</td>
                                    <td>{{ $client->collectionAddress[0]->email ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td class="table_header_td">Division</td>
                                    <td>{{ $client->collectionAddress[0]->division->name ?? '' }}</td>
                                    <td class="table_header_td">District</td>
                                    <td>{{ $client->collectionAddress[0]->district->name ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td class="table_header_td">Thana</td>
                                    <td>{{ $client->collectionAddress[0]->thana->name ?? '' }}</td>
                                    <td class="table_header_td">Address</td>
                                    <td> {{ $client->collectionAddress[0]->address ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td class="table_header_td">Payment Method</td>
                                    <td>{{ $client->collectionAddress[0]->payment_method ?? '' }}</td>
                                    <td class="table_header_td">Approximate Payment Date</td>
                                    <td> {{ $client->collectionAddress[0]->payment_date ?? '' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <input type="hidden" name="status" value="">
                </div>
            </div>
        </div>
    </div>
@endsection
