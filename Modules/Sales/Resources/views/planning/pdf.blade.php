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
                    <h4 style="margin: 2px; padding: 2px;">Planning</h4>
                    <hr />
                </div>
            </div>

        </htmlpageheader>
        <div>
            <div>
                <table class="productTable">
                    <thead>
                        <tr>
                            <th colspan="4">Client Information</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Client Name</th>
                            <td>{{ $plan->lead_generation->client_name }}</td>
                            <th>Address</th>
                            <td>{{ $plan->lead_generation->address }}</td>
                        </tr>
                        <tr>
                            <th>Branch</th>
                            <td>{{ $plan->feasibilityRequirementDetail->branch->name ?? '' }}</td>
                            <th>Division</th>
                            <td>{{ $plan->lead_generation->division->name ?? '' }}</td>
                        </tr>
                        <tr>
                            <th>District</th>
                            <td>{{ $plan->lead_generation->district->name ?? '' }}</td>
                            <th>Thana</th>
                            <td>{{ $plan->lead_generation->thana->name ?? '' }}</td>

                        </tr>
                        <tr>
                            <th>Lat-Long</th>
                            <td>{{ $plan->lead_generation->lat_long }}</td>
                            <th>Contact Person</th>
                            <td>{{ $plan->lead_generation->contact_person }}</td>
                        </tr>
                        <tr>
                            <th>Contact No</th>
                            <td>{{ $plan->lead_generation->contact_no }}</td>
                            <th>Email</th>
                            <td>{{ $plan->lead_generation->email }}</td>
                        </tr>
                        <tr>
                            <th>Website</th>
                            <td>{{ $plan->lead_generation->website }}</td>
                            <th>Landmark</th>
                            <td>{{ $plan->lead_generation->landmark }}</td>
                        </tr>
                    </tbody>

                </table>
            </div>
        </div>

        {{-- create a responsive table --}}
        <div style="width:100%; margin-top:20px;">
            <div style="width: 35%; float: left;">
                <table class="productTable">
                    <thead>
                        <tr>
                            <th colspan="4">Service Plan for
                                {{ $plan->feasibilityRequirementDetail->connectivity_point }}</th>
                        </tr>
                        <tr>
                            <th>Particulars</th>
                            <th>Client Req.</th>
                            <th>Plan</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody id="particular_body">
                        @foreach ($plan->servicePlans as $service_plan)
                            <tr class="particular_row">
                                <td style="width:30%">{!! $service_plan->connectivityProductRequirementDetails->product->name ?? '&nbsp;' !!}</td>
                                <td>{!! $service_plan->connectivityProductRequirementDetails->capacity ?? '&nbsp;' !!}</td>
                                <td>{!! $service_plan->plan ?? '&nbsp;' !!}</td>
                                <td style="width:30%">{!! $service_plan->connectivityProductRequirementDetails->remarks ?? '&nbsp;' !!}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="width: 63%; float: right;">
                <table class="productTable">
                    <thead>
                        <tr>
                            <th colspan="6">Equipment Plan
                                for
                                product</th>
                        </tr>
                        <tr>
                            <th>Equipment Name</th>
                            <th>Quantity</th>
                            <th>Unit</th>
                            <th>Brand</th>
                            <th>Model</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($plan->equipmentPlans as $equipment_plan)
                            <tr class="equipment_row">
                                <td>{{ $equipment_plan->material->name ?? '' }}</td>
                                <td>{!! $equipment_plan->quantity ?? '&nbsp;' !!}</td>
                                <td>{!! $equipment_plan->unit ?? '&nbsp;' !!}</td>
                                <td>{!! $equipment_plan->brand->name ?? '&nbsp;' !!}</td>
                                <td>{!! $equipment_plan->model ?? '&nbsp;' !!}</td>
                                <td>{!! $equipment_plan->remarks ?? '&nbsp;' !!}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @foreach ($plan->planLinks as $key => $plan_link)
        @php $total_key = $key + 1; @endphp
        <hr />
        <div style="width: 100%">
            <div style="width:49%; float: left;">
                <table class="productTable">
                    <tr>
                        <th colspan="2" style="background: #cfeaec !important;">Link
                            {{ $total_key }} Information</th>
                    </tr>
                    <tr>
                        <th class="text-left" style="width: 50%;">Type</th>
                        <td class="text-left">{{ $plan_link->link_type }}</td>
                    </tr>
                    <tr>
                        <th class="text-left" style="width: 50%;">Option</th>
                        <td class="text-left">{{ $plan_link->option }}</td>
                    </tr>
                    <tr>
                        <th class="text-left" style="width: 50%;">Link Status</th>
                        <td class="text-left">{{ $plan_link->existing_infrastructure }}</td>
                    </tr>
                    <tr>
                        <th class="text-left" style="width: 50%;">Existing Transmission Capacity
                        </th>
                        <td class="text-left">{{ $plan_link->existing_transmission_capacity }}</td>
                    </tr>
                    <tr>
                        <th class="text-left" style="width: 50%;">Increase Capacity</th>
                        <td class="text-left">{{ $plan_link->increase_capacity }}</td>
                    </tr>
                    <tr>
                        <th class="text-left" style="width: 50%;">Link Availability Status</th>
                        <td class="text-left">{{ $plan_link->link_availability_status }}</td>
                    </tr>
                    <tr>
                        <th class="text-left" style="width: 50%;">New Transmission Capacity</th>
                        <td class="text-left">{{ $plan_link->new_transmission_capacity }}</td>
                    </tr>
                    <tr>
                        <th class="text-left" style="width: 50%;">Link Remarks</th>
                        <td class="text-left">{{ $plan_link->link_remarks }}</td>
                    </tr>
                </table>
            </div>
            <div style="width:49%; float: right;">
                <table class="productTable">
                    <thead>
                        <tr>
                            <th colspan="2" style="background: #cfeaec !important;">Survey
                                Information</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="text-left" style="width: 50%;">Link Vendor</th>
                            <td class="link_vendor">
                                {{ $plan_link->finalSurveyDetails->vendor->name ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-left" style="width: 50%;">Connecting POP Running Vendor
                            </th>
                            <td class="running_vendor_pop"></td>
                        </tr>
                        <tr>
                            <th class="text-left" style="width: 50%;">Link Availability Status</th>
                            <td class="availability_status">
                                {{ $plan_link->finalSurveyDetails->availability_status ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-left" style="width: 50%;">Connecting POP Running Vendor
                                Capacity</th>
                            <td class="running_vendor_capacity"></td>
                        </tr>
                        <tr>
                            <th class="text-left" style="width: 50%;">Link Connectivity POP</th>
                            <td class="link_connecting_pop">
                                {{ $plan_link->finalSurveyDetails->pop->name ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-left" style="width: 50%;">Zone Area Running NTTN Vendor
                            </th>
                            <td class="nttn_vendor_zone"></td>
                        </tr>
                        <tr>
                            <th class="text-left" style="width: 50%;">Last Mile Connectivity Method
                            </th>
                            <td class="last_mile_connectivity_method">
                                {{ $plan_link->finalSurveyDetails->method ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-left" style="width: 50%;">Zone Area Running NTTN BW</th>
                            <td class="running_nttn_bw"></td>
                        </tr>
                        <tr>
                            <th class="text-left" style="width: 50%;">Last Connectivity Point
                                Latitute
                            </th>
                            <td class="connectivity_lat_long">
                                {{ $plan_link->finalSurveyDetails->lat ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-left" style="width: 50%;">Connectivity Route</th>
                            <td class="connectivity_route"></td>
                        </tr>
                        <tr>
                            <th class="text-left" style="width: 50%;">Last Connectivity Point
                                Longitute
                            </th>
                            <td class="connectivity_lat_long">
                                {{ $plan_link->finalSurveyDetails->long ?? '' }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div style="width: 100%; margin-top:15px;">
            <table class="productTable">
                <thead>
                    <tr>
                        <th colspan="7" style="background: #cfeaec !important;">Link
                            {{ $total_key }} Equipment</th>
                    </tr>
                    <tr>
                        <th>Equipment Name</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Description</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($plan_link->PlanLinkEquipments as $plan_equipment)
                        <tr>
                            <td>
                                <span>{!! $plan_equipment->material->name ?? '&nbsp;' !!}</span>
                            </td>
                            <td>
                                <span>{!! $plan_equipment->quantity ?? '&nbsp;' !!}</span>
                            </td>
                            <td>
                                <span>{!! $plan_equipment->unit ?? '&nbsp;' !!}</span>
                            </td>
                            <td>
                                <span>{!! $plan_equipment->brand->name ?? '&nbsp;' !!}</span>
                            </td>
                            <td>
                                <span>{!! $plan_equipment->model ?? '&nbsp;' !!}</span>
                            </td>
                            <td>
                                <span>{!! $plan_equipment->description ?? '&nbsp;' !!}</span>
                            </td>
                            <td>
                                <span>{!! $plan_equipment->remarks ?? '&nbsp;' !!}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach
</body>

</html>
