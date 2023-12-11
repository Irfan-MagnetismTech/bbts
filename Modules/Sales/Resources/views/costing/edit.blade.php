@extends('layouts.backend-layout')
@section('title', 'costing')

@php
    $is_old = old('client_id') ? true : false;
    $form_heading = 'Update';
    $form_url = route('costing.update', $costing->id);
    $form_method = 'PUT';
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
                {{-- exiting or new radio button --}}
                <div class="col-xl-3 col-md-3">
                    <div class="form-item">
                        <input class="form-control" id="client_id" name="client_no" aria-describedby="client_id"
                            value="{{ $costing->client_no ?? '' }}" readonly placeholder="">
                        <label for="client_id">Client ID<span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-xl-3 col-md-3">
                    <div class="form-item">
                        <input class="form-control form-control-sm" id="client_name" name="client_name"
                            aria-describedby="client_name" value="{{ $costing->lead_generation->client_name ?? '' }}"
                            readonly placeholder="">
                        <label for="client_name">Client Name<span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-xl-3 col-md-3">
                    <div>
                        <div class="form-item">
                            <input type="text" name="connectivity_point" id="connectivity_point"
                                class="form-control form-control-sm" placeholder=""
                                value="{{ $costing->feasibilityRequirementDetail->connectivity_point }}" required>
                            <label for="connectivity_point">Connectivity Point</label>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-3">
                    <div class="form-item">
                        <input type="number" name="month" id="month" class="form-control form-control-sm"
                            placeholder="Month" value="{{ $costing->month }}">
                        <label for="mone">Month</label>
                    </div>
                </div>
                <input type="hidden" name="fr_id" value="{{ $costing->feasibilityRequirementDetail->id }}">
                <input type="hidden" name="fr_no" value="{{ $costing->fr_no }}">
                <input type="hidden" name="mq_no" value="{{ $costing->mq_no }}">
            </div>
            @if ($costing->costingProducts->isNotEmpty())
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
                                    @foreach ($costing->costingProducts as $costing_product)
                                        <tr class="product_details_row">
                                            <input hidden type="text" name="costing_product_id[]"
                                                value="{{ $costing_product->id }}">
                                            <td>
                                                <span>
                                                    <input type="text" name="product[]" id="product"
                                                        class="form-control form-control-sm input" placeholder="Product"
                                                        value="{{ $costing_product->product->name }}" readonly>
                                                    <input type="hidden" name="product_id[]" id="product"
                                                        class="form-control form-control-sm input" placeholder="Product"
                                                        value="{{ $costing_product->product_id }}">
                                                </span>
                                            </td>
                                            <td>
                                                <span>
                                                    <input type="number" name="product_quantity[]"
                                                        class="form-control form-control-sm input product_quantity"
                                                        placeholder="Quantity" value="{{ $costing_product->quantity }}">
                                                </span>
                                            </td>
                                            <td>
                                                <span>
                                                    <input type="number" name="product_rate[]"
                                                        class="form-control form-control-sm input product_rate"
                                                        placeholder="Rate" value="{{ $costing_product->rate }}">
                                                </span>
                                            </td>
                                            <td>
                                                <span>
                                                    <input type="text" name="product_unit[]"
                                                        class="form-control form-control-sm input product_unit"
                                                        value="{{ $costing_product->unit }}" readonly>
                                                </span>
                                            </td>
                                            <td>
                                                <span>
                                                    <input type="number" name="product_price[]"
                                                        class="form-control form-control-sm input product_price"
                                                        placeholder="Amount" value="{{ $costing_product->sub_total }}"
                                                        readonly>
                                                </span>
                                            </td>
                                            <td>
                                                <span>
                                                    <input type="number" name="product_operation_cost[]"
                                                        class="form-control form-control-sm input product_operation_cost"
                                                        placeholder="Total"
                                                        value="{{ $costing_product->operation_cost }}">
                                                </span>
                                            </td>
                                            <td>
                                                <span>
                                                    <input type="number" name="product_operation_cost_total[]"
                                                        class="form-control form-control-sm input product_operation_cost_total"
                                                        placeholder="Operation Cost"
                                                        value="{{ $costing_product->operation_cost_total }}" readonly>
                                                </span>
                                            </td>
                                            <td>
                                                <span>
                                                    <input type="number" name="offer_price[]"
                                                        class="form-control form-control-sm input offer_price"
                                                        placeholder="Margin Price"
                                                        value="{{ $costing_product->offer_price }}" readonly>
                                                </span>
                                            </td>
                                            <td>
                                                <span>
                                                    <input type="number" name="product_offer_total[]"
                                                        class="form-control form-control-sm input product_offer_total"
                                                        placeholder="Margin Price"
                                                        value="{{ $costing_product->offer_price * $costing_product->quantity }}"
                                                        readonly>
                                                </span>
                                            </td>
                                            <td>
                                                <span>
                                                    <input type="number" name="product_vat[]"
                                                        class="form-control form-control-sm input product_vat"
                                                        placeholder="Vat" value="{{ $costing_product->product_vat }}">
                                                </span>
                                            </td>
                                            <td>
                                                <span>
                                                    <input type="number" name="product_vat_amount[]"
                                                        class="form-control form-control-sm input product_vat_amount"
                                                        placeholder="Vat Amount"
                                                        value="{{ $costing_product->product_vat_amount }}" readonly>
                                                </span>
                                            </td>
                                            <td>
                                                <span>
                                                    <input type="number" name="product_offer_total[]"
                                                        class="form-control form-control-sm input total_price"
                                                        placeholder="Total Price" value="{{ $costing_product->total }}"
                                                        readonly>
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
                                                    value="{{ $costing->product_total_cost }}" readonly>
                                            </span>
                                        </td>
                                        <td>
                                            <span>
                                                <input type="number" name="total_operation_cost"
                                                    id="total_operation_cost" class="form-control form-control-sm input"
                                                    placeholder="Total Cost" value="{{ $costing->total_operation_cost }}"
                                                    readonly>
                                            </span>
                                        </td>
                                        <td>
                                            <span>
                                                <input type="number" name="total_cost_amount"
                                                    id="total_with_operation_amount"
                                                    class="form-control form-control-sm input" placeholder="Total Amount"
                                                    value="{{ $costing->total_cost_amount }}" readonly>
                                            </span>
                                        </td>
                                        <td>

                                        </td>
                                        <td>
                                            <span>
                                                <input type="number" name="product_grand_total" id="product_grand_total"
                                                    class="form-control form-control-sm input" placeholder="Total Price"
                                                    value="{{ $costing->product_grand_total }}" readonly>
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if ($costing->costingProductEquipments->isNotEmpty())
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
                                        @foreach ($costing->costingProductEquipments as $product_equipment)
                                            <tr class="connectivity_details_row">
                                                <input hidden type="text" name="costing_product_equipment_id[]"
                                                    value="{{ $product_equipment->id }}">
                                                <td>
                                                    <span>
                                                        <input type="text" name="material[]" id="material"
                                                            class="form-control form-control-sm input"
                                                            placeholder="Link Type"
                                                            value="{{ $product_equipment->material->name ?? '' }}"
                                                            readonly>
                                                        <input type="hidden" name="material_id[]" id="material_id "
                                                            class="form-control form-control-sm input"
                                                            placeholder="Link Type"
                                                            value="{{ $product_equipment->material->id ?? '' }}" readonly>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input type="number" name="equipment_quantity[]"
                                                            class="form-control form-control-sm input equipment_quantity"
                                                            placeholder="Quantity"
                                                            value="{{ $product_equipment->quantity }}" readonly>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input type="text" name="equipment_unit[]"
                                                            class="form-control form-control-sm input equipment_unit"
                                                            placeholder="Unit" value="{{ $product_equipment->unit }}"
                                                            readonly>
                                                    </span>
                                                </td>
                                                <td>
                                                    <select name="equipment_ownership[]"
                                                        class="form-control form-control-sm input equipment_ownership">
                                                        <option value="BBTS"
                                                            @if ($product_equipment->ownership == 'BBTS') selected @endif>
                                                            BBTS</option>
                                                        <option value="Client"
                                                            @if ($product_equipment->ownership == 'Client') selected @endif>
                                                            Client</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" name="equipment_rate[]"
                                                        class="form-control form-control-sm input equipment_rate"
                                                        placeholder="Rate" value="{{ $product_equipment->rate }}">
                                                </td>
                                                <td>
                                                    <span>
                                                        <input type="number" name="equipment_total[]"
                                                            class="form-control form-control-sm input equipment_total"
                                                            placeholder="Total" value="{{ $product_equipment->total }}">
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="5" class="text-right" style="font-size: 14px;">Equipment
                                                Total
                                            </td>
                                            <td>
                                                <span>
                                                    <input type="number" name="equipment_wise_total"
                                                        id="equipment_wise_total"
                                                        class="form-control form-control-sm input"
                                                        placeholder="Total Amount"
                                                        value="{{ $costing->equipment_wise_total }}" readonly>
                                                </span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="5" class="text-right" style="font-size: 14px;">Client
                                                Equipment
                                                Total
                                            </td>
                                            <td>
                                                <span>
                                                    <input type="number" name="client_equipment_total"
                                                        id="client_equipment_total"
                                                        class="form-control form-control-sm input"
                                                        placeholder="Total Amount"
                                                        value="{{ $costing->client_equipment_total }}" </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-right" style="font-size: 14px;">Partial Total
                                            </td>
                                            <td>
                                                <span>
                                                    <input type="number" name="equipment_partial_total"
                                                        id="equipment_partial_total"
                                                        class="form-control form-control-sm input"
                                                        placeholder="Total Amount"
                                                        value="{{ $costing->equipment_partial_total }}" </span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="5" class="text-right" style="font-size: 14px;">Deployment
                                                Cost
                                            </td>
                                            <td>
                                                <span>
                                                    <input type="number" name="equipment_deployment_cost"
                                                        id="equipment_deployment_cost"
                                                        class="form-control form-control-sm input"
                                                        placeholder="Deployment Cost"
                                                        value="{{ $costing->equipment_deployment_cost }}" </span>
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
                                                                placeholder="Interest"
                                                                value="{{ $costing->equipment_perchantage_interest }}">
                                                        </span>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="col-6">
                                                            <span>
                                                                <input type="number" name="equipment_interest"
                                                                    id="equipment_interest"
                                                                    class="form-control form-control-sm input"
                                                                    placeholder="Interest"
                                                                    value="{{ $costing->equipment_interest }}" readonly>
                                                            </span>
                                                        </div>
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
                                                                placeholder="VAT"
                                                                value="{{ $costing->equipment_perchantage_vat }}" </span>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="col-6">
                                                            <span>
                                                                <input type="number" name="equipment_vat"
                                                                    id="equipment_vat"
                                                                    class="form-control form-control-sm input"
                                                                    placeholder="VAT"
                                                                    value="{{ $costing->equipment_vat }}" readonly>
                                                            </span>
                                                        </div>
                                                    </div>
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
                                                                placeholder="Tax"
                                                                value="{{ $costing->equipment_perchantage_tax }}">
                                                        </span>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="col-6">
                                                            <span>
                                                                <input type="number" name="equipment_tax"
                                                                    id="equipment_tax"
                                                                    class="form-control form-control-sm input"
                                                                    placeholder="Tax"
                                                                    value="{{ $costing->equipment_tax }}" readonly>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-right" style="font-size: 14px;">Total</td>
                                            <td>
                                                <span>
                                                    <input type="number" name="equipment_grand_total"
                                                        id="equipment_grand_total"
                                                        class="form-control form-control-sm input" placeholder="Total"
                                                        value="{{ $costing->equipment_grand_total }}" readonly>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-right" style="font-size: 14px;">OTC</td>
                                            <td>
                                                <span>
                                                    <input type="number" name="equipment_otc" id="equipment_otc"
                                                        class="form-control form-control-sm input" placeholder="OTC"
                                                        value="{{ $costing->equipment_otc }}" readonly>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-right" style="font-size: 14px;">ROI</td>
                                            <td>
                                                <span>
                                                    <input type="number" name="equipment_roi" id="equipment_roi"
                                                        class="form-control form-control-sm input" placeholder="ROI"
                                                        value="{{ $costing->equipment_roi }}" readonly>
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
            <hr />
            <div class="text-center">
                <h5> <span> &#10070; </span> Link Details <span>&#10070;</span> </h5>
            </div>
            <hr />
            @foreach ($costing->costingLinks as $key => $costing_link)
                @php $row_no = $key + 1; @endphp
                <input type="hidden" name="total_key" value="{{ $row_no }}">
                <input type="hidden" name="costing_link_id_{{ $row_no }}" value="{{ $costing_link->id }}">
                <div class="PlanLinkMainRow"
                    style="border: 2px solid gray; border-radius: 15px; padding: 15px; margin-top: 15px;">
                    <div class="row">
                        <div style="width: 5%; margin: 0px 7px;">
                            <div class="checkbox-fade fade-in-primary" style="margin-top: 12px; margin-left: 22px;">
                                <label>
                                    <input type="checkbox" name="plan_link_status_{{ $row_no }}"
                                        class="input plan_link_status" value="1"
                                        @if ($costing_link->link_status == 1) checked @endif>

                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <input type="hidden" name="link_no_{{ $row_no }}"
                            value="{{ $costing_link->finalSurveyDetails->link_no }}">
                        <div style="width: 14%; margin: 0px 7px;">
                            <div class="form-item">
                                <input type="text" name="link_type_{{ $row_no }}"
                                    class="form-control form-control-sm link_type input" placeholder="Link Name"
                                    value="{{ $costing_link->link_type }}" readonly>
                                <label for="link_type">Link Type</label>
                            </div>
                        </div>
                        <div style="width: 14%; margin: 0px 7px;">
                            <div class="form-item">
                                <input type="text" name="option_{{ $row_no }}"
                                    class="form-control form-control-sm  plan_link_option input" placeholder="Link Type"
                                    value="{{ $costing_link->option }}" readonly>
                                <label for="plan_link_option">Option</label>
                            </div>
                        </div>
                        <div style="width: 12%; margin: 0px 7px;">
                            <div class="form-item">
                                <input type="text" name="capacity_{{ $row_no }}"
                                    class="form-control form-control-sm  plan_link_capacity input" placeholder="Capacity"
                                    value="{{ $costing_link->transmission_capacity }}" readonly>
                                <label for="plan_link_capacity">Capacity</label>
                            </div>
                        </div>
                        <div style="width: 14%; margin: 0px 7px;">
                            <div class="form-item">
                                <input type="text" name="quantity_{{ $row_no }}"
                                    class="form-control form-control-sm  plan_link_quantity input" placeholder="Quantity"
                                    value="{{ $costing_link->quantity }}">
                                <label for="plan_link_quantity">Quantity</label>
                            </div>
                        </div>
                        <div style="width: 14%; margin: 0px 7px;">
                            <div class="form-item">
                                <input type="text" name="rate_{{ $row_no }}"
                                    class="form-control form-control-sm  plan_link_rate input" placeholder="Rate"
                                    value="{{ $costing_link->rate }}">
                                <label for="plan_link_rate">Rate</label>
                            </div>
                        </div>
                        <div style="width: 14%; margin: 0px 7px;">
                            <div class="form-item">
                                <input type="text" name="link_total_{{ $row_no }}"
                                    class="form-control form-control-sm  plan_link_total input" placeholder="Total"
                                    value="{{ $costing_link->total }}" readonly>
                                <label for="plan_link_total">Total</label>
                            </div>
                        </div>
                    </div>
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
                                @foreach ($costing_link->costingLinkEquipments as $link_equipment)
                                    <tr>
                                        <input hidden type="text"
                                            name="costing_link_equipment_id_{{ $row_no }}[]"
                                            value="{{ $link_equipment->id }}">
                                        <td>
                                            <span>
                                                <input type="text"
                                                    class="form-control form-control-sm plan_equipment_material_name input"
                                                    placeholder="Material"
                                                    name="plan_equipment_material_name_{{ $row_no }}[]"
                                                    value="{{ $link_equipment->material->name ?? '' }}" readonly>
                                                <input type="hidden"
                                                    name="plan_equipment_material_id_{{ $row_no }}[]"
                                                    value="{{ $link_equipment->material->id ?? '' }}">
                                            </span>
                                        </td>
                                        <td>
                                            <span>
                                                <input type="text"
                                                    class="form-control form-control-sm plan_equipment_unit input"
                                                    placeholder="Unit" name="plan_equipment_unit_{{ $row_no }}[]"
                                                    value="{{ $link_equipment->unit ?? '' }}" readonly>
                                            </span>
                                        </td>
                                        <td>
                                            <span>
                                                <select name="ownership_{{ $row_no }}[]"
                                                    class="form-control form-control-sm input plan_equipment_ownership">
                                                    <option value="BBTS"
                                                        @if ($link_equipment->ownership == 'BBTS') selected @endif>
                                                        BBTS</option>
                                                    <option value="Client"
                                                        @if ($link_equipment->ownership == 'Client') selected @endif>
                                                        Client</option>
                                                </select>
                                            </span>
                                        </td>
                                        <td>
                                            <span>
                                                <input type="number"
                                                    class="form-control form-control-sm plan_equipment_quantity input"
                                                    placeholder="Quantity"
                                                    name="plan_equipment_quantity_{{ $row_no }}[]"
                                                    value="{{ $link_equipment->quantity ?? '' }}">
                                            </span>
                                        </td>
                                        <td>
                                            <span>
                                                <input type="number"
                                                    class="form-control form-control-sm plan_equipment_rate input"
                                                    name="plan_equipment_rate_{{ $row_no }}[]" placeholder="Rate"
                                                    value="{{ $link_equipment->rate ?? '' }}">
                                            </span>
                                        </td>
                                        <td>
                                            <span>
                                                <input type="number"
                                                    class="form-control form-control-sm plan_equipment_total input"
                                                    name="plan_equipment_total_{{ $row_no }}[]" placeholder="Total"
                                                    value="{{ $link_equipment->total ?? '' }}">
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="5" class="text-right" style="font-size:14px;">Plan Equipment Total
                                    </td>
                                    <td>
                                        <span>
                                            <input type="number" name="plan_all_equipment_total_{{ $row_no }}"
                                                id="plan_all_equipment_total"
                                                class="form-control form-control-sm plan_all_equipment_total input"
                                                placeholder="Total"
                                                value="{{ $costing_link->plan_all_equipment_total }}">
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right" style="font-size:14px;">Client Equipment Total
                                    </td>
                                    <td>
                                        <span>
                                            <input type="number" name="plan_client_equipment_total_{{ $row_no }}"
                                                id="plan_client_equipment_total"
                                                class="form-control form-control-sm plan_client_equipment_total input"
                                                placeholder="Total"
                                                value="{{ $costing_link->plan_client_equipment_total }}">
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right" style="font-size:14px;">Total
                                    </td>
                                    <td>
                                        <span>
                                            <input type="number" name="plan_equipment_partial_total_{{ $row_no }}"
                                                id="plan_equipment_partial_total"
                                                class="form-control form-control-sm plan_equipment_partial_total input"
                                                placeholder="Total" value="{{ $costing_link->partial_total }}">
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
                                            placeholder="OTC" value="{{ $costing_link->otc }}">
                                    </td>
                                    <td>
                                        <span style="font-size: 14px;">Deployment Cost</span>
                                    </td>
                                    <td>
                                        <input type="number" name="plan_equipment_deployment_cost_{{ $row_no }}"
                                            id="plan_equipment_deployment_cost"
                                            class="form-control form-control-sm plan_equipment_deployment_cost input"
                                            placeholder="Deployment Cost" value="{{ $costing_link->deployment_cost }}">
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
                                            placeholder="ROI" value="{{ $costing_link->roi }}">
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
                                                        placeholder="Interest"
                                                        value="{{ $costing_link->interest_perchantage }}">
                                                </span>
                                            </div>
                                            <div class="col-6">
                                                <span>
                                                    <input type="number"
                                                        name="plan_equipment_interest_{{ $row_no }}"
                                                        id="plan_equipment_interest"
                                                        class="form-control form-control-sm plan_equipment_interest input"
                                                        placeholder="Interest" value="{{ $costing_link->interest }}">
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
                                            placeholder="Capacity" value="{{ $costing_link->capacity_amount }}">
                                    </td>
                                    <td>
                                        <span style="font-size: 14px;">Total</span>
                                    </td>
                                    <td>
                                        <input type="number" name="plan_equipment_grand_total_{{ $row_no }}"
                                            id="plan_equipment_grand_total"
                                            class="form-control form-control-sm plan_equipment_grand_total input"
                                            placeholder="Total" value="{{ $costing_link->grand_total }}">
                                    </td>
                                </tr>
                                <tr class="text-right">
                                    <td colspan="3">
                                        <span style="font-size: 14px;">Operation Cost</span>
                                    </td>
                                    <td>
                                        <input type="number" name="plan_equipment_operation_cost_{{ $row_no }}"
                                            id="plan_equipment_operation_cost"
                                            class="form-control form-control-sm plan_equipment_operation_cost input"
                                            placeholder="Operation Cost" value="{{ $costing_link->operation_cost }}">
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
                                                        placeholder="VAT" value="{{ $costing_link->vat_perchantage }}">
                                                </span>
                                            </div>
                                            <div class="col-6">
                                                <span>
                                                    <input type="number" name="plan_equipment_vat_{{ $row_no }}"
                                                        id="plan_equipment_vat"
                                                        class="form-control form-control-sm plan_equipment_vat input"
                                                        placeholder="VAT" value="{{ $costing_link->vat }}">
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
                                            placeholder="Total MRC" value="{{ $costing_link->total_mrc }}">
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
                                                        placeholder="Tax" value="{{ $costing_link->tax_perchantage }}">
                                                </span>
                                            </div>
                                            <div class="col-6">
                                                <span>
                                                    <input type="number" name="plan_equipment_tax_{{ $row_no }}"
                                                        id="plan_equipment_tax"
                                                        class="form-control form-control-sm plan_equipment_tax input"
                                                        placeholder="Tax" value="{{ $costing_link->tax }}">
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
                                            placeholder="Total Inv" value="{{ $costing_link->total_mrc }}">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
            <hr />
            <div class="text-center">
                <h5>FR Wise Cost Calculation</h5>
            </div>
            <hr />
            <div class="row p-0 m-0">
                <div class="col-3 col-md-3">
                </div>
                <div class="col-6 col-md-6">
                    <table class="table table-bordered w-full">
                        <tbody>
                            <tr>
                                <td colspan="2">
                                    <span style="font-size:14px;">Total Investment</span>
                                </td>
                                <td colspan="2">
                                    <input type="number" name="total_investment" id="total_investment" step="0.01"
                                        class="form-control form-control-sm text-center plan_fr_total_investment input"
                                        placeholder="Total Investment" value="{{ $costing->total_investment }}"
                                        readonly>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <span style="font-size:14px;">Total OTC</span>
                                </td>
                                <td colspan="2">
                                    <input type="number" name="total_otc" id="total_otc" step="0.01"
                                        class="form-control form-control-sm text-center total_otc input"
                                        placeholder="Total OTC" value="{{ $costing->total_otc }}" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <span style="font-size:14px;">Total Product Cost</span>
                                </td>
                                <td colspan="2">
                                    <input type="number" name="total_product_cost" id="total_product_cost"
                                        step="0.01"
                                        class="form-control form-control-sm text-center total_product_cost input"
                                        placeholder="Total Product Cost" value="{{ $costing->total_product_cost }}"
                                        </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <span style="font-size:14px;">Total Service Cost</span>
                                </td>
                                <td colspan="2">
                                    <input type="number" name="total_service_cost" id="total_service_cost"
                                        step="0.01"
                                        class="form-control form-control-sm text-center total_service_cost input"
                                        placeholder="Total Service Cost" value="{{ $costing->total_service_cost }}"
                                        </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <span style="font-size:14px;">Total MRC</span>
                                </td>
                                <td colspan="2">
                                    <input type="number" name="total_mrc" id="total_mrc" step="0.01"
                                        class="form-control form-control-sm text-center total_mrc input"
                                        placeholder="Total MRC" value="{{ $costing->total_mrc }}" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span style="font-size:14px;">Margin</span>
                                </td>
                                <td>
                                    <input type="number" step=".1" name="management_perchantage" step="0.01"
                                        id="management_perchantage"
                                        class="form-control form-control-sm text-center margin input" placeholder="Margin"
                                        value="{{ $costing->management_perchantage }}">
                                </td>
                                <td>
                                    <input type="number" step=".1" name="management_cost_amount" step="0.01"
                                        id="management_cost_amount"
                                        class="form-control form-control-sm text-center management_cost_amount input"
                                        placeholder="Margin Amount" value="{{ $costing->management_cost_amount }}">
                                </td>
                                <td>
                                    <input type="number" step=".1" name="management_cost_total"
                                        id="management_cost_total"
                                        class="form-control form-control-sm text-center management_cost_total input"
                                        placeholder="Margin Amount" value="{{ $costing->management_cost_total }}">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <span style="font-size:14px;">Equipment Price for Client</span>
                                </td>
                                <td colspan="2">
                                    <input type="number" step=".1" name="equipment_price_for_client"
                                        step="0.01" id="equipment_price_for_client"
                                        class="form-control form-control-sm text-center equipment_price_for_client input"
                                        placeholder="Equipment Price for Client"
                                        value="{{ $costing->equipment_price_for_client }}">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <span style="font-size:14px;">Total OTC</span>
                                </td>
                                <td colspan="2">
                                    <input type="number" step=".1" name="total_otc_with_client_equipment"
                                        step="0.01" id="total_otc_with_client_equipment"
                                        class="form-control form-control-sm text-center total_otc_with_client_equipment input"
                                        placeholder="Total OTC" value="{{ $costing->total_otc_with_client_equipment }}">
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

        //calculation for product

        $('.product_rate, .product_quantity').on('keyup', function() {
            var product_rate = $(this).closest('tr').find('.product_rate').val() || 0;
            var product_quantity = $(this).closest('tr').find('.product_quantity').val() || 0;
            var product_total = parseFloat(product_rate) * parseFloat(product_quantity);
            $(this).closest('tr').find('.product_price').val(product_total.toFixed(2));
            productOperationSumCalculation($(this));
            productPartialTotal();
            totalOperationCost()
            totalProductCostWithOperationCost();
        });

        $('.product_operation_cost').on('keyup', function() {
            productOperationSumCalculation($(this));
            totalOperationCost()
            totalProductCostWithOperationCost();
        });

        function productOperationSumCalculation(thisEvent) {
            var product_operation_cost = thisEvent.closest('tr').find('.product_operation_cost').val() || 0;
            var product_price = thisEvent.closest('tr').find('.product_price').val() || 0;
            var product_total = parseFloat(product_operation_cost) + parseFloat(product_price)
            thisEvent.closest('tr').find('.product_operation_cost_total').val(product_total.toFixed(2));
        }

        function totalOperationCost() {
            var total_operation_cost = 0;
            $('.product_operation_cost').each(function() {
                var value = parseFloat($(this).val())
                if (!isNaN(value)) {
                    total_operation_cost += value;
                }
            });
            $('#total_operation_cost').val(total_operation_cost.toFixed(2));
        }

        function totalProductCostWithOperationCost() {
            var total_product_cost = $('.product_operation_cost_total').map(function() {
                return parseFloat($(this).val()) || 0;
            }).get().reduce((acc, val) => acc + val, 0).toFixed(2);
            $('#total_with_operation_amount').val(total_product_cost);
        }

        function productPartialTotal() {
            var product_total = 0;
            const product_total_cost = $('.product_price').map(function() {
                return parseFloat($(this).val()) || 0;
            }).get().reduce((acc, val) => acc + val, 0).toFixed(2);


            const product_operation_cost = $('.product_operation_cost').map(function() {
                return parseFloat($(this).val()) || 0;
            }).get().reduce((acc, val) => acc + val, 0).toFixed(2);

            const product_operation_cost_total = $('.product_operation_cost_total').map(function() {
                return parseFloat($(this).val()) || 0;
            }).get().reduce((acc, val) => acc + val, 0).toFixed(2);

            $('#product_total_cost').val(product_total_cost);
            $('#total_operation_cost').val(product_operation_cost);
            $('#total_with_operation_amount').val(product_operation_cost_total);
        }

        //End calculation for product

        //calculation for Product Equipement

        $('.equipment_rate, .equipment_quantity').on('keyup', function() {
            var equipment_rate = $(this).closest('tr').find('.equipment_rate').val();
            var equipment_quantity = $(this).closest('tr').find('.equipment_quantity').val();
            var equipment_total = parseFloat(equipment_rate) * parseFloat(equipment_quantity);
            $(this).closest('tr').find('.equipment_total').val(equipment_total.toFixed(2));
            equipmentPartialTotal();
        });

        $('#equipment_deployment_cost, #equipment_perchantage_interest, #equipment_perchantage_vat, #equipment_perchantage_tax, #equipment_otc')
            .on('keyup', function() {
                equipmentPartialTotal();
            });

        function equipmentPartialTotal() {
            var equipment_total = 0;
            var client_equipment_total = 0;

            $('.equipment_total').each(function() {
                var value = $(this).val() || 0;
                console.log('value', value)
                if (!isNaN(value)) {
                    equipment_total += Number(value)
                }
                var ownership = $(this).closest('tr').find('.equipment_ownership').val();
                if (ownership == 'Client' && !isNaN(value)) {
                    client_equipment_total += Number(value)
                }
            });

            // Calculate partial_total
            var partial_total = equipment_total - client_equipment_total;

            // Limit the decimal places to 2
            var formatted_partial_total = partial_total.toFixed(2);

            $('#equipment_wise_total').val(equipment_total.toFixed(2));
            $('#client_equipment_total').val(client_equipment_total.toFixed(2));
            $('#partial_total').val(formatted_partial_total);
            $('#equipment_partial_total').val((equipment_total - client_equipment_total).toFixed(2));

            var development_cost = $('#equipment_deployment_cost').val() ? $('#equipment_deployment_cost').val() : 0;

            var interest_perchat_amount = Number((partial_total * $('#equipment_perchantage_interest').val()) / 100)
                .toFixed(2);
            var interest = $('#equipment_perchantage_interest').val() ? interest_perchat_amount : 0;
            $('#equipment_interest').val(interest_perchat_amount)

            var perchantage_vat_amount = Number((partial_total * $('#equipment_perchantage_vat').val()) / 100).toFixed(
                2);
            $('#equipment_vat').val(perchantage_vat_amount)

            var vat = $('#equipment_perchantage_vat').val() ? perchantage_vat_amount : 0;

            var perchantage_tax_amount = Number((partial_total * $('#equipment_perchantage_tax').val()) / 100).toFixed(
                2);
            var tax = $('#equipment_perchantage_tax').val() ? perchantage_tax_amount : 0;
            $('#equipment_tax').val(perchantage_tax_amount)

            var total = Number(partial_total) + Number(development_cost) + Number(interest) + Number(vat) + Number(tax);
            $('#equipment_grand_total').val(total.toFixed(2));

            var equipment_otc = $('#equipment_otc').val() ? $('#equipment_otc').val() : 0;
            var month = $('#month').val();

            if (equipment_otc != 0) {
                var equipment_roi = (Number(total) - Number(equipment_otc)) / parseInt(month);
                $('#equipment_roi').val(equipment_roi.toFixed(2));
            } else {
                $('#equipment_roi').val(0);
            }
        }


        $('.equipment_ownership').on('change', function() {
            equipmentPartialTotal();
        });

        //end calculation for Product Equipement

        $('#calculate_data').on('click', function() {
            equipmentPartialTotal()
        })

        // $('#equipment_otc').on('keyup', function() {
        //     var equipment_otc = $(this).val();
        //     var equipment_total = $('#equipment_grand_total').val();
        //     var month = $('#month').val();
        //     var equipment_roi = (parseFloat(equipment_total).toFixed(2) - parseFloat(equipment_otc)).toFixed(2) /
        //         parseInt(month);
        //     $('#equipment_roi').val(equipment_roi);
        // });

        //calculation for link Equipment

        $('.plan_link_rate, .plan_link_quantity').on('keyup', function() {
            var plan_link_rate = $(this).closest('.PlanLinkMainRow').find('.plan_link_rate').val() || 0;
            var plan_link_quantity = $(this).closest('.PlanLinkMainRow').find('.plan_link_quantity').val() || 0;
            var plan_link_total = parseFloat(plan_link_quantity) * parseFloat(plan_link_rate);
            $(this).closest('.PlanLinkMainRow').find('.plan_equipment_capacity').val(plan_link_total.toFixed(
                2));
            $(this).closest('.PlanLinkMainRow').find('.plan_link_total').val(plan_link_total.toFixed(2));
        });



        $('.plan_equipment_rate, .plan_equipment_quantity').on('keyup', function() {
            planProductWiseQuantityTotal(this);
            planEquipmentPartialTotal(this);
            PlanLinStatusWiseCalculation()
        });

        $('.plan_equipment_ownership').on('change', function() {
            planProductWiseQuantityTotal(this);
            planEquipmentPartialTotal(this);
            PlanLinStatusWiseCalculation()
        });

        function planProductWiseQuantityTotal(this_event) {
            var plan_equipment_rate = $(this_event).closest('tr').find('.plan_equipment_rate').val() || 0;
            var plan_all_equipment_total = 0;
            var plan_client_equipment_total = 0;
            var plan_equipment_quantity = $(this_event).closest('tr').find(
                '.plan_equipment_quantity').val() || 0;
            var equipment_total = Number(plan_equipment_quantity * plan_equipment_rate).toFixed(2);
            $(this_event).closest('tr').find('.plan_equipment_total').val(equipment_total);
            $(this_event).closest('.PlanLinkMainRow').find('.plan_equipment_total').each(function() {
                var value = $(this).val() || 0;
                plan_all_equipment_total += Number(value);
                var plan_ownership = $(this).closest('tr').find('.plan_equipment_ownership').val();
                if (plan_ownership == 'Client' && !isNaN(value)) {
                    plan_client_equipment_total += Number(value);
                }
            });
            var plan_equipment_partial_total = plan_all_equipment_total.toFixed(2) - plan_client_equipment_total.toFixed(
                2);
            $(this_event).closest('.PlanLinkMainRow').find('.plan_all_equipment_total').val(
                plan_all_equipment_total.toFixed(2));
            $(this_event).closest('.PlanLinkMainRow').find('.plan_client_equipment_total').val(
                plan_client_equipment_total.toFixed(2));
            $(this_event).closest('.PlanLinkMainRow').find('.plan_equipment_partial_total').val(
                Number(plan_equipment_partial_total).toFixed(2));
            planEquipmentPartialTotal(this_event);
        }

        $('.plan_equipment_deployment_cost, .plan_equipment_perchantage_interest, .plan_equipment_perchantage_vat, .plan_equipment_perchantage_tax, .plan_equipment_perchantage_vat, .plan_equipment_perchantage_tax, .plan_equipment_otc, .plan_equipment_operation_cost')
            .on('keyup',
                function() {
                    var event = this;
                    planEquipmentPartialTotal(event);
                    PlanLinStatusWiseCalculation()
                });

        function planEquipmentPartialTotal(event) {
            var plan_equipment_partial_total = $(event).closest('.PlanLinkMainRow').find(
                    '.plan_equipment_partial_total')
                .val();
            var deployment_cost = $(event).closest('.PlanLinkMainRow').find(
                '.plan_equipment_deployment_cost').val();
            var plan_equipment_deployment_cost = deployment_cost ? deployment_cost : 0;
            var equipment_perchantage_interest = $(event).closest('.PlanLinkMainRow').find(
                '.plan_equipment_perchantage_interest').val();
            var plan_equipment_perchantage_interest_amount = Number((plan_equipment_partial_total *
                equipment_perchantage_interest) / 100).toFixed(2);

            var plan_equipment_interest = plan_equipment_perchantage_interest_amount ?
                plan_equipment_perchantage_interest_amount : 0;
            $(event).closest('.PlanLinkMainRow').find('.plan_equipment_interest').val(plan_equipment_interest);
            var plan_equipment_total = Number(plan_equipment_partial_total) +
                Number(plan_equipment_deployment_cost) + Number(plan_equipment_interest);
            $(event).closest('.PlanLinkMainRow').find('.plan_equipment_grand_total').val(plan_equipment_total.toFixed(2));

            var equipment_perchantage_vat = $(event).closest('.PlanLinkMainRow').find(
                '.plan_equipment_perchantage_vat').val() || 0;
            var plan_equipment_perchantage_vat_amount = Number((plan_equipment_total * equipment_perchantage_vat) / 100)
                .toFixed(2);
            var plan_equipment_vat = plan_equipment_perchantage_vat_amount ? plan_equipment_perchantage_vat_amount :
                0;
            var equipment_perchantage_tax = $(event).closest('.PlanLinkMainRow').find(
                '.plan_equipment_perchantage_tax').val() || 0;

            var plan_equipment_perchantage_tax_amount = Number((plan_equipment_total * equipment_perchantage_tax) / 100)
                .toFixed(
                    2);
            $(event).closest('.PlanLinkMainRow').find('.plan_equipment_tax').val(
                plan_equipment_perchantage_tax_amount);
            var plan_equipment_tax = plan_equipment_perchantage_tax_amount ? plan_equipment_perchantage_tax_amount :
                0;
            $(event).closest('.PlanLinkMainRow').find('.plan_equipment_vat').val(plan_equipment_vat);
            var plan_equipment_invest_total = Number(plan_equipment_total) + Number(plan_equipment_vat) + Number(
                plan_equipment_tax);
            $(event).closest('.PlanLinkMainRow').find('.plan_equipment_total_inv').val(plan_equipment_invest_total.toFixed(
                2));
            var plan_equipment_otc = $(event).closest('.PlanLinkMainRow').find('.plan_equipment_otc').val() || 0;
            var plan_equipment_total_inv = $(event).closest('.PlanLinkMainRow').find('.plan_equipment_total_inv')
                .val() || 0;
            var plan_equipment_month = $('#month').val();
            var plan_equipment_roi = ((Number(plan_equipment_total_inv) - Number(plan_equipment_otc)) /
                Number(
                    plan_equipment_month));
            $(event).closest('.PlanLinkMainRow').find('.plan_equipment_roi').val(plan_equipment_roi.toFixed(2));
            var capacity_total = $(event).closest('.PlanLinkMainRow').find('.plan_equipment_capacity').val() || 0;
            var plan_equipment_operation_cost = $(event).closest('.PlanLinkMainRow').find(
                '.plan_equipment_operation_cost').val() || 0;
            var plan_equipment_operation_cost = plan_equipment_operation_cost ? plan_equipment_operation_cost : 0;
            var plan_equipment_total = Number(capacity_total) + Number(plan_equipment_operation_cost) +
                Number(
                    plan_equipment_roi);
            $(event).closest('.PlanLinkMainRow').find('.plan_equipment_total_mrc').val(plan_equipment_total.toFixed(2));
        }

        //end calculation for link Equipment

        function PlanLinStatusWiseCalculation() {
            let total_mrc = 0;
            let total_otc = 0;
            let total_equipment_investment = 0;
            let total_plan_equipment_otc = 0;
            let client_link_equipment_total = 0;
            const planLinkMainRows = $('.PlanLinkMainRow');

            $('.plan_link_status:checked').each(function() {
                const $this = $(this);
                const plan_link_total_mrc = $this.closest('.PlanLinkMainRow').find(
                    '.plan_equipment_total_mrc').val();
                total_mrc += Number(plan_link_total_mrc);

                total_equipment_investment += Number($this.closest('.PlanLinkMainRow').find(
                    '.plan_equipment_total_inv').val()) || 0;

                total_plan_equipment_otc += Number($this.closest('.PlanLinkMainRow').find(
                    '.plan_equipment_otc').val()) || 0;

                client_link_equipment_total += Number($this.closest('.PlanLinkMainRow').find(
                    '.plan_client_equipment_total').val()) || 0;
            });

            const equipment_grand_total = Number($('#equipment_grand_total').val()) || 0;
            const total_investment = (equipment_grand_total + total_equipment_investment).toFixed(2);
            $('#total_investment').val(total_investment);
            console.log('total_investment', total_investment);
            console.log('error 1');

            const total_equipment_otc = Number($('#equipment_otc').val()) || 0;
            total_otc = (total_plan_equipment_otc + total_equipment_otc).toFixed(2);
            $('#total_otc').val(total_otc);
            console.log('error 2');

            const equipment_roi = Number($('#equipment_roi').val()) || 0;
            const total_service_cost = (total_mrc + equipment_roi).toFixed(2);
            $('#total_service_cost').val(total_service_cost);
            console.log('error 3');

            const total_product_cost = Number($('#total_with_operation_amount').val()) || 0;
            const client_equipment_total = Number($('#client_equipment_total').val()) || 0;
            const total_client_equipment_total = client_equipment_total + client_link_equipment_total;
            $('#total_product_cost').val(total_product_cost);
            console.log('error 4');

            $('#total_mrc').val((Number(total_service_cost) + Number(total_product_cost)).toFixed(2));
            $('#equipment_price_for_client').val(total_client_equipment_total);
            $('#total_otc_with_client_equipment').val((Number(total_otc) + Number(total_client_equipment_total)).toFixed(
                2));
        }

        $('.plan_link_status').click(function() {
            PlanLinStatusWiseCalculation();
        });


        //  Margin Calculation
        $('#management_perchantage').on('keyup', function() {
            var margin = Number($(this).val()) || 0;
            var total_mrc = Number($('#total_mrc').val()) || 0;
            var total_mrc_amount = (total_mrc.toFixed(2) * margin.toFixed(2)) / 100;
            $('#management_cost_amount').val(Number(total_mrc_amount).toFixed(2));

            var product_total_cost = Number($('#product_total_cost').val());
            var management_cost_total = total_mrc + total_mrc_amount;
            $('#management_cost_total').val(Number(management_cost_total).toFixed(2));
            var perchantage = (Number(management_cost_total).toFixed(2) / product_total_cost.toFixed(2)) * 100 -
                100;
            //ok


            $('.product_rate').each(function() {
                var product_rate = Number($(this).val()) || 0;
                var product_rate_perchantage = product_rate * (perchantage / 100);
                var product_margin_rate = (product_rate + product_rate_perchantage);
                $(this).closest('tr').find('.offer_price').val(product_margin_rate.toFixed(2));
                var product_quantity = $(this).closest('tr').find('.product_quantity').val();
                var total_margin_amount = product_margin_rate * product_quantity;
                $(this).closest('tr').find('.product_offer_total').val(total_margin_amount.toFixed(2));

                var vat_perchant = $(this).closest('tr').find('.product_vat').val();
                var vat_amount = (total_margin_amount * vat_perchant) / 100;
                $(this).closest('tr').find('.product_vat_amount').val(vat_amount.toFixed(2));
                var total_vat = total_margin_amount + vat_amount;
                $(this).closest('tr').find('.total_price').val(total_vat.toFixed(2));
            });
            // console.log('error cal 1')
            var product_grand_total = $('.product_offer_total').get()
                .reduce(function(sum, el) {
                    return sum + Number(el.value) || 0;
                }, 0);
            var total_vat = $('.product_vat_amount').get()
                .reduce(function(sum, el) {
                    return sum + Number(el.value) || 0;
                }, 0);
            var grand_total_price = $('.total_price').get()
                .reduce(function(sum, el) {
                    return sum + Number(el.value) || 0;
                }, 0);

            const client_equipment_total = Number($('#client_equipment_total').val());
            console.log('error cal 2')
            //client equipment total
            let plan_client_equipment_total = 0;
            let plan_equipment_otc = 0;

            $('.plan_link_status').each(function() {
                if ($(this).is(':checked')) {
                    plan_client_equipment_total += Number($(this).closest('.PlanLinkMainRow').find(
                        '.plan_client_equipment_total').val()) || 0;
                    plan_equipment_otc += Number($(this).closest('.PlanLinkMainRow').find(
                        '.plan_equipment_otc').val()) || 0;
                }
            });
            console.log('error cal 3')
            let equipment_price_for_client = client_equipment_total + plan_client_equipment_total;
            $('#equipment_price_for_client').val(equipment_price_for_client);
            console.log('error cal 4')
            let equipment_otc = Number($('#equipment_otc').val());
            let total_equipment_otc = equipment_otc + plan_equipment_otc + equipment_price_for_client
            $('#total_otc_with_client_equipment').val(total_equipment_otc);
            $('#product_grand_total').val(product_grand_total.toFixed(2));
            $('#total_vat').val(total_vat.toFixed(2));
            $('#grand_total_price').val(grand_total_price.toFixed(2));
            console.log('error cal 5')
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
