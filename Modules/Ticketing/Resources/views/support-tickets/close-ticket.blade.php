@extends('layouts.backend-layout')
@section('title', 'Support Team')

@section('style')
    
@endsection

@section('breadcrumb-title')
    Ticket Close
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('support-teams.index')}}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
    <div class="col-md-10 mx-auto">
        <div class="row">
            <div class="col-md-12">
                <form
                action="{{ (!empty($supportTicket)) ? route('process-close-ticket', ['supportTicketId' => $supportTicket->id]) : '' }}"
                method="post" class="custom-form">
                
                    @method('POST')
                @csrf
                
                    <div class="row mx-auto">
                        <div class="form-group col-8 mx-auto">
                            <label for="supportTicketId" class="font-weight-bold">Ticket ID:</label>

                            <input type="text" class="form-control" id="supportTicketId" name="supportTicketId" aria-describedby="supportTicketId"
                            value="{{ old('supportTicketId') ?? (!empty($supportTicket) ? $supportTicket?->ticket_no : '') }}" readonly>

                        </div>
                        <div class="form-group col-8 mx-auto">
                            <label for="closing_date" class="font-weight-bold">Closing Date & Time:</label>

                            <input type="datetime-local" class="form-control" id="closing_date" name="closing_date" aria-describedby="closing_date"
                            value="{{ old('closing_date') ?? \Carbon\Carbon::now() }}">

                        </div>
                        <div class="form-group col-8 mx-auto">
                            <label for="supportTicketId" class="font-weight-bold">Ticket Closed By:</label>

                            <input type="text" class="form-control" id="supportTicketId" name="supportTicketId" aria-describedby="supportTicketId"
                            value="{{ auth()->user()->name }}" readonly>

                        </div>

                        <div class="form-group col-8 mx-auto">
                            <label for="feedback_to_client" class="font-weight-bold">Feedback for Client:</label>

                            <textarea class="form-control" id="feedback_to_client" name="feedback_to_client" aria-describedby="feedback_to_client"
                                    placeholder="Feedback for Client" style="min-height: 100px !important; ">{{ old('feedback_to_client') }}</textarea>

                        </div>

                        <div class="form-group col-8 mx-auto">
                            <label for="feedback_to_bbts" class="font-weight-bold">Feedback for BBTS Internal:</label>

                            <textarea class="form-control" id="feedback_to_bbts" name="feedback_to_bbts" aria-describedby="feedback_to_bbts"
                                    placeholder="Feedback to BBTS Internal Team" style="min-height: 100px !important; ">{{ old('feedback_to_bbts') }}</textarea>

                        </div>
                        <div class="form-group col-8 mx-auto">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="" class="d-block">Mail Notification:</label>
                                        
                                        <div class="form-check-inline">
                                            <label class="form-check-label" for="sendMail">
                                                <input type="radio" class="form-check-input radioButton" id="sendMail" name="mailNotification" value="1">
                                                <span style="position: relative; top: 3px">
                                                    Yes
                                                </span>
                                            </label>
                                        </div>
                
                                        <div class="form-check-inline">
                                            <label class="form-check-label" for="noMailNotification">
                                                <input type="radio" class="form-check-input radioButton" id="noMailNotification" name="mailNotification" value="0">
                                                <span style="position: relative; top: 3px">
                                                    No
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="" class="d-block">SMS Notification:</label>
                                        
                                        <div class="form-check-inline">
                                            <label class="form-check-label" for="smsNotification">
                                                <input type="radio" class="form-check-input radioButton" id="smsNotification" name="smsNotification" value="1">
                                                <span style="position: relative; top: 3px">
                                                    Yes
                                                </span>
                                            </label>
                                        </div>
                
                                        <div class="form-check-inline">
                                            <label class="form-check-label" for="noSmsNotification">
                                                <input type="radio" class="form-check-input radioButton" id="noSmsNotification" name="smsNotification" value="0">
                                                <span style="position: relative; top: 3px">
                                                    No
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="offset-md-4 col-md-4 mt-2">
                            <div class="input-group input-group-sm ">
                                <button class="btn btn-success btn-round btn-block py-2">Submit</button>
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
