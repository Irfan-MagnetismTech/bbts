@extends('layouts.backend-layout')
@section('title', 'Zone')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Zone Info
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('zones.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-plus"></i></a>
@endsection
@section('sub-title')
    Total: {{ @count($zones) }}
@endsection


@section('content')
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#SL</th>
                    <th>Name</th>
                    <th>Thanas</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#SL</th>
                    <th>Name</th>
                    <th>Thanas</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($zones as $key => $zone)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="text-center">{{ $zone->name }}</td>
                        <td class="text-center">
                            {{ $zone->zoneLines->map(function ($line) {
                                return $line->thana->name;
                            }) }}
                        </td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ route('zones.edit', $zone->id) }}" data-toggle="tooltip" title="Edit"
                                        class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                    <form action="{{ url("admin/zones/$zone->id") }}" method="POST" data-toggle="tooltip"
                                        title="Delete" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm delete"><i
                                                class="fas fa-trash"></i></button>
                                    </form>
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
@endsection
