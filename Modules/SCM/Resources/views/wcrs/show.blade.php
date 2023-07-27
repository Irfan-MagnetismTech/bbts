@extends('layouts.backend-layout')
@section('title', 'WCR Show')

@section('breadcrumb-title')
    WCR Show
@endsection

@section('breadcrumb-button')
    <a href="{{ route('warranty-claims.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('content-grid', null)

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered">
                    <tbody class="text-left">
                        <tr style="background-color: #0C4A77;color: white">
                            <td> <strong>WCR No.</strong> </td>
                            <td> <strong>{{ $warranty_claim->wcr_no }}</strong></td>
                        </tr>
                        <tr>
                            <td> <strong>Supplier</strong> </td>
                            <td> {{ ucfirst($warranty_claim->supplier->name) }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Date</strong> </td>
                            <td> {{$warranty_claim->date }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Sending Date</strong> </td>
                            <td> {{ $warranty_claim->sending_date }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Client</strong> </td>
                            <td> {{ ucfirst($warranty_claim?->client?->client_name) }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Type</strong> </td>
                            <td> {{ ucfirst($warranty_claim->type) }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Branch</strong> </td>
                            <td> {{ ucfirst($warranty_claim?->branch?->name) }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Status</strong> </td>
                            <td> {{ ucfirst($warranty_claim->status) }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Remarks</strong> </td>
                            <td> {{ ucfirst($warranty_claim->remarks) }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Created By</strong> </td>
                            <td> {{ ucfirst($warranty_claim->createdBy->name) }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Sent By</strong> </td>
                            <td> {{ ucfirst($warranty_claim?->sentBy?->name ?? '') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Material Name</th>
                    <th>Description</th>
                    <th>Unit</th>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Remaining Days</th>
                    <th>Warranty Period</th>
                    <th>Receiving Date</th>
                    <th>Challan No</th>
                    <th>Serial Code</th>
                    <th>Item Code</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($warranty_claim->lines as $key => $line)
                    <tr>
                        <td> {{ $line->material->name }} </td>
                        <td> {{ $line->description }} </td>
                        <td> {{ $line->material->unit }} </td>
                        <td> {{ $line->brand->name }} </td>
                        <td> {{ $line->model }} </td>
                        <td> {{ $line->remaining_days }} </td>
                        <td> {{ $line->warranty_period }} </td>
                        <td> {{ $line->receiving_date }} </td>
                        <td> {{ $line->challan_no }} </td>
                        <td> {{ $line->serial_code }} </td>
                        <td> {{ $line->item_code }} </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
