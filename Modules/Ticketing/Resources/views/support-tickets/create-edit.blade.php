@extends('layouts.backend-layout')
@section('title', 'Support Ticket')

@section('style')

@endsection

@section('breadcrumb-title')
    @if (!empty($supportTicket))
        Edit Support Ticket
    @else
        Create New Support Ticket
    @endif
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
            <div class="col-md-12">
                <form
                    action="{{ !empty($supportTicket) ? route('support-tickets.update', ['support_ticket' => $supportTicket->id]) : route('support-tickets.store') }}"
                    method="post" class="custom-form">
                    @if (!empty($supportTicket))
                        @method('PUT')
                    @else
                        @method('POST')
                    @endif
                    @csrf

                    <div class="row">
                        <div class="col-5">
                            <div class="row">
                                <div class="col-6">
                                    <label for="client_no" class="font-weight-bold">Client ID: <span
                                            class="text-danger font-bold">*</span></label>
                                    <select name="client_no" id="client_no" class="form-control">
                                        <option
                                            value="{{ old('client_no') ?? (!empty($supportTicket) ? $supportTicket?->client?->client_no : '') }}">
                                            {{ old('client_link_no') ?? (!empty($supportTicket) ? $supportTicket?->client?->client_no : '') }}
                                        </option>
                                    </select>
                                    <input type="hidden" name="client_link_id" id="client_link_id">
                                </div>
                                <div class="col-6">
                                    <label for="fr_no" class="font-weight-bold">Connectivity Point<span
                                            class="text-danger font-bold">*</span></label>
                                    <select name="fr_no" id="fr_no" class="form-control">
                                        @if (!empty($supportTicket))
                                            @foreach ($fr_list as $key => $fr_no)
                                                <option value="{{ $fr_no }}"
                                                    @if (!empty($supportTicket->fr_no == $fr_no)) selected @endif>
                                                    {{ $key . ' (' . $fr_no . ')' }}</option>
                                            @endforeach
                                        @else
                                            <option value="">Select FR</option>
                                        @endif`
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-6">
                                    <label for="opening_time">Opening Time: <span
                                            class="text-danger font-bold">*</span></label>
                                    <input type="text" class="form-control" id="opening_time" name="opening_time"
                                        value="{{ old('opening_time') ?? (!empty($supportTicket) ? $supportTicket?->opening_date : \Carbon\Carbon::now()->format('d/m/Y H:i A')) }}"
                                        disabled>
                                </div>
                                <div class="col-6">
                                    <label for="complain_time">Complain Time:</label>
                                    <input type="datetime-local" class="form-control" id="complain_time"
                                        name="complain_time"
                                        value="{{ old('complain_time') ?? (!empty($supportTicket) ? $supportTicket?->complain_time : \Carbon\Carbon::now()->format('Y-m-d\TH:i:s')) }}">
                                </div>
                            </div>
                            <div class="row">


                                <div class="form-group col-6">
                                    <label for="support_complain_type_id">Complain Type: <span
                                        class="text-danger font-bold">*</span></label>
                                    <select class="form-control select2" id="support_complain_type_id"
                                        name="support_complain_type_id" required>
                                        <option value="" selected>Select Complain Type</option>
                                        @foreach ($complainTypes as $complainType)
                                            <option value="{{ $complainType->id }}"
                                                {{ old('support_complain_type_id', !empty($supportTicket) ? $supportTicket->support_complain_type_id : null) == $complainType->id ? 'selected' : '' }}>
                                                {{ $complainType->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-6">
                                    <label for="description">Description: <span
                                        class="text-danger font-bold">*</span></label>
                                    <input type="text" class="form-control" id="description" name="description"
                                        aria-describedby="description"
                                        value="{{ old('description') ?? (!empty($supportTicket) ? $supportTicket?->description : '') }}"
                                        placeholder="Description" required>
                                </div>
                                <div class="form-group col-6">
                                    <label for="ticket_source_id">Source: <span
                                            class="text-danger font-bold">*</span></label>
                                    <select class="form-control select2" id="ticket_source_id" name="ticket_source_id" required>
                                        <option value="20" selected>Select Source</option>
                                        @foreach ($ticketSources as $complainSource)
                                            <option value="{{ $complainSource->id }}"
                                                {{ old('ticket_source_id', !empty($supportTicket) ? $supportTicket->ticket_source_id : null) == $complainSource->id ? 'selected' : '' }}>
                                                {{ $complainSource->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-6">
                                    <label for="priority">Priority: <span
                                        class="text-danger font-bold">*</span></label>
                                    <select class="form-control select2" id="priority" name="priority" required>
                                        <option value="20" selected>Select Priority</option>
                                        @foreach ($priorities as $priority)
                                            <option value="{{ $priority }}"
                                                {{ old('priority', !empty($supportTicket) ? $supportTicket->priority : null) == $priority ? 'selected' : '' }}>
                                                {{ $priority }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-6">
                                    <label for="remarks">Remarks:</label>
                                    <input type="text" class="form-control" id="remarks" name="remarks"
                                        aria-describedby="remarks"
                                        value="{{ old('remarks') ?? (!empty($supportTicket) ? $supportTicket?->remarks : '') }}"
                                        placeholder="Remarks">
                                </div>


                            </div>



                            <p class="py-1 font-weight-bold">Mail</p>
                            <div class="form-group">
                                <label for="receiver_address">To:</label>
                                <input type="text" class="form-control" id="receiver_address" name="receiver_address"
                                    aria-describedby="receiver_address"
                                    value="{{ old('receiver_address') ?? (!empty($supportTicket) ? $supportTicket?->mail_to : '') }}"
                                    placeholder="To">
                            </div>
                            <div class="form-group">
                                <label for="cc">CC:</label>
                                <input type="text" class="form-control" id="cc" name="cc"
                                    aria-describedby="cc"
                                    value="{{ old('cc') ?? (!empty($supportTicket) ? $supportTicket?->cc : '') }}"
                                    placeholder="CC">
                            </div>
                            <div class="form-group">
                                <label for="subject">Subject:</label>
                                <input type="text" class="form-control" id="subject" name="subject"
                                    aria-describedby="subject"
                                    value="{{ old('subject') ?? (!empty($supportTicket) ? $supportTicket?->subject : '') }}"
                                    placeholder="Subject">
                            </div>
                            <div class="form-group">
                                <label for="body">Mail Description:</label>
                                <input type="text" class="form-control" id="body" name="body"
                                    aria-describedby="body"
                                    value="{{ old('body') ?? (!empty($supportTicket) ? $supportTicket?->body : '') }}"
                                    placeholder="Mail Description">
                            </div>
                        </div>

                        <div class="col-7">
                            <div class="row">
                                <div class="col-6 pt-4 px-0">
                                    <div class="d-flex align-items-center justify-content-space-between mb-2">
                                        <label class="d-flex align-items-center m-0 pr-1 col-4" for="name">Client Name
                                            <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control col-8" id="name" name="name"
                                            value="{{ old('name') ?? (!empty($supportTicket) ? $supportTicket?->client?->client_name : '') }}"
                                            placeholder="Client Name" disabled>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-space-between mb-2">
                                        <label class="d-flex align-items-center m-0 pr-1 col-4" for="contact_person">
                                            Contact Person</label>
                                        <input type="text" disabled class="form-control col-8" id="contact_person"
                                            value="{{ old('contact_person') ?? (!empty($supportTicket) ? $supportTicket?->client?->contact_person : '') }}"
                                            name="contact_person" placeholder="Contact Person">
                                    </div>
                                    <div class="d-flex align-items-center justify-content-space-between mb-2">
                                        <label class="d-flex align-items-center m-0 pr-1 col-4" for="email_address">
                                            E-mail Address</label>
                                        <input type="text" disabled class="form-control col-8" id="email_address"
                                            value="{{ old('email_address') ?? (!empty($supportTicket) ? $supportTicket?->client?->email : '') }}"
                                            name="email_address" placeholder="E-mail Address">
                                    </div>
                                </div>

                                <div class="col-6 pt-4 px-0">
                                    <div class="d-flex align-items-center justify-content-space-between mb-2">
                                        <label class="d-flex align-items-center m-0 pr-1 col-4" for="address">
                                            Address</label>
                                        <input type="text" class="form-control col-8" id="address" name="address"
                                            value="{{ old('address') ?? (!empty($supportTicket) ? $supportTicket?->client?->location : '') }}"
                                            placeholder="Address" disabled>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-space-between mb-2">
                                        <label class="d-flex align-items-center m-0 pr-1 col-4" for="contact_no"> Contact
                                            Number</label>
                                        <input type="text" class="form-control col-8" id="contact_no"
                                            value="{{ old('contact_no') ?? (!empty($supportTicket) ? $supportTicket?->client?->contact_no : '') }}"
                                            name="contact_no" placeholder="Contact Number" disabled>
                                    </div>
                                </div>

                                <div class="row pt-4 m-0 px-0" id="physical_connectivity">
                                    <div class="col-12">
                                        <h5 class="text-center">Physical Connectivity Information</h5>
                                        <hr />
                                    </div>
                                    @if (!empty($supportTicket->physicalConnectivity?->lines))
                                        @forelse ($supportTicket?->physicalConnectivity?->lines as $item)
                                            <div class="col-4">
                                                <div class="form-item">
                                                    <input type="text" id="link_type" name="link_type"
                                                        class="form-control" autocomplete="off"
                                                        value="{{ $item->link_type }}" readonly>
                                                    <label for="link_type">Link Type</label>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-item">
                                                    <input type="text" id="method" name="method"
                                                        class="form-control" autocomplete="off"
                                                        value="{{ $item->method }}" readonly>
                                                    <label for="method">Method</label>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-item">
                                                    <input type="text" id="ldp" name="ldp"
                                                        class="form-control" autocomplete="off"
                                                        value="{{ $item->ldp }}" readonly>
                                                    <label for="ldp">LDP</label>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-item">
                                                    <input type="text" id="switch_port" name="switch_port"
                                                        class="form-control" autocomplete="off"
                                                        value="{{ $item->port }}" readonly>
                                                    <label for="switch_port">Switch Port</label>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-item">
                                                    <input type="text" id="vlan" name="vlan"
                                                        class="form-control" autocomplete="off"
                                                        value="{{ $item->vlan }}" readonly>
                                                    <label for="vlan">VLAN</label>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-item">
                                                    <input type="text" id="switch_ip" name="switch_ip"
                                                        class="form-control" autocomplete="off"
                                                        value="{{ $item->device_ip }}" readonly>
                                                    <label for="switch_ip">Switch IP</label>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-item">
                                                    <input type="text" id="pop" name="pop"
                                                        class="form-control" autocomplete="off"
                                                        value="{{ $item->pop }}" readonly>
                                                    <label for="pop">POP</label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <hr />
                                            </div>
                                        @empty

                                            <div class="col-4">
                                                <div class="form-item">
                                                    <input type="text" id="link_type" name="link_type"
                                                        class="form-control" autocomplete="off" value="" required>
                                                    <label for="link_type">Link Type</label>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-item">
                                                    <input type="text" id="method" name="method"
                                                        class="form-control" autocomplete="off" value="" required>
                                                    <label for="method">Method</label>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-item">
                                                    <input type="text" id="ldp" name="ldp"
                                                        class="form-control" autocomplete="off" value="" required>
                                                    <label for="ldp">LDP</label>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-item">
                                                    <input type="text" id="switch_port" name="switch_port"
                                                        class="form-control" autocomplete="off" value="" required>
                                                    <label for="switch_port">Switch Port</label>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-item">
                                                    <input type="text" id="vlan" name="vlan"
                                                        class="form-control" autocomplete="off" value="" required>
                                                    <label for="vlan">VLAN</label>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-item">
                                                    <input type="text" id="switch_ip" name="switch_ip"
                                                        class="form-control" autocomplete="off" value="" required>
                                                    <label for="switch_ip">Switch IP</label>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-item">
                                                    <input type="text" id="pop" name="pop"
                                                        class="form-control" autocomplete="off" value="" required>
                                                    <label for="pop">POP</label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <hr />
                                            </div>
                                        @endforelse
                                    @endif
                                </div>

                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered" id="previousTickets">
                                            <thead>
                                                <tr>
                                                    <th>Ticket No.</th>
                                                    <th>Status</th>
                                                    <th>Date &amp; Time</th>
                                                    <th>Problem</th>
                                                    <th>Reason</th>
                                                    <th>Action</th>
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

                                <input type="hidden" name="opening_date"
                                    value="{{ encrypt(\Carbon\Carbon::now()->format('Y-m-d H:i:s')) }}" />

                            </div>
                        </div>

                    </div>

                    <div class="clear-both"></div>
                    <div class="row">
                        <div class="col-2">
                            <div class="form-group">
                                <label for="" class="d-block">Ticket Close:</label>

                                <div class="form-check-inline">
                                    <label class="form-check-label" for="closed">
                                        <input type="radio" class="form-check-input radioButton" id="closed"
                                            name="status" value="Closed" @checked(@$supportTicket->status == 'Closed' || old('status') == 'Closed')>
                                        <span style="position: relative; top: 3px">
                                            Yes
                                        </span>
                                    </label>
                                </div>

                                <div class="form-check-inline">
                                    <label class="form-check-label" for="opened">
                                        <input type="radio" class="form-check-input radioButton" id="opened"
                                            name="status" @checked(@$supportTicket->status != 'Closed' || (!empty(old('status')) ? old('status') != 'Closed' : '')) value="Pending">
                                        <span style="position: relative; top: 3px">
                                            No
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label for="" class="d-block">Mail Notification:</label>

                                <div class="form-check-inline">
                                    <label class="form-check-label" for="sendMail">
                                        <input type="radio" class="form-check-input radioButton" id="sendMail"
                                            name="mailNotification" value="1" @checked(@$supportTicket->mailNotification == '1' || old('mailNotification') == '1')>
                                        <span style="position: relative; top: 3px">
                                            Yes
                                        </span>
                                    </label>
                                </div>

                                <div class="form-check-inline">
                                    <label class="form-check-label" for="noMailNotification">
                                        <input type="radio" checked class="form-check-input radioButton"
                                            id="noMailNotification" name="mailNotification" @checked(@$supportTicket->mailNotification == '0' || old('mailNotification') == '0')
                                            value="0">
                                        <span style="position: relative; top: 3px">
                                            No
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label for="" class="d-block">SMS Notification:</label>

                                <div class="form-check-inline">
                                    <label class="form-check-label" for="smsNotification">
                                        <input type="radio" class="form-check-input radioButton" id="smsNotification"
                                            name="smsNotification" value="1" @checked(@$supportTicket->smsNotification == '1' || old('smsNotification') == '1')>
                                        <span style="position: relative; top: 3px">
                                            Yes
                                        </span>
                                    </label>
                                </div>

                                <div class="form-check-inline">
                                    <label class="form-check-label" for="noSmsNotification">
                                        <input type="radio" checked class="form-check-input radioButton"
                                            id="noSmsNotification" name="smsNotification" @checked(@$supportTicket->smsNotification == '0' || old('smsNotification') == '0')
                                            value="0">
                                        <span style="position: relative; top: 3px">
                                            No
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="formSubmit">
                        <div class="col-3 mx-auto">
                            <div class="mx-auto mt-2">
                                <div class="input-group input-group-sm ">
                                    <button class="btn btn-success btn-round btn-block py-2">Submit</button>
                                </div>
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
        $(document).ready(function() {
            select2Ajax("{{ url('ticketing/get-clients-st') }}", '#client_no');
            $('#support_complain_type_id').select2({
                placeholder: "Select Complain Type",
            })
        });

        $('#client_no').on('select2:select', function(e) {
            let clientId = e.params.data.fullObject?.client?.id
            let fr_no = '<option value="">Select FR</option>';
            $.each(e.params.data.fullObject?.fr_list, function(index, item) {
                fr_no += '<option value="' + item + '">' + index + ' (' + item + ')' + '</option>'
            });
            $("#fr_no").html(fr_no)
            $("#fr_no").select2();
            $('#name').val(e.params.data.fullObject?.client_name)
            $('#address').val(e.params.data.fullObject?.address)
            $('#contact_person').val(e.params.data.fullObject?.contact_person)
            $('#contact_no').val(e.params.data.fullObject?.contact_no)
            $('#email_address').val(e.params.data.fullObject?.email)
            $("#client_link_id").val(e.params.data.fullObject?.text)
        });

        $('#fr_no').on('select2:select', function(e) {
            var html = `<div class="col-12">
                            <h5 class="text-center">Physical Connectivity Information</h5>
                            <hr />
                        </div>`;
            let fr_no = e.params.data.id;
            let clientId = $("#client_no").val();
            getClientsPreviousTickets(fr_no, 5)

            $.ajax({
                url: "{{ url('get-links-by-fr') }}" + "/" + clientId + "/" + fr_no,
                type: 'get',
                dataType: "json"
            }).done(function(data) {
                $.each(data.lines, function(index, item) {
                    html += `
                        <div class="col-4">
                            <div class="form-item">
                                <input type="text" id="link_type" name="link_type" class="form-control" autocomplete="off" value="${item.link_type}" readonly>
                                <label for="link_type">Link Type</label>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-item">
                                <input type="text" id="method" name="method" class="form-control" autocomplete="off" value="${item.method}" readonly>
                                <label for="method">Method</label>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-item">
                                <input type="text" id="ldp" name="ldp" class="form-control" autocomplete="off" value="${item.ldp}" readonly>
                                <label for="ldp">LDP</label>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-item">
                                <input type="text" id="switch_port" name="switch_port" class="form-control" autocomplete="off" value="${item.port}" readonly>
                                <label for="switch_port">Switch Port</label>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-item">
                                <input type="text" id="vlan" name="vlan" class="form-control" autocomplete="off" value="${item.vlan}" readonly>
                                <label for="vlan">VLAN</label>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-item">
                                <input type="text" id="switch_ip" name="switch_ip" class="form-control" autocomplete="off" value="${item.device_ip}" readonly>
                                <label for="switch_ip">Switch IP</label>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-item">
                                <input type="text" id="pop" name="pop" class="form-control" autocomplete="off" value="${item.pop}" readonly>
                                <label for="pop">POP</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <hr />
                        </div>
                        `;
                });

                $("#physical_connectivity").empty();
                $("#physical_connectivity").html(html);
            });
        });


        function getClientsPreviousTickets(fr_no, limit = 5) {
            $.ajax({
                url: "{{ url('get-clients-previous-tickets') }}" + "/" + fr_no + "/" + limit,
                type: 'get',
                dataType: "json"
            }).done(function(data) {
                var tickets = data;

                // find if any tickets status is Pending
                var pendingTickets = tickets.filter(function(ticket) {
                    return ticket.status == "Pending";
                });

                // if (pendingTickets.length > 0) {
                //     alert('This client already have pending tickets. Please see the ticket list.');
                //     $("#formSubmit").find("button").css("display", "none");
                // } else {
                //     $("#formSubmit").find("button").removeAttr("style");
                // }

                // run foreach data
                var tableData = '';
                $.each(tickets, function(key, value) {
                    // console.console.log();
                    var inputDate = value.ticket_no
                    // Extract the date parts
                    var year = inputDate.substring(0, 2);
                    var month = inputDate.substring(2, 4);
                    var day = inputDate.substring(4, 6);
                    var restOfString = inputDate.substring(6);

                    // Create the new date string in the desired format
                    var newDateString = day + month + year + restOfString;
                    tableData += '<tr>';
                    tableData += '<td>' + newDateString + '</td>';
                    tableData += '<td>' + value.status + '</td>';
                    tableData += '<td>' + value.opening_date + '</td>';
                    tableData += '<td>' + value.support_complain_type.name + '</td>';
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



        // $('#complain_time').datepicker({
        //     format: "dd-mm-yyyy hh:mm",
        //     autoclose: true,
        //     todayHighlight: true,
        //     showOtherMonths: true,
        // }).datepicker("setDate", new Date());
    </script>
@endsection
