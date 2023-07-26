@extends('layouts.backend-layout')
@section('title', 'MRS Details')

@section('breadcrumb-title')
    MRS (Material Requisition Slip) Details
@endsection

@section('breadcrumb-button')
    <a href="{{ route('requisitions.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
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
                            <td> <strong>{{ $requisition->mrs_no }}</strong></td>
                        </tr>
                        <tr>
                            <td> <strong>Type</strong> </td>
                            <td> {{ ucfirst($requisition->type) }}</td>
                        </tr>
                        @if ($requisition?->type == 'client')
                            <tr>
                                <td> <strong>Client Name</strong> </td>
                                <td> {{ ucfirst($requisition->client?->client_name ?? '') }}</td>
                            </tr>
                        @endif
                        @if ($requisition?->type == 'pop')
                            <tr>
                                <td> <strong>Pop Name</strong> </td>
                                <td> {{ ucfirst($requisition->pop->name) }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td> <strong>Date</strong> </td>
                            <td> {{ $requisition->date }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Requisition By</strong> </td>
                            <td> {{ ucfirst($requisition->requisitionBy->name) }}</td>
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
                    <th>Quantity</th>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Purpose</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requisition->scmRequisitiondetailsWithMaterial as $key => $requisitiondetail)
                    <tr>
                        <td> {{ $requisitiondetail->material->name }} </td>
                        <td> {{ $requisitiondetail->description }} </td>
                        <td> {{ $requisitiondetail->material->unit }} </td>
                        <td> {{ $requisitiondetail->quantity }} </td>
                        <td> {{ $requisitiondetail->brand->name }} </td>
                        <td> {{ $requisitiondetail->model }} </td>
                        <td> {{ $requisitiondetail->purpose }} </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
