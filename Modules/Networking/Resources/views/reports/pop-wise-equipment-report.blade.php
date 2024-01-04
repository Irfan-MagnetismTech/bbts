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
                    <th colspan="2">POP Details</th>
                    <th colspan="3">Device Details</th>
                    <th colspan="3">IP Address</th>
                    <th rowspan="2">Remarks</th>
                </tr>
                <tr>
                    <th>POP Name</th>
                    <th>Location</th>
                    <th>Description</th>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>IP Address</th>
                    <th>Subnet</th>
                    <th>Gateway</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($pop_wise_equipments as $key => $pop_wise_equipment)
                    {{-- @dd($pop_wise_equipment) --}}
                    @foreach ($pop_wise_equipment['equipments'] as $equipment)
                        {{-- @dd($equipment) --}}
                        <tr>
                            @if ($loop->first)
                                <td rowspan="{{ count($pop_wise_equipment) }}">{{ $pop_wise_equipment['pop_name'] }}</td>
                                <td rowspan="{{ count($pop_wise_equipment) }}">{{ $pop_wise_equipment['location'] }}</td>
                            @endif
                            <td>{{ $equipment['material']->name }}</td>
                            <td>{{ $equipment['brand'] }}</td>
                            <td>{{ $equipment['model'] }}</td>
                            <td>{{ $equipment['ip_address'] }}</td>
                            <td>{{ $equipment['subnet_mask'] }}</td>
                            <td>{{ $equipment['gateway'] }}</td>
                            <td>{{ $equipment['remarks'] }}</td>
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
