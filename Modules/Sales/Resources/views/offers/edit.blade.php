@extends('layouts.backend-layout')
@section('title', 'Offer')

@php
    $is_old = old('client_no') ? true : false;
    $form_heading = 'Update';
    $form_url = route('offer.update', $offer->id);
    $form_method = 'PUT';
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
                            $client_name = $is_old ? old('client_name') : $offer->lead_generation->client_name ?? null;
                            $client_no = $is_old ? old('client_name') : $offer->lead_generation->client_no ?? null;
                            $mq_no = $is_old ? old('mq_no') : $offer->mq_no ?? null;
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
                                value="{{ $is_old ? old('offer_validity') : date('d/m/Y', strtotime($offer->offer_validity)) }}"
                                placeholder="Offer Validity" required>

                        </div>
                        @foreach ($offer->offerDetails as $details)
                            @php $row_no++ @endphp
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="tableHeading" style="background-color: #024FA7">
                                        <h5> <span> &#10070; </span> FR NO - {{ $details->fr_no }} <span>&#10070;</span>
                                        </h5>
                                        <input type="hidden" name="fr_no_{{ $row_no }}"
                                            value="{{ $details->fr_no }}">
                                        <input type="hidden" name="row_no" value="{{ $row_no }}">
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <th style="background-color:#057097">Select</th>
                                                <th style="background-color:#057097">Link Type</th>
                                                <th style="background-color:#057097">Option</th>
                                                <th style="background-color:#057097">Existing/New</th>
                                                <th style="background-color:#057097">Method</th>
                                                <th style="background-color:#057097">Vendor</th>
                                                <th style="background-color:#057097">BBTS/POP/LDP</th>
                                                <th style="background-color:#057097">Distance</th>
                                                <th style="background-color:#057097">Client <br> Equipment</th>
                                                <th style="background-color:#057097">OTC</th>
                                                <th style="background-color:#057097">Mo <br> Cost</th>
                                                <th style="background-color:#057097">Offer <br> OTC</th>
                                                <th style="background-color:#057097">Total <br> OTC</th>
                                                <th style="background-color:#057097">Offer <br> MRC</th>
                                            </thead>
                                            <tbody class="mainRow">
                                                @foreach ($details->offerLinks as $key => $link)
                                                    <tr class="offer_details_row">
                                                        <td>
                                                            <div class="checkbox-fade fade-in-primary"
                                                                style="margin-top: 6px;margin-left: 5px;margin-right: 0px;">
                                                                <label>
                                                                    <input type="checkbox"
                                                                        name="link_status_{{ $row_no }}[]"
                                                                        value="{{ $link->link_status }}"
                                                                        @if ($link->link_status == '1') checked @endif
                                                                        class="form-control">

                                                                    <span class="cr">
                                                                        <i
                                                                            class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                            <input type="hidden" name="link_no_{{ $row_no }}[]"
                                                                value="{{ $link->link_no }}">
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
                                                                <input type="text" name="option_{{ $row_no }}[]"
                                                                    class="form-control" value="{{ $link->option }}"
                                                                    id="option" readonly>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group input-group-sm input-group-primary">
                                                                <input type="text"
                                                                    name="existing_or_new_{{ $row_no }}[]"
                                                                    class="form-control"
                                                                    value="{{ $link->existing_or_new }}" id="existingOrNew"
                                                                    readonly>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group input-group-sm input-group-primary">
                                                                <input type="text" name="method_{{ $row_no }}[]"
                                                                    class="form-control" value="{{ $link->method }}"
                                                                    id="method" readonly>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group input-group-sm input-group-primary">
                                                                <input type="text" name="vendor_{{ $row_no }}[]"
                                                                    class="form-control" value="{{ $link->vendor }}"
                                                                    id="vendor" readonly>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group input-group-sm input-group-primary">
                                                                <input type="text"
                                                                    name="bbts_pop_ldp_{{ $row_no }}[]"
                                                                    value="{{ $link->bbts_pop_ldp }}"
                                                                    class="form-control" id="bbtsOrPopOrLdp" readonly>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group input-group-sm input-group-primary">
                                                                <input type="text"
                                                                    name="distance_{{ $row_no }}[]"
                                                                    class="form-control" value="{{ $link->distance }}"
                                                                    id="distance" readonly>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group input-group-sm input-group-primary ">
                                                                <input type="text"
                                                                    name="client_equipment_amount_{{ $row_no }}[]"
                                                                    value="{{ $link->client_equipment_amount }}"
                                                                    class="form-control client_equipment_amount"
                                                                    id="client_equipment_amount" readonly>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group input-group-sm input-group-primary">
                                                                <input type="text" name="otc_{{ $row_no }}[]"
                                                                    value="{{ $link->otc }}"
                                                                    class="form-control text-right" id="otc"
                                                                    readonly>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group input-group-sm input-group-primary">
                                                                <input type="text"
                                                                    name="mo_cost_{{ $row_no }}[]"
                                                                    value="{{ $link->mo_cost }}"
                                                                    class="form-control text-right" id="mo_cost"
                                                                    readonly>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group input-group-sm input-group-primary ">
                                                                <input type="text"
                                                                    name="offer_otc_{{ $row_no }}[]"
                                                                    class="form-control text-right offer_otc"
                                                                    value="{{ $link->offer_otc }}" id="offer_otc">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group input-group-sm input-group-primary">
                                                                <input type="text"
                                                                    name="total_cost_{{ $row_no }}[]"
                                                                    class="form-control text-right total_cost_otc"
                                                                    value="{{ $link->total_cost }}" id="total_cost_otc"
                                                                    readonly>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group input-group-sm input-group-primary">
                                                                <input type="text"
                                                                    name="offer_mrc_{{ $row_no }}[]"
                                                                    value="{{ $link->offer_mrc }}"
                                                                    class="form-control text-right offer_mrc "
                                                                    id="offer_mrc">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                <tr class="text-right">
                                                    <td colspan="6" rowspan="5"></td>
                                                    <td colspan="2" style="text-align: right;">Link wise Total</td>
                                                    <td>
                                                        <div class="input-group input-group-sm input-group-primary">
                                                            <input type="text"
                                                                name="client_equipment_total_{{ $row_no }}"
                                                                class="form-control text-right client_equipment_total"
                                                                id="client_equipment_total"
                                                                value="{{ $details->client_equipment_total }}" readonly>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group input-group-sm input-group-primary">
                                                            <input type="text" name="total_otc_{{ $row_no }}"
                                                                class="form-control text-right total_otc" id="total_otc[]"
                                                                value="{{ $details->total_otc }}" readonly>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group input-group-sm input-group-primary">
                                                            <input type="text" name="total_roi_{{ $row_no }}"
                                                                value="{{ $details->total_roi }}"
                                                                class="form-control text-right total_roi" id="total_roi"
                                                                readonly>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group input-group-sm input-group-primary ">
                                                            <input type="text"
                                                                name="total_offer_otc_{{ $row_no }}"
                                                                value="{{ $details->total_offer_otc }}"
                                                                class="form-control text-right total_offer_otc"
                                                                id="total_offer_otc" readonly>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group input-group-sm input-group-primary">
                                                            <input type="text"
                                                                name="grand_total_otc_{{ $row_no }}"
                                                                value="{{ $details->grand_total_otc }}"
                                                                class="form-control text-right grand_total_otc"
                                                                id="grand_total_otc" readonly>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group input-group-sm input-group-primary">
                                                            <input type="text"
                                                                name="total_offer_mrc_{{ $row_no }}"
                                                                value="{{ $details->total_offer_mrc }}"
                                                                class="form-control text-right total_offer_mrc"
                                                                id="total_offer_mrc" readonly>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2" style="text-align: right;">Product
                                                        Equipment</td>
                                                    <td>
                                                        <div class="input-group input-group-sm input-group-primary">
                                                            <input type="text"
                                                                name="product_equipment_price_{{ $row_no }}"
                                                                class="form-control text-right product_equipment_price"
                                                                id="product_equipment_price"
                                                                value="{{ $details->product_equipment_price }}" readonly>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group input-group-sm input-group-primary">
                                                            <input type="text"
                                                                name="equipment_otc_{{ $row_no }}"
                                                                class="form-control text-right"
                                                                value="{{ $details->equipment_otc }}" id="equipment_otc"
                                                                readonly>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group input-group-sm input-group-primary">
                                                            <input type="text"
                                                                name="equipment_roi_{{ $row_no }}"
                                                                value="{{ $details->equipment_roi }}"
                                                                class="form-control text-right" id="equipment_roi"
                                                                readonly>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group input-group-sm input-group-primary">
                                                            <input type="text"
                                                                name="equipment_offer_price_{{ $row_no }}"
                                                                class="form-control equipment_offer_price text-right"
                                                                value="{{ $details->equipment_offer_price }}"
                                                                id="equipment_offer_price">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group input-group-sm input-group-primary">
                                                            <input type="text"
                                                                name="equipment_total_otc_{{ $row_no }}"
                                                                value="{{ $details->equipment_total_otc }}"
                                                                class="form-control equipment_total_otc text-right"
                                                                id="equipment_total_otc" readonly>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group input-group-sm input-group-primary">
                                                            <input type="text"
                                                                name="equipment_total_mrc_{{ $row_no }}"
                                                                value="{{ $details->equipment_total_mrc }}"
                                                                class="form-control equipment_total_mrc text-right"
                                                                id="equipment_total_mrc">
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2" style="text-align: right;">Product Price
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>
                                                        <div class="input-group input-group-sm input-group-primary">
                                                            <input type="text"
                                                                name="product_amount_{{ $row_no }}"
                                                                class="form-control product_price text-right"
                                                                value="{{ $details->product_amount }}" id="product_price"
                                                                readonly>
                                                        </div>
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>
                                                        <div class="input-group input-group-sm input-group-primary">
                                                            <input type="text"
                                                                name="offer_product_amount_{{ $row_no }}"
                                                                value="{{ $details->offer_product_amount }}"
                                                                class="form-control offer_product_amount text-right"
                                                                id="offer_product_amount">
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2" style="text-align: right;">Management Cost
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="text-right">
                                                        <div class="input-group input-group-sm input-group-primary">
                                                            <input type="text"
                                                                name="management_cost_{{ $row_no }}"
                                                                class="form-control management_cost text-right"
                                                                value="{{ $details->management_cost }}"
                                                                id="management_cost" readonly>
                                                        </div>
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="text-right">
                                                        <div class="input-group input-group-sm input-group-primary">
                                                            <input type="text"
                                                                name="offer_management_cost_{{ $row_no }}"
                                                                value="{{ $details->offer_management_cost }} "
                                                                class="form-control offer_management_cost text-right"
                                                                id="offer_management_cost" readonly>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2" style="text-align: right;">Total Price</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="text-right">
                                                        <div class="input-group input-group-sm input-group-primary">
                                                            <input type="text" name="grand_total_{{ $row_no }}"
                                                                value="{{ $details->grand_total }}"
                                                                class="form-control grand_total text-right"
                                                                id="grand_total" readonly>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <button class="py-2 btn btn-success">
                                        Update
                                    </button>
                                </div>

                            </div>
                        @endforeach
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
