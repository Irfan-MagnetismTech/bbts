@extends('layouts.backend-layout')
@section('title', 'Work Order Receiving Report')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Work Order Receiving Report
@endsection


@section('breadcrumb-button')
    <a href="{{ route('work-order-receives.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i
            class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($worData) }}
    <x-warning-paragraph name="WOR"/>
@endsection

@section('content')
    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th>WOR No.</th>
                <th>#PO No.</th>
                <th>Supplier Name</th>
                <th>Branch Name</th>
                <th>Submitted By</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>SL</th>
                <th>WOR No.</th>
                <th>#PO No.</th>
                <th>Supplier Name</th>
                <th>Branch Name</th>
                <th>Submitted By</th>
                <th>Action</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach ($worData as $key => $wor)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $wor->wor_no }}</td>
                    <td>{{ $wor->purchaseOrder->po_no }}</td>
                    <td>{{ $wor->supplier->name }}</td>
                    <td>{{ $wor->branch->name }}</td>
                    <td>{{ $wor->user->name }}</td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                <a href="{{ route('work-order-receives.show', $wor->id) }}" data-toggle="tooltip"
                                   title="Show" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('work-order-receives.edit', $wor->id) }}" data-toggle="tooltip"
                                   title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                {!! Form::open([
                                    'url' => route('work-order-receives.destroy', $wor->id),
                                    'method' => 'delete',
                                    'class' => 'd-inline',
                                    'data-toggle' => 'tooltip',
                                    'title' => 'Delete',
                                ]) !!}
                                @csrf
                                @method('DELETE')
                                {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete']) }}
                                {!! Form::close() !!}
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
        $(document).ready(function () {
        });
    </script>
@endsection
