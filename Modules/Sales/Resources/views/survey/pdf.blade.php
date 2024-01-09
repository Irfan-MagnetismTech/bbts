<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> {{ $survey->lead_generation->client_name ?? '' }} Survey</title>
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
                    <h4 style="margin: 2px; padding: 2px;">Survey</h4>
                    <hr />
                </div>
            </div>

        </htmlpageheader>
        <div>
            <table class="productTable">
                <thead>
                    <tr>
                        <th colspan="6" style="background: #cfeaec !important;">Client Details</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="font-weight-bold">Date</td>
                        <td>{{ $survey->date }}</td>
                        <td class="font-weight-bold">Client ID</td>
                        <td>{{ $survey->lead_generation->client_no }}</td>
                        <td class="font-weight-bold">Client Name</td>
                        <td>{{ $survey->lead_generation->client_name }}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Connect: Point</td>
                        <td>{{ $survey->feasibilityRequirementDetails->connectivity_point }}</td>
                        <td class="font-weight-bold">FR No</td>
                        <td>{{ $survey->fr_no }}</td>
                        <td class="font-weight-bold">MQ ID</td>
                        <td>{{ $survey->mq_no }}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Latitude</td>
                        <td>{{ $survey->feasibilityRequirementDetails->lat ?? '' }}</td>
                        <td class="font-weight-bold">Longitude</td>
                        <td>{{ $survey->feasibilityRequirementDetails->long ?? '' }}</td>
                        <td class="font-weight-bold">Contact Person</td>
                        <td>{{ $survey->feasibilityRequirementDetails->contact_name }}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Contact Number</td>
                        <td>{{ $survey->feasibilityRequirementDetails->contact_number }}</td>
                        <td class="font-weight-bold">Email</td>
                        <td>{{ $survey->feasibilityRequirementDetails->contact_email }}</td>
                        <td class="font-weight-bold">Designation</td>
                        <td>{{ $survey->feasibilityRequirementDetails->contact_designation }}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Remarks</td>
                        <td colspan="5">{{ $survey->remarks }}</td>
                    </tr>
                </tbody>
            </table>
            <div>
                <div style="width: 100%; margin-top: 15px; margin-bottom:20px;">
                    <table class="productTable">
                        <thead>
                            <tr>
                                <th colspan="5" style="background: #cfeaec !important;">Product Details</th>
                            </tr>
                            <tr>
                                <th>Category</th>
                                <th>Product</th>
                                <th>Capacity</th>
                                <th>Unit</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody class="productBody">
                            @foreach ($connectivity_requirement->connectivityProductRequirementDetails as $connectivityProductRequirementDetail)
                                <tr class="product_details_row">
                                    <td>
                                        <span>
                                            {{ $connectivityProductRequirementDetail->category->name }}
                                        </span>
                                    </td>
                                    <td>
                                        <span>
                                            {{ $connectivityProductRequirementDetail->product->name }}
                                        </span>
                                    </td>
                                    <td>
                                        <span>
                                            {{ $connectivityProductRequirementDetail->capacity }}
                                        </span>
                                    </td>
                                    <td>
                                        <span>
                                            {{ $connectivityProductRequirementDetail->product->unit }}
                                        </span>
                                    </td>
                                    <td>
                                        <span>
                                            {{ $connectivityProductRequirementDetail->remarks ?? '' }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div style="width: 100%; margin-top: 15px; margin-bottom:20px;">
                    <table class="productTable">
                        <thead>
                            <tr>
                                <th colspan="5" style="background: #cfeaec !important;">Connectivity Details</th>
                            </tr>
                            <tr>
                                <th>Link Type</th>
                                <th>Method</th>
                                <th>Capacity %</th>
                                <th>Uptime Reg/SLA</th>
                                <th>Vendor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($connectivity_requirement->connectivityRequirementDetails as $connectivityRequirementDetail)
                                <tr class="connectivity_details_row">
                                    <td>
                                        <span>
                                            {{ $connectivityRequirementDetail->link_type }}
                                        </span>
                                    </td>
                                    <td>
                                        <span>
                                            {{ $connectivityRequirementDetail->method }}
                                        </span>
                                    </td>
                                    <td>
                                        <span>
                                            {{ $connectivityRequirementDetail->connectivity_capacity }}
                                        </span>
                                    </td>
                                    <td>
                                        <span>
                                            {{ $connectivityRequirementDetail->sla }}
                                        </span>
                                    </td>
                                    <td>
                                        <span>
                                            {{ $connectivityRequirementDetail->vendor->name ?? '' }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div style="width: 100%:">
                <table class="productTable">
                    <thead>
                        <tr>
                            <th>Link Type</th>
                            <th>Option</th>
                            <th>Status</th>
                            <th>Method</th>
                            <th>Vendor</th>
                            <th>BTS/POP</th>
                            <th>LDP</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Distance</th>
                            <th>Current Capacity</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($survey->surveyDetails as $detail)
                            <tr class="feasibility_details_row">
                                <td>
                                    <span>{{ $detail->link_type }}</span>
                                </td>
                                <td>
                                    <span>{{ $detail->option }}</span>
                                </td>
                                <td>
                                    <span>{{ $detail->status }}</span>
                                </td>
                                <td>
                                    <span>{{ $detail->method }}</span>
                                </td>
                                <td>
                                    <span>{{ $detail->vendor->name ?? '' }}</span>
                                </td>
                                <td>
                                    <span>{{ $detail->pop->name ?? '' }}</span>
                                </td>
                                <td>
                                    <span>{{ $detail->ldp }}</span>
                                </td>
                                <td>
                                    <span>{{ $detail->lat }}</span>
                                </td>
                                <td>
                                    <span>{{ $detail->long }}</span>
                                </td>
                                <td>
                                    <span>{{ $detail->distance }}</span>
                                </td>
                                <td>
                                    <span>{{ $detail->current_capacity }}</span>
                                </td>
                                <td>
                                    <span>{{ $detail->remarks }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
