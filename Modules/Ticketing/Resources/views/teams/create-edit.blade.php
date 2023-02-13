@extends('layouts.backend-layout')
@section('title', 'Support Tickets')

@section('style')
    
@endsection

@section('breadcrumb-title')
   Create New Support Team
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
                action="{{ ($formType == 'edit') ? route('support-teams.update', $requisition->id) : route('support-teams.store') }}"
                method="post" class="custom-form">
                @if ($formType == 'edit')
                    @method('PUT')
                @endif
                @csrf
                
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="department_id">Department Name:</label>
                            <input type="text" class="form-control" id="department_name" name="department_name" aria-describedby="department_name"
                                value="{{ old('department_name') ?? ($team->department_name ?? '') }}" placeholder="Department Name">

                            <input type="hidden" class="form-control" id="department_id" name="department_id" aria-describedby="department_id"
                                value="{{ old('department_id') ?? ($team->department_id ?? '') }}">
                        </div>
                        <div class="form-group col-6">
                            <label for="user_id">Department Head:</label>

                            <input type="text" class="form-control" id="employee_name" name="employee_name" aria-describedby="employee_name"
                                value="{{ old('employee_name') ?? ($team->employee_name ?? '') }}" placeholder="Department Head">

                            <input type="hidden" class="form-control" id="user_id" name="user_id" aria-describedby="user_id"
                                value="{{ old('user_id') ?? ($team->user_id ?? '') }}">
                        </div>
                    </div>

                    Team Members
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
                                <tr>
                                    <td>1</td>
                                    <td>
                                        <input type="text" value="" placeholder="Search Employee" class="employee-search form-control" />
                                        <input type="hidden" name="user_id[]" value="" placeholder="Search Employee" class="form-control" />
                                    </td>
                                    <td></td>
                                    <td>
                                        <select name="type[]" class="form-control">
                                            <option>Level 1</option>
                                            <option>Level 2</option>
                                            <option>Level 3</option>
                                        </select> 
                                    </td>
                                    <td><i class="btn btn-danger btn-sm fa fa-minus remove-row"></i></td>
                                </tr>
                            </tbody>
                        </table>
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

        $(document).on('keyup focus', '#employee_name', function() {
            $(this).autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ url('search-employee') }}",
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
                    $("#employee_name").val(ui.item.label)
                    $("#employee_id").val(ui.item.value)
                    return false;
                }
            });
        });

        $(document).on('keyup focus', '.employee-search', function() {
            $(this).autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ url('search-employee') }}",
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
                    $(currentRow)
                    return false;
                }
            });
        });


        $(".add-more").on("click", function() {
        
            let length = parseInt($("#teamMembers tbody tr").length) + parseInt(1);
            let tableRow = `<tr>
                                <td>${length}</td>
                                <td>
                                    <input type="text" name="user_id[]" value="" placeholder="Search Employee" class="employee-search form-control" />
                                </td>
                                <td></td>
                                <td>
                                    <select name="type[]" class="form-control">
                                        <option>Level 1</option>
                                        <option>Level 2</option>
                                        <option>Level 3</option>
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
