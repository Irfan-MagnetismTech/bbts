@extends('layouts.backend-layout')
@section('title', 'Pop Wise Client Report')

@section('style')

@endsection

@section('breadcrumb-title')
    Pop Wise Client Report
@endsection

@section('style')
    <style>
    </style>
@endsection



@section('content')
    <form action="" method="get" class="my-4">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="ticket_no" class="font-weight-bold">Pop:</label>
                    <select name="pop_id" id="pop_id" class="form-control select2">
                        <option value="">Select Pop</option>
                        @foreach ($pops as $pop)
                            <option value="{{ $pop->id }}">{{ $pop->name }}</option>
                        @endforeach
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
                    <th rowspan="2">Client ID</th>
                    <th rowspan="2">Client Name</th>
                    <th rowspan="2">Connectivity Point</th>
                    <th>Service Type</th>
                    <th colspan="5">IP Details</th>
                    {{-- <th rowspan="2">Media Tpe Fiber/Wireless UTP</th>
                    <th colspan="3">Switch Information</th> --}}
                </tr>
                <tr>
                    <th>Internet</th>
                    <th>Brandwidth</th>
                    <th>IPV4</th>
                    <th>IPV6</th>
                    <th>Subnet</th>
                    <th>Gateway</th>
                    {{-- <th>Switch IP</th>
                    <th>Switch Port</th>
                    <th>Vlan</th> --}}
            </thead>
            <tbody>
                @foreach ($pop_wise_clients as $key => $pop_wise_client)
                    @foreach ($pop_wise_client['logical'] as $logical)
                        <tr>
                            <td rowspan="{{ count($pop_wise_client['logical']) }}">{{ $key }}</td>
                            <td rowspan="{{ count($pop_wise_client['logical']) }}">{{ $pop_wise_client['client_name'] }}
                            </td>
                            <td rowspan="{{ count($pop_wise_client['logical']) }}"></td>
                        </tr>
                        <tr>
                            <td>{{ $logical['product_category'] }}</td>
                            <td>{{ $logical['quantity'] }}</td>
                            <td>{{ $logical['ipv4'] }}</td>
                            <td>{{ $logical['ipv6'] }}</td>
                            <td>{{ $logical['subnetmask'] }}</td>
                            <td>{{ $logical['gateway'] }}</td>

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
