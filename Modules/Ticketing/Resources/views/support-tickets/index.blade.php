@extends('layouts.backend-layout')
@section('title', 'Support Tickets')

@section('style')
    
@endsection

@section('breadcrumb-title')
   List of Support Tickets
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('support-tickets.create')}}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-plus"></i></a>
@endsection
@section('sub-title')
    Total Tickets: {{ $supportTickets->count() }} <br>
    <small>(Last 30 Days)</small>

@endsection


@section('content')
    <form action="" method="get" class="my-4">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="date_from" class="font-weight-bold">From Date:</label>
                    <input type="text" class="form-control date" id="date_from" name="date_from" aria-describedby="date_from"
                        value="{{ old('date_from') ?? (request()?->date_from ?? null) }}" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="date_to" class="font-weight-bold">To Date:</label>
                    <input type="text" class="form-control date" id="date_to" name="date_to" aria-describedby="date_to"
                        value="{{ old('date_to') ?? (request()?->date_to ?? null) }}" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group my-4">
                    <input type="submit" value="Search" class="btn btn-outline-primary btn-sm">
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
                <th>Priority</th>
                <th style="width: 100px">Complain</th>
                <th>Source</th>
                <th>Description</th>
                <th>Opened By</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            
            <tbody>
                @foreach ($supportTickets as $ticket)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $ticket->ticket_no }}</td>
                        <td>{{ $ticket->priority }}</td>
                        <td style="width: 100px; white-space: normal">{{ $ticket->supportComplainType->name}}</td>
                        <td>{{ $ticket->ticketSource->name}}</td>
                        <td>{{ $ticket->description }}</td>
                        <td>{{ $ticket->createdBy->name }}</td>
                        <td>
                            {{ $ticket->status }} <br />
                            <small>Last Activity: {{ $ticket->supportTicketLifeCycles()->latest()->first()->user->name }}</small>
                        </td>

                        <td class="d-flex align-items-center justify-content-center">

                            @if($ticket->status == 'Pending' || $ticket->status == 'Approved')
                            <div class="icon-btn mr-1">
                                <form action="{{ route('accept-ticket') }}" method="POST" data-toggle="tooltip" title="Accept" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                    <button type="submit" class="btn btn-outline-success btn-sm"><i class="fas fa-check"></i></button>
                                </form>
                            </div>
                            @endif
                            <x:action-button :show="route('support-tickets.show', ['support_ticket' => $ticket->id])" :edit="route('support-tickets.edit', ['support_ticket' => $ticket->id])" :delete="false" />
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
    })
</script>
@endsection
