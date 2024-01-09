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
                <h4 style="margin: 2px; padding: 2px;">Client Wise Equipment Report</h4>
                <hr />
            </div>
        </div>
    </htmlpageheader>
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
</body>

</html>
