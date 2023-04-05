@extends('layouts.backend-layout')
@section('title', 'Support Tickets')

@section('style')
    
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
    <form action="" method="get" class="my-4">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                        <label for="status" class="font-weight-bold">Ticket Status:</label>
                        <select name="status" id="status" class="form-control">
                            <option value="">Select Status</option>
                            @foreach (config('businessinfo.ticketStatuses') as $ticketStatus)
                            <option>{{ $ticketStatus }}</option>
                            @endforeach
                        </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="date_from" class="font-weight-bold">From Date:</label>
                    <input type="text" class="form-control date" id="date_from" name="date_from" aria-describedby="date_from"
                        value="{{ old('date_from') ?? (request()?->date_from ?? null) }}" readonly>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="date_to" class="font-weight-bold">To Date:</label>
                    <input type="text" class="form-control date" id="date_to" name="date_to" aria-describedby="date_to"
                        value="{{ old('date_to') ?? (request()?->date_to ?? null) }}" readonly>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                        <label for="ticket_source_id" class="font-weight-bold">Ticket Source:</label>
                        <select name="ticket_source_id" id="ticket_source_id" class="form-control">
                            <option value="">Select Source</option>
                            @foreach ($ticketSources as $source)
                            <option value="{{ $source->id }}">{{ $source->name }}</option>
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
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
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
                            <option>{{ $priority }}</option>
                            @endforeach
                        </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                        <label for="pop_id" class="font-weight-bold">POP Name:</label>
                        <select name="pop_id" id="pop_id" class="form-control">
                            <option value="">Select Pop</option>
                        </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                        <label for="client_id" class="font-weight-bold">Search Client:</label>
                        <select name="client_id" id="client_id" class="form-control">
                            <option value="">Select Client</option>
                        </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="duration" class="font-weight-bold">Duration:</label>
                    <input type="text" class="form-control" id="duration" name="duration" aria-describedby="duration"
                        value="{{ old('duration') ?? '' }}" placeholder="Duration">
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
                        <button type="button" value="Reset" class="btn btn-outline-danger btn-sm col-12">
                            PDF Download
                            <i class="far fa-file-pdf"></i>
                        </button>
                    </div>
                    <div class="col-md-6">
                        <button type="button" value="Reset" class="btn btn-outline-success btn-sm col-12">
                            Excel Download
                            <i class="far fa-file-excel"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            
        </div>
    </form>
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>#SL</th>
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
                        <td>{{ $loop->index + 1 }}</td>
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

        
    })

    function resetForm() {
        $('#date_from').val('');
        $('#date_to').val('');
        $('#ticket_no').val('').trigger( "change" );
        // $('#ticket_no').prop('selectedIndex',0);
    }

</script>
@endsection
