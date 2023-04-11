@extends('layouts.backend-layout')
@section('title', 'Tickets Reports')

@section('style')
    <style>


    table.dataTable tbody>tr.selected, table.dataTable tbody>tr>.selected {
        background-color: #6b9cff !important;
        color: #fff;
    }

    table.dataTable>tbody>tr.selected>td.select-checkbox:after, table.dataTable>tbody>tr.selected>th.select-checkbox:after {
        color: #140a61;
        font-size: 16px;
        margin-left: -4px;
    }
    </style>
@endsection

@section('breadcrumb-title')
    Reports
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('support-tickets.create')}}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-plus"></i></a>
@endsection
@section('sub-title')
    Total Tickets: {{ !empty($supportTickets) ? $supportTickets->count() : 0 }} <br>
@endsection

@section('content')
    <form action="{{ route('search-report-data') }}" method="post" class="my-4" id="reportForm">
        @csrf
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                        <label for="status" class="font-weight-bold">Ticket Status:</label>
                        <select name="status" id="status" class="form-control">
                            <option value="">Select Status</option>
                            @foreach (config('businessinfo.ticketStatuses') as $ticketStatus)
                            <option value="{{ $ticketStatus }}" {{ ($request->status == $ticketStatus) ? "selected" : "" }}>{{ $ticketStatus }}</option>
                            @endforeach
                        </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="date_from" class="font-weight-bold">From Date:</label>
                    <input type="text" class="form-control date" id="date_from" name="date_from" aria-describedby="date_from"
                        value="{{ old('date_from') ?? ($request->date_from ?? null) }}" readonly>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="date_to" class="font-weight-bold">To Date:</label>
                    <input type="text" class="form-control date" id="date_to" name="date_to" aria-describedby="date_to"
                        value="{{ old('date_to') ?? ($request->date_to ?? null) }}" readonly>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                        <label for="ticket_source_id" class="font-weight-bold">Ticket Source:</label>
                        <select name="ticket_source_id" id="ticket_source_id" class="form-control">
                            <option value="">Select Source</option>
                            @foreach ($ticketSources as $source)
                            <option value="{{ $source->id }}" {{ ($request->ticket_source_id == $source->id) ? "selected" : "" }}>{{ $source->name }}</option>
                            @endforeach
                        </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                        <label for="support_complain_type_id" class="font-weight-bold">Problem Type:</label>
                        <select name="support_complain_type_id" id="support_complain_type_id" class="form-control">
                            <option value="">Select Problem Type</option>
                            @foreach ($complainTypes as $type)
                            <option value="{{ $type->id }}" {{ ($request->support_complain_type_id == $type->id) ? "selected" : "" }}>{{ $type->name }}</option>
                            @endforeach
                        </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                        <label for="priority" class="font-weight-bold">Priority:</label>
                        <select name="priority" id="priority" class="form-control">
                            <option value="">Select Priority</option>
                            @foreach (config('businessinfo.ticketPriorities') as $priority)
                            <option value="{{ $priority }}" {{ ($request->priority == $priority) ? "selected" : "" }}>{{ $priority }}</option>
                            @endforeach
                        </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                        <label for="pop_id" class="font-weight-bold">POP Name:</label>
                        <select name="pop_id" id="pop_id" class="form-control">
                            @if(empty($popInfo))
                            <option value="">Select Pop</option>
                            @else
                            <option value="{{ $popInfo->id }}">{{ $popInfo->name }}</option>
                            @endif
                        </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                        <label for="client_id" class="font-weight-bold">Search Client:</label>
                        <select name="client_id" id="client_id" class="form-control">
                            @if(empty($clientInfo))
                            <option value="">Select Client</option>
                            @else
                            <option value="{{ $clientInfo->id }}">{{ $clientInfo->name }}</option>
                            @endif
                        </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="duration" class="font-weight-bold">Duration: <big>(example: 2<b>h</b>30<b>m</b>)</big></label>
                    <input type="text" class="form-control" id="duration" name="duration" aria-describedby="duration"
                        value="{{ old('duration') ?? $request->duration }}" placeholder="Duration">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group my-4 row">
                    <div class="col-md-6">
                        <input type="button" onclick="resetForm()" value="Reset" class="btn btn-outline-warning btn-sm col-12">
                    </div>
                    <div class="col-md-6">
                        <input type="submit" value="Search" class="btn btn-outline-primary btn-sm col-12">
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group my-4 row">
                    <div class="col-md-6">
                        <button type="button" id="pdfDownload" onclick="reportDownload('pdf')" class="btn btn-outline-danger btn-sm col-12">
                            PDF Download
                            <i class="far fa-file-pdf"></i>
                        </button>
                    </div>
                    
                    <div class="col-md-6">
                        <button type="button" id="excelDownload" onclick="reportDownload('excel')" class="btn btn-outline-success btn-sm col-12">
                            Excel Download
                            <i class="far fa-file-excel"></i>
                        </button>
                    </div>
                </div>
            </div>
            
        </div>
    </form>
    <div class="dt-responsive table-responsive">
        <table id="filterableDatatable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Select</th>
                <th class="d-none"></th>
                <th>Ticket No</th>
                <th>Forwarded By</th>
                <th>Priority</th>
                <th>Complain</th>
                <th>Source</th>
                <th>Remarks</th>
            </tr>
            </thead>
            
            <tbody>
                @foreach ($supportTickets as $supportTicket)
                    <tr>
                        <td></td>
                        <td class="d-none">{{ $supportTicket->id }}</td>
                        <td>{{ $supportTicket->ticket_no }}</td>
                        <td>{{ $supportTicket->createdBy->name }}</td>
                        <td>{{ $supportTicket->priority }}</td>
                        <td>{{ $supportTicket->supportComplainType->name}}</td>
                        <td>{{ $supportTicket->ticketSource->name}}</td>
                        <td>{{ $supportTicket->remarks }}</td>
                        
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="row mt-2 mb-4">
            <div class="col-md-4">
                <div class="form-group my-4 row">
                    <div class="col-md-6">
                        <form action="{{ route('pdf-download') }}" method="post" id="filteredPdfDownload">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm col-12">
                                PDF Download
                                <i class="far fa-file-pdf"></i>
                            </button>
                        </form>
                    </div>

                    
                    <div class="col-md-6">
                        <form action="{{ route('excel-download') }}" id="filteredExcelDownload" method="post">
                            @csrf
                            <button type="submit" class="btn btn-outline-success btn-sm col-12">
                                Excel Download
                                <i class="far fa-file-excel"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('.date').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                todayHighlight: true,
            });

        select2Ajax("{{ route('searchPop') }}", '#pop_id')
        select2Ajax("{{ route('searchClient') }}", '#client_id')

        $("#support_complain_type_id").select2({
            placeholder: "Select Complain Type"
        })
        
    })

    function resetForm() {
        $('#status').val('');
        $('#date_from').val('');
        $('#date_to').val('');
        $('#ticket_source_id').val('').trigger( "change" );
        $('#support_complain_type_id').val('').trigger( "change" );
        $('#priority').val('').trigger( "change" );
        $('#pop_id').val('').trigger( "change" );
        $('#client_id').val('').trigger( "change" );
        $('#duration').val('');
    }

    $(document).ready(function() {

        var table =  $('#filterableDatatable').DataTable( {
            columnDefs: [ {
                orderable: false,
                className: 'select-checkbox',
                targets:   0
            } ],
            select: {
                style:    'os',
                selector: 'td:first-child'
            },
            order: [[ 1, 'asc' ]]
        } );


        $('#filteredExcelDownload').submit(function(event) {
            event.preventDefault();
            var selectedRows = table.rows({ selected: true }).data().pluck(1).toArray();

            if(selectedRows.length != 0) {
                
                $("#filteredExcelDownload").append($('<input>', {
                    type: 'hidden',
                    name: 'supporTickets',
                    value: JSON.stringify(selectedRows)
                }));

                console.log(JSON.stringify(selectedRows))
                this.submit();
            }
        });

    });

    function reportDownload(reportType) {
        $("#reportForm").append($('<input>', {
                    type: 'hidden',
                    name: 'reportType',
                    value: reportType
                }));
        $("#reportForm").submit();
    }
</script>
@endsection
