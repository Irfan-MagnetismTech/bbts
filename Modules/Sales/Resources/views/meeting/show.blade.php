@extends('layouts.backend-layout')
@section('title', 'Meeting Details')

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
Meeting
@endsection

@section('style')

@endsection
@section('breadcrumb-button')
<a href="{{ route('meeting.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-plus"></i></a>
<a href="{{ route('meeting.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection
@section('sub-title')
Meeting Client: {{ $meeting->client->client_name }}
@endsection


@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <!-- table  -->
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered" style="font-size: 12px;">
                            <tr>
                                <th>Client Name</th>
                                <td>{{ $meeting->client->client_name }}</td>
                                <th>Visit Date</th>
                                <td>{{ $meeting->visit_date }}</td>
                            </tr>
                            <tr>
                                <th>Sale Representative</th>
                                <td>{{ $meeting->sales_representative }}</td>
                                <th>Place of Visit</th>
                                <td>{{ $meeting->meeting_place }}</td>
                            </tr>
                            <tr>
                                <th>Time of Work Ended</th>
                                <td>{{ $meeting->meeting_end_time }}</td>
                                <th>Time of Work Started</th>
                                <td>{{ $meeting->meeting_start_time }}</td>
                            </tr>
                            <tr>
                                <th>Contact Person</th>
                                <td>{{ $meeting->client->contact_person }}</td>
                                <th>Designation</th>
                                <td>{{ $meeting->client->designation }}</td>
                            </tr>
                            <tr>
                                <th>Contact No</th>
                                <td>{{ $meeting->client->contact_no }}</td>
                                <th>Email</th>
                                <td>{{ $meeting->client->email }}</td>
                            </tr>
                            <tr>
                                <th>Purpose</th>
                                <td colspan="3" class="text-left">{{ $meeting->purpose }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src=" {{ asset('js/Datatables/jquery.dataTables.min.js') }}">
</script>
<script src="{{ asset('js/Datatables/dataTables.bootstrap4.min.js') }}"></script>
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