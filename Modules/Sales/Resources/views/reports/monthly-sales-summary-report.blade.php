@extends('layouts.backend-layout')
@section('title', 'Sales Summary Report')

@section('style')

@endsection

@section('breadcrumb-title')
    Sales Summary Report
@endsection

@section('style')
    <style>
    </style>
@endsection

@section('sub-title')

@endsection


@section('content')
    <form action="" method="get" class="my-4">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="ticket_no" class="font-weight-bold">Client Name:</label>
                    <select name="client_no" id="client_no" class="form-control select2">
                        <option value="">Select Client</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->client_no }}">{{ $client->client_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="date_from" class="font-weight-bold">From Date:</label>
                    <input type="text" class="form-control date" id="date_from" name="date_from"
                        aria-describedby="date_from" value="{{ old('date_from') ?? (request()?->date_from ?? null) }}"
                        readonly>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="date_to" class="font-weight-bold">To Date:</label>
                    <input type="text" class="form-control date" id="date_to" name="date_to" aria-describedby="date_to"
                        value="{{ old('date_to') ?? (request()?->date_to ?? null) }}" readonly>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="date_to" class="font-weight-bold">Select Type:</label>
                    <select name="type" id="type" class="form-control">
                        <option value="">Select Type</option>
                        <option value="Report">Report</option>
                        <option value="PDF">PDF</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group my-4 row">
                    <div class="col-md-6">
                        <input type="button" onclick="resetForm()" value="Reset"
                            class="btn btn-outline-warning btn-sm col-12">
                    </div>
                    <div class="col-md-6">
                        <input type="submit" value="Search" class="btn btn-outline-primary btn-sm col-12">
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#SL</th>
                    <th>Client ID</th>
                    <th>Client Name</th>
                    <th>Connectivity Point</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>OTC</th>
                    <th>MRC</th>
                    <th>Activation Date</th>
                    <th>Billing Start Date</th>
                    <th>Billing Address</th>
                    <th>A/C holder</th>
                    <th>Remarks</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($sales_data as $key => $monthly_sales_summary)
                    {{-- @dd($monthly_sales_summary['products']) --}}
                    @php
                        $max_rowspan = $monthly_sales_summary['products']->count();
                    @endphp
                    @for ($i = 0; $i < $max_rowspan; $i++)
                        <tr>
                            @if ($i == 0)
                                <td rowspan="{{ $max_rowspan }}">{{ $key + 1 }}</td>
                                <td rowspan="{{ $max_rowspan }}">{{ $monthly_sales_summary['client_no'] }}</td>
                                <td rowspan="{{ $max_rowspan }}">{{ $monthly_sales_summary['client_name'] }}</td>
                                <td rowspan="{{ $max_rowspan }}">{{ $monthly_sales_summary['connectivity_point'] }}</td>
                            @endif
                            <td>{{ $monthly_sales_summary['products'][$i]->product->name }}</td>
                            <td>{{ $monthly_sales_summary['products'][$i]->quantity }}</td>
                            <td>{{ $monthly_sales_summary['products'][$i]->price }}</td>
                            <td>{{ $monthly_sales_summary['products'][$i]->quantity * $monthly_sales_summary['products'][$i]->price }}
                            </td>
                            @if ($i == 0)
                                <td rowspan="{{ $max_rowspan }}">
                                    {{ $monthly_sales_summary['otc'] }}</td>
                                <td rowspan="{{ $max_rowspan }}">
                                    {{ $monthly_sales_summary['mrc'] }}</td>
                                <td rowspan="{{ $max_rowspan }}">
                                    {{ $monthly_sales_summary['activation_date'] }}</td>
                                <td rowspan="{{ $max_rowspan }}">
                                    {{ $monthly_sales_summary['billing_date'] }}</td>
                                <td rowspan="{{ $max_rowspan }}">
                                    {{ $monthly_sales_summary['billing_address'] }}</td>
                                <td rowspan="{{ $max_rowspan }}">
                                    {{ $monthly_sales_summary['account_holder'] }}</td>
                                <td rowspan="{{ $max_rowspan }}">
                                    {{ $monthly_sales_summary['remarks'] }}</td>
                            @endif
                        </tr>
                    @endfor
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.date').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                todayHighlight: true,
            });

            select2Ajax("{{ route('search-support-ticket') }}", '#ticket_no')
        })

        function resetForm() {
            $('#date_from').val('');
            $('#date_to').val('');
            $('#ticket_no').val('').trigger("change");
            // $('#ticket_no').prop('selectedIndex',0);
        }
    </script>
@endsection
