@extends('layouts.backend-layout')
@section('title', 'OTC Bill')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of OTC Bill
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
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
                    <th>Client Name</th>
                    <th>Address</th>
                    <th>Contact No</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#SL</th>
                    <th>Client Name</th>
                    <th>Address</th>
                    <th>Contact No</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($otc_bills as $key => $value)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-center">{{ $value->first()->client->client_name }}</td>
                        <td class="text-center">{{ $value->first()->client->location }}</td>
                        <td class="text-center">{{ $value->first()->client->contact_no }}</td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ route('generate_otc_bill', $value->first()->client->client_no) }}" data-toggle="tooltip" title="Edit"
                                        class="btn btn-outline-success">Generate</a>
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
