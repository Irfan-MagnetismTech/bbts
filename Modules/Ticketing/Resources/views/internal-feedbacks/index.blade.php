@extends('layouts.backend-layout')
@section('title', 'Internal Feedbacks')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Internal Feedbacks
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('internal-feedbacks.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-plus"></i></a>
@endsection
@section('sub-title')
    {{-- Total: {{ @count($branchs) }} --}}
@endsection

@section('content')
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>#SL</th>
                <th>Client No</th>
                <th>Client Name</th>
                <th>Connectivity Point</th>
                <th>Contact Person</th>
                <th>Contact Number</th>
                <th>Feedback</th>
                <th>Time Duration</th>
                <th>Status</th>
                <th>Date</th>
                <th>Remarks</th>
                {{--                    <th>Action</th>--}}
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>#SL</th>
                <th>Client No</th>
                <th>Client Name</th>
                <th>Connectivity Point</th>
                <th>Contact Person</th>
                <th>Contact Number</th>
                <th>Feedback</th>
                <th>Time Duration</th>
                <th>Status</th>
                <th>Date</th>
                <th>Remarks</th>
                {{--                    <th>Action</th>--}}
            </tr>
            </tfoot>
            <tbody>
            @foreach ($feedbacks as $key => $value)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="text-left">{{ $value->client->client_no }}</td>
                    <td class="text-left">{{ $value->client->client_name }}</td>
                    <td class="text-left">
                        @foreach ($value->lines as $subKey => $line)
                            {{ ($line->feasibilityReqirementDetails->connectivity_point ?? '') . ' ('. ($line->feasibilityReqirementDetails->fr_no ?? '') . ')' }}
                            <br>
                        @endforeach
                    </td>
                    <td class="text-left">
                        @foreach ($value->lines as $subKey => $line)
                            {{ $line->contact_person ?? ''}}
                            <br>
                        @endforeach
                    </td>
                    <td class="text-left">
                        @foreach ($value->lines as $subKey => $line)
                            {{ $line->contact_number ?? ''}}
                            <br>
                        @endforeach
                    </td>
                    <td class="text-left">
                        @foreach ($value->lines as $subKey => $line)
                            {{ $line->client_feedback ?? ''}}
                            <br>
                        @endforeach
                    </td>
                    <td class="text-left">
                        @foreach ($value->lines as $subKey => $line)
{{--                            {{ $line->time_duration ?? ''}}--}}
                            @if ($line->time_duration)
                                <?php
                                $timeParts = explode(':', $line->time_duration);
                                $hours = intval($timeParts[0]);
                                $minutes = intval($timeParts[1]);

                                $formattedTime = '';

                                if ($hours > 0) {
                                    $formattedTime .= $hours . ' Hrs';
                                }

                                if ($minutes > 0) {
                                    if ($formattedTime !== '') {
                                        $formattedTime .= ' ';
                                    }
                                    $formattedTime .= $minutes . ' Mins';
                                }
                                ?>
                                {{ $formattedTime }}
                            @else
                            @endif
                            <br>
                        @endforeach
                    </td>
                    <td class="text-left">
                        @foreach ($value->lines as $subKey => $line)
                            {{ $line->status ?? ''}}
                            <br>
                        @endforeach
                    </td>
                    <td class="text-center">{{ $value->date }}</td>
                    <td class="text-left">{{ $value->remarks }}</td>
                    {{--                        <td>--}}
                    {{--                            <div class="icon-btn">--}}
                    {{--                                <nobr>--}}
                    {{--                                title="Show" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>--}}
                    {{--                                    <a href="{{ route('internal-feedbacks.edit', $value->id) }}" data-toggle="tooltip" title="Edit"--}}
                    {{--                                       class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>--}}
                    {{--                                    <form action="{{ route('internal-feedbacks.destroy',$value->id) }}" method="POST" data-toggle="tooltip"--}}
                    {{--                                          title="Delete" class="d-inline">--}}
                    {{--                                        @csrf--}}
                    {{--                                        @method('DELETE')--}}
                    {{--                                        <button type="submit" class="btn btn-outline-danger btn-sm delete"><i--}}
                    {{--                                                class="fas fa-trash"></i></button>--}}
                    {{--                                    </form>--}}
                    {{--                                </nobr>--}}
                    {{--                            </div>--}}
                    {{--                        </td>--}}
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('script')
@endsection
