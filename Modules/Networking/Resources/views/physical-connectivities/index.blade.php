@extends('layouts.backend-layout')
@section('title', 'Pyhsical Connectivity')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Pyhsical Connectivity
@endsection


@section('breadcrumb-button')
    <a href="{{ route('physical-connectivities.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i
            class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($physicalConnectivities) }}
@endsection

@section('content')
    <!-- put search form here -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>FR No</th>
                    <th>Client Name</th>
                    <th>Connectivity Point</th>
                    <th>Link Type</th>
                    <th>POP</th>
                    <th>LDP</th>
                    <th>Device IP</th>
                    <th>PORT</th>
                    <th>Vlan</th>
                    <th></th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($physicalConnectivities as $key => $physicalConnectivity)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $physicalConnectivity->fr_no }}</td>
                        <td>{{ $physicalConnectivity->client->client_name }}</td>
                        <td>
                            {{ $physicalConnectivity->connectivity_point }}
                        </td>
                        <td>
                            @foreach ($physicalConnectivity->lines as $key => $line)
                                <span class="badge badge-info">{{ $line->link_type }}</span> <br>
                            @endforeach
                        </td>
                        <td>
                            @foreach ($physicalConnectivity->lines as $key => $line)
                                <span class="badge badge-info">{{ $line->pop }}</span> <br>
                            @endforeach
                        </td>
                        <td>
                            @foreach ($physicalConnectivity->lines as $key => $line)
                                <span class="badge badge-info">{{ $line->ldp }}</span> <br>
                            @endforeach
                        </td>
                        <td>
                            @foreach ($physicalConnectivity->lines as $key => $line)
                                <span class="badge badge-info">{{ $line->device_ip }}</span> <br>
                            @endforeach
                        </td>
                        <td>
                            @foreach ($physicalConnectivity->lines as $key => $line)
                                <span class="badge badge-info">{{ $line->port }}</span> <br>
                            @endforeach
                        </td>
                        <td>
                            @foreach ($physicalConnectivity->lines as $key => $line)
                                <span class="badge badge-info">{{ $line->vlan }}</span> <br>
                            @endforeach
                        </td>
                        <td>
                            <span class="badge badge-info">
                                <a href="{{ route('logical-connectivities.create', ['physical_connectivity_id' => $physicalConnectivity->id, 'type' => 'internet']) }}"
                                    class="text-white">Internet</a>
                            </span>
                            <span class="badge badge-info">
                                <a href="{{ route('logical-data-connectivities.create', ['physical_connectivity_id' => $physicalConnectivity->id]) }}"
                                    class="text-white">Data</a>
                            </span>
                            <span class="badge badge-info">
                                <a href="{{ route('logical-connectivities.create', ['physical_connectivity_id' => $physicalConnectivity->id, 'type' => 'vas']) }}"
                                    class="text-white">VAS</a>
                            </span>
                        </td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ route('physical-connectivities.show', $physicalConnectivity->id) }}"
                                        data-toggle="tooltip" title="Show" class="btn btn-outline-primary"><i
                                            class="fas fa-eye"></i></a>

                                    <a href="{{ route('physical-connectivities.edit', $physicalConnectivity->id) }}"
                                        data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i
                                            class="fas fa-pen"></i></a>
                                    {!! Form::open([
                                        'url' => route('physical-connectivities.destroy', $physicalConnectivity->id),
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
