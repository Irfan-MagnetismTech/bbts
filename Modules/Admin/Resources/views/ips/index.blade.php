@extends('layouts.backend-layout')
@section('title', 'Ip')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Ip Info
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('ips.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-plus"></i></a>
@endsection
@section('sub-title')
    {{-- Total: {{ @count($ips) }} --}}
@endsection


@section('content')
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#SL</th>
                    <th>Address</th>
                    <th>Type</th>
                    <th>Purpose</th>
                    <th>Vlan Id</th>
                    <th>Zone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#SL</th>
                    <th>Address</th>
                    <th>Type</th>
                    <th>Purpose</th>
                    <th>Vlan Id</th>
                    <th>Zone</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($ips as $key => $ip)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="text-center">{{ $ip->address }}</td>
                        <td class="text-center">{{ $ip->type }}</td>
                        <td class="text-center">{{ $ip->purpose }}</td>
                        <td class="text-center">{{ $ip->vlan_id }}</td>
                        <td class="text-center">{{ $ip?->zone?->name }}</td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ route('ips.edit', $ip->id) }}" data-toggle="tooltip" title="Edit"
                                        class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                    <form action="{{ url("admin/ips/$ip->id") }}" method="POST" data-toggle="tooltip"
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
