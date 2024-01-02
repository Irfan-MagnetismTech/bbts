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
                    <th colspan="3">Switch Information</th>
                </tr>
                <tr>
                    <th>Internet</th>
                    <th>Brandwidth</th>
                    <th>IPV4</th>
                    <th>IPV6</th>
                    <th>Subnet</th>
                    <th>Gateway</th>
                    <th>Switch IP</th>
                    <th>Switch Port</th>
                    <th>Vlan</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($pop_wise_clients))
                    @foreach ($pop_wise_clients as $key => $pop_wise_client)
                        @php
                            $logicalCount = count($pop_wise_client['logical']);
                            $physicalCount = count($pop_wise_client['physical']);
                            $rowspan = max($logicalCount, $physicalCount);
                        @endphp

                        @for ($i = 0; $i < $rowspan; $i++)
                            <tr>
                                {{-- Client ID, Client Name, and Connectivity Point --}}
                                @if ($i === 0)
                                    {{-- Only for the first row --}}
                                    <td rowspan="{{ $rowspan }}">{{ $key }}</td>
                                    <td rowspan="{{ $rowspan }}">{{ $pop_wise_client['client_name'] }}</td>
                                    <td rowspan="{{ $rowspan }}"></td>
                                @endif

                                {{-- Logical information --}}
                                @if ($i < $logicalCount)
                                    <td>{{ $pop_wise_client['logical'][$i]['product_category'] }}</td>
                                    <td>{{ $pop_wise_client['logical'][$i]['quantity'] }}</td>
                                    <td>{{ $pop_wise_client['logical'][$i]['ipv4'] }}</td>
                                    <td>{{ $pop_wise_client['logical'][$i]['ipv6'] }}</td>
                                    <td>{{ $pop_wise_client['logical'][$i]['subnetmask'] }}</td>
                                    <td>{{ $pop_wise_client['logical'][$i]['gateway'] }}</td>
                                @else
                                    {{-- Empty cells for the logical information --}}
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                @endif

                                {{-- Physical information --}}
                                @if ($i < $physicalCount)
                                    <td>{{ $pop_wise_client['physical'][$i]->device_ip }}</td>
                                    <td>{{ $pop_wise_client['physical'][$i]->switch_port }}</td>
                                    <td>{{ $pop_wise_client['physical'][$i]->vlan }}</td>
                                @else
                                    {{-- Empty cells for the physical information --}}
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                @endif
                            </tr>
                        @endfor
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
