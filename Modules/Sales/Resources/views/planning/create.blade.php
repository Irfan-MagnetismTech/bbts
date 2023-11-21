@extends('layouts.backend-layout')
@section('title', 'Planning')

@php
    $is_old = old() ? true : false;
    $form_heading = !empty($planning->id) ? 'Edit' : 'Create';
    $form_url = !empty($planning->id) ? route('planning.update', $planning->id) : route('planning.store');
    $form_method = !empty($planning->id) ? 'PUT' : 'POST';
@endphp
@section('style')
    <style>
        #link_container .main_link {
            border: 2px solid gray;
            border-radius: 15px;
            padding: 8px;
            margin-top: 10px;
        }

        .table_label {
            width: 30px;
            text-align: left !important;
        }

        .surveyTable th,
        .client_information th {
            background-color: #e7e7dc !important;
            color: black !important;
        }

        .custom-spinner-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 40vh;
        }

        .custom-spinner {
            width: 4rem;
            height: 4rem;
            border: .5em solid transparent;
            border-top-color: currentColor;
            border-radius: 50%;
            animation: spinner-animation 1s linear infinite;
        }

        @keyframes spinner-animation {
            to {
                transform: rotate(360deg);
            }
        }

        /* .table_heading {
                background-color: #007af5 !important;
                color: white !important;
                font-size: 14px !important;
            } */
    </style>
@endsection

@section('breadcrumb-title')
    {{ ucfirst($form_heading) }} Planning
@endsection

