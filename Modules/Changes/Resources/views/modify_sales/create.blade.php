@extends('layouts.backend-layout')
@section('title', 'Sales')

@php
    $is_old = old('client_no') ? true : false;
    $form_heading = !empty($sale->id) ? 'Update' : 'Add';
    $form_url = !empty($sale->id) ? route('sales-modification.update', $sale->id) : route('sales-modification.store');
    $form_method = !empty($sale->id) ? 'PUT' : 'POST';
@endphp

@section('breadcrumb-title')
    {{ ucfirst($form_heading) }} Sale
@endsection

@section('breadcrumb-button')
    <a href="{{ route('sales.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
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
                    <h5> <span> &#10070; </span> Sale <span>&#10070;</span> </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @php
                            $client_name = $is_old ? old('client_name') : $sale->client->client_name ?? null;
                            $client_id = $is_old ? old('client_id') : $sale->client->id ?? null;
                            $client_no = $is_old ? old('client_no') : $sale->client_no ?? null;
                            $effective_date = $is_old ? old('effective_date') : $sale->effective_date ?? today()->format('d-m-Y');
                            $account_holder = $is_old ? old('account_holder') : $sale->account_holder ?? null;
                            $employee_id = $is_old ? old('employee_id') : $sale->employee_id ?? null;
                            $offer_id = $is_old ? old('offer_id') : $sale->offer_id ?? null;
                            $remarks = $is_old ? old('remarks') : $sale->remarks ?? null;
                            $mq_no = $is_old ? old('mq_no') : $sale->mq_no ?? null;
                            $contract_duration = $is_old ? old('contract_duration') : $sale->contract_duration ?? null;
                            $work_order = $is_old ? old('work_order') : $sale->work_order ?? null;
                            $sla = $is_old ? old('sla') : $sale->sla ?? null;
                            $wo_no = $is_old ? old('wo_no') : $sale->wo_no ?? null;
                            $grand_total = $is_old ? old('grand_total') : $sale->grand_total ?? 0;
                            $connectivity_requirement_id = $is_old ? old('connectivity_requirement_id') : $sale->connectivity_requirement_id ?? $connectivity_requirement_id;

                        @endphp
                        <x-input-box colGrid="4" name="client_name" value="{{ $client_name }}" label="Client Name" />
                        <x-input-box colGrid="4" name="client_no" value="{{ $client_no }}" label="Client Id" />
                        <x-input-box colGrid="4" name="account_holder" value="{{ $account_holder }}"
                            label="Account Holder" />
                        <input type="hidden" id="employee_id" name="employee_id" value="{{ $employee_id }}">
                        <x-input-box colGrid="4" name="offer_id" value="{{ $offer_id }}" label="Offer Id" />
                        <x-input-box colGrid="4" name="remarks" value="{{ $remarks }}" label="Remarks" />
                        <x-input-box colGrid="4" name="mq_no" value="{{ $mq_no }}" label="MQ No" />
                        <x-input-box colGrid="4" name="contract_duration" value="{{ $contract_duration }}"
                            label="Contract Duration" />
                        <x-input-box colGrid="4" name="effective_date" class="date" value="{{ $effective_date }}"
                            label="Effective Date" />
                        <x-input-box colGrid="4" name="wo_no" value="{{ $wo_no }}" label="Wo No" />
                        <x-input-box colGrid="4" type="file" name="sla" label="SLA" value="" />
                        <x-input-box colGrid="4" type="file" name="work_order" label="Work Order" value="" />
                        <input type="hidden" name="connectivity_requirement_id"
                            value="{{ $connectivity_requirement_id }}">


                    </div>
                </div>
            </div>
            <h6>Old Sale Details</h6>
            <div id='old_fr_details'>
                @if (isset($oldSale) && count($oldSale->saleDetails))
                    @foreach ($oldSale->saleDetails as $key => $value)
                        @php
                            $percent = $value->offerDetails->total_offer_mrc / $value->offerDetails->costing->product_total_cost - 1;
                        @endphp
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" class="" value="Primary"
                                                    @if ($value->checked == 1) checked=True @endif>
                                                <span class="cr">
                                                    <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                                </span>
                                                <span>{{ $value->frDetails->connectivity_point }} ( {{ $value->fr_no }}
                                                    )</span>
                                                <input type="hidden" class="fr_no" value="{{ $value->fr_no }}">
                                                <input type="hidden" class="costing_id" value="{{ $value->costing_id }}">
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        @foreach ($value->saleLinkDetails as $link_key => $link_value)
                                            <span class="badge badge-primary">{{ $link_value->link_type }}</span>
                                            <input type="hidden" value="{{ $link_value->link_no }}">
                                            <input type="hidden" value="{{ $link_value->link_type }}">
                                        @endforeach
                                    </div>
                                </div>
                                <div class="row">
                                    <x-input-box colGrid="3" name="" value="{{ $value->delivery_date ?? '' }}"
                                        label="Delivery Date" class="date" />
                                    {{-- <x-input-box colGrid="3" name=""
                                        value="{{ $value->bill_payment_date ?? '' }}" label="Bill Payment Date"
                                        class="container" attr='readonly' /> --}}

                                    <div class="col-3">
                                        <div class="form-check-inline">
                                            <label class="form-check-label" for="prepaid">
                                                <input type="radio" class="form-check-input payment_status"
                                                    id="prepaid" value="prepaid" @checked(@$value->payment_status == 'prepaid' || ($form_method == 'POST' && !old()))>
                                                Prepaid
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label" for="postpaid">
                                                <input type="radio" class="form-check-input payment_status"
                                                    id="postpaid" value="postpaid" @checked(@$value->payment_status == 'postpaid')>
                                                Postpaid
                                            </label>
                                        </div>
                                    </div>
                                    <x-input-box colGrid="3" name="" value="{{ $value->mrc }}"
                                        label="MRC" attr="readonly" />
                                    <x-input-box colGrid="3" name="" value="{{ $value->otc }}"
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
                                            <th>Price</th>
                                            <th>Total Price</th>
                                            <th>Vat Percent</th>
                                            <th>Vat Amount</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($value->saleProductDetails as $key1 => $val)
                                                <tr>
                                                    <td>
                                                        <div class="input-group input-group-sm input-group-primary">
                                                            <input type="text" class="form-control text-center"
                                                                id="service_name" readonly
                                                                value="{{ $val->product_name }}">
                                                            <input type="hidden" class="form-control text-center"
                                                                id="service" readonly value="{{ $val->product_id }}">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group input-group-sm input-group-primary">
                                                            <input type="text" class="form-control text-right"
                                                                id="quantity" readonly value="{{ $val->quantity }}">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group input-group-sm input-group-primary">
                                                            <input type="text" class="form-control text-center"
                                                                id="unit" readonly value="{{ $val->unit }}">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group input-group-sm input-group-primary">
                                                            <input type="text" class="form-control text-right" readonly
                                                                value="{{ $val->rate }}">
                                                        </div>
                                                    </td>
                                                    <td class="d-none">
                                                        <div class="input-group input-group-sm input-group-primary">
                                                            <input type="text" class="form-control text-right" readonly
                                                                value="{{ $percent * $val->rate + $val->rate }}">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group input-group-sm input-group-primary">
                                                            <input type="text" class="form-control text-right" readonly
                                                                value="{{ ($percent * $val->rate + $val->rate) * $val->quantity }}">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group input-group-sm input-group-primary">
                                                            <input type="text"
                                                                class="form-control text-right vat_percent"
                                                                value="0">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group input-group-sm input-group-primary">
                                                            <input type="text"
                                                                class="form-control text-right vat_amount" readonly
                                                                value="0">
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
                                                        <input type="text" class="form-control text-right total_mrc"
                                                            readonly value="{{ $value->total_mrc }}">
                                                    </div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <h6>Modification Sale Details</h6>
            <div id='fr_details'>
                @if (isset($sale) && count($sale->saleDetails))
                    @foreach ($sale->saleDetails as $key => $value)
                        @php
                            $percent = $value->offerDetails->total_offer_mrc / $value->offerDetails->costing->product_total_cost - 1;
                        @endphp
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" class="checkbox" value="Primary" name="checked"
                                                    @if ($value->checked == 1) checked=True @endif>
                                                <span class="cr">
                                                    <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                                </span>
                                                <span>{{ $value->frDetails->connectivity_point }} ( {{ $value->fr_no }}
                                                    )</span>
                                                <input type="hidden" class="fr_no" name="fr_no"
                                                    value="{{ $value->fr_no }}">
                                                <input type="hidden" class="costing_id" name="costing_id"
                                                    value="{{ $value->costing_id }}">
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        @foreach ($value->saleLinkDetails as $link_key => $link_value)
                                            <span class="badge badge-primary">{{ $link_value->link_type }}</span>
                                            <input type="hidden" name="link_no[]"value="{{ $link_value->link_no }}">
                                            <input type="hidden" name="link_type[]"value="{{ $link_value->link_type }}">
                                        @endforeach
                                    </div>
                                </div>
                                <div class="row">
                                    <x-input-box colGrid="3" name="delivery_date"
                                        value="{{ $value->delivery_date ?? '' }}" label="Delivery Date"
                                        class="date" />
                                    <div class="col-xl-2 col-md-2">
                                        <div class="input-group input-group-sm input-group-primary">
                                            <select name="billing_address_id" class="form-control">
                                                @foreach ($billing_address as $bil_key => $bil_val)
                                                    <option value="{{ $bil_val->id }}"
                                                        @if ($bil_val->id == $value->billing_address_id) selected @endif>
                                                        {{ $bil_val->address }}</option>
                                                @endforeach
                                            </select>
                                            <label class="input-group-addon input-group-addon-manual"
                                                data-toggle="tooltip" title='Add Billing Address'><i
                                                    class="icofont icofont-ui-add"
                                                    onClick="ShowModal('billing','{{ $value->fr_no }}',this)"></i></label>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-md-2">
                                        <div class="input-group input-group-sm input-group-primary">
                                            <select name="collection_address_id" class="form-control">
                                                @foreach ($collection_address as $col_key => $col_val)
                                                    <option value="{{ $col_val->id }}"
                                                        @if ($col_val->id == $value->collection_address_id) selected @endif>
                                                        {{ $col_val->address }}</option>
                                                @endforeach
                                            </select>
                                            <label class="input-group-addon input-group-addon-manual"
                                                data-toggle="tooltip" title='Add Collection Address'><i
                                                    class="icofont icofont-ui-add"
                                                    onClick="ShowModal('collection','{{ $value->fr_no }}',this)"></i></label>
                                        </div>
                                    </div>
                                    <x-input-box colGrid="3" name="bill_payment_date"
                                        value="{{ $value->bill_payment_date ?? '' }}" label="Bill Payment Date"
                                        class="container" attr='readonly' />

                                    <div class="col-3">
                                        <div class="form-check-inline">
                                            <label class="form-check-label" for="prepaid">
                                                <input type="radio" class="form-check-input payment_status"
                                                    id="prepaid" name="payment_status" value="prepaid"
                                                    @checked(@$value->payment_status == 'prepaid' || ($form_method == 'POST' && !old()))>
                                                Prepaid
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label" for="postpaid">
                                                <input type="radio" class="form-check-input payment_status"
                                                    id="postpaid" name="payment_status" value="postpaid"
                                                    @checked(@$value->payment_status == 'postpaid')>
                                                Postpaid
                                            </label>
                                        </div>
                                    </div>
                                    <x-input-box colGrid="3" name="mrc" value="{{ $value->mrc }}"
                                        label="MRC" attr="readonly" />
                                    <x-input-box colGrid="3" name="otc" value="{{ $value->otc }}"
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
                                            <th>Price</th>
                                            <th>Total Price</th>
                                            <th>Vat Percent</th>
                                            <th>Vat Amount</th>
                                            <th>Total Amount</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($value->saleProductDetails as $key1 => $val)
                                                <tr>
                                                    <td>
                                                        <div class="input-group input-group-sm input-group-primary">
                                                            <input type="text" name="product_name[]"
                                                                class="form-control text-center" id="service_name"
                                                                readonly value="{{ $val->product_name }}">
                                                            <input type="hidden" name="product_id[]"
                                                                class="form-control text-center" id="service" readonly
                                                                value="{{ $val->product_id }}">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group input-group-sm input-group-primary">
                                                            <input type="text" name="quantity[]"
                                                                class="form-control text-right" id="quantity" readonly
                                                                value="{{ $val->quantity }}">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group input-group-sm input-group-primary">
                                                            <input type="text" name="unit[]"
                                                                class="form-control text-center" id="unit" readonly
                                                                value="{{ $val->unit }}">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group input-group-sm input-group-primary">
                                                            <input type="text" name="rate[]"
                                                                class="form-control text-right" readonly
                                                                value="{{ $val->rate }}">
                                                        </div>
                                                    </td>
                                                    <td class="d-none">
                                                        <div class="input-group input-group-sm input-group-primary">
                                                            <input type="text" name="price[]"
                                                                class="form-control text-right" readonly
                                                                value="{{ $percent * $val->rate + $val->rate }}">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group input-group-sm input-group-primary">
                                                            <input type="text" name="total_price[]"
                                                                class="form-control text-right" readonly
                                                                value="{{ ($percent * $val->rate + $val->rate) * $val->quantity }}">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group input-group-sm input-group-primary">
                                                            <input type="text" name="vat_percent[]"
                                                                class="form-control text-right vat_percent"
                                                                value="{{ $percent }}">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group input-group-sm input-group-primary">
                                                            <input type="text" name="vat_amount[]"
                                                                class="form-control text-right vat_amount" readonly
                                                                value="0">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group input-group-sm input-group-primary">
                                                            <input type="text" name="total_amount[]"
                                                                class="form-control text-right total_amount" readonly
                                                                value="{{ ($percent * $val->rate + $val->rate) * $val->quantity }}">
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot></tfoot>
                                        <tr>
                                            <td colspan="3" style="text-align: left;"></td>
                                            <td style="text-align: center;">Total MRC</td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="total_mrc"
                                                        class="form-control text-right total_mrc" readonly
                                                        value="{{ $value->total_mrc }}">
                                                </div>
                                            </td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
        @include('sales::sales.model')
        @include('sales::sales.day-table')

    @endsection

    @section('script')
        @include('changes::modify_sales.js')
    @endsection
