@extends('layouts.backend-layout')
@section('title', 'Logical Connectivity')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Logical Connectivity
@endsection


@section('breadcrumb-button')
    <a href="{{ route('logical-connectivities.index') }}" class="btn btn-out-dashed btn-sm btn-success"><i
            class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($logicalConnectivities) }}
@endsection

@section('content')
    <!-- put search form here -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Connectivity Point</th>
                    <th>Client Name</th>
                    <th>Product Category</th>
                    <th>Facility Type</th>
                    <th>Comment</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logicalConnectivities as $key => $logicalConnectivity)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $logicalConnectivity->feasibilityRequirementDetails->connectivity_point ?? '' }}</td>
                        <td>{{ $logicalConnectivity->client->client_name ?? '' }}</td>
                        <td>
                            {{ $logicalConnectivity->product_category ?? '' }}
                        </td>
                        {{--                        <td> --}}
                        {{--                            @foreach ($logicalConnectivity->lines as $key => $line) --}}
                        {{--                            {{ $line->link_type }} <br> --}}
                        {{--                            @endforeach --}}
                        {{--                        </td> --}}
                        <td>
                            {{ $logicalConnectivity->facility_type ?? '' }}
                        </td>
                        <td>
                            {{ $logicalConnectivity->comment ?? '' }}
                        </td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    {{-- <a href="{{ route('logical-connectivities.show', $logicalConnectivity->id) }}"
                                        data-toggle="tooltip" title="Show" class="btn btn-outline-primary"><i
                                            class="fas fa-eye"></i></a> --}}

                                    <a href="{{ route('logical-internet-connectivities.edit', $logicalConnectivity->id) }}"
                                        data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i
                                            class="fas fa-pen"></i></a>
                                    {!! Form::open([
                                        'url' => route('logical-internet-connectivities.destroy', $logicalConnectivity->id),
                                        'method' => 'delete',
                                        'class' => 'd-inline',
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Delete',
                                    ]) !!}
                                    {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete']) }}
                                    {!! Form::close() !!}
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
    <script>
        $(document).ready(function() {});
    </script>
@endsection
