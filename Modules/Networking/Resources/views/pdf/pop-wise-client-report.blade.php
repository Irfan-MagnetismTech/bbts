<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Monthly Sales Report</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid black;
            padding: 5px;
        }

        th {
            text-align: center;
        }

        .dt-responsive {
            overflow: auto;
            padding: 0 5%;
        }

        thead tr th {
            background-color: #f2f2f2;
            font-size: 12px;
        }

        tbody tr td {
            font-size: 12px;
        }

        @page {
            header: page-header;
            footer: page-footer;
        }

        #logo {
            clear: both;
            width: 100%;
            display: block;
            text-align: center;
            position: relative;
        }

        .pdflogo a {
            font-size: 18px;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        @page {
            margin: 150px 0px 40px 0px;
        }
    </style>

</head>

<body>
    <htmlpageheader name="page-header">
        <div>
            &nbsp;
        </div>
        <div>
            <div id="logo" class="pdflogo">
                <img src="{{ asset('images/bbts_logo.png') }}" alt="Logo" class="pdfimg">
                <div class="clearfix"></div>
                <h5 style="margin: 2px; padding: 2px;">Ispahani Building (2nd Floor), Agrabad C/A, Chittagong-4100.</h5>
                <h4 style="margin: 2px; padding: 2px;">POP Wise Client Report</h4>
                <hr />
            </div>
        </div>
    </htmlpageheader>
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

</body>

</html>
