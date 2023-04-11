@extends('layouts.backend-layout')
@section('title', 'Meeting List')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    Meeting List
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('meeting.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-plus"></i></a>
@endsection
@section('sub-title')
    Total: {{ count($meetings) }}
@endsection


@section('content')
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Client Name</th>
                    <th>Visit Date</th>
                    <th>Time of Work Started</th>
                    <th>Time of Work Ended</th>
                    <th>Contact Person</th>
                    <th>Phone</th>
                    <th>Purpose</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($meetings as $meeting)
                    <tr>
                        <td>{{ $meeting->client->client_name }}</td>
                        <td>{{ $meeting->visit_date }}</td>
                        <td>{{ $meeting->meeting_start_time }}</td>
                        <td>{{ $meeting->meeting_end_time }}</td>
                        <td>{{ $meeting->client->contact_person }}</td>
                        <td>{{ $meeting->client->contact_no }}</td>
                        <td>{{ $meeting->purpose }}</td>
                        <td>{{ $meeting->status }}</td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ route('meeting.show', $meeting->id) }}" data-toggle="tooltip"
                                        title="Details" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>

                                    <a href="{{ route('meeting.edit', $meeting->id) }}" data-toggle="tooltip"
                                        title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>

                                    <form action="{{ route('meeting.destroy', $meeting->id) }}" method="POST"
                                        data-toggle="tooltip" title="Delete" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm delete"><i
                                                class="fas fa-trash"></i></button>
                                    </form>
                                    <!-- add followup button -->
                                    <a href="{{ route('followup.create', $meeting->id) }}" data-toggle="tooltip"
                                        title="Add Followup" class="btn btn-outline-success"><i class="fas fa-plus"></i></a>
                                </nobr>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>Client Name</th>
                    <th>Visit Date</th>
                    <th>Time of Work Started</th>
                    <th>Time of Work Ended</th>
                    <th>Contact Person</th>
                    <th>Phone</th>
                    <th>Purpose</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection

@section('script')
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
