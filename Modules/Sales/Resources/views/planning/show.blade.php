@extends('layouts.backend-layout')
@section('title', 'Planning')

@section('breadcrumb-title')
    Planning
@endsection

@section('breadcrumb-button')
    <a href="{{ route('planning.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-list"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection
@section('style')<style>
        .table th {
            background: #006b8d !important;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .table-bordered {
            border: 1px solid #dee2e6 !important;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6 !important;
        }

        .table thead th {
            background-color: #00b5d6;
            border-color: #00b5d6;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f7f7f7;
        }

        /* Colors */
        .table-particulars {
            background-color: #8ccce1;
        }

        .table-equipment {
            background-color: #8ccce1;
        }
    </style>
@endsection



@section('content-grid', null)

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="tableHeading">
                    <h5> <span> &#10070; </span> Planning <span>&#10070;</span> </h5>
                </div>
                <div class="card-body">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <h5 class="text-center">Client Information</h5>
                            <hr />
                            <table class="table table-bordered table-particulars">
                                <tr>
                                    <th>Client Name</th>
                                    <td>{{ $plan->lead_generation->client_name }}</td>
                                    <th>Address</th>
                                    <td>{{ $plan->lead_generation->address }}</td>
                                </tr>
                                <tr>
                                    <th>Division</th>
                                    <td>{{ $plan->lead_generation->division->name ?? '' }}</td>
                                    <th>District</th>
                                    <td>{{ $plan->lead_generation->district->name ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th>Thana</th>
                                    <td>{{ $plan->lead_generation->thana->name ?? '' }}</td>
                                    <th>Landmark</th>
                                    <td>{{ $plan->lead_generation->landmark }}</td>
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
                                    <th>Document</th>
                                    <td>
                                        @if ($plan->lead_generation->document)
                                            <a href="{{ asset('uploads/lead_generation/' . $plan->lead_generation->document) }}"
                                                target="_blank" class="btn btn-sm btn-warning" style="font-size:14px;"><i
                                                    class="fas fa-eye"></i></a>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <hr />
                    <div class="text-center">
                        <h5> <span> &#10070; </span> Plan Details <span>&#10070;</span> </h5>
                    </div>
                    <hr />
                    {{-- create a responsive table --}}
                    <div class="row">
                        <div class="col-md-5 col-5">
                            <div class="table-responsive">
                                <table class="table table-bordered table-particulars">
                                    <thead>
                                        <tr>
                                            <th colspan="5">Service Plan for
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
                        </div>
                        <div class="col-md-7 col-7">
                            <div class="table-responsive">
                                <table class="table table-bordered table-equipment">
                                    <thead>
                                        <tr>
                                            <th colspan="6">Equipment Plan for product</th>
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
                                    <tbody id="equipment_body">
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

                    <div>
                        @foreach ($plan->planLinks as $key => $plan_link)
                            @php $total_key = $key + 1; @endphp
                            <hr />
                            <div class="text-center">
                                <h5> <span> &#10070; </span> Link Details <span>&#10070;</span> </h5>
                            </div>
                            <hr />
                            <div class="main_link row">
                                <div class="table-responsive col-md-6 col-6">
                                    <table class="table table-bordered table-particulars text-right">
                                        <tr>
                                            <th colspan="2">Link {{ $total_key }} Information</th>
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
                                            <th class="text-left" style="width: 50%;">Existing Transmission Capacity</th>
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

                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-particulars">
                                            <tr>
                                                <th colspan="4">Survey Information</th>
                                            </tr>
                                            <tr>
                                                <th class="text-left" style="width: 50%;">Link Vendor</th>
                                                <td class="link_vendor">
                                                    {{ $plan_link->finalSurveyDetails->vendor->name ?? '' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="text-left" style="width: 50%;">Connecting POP Running Vendor</th>
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
                                                <th class="text-left" style="width: 50%;">Zone Area Running NTTN Vendor</th>
                                                <td class="nttn_vendor_zone"></td>
                                            </tr>
                                            <tr>
                                                <th class="text-left" style="width: 50%;">Last Mile Connectivity Method</th>
                                                <td class="last_mile_connectivity_method">
                                                    {{ $plan_link->finalSurveyDetails->method ?? '' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="text-left" style="width: 50%;">Zone Area Running NTTN BW</th>
                                                <td class="running_nttn_bw"></td>
                                            </tr>
                                            <tr>
                                                <th class="text-left" style="width: 50%;">Last Connectivity Point Latitute
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
                                                <th class="text-left" style="width: 50%;">Last Connectivity Point Longitute
                                                </th>
                                                <td class="connectivity_lat_long">
                                                    {{ $plan_link->finalSurveyDetails->long ?? '' }}
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <hr />
                                        <h5> <span> &#10070; </span> Link Equipment <span>&#10070;</span> </h5>
                                    </div>
                                    <hr />
                                    <div class="table-responsive">
                                        <table class="table table-bordered" style="font-size: 12px;">
                                            <thead>
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
                                            <tbody class="link_equipment_table">
                                                @foreach ($plan_link->PlanLinkEquipments as $plan_equipment)
                                                    <tr>
                                                        <td>
                                                            <span>{{ $plan_equipment->material->name ?? '&nbsp;' }}</span>
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
                                    <hr />
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

@endsection
