<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Permanently Inactive Client Report</title>
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
                <h4 style="margin: 2px; padding: 2px;">Permanently Inactive Client Report</h4>
                <hr />
            </div>
        </div>
    </htmlpageheader>
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">

            <tbody>
                @foreach ($permanently_inactive_clients as $key => $inactive_clients)
                    <tr>
                        <td colspan="10"
                            style="text-align: center; font-size: 16px; font-weight: bold; background-color: #f2f2f2;">
                            {{ $key }}
                        </td>
                    </tr>
                    <tr style="background-color: #f3f3f3;">
                        <th>Client</th>
                        <th>Connectivity Point</th>
                        <th>Branch</th>
                        <th>Thana</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Equipment</th>
                        <th>OTC</th>
                        <th>Monthly Revenue</th>
                        <th>Reason</th>
                    </tr>
                    @foreach ($inactive_clients as $client)
                        @php
                            $max_row = max(count($client['scm_err']), count($client['sale_product_details']));
                        @endphp
                        @for ($i = 0; $i < $max_row; $i++)
                            <tr>
                                @if ($i == 0)
                                    <td rowspan="{{ $max_row }}" style="font-size: 14px;">
                                        {{ $client['client_name'] }}</td>
                                    <td rowspan="{{ $max_row }}" style="font-size: 14px;">
                                        {{ $client['connectivity_point'] }}</td>
                                    <td rowspan="{{ $max_row }}" style="font-size: 14px;">{{ $client['branch'] }}
                                    </td>
                                    <td rowspan="{{ $max_row }}" style="font-size: 14px;">{{ $client['thana'] }}
                                    </td>
                                @endif
                                @if (isset($client['sale_product_details'][$i]))
                                    <td style="font-size: 14px;">
                                        {{ $client['sale_product_details'][$i]->product->name }}</td>
                                    <td style="font-size: 14px;">{{ $client['sale_product_details'][$i]->quantity }}
                                    </td>
                                @else
                                    <td>-</td>
                                    <td>-</td>
                                @endif
                                @if (isset($client['scm_err'][$i]))
                                    {{-- @dd($client['scm_err'][$i]); --}}
                                    <td> {{ $client['scm_err'][$i]->material->name }}
                                    @else
                                    <td>-</td>
                                @endif
                                @if ($i == 0)
                                    <td rowspan="{{ $max_row }}" style="font-size: 14px;">{{ $client['otc'] }}
                                    </td>
                                    <td rowspan="{{ $max_row }}" style="font-size: 14px;">{{ $client['mrc'] }}
                                    </td>
                                    <td rowspan="{{ $max_row }}" style="font-size: 14px;">{{ $client['reason'] }}
                                    </td>
                                @endif
                            </tr>
                        @endfor
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
