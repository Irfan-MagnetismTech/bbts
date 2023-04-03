@extends('layouts.backend-layout')
@section('title', 'Support Team')

@section('style')
    
@endsection

@section('breadcrumb-title')
    Ticket Reopen
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
                action="{{ (!empty($supportTicket)) ? route('process-reopen-ticket', ['supportTicketId' => $supportTicket->id]) : '' }}"
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
                            <label for="remarks" class="font-weight-bold">Remarks:</label>

                            <textarea class="form-control" id="remarks" name="remarks" aria-describedby="remarks"
                                    placeholder="Reason of Reopen" style="min-height: 100px !important; ">{{ old('remarks') }}</textarea>

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
