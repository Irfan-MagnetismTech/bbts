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
                <h4 style="margin: 2px; padding: 2px;">POP Wise equipment Report</h4>
                <hr />
            </div>
        </div>
    </htmlpageheader>
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
                                <td rowspan="{{ count($pop_wise_equipment) }}">{{ $pop_wise_equipment['pop_name'] }}
                                </td>
                                <td rowspan="{{ count($pop_wise_equipment) }}">{{ $pop_wise_equipment['location'] }}
                                </td>
                            @endif
                            <td>{{ $equipment['material']?->name ?? ''}}</td>
                            <td>{{ $equipment['brand'] ?? ''}}</td>
                            <td>{{ $equipment['model'] ?? ''}}</td>
                            <td>{{ $equipment['ip_address'] ?? ''}}</td>
                            <td>{{ $equipment['subnet_mask'] ?? ''}}</td>
                            <td>{{ $equipment['gateway'] ?? ''}}</td>
                            <td>{{ $equipment['remarks'] ?? ''}}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>

    </div>
</body>

</html>
