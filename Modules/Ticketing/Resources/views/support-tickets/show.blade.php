@extends('layouts.backend-layout')
@section('title', 'Support Ticket Details')

@section('style')
    
@endsection

@section('breadcrumb-title')
    Support Ticket Details
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('support-tickets.index')}}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('content-grid', 'col-12 my-3')

@section('content')
    <div class="col-md-12 mx-auto">
        <div class="row">
            <div class="col-6">
                <div class="row align-items-center">
                    <div class="col-4 text-right">
                        Ticket ID
                    </div>
                    <div class="col-8">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control"
                                value="{{ $supportTicket->ticket_no }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center mt-2">
                    <div class="col-4 text-right">
                        Link ID
                    </div>
                    <div class="col-8">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control"
                                value="{{ $supportTicket->clientDetail->link_name }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center mt-2">
                    <div class="col-4 text-right">
                        Complain Type
                    </div>
                    <div class="col-8">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control"
                                value="{{ $supportTicket->supportComplainType->name }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center mt-2">
                    <div class="col-4 text-right">
                        Description
                    </div>
                    <div class="col-8">
                        <div class="form-group mb-0">
                            <textarea type="text" class="form-control" disabled>{{ $supportTicket->description }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center mt-2">
                    <div class="col-4 text-right">
                        Source
                    </div>
                    <div class="col-8">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control"
                                value="{{ $supportTicket->ticketSource->name }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center mt-2">
                    <div class="col-4 text-right">
                        Remarks
                    </div>
                    <div class="col-8">
                        <div class="form-group mb-0">
                            <textarea type="text" class="form-control" disabled>{{ $supportTicket->remarks }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center mt-2">
                    <div class="col-4 text-right">
                        To
                    </div>
                    <div class="col-8">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control"
                                value="" disabled>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center mt-2">
                    <div class="col-4 text-right">
                        CC
                    </div>
                    <div class="col-8">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control"
                                value="" disabled>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center mt-2">
                    <div class="col-4 text-right">
                        Subject
                    </div>
                    <div class="col-8">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control"
                                value="" disabled>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center mt-2">
                    <div class="col-4 text-right">
                        Mail Description
                    </div>
                    <div class="col-8">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control"
                                value="" disabled>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="row align-items-center mt-2">
                    <div class="col-4 text-right">
                        Client Name
                    </div>
                    <div class="col-8">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control"
                                value="{{ $supportTicket->clientDetails?->client?->name }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center mt-2">
                    <div class="col-4 text-right">
                        Contact Person
                    </div>
                    <div class="col-8">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control"
                                value="" disabled>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center mt-2">
                    <div class="col-4 text-right">
                        E-mail Address
                    </div>
                    <div class="col-8">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control"
                                value="" disabled>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center mt-2">
                    <div class="col-4 text-right">
                        Swtich Port
                    </div>
                    <div class="col-8">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control"
                                value="" disabled>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center mt-2">
                    <div class="col-4 text-right">
                        VLAN
                    </div>
                    <div class="col-8">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control"
                                value="" disabled>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center mt-2">
                    <div class="col-4 text-right">
                        Address
                    </div>
                    <div class="col-8">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control"
                                value="" disabled>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center mt-2">
                    <div class="col-4 text-right">
                        Contact Number
                    </div>
                    <div class="col-8">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control"
                                value="" disabled>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center mt-2">
                    <div class="col-4 text-right">
                        Switch IP
                    </div>
                    <div class="col-8">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control"
                                value="" disabled>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center mt-2">
                    <div class="col-4 text-right">
                        POP
                    </div>
                    <div class="col-8">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control"
                                value="" disabled>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center mt-2">
                    <div class="col-4 text-right">
                        Ticket Closed By
                    </div>
                    <div class="col-8">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control"
                                value="" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h4 class="text-center mt-5">Ticket Activity</h4>
                <div class="dt-responsive table-responsive">
                    <table id="dataTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#SL</th>
                                <th>Opening Time</th>
                                <th>Solutions</th>
                                <th>Department</th>
                                <th>Updated By</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <hr>
            <div class="col-12 d-flex justify-content-between mt-3">
                <a href="{{ route('ticket-movements', ['type' => 'Backward', 'id' => $supportTicket->id]) }}" class="btn btn-success btn-round btn-inline-block py-2">
                    <i class="fas fa-chevron-circle-left"></i>
                    Backward
                </a>
                <a href="{{ route('ticket-movements', ['type' => 'Forward', 'id' => $supportTicket->id]) }}" class="btn btn-success btn-round btn-inline-block py-2">
                    Forward
                    <i class="fas fa-chevron-circle-right"></i>
                </a>
                <a href="{{ route('ticket-movements', ['type' => 'Handover', 'id' => $supportTicket->id]) }}" class="btn btn-success btn-round btn-inline-block py-2">
                    Handover
                    <i class="fas fa-handshake"></i>
                </a>
                <a href="" class="btn btn-success btn-round btn-inline-block py-2">
                    Send Mail
                    <i class="fas fa-envelope"></i>
                </a>
                <a href="" class="btn btn-success btn-round btn-inline-block py-2">
                    Send SMS
                    <i class="fas fa-inbox"></i>
                </a>
                <a href="" class="btn btn-danger btn-round btn-inline-block py-2">
                    Close
                    <i class="far fa-check-circle"></i>
                </a>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
        

        $(document).on('keyup focus', '#client_id', function() {
            $(this).autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ url('get-clients-by-links') }}",
                        type: 'get',
                        dataType: "json",
                        data: {
                            search: request.term
                        },
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                select: function(event, ui) {
                    
                    console.log(ui.item)
                    $("#client_id").val(ui.item.label)
                    $("#fr_composit_key").val(ui.item.value)

                    getClientsPreviousTickets(ui.item.client.id, 5)
                    return false;
                }
            });
        });

        function getClientsPreviousTickets(clientId, limit = 5) {
            console.log(clientId, limit)
            $.ajax({
                url: "{{ url('get-clients-previous-tickets') }}"+"/"+clientId+"/"+limit,
                type: 'get',
                dataType: "json"
            }).done(function(data) {
                var tickets = data;

                // find if any tickets status is Pending
                var pendingTickets = tickets.filter(function(ticket) {
                    return ticket.status == "Pending";
                });

                if (pendingTickets.length > 0) {
                    alert('This client already have pending tickets. Please see the ticket list.');
                    $("#formSubmit").find("button").css("display", "none");
                } else {
                    $("#formSubmit").find("button").removeAttr("style");
                }

                // run foreach data 
                var tableData = '';
                $.each(tickets, function(key, value) {
                    tableData += '<tr>';
                    tableData += '<td>' + value.ticket_no + '</td>';
                    tableData += '<td>' + value.status + '</td>';
                    tableData += '<td>' + value.opening_date + '</td>';
                    tableData += '<td>' + value.complain_type.name + '</td>';
                    tableData += '<td>' + value.remarks + '</td>';
                    tableData += '<td><div class="icon-btn"><a href="{{ route('support-tickets.index') }}/'+value.id+'" data-toggle="tooltip" title="Details" class="btn btn-outline-primary" data-original-title="Details"><i class="fas fa-eye"></i></a></div></td>';
                    tableData += '</tr>';
                })

                $("#previousTickets").find("tbody").html("");
                $("#previousTickets").find("tbody").html(tableData);

            })
        }

        // $('#complain_time').datepicker({
        //     format: "dd-mm-yyyy hh:mm",
        //     autoclose: true,
        //     todayHighlight: true,
        //     showOtherMonths: true,
        // }).datepicker("setDate", new Date());
</script>
@endsection
