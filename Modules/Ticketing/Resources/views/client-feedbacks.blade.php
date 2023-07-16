@extends('layouts.backend-layout')
@section('title', 'Client Feedbacks')

@section('style')

@endsection

@section('breadcrumb-title')
    List of Client Feedbacks
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
    Total: {{ $feedbacks->count() }}
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
                    <th>Ticket No</th>
                    <th>Client</th>
                    <th>FR No</th>
                    <th>Rating and Comment</th>
                </tr>
            </thead>

            <tbody>
                @forelse($feedbacks as $key => $feedback)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td><a
                                href="{{ route('support-tickets.show', ['support_ticket' => $feedback->first()->support_ticket_id]) }}">{{ $feedback->first()->supportTicket->ticket_no }}</a>
                        </td>
                        <td>{{ $feedback->first()->client->name }}</td>
                        <td>{{ $feedback->first()->supportTicket->feasibilityRequirementDetails->connectivity_point }} /
                            {{ ' (' . $feedback->first()->supportTicket->fr_no . ')' }}</td>
                        <td class="text-left">
                            @foreach ($feedback as $item)
                                <div class="pb-3">
                                    <strong>Rating:</strong> {{ $item->rating }} <br>
                                    <strong>Comment:</strong> {{ $item->feedback }} <br>
                                    <small>Date:
                                        {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y \a\t H:i a') }}</small>
                                </div>
                            @endforeach
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No Data Found.</td>
                    </tr>
                @endforelse
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
        }
    </script>
@endsection