@section('breadcrumb-button')
    <a href="{{ route('planning.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-list"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')

    {!! Form::open([
        'url' => $form_url,
        'method' => $form_method,
        'class' => 'custom-form',
    ]) !!}

    {{-- Comparative Statement --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                {{-- <div class="tableHeading">
                    <h5> <span> &#10070; </span> Planning <span>&#10070;</span> </h5>
                </div> --}}
                <div class="card-body">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            {{-- <h5 class="text-center">Client Information</h5> --}}
                            <table class="table table-bordered client_information" style="font-size: 12px;">
                                <thead>
                                    <tr>
                                        <th class="text-center" colspan="6"
                                            style="background-color: #edeef0 !important; font-size: 14px !important;">
                                            Connectivity
                                            Point
                                            Information</th>
                                    </tr>
                                </thead>

                                <tr>
                                    <th class="table_label">
                                        Client Name
                                    </th>
                                    <td>
                                        {{ $lead_generation->client_name }}
                                    </td>
                                    <th class="table_label">Connectivity Point</th>
                                    <td>{{ $feasibilityRequirementDetail->connectivity_point }}</td>
                                    <th class="table_label">Division</th>
                                    <td>{{ $feasibilityRequirementDetail->division->name ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th class="table_label">Contact Person</th>
                                    <td>{{ $feasibilityRequirementDetail->contact_name }}</td>
                                    <th class="table_label">Lat-Long</th>
                                    <td>{{ $feasibilityRequirementDetail->lat }} - {{ $feasibilityRequirementDetail->long }}
                                    </td>
                                    <th class="table_label">District</th>
                                    <td>{{ $feasibilityRequirementDetail->district->name ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th class="table_label">Contact No</th>
                                    <td>{{ $feasibilityRequirementDetail->contact_no }}</td>
                                    <th class="table_label">Branch</th>
                                    <td>{{ $feasibilityRequirementDetail->branch->name ?? '' }}</td>
                                    <th class="table_label">Thana</th>
                                    <td>{{ $feasibilityRequirementDetail->thana->name ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th class="table_label">Email</th>
                                    <td>{{ $feasibilityRequirementDetail->contact_email }}</td>
                                    <th class="table_label">Address</th>
                                    <td> {{ $feasibilityRequirementDetail->location }}</td>
                                    <th class="table_label">Document</th>
                                    <td>
                                        @if ($lead_generation->document)
                                            <a href="{{ asset('uploads/lead_generation/' . $lead_generation->document) }}"
                                                target="_blank" class="btn btn-sm btn-warning" style="font-size:14px;"><i
                                                    class="fas fa-eye"></i></a>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table_label">Remarks</th>
                                    <td colspan="5" style="padding: 2px !important; margin: 2px !important;">
                                        <input type="text" name="remarks" id="remarks"
                                            class="form-control form-control-sm" value=""
                                            style="height: 25px !important;" placeholder="Remarks">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    {{-- <hr /> --}}
                    {{-- <div class="text-center">
                        <h5> <span> &#10070; </span> Plan Details <span>&#10070;</span> </h5>
                    </div> --}}
                    {{-- <hr /> --}}
                    {{-- create a responsive table --}}

                    {{--                    <div class="row loading" style="display: none;"> --}}
                    {{--                        <div class="col-md-12"> --}}
                    {{--                            <div class="custom-spinner-container"> --}}
                    {{--                                <div class="custom-spinner text-primary" role="status"> --}}
                    {{--                                    <span class="sr-only">Loading...</span> --}}
                    {{--                                </div> --}}

                    {{--                                <!-- Optional text --> --}}
                    {{--                                <div class="mt-2">Loading...</div> --}}
                    {{--                            </div> --}}
                    {{--                        </div> --}}
                    {{--                    </div> --}}

                    <div class="row ">
                        <div class="md-col-5 col-5">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th colspan="5">Service Plan
                                                {{-- {{ $feasibilityRequirementDetail->location }} --}}
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Particulars</th>
                                            <th>Client Req.</th>
                                            <th>Plan</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody id="particular_body">
                                        @foreach ($connectivityProductRequirementDetails as $detail)
                                            <tr class="particular_row">
                                                <td style="width:30%">
                                                    <input type="hidden" name="detail_id[]" id="detail_id"
                                                        class="form-control form-control-sm"
                                                        value="{{ $detail->id ?? '' }}">
                                                    <span
                                                        class="form-control form-control-sm">{{ $detail->product->name ?? '' }}</span>

                                                </td>
                                                <td>
                                                    <span
                                                        class="form-control form-control-sm">{{ $detail->capacity ?? '' }}</span>
                                                </td>
                                                <td>
                                                    <input type="text" name="plan[]" id="plan"
                                                        class="form-control form-control-sm" value="">
                                                </td>
                                                <td style="width:30%">
                                                    <span
                                                        class="form-control form-control-sm">{{ $detail->remarks ?? '' }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                </table>
                            </div>
                        </div>
                        <div class="md-col-7 col-7">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="equipment_table">
                                    <thead>
                                        <tr>
                                            <th colspan="6">Equipment Plan for product</th>
                                            <th rowspan="2">
                                                {{-- <button type="button" class="" id="addEquipmentRow">
                                                    <i class="fas fa-plus"></i>
                                                </button> --}}
                                                <button type="button" class="btn btn-sm btn-success"
                                                    style="padding: 5px 10px" id="addEquipmentRow"><i
                                                        class="fas fa-plus"></i></button>
                                            </th>
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
                                    <tbody class="equipment_body">
                                        <tr class="equipment_row">
                                            <td>
                                                <div>
                                                    <select name="equipment_id[]"
                                                        class="form-control form-control-sm equipment_id select2">
                                                        <option value="">Select Equipment</option>
                                                        @foreach ($materials as $material)
                                                            <option value="{{ $material->id }}">
                                                                {{ $material->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="text" name="quantity[]" class="form-control form-control-sm"
                                                    value="">
                                            </td>
                                            <td>
                                                <input type="text" name="unit[]"
                                                    class="form-control form-control-sm unit" value="">
                                            </td>
                                            <td>
                                                <div>
                                                    <select name="brand_id[]"
                                                        class="form-control form-control-sm brand_id select2">
                                                        <option value="">Select Brand</option>
                                                        @foreach ($brands as $brand)
                                                            <option value="{{ $brand->id }}">
                                                                {{ $brand->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <input list="models" name="model[]" id="model[]"
                                                        class="form-control model" value="">
                                                    <datalist id="models">
                                                        @foreach ($models as $model)
                                                            <option value="{{ $model }}">
                                                        @endforeach
                                                    </datalist>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="text" name="equipment_remarks[]"
                                                    class="form-control form-control-sm equipment_remarks" value="">
                                            </td>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-danger removeEquipmentRow"
                                                    style="padding: 5px 10px"><i class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{-- <hr /> --}}

                    <div class="row">
                        <input type="hidden" id="client_id" name="client_id"
                            value="{{ $lead_generation->client_id }}">
                        <input type="hidden" name="total_key" id="total_key" value="1">
                        {{-- <div class="col-md-11 text-center">
                            <h5> <span> &#10070; </span> Link Information <span>&#10070;</span> </h5>
                        </div> --}}
                        {{-- <div class="col-md-1" style="float: right">
                            <button type="button" class="btn btn-sm btn-outline-success" style="padding: 5px 10px" id="addLinkRow">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div> --}}
                    </div>
                    {{-- <hr /> --}}
                    <div id="link_container">
                        <div class="main_link">
                            <input type="hidden" name="plan_link_no_1" value="">
                            <div class="row">
                                <div class="col-md-10 col-10">
                                    <h5 class="text-center mb-2"> <span>&#10070;</span> Link - <span
                                            class="link_no">1</span> <span>&#10070;</span></h5>
                                </div>
                                {{-- <div class="col-md-1 col-1">
                                    <button type="button" class="btn btn-sm btn-outline-success" style="padding: 5px 10px" id="addLinkRow">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div> --}}
                                <div class="col-md-1 col-1">
                                    <nobr>
                                        <button type="button" class="btn btn-sm btn-outline-success addLinkRow"
                                            style="padding: 5px 10px">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                        <button type="button"
                                            class="btn btn-sm btn-outline-danger text-left removeLinkRow"
                                            style="padding: 5px 10px" onclick="removeLinkRow(this)"><i
                                                class="fas fa-trash"></i></button>
                                    </nobr>
                                </div>
                                {{-- <hr style="width: 100%; margin-bottom: 10px;"> --}}
                                <div class="md-col-3 col-3  mt-3">
                                    <div class="form-item">
                                        <select name="link_type_1" class="form-control form-control-sm link_type "
                                            required>
                                            <option value="">Select Type</option>
                                            <option value="Primary">Primary</option>
                                            <option value="Secondary">Secondary</option>
                                            <option value="Tertiary">Tertiary</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="md-col-3 col-3  mt-3">
                                    <div class="form-item">
                                        <select name="option_1" class="form-control form-control-sm option "
                                            onchange="optionChange(event)" required>
                                            <option value="">Select Option</option>
                                            <option value="Option 1">Option 1</option>
                                            <option value="Option 2">Option 2</option>
                                            <option value="Option 3">Option 3
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-3 col-md-3  mt-3">
                                    <div class="form-item">
                                        <select name="existing_infrastructure_1"
                                            class="form-control form-control-sm existing_infrastructure">
                                            <option value="">Select Status</option>
                                            <option value="Existing">Existing</option>
                                            <option value="New">New</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-3 col-md-3 mt-3 link_list" style="display: none">
                                    <div class="form-item">
                                        <select name="existing_infrastructure_link_1"
                                            class="form-control form-control-sm existing_infrastructure_link ">
                                            <option value="">Select Link</option>
                                        </select>
                                        <label for="type">Link List</label>
                                    </div>
                                </div>
                                <div class="md-col-3 col-3  mt-3" style="display: none">
                                    <div class="form-item">
                                        <input type="text" name="existing_transmission_capacity_1"
                                            class="form-control form-control-sm existing_transmission_capacity"
                                            value="">
                                        <label for="type">Existing T.Capacity</label>
                                    </div>
                                </div>

                                <div class="md-col-3 col-3 mt-3" style="display: none">
                                    <div class="form-item">
                                        <input type="text" name="increase_capacity_1"
                                            class="form-control form-control-sm increase_capacity" value="">
                                        <label for="type">Increase Capacity</label>
                                    </div>
                                </div>
                                <div class="md-col-3 col-3  mt-3 new_transmission_capacity_div">
                                    <div class="form-item">
                                        <input type="text" name="new_transmission_capacity_1"
                                            class="form-control form-control-sm" value="">
                                        <label for="type">New T.Capacity</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered surveyTable" style="font-size: 12px;">
                                        <tr>
                                            <th class="text-center"
                                                style="background-color: #e1e7ec !important; font-size: 14px !important;"
                                                colspan="4"> Survey Information</th>
                                        </tr>
                                        <tr>
                                            <th class="text-left table_label">Vendor</th>
                                            <td class="link_vendor" style="width:40%">
                                                <select name="link_vendor_id_1"
                                                    class="form-control form-control-sm link_vendor_id_1 select2"
                                                    style="display: none">
                                                    <option value="">Select Vendor</option>
                                                    @foreach ($vendors as $vendor)
                                                        <option value="{{ $vendor->id }}">
                                                            {{ $vendor->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <th class="text-left table_label"> POP Vendors</th>
                                            <td class="running_vendor_pop" style="width:40%"></td>
                                        </tr>
                                        <tr>
                                            <th class="text-left">POP</th>
                                            <td class="link_connecting_pop" style="width:40%">
                                                <select name="link_connecting_pop_id_1"
                                                    class="form-control form-control-sm link_connecting_pop_id_1 select2"
                                                    style="display: none">
                                                    <option value="">Select POP</option>
                                                    @foreach ($pops as $pop)
                                                        <option value="{{ $pop->id }}"> {{ $pop->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <th class="text-left"> POP Capacity</th>
                                            <td class="running_vendor_capacity" style="width:40%"></td>
                                        </tr>
                                        <tr>
                                            <th class="text-left">Method</th>
                                            <td class="last_mile_connectivity_method" style="width:40%">
                                                {{-- <input type="text" name="last_mile_connectivity_method_1"
                                                    class="form-control form-control-sm last_mile_connectivity_method_1"
                                                    style="height: 25px !important" value="" > --}}
                                                <select name="last_mile_connectivity_method_1"
                                                    class="form-control form-control-sm last_mile_connectivity_method_1">
                                                    <option value="">Select Method</option>
                                                    @foreach ($methods as $key => $method)
                                                        <option value="{{ $key }}">{{ $method }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <th class="text-left">Zone Vendors</th>
                                            <td class="nttn_vendor_zone" style="width:40%"></td>
                                        </tr>
                                        <tr>
                                            <th class="text-left">Latitude</th>
                                            <td class="connectivity_lat_long" style="width:40%">
                                                <input type="text" name="connectivity_lat_1"
                                                    class="form-control form-control-sm connectivity_lat_1"
                                                    style="height: 25px !important" value="">
                                            </td>
                                            <th class="text-left">Zone Capacity</th>
                                            <td class="running_nttn_bw" style="width:40%"></td>
                                        </tr>
                                        <tr>
                                            <th class="text-left">Longitude</th>
                                            <td class="connectivity_lat_long" style="width:40%">
                                                <input type="text" name="connectivity_long_1"
                                                    class="form-control form-control-sm connectivity_long_1"
                                                    style="height: 25px !important" value="">
                                            </td>
                                            <th class="text-left">Connectivity Route</th>
                                            <td class="connectivity_route" style="width:40%"></td>

                                        </tr>
                                        <tr>
                                            <th class="text-left">Distance</th>
                                            <td class="connectivity_lat_long" style="width:40%">
                                                <input type="text" name="distance_1"
                                                    class="form-control form-control-sm distance_1"
                                                    style="height: 25px !important" value="">
                                            </td>
                                            <th class="text-left">Remarks</th>
                                            <td class="connectivity_route" style="width:40%">
                                                <input type="text" name="link_remarks_1"
                                                    class="form-control form-control-sm" style="height: 25px !important"
                                                    value="">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered" style="font-size: 12px;">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="font-size: 14px!important" colspan="7">
                                                    <span> &#10070; </span> Link Equipment <span>&#10070;</span>
                                                </th>
                                                <th rowspan="2">
                                                    <button type="button"
                                                        class="btn btn-success btn-sm addLinkEquipmentRow"
                                                        style="padding: 5px 10px" onclick="addLinkEquipmentRow(this)">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </th>
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
                                        <tbody class="link_equipment_table">
                                            <tr>
                                                <td>
                                                    <div>
                                                        <select name="material_id_1[]"
                                                            class="form-control form-control-sm link_material_id select2">
                                                            <option value="">Select Equipment</option>
                                                            @foreach ($materials as $material)
                                                                <option value="{{ $material->id }}">
                                                                    {{ $material->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="quantity_1[]"
                                                        class="form-control form-control-sm link_quantity" value="">
                                                </td>
                                                <td>
                                                    <input type="text" name="unit_1[]"
                                                        class="form-control form-control-sm link_unit" value="">
                                                </td>
                                                <td>
                                                    <div>
                                                        <select name="brand_id_1[]"
                                                            class="form-control form-control-sm link_brand select2">
                                                            <option value="">Select Brand</option>
                                                            @foreach ($brands as $brand)
                                                                <option value="{{ $brand->id }}">
                                                                    {{ $brand->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>
                                                        <input list="models" name="model_1[]" id="model_1[]"
                                                            class="form-control link_model" value="">
                                                        <datalist id="models">
                                                            @foreach ($models as $model)
                                                                <option value="{{ $model }}">
                                                            @endforeach
                                                        </datalist>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="description_1[]"
                                                        class="form-control form-control-sm link_description"
                                                        value="">
                                                </td>
                                                <td>
                                                    <input type="text" name="remarks_1[]"
                                                        class="form-control form-control-sm link_remarks" value="">
                                                </td>
                                                <td>
                                                    <button type="button"
                                                        class="btn btn-outline-danger btn-sm removeLinkEquipmentRow"
                                                        style="padding: 5px 10px" onclick="removeLinkEquipmentRow(this)">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- create a responsive table --}}
                    {{-- <div class="row">
                        <div class="col-md-12">
                            <hr />
                            <div class="text-center">
                                <h5> <span> &#10070; </span> Plan Preview <span>&#10070;</span> </h5>
                            </div>
                            <hr />
                            <div class="md-col-6 col-6">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th colspan="4">Equipment Plan</th>
                                            </tr>
                                            <tr>
                                                <th>Material</th>
                                                <th>Unit</th>
                                                <th>Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    Demo Material
                                                </td>
                                                <td>
                                                    PCS
                                                </td>
                                                <td>
                                                    10
                                                </td>
                                            </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <input type="hidden" id="client_no" name="client_no" value="{{ $lead_generation->client_no }}">
                    <input type="hidden" id="fr_no" name="fr_no"
                        value="{{ $feasibilityRequirementDetail->fr_no }}">
                </div>
                <button
                    class="py-2 btn btn-success float-right">{{ !empty($connectivity_requirement->id) ? 'Update' : 'Save' }}</button>
            </div>
        </div>
        {!! Form::close() !!}

    @endsection

    @section('script')
        <script>
            let plan_equipment_html = `<tr class="equipment_row">
                                            <td>
                                                <div>
                                                    <select name="equipment_id[]"
                                                    class="form-control form-control-sm equipment_id select2">
                                                        <option value="">Select Equipment</option>
                                                        @foreach ($materials as $material)
                                                            <option value="{{ $material->id }}">
                                                                {{ $material->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="text" name="quantity[]"
                                                    class="form-control form-control-sm" value="">
                                            </td>
                                            <td>
                                                <input type="text" name="unit[]"
                                                    class="form-control form-control-sm unit" value="">
                                            </td>
                                            <td>
                                                <div>
                                                    <select name="brand_id[]"
                                                    class="form-control form-control-sm brand_id select2">
                                                        <option value="">Select Brand</option>
                                                        @foreach ($brands as $brand)
                                                            <option value="{{ $brand->id }}">
                                                                {{ $brand->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <input list="models" name="model[]" id="model[]" class="form-control model">
                                                    <datalist id="models">
                                                        @foreach ($models as $model)
                                                    <option value="{{ $model }}">
                                                        @endforeach
                                                    </datalist>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="text" name="equipment_remarks[]"
                                                    class="form-control form-control-sm equipment_remarks" value="">
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-danger removeEquipmentRow"><i
                                                        class="fas fa-trash"></i></button>
                                            </td>
                                        </tr> `;
            $('#addEquipmentRow').on('click', function() {
                addEquipmentRow();
                $(".select2").select2();
            });

            function addEquipmentRow() {
                let check_first_row = $('.equipment_row').length;
                if (check_first_row !== 0) {
                    let row = $('.equipment_row').first().clone();
                    row.find('input').val('');
                    row.find("span").remove();
                    row.appendTo('.equipment_body');
                } else {
                    $('.equipment_body').append('<tr>' + plan_equipment_html + '</tr>');
                }

            };


            $(document).on('click', '.removeEquipmentRow', function() {
                let count = $('.equipment_row').length;
                if (count > 1) {
                    $(this).closest('tr').remove();
                } else {
                    plan_equipment_html = $(this).closest('tr').html();
                    $(this).closest('tr').remove();
                }
            });


            $('#date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                showOtherMonths: true
            }).datepicker("setDate", new Date());

            function optionChange(event) {
                var check_validation = checkUniqueTypeAndOption(event.target);
                console.log('check_validation', check_validation);
                if (check_validation == false) {
                    return false;
                } else {
                    let option = $(event.target).val();
                    var link_type = $(event.target).closest('.main_link').find('.link_type').val();
                    let client_id = $('#client_no').val();
                    let fr_no = $('#fr_no').val();
                    $.ajax({
                        url: "{{ route('get-survey-details') }}",
                        data: {
                            option: option,
                            link_type: link_type,
                            client_id: client_id,
                            fr_no: fr_no,
                        },
                        success: function(data) {
                            $(event.target).closest('.main_link').find('input[name^="plan_link_no_"]').val(data
                                ?.link_no);
                            $(event.target).closest('.main_link').find('select[name^="link_vendor_id_"]').val(data
                                ?.vendor
                                ?.id).trigger('change');

                            //set existing_infrastructure_ select box value
                            $(event.target).closest('.main_link').find('select[name^="existing_infrastructure_"]')
                                .val(
                                    data
                                    ?.status);
                            $(event.target).closest('.main_link').find('input[name^="availability_status_"]').val(
                                data
                                ?.status);
                            $(event.target).closest('.main_link').find('select[name^="link_connecting_pop_id_"]')
                                .val(
                                    data?.pop?.id).trigger('change');
                            $(event.target).closest('.main_link').find(
                                    'select[name^="last_mile_connectivity_method_"]')
                                .val(data?.method).trigger('change');
                            $(event.target).closest('.main_link').find('input[name^="connectivity_long_"]').val(data
                                ?.long);
                            $(event.target).closest('.main_link').find('input[name^="connectivity_lat_"]').val(data
                                ?.lat);
                            $(event.target).closest('.main_link').find('input[name^="distance_"]').val(data
                                ?.distance);
                            $(event.target).closest('.main_link').find('input[name^="gps_"]').val(data?.gps);
                            $(event.target).closest('.main_link').find('input[name^="connectivity_point_"]').val(
                                data
                                ?.bts_pop_ldp)
                            // $(event.target).closest('.main_link').find('.link_vendor').html(data.vendor);
                            // $(event.target).closest('.main_link').find('.availability_status').html(data.status);
                            // $(event.target).closest('.main_link').find('.link_connecting_pop').html(data.bts_pop_ldp);
                            // $(event.target).closest('.main_link').find('.last_mile_connectivity_method').html(data
                            //     .method);
                            // $(event.target).closest('.main_link').find('.connectivity_lat_long').html(data.gps);
                            // $(event.target).closest('.main_link').find('.distance').val(data.distance);
                            // $(event.target).closest('.main_link').find('.gps').val(data.gps);
                            // $(event.target).closest('.main_link').find('.connectivity_point').val(data.bts_pop_ldp)
                            changeLink($(event.target));
                        }
                    });
                }
            }

            function checkUniqueTypeAndOption(currentValue) {
                let checkValidation = true;
                var current_selector = $(currentValue);
                var current_link_type = $(currentValue).closest('.main_link').find('.link_type').val();
                var current_option = $(currentValue).closest('.main_link').find('.option').val();
                var current_key = `${current_link_type}_${current_option}`;
                console.log('current_key', current_key);
                var count_row = $('.main_link').length;
                var thisOption = $(currentValue).closest('.main_link').find('.option');
                let options = $('.option').not($(thisOption));

                options.each(function() {
                    var link_type = $(this).closest('.main_link').find('.link_type').val();
                    var option = $(this).closest('.main_link').find('.option').val();
                    var key = `${link_type}_${option}`;
                    console.log('key', key);
                    if (key === current_key && count_row > 1) {
                        swal.fire({
                            title: "Same Link Type and Option already exists!",
                            type: "warning",
                        }).then(function() {
                            $(current_selector).closest('.main_link').find('.option').val('').trigger(
                                'change');
                        });
                        checkValidation = false;
                        return false;

                    } else {
                        checkValidation = true;
                    }
                });
                return checkValidation;
            }

            function addLinkEquipmentRow(event) {
                var $table = $(event).closest('.table-bordered');
                var $clone = $table.find('tbody tr:first').clone();
                $clone.find('input').val('');
                $clone.find('span').remove();
                $table.find('tbody').append($clone);
                $(".select2").select2();
            }

            function removeLinkEquipmentRow(event) {
                var $table = $(event).closest('.table-bordered');
                var $tr = $table.find('tbody tr');
                if ($tr.length > 1) {
                    $(event).closest('tr').remove();
                }
            }
            $(document).on('click', '.addLinkRow', function() {
                addLinkRow();
            });

            // $('.addLinkRow').on('click', function() {
            //     addLinkRow();
            // });

            function addLinkRow() {
                var clonedRow = $('.main_link').first().clone();
                var count_row = $('.main_link').length;
                var link_no = parseInt(count_row) + 1;
                $('#total_key').val(link_no);

                clonedRow.find('input, select').val('').attr('name', function(index, name) {
                    var underscoreIndex = name.lastIndexOf('_');
                    if (underscoreIndex !== -1) {
                        var baseName = name.substring(0, underscoreIndex);
                        var fieldName = name.substring(underscoreIndex + 1);
                        if (fieldName.includes('[]')) {
                            return baseName + '_' + link_no + '[]';
                        } else {
                            return baseName + '_' + link_no;
                        }
                    }
                });
                // clonedRow.find('span').remove();
                clonedRow.find('span:not(.link_no)').remove();
                clonedRow.find('#addLinkEquipmentRow').attr('id', 'addLinkEquipmentRow_' + link_no);
                clonedRow.find('#removeLinkEquipmentRow').attr('id', 'removeLinkEquipmentRow_' + link_no);
                clonedRow.appendTo('#link_container');
                clonedRow.find('.link_no').html(link_no);
                var $equipmentRow = clonedRow.find('.link_equipment_table').children('tr').length;
                if ($equipmentRow > 1) {
                    clonedRow.find('.link_equipment_table tr').not(':first').remove();
                }
                $(".select2").select2();
            }

            function removeLinkRow(event) {
                var count = $('.main_link').length;
                if (count > 1) {
                    $(event).closest('.main_link').remove();
                }
            }

            $(document).on('change', '.equipment_id', function() {
                // $('.loading').show();
                var this_event = $(this);
                var equipment_id = $(this).val();
                var equiments = {!! json_encode($materials) !!};
                var find_equipment = equiments.find(x => x.id == equipment_id);
                $(this).closest('tr').find('.unit').val(find_equipment.unit);
                $.get('{{ route('getMaterialWiseBrands') }}', {
                    material_id: equipment_id
                }, function(data) {
                    var html = '<option value="">Select Brand</option>';
                    $.each(data, function(key, item) {
                        html += '<option value="' + item.id + '">' +
                            item.name + '</option>';
                    });
                    this_event.closest('tr').find('.brand_id').html(html);
                    // $('.loading').hide();
                })
            });

            $(document).on('change', '.link_material_id', function() {
                // $('.loading1').show();
                var this_event = $(this);
                var material_id = $(this).val();
                var materials = {!! json_encode($materials) !!};
                var find_material = materials.find(x => x.id == material_id);
                $(this).closest('tr').find('.link_unit').val(find_material.unit);
                $.get('{{ route('getMaterialWiseBrands') }}', {
                    material_id: material_id
                }, function(data) {
                    var html = '<option value="">Select Brand</option>';
                    $.each(data, function(key, item) {
                        html += '<option value="' + item.id + '">' +
                            item.name + '</option>';
                    });
                    this_event.closest('tr').find('.link_brand').html(html);
                    // $('.loading1').hide();
                })
            });

            $(document).on('change', '.brand_id', function() {
                // $('.loading').show();
                var material_id = $(this).closest('tr').find('.equipment_id').val();
                var brand_id = $(this).val();
                getModel(material_id, brand_id);
            });

            $(document).on('change', '.link_brand', function() {
                // $('.loading1').show();
                var material_id = $(this).closest('tr').find('.link_material_id').val();
                var brand_id = $(this).val();
                getModel(material_id, brand_id);
            });

            function getModel(material_id, brand_id) {
                $.get('{{ route('getMaterialWiseModels') }}', {
                    material_id: material_id,
                    brand_id: brand_id,
                }, function(data) {
                    var html = '';
                    $.each(data, function(key, item) {
                        html += '<option value="' + item + '">' + item + '</option>';
                    });
                    $('#models').empty().append(html);
                    // $('.loading').hide();
                    // $('.loading1').hide();
                });
            }

            let link_array = [];

            $(document).on('change', '.existing_infrastructure', function() {
                changeLink($(this));
            });

            $(document).on('change', '.link_connecting_pop_id_1', function() {
                changeLink($(this));
            });


            function changeLink(this_event) {
                // alert('change');
                // var this_event = $(this);
                // alert(this_event);
                let pop_id = this_event.closest('.main_link').find('.link_connecting_pop_id_1').val();
                var value = this_event.closest('.main_link').find('.existing_infrastructure').val();
                // alert(value);
                if (value == 'Existing') {
                    $.ajax({
                        url: "{{ route('get-existing-link-list') }}",
                        data: {
                            pop_id: pop_id,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            this_event.closest('.main_link').find('.link_list').css('display', 'block');
                            var html = '<option value="">Select Link</option>';
                            $.each(data, function(key, item) {
                                $.each(item, function(key, value) {
                                    link_array.push(value);
                                    html += '<option value="' + value.bbts_link_id + '">' +
                                        value.bbts_link_id + '</option>';
                                });
                            });
                            this_event.closest('.main_link').find('.existing_infrastructure_link').html(
                                html);
                            this_event.closest('.main_link').find('.existing_transmission_capacity').parent(
                                'div').parent(
                                'div').show();
                            this_event.closest('.main_link').find('.increase_capacity').parent('div')
                                .parent('div').show();
                        }
                    });
                    this_event.closest('.main_link').find('.new_transmission_capacity_div').css('display',
                        'none');
                } else {
                    this_event.closest('.main_link').find('.link_list').css('display', 'none');
                    this_event.closest('.main_link').find('.new_transmission_capacity_div').css('display',
                        'block');
                    this_event.closest('.main_link').find('.existing_transmission_capacity').parent('div').parent(
                        'div').hide();
                    this_event.closest('.main_link').find('.increase_capacity').parent('div').parent('div').hide();
                }
            }

            $(document).on('change', '.existing_infrastructure_link', function() {
                var this_event = $(this);
                var value = this_event.val();

                // Filter the link_array to find the link with the selected 'bbts_link_id'
                var link = link_array.filter(function(item) {
                    return item.bbts_link_id == value;
                });

                // Sort the link array based on the 'created_at' date in descending order (latest date first)
                link.sort(function(a, b) {
                    // Convert the dates to JavaScript Date objects for comparison
                    const dateA = new Date(a.created_at);
                    const dateB = new Date(b.created_at);
                    // Sort in descending order
                    return dateB - dateA;
                });

                // Access the link with the latest date (first element of the sorted array)
                const latestLink = link[0];
                this_event.closest('.main_link').find('.existing_transmission_capacity').val(latestLink.capacity).attr(
                    'value', latestLink.capacity);
            });
        </script>
    @endsection
