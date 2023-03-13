@extends('layouts.backend-layout')
@section('title', "Customize $notificationType")

@section('style')
    
@endsection

@section('breadcrumb-title')
    Customize {{ ucfirst($notificationType) }}
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ url()->previous() }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-chevron-left"></i></a>
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
    <div class="col-md-10 mx-auto">
        <div class="row">
            <div class="col-md-12">
                <form
                action="{{ route('send-notification') }}"
                method="post" class="custom-form">
                
                @csrf
                
                    <div class="row">
                        <div class="form-group col-10 mx-auto">
                            <div class="form-group">
                                <label for="ticket_no">Ticket ID:</label>
                                <input type="text" class="form-control" id="ticket_no" name="ticket_no" aria-describedby="ticket_no"
                                    value="{{ old('ticket_no') ?? (!empty($supportTicket) ? $supportTicket?->ticket_no : '') }}" placeholder="Ticket ID" readonly>
                            </div>

                            <div class="form-group">
                                <label for="to">To:</label>
                                <input type="text" class="form-control" id="to" name="to" aria-describedby="to"
                                    value="{{ old('to') ?? (!empty($supportTicket->clientDetail->client) ? ($notificationType == 'email' ? $supportTicket->clientDetail->client->email : $supportTicket->clientDetail->client->mobile) : '') }}" placeholder="To" readonly>
                            </div>
                            @if($notificationType == 'email')
                            <div class="form-group">
                                <label for="cc">CC: <small><strong>[Multiple email should be separated by ";" mark]</strong></small></label>
                                <input type="text" class="form-control" id="cc" name="cc" aria-describedby="cc"
                                    value="{{ old('cc') ?? null }}" placeholder="CC">
                            </div>
                            <div class="form-group">
                                <label for="subject">Subject:</label>
                                <input type="text" class="form-control" id="subject" name="subject" aria-describedby="subject"
                                    value="{{ old('subject') ?? null }}" placeholder="Subject">
                            </div>
                            @endif
                            <div class="form-group">
                                <label for="description">Description:</label>
                                <textarea type="text" class="form-control" id="description" name="description" aria-describedby="description"
                                    value="{{ old('description') ?? null }}" placeholder="Description" style="min-height: 100px !important; "></textarea>
                            </div>
                            @if($notificationType == 'email')
                            <div class="form-group">
                                <label for="estimated_time">Estimated Time:</label>
                                <input type="text" class="form-control" id="estimated_time" name="estimated_time" aria-describedby="estimated_time"
                                    value="{{ old('estimated_time') ?? null }}" placeholder="Estimated Time">
                            </div>
                            @endif
                            <input type="hidden" name="ticket_id" value="{{ $supportTicket->id }}">
                            <input type="hidden" name="notification_type" value="{{ $notificationType }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="offset-md-4 col-md-4 mt-2">
                            <div class="input-group input-group-sm ">
                                <button class="btn btn-success btn-round btn-block py-2">Send Email</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
        
</script>
@endsection
