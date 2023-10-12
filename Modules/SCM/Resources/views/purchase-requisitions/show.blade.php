@extends('layouts.backend-layout')
@section('title', 'MRS Details')

@section('breadcrumb-title')
    MRS (Material Requisition Slip) Details
@endsection

@section('breadcrumb-button')
    <a href="{{ route('purchase-requisitions.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-database"></i></a>
@endsection

@section('content-grid', null)

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered">
                    <tbody class="text-left">
                        <tr style="background-color: #0C4A77;color: white">
                            <td> <strong>MRS No.</strong> </td>
                            <td> <strong>{{ $purchaseRequisition->prs_no }}</strong></td>
                        </tr>
                        <tr>
                            <td> <strong>Type</strong> </td>
                            <td> {{ ucfirst($purchaseRequisition->type) }}</td>
                        </tr>
                        @if ($purchaseRequisition?->typre == 'client')
                            <tr>
                                <td> <strong>Client Name</strong> </td>
                                <td> {{ ucfirst($purchaseRequisition->client->name) }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td> <strong>Date</strong> </td>
                            <td> {{ $purchaseRequisition->date }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Requisition By</strong> </td>
                            <td> {{ ucfirst($purchaseRequisition->requisitionBy->name) }}</td>
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
                    <th>Unit</th>
                    <th>Quantity</th>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Purpose</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($purchaseRequisition->scmPurchaseRequisitionDetails as $key => $requisitionDetail)
                    <tr>
                        <td> {{ $requisitionDetail->material->name }} </td>
                        <td> {{ $requisitionDetail->material->unit }} </td>
                        <td> {{ $requisitionDetail->quantity }} </td>
                        <td> {{ $requisitionDetail->brand->name }} </td>
                        <td> {{ $requisitionDetail->model }} </td>
                        <td> {{ $requisitionDetail->purpose }} </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
