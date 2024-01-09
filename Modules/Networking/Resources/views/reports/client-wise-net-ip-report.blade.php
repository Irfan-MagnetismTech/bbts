@extends('layouts.backend-layout')
@section('title', 'Client Network and IP Report')

@section('style')

@endsection

@section('breadcrumb-title')
    Client Network and IP Report
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
                            <option value="{{ $client->id }}">{{ $client->client_name }}</option>
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
                    <th rowspan="2">Client ID</th>
                    <th rowspan="2">Client Name</th>
                    <th rowspan="2">Connectivity Point</th>
                    <th rowspan="2">Activation Date</th>
                    <th>Service Type</th>
                    <th colspan="5">IP Details</th>
                    <th colspan="4">Network Information</th>
                </tr>
                <tr>
                    <th>Internet</th>
                    <th>Brandwidth</th>
                    <th>IPV4</th>
                    <th>IPV6</th>
                    <th>Subnet</th>
                    <th>Gateway</th>
                    <th>Method</th>
                    <th>Switch IP</th>
                    <th>Switch Port</th>
                    <th>Vlan</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($client_ip_infos))
                    @foreach ($client_ip_infos as $key => $client_ip_info)
                        @php
                            $logicalCount = count($client_ip_info['logical']);
                            $physicalCount = count($client_ip_info['physical']);
                            $rowspan = max($logicalCount, $physicalCount);
                        @endphp

                        @for ($i = 0; $i < $rowspan; $i++)
                            <tr>
                                {{-- Client ID, Client Name, and Connectivity Point --}}
                                @if ($i === 0)
                                    {{-- Only for the first row --}}
                                    <td rowspan="{{ $rowspan }}">{{ $key }}</td>
                                    <td rowspan="{{ $rowspan }}">{{ $client_ip_info['client_name'] }}</td>
                                    <td rowspan="{{ $rowspan }}">{{ $client_ip_info['connectivity_point'] }}</td>
                                    <td rowspan="{{ $rowspan }}">{{ $client_ip_info['activation_date'] }}</td>
                                @endif

                                {{-- Logical information --}}
                                @if ($i < $logicalCount)
                                    <td>{{ $client_ip_info['logical'][$i]['product_category'] }}</td>
                                    <td>{{ $client_ip_info['logical'][$i]['quantity'] }}</td>
                                    <td>{{ $client_ip_info['logical'][$i]['ipv4'] }}</td>
                                    <td>{{ $client_ip_info['logical'][$i]['ipv6'] }}</td>
                                    <td>{{ $client_ip_info['logical'][$i]['subnetmask'] }}</td>
                                    <td>{{ $client_ip_info['logical'][$i]['gateway'] }}</td>
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
                                    <td>{{ $client_ip_info['physical'][$i]->method }}</td>
                                    <td>{{ $client_ip_info['physical'][$i]->device_ip }}</td>
                                    <td>{{ $client_ip_info['physical'][$i]->switch_port }}</td>
                                    <td>{{ $client_ip_info['physical'][$i]->vlan }}</td>
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
