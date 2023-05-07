@extends('layouts.backend-layout')
@section('title', 'Meeting Details')

@section('style')

    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    Meeting
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
            <div class="card-header">
                <h5>Client Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table custom_table table-bordered" id="client_table" style="font-size: 12px;">
                                <tr>
                                    <th>Client Name</th>
                                    <td>{{ $meeting->client->client_name }}</td>
                                    <th>Address</th>
                                    <td>{{ $meeting->client->address }}</td>
                                </tr>
                                <tr>
                                    <th>Division</th>
                                    <td>{{ $meeting->client->division->name ?? '' }}</td>
                                    <th>District</th>
                                    <td>{{ $meeting->client->district->name ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th>Thana</th>
                                    <td>{{ $meeting->client->thana->name ?? '' }}</td>
                                    <th>Landmark</th>
                                    <td>{{ $meeting->client->landmark }}</td>
                                </tr>
                                <tr>
                                    <th>Lat-Long</th>
                                    <td>{{ $meeting->client->lat_long }}</td>
                                    <th>Contact Person</th>
                                    <td>{{ $meeting->client->contact_person }}</td>
                                </tr>
                                <tr>
                                    <th>Contact No</th>
                                    <td>{{ $meeting->client->contact_no }}</td>
                                    <th>Email</th>
                                    <td>{{ $meeting->client->email }}</td>
                                </tr>
                                <tr>
                                    <th>Website</th>
                                    <td>{{ $meeting->client->website }}</td>
                                    <th>Document</th>
                                    <td>
                                        @if ($meeting->client->document)
                                            <a href="{{ asset('uploads/lead_generation/' . $meeting->client->document) }}"
                                                target="_blank" class="btn btn-sm btn-warning" style="font-size:14px;"><i
                                                    class="fas fa-eye"></i></a>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-header">
                <h5>Schedule Meeting Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- table  -->
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table custom_table table-bordered" id="meeting_info" style="font-size: 12px;">
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
            @if ($previous_meetings->count() > 0)
                <div class="card-header">
                    <h5>Previous Meetings</h5>
                </div>
            @endif
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered" style="font-size: 12px;">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Date</th>
                                        <th>Meeting Time</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($previous_meetings as $key => $previous_meeting)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $previous_meeting->visit_date }}</td>
                                            <td>{{ $previous_meeting->meeting_start_time }} To
                                                {{ $previous_meeting->meeting_end_time }}</td>
                                            <td>{{ $previous_meeting->sales_representative }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{ Form::open([
                'route' => ['meeting.status.update', $meeting->id],
                'method' => 'get',
                'id' => 'content_form',
            ]) }}
            <div class="d-flex justify-content-around mt-2 mb-2">
                <button type="submit" name="status" value="Accept" class="btn btn-outline-success">Accept</button>
                <button type="submit" name="status" value="Deny" class="btn btn-outline-danger">Deny</button>
                <button type="submit" name="status" value="Re-Schedule"
                    class="btn btn-outline-warning">Re-Schedule</button>
                <button type="submit" name="status" value="Cancel" class="btn btn-outline-info">Cancel</button>
            </div>
            {{ Form::close() }}
        </div>

    </div>
@endsection
@section('script')
    <script src=" {{ asset('js/Datatables/jquery.dataTables.min.js') }}"></script>
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
    </script>
@endsection
