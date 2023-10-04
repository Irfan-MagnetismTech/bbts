@extends('layouts.backend-layout')
@section('title', 'Support Tickets')

@section('style')

@endsection

@section('breadcrumb-title')
    Repeated Ticket Client List
@endsection

@section('style')
    <style>
    </style>
@endsection
{{-- @section('breadcrumb-button')
    <a href="{{ route('support-tickets.create')}}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-plus"></i></a>
@endsection --}}
@section('sub-title')
    {{-- Total Tickets: {{ $supportTickets->count() }} <br>
    <small>(Last 30 Days)</small> --}}

@endsection


@section('content')
    <div class="row mb-3">
        <div class="col-md-8"></div>
        <div class="col-md-4">
            <label> Filter Repeated Client </label>
            <select class="form-control" id="mySelect">
                <option selected>Select days</option>
                <option value="7">Last 7 days</option>
                <option value="15">Last 15 days</option>
                <option value="30">Last 30 days</option>
            </select>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered" id="client-ticket">
            <thead>
                <tr>
                    <th>Client Name</th>
                    <th>Ticket No</th>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#mySelect').on('change', function() {
                var selectedValue = $(this).val();
                // console.log("Selected Value: " + selectedValue);
                $.ajax({
                    url: "{{ route('get-repeated-ticket-client-list') }}",
                    data: {
                        selected_day: selectedValue,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        var clientTickets = data;


                        var tableData = '';
                        $.each(clientTickets, function(key, value) {
                            console.log(value);


                            tableData += '<tr>';
                            tableData += '<td>' + value[0]?.client?.client_name +
                                '</td>';
                            tableData += '<td>' + value.map(function(val) {
                                return val.ticket_no;
                            }); + '</td>';
                            // tableData += '<td>' + value.opening_date + '</td>';

                        })

                        $("#client-ticket").find("tbody").html("");
                        $("#client-ticket").find("tbody").html(tableData);


                    }
                });
            });
        });
    </script>
@endsection
