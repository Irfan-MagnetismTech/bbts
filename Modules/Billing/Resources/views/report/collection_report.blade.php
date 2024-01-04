@extends('layouts.backend-layout')
@section('title', 'Collection Report')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    Collection Report
@endsection

@section('style')
    <style>
    </style>
@endsection

@section('content')
    <form
        action="{{ url("billing/collection-report") }}"
        method="get" class="custom-form">
        @csrf
        <div style="display: flex">
            <div style="width: 100px">
                <select name="type" class="form-control type select2" autocomplete="off">
                    <option value="list">List</option>
                    <option value="pdf">PDF</option>
                </select>
            </div>
{{--            <div style="width: 200px; margin-left: 20px">--}}
{{--                <select name="branch_id" class="form-control branch select2" autocomplete="off" required>--}}
{{--                    <option value="">Select Branch</option>--}}
{{--                    @foreach ($branches as $branch)--}}
{{--                        <option value="{{ $branch->id }}" @selected($branch->id == $branch_id)>--}}
{{--                            {{ $branch->name }}--}}
{{--                        </option>--}}
{{--                    @endforeach--}}
{{--                </select>--}}
{{--            </div>--}}
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
            <div style="width: 150px; margin-left: 20px">
                <input class="form-control" id="from_date" name="from_date" aria-describedby="from_date"
                       value="{{ $from_date }}" readonly
                       placeholder="From Date">
            </div>
            <div style="width: 150px; margin-left: 20px">
                <input class="form-control" id="to_date" name="to_date" aria-describedby="to_date"
                       value="{{ $to_date }}" readonly
                       placeholder="To Date">
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
                    <th>Payment Method</th>
                    <th>Bank Name</th>
                    <th>Payment Amount</th>
                    <th>Received Amount</th>
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
                    <th>Payment Method</th>
                    <th>Bank Name</th>
                    <th>Payment Amount</th>
                    <th>Received Amount</th>
                    <th>Date</th>
                </tr>
                </tfoot>
                <tbody>
                    @foreach($collection as $key => $value)
                        <tr>
                            <td>{{$key + 1}}</td>
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
                            <td style="text-align: start">
                                @foreach ($value->lines as $subKey => $data)
                                    {{ $data->payment_method ?? ''}} <br>
                                @endforeach
                            </td>
                            <td style="text-align: start">
                                @foreach ($value->lines as $subKey => $data)
                                    {{ $data->bank_name ?? ''}} <br>
                                @endforeach
                            </td>
                            <td style="text-align: right">
                                @foreach ($value->lines as $subKey => $data)
                                    {{ $data->amount ?? ''}} <br>
                                @endforeach
                            </td>
                            <td style="text-align: right">
                                @foreach ($value->collectionBills as $subKey => $data)
                                    {{ $data->receive_amount ?? ''}} <br>
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

@section('script')
    <script>
        if ($('#from_date').val() != null) {
            $('#from_date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                showOtherMonths: true
            });
        } else {
            $('#from_date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                showOtherMonths: true
            }).datepicker("setDate", new Date());
        }

        if ($('#to_date').val() != null) {
            $('#to_date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                showOtherMonths: true
            });
        } else {
            $('#to_date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                showOtherMonths: true
            }).datepicker("setDate", new Date());
        }
    </script>
@endsection

