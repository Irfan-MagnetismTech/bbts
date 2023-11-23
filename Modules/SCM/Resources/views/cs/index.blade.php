@extends('layouts.backend-layout')
@section('title', 'Comparative Statement')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Comparative Statement
@endsection


@section('breadcrumb-button')
    <a href="{{ route('cs.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($all_cs) }}
@endsection

@section('content')
    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Cs Ref</th>
                    <th>Effective Date</th>
{{--                    <th>Expiry Date</th>--}}
                    <th>Remarks</th>
                    <th>Selected Supplier</th>
                    {{-- <th>Status</th> --}}
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>Cs Ref</th>
                    <th>Effective Date</th>
{{--                    <th>Expiry Date</th>--}}
                    <th>Remarks</th>
                    <th>Selected Supplier</th>
                    {{-- <th>Status</th> --}}
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                {{-- @dd($all_cs) --}}
                @foreach ($all_cs as $key => $cs)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>{{ $cs->cs_no }}</strong></td>
                        @if($cs->effective_date==null)
                        <td></td>
                        @else
                        <td>{{ \Carbon\Carbon::parse($cs->effective_date)->format('d-m-Y') }}</td>
                        @endif
                        {{--                        <td>{{ $cs->expiry_date }}</td>--}}
                        <td>{{ $cs->remarks }}</td>
                        <td>
                            @foreach ($cs->selectedSuppliers as $csSupplier)
                                <p style="font-size: 11px">{{ $csSupplier->supplier->name }}</p>
                            @endforeach
                            @if ($cs->selectedSuppliers->isEmpty())
                                No Supplier Selected
                            @endif
                        </td>
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
                                        $approval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($cs){
                                            $q->where([['name','CS'],['department_id',$cs->appliedBy->department_id]]);
                                        })->whereDoesntHave('approvals',function ($q) use($cs){
                                            $q->where('approvable_id',$cs->id)->where('approvable_type',\App\Procurement\Cs::class);
                                        })->orderBy('order_by','asc')->first();
                                    @endphp
                                    @if ((!empty($approval) && $approval->designation_id == auth()->user()->designation?->id && $approval->department_id == auth()->user()->department_id) ||
    (!empty($approval) &&
        auth()->user()->hasAnyRole(['admin', 'super-admin'])))
                                        <a href="{{ url("cs/approved/$cs->id/1") }}" data-toggle="tooltip" title="Approve CS" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i></a>
                                    @endif
                                    @if ($cs->approval()->doesntExist() ||
    auth()->user()->hasAnyRole(['admin', 'super-admin']))
                                        <a href="{{ route("cs.edit", $cs->id) }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                        @if ($cs->approval()->doesntExist())
                                        {!! Form::open(array('url' => route("cs.destroy", $cs->id),'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                        {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                        {!! Form::close() !!}
                                        @endif
                                    @endif() --}}

                                     <a href="{{ route("cs-pdf", $cs->id) }}" data-toggle="tooltip" title="PDF" class="btn btn-outline-primary"><i class="fas fa-file-pdf"></i></a>

{{--                                    <a href="{{ url("csLog/$cs->id/log") }}" data-toggle="tooltip" title="Logs" class="btn btn-dark"><i class="fas fa-history"></i></a> --}}
                                    <a href="{{ route('cs.edit', $cs->id) }}" data-toggle="tooltip" title="Edit"
                                        class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                    <a href="{{ route('cs.show', $cs->id) }}" data-toggle="tooltip"
                                            title="Show" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>

                                    {!! Form::open([
                                        'url' => route('cs.destroy', $cs->id),
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
        $(document).ready(function() {
        });
    </script>
@endsection
