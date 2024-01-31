@extends('layouts.backend-layout')
@section('title', 'Plan Reports')

@section('style')

@endsection

@section('breadcrumb-title')
    Product Wise Report
@endsection

@section('style')
    <style>
    </style>
@endsection

@section('sub-title')
    <small>(Last 30 Days)</small>

@endsection


@section('content')
    <form action="" method="get" class="my-4">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="ticket_no" class="font-weight-bold">Product:</label>
                    <select name="product_id" id="product_id" class="form-control select2">
                        <option value="">Select Product</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
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
            <tbody>
                @foreach ($product_data as $key => $product)
                    <tr style="background-color: rgb(213, 255, 177) !important; font-weight:bold;">
                        <td colspan="10" class="text-center font-weight-bold">{{ $key }}</td>
                    </tr>
                    <tr style="background-color: rgb(177, 255, 229) !important; font-weight:bold;">
                        <td>#SL</td>
                        <td>Client No</td>
                        <td>Client Name</td>
                        <td>Product</td>
                        <td>Quantity</td>
                        <td>Price</td>
                        <td>Total</td>
                        <td>Activation Date</td>
                        <td>Billing Start Date</td>
                        <td>Account Holder</td>
                    </tr>
                    @foreach ($product as $single_product)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $single_product['client_no'] }}</td>
                            <td>{{ $single_product['client_name'] }}</td>
                            <td>{{ $single_product['product_name'] }}</td>
                            <td>{{ $single_product['quantity'] }}</td>
                            <td>{{ $single_product['price'] }}</td>
                            <td>{{ $single_product['total'] }}</td>
                            <td>{{ $single_product['activation_date'] }}</td>
                            <td>{{ $single_product['billing_date'] }}</td>
                            <td>{{ $single_product['account_holder'] }}</td>
                        </tr>
                    @endforeach
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
