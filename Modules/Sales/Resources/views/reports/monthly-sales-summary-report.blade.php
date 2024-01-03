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
    Total Tickets: {{ $plan_reports->count() }} <br>
    <small>(Last 30 Days)</small>

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
                @foreach ($monthly_sales_summary as $key => $monthly_sales_summary)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $monthly_sales_summary->client_no }}</td>
                        <td>{{ $monthly_sales_summary->client_name }}</td>
                        <td>{{ $monthly_sales_summary->connectivity_point }}</td>
                        <td>{{ $monthly_sales_summary->product }}</td>
                        <td>{{ $monthly_sales_summary->otc }}</td>
                        <td>{{ $monthly_sales_summary->mrc }}</td>
                        <td>{{ $monthly_sales_summary->activation_date }}</td>
                        <td>{{ $monthly_sales_summary->billing_start_date }}</td>
                        <td>{{ $monthly_sales_summary->billing_address }}</td>
                        <td>{{ $monthly_sales_summary->ac_holder }}</td>
                        <td>{{ $monthly_sales_summary->remarks }}</td>
                    </tr>
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
