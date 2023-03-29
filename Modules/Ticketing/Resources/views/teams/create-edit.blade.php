@extends('layouts.backend-layout')
@section('title', 'Support Team')

@section('style')
    
@endsection

@section('breadcrumb-title')
    @if (!empty($supportTeam))
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

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
    <div class="col-md-10 mx-auto">
        <div class="row">
            <div class="col-md-12">
                <form
                action="{{ (!empty($supportTeam)) ? route('support-teams.update', ['support_team' => $supportTeam->id]) : route('support-teams.store') }}"
                method="post" class="custom-form">
                @if (!empty($supportTeam))
                    @method('PUT')
                @else
                    @method('POST')
                @endif
                @csrf
                
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="department_id">Department Name:</label>

                            <select name="department_id" id="department_id" class="form-control">
                                <option value="">Select Department</option>
                                @foreach($departments as $department)
                                <option value="{{ $department->id }}" 
                                    {{ old('department_id', (!empty($supportTeam) ? $supportTeam?->department_id : '')) == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="form-group col-6">
                            <label for="user_name">Department Head:</label>

                            <input type="text" class="form-control" id="user_name" name="user_name" aria-describedby="user_name"
                                value="{{ old('user_name') ?? (!empty($supportTeam) ? $supportTeam?->user?->name : '') }}" placeholder="Department Head" required>

                            <input type="hidden" class="form-control" id="user_id" name="user_id" aria-describedby="user_id"
                                value="{{ old('user_id') ?? (!empty($supportTeam) ? $supportTeam->user_id : '') }}">
                        </div>
                    </div>

                    <strong>Team Members</strong>
                    <div class="dt-responsive table-responsive">
                        <table class="table table-striped table-bordered" id="teamMembers">
                            <thead>
                            <tr>
                                <th>#SL</th>
                                <th>Name</th>
                                <th>Designation</th>
                                <th>Type</th>
                                <th>Action<i class="btn btn-primary btn-sm fa fa-plus add-more ml-2"></i></th>
                            </tr>
                            </thead>
                            <tbody>
                                @if(empty($supportTeam) || empty($supportTeam?->supportTeamMembers))
                                <tr>
                                    <td>1</td>
                                    <td>
                                        <input type="text" value="" placeholder="Search Employee" class="user-search form-control" />
                                        <input type="hidden" name="users_id[]" value="" placeholder="Search Employee" class="member_id form-control" />
                                    </td>
                                    <td></td>
                                    <td>
                                        <select name="type[]" class="form-control">
                                            @foreach($levels as $id => $level)
                                             <option value="{{ $id }}">{{ $level }}</option>
                                            @endforeach
                                         </select> 
                                    </td>
                                    <td><i class="btn btn-danger btn-sm fa fa-minus remove-row"></i></td>
                                </tr>
                                @else
                                    @foreach($supportTeam->supportTeamMembers as $teamMember)
                                        <tr>
                                            <td>{{ $loop->index+1 }}</td>
                                            <td>
                                                
                                                <input type="text" value="{{ $teamMember->user->name }}" placeholder="Search Employee" class="user-search form-control" />
                                                <input type="hidden" name="users_id[]" value="{{ $teamMember->user_id }}" placeholder="Search Employee" class="member_id form-control" />
                                            </td>
                                            <td>{{ $teamMember?->user?->employee?->designation?->name }}</td>
                                            <td>
                                                <select name="type[]" class="form-control">
                                                    @foreach($levels as $id => $level)
                                                     <option value="{{ $id }}" {{ ($teamMember?->type == $id) ? 'selected' : null }}>{{ $level }}</option>
                                                    @endforeach
                                                 </select> 
                                            </td>
                                            <td><i class="btn btn-danger btn-sm fa fa-minus remove-row"></i></td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
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
                    $("#department_id").val(ui.item.value)
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
                    $("#user_id").val(ui.item.value)
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

        $(".add-more").on("click", function() {
        
            let length = parseInt($("#teamMembers tbody tr").length) + parseInt(1);
            let tableRow = `<tr>
                                <td>${length}</td>
                                <td>
                                    <input type="text" value="" placeholder="Search Employee" class="user-search form-control" />
                                    <input type="hidden" name="users_id[]" value="" placeholder="Search Employee" class="member_id form-control" />

                                </td>
                                <td></td>
                                <td>
                                    <select name="type[]" class="form-control">
                                       @foreach($levels as $id => $level)
                                        <option value="{{ $id }}">{{ $level }}</option>
                                       @endforeach
                                    </select> 
                                </td>
                                <td><i class="btn btn-danger btn-sm fa fa-minus remove-row"></i></td>
                            </tr>`
            
            $("#teamMembers tbody").append(tableRow)

        });

        $("table").on("click", ".remove-row",  function() {
            $(this).closest("tr").remove();
        })
</script>
@endsection
