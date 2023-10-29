@extends('layouts.backend-layout')
@section('title', 'costing')

@php
    $is_old = old('client_id') ? true : false;
    $form_heading = !empty($costing->id) ? 'Update' : 'Add';
    $form_url = !empty($costing->id) ? route('survey.update', $costing->id) : route('costing.store');
    $form_method = !empty($costing->id) ? 'PUT' : 'POST';
@endphp

@section('breadcrumb-title')
    {{ ucfirst($form_heading) }} Costing Sheet
@endsection

@section('breadcrumb-button')
    <a href="{{ route('costing.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')

    {!! Form::open([
        'url' => $form_url,
        'method' => $form_method,
    ]) !!}

    {{-- Comparative Statement --}}
    <div class="card">
        <div class="tableHeading">
            <h5> <span> &#10070; </span> Costing Sheet <span>&#10070;</span> </h5>
        </div>
        <div class="card-body">
            <div class="row">
                @php
                    $client_name = $is_old ? old('client_name') : $planning->feasibilityRequirementDetail->feasibilityRequirement->lead_generation->client_name;
                    $client_no = $is_old ? old('client_no') : $planning->feasibilityRequirementDetail->feasibilityRequirement->lead_generation->client_no;
                    $location = $is_old ? old('location') : $planning->feasibilityRequirementDetail->connectivity_point;
                    $fr_no = $is_old ? old('fr_no') : $planning->feasibilityRequirementDetail->fr_no;
                    $fr_id = $is_old ? old('fr_id') : $planning->feasibilityRequirementDetail->id;
                    $mq_no = $is_old ? old('mq_no') : $planning->feasibilityRequirementDetail->feasibilityRequirement->mq_no;

                @endphp
                {{-- exiting or new radio button --}}
                <div class="col-xl-3 col-md-3">
                    <div class="form-item">
                        <input class="form-control" id="client_id" name="client_no" aria-describedby="client_id"
                            value="{{ $client_no ?? '' }}" readonly placeholder="">
                        <label for="client_id">Client ID<span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-xl-3 col-md-3">
                    <div class="form-item">
                        <input class="form-control form-control-sm" id="client_name" name="client_name"
                            aria-describedby="client_name" value="{{ $client_name ?? '' }}" readonly placeholder="">
                        <label for="client_name">Client Name<span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-xl-3 col-md-3">
                    <div>
                        <div class="form-item">
                            <input type="text" name="connectivity_point" id="connectivity_point"
                                class="form-control form-control-sm" placeholder="" value="{{ $location }}" required>
                            <label for="connectivity_point">Connectivity Point</label>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-3">
                    <div class="form-item">
                        <input type="number" name="month" id="month" class="form-control form-control-sm"
                            placeholder="Month" value="12">
                        <label for="mone">Month</label>
                    </div>
                </div>
                <input type="hidden" name="fr_id" value="{{ $fr_id }}">
                <input type="hidden" name="fr_no" value="{{ $fr_no }}">
                <input type="hidden" name="mq_no" value="{{ $mq_no }}">
            </div>
            <div class="row">
                <div class="md-col-12 col-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th colspan="12">Product Costing</th>
                                </tr>
                                <tr>
                                    <th style="min-width: 200px">Product</th>
                                    <th style="min-width: 100px">Quantity</th>
                                    <th style="min-width: 100px">Rate</th>
                                    <th style="min-width: 100px">Unit</th>
                                    <th style="min-width: 100px">Amount</th>
                                    <th style="min-width: 100px">Operation Cost</th>
                                    <th style="min-width: 100px">Total Amount</th>
                                    <th style="min-width: 100px">Price </th>
                                    <th style="min-width: 100px">Total </th>
                                    <th style="min-width: 100px">Vat(%)</th>
                                    <th style="min-width: 100px">Vat Amount</th>
                                    <th style="min-width: 100px">Total Price</th>
                                </tr>
                            </thead>
                            <tbody class="productBody">
                                @foreach ($planning->servicePlans as $service_plan)
                                    <tr class="product_details_row">
                                        <td>
                                            <span>
                                                <input type="text" name="product[]" id="product"
                                                    class="form-control form-control-sm input" placeholder="Product"
                                                    value="{{ $service_plan->connectivityProductRequirementDetails->product->name }}"
                                                    readonly>
                                                <input type="hidden" name="product_id[]" id="product"
                                                    class="form-control form-control-sm input" placeholder="Product"
                                                    value="{{ $service_plan->connectivityProductRequirementDetails->product->id }}">
                                            </span>
                                        </td>
                                        <td>
                                            <span>
                                                <input type="number" name="product_quantity[]"
                                                    class="form-control form-control-sm input product_quantity"
                                                    placeholder="Quantity" value="{{ $service_plan->plan }}">
                                            </span>
                                        </td>
                                        <td>
                                            <span>
                                                <input type="number" name="product_rate[]"
                                                    class="form-control form-control-sm input product_rate"
                                                    placeholder="Rate" value="">
                                            </span>
                                        </td>
                                        <td>
                                            <span>
                                                <input type="text" name="product_unit[]"
                                                    class="form-control form-control-sm input product_unit"
                                                    value="{{ $service_plan->connectivityProductRequirementDetails->product->unit }}"
                                                    readonly>
                                            </span>
                                        </td>
                                        <td>
                                            <span>
                                                <input type="number" name="product_price[]"
                                                    class="form-control form-control-sm input product_price"
                                                    placeholder="Amount" value="" readonly>
                                            </span>
                                        </td>
                                        <td>
                                            <span>
                                                <input type="number" name="product_operation_cost[]"
                                                    class="form-control form-control-sm input product_operation_cost"
                                                    placeholder="Operation Cost" value="">
                                            </span>
                                        </td>
                                        <td>
                                            <span>
                                                <input type="number" name="product_operation_cost_total[]"
                                                    class="form-control form-control-sm input product_operation_cost_total"
                                                    placeholder="Total" value="" readonly>
                                            </span>
                                        </td>
                                        <td>
                                            <span>
                                                <input type="number" name="offer_price[]"
                                                    class="form-control form-control-sm input offer_price"
                                                    placeholder=" Price" value="" readonly>
                                            </span>
                                        </td>
                                        <td>
                                            <span>
                                                <input type="number" name="product_offer_total[]"
                                                    class="form-control form-control-sm input product_offer_total"
                                                    placeholder="Total Price" value="" readonly>
                                            </span>
                                        </td>
                                        <td>
                                            <span>
                                                <input type="number" name="product_vat[]"
                                                    class="form-control form-control-sm input product_vat"
                                                    placeholder="Vat"
                                                    value="{{ $service_plan->connectivityProductRequirementDetails->product->vat }}"
                                                    step="0.01">
                                            </span>
                                        </td>
                                        <td>
                                            <span>
                                                <input type="number" name="product_vat_amount[]"
                                                    class="form-control form-control-sm input product_vat_amount"
                                                    placeholder="Vat Amount" value="" readonly>
                                            </span>
                                        </td>
                                        <td>
                                            <span>
                                                <input type="number" name="total_price[]"
                                                    class="form-control form-control-sm input total_price"
                                                    placeholder="Total Price" value="" readonly>
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="4" class="text-right">Total</td>
                                    <td>
                                        <span>
                                            <input type="number" name="product_total_cost" id="product_total_cost"
                                                class="form-control form-control-sm input" placeholder="Total Price"
                                                value="" readonly step="0.01">
                                        </span>
                                    </td>
                                    <td>
                                        <span>
                                            <input type="number" name="total_operation_cost" id="total_operation_cost"
                                                class="form-control form-control-sm input" placeholder="Total Cost"
                                                value="" readonly step="0.01">
                                        </span>
                                    </td>
                                    <td>
                                        <span>
                                            <input type="number" name="total_cost_amount"
                                                id="total_with_operation_amount"
                                                class="form-control form-control-sm input" placeholder="Total Amount"
                                                value="" readonly step="0.01">
                                        </span>
                                    </td>
                                    <td></td>
                                    <td>
                                        <span>
                                            <input type="number" name="product_grand_total" id="product_grand_total"
                                                class="form-control form-control-sm input" placeholder="Total Price"
                                                value="" readonly step="0.01">
                                        </span>
                                    </td>
                                    <td></td>
                                    <td>
                                        <span>
                                            <input type="number" name="total_vat" id="total_vat"
                                                class="form-control form-control-sm input" placeholder="Total VAT"
                                                value="" readonly step="0.01">
                                        </span>
                                    </td>
                                    <td>
                                        <span>
                                            <input type="number" name="grand_total_price" id="grand_total_price"
                                                class="form-control form-control-sm input" placeholder="Grand Total "
                                                value="" readonly>
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($planning->equipmentPlans->isNotEmpty())
                    <div class="md-col-12 col-12">
                        {{-- Connectivity Details --}}
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th colspan="6">Product Related Equipment</th>
                                    </tr>
                                    <tr>
                                        <th>Link Type</th>
                                        <th>Quantity</th>
                                        <th>Unit</th>
                                        <th>Ownership</th>
                                        <th>Rate</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody class="connectivityBody">
                                    @foreach ($planning->equipmentPlans as $equipment_plan)
                                        <tr class="connectivity_details_row">
                                            <td>
                                                <span>
                                                    <input type="text" name="material[]" id="material"
                                                        class="form-control form-control-sm input" placeholder="Link Type"
                                                        value="{{ $equipment_plan->material->name ?? '' }}" readonly>
                                                    <input type="hidden" name="material_id[]" id="material_id "
                                                        class="form-control form-control-sm input" placeholder="Link Type"
                                                        value="{{ $equipment_plan->material->id ?? '' }}" readonly>
                                                </span>
                                            </td>
                                            <td>
                                                <span>
                                                    <input type="number" name="equipment_quantity[]"
                                                        class="form-control form-control-sm input equipment_quantity"
                                                        placeholder="Quantity" value="{{ $equipment_plan->quantity }}"
                                                        readonly>
                                                </span>
                                            </td>
                                            <td>
                                                <span>
                                                    <input type="text" name="equipment_unit[]"
                                                        class="form-control form-control-sm input equipment_unit"
                                                        placeholder="Unit" value="{{ $equipment_plan->unit }}" readonly>
                                                </span>
                                            </td>
                                            <td>
                                                <select name="equipment_ownership[]"
                                                    class="form-control form-control-sm input equipment_ownership select2">
                                                    <option value="BBTCL">BBTCL</option>
                                                    <option value="Client">Client</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" name="equipment_rate[]"
                                                    class="form-control form-control-sm input equipment_rate"
                                                    placeholder="Rate">
                                            </td>
                                            <td>
                                                <span>
                                                    <input type="number" name="equipment_total[]"
                                                        class="form-control form-control-sm input equipment_total"
                                                        placeholder="Total">
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="5" class="text-right" style="font-size: 14px;">Equipment Total
                                        </td>
                                        <td>
                                            <span>
                                                <input type="number" name="equipment_wise_total"
                                                    id="equipment_wise_total" class="form-control form-control-sm input"
                                                    placeholder="Total Amount" value="" readonly>
                                            </span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="5" class="text-right" style="font-size: 14px;">Client Equipment
                                            Total
                                        </td>
                                        <td>
                                            <span>
                                                <input type="number" name="client_equipment_total"
                                                    id="client_equipment_total" class="form-control form-control-sm input"
                                                    placeholder="Total Amount" value="" readonly>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-right" style="font-size: 14px;">Partial Total</td>
                                        <td>
                                            <span>
                                                <input type="number" name="equipment_partial_total"
                                                    id="equipment_partial_total"
                                                    class="form-control form-control-sm input" placeholder="Total Amount"
                                                    value="" readonly>
                                            </span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="5" class="text-right" style="font-size: 14px;">Deployment Cost
                                        </td>
                                        <td>
                                            <span>
                                                <input type="number" name="equipment_deployment_cost"
                                                    id="equipment_deployment_cost"
                                                    class="form-control form-control-sm input"
                                                    placeholder="Deployment Cost" value="">
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-right" style="font-size: 14px;">Interest</td>
                                        <td>
                                            <div class="row">
                                                <div class="col-6">
                                                    <span>
                                                        <input type="number" name="equipment_perchantage_interest"
                                                            id="equipment_perchantage_interest"
                                                            class="form-control form-control-sm input"
                                                            placeholder="Interest (%)" value="">
                                                    </span>
                                                </div>
                                                <div class="col-6">
                                                    <span>
                                                        <input type="number" name="equipment_interest"
                                                            id="equipment_interest"
                                                            class="form-control form-control-sm input"
                                                            placeholder="Interest" value="" readonly>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-right" style="font-size: 14px;">VAT</td>
                                        <td>
                                            <div class="row">
                                                <div class="col-6">
                                                    <span>
                                                        <input type="number" name="equipment_perchantage_vat"
                                                            id="equipment_perchantage_vat"
                                                            class="form-control form-control-sm input"
                                                            placeholder="VAT (%)" value="">
                                                    </span>
                                                </div>
                                                <div class="col-6">
                                                    <span>
                                                        <input type="number" name="equipment_vat" id="equipment_vat"
                                                            class="form-control form-control-sm input" placeholder="VAT"
                                                            value="" readonly>
                                                    </span>
                                                </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-right" style="font-size: 14px;">Tax</td>
                                        <td>
                                            <div class="row">
                                                <div class="col-6">
                                                    <span>
                                                        <input type="number" name="equipment_perchantage_tax"
                                                            id="equipment_perchantage_tax"
                                                            class="form-control form-control-sm input"
                                                            placeholder="Tax (%)" value="">
                                                    </span>
                                                </div>
                                                <div class="col-6">
                                                    <span>
                                                        <input type="number" name="equipment_tax" id="equipment_tax"
                                                            class="form-control form-control-sm input" placeholder="Tax"
                                                            value="" readonly>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-right" style="font-size: 14px;">Total</td>
                                        <td>
                                            <span>
                                                <input type="number" name="equipment_grand_total"
                                                    id="equipment_grand_total" class="form-control form-control-sm input"
                                                    placeholder="Total" value="">
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-right" style="font-size: 14px;">OTC</td>
                                        <td>
                                            <span>
                                                <input type="number" name="equipment_otc" id="equipment_otc"
                                                    class="form-control form-control-sm input" placeholder="OTC"
                                                    value="">
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-right" style="font-size: 14px;">ROI</td>
                                        <td>
                                            <span>
                                                <input type="number" name="equipment_roi" id="equipment_roi"
                                                    class="form-control form-control-sm input" placeholder="ROI"
                                                    value="" readonly>
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
            <hr />
            <div class="text-center">
                <h5> <span> &#10070; </span> Link Details <span>&#10070;</span> </h5>
            </div>
            <hr />
            @foreach ($planning->PlanLinks as $key => $plan_link)
                @php $row_no = $key + 1; @endphp
                <input type="hidden" name="total_key" value="{{ $row_no }}">
                <div class="PlanLinkMainRow"
                    style="border: 2px solid gray; border-radius: 15px; padding: 15px; margin-top: 15px;">
                    <div class="row">
                        <div style="width: 5%; margin: 0px 7px;">
                            <div class="checkbox-fade fade-in-primary"
                                style="margin-top: 12px; margin-left: 22px;">
                                <label>
                                    <input type="checkbox" name="plan_link_status_{{ $row_no }}"
                                        class="input plan_link_status" value="1">

                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <input type="hidden" name="link_no_{{ $row_no }}"
                            value="{{ $plan_link->finalSurveyDetails->link_no }}">
                        <div style="width: 14%; margin: 0px 7px;">
                            <div class="form-item">
                                <input type="text" name="link_type_{{ $row_no }}"
                                    class="form-control form-control-sm link_type input" placeholder="Link Name"
                                    value="{{ $plan_link->link_type }}" readonly>
                                <label for="link_type">Link Type</label>
                            </div>
                        </div>
                        <div style="width: 14%; margin: 0px 7px;">
                            <div class="form-item">
                                <input type="text" name="option_{{ $row_no }}"
                                    class="form-control form-control-sm  plan_link_option input" placeholder="Link Type"
                                    value="{{ $plan_link->option }}" readonly>
                                <label for="plan_link_option">Option</label>
                            </div>
                        </div>
                        <div style="width: 12%; margin: 0px 7px;">
                            <div class="form-item">
                                <input type="text" name="capacity_{{ $row_no }}"
                                    class="form-control form-control-sm  plan_link_capacity input" placeholder="Capacity"
                                    value="{{ $plan_link->existing_transmission_capacity ?? $plan_link->new_transmission_capacity }}"
                                    readonly>
                                <label for="plan_link_capacity">Capacity</label>
                            </div>
                        </div>
                        <div style="width: 14%; margin: 0px 7px;">
                            <div class="form-item">
                                <input type="text" name="quantity_{{ $row_no }}"
                                    class="form-control form-control-sm  plan_link_quantity input" placeholder="Quantity"
                                    value="">
                                <label for="plan_link_quantity">Quantity</label>
                            </div>
                        </div>
                        <div style="width: 14%; margin: 0px 7px;">
                            <div class="form-item">
                                <input type="text" name="rate_{{ $row_no }}"
                                    class="form-control form-control-sm  plan_link_rate input" placeholder="Rate"
                                    value="">
                                <label for="plan_link_rate">Rate</label>
                            </div>
                        </div>
                        <div style="width: 14%; margin: 0px 7px;">
                            <div class="form-item">
                                <input type="text" name="link_total_{{ $row_no }}"
                                    class="form-control form-control-sm  plan_link_total input" placeholder="Total"
                                    value="" readonly>
                                <label for="plan_link_total">Total</label>
                            </div>
                        </div>
                    </div>
                    @if (!empty($plan_link->PlanLinkEquipments))
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th colspan="6">Equipment</th>
                                    </tr>
                                    <tr>
                                        <th>Material</th>
                                        <th>Unit</th>
                                        <th>Ownership</th>
                                        <th>Quantity</th>
                                        <th>Rate</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody class="tbody">
                                    @foreach ($plan_link->PlanLinkEquipments as $plan_link_equipment)
                                        <tr>
                                            <td>
                                                <span>
                                                    <input type="text"
                                                        class="form-control form-control-sm plan_equipment_material_name input"
                                                        placeholder="Material"
                                                        name="plan_equipment_material_name_{{ $row_no }}[]"
                                                        value="{{ $plan_link_equipment->material->name ?? '' }}">
                                                    <input type="hidden"
                                                        name="plan_equipment_material_id_{{ $row_no }}[]"
                                                        value="{{ $plan_link_equipment->material->id ?? '' }}">
                                            </td>
                                            <td>
                                                <span>
                                                    <input type="text"
                                                        class="form-control form-control-sm plan_equipment_unit input"
                                                        placeholder="Unit"
                                                        name="plan_equipment_unit_{{ $row_no }}[]"
                                                        value="{{ $plan_link_equipment->unit ?? '' }}">
                                                </span>
                                            </td>
                                            <td>
                                                <span>
                                                    <select name="ownership_{{ $row_no }}[]"
                                                        class="form-control form-control-sm input plan_equipment_ownership">
                                                        <option value="BBTS">BBTS</option>
                                                        <option value="Client">Client</option>
                                                    </select>
                                                </span>
                                            </td>
                                            <td>
                                                <span>
                                                    <input type="number"
                                                        class="form-control form-control-sm plan_equipment_quantity input"
                                                        placeholder="Quantity"
                                                        name="plan_equipment_quantity_{{ $row_no }}[]"
                                                        value="{{ $plan_link_equipment->quantity ?? '' }}">
                                                </span>
                                            </td>
                                            <td>
                                                <span>
                                                    <input type="number"
                                                        class="form-control form-control-sm plan_equipment_rate input"
                                                        name="plan_equipment_rate_{{ $row_no }}[]"
                                                        placeholder="Rate" value="" step="0.01">
                                                </span>
                                            </td>
                                            <td>
                                                <span>
                                                    <input type="number"
                                                        class="form-control form-control-sm plan_equipment_total input"
                                                        name="plan_equipment_total_{{ $row_no }}[]"
                                                        placeholder="Total" value="" step="0.01">
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="5" class="text-right" style="font-size:14px;">Plan Equipment
                                            Total
                                        </td>
                                        <td>
                                            <span>
                                                <input type="number" name="plan_all_equipment_total_{{ $row_no }}"
                                                    id="plan_all_equipment_total"
                                                    class="form-control form-control-sm plan_all_equipment_total input"
                                                    placeholder="Total" value="" step="0.01">
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-right" style="font-size:14px;">Client Equipment
                                            Total
                                        </td>
                                        <td>
                                            <span>
                                                <input type="number"
                                                    name="plan_client_equipment_total_{{ $row_no }}"
                                                    id="plan_client_equipment_total"
                                                    class="form-control form-control-sm plan_client_equipment_total input"
                                                    placeholder="Total" value="" step="0.01">
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-right" style="font-size:14px;">Total
                                        </td>
                                        <td>
                                            <span>
                                                <input type="number"
                                                    name="plan_equipment_partial_total_{{ $row_no }}"
                                                    id="plan_equipment_partial_total"
                                                    class="form-control form-control-sm plan_equipment_partial_total input"
                                                    placeholder="Total" value="" step="0.01">
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="text-right">
                                        <td colspan="3">
                                            <span style="font-size: 14px;">OTC</span>
                                        </td>
                                        <td>
                                            <input type="number" name="plan_equipment_otc_{{ $row_no }}"
                                                id="plan_equipment_otc"
                                                class="form-control form-control-sm plan_equipment_otc input"
                                                placeholder="OTC" value="" step="0.01">
                                        </td>
                                        <td>
                                            <span style="font-size: 14px;">Deployment Cost</span>
                                        </td>
                                        <td>
                                            <input type="number"
                                                name="plan_equipment_deployment_cost_{{ $row_no }}"
                                                id="plan_equipment_deployment_cost"
                                                class="form-control form-control-sm plan_equipment_deployment_cost input"
                                                placeholder="Deployment Cost" value="" step="0.01">
                                        </td>
                                    </tr>
                                    <tr class="text-right">
                                        <td colspan="3">
                                            <span style="font-size: 14px;">ROI</span>
                                        </td>
                                        <td>
                                            <input type="number" name="plan_equipment_roi_{{ $row_no }}"
                                                id="plan_equipment_roi"
                                                class="form-control form-control-sm plan_equipment_roi input"
                                                placeholder="ROI" value="" step="0.01">
                                        </td>
                                        <td>
                                            <span style="font-size: 14px;">Interest</span>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-6">
                                                    <span>
                                                        <input type="number"
                                                            name="plan_equipment_perchantage_interest_{{ $row_no }}"
                                                            id="plan_equipment_perchantage_interest"
                                                            class="form-control form-control-sm plan_equipment_perchantage_interest input"
                                                            placeholder="Interest (%)" value="" step="0.01">
                                                    </span>
                                                </div>
                                                <div class="col-6">
                                                    <span>
                                                        <input type="number"
                                                            name="plan_equipment_interest_{{ $row_no }}"
                                                            id="plan_equipment_interest"
                                                            class="form-control form-control-sm plan_equipment_interest input"
                                                            placeholder="Interest" value="" step="0.01">
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="text-right">
                                        <td colspan="3">
                                            <span style="font-size: 14px;">Capacity</span>
                                        </td>
                                        <td>
                                            <input type="number" name="plan_equipment_capacity_{{ $row_no }}"
                                                id="plan_equipment_capacity"
                                                class="form-control form-control-sm plan_equipment_capacity input"
                                                placeholder="Capacity" value="" step="0.01">
                                        </td>
                                        <td>
                                            <span style="font-size: 14px;">Total</span>
                                        </td>
                                        <td>
                                            <input type="number" name="plan_equipment_grand_total_{{ $row_no }}"
                                                id="plan_equipment_grand_total"
                                                class="form-control form-control-sm plan_equipment_grand_total input"
                                                placeholder="Total" value="" step="0.01">
                                        </td>
                                    </tr>
                                    <tr class="text-right">
                                        <td colspan="3">
                                            <span style="font-size: 14px;">Operation Cost</span>
                                        </td>
                                        <td>
                                            <input type="number"
                                                name="plan_equipment_operation_cost_{{ $row_no }}"
                                                id="plan_equipment_operation_cost"
                                                class="form-control form-control-sm plan_equipment_operation_cost input"
                                                placeholder="Operation Cost" value="" step="0.01">
                                        </td>
                                        <td>
                                            <span style="font-size: 14px;">VAT</span>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-6">
                                                    <span>
                                                        <input type="number"
                                                            name="plan_equipment_perchantage_vat_{{ $row_no }}"
                                                            id="plan_equipment_perchantage_vat"
                                                            class="form-control form-control-sm plan_equipment_perchantage_vat input"
                                                            placeholder="VAT (%)" value="" step="0.01">
                                                    </span>
                                                </div>
                                                <div class="col-6">
                                                    <span>
                                                        <input type="number"
                                                            name="plan_equipment_vat_{{ $row_no }}"
                                                            id="plan_equipment_vat"
                                                            class="form-control form-control-sm plan_equipment_vat input"
                                                            placeholder="VAT" value="" step="0.01">
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="text-right">
                                        <td colspan="3">
                                            <span style="font-size: 14px;">Total MRC</span>
                                        </td>
                                        <td>
                                            <input type="number" name="plan_equipment_total_mrc_{{ $row_no }}"
                                                id="plan_equipment_total_mrc"
                                                class="form-control form-control-sm plan_equipment_total_mrc input"
                                                placeholder="Total MRC" value="" step="0.01">
                                        </td>
                                        <td>
                                            <span style="font-size: 14px;">Tax</span>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-6">
                                                    <span>
                                                        <input type="number"
                                                            name="plan_equipment_perchantage_tax_{{ $row_no }}"
                                                            id="plan_equipment_perchantage_tax"
                                                            class="form-control form-control-sm plan_equipment_perchantage_tax input"
                                                            placeholder="Tax (%)" value="" step="0.01">
                                                    </span>
                                                </div>
                                                <div class="col-6">
                                                    <span>
                                                        <input type="number"
                                                            name="plan_equipment_tax_{{ $row_no }}"
                                                            id="plan_equipment_tax"
                                                            class="form-control form-control-sm plan_equipment_tax input"
                                                            placeholder="Tax" value="" step="0.01">
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="text-right">
                                        <td colspan="5">
                                            <span style="font-size: 14px;">Total Inv</span>
                                        </td>
                                        <td>
                                            <input type="number" name="plan_equipment_total_inv_{{ $row_no }}"
                                                id="plan_equipment_total_inv"
                                                class="form-control form-control-sm plan_equipment_total_inv input"
                                                placeholder="Total Inv" value="" step="0.01">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            @endforeach
            <hr />
            <div class="text-center">
                <h5>FR Wise Cost Calculation</h5>
            </div>
            <hr />
            <div class="row p-0 m-0">
                <div class="col-3 col-md-3">
                    <button type="button" class="btn btn-outline-primary btn-sm" id="calculate_data">Calculate
                        Data</button>
                </div>
                <div class="col-6 col-md-6">
                    <table class="table table-bordered w-full">
                        <tbody>
                            <tr>
                                <td colspan="2">
                                    <span style="font-size:14px;">Total Investment</span>
                                </td>
                                <td colspan="2">
                                    <input type="number" name="total_investment" id="total_investment"
                                        class="form-control form-control-sm text-center plan_fr_total_investment input"
                                        placeholder="Total Investment" value="">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <span style="font-size:14px;">Total OTC</span>
                                </td>
                                <td colspan="2">
                                    <input type="number" name="total_otc" id="total_otc"
                                        class="form-control form-control-sm text-center total_otc input"
                                        placeholder="Total OTC" value="">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <span style="font-size:14px;">Total Product Cost</span>
                                </td>
                                <td colspan="2">
                                    <input type="number" name="total_product_cost" id="total_product_cost"
                                        class="form-control form-control-sm text-center total_product_cost input"
                                        placeholder="Total Product Cost" value="">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <span style="font-size:14px;">Total Service Cost</span>
                                </td>
                                <td colspan="2">
                                    <input type="number" name="total_service_cost" id="total_service_cost"
                                        class="form-control form-control-sm text-center total_service_cost input"
                                        placeholder="Total Service Cost" value="">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <span style="font-size:14px;">Total MRC</span>
                                </td>
                                <td colspan="2">
                                    <input type="number" name="total_mrc" id="total_mrc"
                                        class="form-control form-control-sm text-center total_mrc input"
                                        placeholder="Total MRC" value="" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span style="font-size:14px;">Margin</span>
                                </td>
                                <td>
                                    <input type="number" name="management_perchantage" id="management_perchantage"
                                        class="form-control form-control-sm text-center margin input" placeholder="Margin"
                                        value="">
                                </td>
                                <td>
                                    <input type="number" name="management_cost_amount" id="management_cost_amount"
                                        class="form-control form-control-sm text-center management_cost_amount input"
                                        placeholder="Margin Amount" value="" readonly>
                                </td>
                                <td>
                                    <input type="number" name="management_cost_total" id="management_cost_total"
                                        class="form-control form-control-sm text-center management_cost_total input"
                                        placeholder="Margin Amount" value="" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <span style="font-size:14px;">Equipment Price for Client</span>
                                </td>
                                <td colspan="2">
                                    <input type="number" name="equipment_price_for_client"
                                        id="equipment_price_for_client"
                                        class="form-control form-control-sm text-center equipment_price_for_client input"
                                        placeholder="Equipment Price for Client" value="" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <span style="font-size:14px;">Total OTC</span>
                                </td>
                                <td colspan="2">
                                    <input type="number" name="total_otc_with_client_equipment"
                                        id="total_otc_with_client_equipment"
                                        class="form-control form-control-sm text-center total_otc_with_client_equipment input"
                                        placeholder="Total OTC" value="" readonly>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-3 col-md-3">
                </div>
            </div>
        </div>
    </div>
    <button class="py-2 btn btn-success ">{{ !empty($costing->id) ? 'Update' : 'Save' }}</button>
    </div>
    {!! Form::close() !!}
