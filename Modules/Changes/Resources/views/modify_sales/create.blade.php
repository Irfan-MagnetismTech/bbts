@extends('layouts.backend-layout')
@section('title', 'Sales')

@php
    $is_old = old('client_no') ? true : false;
    $form_heading = !empty($sale->id) ? 'Update' : 'Add';
    $form_url = !empty($sale->id) ? route('sales-modification.update', $sale->id) : route('sales-modification.store');
    $form_method = !empty($sale->id) ? 'PUT' : 'POST';
@endphp

@section('breadcrumb-title')
    {{ ucfirst($form_heading) }} Sale Modification
@endsection

@section('breadcrumb-button')
    <a href="{{ route('sales-modification.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
    <style>
        /* #calculation_table.table-bordered td, .table-bordered th{
                                                                                                                                                                                                                                border: 1px solid gainsboro!important;
                                                                                                                                                                                                                            } */
        #dv {
            background-color: #f6f9f9 !important;
            color: #191818 !important;
            height: 100% !important;
        }

        .btn.btn-icon {
            border-radius: 50% !important;
            width: 25px !important;
            line-height: 20px !important;
            height: 25px !important;
            padding: 0px !important;
            text-align: center !important;
        }

        .day_td {
            cursor: pointer;
            padding: 5px;
            border: 1px solid yellowgreen;
        }

        .day_td:hover {
            color: blue;
            background-color: yellow;
        }

        .box {
            position: absolute;
            width: 30px;
            height: 30px;
            left: -1000px;
        }

        .container {
            position: relative;
        }

        .custom-form .input-group-addon-manual {
            min-width: 22px !important;
            max-width: 22px !important;
            background-color: #007af5 !important;
            padding-left: 4px !important;
            padding-right: 4px !important;
            color: white;
            font-weight: 500;
        }

        .bg-secondary {
            background-color: #e5f0fc !important;
        }
    </style>

    {!! Form::open([
        'url' => $form_url,
        'method' => $form_method,
        'encType' => 'multipart/form-data',
        'class' => 'custom-form',
    ]) !!}

    <div class="row pt-5" id="dv">
        <div class="col-md-12">
            <div class="card">
                <div class="tableHeading">
                    <h5> <span> &#10070; </span> Sale Modification <span>&#10070;</span> </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @php
                            $client_name = $is_old ? old('client_name') : $costing->client->client_name ?? null;
                            $client_id = $is_old ? old('client_id') : $costing->client->id ?? null;
                            $client_no = $is_old ? old('client_no') : $costing->client_no ?? null;
                            $fr_no = $is_old ? old('fr_no') : $costing->fr_no ?? null;
                            $effective_date = $is_old ? old('effective_date') : null;
                            $account_holder = $is_old ? old('account_holder') : null;
                            $employee_id = $is_old ? old('employee_id') : null;
                            $remarks = $is_old ? old('remarks') : null;
                            $contract_duration = $is_old ? old('contract_duration') : $sale->contract_duration ?? null;
                            $sla = $is_old ? old('sla') : $sale->sla ?? null;
                            $grand_total = $is_old ? old('grand_total') : 0;
                        @endphp
                        <x-input-box colGrid="4" name="client_name" value="{{ $client_name }}" label="Client Name" />
                        <x-input-box colGrid="4" name="client_no" value="{{ $client_no }}" label="Client Id" />
                        <x-input-box colGrid="4" name="account_holder" value="{{ $account_holder }}"
                            label="Account Holder" />
                        <input type="hidden" id="employee_id" name="employee_id" value="{{ $employee_id }}">
                        <x-input-box colGrid="4" name="fr_no" value="{{ $fr_no }}" label="FR No" />
                        <x-input-box colGrid="4" name="remarks" value="{{ $remarks }}" label="Remarks" />
                        <x-input-box colGrid="4" name="contract_duration" value="{{ $contract_duration }}"
                            label="Contract Duration" />
                        <x-input-box colGrid="4" name="effective_date" class="date" value="{{ $effective_date }}"
                            label="Effective Date" />
                        <x-input-box colGrid="4" type="file" name="sla" label="SLA" value="" />
                    </div>
                </div>
            </div>
            <div id='fr_details'>
                @if (isset($costing))
                    @php
                        $offer_mrc = $costing->total_mrc ?? 0;
                        $product_amount = $costing->total_product_cost ?? 0;
                        $management_cost = $costing->management_cost_amount ?? 0;
                        $total_mrc = $offer_mrc + $product_amount + $management_cost + $costing->equipment_total_mrc ?? 0;
                    @endphp
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3">
                                    <div class="checkbox-fade fade-in-primary">
                                        <label>
                                            <input type="checkbox" class="checkbox" value="Primary" name="checked[${indx}]">
                                            <span class="cr">
                                                <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                            </span>
                                            <span>{{ $costing->feasibilityRequirementDetail->connectivity_point }} -
                                                ({{ $costing->fr_no }})</span>
                                            <input type="hidden" class="fr_no" name="fr_no"
                                                value="{{ $costing->fr_no }}">
                                            <input type="hidden" class="costing_id" name="costing_id"
                                                value="{{ $costing->id }}">
                                        </label>
                                    </div>
                                </div>
                                <div class="col-9">
                                    @foreach ($costing->costingLinks as $key => $link)
                                        <input type="hidden" name="link_no[]"value="{{ $link->link_no }}">
                                        <input type="hidden" name="link_type[]"value="{{ $link->link_type }}">
                                    @endforeach
                                </div>
                            </div>
                            <div class="row">
                                <x-input-box colGrid="3" name="delivery_date" value="{{ $delivery_date ?? '' }}"
                                    label="Delivery Date" class="date" />
                                <div class="col-xl-3 col-md-3">
                                    <div class="input-group input-group-sm input-group-primary">
                                        <select name="billing_address_id" class="form-control">

                                            @foreach ($costing->client->billingAddress as $billing_address)
                                                <option value="{{ $billing_address->id }}">{{ $billing_address->address }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label class="input-group-addon input-group-addon-manual"><i
                                                class="icofont icofont-ui-add"
                                                onClick="ShowModal('billing','{{ $costing->fr_no }}',this)"></i></label>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-3">
                                    <div class="input-group input-group-sm input-group-primary">
                                        <select name="collection_address_id" class="form-control">
                                            @foreach ($costing->client->collectionAddress as $collection_address)
                                                <option value="{{ $collection_address->id }}">
                                                    {{ $collection_address->address }}</option>
                                            @endforeach
                                        </select>
                                        <label class="input-group-addon input-group-addon-manual"><i
                                                class="icofont icofont-ui-add"
                                                onClick="ShowModal('collection','{{ $costing->fr_no }}',this)"></i></label>
                                    </div>
                                </div>
                                <x-input-box colGrid="3" name="bill_payment_date" label="Bill Payment Date"
                                    class="container" attr='readonly' value="" />
                                <div class="col-3">
                                    <div class="form-check-inline">
                                        <label class="form-check-label" for="prepaid">
                                            <input type="radio" class="form-check-input payment_status" id="prepaid"
                                                name="payment_status" value="prepaid" checked>
                                            Prepaid
                                        </label>
                                    </div>

                                    <div class="form-check-inline">
                                        <label class="form-check-label" for="prepaid">
                                            <input type="radio" class="form-check-input payment_status" id="prepaid"
                                                name="payment_status" value="postpaid">
                                            Postpaid
                                        </label>
                                    </div>
                                </div>
                                <x-input-box colGrid="3" name="mrc" value="{{ $costing->total_mrc ?? 0 }}"
                                    label="MRC" attr="readonly" />
                                <x-input-box colGrid="3" name="otc" value="{{ $costing->total_otc ?? 0 }}"
                                    label="OTC" attr="readonly" />
                            </div>
                            <div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <th>Product/Service</th>
                                        <th>Quantity</th>
                                        <th>Unit</th>
                                        <th>Unit Price</th>
                                        <th>Total Price</th>
                                        <th>VAT</th>
                                        <th>Total Amount</th>
                                    </thead>
                                    <tbody>
                                        @php
                                            $total = 0;
                                            $sub_total_vat = 0;
                                            $sub_total_amount = 0;
                                        @endphp
                                        @foreach ($costing->costingProducts as $key => $costing_product)
                                            @php
                                                $total_price = ($costing_product->vat_percentage * $costing_product->rate + $costing_product->rate) * $costing_product->quantity;
                                                $total_amount = $costing_product->product_vat_amount + $total_price;
                                                $total += $total_price;
                                                $sub_total_vat += $costing_product->product_vat_amount;
                                                $sub_total_amount += $total_amount;
                                            @endphp
                                            <tr>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="product_name[]"
                                                            class="form-control text-center" id="service_name" readonly
                                                            value="{{ $costing_product->product->name }}">
                                                        <input type="hidden" name="product_id[]"
                                                            class="form-control text-center" id="service" readonly
                                                            value="{{ $costing_product->product->id }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="quantity[]"
                                                            class="form-control text-right" id="quantity" readonly
                                                            value="{{ $costing_product->quantity }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="unit[]"
                                                            class="form-control text-center" id="unit" readonly
                                                            value="{{ $costing_product->product->unit }}">
                                                    </div>
                                                </td>
                                                <td class="d-none">
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="rate[]"
                                                            class="form-control text-right" readonly
                                                            value="{{ $costing_product->rate }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="price[]"
                                                            class="form-control text-right price" readonly
                                                            value="{{ $costing_product->rate }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="total_price[]"
                                                            class="form-control text-right total_price" readonly
                                                            value="{{ $total_price }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="vat_amount[]"
                                                            class="form-control text-right vat_amount" readonly
                                                            value="{{ $costing_product->product_vat_amount }}">
                                                        <input type="hidden" name="vat_percent[]"
                                                            class="form-control text-right vat_percent" readonly
                                                            value="{{ $costing_product->product_vat }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="total_amount[]"
                                                            class="form-control text-right total_amount" readonly
                                                            value="{{ $total_amount }}">
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" style="text-align: left;"></td>
                                            <td style="text-align: center;">Total MRC</td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="total_mrc"
                                                        class="form-control text-right total_mrc" readonly
                                                        value="{{ $total }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="sub_total_vat"
                                                        class="form-control text-right sub_total_vat" readonly
                                                        value="{{ $sub_total_vat }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="sub_total_amount"
                                                        class="form-control text-right sub_total_amount" readonly
                                                        value="{{ $sub_total_amount }}">
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3"></div>
                            <div class="col-3"></div>
                            <div class="col-3 text-right">Grand Total MRC</div>
                            <div class="col-3">
                                <div class="input-group input-group-sm input-group-primary float-right"
                                    style="width:82%;">
                                    <input type="text" name="grand_total" class="form-control text-right"
                                        id="grand_total" readonly value="{{ $grand_total }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <button class="py-2 btn btn-success">
                        {{ !empty($sale->id) ? 'Update' : 'Save' }}
                    </button>
                </div>
            </div>
        </div>

        {!! Form::close() !!}
        @include('changes::modify_sales.model')
        @include('changes::modify_sales.day-table')

    @endsection
    @section('script')
        @include('changes::modify_sales.js')
    @endsection
