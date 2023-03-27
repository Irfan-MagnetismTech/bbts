@extends('layouts.backend-layout')
@section('title', 'Support Team')

@section('style')
    
@endsection

@section('breadcrumb-title')
   {{ ucfirst($movementType) }} Ticket
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('support-tickets.index')}}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
    <div class="col-md-10 mx-auto">
        <div class="row">
            <div class="col-md-12">
                <form
                action="{{ ($movementType == $movementTypes[0]) ? route('process-ticket-movements', ['type' => $movementType, 'id' => $ticketId]) : (($movementType == $movementTypes[1] ? route('process-backward-ticket-movements', ['type' => $movementType, 'id' => $ticketId]) : null)) }}"
                method="post" class="custom-form">
                
                @csrf
                    <div class="row">
                        <div class="col-8 mx-auto">
                            <div class="form-group">
                                <label for="support_ticket_id">Ticket ID:</label>
                                <input type="text" class="form-control" id="support_ticket_id" name="support_ticket_id" aria-describedby="support_ticket_id"
                                    value="{{ old('support_ticket_id') ?? (!empty($supportTicket) ? $supportTicket?->ticket_no : '') }}" placeholder="Ticket ID" disabled>
                            </div>
                            <div class="form-group">
                                <label for="status">Status:</label>
                                <input type="text" class="form-control" id="status" name="status" aria-describedby="status"
                                    value="{{ old('status') ?? (!empty($supportTicket) ? $supportTicket?->status : '') }}" placeholder="Status" disabled>
                            </div>
                            @if($movementType != $movementTypes[1] || $movementType == $movementTypes[2])

                            @if($movementType != $movementTypes[2])
                            <div class="form-group">
                                <label for="movement_to">Assign to Department Name:</label>
                                <select name="movement_to" id="movement_to" class="form-control team">
                                    <option value="">Select Team</option>
                                    @foreach($supportTeams as $team)
                                    <option value="{{ $team->id }}"
                                    >{{ $team->department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            
                            <div class="form-group" style="display: block">
                                <label for="movement_to">Select Team Member</label>
                                <select name="teamMemberId" id="teamMemberList" class="form-control">
                                    <option value="">Select Team Member</option>
                                </select>
                            </div>
                            @endif
                            <div class="form-group">
                                <label for="remarks">Remarks:</label>
                                <textarea class="form-control" id="remarks" name="remarks" aria-describedby="remarks"
                                    placeholder="Remarks" style="min-height: 100px !important; "></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <input type="hidden" name="ticket_id" value="{{ $ticketId }}">
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
    $('.team').on('change', function() {
        $.ajax({
            url: "{{ url('get-support-team-members') }}",
            type: 'get',
            dataType: "json",
            data: {
                search: $(this).val()
            },
            success: function(data) {
                console.log(data)
                var teamMembers = data.support_team_members
                var memberInfo = '<option value="">Select a Team Member</option>';
                $.each(teamMembers, function(key, value) {
                    memberInfo += '<option value="' + value.user_id + '">' + value.user.name + '</option>';
                });

                $('#teamMemberList').html(null);
                $('#teamMemberList').html(memberInfo);

            }
        });
    });
</script>
@endsection
