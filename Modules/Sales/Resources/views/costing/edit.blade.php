@extends('layouts.backend-layout')
@section('title', 'consting')

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
            <div class="row">
                <div class="md-col-12 col-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th colspan="11">Product Costing</th>
                                </tr>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Rate</th>
                                    <th>Unit</th>
                                    <th>Amount</th>
                                    <th>Vat(%)</th>
                                    <th>Vat Amount</th>
                                    <th>Operation Cost</th>
                                    <th>Total Amount</th>
                                    <th>Price </th>
                                    <th>Total Price</th>
                                </tr>
                            </thead>
                            <tbody class="productBody">
                                @foreach ($costing->costingProducts as $costing_product)
                                    <tr class="product_details_row">
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
                                                <input type="number" name="product_vat[]"
                                                    class="form-control form-control-sm input product_vat" placeholder="Vat"
                                                    value="{{ $costing_product->product_vat }}">
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
                                                <input type="number" name="product_operation_cost[]"
                                                    class="form-control form-control-sm input product_operation_cost"
                                                    placeholder="Total" value="{{ $costing_product->operation_cost }}">
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
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <span>
                                            <input type="number" name="total_operation_cost" id="total_operation_cost"
                                                class="form-control form-control-sm input" placeholder="Total Cost"
                                                value="{{ $costing->total_operation_cost }}" readonly>
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
                                        <td>
                                            <span>
                                                <input type="text" name="material[]" id="material"
                                                    class="form-control form-control-sm input" placeholder="Link Type"
                                                    value="{{ $product_equipment->material->name ?? '' }}" readonly>
                                                <input type="hidden" name="material_id[]" id="material_id "
                                                    class="form-control form-control-sm input" placeholder="Link Type"
                                                    value="{{ $product_equipment->material->id ?? '' }}" readonly>
                                            </span>
                                        </td>
                                        <td>
                                            <span>
                                                <input type="number" name="equipment_quantity[]"
                                                    class="form-control form-control-sm input equipment_quantity"
                                                    placeholder="Quantity" value="{{ $product_equipment->quantity }}"
                                                    readonly>
                                            </span>
                                        </td>
                                        <td>
                                            <span>
                                                <input type="text" name="equipment_unit[]"
                                                    class="form-control form-control-sm input equipment_unit"
                                                    placeholder="Unit" value="{{ $product_equipment->unit }}" readonly>
                                            </span>
                                        </td>
                                        <td>
                                            <select name="equipment_ownership[]"
                                                class="form-control form-control-sm input equipment_ownership">
                                                <option value="BBTS" @if ($product_equipment->ownership == 'BBTS') selected @endif>
                                                    BBTS</option>
                                                <option value="Client" @if ($product_equipment->ownership == 'Client') selected @endif>
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
                                    <td colspan="5" class="text-right" style="font-size: 14px;">Equipment Total</td>
                                    <td>
                                        <span>
                                            <input type="number" name="equipment_wise_total" id="equipment_wise_total"
                                                class="form-control form-control-sm input" placeholder="Total Amount"
                                                value="{{ $costing->equipment_wise_total }}" readonly>
                                        </span>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="5" class="text-right" style="font-size: 14px;">Client Equipment Total
                                    </td>
                                    <td>
                                        <span>
                                            <input type="number" name="client_equipment_total"
                                                id="client_equipment_total" class="form-control form-control-sm input"
                                                placeholder="Total Amount" value="{{ $costing->client_equipment_total }}"
                                                </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right" style="font-size: 14px;">Partial Total</td>
                                    <td>
                                        <span>
                                            <input type="number" name="equipment_partial_total"
                                                id="equipment_partial_total" class="form-control form-control-sm input"
                                                placeholder="Total Amount"
                                                value="{{ $costing->equipment_partial_total }}" </span>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="5" class="text-right" style="font-size: 14px;">Deployment Cost</td>
                                    <td>
                                        <span>
                                            <input type="number" name="equipment_deployment_cost"
                                                id="equipment_deployment_cost" class="form-control form-control-sm input"
                                                placeholder="Deployment Cost"
                                                value="{{ $costing->equipment_deployment_cost }}" </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right" style="font-size: 14px;">Interest</td>
                                    <td>
                                        <span>
                                            <input type="number" name="equipment_interest" id="equipment_interest"
                                                class="form-control form-control-sm input" placeholder="Interest"
                                                value="{{ $costing->equipment_interest }}" readonly>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right" style="font-size: 14px;">VAT</td>
                                    <td>
                                        <span>
                                            <input type="number" name="equipment_vat" id="equipment_vat"
                                                class="form-control form-control-sm input" placeholder="VAT"
                                                value="{{ $costing->equipment_vat }}">
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right" style="font-size: 14px;">Tax</td>
                                    <td>
                                        <span>
                                            <input type="number" name="equipment_tax" id="equipment_tax"
                                                class="form-control form-control-sm input" placeholder="Tax"
                                                value="{{ $costing->equipment_tax }}">
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right" style="font-size: 14px;">Total</td>
                                    <td>
                                        <span>
                                            <input type="number" name="equipment_grand_total" id="equipment_grand_total"
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
            </div>
            <hr />
            <div class="text-center">
                <h5> <span> &#10070; </span> Link Details <span>&#10070;</span> </h5>
            </div>
            <hr />
            @foreach ($costing->costingLinks as $key => $costing_link)
                @php $row_no = $key + 1; @endphp
                <input type="hidden" name="total_key" value="{{ $row_no }}">
                <div class="PlanLinkMainRow"
                    style="border: 2px solid gray; border-radius: 15px; padding: 15px; margin-top: 15px;">
                    <div class="row">
                        <div class="col-1 col-md-1">
                            <div class="checkbox-fade fade-in-primary">
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
                        <div class="col-2 col-md-2">
                            <div class="form-item">
                                <input type="text" name="link_type_{{ $row_no }}"
                                    class="form-control form-control-sm link_type input" placeholder="Link Name"
                                    value="{{ $costing_link->link_type }}" readonly>
                                <label for="link_type">Link Type</label>
                            </div>
                        </div>
                        <div class="col-2 col-md-2">
                            <div class="form-item">
                                <input type="text" name="option_{{ $row_no }}"
                                    class="form-control form-control-sm  plan_link_option input" placeholder="Link Type"
                                    value="{{ $costing_link->option }}" readonly>
                                <label for="plan_link_option">Option</label>
                            </div>
                        </div>
                        <div class="col-2 col-md-2">
                            <div class="form-item">
                                <input type="text" name="capacity_{{ $row_no }}"
                                    class="form-control form-control-sm  plan_link_capacity input" placeholder="Capacity"
                                    value="{{ $costing_link->transmission_capacity }}" readonly>
                                <label for="plan_link_capacity">Capacity</label>
                            </div>
                        </div>
                        <div class="col-2 col-md-2">
                            <div class="form-item">
                                <input type="text" name="quantity_{{ $row_no }}"
                                    class="form-control form-control-sm  plan_link_quantity input" placeholder="Quantity"
                                    value="{{ $costing_link->quantity }}" readonly>
                                <label for="plan_link_quantity">Quantity</label>
                            </div>
                        </div>
                        <div class="col-1 col-md-1">
                            <div class="form-item">
                                <input type="text" name="rate_{{ $row_no }}"
                                    class="form-control form-control-sm  plan_link_rate input" placeholder="Rate"
                                    value="{{ $costing_link->rate }}" readonly>
                                <label for="plan_link_rate">Rate</label>
                            </div>
                        </div>
                        <div class="col-2 col-md-2">
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
                                        <input type="number" name="plan_equipment_interest_{{ $row_no }}"
                                            id="plan_equipment_interest"
                                            class="form-control form-control-sm plan_equipment_interest input"
                                            placeholder="Interest" value="{{ $costing_link->interest }}">
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
                                        <input type="number" name="plan_equipment_vat_{{ $row_no }}"
                                            id="plan_equipment_vat"
                                            class="form-control form-control-sm plan_equipment_vat input"
                                            placeholder="VAT" value="{{ $costing_link->vat }}">
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
                                        <input type="number" name="plan_equipment_tax_{{ $row_no }}"
                                            id="plan_equipment_tax"
                                            class="form-control form-control-sm plan_equipment_tax input"
                                            placeholder="Tax" value="{{ $costing_link->tax }}">
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
                                    <input type="number" name="total_investment" id="total_investment"
                                        class="form-control form-control-sm text-center plan_fr_total_investment input"
                                        placeholder="Total Investment" value="{{ $costing->total_investment }}" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <span style="font-size:14px;">Total OTC</span>
                                </td>
                                <td colspan="2">
                                    <input type="number" name="total_otc" id="total_otc"
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
                                        class="form-control form-control-sm text-center total_service_cost input"
                                        placeholder="Total Service Cost" value="{{ $costing->total_service_cost }}"
                                        </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <span style="font-size:14px;">Total MRC</span>
                                </td>
                                <td colspan="2">
                                    <input type="number" name="total_mrc" id="total_mrc"
                                        class="form-control form-control-sm text-center total_mrc input"
                                        placeholder="Total MRC" value="{{ $costing->total_mrc }}" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span style="font-size:14px;">Margin</span>
                                </td>
                                <td>
                                    <input type="number" name="management_perchantage" id="management_perchantage"
                                        class="form-control form-control-sm text-center margin input" placeholder="Margin"
                                        value="{{ $costing->management_perchantage }}">
                                </td>
                                <td>
                                    <input type="number" name="management_cost_amount" id="management_cost_amount"
                                        class="form-control form-control-sm text-center management_cost_amount input"
                                        placeholder="Margin Amount" value="{{ $costing->management_cost_amount }}" </td>
                                <td>
                                    <input type="number" name="management_cost_total" id="management_cost_total"
                                        class="form-control form-control-sm text-center management_cost_total input"
                                        placeholder="Margin Amount" value="{{ $costing->management_cost_total }}" </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <span style="font-size:14px;">Equipment Price for Client</span>
                                </td>
                                <td colspan="2">
                                    <input type="number" name="equipment_price_for_client"
                                        id="equipment_price_for_client"
                                        class="form-control form-control-sm text-center equipment_price_for_client input"
                                        placeholder="Equipment Price for Client"
                                        value="{{ $costing->equipment_price_for_client }}" </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <span style="font-size:14px;">Total OTC</span>
                                </td>
                                <td colspan="2">
                                    <input type="number" name="total_otc_with_client_equipment"
                                        id="total_otc_with_client_equipment"
                                        class="form-control form-control-sm text-center total_otc_with_client_equipment input"
                                        placeholder="Total OTC" value="{{ $costing->total_otc_with_client_equipment }}"
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
            var vat_perchant = $(this).closest('tr').find('.product_vat').val();
            var vat_amount = (product_total * vat_perchant) / 100;
            $(this).closest('tr').find('.product_vat_amount').val(vat_amount);
            productPartialTotal();
        });

        $('.product_operation_cost').on('keyup', function() {
            var product_operation_cost = $(this).val();
            var product_price = $(this).closest('tr').find('.product_price').val();
            var vat_amount = $(this).closest('tr').find('.product_vat_amount').val();
            var product_total = parseInt(product_operation_cost) + parseInt(product_price) + parseInt(vat_amount);
            $(this).closest('tr').find('.product_operation_cost_total').val(product_total);
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

        }

        $('.equipment_rate').on('keyup', function() {
            var equipment_rate = $(this).val();
            var equipment_quantity = $(this).closest('tr').find('.equipment_quantity').val();
            var equipment_total = parseInt(equipment_rate) * parseInt(equipment_quantity);
            $(this).closest('tr').find('.equipment_total').val(equipment_total);
            equipmentPartialTotal();
        });

        $('#equipment_deployment_cost, #equipment_interest, #equipment_vat, #equipment_tax').on('keyup', function() {
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
            var interest = $('#equipment_interest').val() ? $('#equipment_interest').val() : 0;
            var vat = $('#equipment_vat').val() ? $('#equipment_vat').val() : 0;
            var tax = $('#equipment_tax').val() ? $('#equipment_tax').val() : 0;
            var total = parseInt(partial_total) + parseInt(development_cost) + parseInt(interest) + parseInt(
                vat) + parseInt(tax);
            $('#equipment_grand_total').val(total);
        }

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

        $('.plan_equipment_deployment_cost, .plan_equipment_interest, .plan_equipment_vat, .plan_equipment_tax').on('keyup',
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
            var equipment_interest = $(event).closest('.PlanLinkMainRow').find('.plan_equipment_interest').val();
            var plan_equipment_interest = equipment_interest ? equipment_interest : 0;
            var plan_equipment_total = parseInt(plan_equipment_partial_total) + parseInt(plan_equipment_deployment_cost) +
                parseInt(plan_equipment_interest);
            $(event).closest('.PlanLinkMainRow').find('.plan_equipment_grand_total').val(plan_equipment_total);
        }


        $('.plan_equipment_vat, .plan_equipment_tax').on('keyup', function() {
            var event = this;
            planEquipmentPartialTotal(event);
            planEquipmentInvestTotal(event);
            calculatePlanEquipmentROI(event)

        });

        function planEquipmentInvestTotal(event) {
            var plan_equipment_grand_total = $(event).closest('.PlanLinkMainRow').find('.plan_equipment_grand_total').val();
            var equipment_vat = $(event).closest('.PlanLinkMainRow').find('.plan_equipment_vat').val();
            var plan_equipment_vat = equipment_vat ? equipment_vat : 0;
            var equipment_tax = $(event).closest('.PlanLinkMainRow').find('.plan_equipment_tax').val();
            var plan_equipment_tax = equipment_tax ? equipment_tax : 0;
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
            var plan_equipment_roi = (parseInt(plan_equipment_total_inv) - parseInt(plan_equipment_otc)) / parseInt(
                plan_equipment_month);
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
            const $planLinkMainRows = $('.PlanLinkMainRow');

            $('.plan_link_status:checked').each(function() {
                const $this = $(this);
                const plan_link_total_mrc = parseInt($this.closest('.PlanLinkMainRow').find(
                    '.plan_equipment_total_mrc').val()) || 0;
                total_mrc += plan_link_total_mrc;

                total_equipment_investment += parseInt($this.closest('.PlanLinkMainRow').find(
                    '.plan_equipment_total_inv').val()) || 0;

                total_plan_equipment_otc = parseInt($this.closest('.PlanLinkMainRow').find(
                    '.plan_equipment_otc').val()) || 0;

            });

            $('#total_mrc').val(total_mrc);
            const equipment_grand_total = parseInt($('#equipment_grand_total').val());
            const total_investment = equipment_grand_total + total_equipment_investment;
            $('#total_investment').val(total_investment);
            const total_equipment_otc = parseInt($('#equipment_otc').val()) || 0;
            total_otc = total_plan_equipment_otc + total_equipment_otc;
            $('#total_otc').val(total_otc);
            const equipment_roi = parseInt($('#equipment_roi').val()) || 0;
            const total_service_cost = total_mrc + equipment_roi;
            $('#total_service_cost').val(total_service_cost);

            const total_product_cost = parseInt($('#total_with_operation_amount').val()) || 0;
            $('#total_product_cost').val(total_product_cost);
        });


        //  Margin Calculation
        $('#management_perchantage').on('keyup', function() {
            var margin = $(this).val();
            var total_mrc = parseFloat($('#total_mrc').val());
            var total_mrc_amount = total_mrc * margin / 100;
            $('#management_cost_amount').val(total_mrc_amount);
            var management_cost_total = total_mrc + total_mrc_amount;
            $('#management_cost_total').val(management_cost_total);
            var product_total_cost = parseFloat($('#total_product_cost').val());
            var perchantage = (management_cost_total / product_total_cost) * 100 - 100;
            $('.product_rate').each(function() {
                var product_rate = parseFloat($(this).val());
                var product_rate_perchantage = product_rate.toFixed(2) * perchantage / 100;
                var product_margin_rate = (product_rate + product_rate_perchantage).toFixed(2);
                $(this).closest('tr').find('.offer_price').val(product_margin_rate);
                var total_margin_amount = product_margin_rate * parseFloat($(this).closest('tr').find(
                    '.product_quantity').val());
                $(this).closest('tr').find('.product_offer_total').val(total_margin_amount.toFixed(2));
            });
            var product_grand_total = $('.product_offer_total').get()
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
