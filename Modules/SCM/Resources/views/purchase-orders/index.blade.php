@extends('layouts.backend-layout')
@section('title', 'Purchase Orders')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Purchase Orders
@endsection


@section('breadcrumb-button')
    <a href="{{ route('purchase-orders.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i
            class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($all_pos) }}
@endsection

@section('content')
    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th>Date</th>
                <th>Po No.</th>
                <th>Material</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Qty</th>
                <th>Unit</th>
                <th>Rate</th>
                <th>Total Price</th>
                <th>Warranty</th>
                <th>Remarks</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>SL</th>
                <th>Date</th>
                <th>Po No.</th>
                <th>Material</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Qty</th>
                <th>Unit</th>
                <th>Rate</th>
                <th>Total Price</th>
                <th>Warranty</th>
                <th>Remarks</th>
                <th>Action</th>
            </tr>
            </tfoot>
            <tbody>
            @php($i=1)
            @foreach ($all_pos as $key => $po)
                @foreach ($po->purchaseOrderLines as $key => $data)
                    <tr>
                        <td rowspan="">{{ $i++ }}</td>
                        <td class="text-center">{{ $po->date ?? ''}}</td>
                        <td class="text-center">{{ $po->po_no ?? ''}}</td>
                        <td class="text-center">{{ $data->material->name ?? ''}}</td>
                        <td class="text-center">{{ $data->brand->name ?? ''}}</td>
                        <td class="text-center">{{ $data->model ?? ''}}</td>
                        <td class="text-center">{{ $data->quantity ?? ''}}</td>
                        <td class="text-center">{{ $data->material->unit ?? ''}}</td>
                        <td class="text-center">{{ $data->unit_price ?? ''}}</td>
                        <td class="text-center">{{ $data->total_amount ?? ''}}</td>
                        <td class="text-center">{{ $data->warranty_period ?? ''}}</td>
                        <td class="text-center">{{ $po->remarks ?? ''}}</td>
                        <td rowspan="">
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ route("po-pdf", $po->id) }}" data-toggle="tooltip" title="PDF"
                                       class="btn btn-outline-primary"><i class="fas fa-file-pdf"></i></a>

                                    <a href="{{ route('purchase-orders.show', $po->id) }}" data-toggle="tooltip"
                                       title="Show" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>

                                    <a href="{{ route('purchase-orders.edit', $po->id) }}" data-toggle="tooltip"
                                       title="Edit" class="btn btn-outline-success"><i class="fas fa-pen"></i></a>

                                    <a href="{{ route('closePo', $po->id) }}" data-toggle="tooltip"
                                       title="Close" class="btn btn-outline-warning"><i class="fas fa-window-close"></i></a>

                                    {!! Form::open([
                                        'url' => route('purchase-orders.destroy', $po->id),
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
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
        });
    </script>
@endsection
