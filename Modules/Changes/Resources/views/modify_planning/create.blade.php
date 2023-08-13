@extends('layouts.backend-layout')
@section('title', 'Planning')

@php
    $is_old = old() ? true : false;
    $form_heading = 'Create';
    $form_url = route('planning.store');
    $form_method = 'POST';
    $client_no = $is_old ? old('client_no') : $connectivity_requirement->lead_generation->client_no;
    $client_name = $is_old ? old('client_name') : $connectivity_requirement->lead_generation->client_name;
    $client_address = $is_old ? old('client_address') : $connectivity_requirement->lead_generation->address;
    $client_division = $is_old ? old('client_division') : $connectivity_requirement->lead_generation->division->name;
    $client_district = $is_old ? old('client_district') : $connectivity_requirement->lead_generation->district->name;
    $client_thana = $is_old ? old('client_thana') : $connectivity_requirement->lead_generation->thana->name;
    $client_landmark = $is_old ? old('client_landmark') : $connectivity_requirement->lead_generation->landmark;
    $client_lat_long = $is_old ? old('client_lat_long') : $connectivity_requirement->lead_generation->lat_long;
    $client_contact_person = $is_old ? old('client_contact_person') : $connectivity_requirement->lead_generation->contact_person;
    $client_contact_no = $is_old ? old('client_contact_no') : $connectivity_requirement->lead_generation->contact_no;
    $client_email = $is_old ? old('client_email') : $connectivity_requirement->lead_generation->email;
    $client_website = $is_old ? old('client_website') : $connectivity_requirement->lead_generation->website;
    $client_document = $is_old ? old('client_document') : $connectivity_requirement->lead_generation->document;
    $change_type = $is_old ? old('change_type') : json_decode($connectivity_requirement->change_type) ?? [];
    $requirement_details = $is_old ? old('requirement_details') : $connectivity_requirement->connectivityRequirementDetails;
    $product_details = $is_old ? old('product_details') : $connectivity_requirement->connectivityProductRequirementDetails;
    $fr_no = $is_old ? old('fr_no') : $connectivity_requirement->fr_no;
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
                <div class="tableHeading">
                    <h5> <span> &#10070; </span> Planning <span>&#10070;</span> </h5>
                </div>
                <div class="card-body">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <h5 class="text-center">Client Information</h5>
                            <hr />
                            <table class="table custom_table table-bordered" style="font-size: 12px;">
                                <tr>
                                    <th class="table_label">Client Name</th>
                                    <td>{{ $client_name }}</td>
                                    <th class="table_label">Address</th>
                                    <td>{{ $client_address }}</td>
                                </tr>
                                <tr>
                                    <th class="table_label">Division</th>
                                    <td>{{ $client_division }}</td>
                                    <th class="table_label">District</th>
                                    <td>{{ $client_district }}</td>
                                </tr>
                                <tr>
                                    <th class="table_label">Thana</th>
                                    <td>{{ $client_thana }}</td>
                                    <th class="table_label">Landmark</th>
                                    <td>{{ $client_landmark }}</td>
                                </tr>
                                <tr>
                                    <th class="table_label">Lat-Long</th>
                                    <td>{{ $client_lat_long }}</td>
                                    <th class="table_label">Contact Person</th>
                                    <td>{{ $client_contact_person }}</td>
                                </tr>
                                <tr>
                                    <th class="table_label">Contact No</th>
                                    <td>{{ $client_contact_no }}</td>
                                    <th class="table_label">Email</th>
                                    <td>{{ $client_email }}</td>
                                </tr>
                                <tr>
                                    <th class="table_label">Website</th>
                                    <td>{{ $client_website }}</td>
                                    <th class="table_label">Document</th>
                                    <td>
                                        {{-- @if ($lead_generation->document)
                                            <a href="{{ asset('uploads/lead_generation/' . $lead_generation->document) }}"
                                                target="_blank" class="btn btn-sm btn-warning" style="font-size:14px;"><i
                                                    class="fas fa-eye"></i></a>
                                        @endif --}}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <hr />
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" name="change_type[]" id="temporary_inactive"
                                        @if (in_array('Temporary-Inactive', $change_type)) checked @endif value="Temporary-Inactive">
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span>Temporary-Inactive</span>
                                </label>
                            </div>
                            <div class="checkbox-fade fade-in-primar  y">
                                <label>
                                    <input type="checkbox" name="change_type[]" value="Permanent-Inactive"
                                        id="permanent_inactive" @if (in_array('Permanent-Inactive', $change_type)) checked @endif>
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span>Permanent Inactive</span>
                                </label>
                            </div>
                            <div class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" name="change_type[]" value="Re-Inactive" id="re_inactive"
                                        @if (in_array('Re-Inactive', $change_type)) checked @endif>
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span>Re-Inactive</span>
                                </label>
                            </div>
                            <div class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" name="change_type[]" value="B/W Increase/Decrease"
                                        id="bw_increase_decrease" @if (in_array('B/W Increase/Decrease', $change_type)) checked @endif>
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span>B/W Increase/Decrease</span>
                                </label>
                            </div>
                            <div class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" name="change_type[]" value="IP Increase/Decrease"
                                        id="ip_increase_decrease" @if (in_array('IP Increase/Decrease', $change_type)) checked @endif>
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span>IP Increase/Decrease</span>
                                </label>
                            </div>
                            <div class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" name="change_type[]" id="mrc_decrease" value="MRC-Decrease"
                                        @if (in_array('MRC-Decrease', $change_type)) checked @endif>
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span>MRC Decrease</span>
                                </label>
                            </div>
                            <div class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" name="change_type[]"
                                        value="Price Increase/Decrease with BW Change" id="price_increase_decrease"
                                        @if (in_array('Price Increase/Decrease with BW Change', $change_type)) checked @endif>
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span>Price Increase/Decrease with BW Change</span>
                                </label>
                            </div>
                            <div class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" name="change_type[]" value="Method Change" id="method_change"
                                        @if (in_array('Method Change', $change_type)) checked @endif>
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span>Method Change</span>
                                </label>
                            </div>
                            <div class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" name="change_type[]" value="Redundant Link" id="redundant_link"
                                        @if (in_array('Redundant Link', $change_type)) checked @endif>
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span>Redundant Link</span>
                                </label>
                            </div>
                            <div class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" name="change_type[]" value="Shifting" id="shifting"
                                        @if (in_array('Shifting', $change_type)) checked @endif>
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span>Shifting</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class="text-center">
                        <h5> <span> &#10070; </span> Plan Details <span>&#10070;</span> </h5>
                    </div>
                    <hr />
                    {{-- create a responsive table --}}
                    <div class="row ">
                        <div class="md-col-12 col-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th colspan="5">Service Plan for </th>
                                        </tr>
                                        <tr>
                                            <th>Particulars</th>
                                            <th>Client Req.</th>
                                            <th>Plan</th>
                                            <th>Remarks</th>
                                            <th>
                                                <button type="button" class="btn btn-sm btn-success"
                                                    id="addParticularRow"><i class="fas fa-plus"></i></button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="particular_body">
                                        @foreach ($product_details as $product_detail)
                                            <tr>
                                                <td>
                                                    <input type="hidden" name="detail_id[]" id="detail_id"
                                                        class="form-control form-control-sm"
                                                        value="{{ $product_detail->id ?? '' }}">
                                                    <span
                                                        class="form-control form-control-sm">{{ $product_detail->product->name ?? '' }}</span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="form-control form-control-sm">{{ $product_detail->capacity ?? '' }}</span>
                                                </td>
                                                <td>
                                                    <input type="text" name="plan[]" id="plan"
                                                        class="form-control form-control-sm" value="">
                                                </td>
                                                <td>
                                                    <input type="text" name="remarks[]" class="form-control"
                                                        value="{{ $product_detail->remarks }}" />
                                                </td>
                                                <td>
                                                    <button type="button"
                                                        class="btn btn-sm btn-danger removeParticularRow"><i
                                                            class="fas fa-minus"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="md-col-12 col-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th colspan="7">Equipment Plan for product</th>
                                        </tr>
                                        <tr>
                                            <th>Equipment Name</th>
                                            <th>Quantity</th>
                                            <th>Unit</th>
                                            <th>Brand</th>
                                            <th>Model</th>
                                            <th>Remarks</th>
                                            <th>
                                                <button type="button" class="btn btn-sm btn-success"
                                                    id="addEquipmentRow"><i class="fas fa-plus"></i></button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="equipment_body">
                                        <tr class="equipment_row">
                                            <td>
                                                <select name="equipment_id[]" id="equipment_id"
                                                    class="form-control form-control-sm equipment_id">
                                                    <option value="">Select Equipment</option>
                                                    @foreach ($materials as $material)
                                                        <option value="{{ $material->id }}">
                                                            {{ $material->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="quantity[]" id="quantity"
                                                    class="form-control form-control-sm" value="">
                                            </td>
                                            <td>
                                                <input type="text" name="unit[]" id="unit"
                                                    class="form-control form-control-sm unit" value="">
                                            </td>
                                            <td>
                                                <select name="brand_id[]" id="brand_id"
                                                    class="form-control form-control-sm brand_id">
                                                    <option value="">Select Brand</option>
                                                    @foreach ($brands as $brand)
                                                        <option value="{{ $brand->id }}">
                                                            {{ $brand->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="model[]" id="model"
                                                    class="form-control form-control-sm model" value="">
                                            </td>
                                            <td>
                                                <input type="text" name="equipment_remarks[]" id="equipment_remarks"
                                                    class="form-control form-control-sm equipment_remarks" value="">
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-danger removeEquipmentRow"><i
                                                        class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <input type="hidden" id="client_id" name="client_id" value="">
                        <input type="hidden" name="total_key" id="total_key" value="1">
                        <div class="col-md-11 text-center">
                            <h5> <span> &#10070; </span> Link Information <span>&#10070;</span> </h5>
                        </div>
                        <div class="col-md-1" style="float: right">
                            <button type="button" class="btn btn-sm btn-success text-left" id="addLinkRow"><i
                                    class="fas fa-plus"></i></button>
                        </div>
                    </div>
                    <hr />
                    <div id="link_container">
                        <div class="main_link">
                            <div class="row">
                                <div class="col-md-11 col-11">
                                    <h5 class="text-center mb-2">Link <span class="link_no">1</span></h5>
                                </div>
                                <div class="col-md-1 col-1">
                                    <button type="button" class="btn btn-sm btn-danger text-left removeLinkRow"
                                        onclick="removeLinkRow(this)"><i class="fas fa-trash"></i></button>
                                </div>
                                <hr / style="width: 100%; margin-bottom: 10px;">
                                <div class="md-col-3 col-3  mt-3">
                                    <div class="form-item">
                                        <select name="link_type_1" class="form-control form-control-sm link_type">
                                            <option value="">Select Type</option>
                                            <option value="Primary">Primary</option>
                                            <option value="Secondary">Secondary</option>
                                            <option value="Tertiary">Tertiary</option>
                                        </select>
                                        <label for="type">Type <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="md-col-3 col-3  mt-3">
                                    <div class="form-item">
                                        <select name="option_1" id="option"
                                            class="form-control form-control-sm option" onchange="optionChange(event)">
                                            <option value="">Select Option</option>
                                            <option value="Option 1">Option 1</option>
                                            <option value="Option 2">Option 2</option>
                                            <option value="Option 3">Option 3
                                            </option>
                                        </select>
                                        <label for="type">Option <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-3 col-md-3  mt-3">
                                    <div class="form-item">
                                        <select name="existing_infrastructure_1" id="existing_infrastructure"
                                            class="form-control form-control-sm existing_infrastructure">
                                            <option value="">Select Status</option>
                                            <option value="Existing">Existing</option>
                                            <option value="New">New</option>
                                        </select>
                                        <label for="type">Link Status</label>
                                    </div>
                                </div>
                                <div class="col-3 col-md-3 mt-3 link_list" style="display: none;">
                                    <div class="form-item">
                                        <select name="existing_infrastructure_link_1" id="existing_infrastructure_link"
                                            class="form-control form-control-sm existing_infrastructure_link">
                                            <option value="">Select Link</option>
                                        </select>
                                        <label for="type">Link List</label>
                                    </div>
                                </div>
                                <div class="md-col-3 col-3  mt-3">
                                    <div class="form-item">
                                        <input type="text" name="existing_transmission_capacity_1"
                                            id="existing_transmission_capacity"
                                            class="form-control form-control-sm existing_transmission_capacity"
                                            value="">
                                        <label for="type">Existing Transmission Capacity</label>
                                    </div>
                                </div>

                                <div class="md-col-3 col-3 mt-3">
                                    <div class="form-item">
                                        <input type="text" name="increase_capacity_1" id="increase_capacity"
                                            class="form-control form-control-sm increase_capacity" value="">
                                        <label for="type">Increase Capacity</label>
                                    </div>
                                </div>

                                <div class="md-col-3 col-3  mt-3">
                                    <div class="form-item">
                                        <select name="link_availability_status_1" id="link_availability_status"
                                            class="form-control form-control-sm link_availability_status">
                                            <option value="">Select Vendor</option>
                                            {{-- @foreach ($vendors as $vendor)
                                                <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                            @endforeach --}}
                                        </select>
                                        <label for="type">New Transmission Link</label>
                                    </div>
                                </div>

                                <div class="md-col-3 col-3  mt-3">
                                    <div class="form-item">
                                        <input type="text" name="new_transmission_capacity_1"
                                            id="new_transmission_capacity" class="form-control form-control-sm"
                                            value="">
                                        <label for="type">New Transmission Capacity</label>
                                    </div>
                                </div>

                                <div class="md-col-3 col-3  mt-3">
                                    <div class="form-item">
                                        <input type="text" name="link_remarks_1" id="link_remarks"
                                            class="form-control form-control-sm" value="">
                                        <label for="type">Remarks</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <hr />
                                    <h5 class="text-center">Survey Information</h5>
                                    <hr />
                                    <table class="table custom_table table-bordered surveyTable" style="font-size: 12px;">
                                        <tr>
                                            <th>Link Vendor</th>
                                            <td class="link_vendor" style="width:30%">
                                                <input type="text" name="link_vendor_1" id="link_vendor"
                                                    class="form-control form-control-sm link_vendor_1" value=""
                                                    style="height: 25px !important">
                                                <input type="hidden" name="link_vender_id_1" id="link_vendor_id"
                                                    class="form-control form-control-sm link_vender_id_1" value="">
                                            </td>
                                            <th>Connecting POP Running Vendor</th>
                                            <td class="running_vendor_pop" style="width:30%"></td>
                                        </tr>
                                        <tr>
                                            <th>Link Availability Status</th>
                                            <td class="availability_status" style="width:30%">
                                                <input type="text" name="availability_status_1"
                                                    id="availability_status"
                                                    class="form-control form-control-sm availability_status_1"
                                                    style="height: 25px !important" value="">
                                            </td>
                                            <th>Connecting POP Running Vendor Capacity</th>
                                            <td class="running_vendor_capacity" style="width:30%"></td>
                                        </tr>
                                        <tr>
                                            <th>Link Connectivity POP</th>
                                            <td class="link_connecting_pop" style="width:30%">
                                                <input type="text" name="link_connecting_pop_1"
                                                    id="link_connecting_pop"
                                                    class="form-control form-control-sm link_connecting_pop_1"
                                                    style="height: 25px !important" value="">
                                                <input type="hidden" name="link_connecting_pop_id_1"
                                                    id="link_connecting_pop_id" class="link_connecting_pop_id_1">
                                            </td>
                                            <th>Zone Area Running NTTN Vendor</th>
                                            <td class="nttn_vendor_zone" style="width:30%"></td>
                                        </tr>
                                        <tr>
                                            <th>Last Mile Connectivity Method</th>
                                            <td class="last_mile_connectivity_method" style="width:30%">
                                                <input type="text" name="last_mile_connectivity_method_1"
                                                    id="last_mile_connectivity_method"
                                                    class="form-control form-control-sm last_mile_connectivity_method_1"
                                                    style="height: 25px !important" value="">
                                            </td>
                                            <th>Zone Area Running NTTN BW</th>
                                            <td class="running_nttn_bw" style="width:30%"></td>
                                        </tr>
                                        <tr>
                                            <th>Last Connectivity Point Latitute</th>
                                            <td class="connectivity_lat_long" style="width:30%">
                                                <input type="text" name="connectivity_lat_1"
                                                    id="connectivity_lat_long"
                                                    class="form-control form-control-sm connectivity_lat_1"
                                                    style="height: 25px !important" value="">
                                            </td>
                                            <th>Connectivity Route</th>
                                            <td class="connectivity_route" style="width:30%"></td>
                                        </tr>
                                        <tr>
                                            <th>Last Connectivity Point Longitute</th>
                                            <td class="connectivity_lat_long" style="width:30%">
                                                <input type="text" name="connectivity_long_1"
                                                    id="connectivity_lat_long"
                                                    class="form-control form-control-sm connectivity_long_1"
                                                    style="height: 25px !important" value="">
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
                                                <th>
                                                    <button type="button"
                                                        class="btn btn-success btn-sm addLinkEquipmentRow"
                                                        onclick="addLinkEquipmentRow(this)">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="link_equipment_table">
                                            <tr>
                                                <td>
                                                    <select name="material_id_1[]" id="material_id"
                                                        class="form-control form-control-sm link_material_id">
                                                        <option value="">Select Equipment</option>
                                                        @foreach ($materials as $material)
                                                            <option value="{{ $material->id }}">
                                                                {{ $material->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="quantity_1[]" id="quantity"
                                                        class="form-control form-control-sm link_quantity" value="">
                                                </td>
                                                <td>
                                                    <input type="text" name="unit_1[]" id="unit"
                                                        class="form-control form-control-sm link_unit" value="">
                                                </td>
                                                <td>
                                                    <select name="brand_id_1[]" id="brand"
                                                        class="form-control form-control-sm link_brand">
                                                        <option value="">Select Brand</option>
                                                        @foreach ($brands as $brand)
                                                            <option value="{{ $brand->id }}">
                                                                {{ $brand->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="model_1[]" id="model"
                                                        class="form-control form-control-sm link_model" value="">
                                                </td>
                                                <td>
                                                    <input type="text" name="description_1[]" id="description"
                                                        class="form-control form-control-sm link_description"
                                                        value="">
                                                </td>
                                                <td>
                                                    <input type="text" name="remarks_1[]" id="remarks"
                                                        class="form-control form-control-sm link_remarks" value="">
                                                </td>
                                                <td>
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm removeLinkEquipmentRow"
                                                        onclick="removeLinkEquipmentRow(this)">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <hr />
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="client_no" name="client_no" value="{{ $client_no }}">
                    <input type="hidden" id="fr_no" name="fr_no" value="{{ $fr_no }}">
                </div>
                <button class="py-2 btn btn-success float-right">Save</button>
            </div>
        </div>
        {!! Form::close() !!}

    @endsection

    @section('script')
        <script>
            let plan_equipment_html = '';
            $('#addEquipmentRow').on('click', function() {
                addEquipmentRow();
            });

            function addEquipmentRow() {
                let check_first_row = $('.equipment_row').first();
                if (check_first_row.length !== 0) {
                    console.log('not empty');
                    $('.equipment_row').first().clone().appendTo('#equipment_body');
                    $('.equipment_row').last().find('input').val('');
                    $('.equipment_row').last().find('select').val('');
                } else {
                    console.log('empty');
                    console.log(plan_equipment_html);
                    $('#equipment_body').append('<tr>' + plan_equipment_html + '</tr>');
                }
                // $('.equipment_row').first().clone().appendTo('#equipment_body');
                // $('.equipment_row').last().find('input').val('');
                // $('.equipment_row').last().find('select').val('');
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
                let option = $(event.target).val();
                var link_type = $(event.target).closest('.main_link').find('.link_type').val();
                let client_id = $('#client_no').val();
                let fr_no = $('#fr_no').val();
                $.ajax({
                    url: "{{ route('get-modify-survey-details') }}",
                    data: {
                        option: option,
                        link_type: link_type,
                        client_id: client_id,
                        fr_no: fr_no,
                    },
                    success: function(data) {
                        console.log(data);
                        $(event.target).closest('.main_link').find('input[name^="link_vendor_"]').val(data?.vendor
                            ?.name);
                        $(event.target).closest('.main_link').find('input[name^="link_vender_id_"]').val(data
                            ?.vendor
                            ?.id);
                        $(event.target).closest('.main_link').find('input[name^="availability_status_"]').val(data
                            .status);
                        $(event.target).closest('.main_link').find('input[name^="link_connecting_pop_"]').val(data
                            .pop.name);
                        $(event.target).closest('.main_link').find('input[name^="link_connecting_pop_id_"]').val(
                            data.pop
                            .id);
                        $(event.target).closest('.main_link').find('input[name^="last_mile_connectivity_method_"]')
                            .val(data
                                .method);
                        $(event.target).closest('.main_link').find('input[name^="connectivity_long_"]').val(data
                            .long);
                        $(event.target).closest('.main_link').find('input[name^="connectivity_lat_"]').val(data
                            .lat);
                        $(event.target).closest('.main_link').find('input[name^="distance_"]').val(data.distance);
                        $(event.target).closest('.main_link').find('input[name^="gps_"]').val(data.gps);
                        $(event.target).closest('.main_link').find('input[name^="connectivity_point_"]').val(data
                            .bts_pop_ldp)
                        // $(event.target).closest('.main_link').find('.link_vendor').html(data.vendor);
                        // $(event.target).closest('.main_link').find('.availability_status').html(data.status);
                        // $(event.target).closest('.main_link').find('.link_connecting_pop').html(data.bts_pop_ldp);
                        // $(event.target).closest('.main_link').find('.last_mile_connectivity_method').html(data
                        //     .method);
                        // $(event.target).closest('.main_link').find('.connectivity_lat_long').html(data.gps);
                        // $(event.target).closest('.main_link').find('.distance').val(data.distance);
                        // $(event.target).closest('.main_link').find('.gps').val(data.gps);
                        // $(event.target).closest('.main_link').find('.connectivity_point').val(data.bts_pop_ldp)
                    }
                });
            }

            function addLinkEquipmentRow(event) {
                var $table = $(event).closest('.table-bordered');
                var $clone = $table.find('tbody tr:first').clone();
                $clone.find('input').val('');
                $clone.find('select').val('');
                $table.find('tbody').append($clone);
            }

            function removeLinkEquipmentRow(event) {
                var $table = $(event).closest('.table-bordered');
                var $tr = $table.find('tbody tr');
                if ($tr.length > 1) {
                    $(event).closest('tr').remove();
                }
            }
            $('#addLinkRow').on('click', function() {
                addLinkRow();
            });

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
                clonedRow.find('#addLinkEquipmentRow').attr('id', 'addLinkEquipmentRow_' + link_no);
                clonedRow.find('#removeLinkEquipmentRow').attr('id', 'removeLinkEquipmentRow_' + link_no);
                clonedRow.find('.link_no').html(link_no);
                clonedRow.appendTo('#link_container');
                var $equipmentRow = clonedRow.find('.link_equipment_table').children('tr').length;
                console.log($equipmentRow);
                if ($equipmentRow > 1) {
                    clonedRow.find('.link_equipment_table tr').not(':first').remove();
                }
            }

            function removeLinkRow(event) {
                var count = $('.main_link').length;
                if (count > 1) {
                    $(event).closest('.main_link').remove();
                }
            }

            $(document).on('change', '.equipment_id', function() {
                var equipment_id = $(this).val();
                var equiments = {!! json_encode($materials) !!};
                var find_equipment = equiments.find(x => x.id == equipment_id);
                console.log(find_equipment);
                $(this).closest('tr').find('.unit').val(find_equipment.unit);
            });

            $(document).on('change', '.link_material_id', function() {
                var material_id = $(this).val();
                var materials = {!! json_encode($materials) !!};
                var find_material = materials.find(x => x.id == material_id);
                $(this).closest('tr').find('.link_unit').val(find_material.unit);
            });

            let link_array = [];

            $('.existing_infrastructure').on('change', function() {
                var this_event = $(this);
                var value = this_event.val();
                let pop_id = this_event.closest('.main_link').find('input[name^="link_connecting_pop_id_"]').val();

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
                        }
                    });
                } else {
                    this_event.closest('.main_link').find('.link_list').css('display', 'none');
                }
            });

            $('.existing_infrastructure_link').on('change', function() {
                console.log(link_array);
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
                console.log('latestLink', latestLink);
                this_event.closest('.main_link').find('.existing_transmission_capacity').val(latestLink.capacity).attr(
                    'value', latestLink.capacity);
            });
        </script>
    @endsection
