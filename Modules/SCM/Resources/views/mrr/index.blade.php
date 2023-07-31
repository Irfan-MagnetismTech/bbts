@extends('layouts.backend-layout')
@section('title', 'Material Receive Report')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Material Receive Report
@endsection


@section('breadcrumb-button')
    <a href="{{ route('material-receives.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i
            class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($mrrs) }}
    <x-warning-paragraph name="MRR" />
@endsection

@section('content')
    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>#MRR No.</th>
                    <th>#PO No.</th>
                    <th>#PO Date.</th>
                    <th>Supplier Name</th>
                    <th>Challan No</th>
                    <th>Submitted By</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>#MRR No.</th>
                    <th>#PO No.</th>
                    <th>#PO Date.</th>
                    <th>Supplier Name</th>
                    <th>Challan No</th>
                    <th>Submitted By</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($mrrs as $key => $mrr)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>#{{ $mrr->mrr_no }}</strong></td>
                        <td>{{ $mrr->purchaseOrder->po_no }}</td>
                        <td>{{ $mrr->purchaseOrder->date }}</td>
                        <td>{{ $mrr->supplier->name }}</td>
                        <td>{{ $mrr->challan_no }}</td>
                        <td>{{ $mrr->createdBy->name }}</td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ route('material-receives.show', $mrr->id) }}" data-toggle="tooltip"
                                        title="Show" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                    @if (!$mrr->isDeleteable())
                                        <a href="{{ route('material-receives.edit', $mrr->id) }}" data-toggle="tooltip"
                                            title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                        {!! Form::open([
                                            'url' => route('material-receives.destroy', $mrr->id),
                                            'method' => 'delete',
                                            'class' => 'd-inline',
                                            'data-toggle' => 'tooltip',
                                            'title' => 'Delete',
                                        ]) !!}
                                        {{-- {!! Form::button('<i class="fa fa-trash"></i>', [
                                            'type' => 'submit',
                                            'class' => 'btn btn-outline-danger btn-sm delete',
                                        'onClick' => ($mrr->isDeleteable()) ? 'checkParent(event)' : null,
                                        ]) !!} --}}
                                        {!! Form::button('<i class="fa fa-trash"></i>', [
                                            'type' => 'submit',
                                            'class' => 'btn btn-outline-danger btn-sm delete',
                                        ]) !!}

                                        {!! Form::close() !!}
                                    @endif
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
        $(document).ready(function() {

        });
        //     function checkParent(e) {
        //     e.preventDefault();
        //     alert("Please delete parent first");
        //     e.stopImmediatePropagation();
        //     return false;
        // }
    </script>
@endsection
