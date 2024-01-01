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
    <a href="{{ route('support-tickets.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-plus"></i></a>
@endsection
@section('sub-title')
    Total Tickets: {{ $supportTickets->count() }} <br>
    <small>(Last 30 Days)</small>

@endsection


@section('content')
    <form action="" method="get" class="my-4">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="ticket_no" class="font-weight-bold">Ticket Name:</label>
                    <select name="ticket_no" id="ticket_no" class="form-control">
                        @if (empty(request()?->ticket_no))
                            <option value="">Select Ticket</option>
                        @else
                            <option value="{{ old('ticket_no') ?? (request()?->ticket_no ?? null) }}">
                                {{ $ticketNo ?? null }}</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="date_from" class="font-weight-bold">From Date:</label>
                    <input type="text" class="form-control date" id="date_from" name="date_from"
                        aria-describedby="date_from" value="{{ old('date_from') ?? (request()?->date_from ?? null) }}"
                        readonly>
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
                <label for="search_by_days" class="font-weight-bold">Search By Days:</label>
                <select name="search_by_days" id="search_by_days" class="form-control">
                    <option value="">Select Days</option>
                    <option value="7" {{ request()->search_by_days == 7 ? 'selected' : '' }}>7 Days</option>
                    <option value="15" {{ request()->search_by_days == 15 ? 'selected' : '' }}>15 Days</option>
                    <option value="30" {{ request()->search_by_days == 30 ? 'selected' : '' }}>30 Days</option>
                    <option value="60" {{ request()->search_by_days == 60? 'selected' : '' }}>60 Days</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="search_by_status" class="font-weight-bold">Search By Status:</label>
                <select name="search_by_status" id="search_by_status" class="form-control">
                    <option value="">Select Status</option>
                    <option value="Pending" {{ request()->search_by_days == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Accepted" {{ request()->search_by_days == 'Accepted' ? 'selected' : '' }}>Accepted</option>
                    <option value="Processing" {{ request()->search_by_days == 'Processing' ? 'selected' : '' }}>Processing</option>
                    <option value="Closed" {{ request()->search_by_days == 'Closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </div>
            <div class="col-md-3">
                <div class="form-group my-4 row">
                    <div class="col-md-6">
                        <input type="button" onclick="resetForm()" value="Reset"
                            class="btn btn-outline-warning btn-sm col-12">
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
                    <th>Date</th>
                    <th>Ticket No</th>
                    <th>Client</th>
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
                        <td>{{ $ticket->created_at->format('d-m-Y') ?? '' }}</td>
                        <td>{{ $ticket->ticket_no ?? '' }}</td>
                        <td>{{ $ticket->client->client_name ?? '' }} <br>
                            {{ $ticket->feasibilityRequirementDetails->connectivity_point ?? '' }}</td>
                        <td>{{ $ticket->priority ?? '' }}</td>
                        <td style="width: 100px; white-space: normal">{{ $ticket->supportComplainType->name ?? '' }}</td>
                        <td>{{ $ticket->ticketSource->name ?? '' }}</td>
                        <td>{{ $ticket->description ?? '' }}</td>
                        <td>{{ $ticket->createdBy->name ?? ''}}</td>
                        <td>
                            @if($ticket->status == 'Pending')
                                <span class="badge badge-pill badge-warning" style="font-size: 10px;">{{ $ticket->status ?? '' }}</span>
                            @elseif($ticket->status == 'Accepted')
                                <span class="badge badge-pill badge-primary" style="font-size: 10px;">{{ $ticket->status ?? '' }}</span>
                            @elseif($ticket->status == 'Processing')
                                <span class="badge badge-pill badge-info" style="font-size: 10px;">{{ $ticket->status ?? '' }}</span>
                            @elseif($ticket->status == 'Closed')
                                <span class="badge badge-pill badge-success" style="font-size: 10px;">{{ $ticket->status ?? '' }}</span>
                            @endif 
                            <br />
                            <small style="font-size: 10px;">Last Activity:
                                {{ $ticket->supportTicketLifeCycles()->latest()->first()->remarks ?? ''}}</small>
                        </td>

                        <td class="d-flex align-items-center justify-content-center">

                            @if ($ticket->status == 'Pending' || $ticket->status == 'Approved')
                                <div class="icon-btn mr-1">
                                    <form action="{{ route('accept-ticket') }}" method="POST" data-toggle="tooltip"
                                        title="Accept" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                        <button type="submit" class="btn btn-outline-success btn-sm"><i
                                                class="fas fa-check"></i></button>
                                    </form>
                                </div>
                            @endif
                            <x:action-button :show="route('support-tickets.show', ['support_ticket' => $ticket->id])"
                                :edit="route('support-tickets.edit', ['support_ticket' => $ticket->id])"
                                :delete="false" />
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
            $('#ticket_no').val('').trigger("change");
            // $('#ticket_no').prop('selectedIndex',0);
        }
    </script>
@endsection
