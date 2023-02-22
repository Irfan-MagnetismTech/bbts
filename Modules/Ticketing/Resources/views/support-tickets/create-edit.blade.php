@extends('layouts.backend-layout')
@section('title', 'Support Team')

@section('style')
    
@endsection

@section('breadcrumb-title')
    @if (!empty($supportTicket))
    Edit Support Team
    @else
    Create New Support Team
    @endif
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('support-teams.index')}}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('content-grid', 'col-12 my-3')

@section('content')
    <div class="col-md-12 mx-auto">
        <div class="row">
            <div class="col-md-12">
                <form
                action="{{ (!empty($supportTicket)) ? route('support-teams.update', ['support_team' => $supportTicket->id]) : route('support-teams.store') }}"
                method="post" class="custom-form">
                @if (!empty($supportTicket))
                    @method('PUT')
                @else
                    @method('POST')
                @endif
                @csrf
                
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="departments_id">Client Link ID:</label>
                                <input type="text" class="form-control" id="clients_id" name="clients_id" aria-describedby="clients_id"
                                    value="{{ old('clients_id') ?? (!empty($supportTicket) ? $supportTicket?->clients_id : '') }}" placeholder="Client Link ID">
                            </div>
                            <div class="form-group">
                                <label for="departments_id">Complain Type:</label>
                                <input type="text" class="form-control" id="complain_types_id" name="complain_types_id" aria-describedby="complain_types_id"
                                    value="{{ old('complain_types_id') ?? (!empty($supportTicket) ? $supportTicket?->complain_types_id : '') }}" placeholder="Complain Type">
                            </div>
                            <div class="form-group">
                                <label for="departments_id">Description:</label>
                                <input type="text" class="form-control" id="description" name="description" aria-describedby="description"
                                    value="{{ old('description') ?? (!empty($supportTicket) ? $supportTicket?->description : '') }}" placeholder="Description">
                            </div>
                            <div class="form-group">
                                <label for="departments_id">Source:</label>
                                <input type="text" class="form-control" id="source" name="source" aria-describedby="source"
                                    value="{{ old('source') ?? (!empty($supportTicket) ? $supportTicket?->source : '') }}" placeholder="Source">
                            </div>
                            <div class="form-group">
                                <label for="departments_id">Remarks:</label>
                                <input type="text" class="form-control" id="remarks" name="remarks" aria-describedby="remarks"
                                    value="{{ old('remarks') ?? (!empty($supportTicket) ? $supportTicket?->remarks : '') }}" placeholder="Remarks">
                            </div>
                            <p class="py-1 font-weight-bold">Mail</p>
                            <div class="form-group">
                                <label for="departments_id">To:</label>
                                <input type="text" class="form-control" id="receiver_address" name="receiver_address" aria-describedby="receiver_address"
                                    value="{{ old('receiver_address') ?? (!empty($supportTicket) ? $supportTicket?->mail_to : '') }}" placeholder="To">
                            </div>
                            <div class="form-group">
                                <label for="departments_id">CC:</label>
                                <input type="text" class="form-control" id="cc" name="cc" aria-describedby="cc"
                                    value="{{ old('cc') ?? (!empty($supportTicket) ? $supportTicket?->cc : '') }}" placeholder="CC">
                            </div>
                            <div class="form-group">
                                <label for="departments_id">Subject:</label>
                                <input type="text" class="form-control" id="subject" name="subject" aria-describedby="subject"
                                    value="{{ old('subject') ?? (!empty($supportTicket) ? $supportTicket?->subject : '') }}" placeholder="Subject">
                            </div>
                            <div class="form-group">
                                <label for="departments_id">Mail Description:</label>
                                <input type="text" class="form-control" id="body" name="body" aria-describedby="body"
                                    value="{{ old('body') ?? (!empty($supportTicket) ? $supportTicket?->body : '') }}" placeholder="Mail Description">
                            </div>
                            <div class="form-group">
                                <label for="departments_id" class="d-block">Ticket Close:</label>
                                
                                <div class="form-check-inline">
                                    <label class="form-check-label" for="opened">
                                        <input type="radio" class="form-check-input radioButton" id="opened" name="status" value="opened" @checked((@$supportTicket->status == "opened") || (old('status') == 'opened')) 
                                        >
                                        <span style="position: relative; top: 3px">
                                            Yes
                                        </span>
                                    </label>
                                </div>
        
                                <div class="form-check-inline">
                                    <label class="form-check-label" for="closed">
                                        <input type="radio" class="form-check-input radioButton" id="closed" name="status" @checked((@$supportTicket->status == "closed") || (old('status') == 'closed'))
                                            value="closed">
                                        <span style="position: relative; top: 3px">
                                            No
                                        </span>
                                    </label>
                                </div>
                            </div>

                        </div>

                        <div class="col-8">
                            <div class="row">
                                <div class="col-6 pt-4 px-0">
                                    <div class="d-flex align-items-center justify-content-space-between mb-2">
                                        <label class="d-flex align-items-center m-0 pr-1 col-4" for="name">Client Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control col-8" id="name" name="name" placeholder="Enter branch name" value="" required="">
                                    </div>
                                    <div class="d-flex align-items-center justify-content-space-between mb-2">
                                        <label class="d-flex align-items-center m-0 pr-1 col-4" for="contact_person"> Contact Person</label>
                                        <input type="text" class="form-control col-8" id="contact_person" name="contact_person" placeholder="Contact Person" value="">
                                    </div>
                                    <div class="d-flex align-items-center justify-content-space-between mb-2">
                                        <label class="d-flex align-items-center m-0 pr-1 col-4" for="email_address"> E-mail Address</label>
                                        <input type="text" class="form-control col-8" id="email_address" name="email_address" placeholder="E-mail Address" value="">
                                    </div>
                                    <div class="d-flex align-items-center justify-content-space-between mb-2">
                                        <label class="d-flex align-items-center m-0 pr-1 col-4" for="switch_port"> Switch Port</label>
                                        <input type="text" class="form-control col-8" id="switch_port" name="switch_port" placeholder="Switch Port" value="">
                                    </div>
                                    <div class="d-flex align-items-center justify-content-space-between mb-2">
                                        <label class="d-flex align-items-center m-0 pr-1 col-4" for="vlan"> VLAN</label>
                                        <input type="text" class="form-control col-8" id="vlan" name="vlan" placeholder="VLAN" value="">
                                    </div>

                                </div>
                                <div class="col-6 pt-4 px-0">
                                    <div class="d-flex align-items-center justify-content-space-between mb-2">
                                        <label class="d-flex align-items-center m-0 pr-1 col-4" for="address"> Address</label>
                                        <input type="text" class="form-control col-8" id="address" name="address" placeholder="Address" value="">
                                    </div>
                                    <div class="d-flex align-items-center justify-content-space-between mb-2">
                                        <label class="d-flex align-items-center m-0 pr-1 col-4" for="contact_no"> Contact Number</label>
                                        <input type="text" class="form-control col-8" id="contact_no" name="contact_no" placeholder="Contact Number" value="">
                                    </div>
                                    <div class="d-flex align-items-center justify-content-space-between mb-2">
                                        <label class="d-flex align-items-center m-0 pr-1 col-4" for="switch_ip"> Switch IP</label>
                                        <input type="text" class="form-control col-8" id="switch_ip" name="switch_ip" placeholder="Switch IP" value="">
                                    </div>
                                    <div class="d-flex align-items-center justify-content-space-between mb-2">
                                        <label class="d-flex align-items-center m-0 pr-1 col-4" for="pop"> POP</label>
                                        <input type="text" class="form-control col-8" id="pop" name="pop" placeholder="POP" value="">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="dt-responsive table-responsive">
                                        <table id="dataTable" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Ticket No.</th>
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
                                        <table>
                                    </div>

                                    
                                    
                                </div>

                                    <div class="mx-auto col-md-4 mt-2">
                                        <div class="input-group input-group-sm ">
                                            <button class="btn btn-success btn-round btn-block py-2">Submit</button>
                                        </div>
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
        $(document).on('keyup focus', '#department_name', function() {
            $(this).autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ url('search-department') }}",
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
                    $("#department_name").val(ui.item.label)
                    $("#departments_id").val(ui.item.value)
                    return false;
                }
            });
        });

        $(document).on('keyup focus', '#user_name', function() {
            $(this).autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ url('search-user') }}",
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
                    $("#user_name").val(ui.item.label)
                    $("#employee_id").val(ui.item.value)
                    return false;
                }
            });
        });

        $(document).on('keyup focus', '.user-search', function() {
            $(this).autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ url('search-user') }}",
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
                    let currentRow = $(this).closest("tr")
                    $(currentRow).find("td:nth-child(3)").html(ui.item.designation);
                    $(currentRow).find("td:nth-child(2)").find('.user-search').val(ui.item.label);
                    $(currentRow).find("td:nth-child(2)").find('.member_id').val(ui.item.value);
                    
                    return false;
                }
            });
        });
</script>
@endsection