@endsection

@section('script')
    <script>
        $('#date').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true,
            showOtherMonths: true
        }).datepicker("setDate", new Date());

        $('.product_rate').on('keyup', function() {
            var product_rate = $(this).val();
            var product_quantity = $(this).closest('tr').find('.product_quantity').val();
            var product_total = product_rate * product_quantity;
            $(this).closest('tr').find('.product_price').val(product_total);
            // var vat_perchant = $(this).closest('tr').find('.product_vat').val();
            // var vat_amount = (product_total * vat_perchant) / 100;
            // $(this).closest('tr').find('.product_vat_amount').val(vat_amount);
            productPartialTotal();
        });

        $('.product_operation_cost').on('keyup', function() {
            var product_operation_cost = $(this).val();
            var product_price = $(this).closest('tr').find('.product_price').val();
            // var vat_amount = $(this).closest('tr').find('.product_vat_amount').val();
            var product_total = parseInt(product_operation_cost) + parseInt(product_price);
            $(this).closest('tr').find('.product_operation_cost_total').val(product_total);
            // $('#total_product_cost').val(product_total); 
            // $('#total_mrc').val(product_total); 
            productPartialTotal();
        });

        function productPartialTotal() {
            var product_total = 0;
            $('.product_operation_cost').each(function() {
                var value = parseInt($(this).val());
                if (!isNaN(value)) {
                    product_total += value;
                }
            });
            $('#total_operation_cost').val(product_total);

            var total_with_operation = 0;
            $('.product_operation_cost_total').each(function() {
                var value = parseInt($(this).val());
                if (!isNaN(value)) {
                    total_with_operation += value;
                }
            });

            const product_total_cost = $('.product_price').map(function() {
                return parseInt($(this).val()) || 0;
            }).get().reduce((acc, val) => acc + val, 0);
            $('#product_total_cost').val(product_total_cost);

            $('#total_with_operation_amount').val(total_with_operation);

            $('#total_product_cost').val(total_with_operation);
            $('#total_mrc').val(total_with_operation);

        }

        $('.equipment_rate').on('keyup', function() {
            var equipment_rate = $(this).val();
            var equipment_quantity = $(this).closest('tr').find('.equipment_quantity').val();
            var equipment_total = parseInt(equipment_rate) * parseInt(equipment_quantity);
            $(this).closest('tr').find('.equipment_total').val(equipment_total);
            equipmentPartialTotal();
        });

        $('#equipment_deployment_cost, #equipment_perchantage_interest, #equipment_perchantage_vat, #equipment_perchantage_tax')
            .on('keyup', function() {
                equipmentPartialTotal();
            });

        function equipmentPartialTotal() {
            var equipment_total = 0;
            var client_equipment_total = 0;

            $('.equipment_total').each(function() {
                var value = parseInt($(this).val());
                if (!isNaN(value)) {
                    equipment_total += value;
                }
                var ownership = $(this).closest('tr').find('.equipment_ownership').val();
                console.log('ownership', ownership)
                if (ownership == 'Client' && !isNaN(value)) {
                    client_equipment_total += value;

                }
            });

            $('#equipment_wise_total').val(equipment_total);
            $('#client_equipment_total').val(client_equipment_total);
            var partial_total = equipment_total - client_equipment_total;
            $('#equipment_partial_total').val(equipment_total - client_equipment_total);
            var development_cost = $('#equipment_deployment_cost').val() ? $('#equipment_deployment_cost').val() : 0;
            var interest_perchat_amount = (partial_total * $('#equipment_perchantage_interest').val()) / 100;
            var interest = $('#equipment_perchantage_interest').val() ? interest_perchat_amount : 0;
            $('#equipment_interest').val(interest_perchat_amount)
            var perchantage_vat_amount = (partial_total * $('#equipment_perchantage_vat').val()) / 100;
            $('#equipment_vat').val(perchantage_vat_amount)
            var vat = $('#equipment_perchantage_vat').val() ? perchantage_vat_amount : 0;
            var perchantage_tax_amount = (partial_total * $('#equipment_perchantage_tax').val()) / 100;
            var tax = $('#equipment_perchantage_tax').val() ? perchantage_tax_amount : 0;
            $('#equipment_tax').val(perchantage_tax_amount)
            var total = parseInt(partial_total) + parseInt(development_cost) + parseInt(interest) + parseInt(
                vat) + parseInt(tax);
            $('#equipment_grand_total').val(total);
        }

        $('#calculate_data').on('click', function() {
            // alert('fine')
            equipmentPartialTotal()
        })

        $('#equipment_otc').on('keyup', function() {
            var equipment_otc = $(this).val();
            var equipment_total = $('#equipment_grand_total').val();
            var month = $('#month').val();
            var equipment_roi = (parseInt(equipment_total) - parseInt(equipment_otc)) / parseInt(month);
            $('#equipment_roi').val(equipment_roi);
        });

        $('.plan_link_rate').on('keyup', function() {
            var plan_link_rate = $(this).val();
            var plan_link_quantity = $(this).closest('.PlanLinkMainRow').find('.plan_link_quantity').val();
            var plan_link_total = parseInt(plan_link_quantity) * parseInt(plan_link_rate);
            $(this).closest('.PlanLinkMainRow').find('.plan_equipment_capacity').val(plan_link_total);
            $(this).closest('.PlanLinkMainRow').find('.plan_link_total').val(plan_link_total);
        });

        $('.plan_equipment_rate').on('keyup', function() {
            var plan_equipment_rate = $(this).val();
            var plan_all_equipment_total = 0;
            var plan_client_equipment_total = 0;
            var plan_equipment_quantity = $(this).closest('tr').find(
                '.plan_equipment_quantity').val();
            var equipment_total = parseInt(plan_equipment_quantity) * parseInt(plan_equipment_rate);
            $(this).closest('tr').find('.plan_equipment_total').val(equipment_total);
            $(this).closest('.PlanLinkMainRow').find('.plan_equipment_total').each(function() {
                var value = parseInt($(this).val());
                if (!isNaN(value)) {
                    plan_all_equipment_total += value;
                }
                var ownership = $(this).closest('tr').find('.plan_equipment_ownership').val();
                if (ownership == 'Client' && !isNaN(value)) {
                    plan_client_equipment_total += value;
                }
            });
            console.log('plan_all_equipment_total', plan_all_equipment_total)
            console.log('plan_client_equipment_total', plan_client_equipment_total)
            var plan_equipment_partial_total = plan_all_equipment_total - plan_client_equipment_total;
            $(this).closest('.PlanLinkMainRow').find('.plan_all_equipment_total').val(plan_all_equipment_total);
            $(this).closest('.PlanLinkMainRow').find('.plan_client_equipment_total').val(
                plan_client_equipment_total);
            $(this).closest('.PlanLinkMainRow').find('.plan_equipment_partial_total').val(
                plan_equipment_partial_total);
            // planEquipmentPartialTotal(this);
            // planEquipmentInvestTotal(this);
            // calculatePlanEquipmentROI(this)
        });

        $('.plan_equipment_deployment_cost, .plan_equipment_perchantage_interest, .plan_equipment_perchantage_vat, .plan_equipment_perchantage_tax')
            .on('keyup',
                function() {
                    var event = this;
                    planEquipmentPartialTotal(event);
                    planEquipmentInvestTotal(event);
                    calculatePlanEquipmentROI(event);
                });

        function planEquipmentPartialTotal(event) {
            var plan_equipment_partial_total = $(event).closest('.PlanLinkMainRow').find('.plan_equipment_partial_total')
                .val();
            var deployment_cost = $(event).closest('.PlanLinkMainRow').find(
                '.plan_equipment_deployment_cost').val();
            var plan_equipment_deployment_cost = deployment_cost ? deployment_cost : 0;
            var equipment_perchantage_interest = $(event).closest('.PlanLinkMainRow').find(
                '.plan_equipment_perchantage_interest').val();
            var plan_equipment_perchantage_interest_amount = (plan_equipment_partial_total *
                equipment_perchantage_interest) / 100;

            var plan_equipment_interest = plan_equipment_perchantage_interest_amount ?
                plan_equipment_perchantage_interest_amount : 0;
            $(event).closest('.PlanLinkMainRow').find('.plan_equipment_interest').val(plan_equipment_interest);
            var plan_equipment_total = parseInt(plan_equipment_partial_total) + parseInt(plan_equipment_deployment_cost) +
                parseInt(plan_equipment_interest);
            $(event).closest('.PlanLinkMainRow').find('.plan_equipment_grand_total').val(plan_equipment_total);
        }


        $('.plan_equipment_perchantage_vat, .plan_equipment_perchantage_tax').on('keyup', function() {
            var event = this;
            planEquipmentPartialTotal(event);
            planEquipmentInvestTotal(event);
            calculatePlanEquipmentROI(event)

        });

        function planEquipmentInvestTotal(event) {
            var plan_equipment_grand_total = $(event).closest('.PlanLinkMainRow').find('.plan_equipment_grand_total').val();
            var equipment_perchantage_vat = $(event).closest('.PlanLinkMainRow').find(
                '.plan_equipment_perchantage_vat').val() || 0;
            var plan_equipment_perchantage_vat_amount = (plan_equipment_grand_total * equipment_perchantage_vat) / 100;
            var plan_equipment_vat = plan_equipment_perchantage_vat_amount ? plan_equipment_perchantage_vat_amount : 0;
            var equipment_perchantage_tax = $(event).closest('.PlanLinkMainRow').find(
                '.plan_equipment_perchantage_tax').val() || 0;

            var plan_equipment_perchantage_tax_amount = (plan_equipment_grand_total * equipment_perchantage_tax) / 100;
            $(event).closest('.PlanLinkMainRow').find('.plan_equipment_tax').val(plan_equipment_perchantage_tax_amount);
            var plan_equipment_tax = plan_equipment_perchantage_tax_amount ? plan_equipment_perchantage_tax_amount : 0;
            $(event).closest('.PlanLinkMainRow').find('.plan_equipment_vat').val(plan_equipment_vat);
            var plan_equipment_invest_total = parseInt(plan_equipment_grand_total) + parseInt(plan_equipment_vat) +
                parseInt(plan_equipment_tax);
            $(event).closest('.PlanLinkMainRow').find('.plan_equipment_total_inv').val(plan_equipment_invest_total);
        }

        $('.plan_equipment_otc, .plan_equipment_operation_cost').on('keyup', function() {
            var event = this;
            calculatePlanEquipmentROI(event);
        });

        function calculatePlanEquipmentROI(event) {
            var plan_equipment_otc = $(event).closest('.PlanLinkMainRow').find('.plan_equipment_otc').val();
            var plan_equipment_total_inv = $(event).closest('.PlanLinkMainRow').find('.plan_equipment_total_inv').val();
            var plan_equipment_month = $('#month').val();
            var plan_equipment_roi = ((parseInt(plan_equipment_total_inv) - parseInt(plan_equipment_otc)) / parseInt(
                plan_equipment_month)).toFixed(2);
            $(event).closest('.PlanLinkMainRow').find('.plan_equipment_roi').val(plan_equipment_roi);
            var capacity_total = $(event).closest('.PlanLinkMainRow').find('.plan_equipment_capacity').val();
            var plan_equipment_operation_cost = $(event).closest('.PlanLinkMainRow').find(
                '.plan_equipment_operation_cost').val();
            var plan_equipment_operation_cost = plan_equipment_operation_cost ? plan_equipment_operation_cost : 0;
            var plan_equipment_total = parseInt(capacity_total) + parseInt(plan_equipment_operation_cost) + parseInt(
                plan_equipment_roi);
            $(event).closest('.PlanLinkMainRow').find('.plan_equipment_total_mrc').val(plan_equipment_total);
        }

        $('.plan_link_status').click(function(event) {
            let total_mrc = 0;
            let total_otc = 0;
            let total_equipment_investment = 0;
            let total_plan_equipment_otc = 0;
            const planLinkMainRows = $('.PlanLinkMainRow');

            $('.plan_link_status:checked').each(function() {
                const $this = $(this);
                const plan_link_total_mrc = $this.closest('.PlanLinkMainRow').find(
                    '.plan_equipment_total_mrc').val();
                total_mrc += parseFloat(plan_link_total_mrc);

                total_equipment_investment += parseFloat($(this).closest('.PlanLinkMainRow').find(
                    '.plan_equipment_total_inv').val()) || 0;

                total_plan_equipment_otc += parseFloat($(this).closest('.PlanLinkMainRow').find(
                    '.plan_equipment_otc').val()) || 0;

            });

            console.log('total_mrc', total_mrc)

            const equipment_grand_total = parseInt($('#equipment_grand_total').val()) || 0;
            const total_investment = equipment_grand_total + total_equipment_investment;
            $('#total_investment').val(total_investment);
            const total_equipment_otc = parseInt($('#equipment_otc').val()) || 0;
            total_otc = total_plan_equipment_otc + total_equipment_otc;
            $('#total_otc').val(total_otc);
            const equipment_roi = parseInt($('#equipment_roi').val()) || 0;
            const total_service_cost = (total_mrc + equipment_roi) || 0;
            $('#total_service_cost').val(total_service_cost);

            const total_product_cost = parseInt($('#total_with_operation_amount').val()) || 0;
            $('#total_product_cost').val(total_product_cost);
            $('#total_mrc').val(total_service_cost + total_product_cost);
        });


        //  Margin Calculation
        $('#management_perchantage').on('keyup', function() {
            var margin = $(this).val();
            var total_mrc = parseFloat($('#total_mrc').val());
            var total_mrc_amount = total_mrc * margin / 100;
            $('#management_cost_amount').val(total_mrc_amount);

            var product_total_cost = parseFloat($('#product_total_cost').val());
            var management_cost_total = total_mrc + total_mrc_amount;
            $('#management_cost_total').val(management_cost_total);

            var perchantage = (management_cost_total / product_total_cost) * 100 - 100;
            $('.product_rate').each(function() {

                var product_rate = parseFloat($(this).val());
                var product_rate_perchantage = product_rate.toFixed(2) * (perchantage / 100);
                var product_margin_rate = (product_rate + product_rate_perchantage).toFixed(2);
                $(this).closest('tr').find('.offer_price').val(product_margin_rate);
                var total_margin_amount = product_margin_rate * parseFloat($(this).closest('tr').find(
                    '.product_quantity').val());
                $(this).closest('tr').find('.product_offer_total').val(total_margin_amount.toFixed(2));

                var vat_perchant = $(this).closest('tr').find('.product_vat').val();
                var vat_amount = (total_margin_amount * vat_perchant) / 100;
                $(this).closest('tr').find('.product_vat_amount').val(vat_amount);
                $(this).closest('tr').find('.total_price').val((total_margin_amount + vat_amount).toFixed(
                    2));
            });
            var product_grand_total = $('.product_offer_total').get()
                .reduce(function(sum, el) {
                    return sum + parseFloat(el.value);
                }, 0);
            var total_vat = $('.product_vat_amount').get()
                .reduce(function(sum, el) {
                    return sum + parseFloat(el.value);
                }, 0);
            var grand_total_price = $('.total_price').get()
                .reduce(function(sum, el) {
                    return sum + parseFloat(el.value);
                }, 0);

            const client_equipment_total = parseFloat($('#client_equipment_total').val());

            //client equipment total
            let plan_client_equipment_total = 0;
            let plan_equipment_otc = 0;

            $('.plan_link_status').each(function() {
                if ($(this).is(':checked')) {
                    plan_client_equipment_total += parseFloat($(this).closest('.PlanLinkMainRow').find(
                        '.plan_client_equipment_total').val()) ?? 0;
                    plan_equipment_otc += parseFloat($(this).closest('.PlanLinkMainRow').find(
                        '.plan_equipment_otc').val()) ?? 0;
                }
            });

            let equipment_price_for_client = client_equipment_total + plan_client_equipment_total;
            $('#equipment_price_for_client').val(equipment_price_for_client.toFixed(2));

            let equipment_otc = parseFloat($('#equipment_otc').val());
            let total_equipment_otc = equipment_otc + plan_equipment_otc + equipment_price_for_client
            $('#total_otc_with_client_equipment').val(total_equipment_otc);
            $('#product_grand_total').val(product_grand_total.toFixed(2));
            $('#total_vat').val(total_vat.toFixed(2));
            $('#grand_total_price').val(grand_total_price.toFixed(2));
        });

        //This is button function for add new row in plan link

        $(".input").on("keydown", function(e) {
            if (e.key === "Enter") {
                e.preventDefault();
                var currentIndex = $(".input").index(this);
                var nextIndex = currentIndex + 1;
                var inputs = $(".input");

                if (nextIndex < inputs.length) {
                    var nextInput = inputs.eq(nextIndex);
                    nextInput.focus();
                }
            } else if (e.keyCode === 40 || e.which === 40) {
                e.preventDefault();
                var currentIndex = $(".input").index(this);
                var nextIndex = currentIndex + 1;
                var inputs = $(".input");

                if (nextIndex < inputs.length) {
                    var nextInput = inputs.eq(nextIndex);
                    nextInput.focus();
                }
            } else if (e.keyCode === 38 || e.which === 38) {
                e.preventDefault();
                var currentIndex = $(".input").index(this);
                var nextIndex = currentIndex - 1;
                var inputs = $(".input");

                if (nextIndex < inputs.length) {
                    var nextInput = inputs.eq(nextIndex);
                    nextInput.focus();
                }
            } else if (e.keyCode === 37 || e.which === 37) {
                e.preventDefault();
                var currentIndex = $(".input").index(this);
                var nextIndex = currentIndex - 1;
                var inputs = $(".input");

                if (nextIndex < inputs.length) {
                    var nextInput = inputs.eq(nextIndex);
                    nextInput.focus();
                }
            } else if (e.keyCode === 39 || e.which === 39) {
                e.preventDefault();
                var currentIndex = $(".input").index(this);
                var nextIndex = currentIndex + 1;
                var inputs = $(".input");

                if (nextIndex < inputs.length) {
                    var nextInput = inputs.eq(nextIndex);
                    nextInput.focus();
                }
            }
        });
    </script>
@endsection
