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
    <a href="{{ route('support-tickets.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-database"></i></a>
@endsection

@section('content-grid', 'col-12 my-3')

@section('content')
    <div class="col-md-12 mx-auto">
        <div class="row">
            <div class="col-4">
                <div class="row align-items-center">
                    <div class="col-4 text-right">
                        Ticket ID
                    </div>
                    <div class="col-8">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control" value="{{ $supportTicket->ticket_no }}" disabled>
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
                                value="{{ $supportTicket?->clientDetail?->link_name }}" disabled>
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
                                value="{{ $supportTicket?->supportComplainType?->name }}" disabled>
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
                        To
                    </div>
                    <div class="col-8">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control" value="" disabled>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center mt-2">
                    <div class="col-4 text-right">
                        CC
                    </div>
                    <div class="col-8">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control" value="" disabled>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center mt-2">
                    <div class="col-4 text-right">
                        Subject
                    </div>
                    <div class="col-8">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control" value="" disabled>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center mt-2">
                    <div class="col-4 text-right">
                        Mail Description
                    </div>
                    <div class="col-8">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control" value="" disabled>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-5">
                <div class="col-12">
                    <h4 class="text-center mt-5">Feasibility Information</h4>
                </div>
                @if (!empty($supportTicket->physicalConnectivity))
                    @foreach ($supportTicket->physicalConnectivity->lines as $line)
                        <hr />
                        <div class="row align-items-center mt-2">
                            <div class="col-2 text-right">
                                Swtich Port
                            </div>
                            <div class="col-4">
                                <div class="form-group mb-0">
                                    <input type="text" class="form-control" value="{{ $line->port }}" disabled>
                                </div>
                            </div>
                            <div class="col-2 text-right">
                                VLAN
                            </div>
                            <div class="col-4">
                                <div class="form-group mb-0">
                                    <input type="text" class="form-control" value="{{ $line->vlan }}" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="row align-items-center mt-2">
                            <div class="col-2 text-right">
                                Switch IP
                            </div>
                            <div class="col-4">
                                <div class="form-group mb-0">
                                    <input type="text" class="form-control" value="{{ $line->device_ip }}" disabled>
                                </div>
                            </div>

                            <div class="col-2 text-right">
                                LDP
                            </div>
                            <div class="col-4">
                                <div class="form-group mb-0">
                                    <input type="text" class="form-control" value="{{ $line?->ldb }}" disabled>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
                <div class="row align-items-center mt-2">
                    <div class="col-2 text-right">
                        Ticket Closed By
                    </div>
                    <div class="col-10">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control" value="" disabled>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="row align-items-center mt-2">
                    <div class="col-4 text-right">
                        Source
                    </div>
                    <div class="col-8">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control" value="{{ $supportTicket->ticketSource->name }}"
                                disabled>
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
                        Client Name
                    </div>
                    <div class="col-8">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control"
                                value="{{ $supportTicket?->client?->client_name }}" disabled>
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
                                value="{{ $supportTicket->client?->contact_person }}" disabled>
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
                                value="{{ $supportTicket?->clientDetail?->client?->email }}"disabled>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center mt-2">
                    <div class="col-4 text-right">
                        Swtich Port
                    </div>
                    <div class="col-8">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control" value="" disabled>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center mt-2">
                    <div class="col-4 text-right">
                        VLAN
                    </div>
                    <div class="col-8">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control" value="" disabled>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center mt-2">
                    <div class="col-4 text-right">
                        Address
                    </div>
                    <div class="col-8">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control" value="{{ $supportTicket?->client?->location }}"
                                disabled>
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
                                value="{{ $supportTicket?->client?->contact_no }}" disabled>
                        </div>
                    </div>
                </div>









            </div>




        </div>





        <div class="row">
            <div class="col-12 text-center">
                <h4 class="text-center mt-5">Ticket Activity</h4>
                <div class="dt-responsive table-responsive">
                    <table id="dataTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#SL</th>
                                <th>Activity Time</th>
                                <th>Event</th>
                                <th>Solutions / Remarks</th>
                                <th>Department</th>
                                <th>Updated By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($supportTicket->supportTicketLifeCycles as $activity)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ \Carbon\Carbon::parse($activity->created_at)->format('h:i A \o\n d/m/Y') }}</td>
                                    <td>{{ $activity->remarks }}</td>
                                    <td>{{ $activity->description }}</td>
                                    <td>{{ $activity?->user?->employee?->department?->name }}</td>
                                    <td>{{ $activity?->user?->name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            @if ($supportTicket->status == 'Pending' || $supportTicket->status == 'Approved')
                <div class="col-12 my-5">
                    <div class="col-2 mx-auto">
                        <form action="{{ route('accept-ticket') }}" method="POST" data-toggle="tooltip" title="Accept"
                            class="d-inline">
                            @csrf
                            <input type="hidden" name="ticket_id" value="{{ $supportTicket->id }}">
                            <button type="submit" class="btn btn-success btn-out btn-md btn-round">
                                <i class="fas fa-check"></i>
                                Accept Ticket
                            </button>
                        </form>
                    </div>
                </div>
            @endif
            @if (
                $supportTicket->status == 'Accepted' ||
                    $supportTicket->status == 'Processing' ||
                    $supportTicket->status == 'Reopen')
                <div class="col-12 my-5">
                    <div class="row">
                        <div class="col-6 mx-auto rounded shadow-sm"
                            style="background-color: #A0B9FF; box-shadow: 2px 2px 6px 0px #70708d">
                            <form action="{{ route('add-solution') }}" method="post">
                                @csrf
                                <input type="hidden" name="ticket_id" value="{{ $supportTicket->id }}">
                                <h4 class="text-center mt-5">Add New Solution</h4>
                                <label for="quick_solution"><b>Solution Name:</b></label>
                                <select name="quick_solution" id="quick_solution" class="form-control mb-2">
                                    <option value="">Select Solution</option>
                                    @foreach ($quickSolutions as $solution)
                                        <option value="{{ $solution->name }}"
                                            {{ old('quick_solution', '') == $solution->id ? 'selected' : '' }}>
                                            {{ $solution->name }}</option>
                                    @endforeach
                                    <option value="other">Others</option>

                                </select>
                                <div class="form-group d-none" id="custom-solution">
                                    <label for="solution"><b>Solution / Remarks:</b></label>
                                    <textarea class="form-control mb-2" id="solution" name="custom_solution" aria-describedby="solution"
                                        value="{{ old('solution') ?? null }}" placeholder="Solution / Remarks"></textarea>
                                </div>
                                <div class="mx-auto text-center">
                                    <input type="submit" value="Submit" class="btn btn-info btn-round my-2">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
            @if ($supportTicket->status != 'Closed')
                <hr>
                <div class="col-12 d-flex justify-content-between mt-3">
                    @can('support-ticket-backward')
                        <a href="{{ route('ticket-movements', ['type' => 'Backward', 'id' => $supportTicket->id]) }}"
                            class="btn btn-success btn-round btn-inline-block py-2">
                            <i class="fas fa-chevron-circle-left"></i>
                            Backward
                        </a>
                    @endcan

                    {{-- @can('support-ticket-forward')
                        <a href="{{ route('ticket-movements', ['type' => 'Forward', 'id' => $supportTicket->id]) }}"
                            class="btn btn-success btn-round btn-inline-block py-2">
                            Forward
                            <i class="fas fa-chevron-circle-right"></i>
                        </a>
                    @endcan --}}

                    {{-- @can('support-ticket-handover')
                        <a href="{{ route('ticket-movements', ['type' => 'Handover', 'id' => $supportTicket->id]) }}"
                            class="btn btn-success btn-round btn-inline-block py-2">
                            Handover
                            <i class="fas fa-handshake"></i>
                        </a>
                    @endcan --}}

                    {{-- @can('support-client-send-email')
                        <a href="{{ route('notify-client', ['ticketId' => $supportTicket?->id, 'type' => 'email']) }}"
                            class="btn btn-success btn-round btn-inline-block py-2">
                            Send Mail
                            <i class="fas fa-envelope"></i>
                        </a>
                    @endcan --}}

                    {{-- @can('support-client-send-sms')
                        <a href="{{ route('notify-client', ['ticketId' => $supportTicket?->id, 'type' => 'sms']) }}"
                            class="btn btn-success btn-round btn-inline-block py-2">
                            Send SMS
                            <i class="fas fa-inbox"></i>
                        </a>
                    @endcan --}}

                    @can('support-ticket-close')
                        @if ($supportTicket->status != 'Closed')
                            <a href="{{ route('close-ticket', ['supportTicketId' => $supportTicket?->id]) }}"
                                class="btn btn-danger btn-round btn-inline-block py-2">
                                Close
                                <i class="far fa-check-circle"></i>
                            </a>
                        @endif
                    @endcan
                </div>
            @else
                <hr>
                @php
                    $closingDate = $supportTicket->closing_date;
                    $currentTime = \Carbon\Carbon::now();
                    $minutesDiff = $currentTime->diffInMinutes($closingDate);
                @endphp
                @if ($minutesDiff <= 60 * 24)
                    <div class="col-12 d-flex justify-content-center mt-3">
                        {{-- @can('support-ticket-reopen')
                            <a href="{{ route('reopen-ticket', ['supportTicketId' => $supportTicket->id]) }}"
                                class="btn btn-success btn-round btn-inline-block py-2">
                                <i class="fas fa-folder-open"></i>
                                Reopen
                            </a>
                        @endcan --}}
                    </div>
                @endif
            @endif
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
                url: "{{ url('get-clients-previous-tickets') }}" + "/" + clientId + "/" + limit,
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
                    tableData +=
                        '<td><div class="icon-btn"><a href="{{ route('support-tickets.index') }}/' + value
                        .id +
                        '" data-toggle="tooltip" title="Details" class="btn btn-outline-primary" data-original-title="Details"><i class="fas fa-eye"></i></a></div></td>';
                    tableData += '</tr>';
                })

                $("#previousTickets").find("tbody").html("");
                $("#previousTickets").find("tbody").html(tableData);

            })
        }

        $("#quick_solution").on("change", function() {
            if ($(this).val() == "other") {
                $("#custom-solution").addClass("d-block");
            } else {
                $("#custom-solution").removeClass("d-block");
            }
        });

        // $('#complain_time').datepicker({
        //     format: "dd-mm-yyyy hh:mm",
        //     autoclose: true,
        //     todayHighlight: true,
        //     showOtherMonths: true,
        // }).datepicker("setDate", new Date());
    </script>
@endsection
