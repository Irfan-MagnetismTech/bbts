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
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>#SL</th>
                <th>Ticket No</th>
                <th>Priority</th>
                <th>Complain</th>
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
                        <td>{{ $ticket->supportComplainType->name}}</td>
                        <td>{{ $ticket->ticketSource->name}}</td>
                        <td>{{ $ticket->description }}</td>
                        <td>{{ $ticket->createdBy->name }}</td>
                        <td>{{ $ticket->status }}</td>

                        <td>
                            <x:action-button :show="route('support-tickets.show', ['support_ticket' => $ticket->id])" :edit="route('support-tickets.edit', ['support_ticket' => $ticket->id])" :delete="false" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('script')

@endsection
