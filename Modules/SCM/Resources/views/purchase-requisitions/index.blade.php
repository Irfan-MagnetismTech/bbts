@extends('layouts.backend-layout')
@section('title', 'Purchase Requisitions Slip')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Purchase Requisitions Slip
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('purchase-requisitions.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-plus"></i></a>
@endsection
@section('sub-title')
    Total: {{ count($purchaseRequisitions) }}
@endsection


@section('content')
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>#SL</th>
                <th>MRS No</th>
                <th>Material - Brand - Model</th>
                <th>Quantity</th>
                <th>Type</th>
                <th>Requisition By</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>#SL</th>
                <th>MRS No</th>
                <th>Material - Brand - Model</th>
                <th>Quantity</th>
                <th>Type</th>
                <th>Requisition By</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach ($purchaseRequisitions as $key => $requisition)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="text-center">{{ $requisition->prs_no ?? ''}}</td>
                        <td class="text-left">
                            @foreach ($requisition->scmPurchaseRequisitionDetails as $subKey => $requisitionDetail)
                            {{ $requisitionDetail->material->name ?? ''}} - {{ $requisitionDetail->brand->name ?? ''}}
                            - {{ $requisitionDetail->model ?? ''}} <br>
                            @endforeach
                        </td>
                        <td class="text-center">
                            @foreach ($requisition->scmPurchaseRequisitionDetails as $subKey => $requisitionDetail)
                            {{ $requisitionDetail->quantity  ?? ''}} <br>
                            @endforeach
                        </td>
                        <td class="text-center">{{ ucfirst($requisition->type) }} {{($requisition->type == 'client') ? ('( '. $requisition->client?->client_name . ' :: ' . $requisition->fr_no . ' )') : ''}}</td>
                        <td class="text-center">{{ ucfirst($requisition->requisitionBy->name) }}</td>
                        <td class="text-center">{{ $requisition->date }}</td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ url("scm/purchase-requisitions/$requisition->id") }}"
                                       data-toggle="tooltip"
                                       title="Details" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>

                                    <a href="{{ route('purchase-requisitions.edit', $requisition->id) }}"
                                       data-toggle="tooltip"
                                       title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>

                                    <form action="{{ url("scm/purchase-requisitions/$requisition->id") }}" method="POST"
                                          data-toggle="tooltip" title="Delete" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm delete"><i
                                                class="fas fa-trash"></i></button>
                                    </form>
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
