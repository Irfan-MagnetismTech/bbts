@extends('layouts.backend-layout')
@section('title', 'Employee Details')

@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
<style>
    td{
        text-align: left;
        padding-left: 20px;
        word-break: break-all;
        white-space: normal !important;
    }
</style>
@endsection

@section('breadcrumb-title')
Employee Details
@endsection


@section('breadcrumb-button')
<a href="{{ url('employees/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('content')
<div class="card-">
    <div class="card-">
        <img src="{{ asset('/images/Employees') }}/{{ $employee->picture }}" alt="" class="img-rounded" width="100px" height="80px">
    </div>
    <div class="card-">
        <table>
            <tr>
                <th>
                    Name:
                </th>
                <td>
                    {{ $employee->name }}
                </td>
            </tr>
            <tr>
                <th>
                    Department:
                </th>
                <td>
                    {{ $employee->department->name }}
                </td>
            </tr>
            <tr>
                <th>
                    Designation:
                </th>
                <td>
                    {{ $employee->designation->name }}
                </td>
            </tr>
            <tr>
                <th>
                    NID:
                </th>
                <td>
                    {{ $employee->nid }}
                </td>
            </tr>
            <tr>
                <th>
                    Date of Birth:
                </th>
                <td>
                    {{ $employee->dob }}
                </td>
            </tr>
            <tr>
                <th>
                    Contact:
                </th>
                <td>
                    {{ $employee->contact }}
                </td>
            </tr>
            <tr>
                <th>
                    Email:
                </th>
                <td>
                    {{ $employee->email }}
                </td>
            </tr>
            <tr>
                <th>
                    Blood Group:
                </th>
                <td>
                    {{ $employee->blood_group }}
                </td>
            </tr>
            <tr>
                <th>
                    Emergency Contact:
                </th>
                <td>
                    {{ $employee->emergency }}
                </td>
            </tr>
            <tr>
                <th>
                    Father:
                </th>
                <td>
                    {{ $employee->father }}
                </td>
            </tr>
            <tr>
                <th>
                    Mother:
                </th>
                <td>
                    {{ $employee->mother }}
                </td>
            </tr>
            <tr>
                <th>
                    Joining Date:
                </th>
                <td>
                    {{ $employee->joining_date }}
                </td>
            </tr>
            <tr>
                <th>
                    Reference:
                </th>
                <td>
                    {{ $employee->reference }}
                </td>
            </tr>
            <tr>
                <th>
                    Job Experience:
                </th>
                <td>
                    {{ $employee->job_experience }}
                </td>
            </tr>
        </table>
        <div class="row mt-3">
            <div class="col-md-6">
            <h4>Present Address</h4>
            <table>
                    <tr>
                        <th>
                            Address:
                        </th>
                        <td>
                            {{ $employee->pre_street_address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Division:
                        </th>
                        <td>
                            {{ $employee->preThana->district->division->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            District:
                        </th>
                        <td>
                        {{ $employee->preThana->district->name }}

                        </td>
                    </tr>
                    <tr>
                        <th>
                            Thana:
                        </th>
                        <td>
                        {{ $employee->preThana->name }}

                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
            <h4>Permanent Address</h4>

                <table>
                    <tr>
                        <th>
                            Address:
                        </th>
                        <td>
                            {{ $employee->per_street_address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Division:
                        </th>
                        <td>
                            {{ $employee->perThana->district->division->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            District:
                        </th>
                        <td>
                        {{ $employee->perThana->district->name }}

                        </td>
                    </tr>
                    <tr>
                        <th>
                            Thana:
                        </th>
                        <td>
                        {{ $employee->perThana->name }}

                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{asset('js/Datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('js/Datatables/dataTables.bootstrap4.min.js')}}"></script>
<script>
    $(window).scroll(function() {
        //set scroll position in session storage
        sessionStorage.scrollPos = $(window).scrollTop();
    });
    var init = function() {
        //get scroll position in session storage
        $(window).scrollTop(sessionStorage.scrollPos || 0)
    };
    window.onload = init;

    $(document).ready(function() {
        $('#dataTable').DataTable({
            stateSave: true
        });
    });
</script>
@endsection
