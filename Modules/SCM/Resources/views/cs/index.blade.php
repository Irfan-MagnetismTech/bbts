@extends('layouts.backend-layout')
@section('title', 'Comparative Statement')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Comparative Statement
@endsection


@section('breadcrumb-button')
    <a href="{{ route('comparative-statements.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
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
                <th>#Cs Ref</th>
                <th>Effective Date</th>
                <th>Expiry Date</th>
                <th>Remarks</th>
                <th>Selected Supplier</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>#Cs Ref</th>
                    <th>Effective Date</th>
                    <th>Expiry Date</th>
                    <th>Remarks</th>
                    <th>Selected Supplier</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
            @foreach($all_cs as $key => $cs)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td><strong>#{{$cs->reference_no}}</strong></td>
                        <td>{{$cs->effective_date}}</td>
                        <td>{{$cs->expiry_date}}</td>
                        <td>{{$cs->remarks}}</td>
                        <td>
                            @php $any_selected = false; @endphp
                            @forelse ($cs->csSuppliers as $cs_supplier)
                                @if($cs_supplier->is_checked)
                                    @php $any_selected = true; @endphp
                                    <p style="font-size: 11px">{{ $cs_supplier->supplier->name }}</p>
                                @endif
                            @empty
                            @endforelse
                            @if(!$any_selected)
                                <p style="font-size: 11px">No Supplier Selected</p>
                            @endif
                        </td>
                        <td>
                            @if($cs->approval()->exists())
                                @foreach($cs->approval as $approval)
                                    <span class="badge @if($approval->status == 'Approved') bg-primary @else bg-warning @endif bg-warning badge-md">
                                        {{ $approval->status }} - {{$approval->user->employee->department->name ?? ''}} - {{$approval->user->employee->designation->name ?? ''}}
                                    </span><br><br>
                                @endforeach
                            @else
                                <span class="badge bg-warning badge-lg">{{ 'Pending' }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    @php
                                        $approval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($cs){
                                            $q->where([['name','CS'],['department_id',$cs->appliedBy->department_id]]);
                                        })->whereDoesntHave('approvals',function ($q) use($cs){
                                            $q->where('approvable_id',$cs->id)->where('approvable_type',\App\Procurement\Cs::class);
                                        })->orderBy('order_by','asc')->first();
                                    @endphp
                                    @if((!empty($approval) && $approval->designation_id == auth()->user()->designation?->id && $approval->department_id == auth()->user()->department_id) || (!empty($approval) && auth()->user()->hasAnyRole(['admin','super-admin'])))
                                        <a href="{{ url("cs/approved/$cs->id/1") }}" data-toggle="tooltip" title="Approve CS" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i></a>
                                    @endif
                                    @if($cs->approval()->doesntExist() || auth()->user()->hasAnyRole(['admin','super-admin']))
                                        <a href="{{ route("comparative-statements.edit", $cs->id) }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                        @if($cs->approval()->doesntExist())
                                        {!! Form::open(array('url' => route("comparative-statements.destroy", $cs->id),'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                        {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                        {!! Form::close() !!}
                                        @endif
                                    @endif()

                                    <a href="{{ route("comparative-statements-pdf", $cs->id) }}" data-toggle="tooltip" title="PDF" class="btn btn-outline-primary"><i class="fas fa-file-pdf"></i></a>

                                    <a href="{{ url("csLog/$cs->id/log") }}" data-toggle="tooltip" title="Logs" class="btn btn-dark"><i class="fas fa-history"></i></a>

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
    <script src="{{asset('js/Datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/Datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script>
        $(window).scroll(function () {
            //set scroll position in session storage
            sessionStorage.scrollPos = $(window).scrollTop();
        });
        var init = function () {
            //get scroll position in session storage
            $(window).scrollTop(sessionStorage.scrollPos || 0)
        };
        window.onload = init;

        $(document).ready(function () {
            $('#dataTable').DataTable({
                stateSave: true
            });
        });
    </script>
@endsection
