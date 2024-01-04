@extends('layouts.backend-layout')
@section('title', 'Dues Report')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    Dues Report
@endsection

@section('style')
    <style>
    </style>
@endsection

@section('content')
    <form
        action="{{ url("billing/dues-report") }}"
        method="get" class="custom-form">
        @csrf
        <div style="display: flex">
            <div style="width: 100px">
                <select name="type" class="form-control type select2" autocomplete="off">
                    <option value="list">List</option>
                    <option value="pdf">PDF</option>
                </select>
            </div>
            <div style="width: 200px; margin-left: 20px">
                <select name="client_no" class="form-control client select2" autocomplete="off">
                    <option value="">Select Client</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->client_no }}" @selected($client->client_no == $client_no)>
                            {{ $client->client_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="icon-btn" style="margin-left: 30px; margin-top: 5px">
                <button data-toggle="tooltip" title="Search" class="btn btn-outline-primary"><i
                        class="fas fa-search"></i></button>
            </div>
        </div>

        <div class="dt-responsive table-responsive" style="margin-top: 10px">
            <table id="dataTable" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Sl</th>
                    <th>Client No</th>
                    <th>Client Name</th>
                    <th>Bill No</th>
                    <th>Bill Type</th>
                    <th>Amount</th>
                    <th>Penalty</th>
                    <th>Discount</th>
                    <th>Vat</th>
                    <th>Tax</th>
                    <th>Net Amount</th>
                    <th>Received Amount</th>
                    <th>Due Amount</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Sl</th>
                    <th>Client No</th>
                    <th>Client Name</th>
                    <th>Bill No</th>
                    <th>Bill Type</th>
                    <th>Amount</th>
                    <th>Penalty</th>
                    <th>Discount</th>
                    <th>Vat</th>
                    <th>Tax</th>
                    <th>Net Amount</th>
                    <th>Received Amount</th>
                    <th>Due Amount</th>
                    <th>Date</th>
                </tr>
                </tfoot>
                <tbody>
                    @foreach($collection as $key => $value)
                        <tr>
                            <td style="text-align: center">{{$key + 1}}</td>
                            <td style="text-align: start">{{ $value->client_no ?? ''}}</td>
                            <td style="text-align: start">{{ $value->client->client_name ?? ''}}</td>
                            <td style="text-align: start">
                            @foreach ($value->collectionBills as $subKey => $data)
                                {{ $data->bill_no ?? ''}} <br>
                            @endforeach
                            </td>
                            <td style="text-align: start">
                                @foreach ($value->collectionBills as $subKey => $data)
                                    {{ $data->billGenerate->bill_type ?? ''}} <br>
                                @endforeach
                            </td>
                            <td style="text-align: right">
                                @foreach ($value->collectionBills as $subKey => $data)
                                    {{ $data->amount ?? ''}} <br>
                                @endforeach
                            </td>
                            <td style="text-align: right">
                                @foreach ($value->collectionBills as $subKey => $data)
                                    {{ $data->penalty ?? ''}} <br>
                                @endforeach
                            </td>
                            <td style="text-align: right">
                                @foreach ($value->collectionBills as $subKey => $data)
                                    {{ $data->discount ?? ''}} <br>
                                @endforeach
                            </td>
                            <td style="text-align: right">
                                @foreach ($value->collectionBills as $subKey => $data)
                                    {{ $data->vat ?? ''}} <br>
                                @endforeach
                            </td>
                            <td style="text-align: right">
                                @foreach ($value->collectionBills as $subKey => $data)
                                    {{ $data->tax ?? ''}} <br>
                                @endforeach
                            </td>
                            <td style="text-align: right">
                                @foreach ($value->collectionBills as $subKey => $data)
                                    {{ $data->net_amount ?? ''}} <br>
                                @endforeach
                            </td>
                            <td style="text-align: right">
                                @foreach ($value->collectionBills as $subKey => $data)
                                    {{ $data->receive_amount ?? ''}} <br>
                                @endforeach
                            </td>
                            <td style="text-align: right">
                                @foreach ($value->collectionBills as $subKey => $data)
                                    {{ $data->due ?? ''}} <br>
                                @endforeach
                            </td>
                            <td style="text-align: center">{{ $value->date ?? ''}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </form>
@endsection


