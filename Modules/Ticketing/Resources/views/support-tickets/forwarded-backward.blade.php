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
    Total Tickets: {{ $supportTicketMovements->count() }} <br>
@endsection


@section('content')
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

@endsection
