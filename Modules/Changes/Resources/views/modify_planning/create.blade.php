@extends('layouts.backend-layout')
@section('title', 'Planning')

@php
    $form_heading = $type == 'create' ? 'Add' : 'Update';
    $form_url = $type == 'create' ? route('client-plan-modification.store') : route('client-plan-modification.update', $id);
    $form_method = $type == 'create' ? 'POST' : 'PUT';
@endphp
@section('style')
    <style>
        .main_link {
            border: 2px solid gray;
            border-radius: 15px;
            padding: 8px;
            margin-top: 10px;
        }

        .surveyTable th,
        .client_information th {
            background-color: #e7e7dc !important;
            color: black !important;
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

                                <tbody>
                                    <tr>
                                        <th class="table_label"> Client Name </th>
                                        <td> {{ $client_name }} </td>
                                        <th class="table_label">Connectivity Point</th>
                                        <td>{{ $connectivity_point }}</td>
                                        <th class="table_label">Division</th>
                                        <td>{{ $client_division }}</td>
                                    </tr>
                                    <tr>
                                        <th class="table_label">Contact Person</th>
                                        <td>{{ $client_contact_person }}</td>
                                        <th class="table_label">Lat-Long</th>
                                        <td>{{ $client_lat }} - {{ $client_long }} </td>
                                        <th class="table_label">District</th>
                                        <td>{{ $client_district }}</td>
                                    </tr>
                                    <tr>
                                        <th class="table_label">Contact No</th>
                                        <td>{{ $client_contact_no }}</td>
                                        <th class="table_label">Branch</th>
                                        <td>{{ $branch }}</td>
                                        <th class="table_label">Thana</th>
                                        <td>{{ $client_thana }}</td>
                                    </tr>
                                    <tr>
                                        <th class="table_label">Email</th>
                                        <td>{{ $client_email }}</td>
                                        <th class="table_label">Address</th>
                                        <td> {{ $client_address }}</td>
                                        <th class="table_label">Document</th>
                                        <td>
                                            {{-- @if ($plan->lead_generation->document)
                                            <a href="{{ asset('uploads/lead_generation/' . $plan->lead_generation->document) }}"
                                                target="_blank" class="btn btn-sm btn-warning" style="font-size:14px;"><i
                                                    class="fas fa-eye"></i></a>
                                        @endif --}}
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
                                </tbody>
                            </table>
                            <input type="hidden" id="connectivity_requirement_id" name="connectivity_requirement_id"
                                value="{{ $connectivity_requirement_id }}">
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
                                    <input type="checkbox" name="change_type[]" value="Redundant Link"
                                        id="redundant_link" @if (in_array('Redundant Link', $change_type)) checked @endif>
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
                                            <th colspan="6">Service Plan for </th>
                                        </tr>
                                        <tr>
                                            <th>Particulars</th>
                                            <th>Existing Capacity</th>
                                            <th>Client Req.</th>
                                            <th>Plan</th>
                                            <th>Remarks</th>
                                            <th>

                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="particular_body">
                                        @foreach ($product_details as $product_detail)
                                            <tr>
                                                <input type="hidden" name="service_plan_id[]"
                                                    value="{{ $product_detail['id'] ?? '' }}">
                                                <td>
                                                    <input type="hidden" name="detail_id[]"
                                                        class="form-control form-control-sm"
                                                        value="{{ $product_detail['connectivity_product_requirement_details_id'] ?? '' }}">
                                                    <span
                                                        class="form-control form-control-sm">{{ $product_detail['product_name'] ?? '' }}</span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="form-control form-control-sm">{{ $product_detail['prev_quantity'] ?? '' }}</span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="form-control form-control-sm">{{ $product_detail['capacity'] ?? '' }}</span>
                                                </td>
                                                <td>
                                                    <input type="text" name="plan[]"
                                                        class="form-control form-control-sm"
                                                        value="{{ $product_detail['plan'] ?? '' }}">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control"
                                                        value="{{ $product_detail['remarks'] ?? '' }}" />
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
                        <div class="md-col-5 col-5">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th colspan="7">Existing Equipment Plan</th>
                                        </tr>
                                        <tr>
                                            <th>Equipment Name</th>
                                            <th>Quantity</th>
                                            <th>Unit</th>
                                            <th>Brand</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($previous_products))
                                            @foreach ($previous_products->lines as $previous_product)
                                                <tr>
                                                    <td>
                                                        <input type="readonly" name="equipment_name[]"
                                                            class="form-control form-control-sm"
                                                            value="{{ $previous_product->material->name ?? '' }}">
                                                    </td>
                                                    <td>
                                                        <input type="readonly" class="form-control form-control-sm"
                                                            value="{{ $previous_product->quantity ?? '' }}">
                                                    </td>
                                                    <td>
                                                        <input type="readonly" class="form-control form-control-sm unit"
                                                            value="{{ $previous_product->material->unit ?? '' }}">
                                                    </td>
                                                    <td>
                                                        <input type="readonly" class="form-control form-control-sm brand"
                                                            value="{{ $previous_product->brand->name ?? '' }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="equipment_remarks[]"
                                                            class="form-control form-control-sm equipment_remarks"
                                                            value="{{ $previous_product->remarks ?? '' }}">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="md-col-7 col-7" id='EquipmentPlan'>
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
                                    <tbody class="equipment_body">
                                        @if (!empty($equipment_plans))
                                            @foreach ($equipment_plans as $equipment_plan)
                                                <tr class="equipment_row">
                                                    <input type="hidden" name="equipment_plan_id[]"
                                                        value="{{ $equipment_plan->id ?? '' }}">
                                                    <td>
                                                        <select name="equipment_id[]"
                                                            class="form-control form-control-sm equipment_id select2">
                                                            <option value="">Select Equipment</option>
                                                            @foreach ($materials as $material)
                                                                <option value="{{ $material->id }}"
                                                                    {{ $equipment_plan->material_id == $material->id ? 'selected' : '' }}>
                                                                    {{ $material->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="quantity[]"
                                                            class="form-control form-control-sm"
                                                            value="{{ $equipment_plan->quantity ?? '' }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="unit[]"
                                                            class="form-control form-control-sm unit"
                                                            value="{{ $equipment_plan->unit ?? '' }}">
                                                    </td>
                                                    <td>
                                                        <select name="brand_id[]"
                                                            class="form-control form-control-sm brand_id select2">
                                                            <option value="">Select Brand</option>
                                                            @foreach ($brands as $brand)
                                                                <option value="{{ $brand->id }}"
                                                                    {{ $equipment_plan->brand_id == $brand->id ? 'selected' : '' }}>
                                                                    {{ $brand->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="model[]"
                                                            class="form-control form-control-sm model"
                                                            value="{{ $equipment_plan->model ?? '' }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="equipment_remarks[]"
                                                            class="form-control form-control-sm equipment_remarks"
                                                            value="{{ $equipment_plan->remarks ?? '' }}">
                                                    </td>
                                                    <td>
                                                        <button type="button"
                                                            class="btn btn-sm btn-danger removeEquipmentRow"><i
                                                                class="fas fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class="table-responsive">
                        <div class="tableHeading">
                            <h5> <span> &#10070; </span> Existing Connection <span>&#10070;</span> </h5>
                        </div>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <th>Link Type</th>
                                <th>Method</th>
                                <th>Vendor</th>
                                <th>BTS/POP/LDP</th>
                                <th>Current Capacity</th>
                                <th>View Link Equipment</th>
                            </thead>
                            <tbody class="existingBody">
                                @foreach ($existingConnections as $key => $value)
                                    <tr class="product_existing_row">
                                        <td>
                                            <div class="input-group input-group-sm input-group-primary">
                                                <input type="text" name="existing_link_type[]"
                                                    class="form-control text-center existing_link_type" readonly
                                                    value="{{ $value->link_type }}">
                                                <input type="hidden" name="existing_bbts_link_id[]"
                                                    class="form-control text-center existing_bbts_link_id" readonly
                                                    value="{{ $value->bbts_link_id }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm input-group-primary">
                                                <input type="text" name="existing_method[]"
                                                    class="form-control text-right existing_method" readonly
                                                    value="{{ $value->method }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm input-group-primary">
                                                <input type="text" name="existing_vendor_name[]"
                                                    class="form-control text-center existing_vendor_name" readonly
                                                    value="{{ $value?->connectivityLink?->vendor?->name }}">
                                                <input type="hidden" name="existing_vendor_id[]"
                                                    class="form-control text-center existing_vendor_id"
                                                    value="{{ $value?->connectivityLink?->vendorid }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm input-group-primary">
                                                <input type="text" name="existing_method[]"
                                                    class="form-control text-right existing_method" readonly
                                                    value="{{ $value->method }}">
                                                <input type="hidden" name="existing_bbts_link_id[]"
                                                    class="form-control existing_bbts_link_id" readonly
                                                    value="{{ $value->bbts_link_id }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm input-group-primary">
                                                <input type="text" name="existing_current_capacity[]"
                                                    class="form-control text-center existing_current_capacity" readonly
                                                    value="{{ $value->physicalConnectivity->planning->finalSurveyDetail->current_capacity ?? 0 }}">
                                            </div>
                                        </td>

                                        <td>
                                            <button type="button" class="btn btn-sm btn-success existingLinkEquipment"
                                                data-toggle="modal"
                                                data-target="#existingLinkEquipmentModal{{ $value->id }}"><i
                                                    class="fas fa-eye"></i></button>
                                            {{-- Link Equipment Product list --}}
                                            <div class="modal fade bd-example-modal-lg"
                                                id="existingLinkEquipmentModal{{ $value->id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-primary">
                                                            <h5 class="modal-title text-white" id="myLargeModalLabel">
                                                                Link Equipment List</h5>
                                                            <button type="button" class="close text-white"
                                                                data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body" id="existingLinkEquipmentBody">
                                                            <table class="table table-bordered table-striped">
                                                                <thead>
                                                                    <th>Equipment</th>
                                                                    <th>Quantity</th>
                                                                    <th>Unit</th>
                                                                    <th>Brand</th>
                                                                    <th>Model</th>
                                                                    <th>Remarks</th>
                                                                </thead>
                                                                <tbody id="link_product_list">
                                                                    @if (!empty($value->scmMur->lines))
                                                                        @foreach ($value->scmMur->lines as $existing_product)
                                                                            <tr>
                                                                                <td>
                                                                                    <input type="text"
                                                                                        name="existing_product[]"
                                                                                        class="form-control form-control-sm existing_product"
                                                                                        value="{{ $existing_product->material->name ?? '' }}"
                                                                                        readonly>
                                                                                </td>
                                                                                <td>
                                                                                    <input type="text"
                                                                                        name="existing_product_quantity[]"
                                                                                        id="existing_product_quantity"
                                                                                        class="form-control form-control-sm existing_product_quantity"
                                                                                        value="{{ $existing_product->quantity ?? '' }}"
                                                                                        readonly>
                                                                                </td>
                                                                                <td>
                                                                                    <input type="text"
                                                                                        name="existing_product_unit[]"
                                                                                        id="existing_product_unit"
                                                                                        class="form-control form-control-sm existing_product_unit"
                                                                                        value="{{ $existing_product->unit ?? '' }}"
                                                                                        readonly>
                                                                                </td>
                                                                                <td>
                                                                                    <input type="text"
                                                                                        name="existing_product_brand[]"
                                                                                        id="existing_product_brand"
                                                                                        class="form-control form-control-sm existing_product_brand"
                                                                                        value="{{ $existing_product->brand->name ?? '' }}"
                                                                                        readonly>
                                                                                </td>
                                                                                <td>
                                                                                    <input type="text"
                                                                                        name="existing_product_model[]"
                                                                                        id="existing_product_model"
                                                                                        class="form-control form-control-sm existing_product_model"
                                                                                        value="{{ $existing_product->model ?? '' }}"
                                                                                        readonly>
                                                                                </td>
                                                                                <td>
                                                                                    <input type="text"
                                                                                        name="existing_product_remarks[]"
                                                                                        id="existing_product_remarks"
                                                                                        class="form-control form-control-sm existing_product_remarks"
                                                                                        value="{{ $existing_product->remarks ?? '' }}"
                                                                                        readonly>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- Link Equipment Product list --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <hr />
                    <div class="row">
                        <input type="hidden" id="client_id" name="client_id" value="">
                        <input type="hidden" name="total_key" id="total_key" value="1">
                        <div class="col-md-11 text-center">
                            <h5> <span> &#10070; </span> Link Information <span>&#10070;</span> </h5>
                        </div>
                    </div>
                    <hr />
                    <div id="link_container">
                        @if ($plan_links)
                            <input type="hidden" name="total_key" id="total_key" value="{{ $plan_links->count() }}">
                            @foreach ($plan_links as $key => $plan_link)
                                <div class="main_link">
                                    @php $total_key = $key + 1; @endphp

                                    <input type="hidden" name="plan_link_id_{{ $total_key }}"
                                        value="{{ $plan_link->id ?? '' }}">
                                    <input type="hidden" name="plan_link_no_{{ $total_key }}"
                                        value="{{ $plan_link->link_no ?? '' }}">
                                    <input type="hidden" name="final_survey_id_{{ $total_key }}"
                                        value="{{ $plan_link->finalSurveyDetails->id ?? '' }}">
                                    <div class="row">
                                        <div class="col-md-11 col-11">
                                            <h5 class="text-center mb-2">Link <span
                                                    class="link_no">{{ $total_key }}</span></h5>
                                        </div>
                                        <div class="col-md-1 col-1">
                                            <nobr>
                                                <button type="button" class="btn btn-sm btn-outline-success addLinkRow"
                                                    style="padding: 5px 10px">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                                <button type="button"
                                                    class="btn btn-sm btn-danger text-left removeLinkRow"
                                                    style="padding: 5px 10px" onclick="removeLinkRow(this)"><i
                                                        class="fas fa-trash"></i></button>
                                            </nobr>
                                        </div>
                                        <hr / style="width: 100%; margin-bottom: 10px;">
                                        <div class="md-col-3 col-3">
                                            <div class="form-item">
                                                <select name="link_type_{{ $total_key }}"
                                                    class="form-control form-control-sm select2 link_type">
                                                    <option value="">Select Type</option>
                                                    <option value="Primary"
                                                        {{ $plan_link->link_type == 'Primary' ? 'selected' : '' }}>Primary
                                                    </option>
                                                    <option value="Secondary"
                                                        {{ $plan_link->link_type == 'Secondary' ? 'selected' : '' }}>
                                                        Secondary</option>
                                                    <option value="Tertiary"
                                                        {{ $plan_link->link_type == 'Tertiary' ? 'selected' : '' }}>
                                                        Tertiary</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="md-col-3 col-3">
                                            <div class="form-item">
                                                <select name="option_{{ $total_key }}"
                                                    class="form-control form-control-sm option select2"
                                                    onchange="optionChange(event)">
                                                    <option value="">Select Option</option>
                                                    <option value="Option 1"
                                                        {{ $plan_link->option == 'Option 1' ? 'selected' : '' }}>
                                                        Option 1</option>
                                                    <option value="Option 2"
                                                        {{ $plan_link->option == 'Option 2' ? 'selected' : '' }}>
                                                        Option 2</option>
                                                    <option value="Option 3"
                                                        {{ $plan_link->option == 'Option 3' ? 'selected' : '' }}>
                                                        Option 3</option>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-3 col-md-3">
                                            <div class="form-item">
                                                <select name="existing_infrastructure_{{ $total_key }}"
                                                    class="form-control form-control-sm existing_infrastructure select2">
                                                    <option value="">Select Status</option>
                                                    <option value="Existing"
                                                        {{ $plan_link->existing_infrastructure == 'Existing' ? 'selected' : '' }}>
                                                        Existing</option>
                                                    <option value="New"
                                                        {{ $plan_link->existing_infrastructure == 'New' ? 'selected' : '' }}>
                                                        New</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-3 col-md-3 link_list" style="display: none;">
                                            <div class="form-item">
                                                <select name="existing_infrastructure_link_1"
                                                    class="form-control form-control-sm existing_infrastructure_link select2">
                                                    <option value="">Select Link</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="md-col-3 col-3">
                                            <div class="form-item">
                                                <input type="text"
                                                    name="existing_transmission_capacity_{{ $total_key }}"
                                                    class="form-control form-control-sm existing_transmission_capacity"
                                                    value="{{ $plan_link->existing_transmission_capacity ?? '' }}">
                                                <label for="type">Existing T. Capacity</label>
                                            </div>
                                        </div>

                                        <div class="md-col-3 col-3 mt-3">
                                            <div class="form-item">
                                                <input type="text" name="increase_capacity_{{ $total_key }}"
                                                    class="form-control form-control-sm increase_capacity"
                                                    value="{{ $plan_link->increase_capacity ?? '' }}">
                                                <label for="type">Increase Capacity</label>
                                            </div>
                                        </div>

                                        {{-- <div class="md-col-3 col-3  mt-3">
                                            <div class="form-item">
                                                <select name="link_availability_status_{{ $total_key }}"
                                                    id="link_availability_status"
                                                    class="form-control form-control-sm link_availability_status select2">
                                                    <option value="">Select Vendor</option>
                                                    @foreach ($vendors as $vendor)
                                                        <option value="{{ $vendor->id }}"
                                                            {{ $plan_link->link_availability_status == $vendor->id ? 'selected' : '' }}>
                                                            {{ $vendor->name }}</option>
                                                    @endforeach
                                                </select>
                                                <label for="type">New Transmission Link</label>
                                            </div>
                                        </div> --}}

                                        <div class="md-col-3 col-3  mt-3 new_transmission_capacity_div">
                                            <div class="form-item">
                                                <input type="text"
                                                    name="new_transmission_capacity_{{ $total_key }}"
                                                    class="form-control form-control-sm"
                                                    value="{{ $plan_link->new_transmission_capacity ?? '' }}">
                                                <label for="type">New Transmission Capacity</label>
                                            </div>
                                        </div>
                                        {{-- 
                                        <div class="md-col-3 col-3  mt-3">
                                            <div class="form-item">
                                                <input type="text" name="link_remarks_{{ $total_key }}"
                                                    id="link_remarks" class="form-control form-control-sm"
                                                    value="{{ $plan_link->link_remarks ?? '' }}">
                                                <label for="type">Remarks</label>
                                            </div>
                                        </div> --}}
                                    </div>
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <hr />
                                            <h5 class="text-center">Survey Information</h5>
                                            <hr />
                                            <table class="table custom_table table-bordered surveyTable"
                                                style="font-size: 12px;">
                                                <tr>
                                                    <th>Vendor</th>
                                                    <td class="link_vendor" style="width:30%">
                                                        <select name="link_vendor_id_{{ $total_key }}"
                                                            class="form-control form-control-sm link_vendor_id_1 select2">
                                                            <option value="">Select Vendor</option>
                                                            @foreach ($vendors as $vendor)
                                                                <option value="{{ $vendor->id }}"
                                                                    @if ($plan_link->finalSurveyDetails->vendor_id == $vendor->id) selected @endif>
                                                                    {{ $vendor->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <th>POP Vendor</th>
                                                    <td class="running_vendor_pop" style="width:30%"></td>
                                                </tr>
                                                <tr>
                                                    <th>Pop</th>
                                                    <td class="link_connecting_pop" style="width:40%">
                                                        <select name="link_connecting_pop_id_{{ $total_key }}"
                                                            class="form-control form-control-sm link_connecting_pop_id_1 select2">
                                                            <option value="">Select POP</option>
                                                            @foreach ($pops as $pop)
                                                                <option value="{{ $pop->id }}"
                                                                    @if ($plan_link->finalSurveyDetails->pop_id == $pop->id) selected @endif>
                                                                    {{ $pop->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <th>POP Capacity</th>
                                                    <td class="running_vendor_capacity" style="width:30%"></td>
                                                </tr>
                                                <tr>
                                                    <th>Method</th>
                                                    <td class="last_mile_connectivity_method" style="width:40%">
                                                        <input type="text"
                                                            name="last_mile_connectivity_method_{{ $total_key }}"
                                                            class="form-control form-control-sm last_mile_connectivity_method_1"
                                                            style="height: 25px !important"
                                                            value="{{ $plan_link->finalSurveyDetails->method }}" readonly>
                                                    </td>
                                                    <th>Zone Vendor</th>
                                                    <td class="nttn_vendor_zone" style="width:30%"></td>
                                                </tr>
                                                <tr>
                                                    <th>Latitute</th>
                                                    <td class="connectivity_lat_long" style="width:40%">
                                                        <input type="text" name="connectivity_lat_{{ $total_key }}"
                                                            class="form-control form-control-sm connectivity_lat_1"
                                                            style="height: 25px !important"
                                                            value="{{ $plan_link->finalSurveyDetails->lat }}" readonly>
                                                    </td>
                                                    <th>Zone Capacity</th>
                                                    <td class="running_nttn_bw" style="width:30%"></td>
                                                </tr>
                                                <tr>
                                                    <th>Longitute</th>
                                                    <td class="connectivity_lat_long" style="width:40%">
                                                        <input type="text"
                                                            name="connectivity_long_{{ $total_key }}"
                                                            class="form-control form-control-sm connectivity_long_1"
                                                            style="height: 25px !important"
                                                            value="{{ $plan_link->finalSurveyDetails->long }}" readonly>
                                                    </td>
                                                    <th>Connectivity Route</th>
                                                    <td class="connectivity_route" style="width:30%"></td>
                                                </tr>
                                                <tr>
                                                    <th>Distance</th>
                                                    <td class="connectivity_lat_long" style="width:40%">
                                                        <input type="text" name="distance_{{ $total_key }}"
                                                            class="form-control form-control-sm distance_1"
                                                            style="height: 25px !important"
                                                            value="{{ $plan_link->finalSurveyDetails->distance }}"
                                                            readonly>
                                                    </td>
                                                    <th>Remarks</th>
                                                    <td>
                                                        <input type="text" name="link_remarks_{{ $total_key }}"
                                                            style="height: 25px !important" id="link_remarks"
                                                            class="form-control form-control-sm"
                                                            value="{{ $plan_link->link_remarks ?? '' }}">
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
                                                    @foreach ($plan_link->PlanLinkEquipments as $plan_equipment)
                                                        <tr>
                                                            <input type="hidden"
                                                                name="plan_link_equipment_id_{{ $total_key }}[]"
                                                                value="{{ $plan_equipment->id ?? '' }}">
                                                            <td>
                                                                <select name="material_id_{{ $total_key }}[]"
                                                                    class="form-control form-control-sm link_material_id select2">
                                                                    <option value="">Select Equipment</option>
                                                                    @foreach ($materials as $material)
                                                                        <option value="{{ $material->id }}"
                                                                            {{ $plan_equipment->material_id == $material->id ? 'selected' : '' }}>
                                                                            {{ $material->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>

                                                            <td>
                                                                <input type="text"
                                                                    name="quantity_{{ $total_key }}[]"
                                                                    class="form-control form-control-sm link_quantity"
                                                                    value="{{ $plan_equipment->quantity ?? '' }}">
                                                            </td>
                                                            <td>
                                                                <input type="text" name="unit_{{ $total_key }}[]"
                                                                    class="form-control form-control-sm link_unit"
                                                                    value="{{ $plan_equipment->unit ?? '' }}">
                                                            </td>
                                                            <td>
                                                                <select name="brand_id_{{ $total_key }}[]"
                                                                    class="form-control form-control-sm link_brand select2">
                                                                    <option value="">Select Brand</option>
                                                                    @foreach ($brands as $brand)
                                                                        <option value="{{ $brand->id }}"
                                                                            {{ $plan_equipment->brand_id == $brand->id ? 'selected' : '' }}>
                                                                            {{ $brand->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text" name="model_{{ $total_key }}[]"
                                                                    class="form-control form-control-sm link_model"
                                                                    value="{{ $plan_equipment->model ?? '' }}">
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                    name="description_{{ $total_key }}[]"
                                                                    class="form-control form-control-sm link_description"
                                                                    value="{{ $plan_equipment->description ?? '' }}">
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                    name="remarks_{{ $total_key }}[]"
                                                                    class="form-control form-control-sm link_remarks"
                                                                    value="{{ $plan_equipment->remarks ?? '' }}">
                                                            </td>
                                                            <td>
                                                                <button type="button"
                                                                    class="btn btn-danger btn-sm removeLinkEquipmentRow"
                                                                    onclick="removeLinkEquipmentRow(this)">
                                                                    <i class="fas fa-minus"></i>
                                                                </button>
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
                        @endif
                    </div>
                    <input type="hidden" id="client_no" name="client_no" value="{{ $client_no }}">
                    <input type="hidden" id="fr_no" name="fr_no" value="{{ $fr_no }}">
                    <input type="hidden" id="delete_plan_link_id" name="delete_plan_link_id" value="">
                    <input type="hidden" id="delete_equipment_plan_id" name="delete_equipment_plan_id" value="">
                    <input type="hidden" id="delete_link_equipment_id" name="delete_link_equipment_id" value="">
                </div>
                <button class="py-2 btn btn-success float-right">Save</button>
            </div>
        </div>
        {!! Form::close() !!}

    @endsection

    @section('script')

        <script>
            $(document).ready(function() {
                $('.select2').select2();
            })
            let plan_equipment_html = `<tr class="equipment_row">
                                        <td>
                                            <select name="equipment_id[]"
                                                class="form-control form-control-sm equipment_id select2">
                                                <option value="">Select Equipment</option>
                                                @foreach ($materials as $material)
                                                    <option value="{{ $material->id }}">
                                                        {{ $material->name }}</option>
                                                @endforeach
                                            </select>
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
                                            <select name="brand_id[]"
                                                class="form-control form-control-sm brand_id select2">
                                                <option value="">Select Brand</option>
                                                @foreach ($brands as $brand)
                                                    <option value="{{ $brand->id }}">
                                                        {{ $brand->name }}</option>
                                                @endforeach
                                            </select>
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
                                                    <button type="button" class="btn btn-sm btn-danger removeEquipmentRow" style="padding: 5px 10px"><i
                                                            class="fas fa-trash"></i></button>
                                                </td>
                                            </tr> `;
            $('#addEquipmentRow').on('click', function() {
                addEquipmentRow();
                $('.select2').select2();
            });

            function addEquipmentRow() {
                let check_first_row = $('.equipment_row').length;
                if (check_first_row !== 0) {
                    let row = $('.equipment_row').first().clone();
                    row.find('input').val('');
                    row.find('span').remove();
                    row.appendTo('.equipment_body');
                } else {
                    $('.equipment_body').append('<tr>' + plan_equipment_html + '</tr>');
                }
            };


            let delete_equipment_id = [];
            $(document).on('click', '.removeEquipmentRow', function(e) {
                e.preventDefault();
                var equipment_plan_id = $(this).closest('tr').find('input[name^="equipment_plan_id"]').val();
                if (equipment_plan_id) {
                    delete_equipment_id.push(equipment_plan_id);
                    let delete_equipment_id_json = JSON.stringify(delete_equipment_id);
                    $('#delete_equipment_plan_id').val(delete_equipment_id_json);
                }
                $(this).closest('tr').remove();
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
                        url: "{{ route('get-modify-survey-details') }}",
                        data: {
                            option: option,
                            link_type: link_type,
                            client_id: client_id,
                            fr_no: fr_no,
                            connectivity_requirement_id: $('#connectivity_requirement_id').val(),
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
                                .status);
                            $(event.target).closest('.main_link').find('select[name^="link_connecting_pop_id_"]')
                                .val(
                                    data?.pop?.id).trigger('change');
                            $(event.target).closest('.main_link').find(
                                    'input[name^="last_mile_connectivity_method_"]')
                                .val(data
                                    .method);
                            $(event.target).closest('.main_link').find('input[name^="connectivity_long_"]').val(data
                                .long);
                            $(event.target).closest('.main_link').find('input[name^="connectivity_lat_"]').val(data
                                .lat);
                            $(event.target).closest('.main_link').find('input[name^="distance_"]').val(data
                                .distance);
                            $(event.target).closest('.main_link').find('input[name^="gps_"]').val(data.gps);
                            $(event.target).closest('.main_link').find('input[name^="connectivity_point_"]').val(
                                data
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
                $clone.find('select').val('');
                $table.find('tbody').append($clone);
                $(".select2").select2();
            }

            let delete_link_equipment_id = [];

            function removeLinkEquipmentRow(event) {
                var plan_link_id = $(event).closest('.main_link').find('input[name^="plan_link_id_"]').val();
                var link_equipment_id = $(event).closest('tr').find('input[name^="plan_link_equipment_id_"]').val();
                if (link_equipment_id) {
                    delete_link_equipment_id.push({
                        'link_equipment_id': link_equipment_id,
                        'plan_link_id': plan_link_id
                    });
                    let delete_link_equipment_id_json = JSON.stringify(delete_link_equipment_id);
                    $('#delete_link_equipment_id').val(delete_link_equipment_id_json);
                }
                var $table = $(event).closest('.table-bordered');
                var $tr = $table.find('tbody tr');
                $(event).closest('tr').remove();
            }
            $(document).on('click', '.addLinkRow', function() {
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

            let deletedPlanLinkId = [];

            function removeLinkRow(event) {
                var plan_link_id = $(event).closest('.main_link').find('input[name^="plan_link_id_"]').val();
                deletedPlanLinkId.push(plan_link_id);
                let deletedPlanLinkIdJson = JSON.stringify(deletedPlanLinkId);
                $('#delete_plan_link_id').val(deletedPlanLinkIdJson);
                let count = $('.main_link').length;
                if (count > 0) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You want to delete this link!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33'
                    }).then((result) => {
                        if (result.value) {
                            linkMainDiv = $(event).closest('.main_link').html();
                            $(event).closest('.main_link').remove();
                        }
                    })
                }
            }

            $(document).on('change', '.equipment_id', function() {
                var this_event = $(this);
                var equipment_id = $(this).val();
                var equiments = {!! json_encode($materials) !!};
                var find_equipment = equiments.find(x => x.id == equipment_id);
                $(this).closest('tr').find('.unit').val(find_equipment.unit);
                $.get('{{ route('getMaterialWiseBrands') }}', {
                    material_id: equipment_id
                }, function(data) {
                    console.log(data);
                    var html = '<option value="">Select Brand</option>';
                    $.each(data, function(key, item) {
                        html += '<option value="' + item.id + '">' +
                            item.name + '</option>';
                    });
                    this_event.closest('tr').find('.brand_id').html(html);
                })
            });

            $(document).on('change', '.link_material_id', function() {
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
                })
            });
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
        @include('changes::modify_planning.js')
    @endsection
