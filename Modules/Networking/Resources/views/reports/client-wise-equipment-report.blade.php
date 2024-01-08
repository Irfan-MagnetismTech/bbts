@extends('layouts.backend-layout')
@section('title', 'Client Wise Equipment Report')

@section('style')

@endsection

@section('breadcrumb-title')
    Client Wise Equipment Report
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
                    <label for="ticket_no" class="font-weight-bold">Select Client:</label>
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
                    <label for="ticket_no" class="font-weight-bold">Type:</label>
                    <select name="type" id="type" class="form-control select2">
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
                    <th>Client ID</th>
                    <th>Client Name</th>
                    <th>Connectivity Point</th>
                    <th>Material</th>
                    <th>Brand</th>
                    <th>Quantity</th>

                </tr>
            </thead>
            <tbody>
                @if (!empty($client_wise_unique_materials))
                    @foreach ($client_wise_unique_materials as $key => $client_no_group)
                        @php
                            $client = \Modules\Sales\Entities\Client::find($key);
                            $max_row = 0;
                            foreach ($client_no_group as $fr_key => $fr_group) {
                                $row = count($fr_group);
                                if ($row > $max_row) {
                                    $max_row = $row;
                                }
                            }
                        @endphp
                        <tr>
                            <td rowspan="{{ $max_row }}">
                                {{ $key }}
                            </td>
                            <td rowspan="{{ $max_row }}">
                                {{ $client->client_name }}
                            </td>
                            @foreach ($client_no_group as $fr_key => $fr_group)
                                @php
                                    $connectivity_point = \Modules\Sales\Entities\FeasibilityRequirementDetail::where('fr_no', $fr_key)->first()->connectivity_point;
                                @endphp
                                <td rowspan="{{ count($fr_group) }}">
                                    {{ $connectivity_point }}
                                </td>
                                @foreach ($fr_group as $material)
                                    <td>{{ $material['material_name'] }}</td>
                                    <td>{{ $material['brand_name'] }}</td>
                                    <td>{{ $material['quantity'] }}</td>
                        </tr> {{-- Move the </tr> here to close the row after all the columns --}}
                        <tr> {{-- Start a new row for the next set of columns --}}
                    @endforeach
                @endforeach
                </tr>
                @endforeach
                @endif
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
