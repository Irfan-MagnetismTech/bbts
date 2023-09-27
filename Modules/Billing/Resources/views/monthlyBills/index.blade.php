@extends('layouts.backend-layout')
@section('title', 'Monthly Bill')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Monthly Bill
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('monthly-bills.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
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
                <th>Client Name</th>
                <th>Address</th>
                <th>Contact No</th>
                <th>Bill Type</th>
                <th>Bill No</th>
                <th>Bill Date</th>
                <th>Amount</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>#SL</th>
                <th>Client Name</th>
                <th>Address</th>
                <th>Contact No</th>
                <th>Bill Type</th>
                <th>Bill No</th>
                <th>Bill Date</th>
                <th>Amount</th>
                <th>Action</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach ($datas as $key => $value)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="text-center">{{ $value->client->client_name }}</td>
                    <td class="text-center">{{ $value->client->location }}</td>
                    <td class="text-center">{{ $value->client->contact_no }}</td>
                    <td class="text-center">{{ $value->bill_type }}</td>
                    <td class="text-center">{{ $value->bill_no }}</td>
                    <td class="text-center">{{ $value->date }}</td>
                    <td class="text-center">{{ $value->amount }}</td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                <a href="{{ route('monthly-bills.edit', $value->id) }}" data-toggle="tooltip" title="Edit"
                                   class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                <a href="{{ route('mrc_bill', $value->id) }}" data-toggle="tooltip" title="PDF"
                                   class="btn btn-outline-success">MRC Bill</a>
                                <a href="{{ route('mrc_bill_summary', $value->id) }}" data-toggle="tooltip" title="PDF"
                                   class="btn btn-outline-success">MRC Bill Summary</a>
{{--                                <a href="{{ route('mrc_bill_except_penalty', $value->id) }}" data-toggle="tooltip"--}}
{{--                                   title="PDF"--}}
{{--                                   class="btn btn-outline-success">MRC Bill (without penalty)</a>--}}
{{--                                <a href="{{ route('mrc_bill_summary_except_penalty', $value->id) }}"--}}
{{--                                   data-toggle="tooltip" title="PDF"--}}
{{--                                   class="btn btn-outline-success">MRC Bill Summary (without penalty)</a>--}}
                                <a href="{{ route('mrc_bill_except_due', $value->id) }}" data-toggle="tooltip" title="PDF"
                                   class="btn btn-outline-success">MRC Bill (without due)</a>
                                <a href="{{ route('mrc_bill_with_pad', $value->id) }}" data-toggle="tooltip" title="PDF"
                                   class="btn btn-outline-success">MRC Bill (with pad)</a>
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
