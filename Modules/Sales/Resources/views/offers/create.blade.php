@extends('layouts.backend-layout')
@section('title', 'Offer')

@php
    $is_old = old('client_no') ? true : false;
    $form_heading = !empty($offer->id) ? 'Update' : 'Add';
    $form_url = !empty($offer->id) ? route('offer.update', $offer->id) : route('offer.store');
    $form_method = !empty($offer->id) ? 'PUT' : 'POST';
@endphp

@section('breadcrumb-title')
    {{ ucfirst($form_heading) }} Offer
@endsection

@section('breadcrumb-button')
    <a href="{{ route('offers.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')

    {!! Form::open([
        'url' => $form_url,
        'method' => $form_method,
        'encType' => 'multipart/form-data',
        'class' => 'custom-form',
    ]) !!}

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="tableHeading">
                    <h5> <span> &#10070; </span> Offer <span>&#10070;</span> </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @php
                            $client_name = $is_old ? old('client_name') : $feasibility_requirement->lead_generation->client_name ?? null;
                            $client_no = $is_old ? old('client_name') : $feasibility_requirement->client_no ?? null;
                            $mq_no = $is_old ? old('mq_no') : $feasibility_requirement->mq_no ?? null;
                            $row_no = 0;
                            
                        @endphp
                        <div class="col-md-3 col-3">
                            <input type="text" name="client_no" id="client_no" class="form-control"
                                value="{{ $client_no }}" placeholder="Client No" readonly>
                        </div>
                        <div class="col-md-3 col-3">
                            <input type="text" name="mq_no" id="mq_no" class="form-control"
                                value="{{ $mq_no }}" placeholder="MQ No" readonly>
                        </div>
                        <x-input-box colGrid="3" name="client_name" value="{{ $client_name }}" label="Client Name" />
                        <div class="col-md-3 col-3">
                            <input type="text" name="offer_validity" id="offer_validity" class="form-control date"
                                value="{{ $is_old ? old('offer_validity') : $costing->offer_validity ?? null }}"
                                placeholder="Offer Validity" required>

                        </div>
                        @foreach ($feasibility_requirement->feasibilityRequirementDetails as $details)
                            @php $row_no++ @endphp
                            @if ($details->costing)
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="tableHeading">
                                            <h5> <span> &#10070; </span> FR NO - {{ $details->fr_no }} <span>&#10070;</span>
                                            </h5>
                                            <input type="hidden" name="fr_no_{{ $row_no }}"
                                                value="{{ $details->fr_no }}">
                                            <input type="hidden" name="row_no" value="{{ $row_no }}">
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <th>Select</th>
                                                    <th>Link Type</th>
                                                    <th>Option</th>
                                                    <th>Existing/New</th>
                                                    <th>Method</th>
                                                    <th>Vendor</th>
                                                    <th>BBTS/POP/LDP</th>
                                                    <th>Distance</th>
                                                    <th>Client <br> Equipment</th>
                                                    <th>OTC</th>
                                                    <th>Mo <br> Cost</th>
                                                    <th>Offer <br> OTC</th>
                                                    <th>Total <br> OTC</th>
                                                    <th>Offer <br> MRC</th>
                                                </thead>

                                                @foreach ($details->costing->costingLinks as $key => $link)
                                                    <tbody class="mainRow">
                                                        <tr class="offer_details_row">
                                                            <td>
                                                                <div class="checkbox-fade fade-in-primary"
                                                                    style="margin-top: 6px;margin-left: 5px;margin-right: 0px;">
                                                                    <label>
                                                                        <input type="checkbox"
                                                                            name="link_status_{{ $row_no }}[]"
                                                                            value="1" class="form-control">

                                                                        <span class="cr">
                                                                            <i
                                                                                class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                                <input type="hidden" name="link_no_{{ $row_no }}[]"
                                                                    value="{{ $link->finalSurveyDetails->link_no }}">
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-sm input-group-primary">
                                                                    <input type="text"
                                                                        name="link_type_{{ $row_no }}[]"
                                                                        class="form-control" id="link_type"
                                                                        value="{{ $link->link_type }}" readonly>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-sm input-group-primary">
                                                                    <input type="text"
                                                                        name="option_{{ $row_no }}[]"
                                                                        class="form-control" value="{{ $link->option }}"
                                                                        id="option" readonly>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-sm input-group-primary">
                                                                    <input type="text"
                                                                        name="existing_or_new_{{ $row_no }}[]"
                                                                        class="form-control"
                                                                        value="{{ $link->finalSurveyDetails->planLinks->existing_infrastructure }}"
                                                                        id="existingOrNew" readonly>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-sm input-group-primary">
                                                                    <input type="text"
                                                                        name="method_{{ $row_no }}[]"
                                                                        class="form-control"
                                                                        value="{{ $link->finalSurveyDetails->method }}"
                                                                        id="method" readonly>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-sm input-group-primary">
                                                                    <input type="text"
                                                                        name="vendor_{{ $row_no }}[]"
                                                                        class="form-control"
                                                                        value="{{ $link->finalSurveyDetails->vendor }}"
                                                                        id="vendor" readonly>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-sm input-group-primary">
                                                                    <input type="text"
                                                                        name="bbts_pop_ldp_{{ $row_no }}[]"
                                                                        value="{{ $link->finalSurveyDetails->bbts_pop_ldp }}"
                                                                        class="form-control" id="bbtsOrPopOrLdp" readonly>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-sm input-group-primary">
                                                                    <input type="text"
                                                                        name="distance_{{ $row_no }}[]"
                                                                        class="form-control"
                                                                        value="{{ $link->finalSurveyDetails->distance }}"
                                                                        id="distance" readonly>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div
                                                                    class="input-group input-group-sm input-group-primary ">
                                                                    <input type="text"
                                                                        name="client_equipment_amount_{{ $row_no }}[]"
                                                                        value="{{ $link->plan_client_equipment_total }}"
                                                                        class="form-control client_equipment_amount"
                                                                        id="client_equipment_amount" readonly>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div
                                                                    class="input-group input-group-sm input-group-primary">
                                                                    <input type="text"
                                                                        name="otc_{{ $row_no }}[]"
                                                                        value="{{ $link->otc }}" class="form-control"
                                                                        id="otc" readonly>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div
                                                                    class="input-group input-group-sm input-group-primary">
                                                                    <input type="text"
                                                                        name="mo_cost_{{ $row_no }}[]"
                                                                        value="{{ $link->roi }}" class="form-control"
                                                                        id="mo_cost" readonly>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div
                                                                    class="input-group input-group-sm input-group-primary ">
                                                                    <input type="text"
                                                                        name="offer_otc_{{ $row_no }}[]"
                                                                        class="form-control offer_otc" id="offer_otc">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div
                                                                    class="input-group input-group-sm input-group-primary">
                                                                    <input type="text"
                                                                        name="total_cost_{{ $row_no }}[]"
                                                                        class="form-control total_cost_otc"
                                                                        id="total_cost_otc" readonly>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div
                                                                    class="input-group input-group-sm input-group-primary">
                                                                    <input type="text"
                                                                        name="offer_mrc_{{ $row_no }}[]"
                                                                        class="form-control offer_mrc" id="offer_mrc">
                                                                </div>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td colspan="8" style="text-align: right;">Link wise Total
                                                            </td>
                                                            <td>
                                                                <div
                                                                    class="input-group input-group-sm input-group-primary">
                                                                    <input type="text"
                                                                        name="client_equipment_total_{{ $row_no }}"
                                                                        class="form-control client_equipment_total"
                                                                        id="client_equipment_total"
                                                                        value="{{ $details->costing->costingLinks->sum('plan_client_equipment_total') }}"
                                                                        readonly>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div
                                                                    class="input-group input-group-sm input-group-primary">
                                                                    <input type="text"
                                                                        name="total_otc_{{ $row_no }}"
                                                                        class="form-control total_otc" id="total_otc[]"
                                                                        value="{{ $details->costing->costingLinks->sum('otc') }}"
                                                                        readonly>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div
                                                                    class="input-group input-group-sm input-group-primary">
                                                                    <input type="text"
                                                                        name="total_roi_{{ $row_no }}"
                                                                        value="{{ $details->costing->costingLinks->sum('roi') }}"
                                                                        class="form-control total_roi" id="total_roi"
                                                                        readonly>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div
                                                                    class="input-group input-group-sm input-group-primary ">
                                                                    <input type="text"
                                                                        name="total_offer_otc_{{ $row_no }}"
                                                                        class="form-control total_offer_otc"
                                                                        id="total_offer_otc" readonly>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div
                                                                    class="input-group input-group-sm input-group-primary">
                                                                    <input type="text"
                                                                        name="grand_total_otc_{{ $row_no }}"
                                                                        class="form-control grand_total_otc"
                                                                        id="grand_total_otc" readonly>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div
                                                                    class="input-group input-group-sm input-group-primary">
                                                                    <input type="text"
                                                                        name="total_offer_mrc_{{ $row_no }}"
                                                                        class="form-control total_offer_mrc"
                                                                        id="total_offer_mrc" readonly>
                                                                </div>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td colspan="8" style="text-align: right;">Product
                                                                Equipment</td>
                                                            <td>
                                                                <div
                                                                    class="input-group input-group-sm input-group-primary">
                                                                    <input type="text"
                                                                        name="product_equipment_price_{{ $row_no }}"
                                                                        class="form-control product_equipment_price"
                                                                        id="product_equipment_price"
                                                                        value="{{ $details->costing->client_equipment_total }}"
                                                                        readonly>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div
                                                                    class="input-group input-group-sm input-group-primary">
                                                                    <input type="text"
                                                                        name="equipment_otc_{{ $row_no }}"
                                                                        class="form-control"
                                                                        value="{{ $details->costing->equipment_otc }}"
                                                                        id="equipment_otc" readonly>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div
                                                                    class="input-group input-group-sm input-group-primary">
                                                                    <input type="text"
                                                                        name="equipment_roi_{{ $row_no }}"
                                                                        value="{{ $details->costing->equipment_roi }}"
                                                                        class="form-control" id="equipment_roi" readonly>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div
                                                                    class="input-group input-group-sm input-group-primary">
                                                                    <input type="text"
                                                                        name="equipment_offer_price_{{ $row_no }}"
                                                                        class="form-control equipment_offer_price"
                                                                        id="equipment_offer_price">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div
                                                                    class="input-group input-group-sm input-group-primary">
                                                                    <input type="text"
                                                                        name="equipment_total_otc_{{ $row_no }}"
                                                                        class="form-control equipment_total_otc"
                                                                        id="equipment_total_otc" readonly>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div
                                                                    class="input-group input-group-sm input-group-primary">
                                                                    <input type="text"
                                                                        name="equipment_total_mrc_{{ $row_no }}"
                                                                        class="form-control equipment_total_mrc"
                                                                        id="equipment_total_mrc">
                                                                </div>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td colspan="8" style="text-align: right;">Product Price
                                                            </td>
                                                            <td></td>
                                                            <td></td>
                                                            <td>
                                                                <div
                                                                    class="input-group input-group-sm input-group-primary">
                                                                    <input type="text"
                                                                        name="product_amount_{{ $row_no }}"
                                                                        class="form-control product_price"
                                                                        value="{{ $details->costing->total_cost_amount }}"
                                                                        id="product_price" readonly>
                                                                </div>
                                                            </td>
                                                            <td></td>
                                                            <td></td>
                                                            <td>
                                                                <div
                                                                    class="input-group input-group-sm input-group-primary">
                                                                    <input type="text"
                                                                        name="offer_product_amount_{{ $row_no }}"
                                                                        class="form-control offer_product_amount"
                                                                        id="offer_product_amount">
                                                                </div>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td colspan="8" style="text-align: right;">Management Cost
                                                            </td>
                                                            <td></td>
                                                            <td></td>
                                                            <td>
                                                                <div
                                                                    class="input-group input-group-sm input-group-primary">
                                                                    <input type="text"
                                                                        name="management_cost_{{ $row_no }}"
                                                                        class="form-control management_cost"
                                                                        value="{{ $details->costing->management_cost_amount }}"
                                                                        id="management_cost" readonly>
                                                                </div>
                                                            </td>
                                                            <td></td>
                                                            <td></td>
                                                            <td>
                                                                <div
                                                                    class="input-group input-group-sm input-group-primary">
                                                                    <input type="text"
                                                                        name="offer_management_cost_{{ $row_no }}"
                                                                        value="{{ $details->costing->management_cost_amount }} "
                                                                        class="form-control offer_management_cost"
                                                                        id="offer_management_cost" readonly>
                                                                </div>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td colspan="8" style="text-align: right;">Total Price</td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td>
                                                                <div
                                                                    class="input-group input-group-sm input-group-primary">
                                                                    <input type="text"
                                                                        name="grand_total_{{ $row_no }}"
                                                                        class="form-control grand_total" id="grand_total"
                                                                        readonly>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                @endforeach

                                            </table>
                                        </div>

                                    </div>

                                </div>
                            @endif
                        @endforeach
                        <button class="py-2 btn btn-success">
                            {{ !empty($lead_generation->id) ? 'Update' : 'Save' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

@endsection
@section('script')
    @include('sales::offers.js')
@endsection
