@extends('layouts.backend-layout')
@section('title', 'Follow up List')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    Follow Up List
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('followup.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-plus"></i></a>
@endsection
@section('sub-title')
    Total: {{ count($followups) }}
@endsection


@section('content')
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Client Name</th>
                    <th>Address</th>
                    <th>Activity Date</th>
                    <th>Time of Work Started</th>
                    <th>Time of Work Ended</th>
                    <th>Nature of Work</th>
                    <th>Types of Sales Call</th>
                    <th>Potentility Amount</th>
                    <th>Meeting Outcome</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($followups as $followup)
                    <tr>
                        <td> {{ $loop->index + 1 }} </td>
                        <td>{{ $followup->client->client_name }}</td>
                        <td>{{ $followup->client->address }}</td>
                        <td>{{ $followup->activity_date }}</td>
                        <td>{{ $followup->work_start_time }}</td>
                        <td>{{ $followup->work_end_time }}</td>
                        <td>{{ $followup->work_nature_type }}</td>
                        <td>{{ $followup->sales_type }}</td>
                        <td>{{ $followup->potentility_amount }}</td>
                        <td>{{ $followup->meeting_outcome }}</td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    @can('followup-view')
                                        <a href="{{ route('followup.show', $followup->id) }}" data-toggle="tooltip"
                                            title="Details" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                    @endcan
                                    @can('followup-edit')
                                        <a href="{{ route('followup.edit', $followup->id) }}" data-toggle="tooltip"
                                            title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                    @endcan
                                    @can('followup-delete')
                                        <form action="{{ route('followup.destroy', $followup->id) }}" method="POST"
                                            data-toggle="tooltip" title="Delete" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm delete"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>
                                    @endcan
                                </nobr>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/Datatables/jquery.dataTables.min.js') }}"></script>
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
