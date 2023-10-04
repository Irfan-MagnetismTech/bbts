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
    {{-- <form action="" method="get" class="my-4">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                        <label for="ticket_no" class="font-weight-bold">Ticket Name:</label>
                        <select name="ticket_no" id="ticket_no" class="form-control">
                        @if (empty(request()?->ticket_no))
                        <option value="">Select Ticket</option>
                        @else
                        <option value="{{ old('ticket_no') ?? (request()?->ticket_no ?? null) }}">{{ $ticketNo ?? null }}</option>
                        @endif
                        </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="date_from" class="font-weight-bold">From Date:</label>
                    <input type="text" class="form-control date" id="date_from" name="date_from" aria-describedby="date_from"
                        value="{{ old('date_from') ?? (request()?->date_from ?? null) }}" readonly>
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
                        <input type="button" onclick="resetForm()" value="Reset" class="btn btn-outline-warning btn-sm col-12">
                    </div>
                    <div class="col-md-6">
                        <input type="submit" value="Search" class="btn btn-outline-primary btn-sm col-12">
                    </div>
                </div>
            </div>
        </div>
    </form>
     --}}
    <div class="row ml-3 mb-5 mt-3">
        <div class="form-check col-2">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" data-value="7">
            <label class="form-check-label" for="flexRadioDefault1">
                Last 7 days
            </label>
        </div>
        <div class="form-check col-2">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" data-value="15">
            <label class="form-check-label" for="flexRadioDefault2">
                Last 15 days
            </label>
        </div>
        <div class="form-check col-2">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault3" data-value="30">
            <label class="form-check-label" for="flexRadioDefault3">
                Last 30 days
            </label>
        </div>
    </div>




    <div class="col-12">
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



    </div>
@endsection

@section('script')
    {{-- <script>
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
        $('#ticket_no').val('').trigger( "change" );
    }

</script> --}}
    <script>
        $(document).ready(function() {
            $('input[type="radio"]').change(function() {
                if ($(this).is(':checked')) {
                    const selectedValue = $(this).data('value');
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
                                    return val.client_no;
                                }); + '</td>';
                                // tableData += '<td>' + value.opening_date + '</td>';
                                // tableData += '<td>' + value.support_complain_type.name + '</td>';
                                // tableData += '<td>' + value.remarks + '</td>';

                            })

                            $("#client-ticket").find("tbody").html("");
                            $("#client-ticket").find("tbody").html(tableData);






















                        }
                    });
                    // console.log(selectedValue);
                    // client-ticket
                }
            });
        });
    </script>
@endsection
