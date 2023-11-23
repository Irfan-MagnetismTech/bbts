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
                    <th>Po No.</th>
                    <th>PO type</th>
                    <th>Supplier Name</th>
                    <th>Purchaased Date</th>
                    <th>Submitted By</th>
                    {{-- <th>Status</th> --}}
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>Po No.</th>
                    <th>PO type</th>
                    <th>Supplier Name</th>
                    <th>Purchaased Date</th>
                    <th>Submitted By</th>
                    {{-- <th>Status</th> --}}
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($all_pos as $key => $po)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>{{ $po->po_no ?? ''}}</strong></td>
                        <td>{{ $po->po_type ?? ''}}</td>
                        <td>{{ $po->supplier->name ?? ''}}</td>
                        <td>{{ $po->date ?? ''}}</td>
                        <td>{{ $po->createdBy->name ?? ''}}</td>
                        {{-- <td>
                            @if ($cs->approval()->exists())
                                @foreach ($cs->approval as $approval)
                                    <span class="badge @if ($approval->status == 'Approved') bg-primary @else bg-warning @endif bg-warning badge-md">
                                        {{ $approval->status }} - {{$approval->user->employee->department->name ?? ''}} - {{$approval->user->employee->designation->name ?? ''}}
                                    </span><br><br>
                                @endforeach
                            @else
                                <span class="badge bg-warning badge-lg">{{ 'Pending' }}</span>
                            @endif
                        </td> --}}
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    {{-- @php
                                        $approval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($cs) {
                                            $q->where([['name', 'CS'], ['department_id', $cs->appliedBy->department_id]]);
                                        })
                                            ->whereDoesntHave('approvals', function ($q) use ($cs) {
                                                $q->where('approvable_id', $cs->id)->where('approvable_type', \App\Procurement\Cs::class);
                                            })
                                            ->orderBy('order_by', 'asc')
                                            ->first();
                                    @endphp
                                    @if (
                                        (!empty($approval) &&
                                            $approval->designation_id == auth()->user()->designation?->id &&
                                            $approval->department_id == auth()->user()->department_id) ||
                                            (!empty($approval) &&
                                                auth()->user()->hasAnyRole(['admin', 'super-admin'])))
                                        <a href="{{ url("cs/approved/$cs->id/1") }}" data-toggle="tooltip"
                                            title="Approve CS" class="btn btn-success"><i class="fa fa-check"
                                                aria-hidden="true"></i></a>
                                    @endif
                                    @if (
                                        $cs->approval()->doesntExist() ||
                                            auth()->user()->hasAnyRole(['admin', 'super-admin']))
                                        <a href="{{ route('cs.edit', $cs->id) }}" data-toggle="tooltip" title="Edit"
                                            class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                        @if ($cs->approval()->doesntExist())
                                            {!! Form::open([
                                                'url' => route('cs.destroy', $cs->id),
                                                'method' => 'delete',
                                                'class' => 'd-inline',
                                                'data-toggle' => 'tooltip',
                                                'title' => 'Delete',
                                            ]) !!}
                                            {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete']) }}
                                            {!! Form::close() !!}
                                        @endif
                                    @endif --}}

                                    <a href="{{ route("po-pdf", $po->id) }}" data-toggle="tooltip" title="PDF" class="btn btn-outline-primary"><i class="fas fa-file-pdf"></i></a>

{{--                                    <a href="{{ url("csLog/$cs->id/log") }}" data-toggle="tooltip" title="Logs" class="btn btn-dark"><i class="fas fa-history"></i></a> --}}
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
            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {});
    </script>
@endsection
