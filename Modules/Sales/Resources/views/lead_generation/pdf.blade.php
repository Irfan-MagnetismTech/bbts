<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> {{ $plan->lead_generation->client_name ?? '' }} Planning </title>
    <style>
        .text-center {
            text-align: center;
        }

        .font-weight-bold {
            font-weight: bold;
        }

        .productTable {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid black;
            font-size: 12px;
        }

        .productTable th {
            border: 1px solid rgb(61, 66, 65);
            padding: 5px;
            background: #f2f2f2;
        }

        .productTable td {
            border: 1px solid rgb(61, 66, 65);
            padding: 5px;
        }

        .equipementTable {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid black;
            font-size: 12px;
        }

        .equipementTable th {
            border: 1px solid rgb(61, 66, 65);
            padding: 5px;
            background: #f2f2f2;
        }

        .equipementTable td {
            border: 1px solid rgb(61, 66, 65);
            padding: 5px;
        }

        .totalInvestment {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid black;
            font-size: 12px;
        }

        .totalInvestment th {
            border: 1px solid rgb(61, 66, 65);
            padding: 5px;
            background: #f2f2f2;
        }

        .totalInvestment td {
            border: 1px solid rgb(61, 66, 65);
            padding: 5px;
        }

        .productEquipmentTable {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid black;
            font-size: 12px;
        }

        .productEquipmentTable th {
            border: 1px solid rgb(61, 66, 65);
            padding: 5px;
            background: #f2f2f2;
        }

        .productEquipmentTable td {
            border: 1px solid rgb(61, 66, 65);
            padding: 5px;
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
            margin: 150px 10px 40px 10px;
        }
    </style>
</head>

<body>
    <div>
        <htmlpageheader name="page-header">
            <div>
                &nbsp;
            </div>
            <div>
                <div id="logo" class="pdflogo">
                    <img src="{{ asset('images/bbts_logo.png') }}" alt="Logo" class="pdfimg">
                    <div class="clearfix"></div>
                    <h5 style="margin: 2px; padding: 2px;">Ispahani Building (2nd Floor), Agrabad C/A, Chittagong-4100.
                    </h5>
                    <h4 style="margin: 2px; padding: 2px;">Lead Generation</h4>
                    <hr />
                </div>
            </div>

        </htmlpageheader>
        <div>
            <div>
                <table class="productTable">
                    <tr>
                        <th>Client Name</th>
                        <td>{{ $lead_generation->client_name }}</td>
                        <th>Address</th>
                        <td>{{ $lead_generation->address }}</td>
                    </tr>
                    <tr>
                        <th>Division</th>
                        <td>{{ $lead_generation->division->name ?? '' }}</td>
                        <th>District</th>
                        <td>{{ $lead_generation->district->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>Thana</th>
                        <td>{{ $lead_generation->thana->name ?? '' }}</td>
                        <th>Landmark</th>
                        <td>{{ $lead_generation->landmark }}</td>
                    </tr>
                    <tr>
                        <th>Lat-Long</th>
                        <td>{{ $lead_generation->lat }}</td>
                        <th>Lat-Long</th>
                        <td>{{ $lead_generation->long }}</td>

                    </tr>
                    <tr>
                        <th>Contact Person</th>
                        <td>{{ $lead_generation->contact_person }}</td>
                        <th>Contact No</th>
                        <td>{{ $lead_generation->contact_no }}</td>

                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $lead_generation->email }}</td>
                        <th>Website</th>
                        <td>{{ $lead_generation->website }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
