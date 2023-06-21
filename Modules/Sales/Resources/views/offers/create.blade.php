@extends('layouts.backend-layout')
@section('title', 'Offer')

@php
    $is_old = old('client_no') ? true : false;
    $form_heading = !empty($feasibility_requirement->id) ? 'Update' : 'Add';
    $form_url = !empty($feasibility_requirement->id) ? route('feasibility-requirement.update', $feasibility_requirement->id) : route('feasibility-requirement.store');
    $form_method = !empty($feasibility_requirement->id) ? 'PUT' : 'POST';
@endphp

@section('breadcrumb-title')
    {{ ucfirst($form_heading) }} Offer
@endsection

@section('breadcrumb-button')
    <a href="{{ route('feasibility-requirement.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-database"></i></a>
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
                            <input type="date" name="offer_validity" id="offer_validity" class="form-control date"
                                value="{{ $is_old ? old('offer_validity') : $costing->offer_validity ?? null }}"
                                placeholder="Offer Validity" required>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="tableHeading">
                                    <h5> <span> &#10070; </span> FR-1 <span>&#10070;</span> </h5>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <th>Select</th>
                                            <th>Link Type</th>
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
                                        <tbody>
                                            @foreach ($feasibility_requirement->feasibilityRequirementDetails as $details)
                                                @if ($details->costing)
                                                    @foreach ($details->costing->costingLinks as $key => $link)
                                                        <tr class="offer_details_row">
                                                            <td>
                                                                <div class="checkbox-fade fade-in-primary"
                                                                    style="margin-top: 6px;margin-left: 5px;margin-right: 0px;">
                                                                    <label>
                                                                        <input type="checkbox" name="link_no[]"
                                                                            value="Router" class="form-control">
                                                                        <span class="cr">
                                                                            <i
                                                                                class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-sm input-group-primary">
                                                                    <input type="text" name="link_type[]"
                                                                        class="form-control" id="link_type"
                                                                        value="{{ $link->link_type }}" readonly>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-sm input-group-primary">
                                                                    <input type="text" name="existing_or_new[]"
                                                                        class="form-control"
                                                                        value="{{ $link->finalSurveyDetails->planLinks->existing_infrastructure }}"
                                                                        id="existingOrNew" readonly>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-sm input-group-primary">
                                                                    <input type="text" name="method[]"
                                                                        class="form-control"
                                                                        value="{{ $link->finalSurveyDetails->method }}"
                                                                        id="method" readonly>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-sm input-group-primary">
                                                                    <input type="text" name="vendor[]"
                                                                        class="form-control"
                                                                        value="{{ $link->finalSurveyDetails->vendor }}"
                                                                        id="vendor" readonly>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-sm input-group-primary">
                                                                    <input type="text" name="bbts_pop_ldp[]"
                                                                        value="{{ $link->finalSurveyDetails->bbts_pop_ldp }}"
                                                                        class="form-control" id="bbtsOrPopOrLdp" readonly>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-sm input-group-primary">
                                                                    <input type="text" name="distance[]"
                                                                        class="form-control"
                                                                        value="{{ $link->finalSurveyDetails->distance }}"
                                                                        id="distance" readonly>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div
                                                                    class="input-group input-group-sm input-group-primary client_equipment_amount">
                                                                    <input type="text" name="client_equipment_amount[]"
                                                                        value="{{ $link->plan_client_equipment_total }}"
                                                                        class="form-control" id="client_equipment_amount"
                                                                        readonly>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-sm input-group-primary">
                                                                    <input type="text" name="otc[]"
                                                                        value="{{ $link->otc }}" class="form-control"
                                                                        id="otc" readonly>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-sm input-group-primary">
                                                                    <input type="text" name="mo_cost[]"
                                                                        value="{{ $link->roi }}" class="form-control"
                                                                        id="mo_cost" readonly>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div
                                                                    class="input-group input-group-sm input-group-primary offer_otc">
                                                                    <input type="text" name="offer_otc[]"
                                                                        class="form-control" id="offer_otc">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div
                                                                    class="input-group input-group-sm input-group-primary total_cost">
                                                                    <input type="text" name="total_cost[]"
                                                                        class="form-control" id="total_cost" readonly>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div
                                                                    class="input-group input-group-sm input-group-primary offer_mrc">
                                                                    <input type="text" name="offer_mrc[]"
                                                                        class="form-control" id="offer_mrc">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </tbody>

                                        <tr>
                                            <td colspan="7" style="text-align: right;">Link wise Total</td>
                                            <td>
                                                <div
                                                    class="input-group input-group-sm input-group-primary client_equipment_total">
                                                    <input type="text" name="client_equipment_total[]"
                                                        class="form-control" id="client_equipment_total" readonly>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary total_otc">
                                                    <input type="text" name="total_otc[]" class="form-control"
                                                        id="total_otc[]" readonly>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary total_roi">
                                                    <input type="text" name="total_roi" class="form-control"
                                                        id="total_roi" readonly>
                                                </div>
                                            </td>
                                            <td>
                                                <div
                                                    class="input-group input-group-sm input-group-primary total_offer_otc">
                                                    <input type="text" name="total_offer_otc" class="form-control"
                                                        id="total_offer_otc" readonly>
                                                </div>
                                            </td>
                                            <td>
                                                <div
                                                    class="input-group input-group-sm input-group-primary grand_total_otc">
                                                    <input type="text" name="grand_total_otc" class="form-control"
                                                        id="grand_total_otc" readonly>
                                                </div>
                                            </td>
                                            <td>
                                                <div
                                                    class="input-group input-group-sm input-group-primary total_offer_mrc">
                                                    <input type="text" name="total_offer_mrc" class="form-control"
                                                        id="total_offer_mrc" readonly>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="7" style="text-align: right;">Product Equipment</td>
                                            <td>
                                                <div
                                                    class="input-group input-group-sm input-group-primary product_equipment_price">
                                                    <input type="text" name="product_equipment_price"
                                                        class="form-control" id="product_equipment_price" readonly>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="equipment_otc" class="form-control"
                                                        id="equipment_otc" readonly>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="equipment_roi" class="form-control"
                                                        id="equipment_roi" readonly>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="equipment_offer_price"
                                                        class="form-control" id="equipment_offer_price" readonly>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="equipment_total_otc" class="form-control"
                                                        id="equipment_total_otc" readonly>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="equipment_total_mrc" class="form-control"
                                                        id="equipment_total_mrc" readonly>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="7" style="text-align: right;">Product Price</td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="product_amount" class="form-control"
                                                        id="product_price" readonly>
                                                </div>
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="offer_product_amount"
                                                        class="form-control" id="offer_product_amount" readonly>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="7" style="text-align: right;">Management Cost</td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="management_cost" class="form-control"
                                                        id="management_cost" readonly>
                                                </div>
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="offer_management_cost"
                                                        class="form-control" id="offer_management_cost" readonly>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="7" style="text-align: right;">Total Price</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="grand_total" class="form-control"
                                                        id="grand_total" readonly>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <button class="py-2 btn btn-success">
                                    {{ !empty($lead_generation->id) ? 'Update' : 'Save' }}
                                </button>
                            </div>

                        </div>
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
