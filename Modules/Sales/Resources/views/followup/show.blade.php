@extends('layouts.backend-layout')
@section('title', 'Follow Up Details')

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
Follow Up Details
@endsection

@section('style')

@endsection
@section('breadcrumb-button')
<a href="{{ route('followup.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-plus"></i></a>
<a href="{{ route('followup.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection
@section('sub-title')
Meeting Client: {{ $followup->client->client_name }}
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
                                <td>{{ $followup->client->client_name }}</td>
                                <th>Address</th>
                                <td>{{ $followup->client->address }}</td>
                            </tr>
                            <tr>
                                <th>Activity Date</th>
                                <td>{{ $followup->activity_date }}</td>
                                <th>Time of Work Started</th>
                                <td>{{ $followup->work_start_time }}</td>
                            </tr>
                            <tr>
                                <th>Time of Work Ended</th>
                                <td>{{ $followup->work_end_time }}</td>
                                <th>Nature of Work</th>
                                <td>{{ $followup->work_nature_type }}</td>
                            </tr>
                            <tr>
                                <th>Types of Sales Call</th>
                                <td>{{ $followup->sales_type }}</td>
                                <th>Potentility Amount</th>
                                <td>{{ $followup->potentility_amount }}</td>
                            </tr>
                            <tr>
                                <th>Meeting Outcome</th>
                                <td colspan="3" class="text-left">{{ $followup->meeting_outcome }}</td>
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