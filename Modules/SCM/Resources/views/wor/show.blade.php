@extends('layouts.backend-layout')
@section('title', 'WOR Show')

@section('breadcrumb-title')
    WOR Show
@endsection

@section('breadcrumb-button')
<a href="{{ route('work-order-receives.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
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
                            <td> <strong>WOR No</strong> </td>
                            <td> <strong>{{ $work_order_receife->wor_no }}</strong></td>
                        </tr>
                        <tr>
                            <td> <strong>Supplier Name</strong> </td>
                            <td> {{ ucfirst($work_order_receife->supplier->name) }}</td>
                        </tr>
                        <tr>
                            <td> <strong>PO No</strong> </td>
                            <td> {{ ucfirst($work_order_receife->purchaseOrder->po_no) }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Branch</strong> </td>
                            <td> {{ ucfirst($work_order_receife->branch->name) }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Date</strong> </td>
                            <td> {{ $work_order_receife->date }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Status</strong> </td>
                            <td> {{ $work_order_receife->status }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Created By</strong> </td>
                            <td> {{ ucfirst($work_order_receife->user->name) }}</td>
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
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Item Code</th>
                    <th>Serial Code</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($work_order_receife->lines as $key => $line)
                    <tr>
                        <td> {{ $line->material->name }} </td>
                        <td> {{ $line->material->unit }} </td>
                        <td> {{ $line->brand->name }} </td>
                        <td> {{ $line->model }} </td>
                        <td> {{ $line->item_code }} </td>
                        <td> {{ $line->serial_code }} </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
