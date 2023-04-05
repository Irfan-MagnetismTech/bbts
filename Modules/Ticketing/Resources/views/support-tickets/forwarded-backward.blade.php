@extends('layouts.backend-layout')
@section('title', 'Support Tickets')

@section('style')
    
@endsection

@section('breadcrumb-title')
    List of {{ $type }} Tickets
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('support-tickets.create')}}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-plus"></i></a>
@endsection
@section('sub-title')
    Total Tickets: {{ !empty($supportTicketMovements) ? $supportTicketMovements->count() : 0 }} <br>
@endsection

@section('content')
    <form action="" method="get" class="my-4">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                        <label for="ticket_no" class="font-weight-bold">Ticket Name:</label>
                        <select name="ticket_no" id="ticket_no" class="form-control">
                        @if(empty(request()?->ticket_no))
                        <option value="">Select Ticket</option>
                        @else
                        <option value="{{ old('ticket_no') ?? (request()?->ticket_no ?? null) }}">{{ $ticketInfo->ticketNo }}</option>
                        @endif
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
                <div class="form-group my-4 row">
                    <div class="col-md-6">
                        <input type="button" onclick="resetForm()" value="Reset" class="btn btn-outline-warning btn-sm col-12">
                    </div>
                    <div class="col-md-6">
                        <input type="submit" value="Search" class="btn btn-outline-primary btn-sm col-12">
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
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            
            <tbody>
                @foreach ($supportTicketMovements as $movement)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $movement->supportTicket->ticket_no }}</td>
                        <td>{{ $movement->user->name }}</td>
                        <td>{{ $movement->supportTicket->priority }}</td>
                        <td>{{ $movement->supportTicket->supportComplainType->name}}</td>
                        <td>{{ $movement->supportTicket->ticketSource->name}}</td>
                        <td>{{ $movement->remarks }}</td>
                        <td>
                            
                            {{ $movement->status }}
                            @if($movement->status == 'Accepted')
                            <br/>
                            <small>by {{ $movement->acceptedBy->name }} on {{ \Carbon\Carbon::parse($movement->updated_at)->format('d/m/Y h:i a') }}</small>
                            @endif
                        
                        </td>

                        <td class="d-flex align-items-center justify-content-center">

                            @if($movement->status == 'Pending' && $supportTicketMovements->first()->type ==  $movementTypes[0])
                            <div class="icon-btn mr-1">
                                <form action="{{ route('accept-forwarded-tickets') }}" method="POST" data-toggle="tooltip" title="Accept" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="movement_id" value="{{ $movement->id }}">
                                    <button type="submit" class="btn btn-outline-success btn-sm approve"><i class="fas fa-check"></i></button>
                                </form>
                            </div>
                            @endif
                            <x:action-button :show="route('support-tickets.show', ['support_ticket' => $movement->supportTicket->id])" :edit="false" :delete="false" />
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
        $('.date').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                todayHighlight: true,
            });

        select2Ajax("{{ route('search-support-ticket') }}", '#ticket_no')
    })

    function resetForm() {
        $('#date_from').val('');
        $('#date_to').val('');
        $('#ticket_no').val('').trigger( "change" );
        // $('#ticket_no').prop('selectedIndex',0);
    }

</script>
@endsection
