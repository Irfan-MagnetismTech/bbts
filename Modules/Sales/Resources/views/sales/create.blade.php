@extends('layouts.backend-layout')
@section('title', 'Sales')

@php
    $is_old = old('client_no') ? true : false;
    $form_heading = !empty($sale->id) ? 'Update' : 'Add';
    $form_url = !empty($sale->id) ? route('sales.update', $sale->id) : route('sales.store');
    $form_method = !empty($sale->id) ? 'PUT' : 'POST';
@endphp

@section('breadcrumb-title')
    {{ ucfirst($form_heading) }} sale
@endsection

@section('breadcrumb-button')
    <a href="{{ route('sales.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
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
#dv{
    background-color: #f6f9f9!important;
    color: #191818!important;
    height: 100%!important;
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
                    <h5> <span> &#10070; </span> sale <span>&#10070;</span> </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @php
                            $client_name = $is_old ? old('client_name') : $sale->client->client_name ?? null;
                            $client_no = $is_old ? old('client_no') : $sale->client_no ?? null;
                            $effective_date = $is_old ? old('effective_date') : $sale->effective_date ?? today()->format('d-m-Y');
                            $account_holder = $is_old ? old('account_holder') : $sale->account_holder ?? null;
                            $offer_id = $is_old ? old('offer_id') : $sale->offer_id ?? null;
                            $remarks = $is_old ? old('remarks') : $sale->remarks ?? null;
                            $mq_no = $is_old ? old('mq_no') : $sale->mq_no ?? null;
                            $contract_duration = $is_old ? old('contract_duration') : $sale->contract_duration ?? null;
                            $work_order = $is_old ? old('work_order') : $sale->work_order ?? null;
                            $sla = $is_old ? old('sla') : $sale->sla ?? null;
                            $wo_no = $is_old ? old('wo_no') : $sale->wo_no ?? null;
                            $grand_total = $is_old ? old('grand_total') : $sale->grand_total ?? null;
                        @endphp
                        <x-input-box colGrid="4" name="client_name" value="{{ $client_name }}" label="Client Name" />
                        <x-input-box colGrid="4" name="client_no" value="{{ $client_no }}" label="Client Id" />
                        <x-input-box colGrid="4" name="account_holder" value="{{ $account_holder }}" label="Account Holder" />
                        <x-input-box colGrid="4" name="offer_id" value="{{ $offer_id }}" label="Offer Id" />
                        <x-input-box colGrid="4" name="remarks" value="{{ $remarks }}" label="Remarks" />
                        <x-input-box colGrid="4" name="mq_no" value="{{ $mq_no }}" label="MQ No" />
                        <x-input-box colGrid="4" name="contract_duration" value="{{ $contract_duration }}" label="Contract Duration" />
                        <x-input-box colGrid="4" name="effective_date" class="date" value="{{ $effective_date }}" label="Effective Date" />
                        <x-input-box colGrid="4" name="wo_no" value="{{ $wo_no }}" label="Wo No" />
                        <x-input-box colGrid="4" type="file" name="sla" label="SLA" value=""/>
                        <x-input-box colGrid="4" type="file" name="work_order" label="Work Order" value=""/>

                        
                    </div>
                </div>
            </div>
            <div id='fr_details'>
                @if(isset($sale) && count($sale->saleDetails))
                    @foreach($sale->saleDetails as $key => $value)
                        @php
                            $percent =  ($value->offerDetails->total_offer_mrc / $value->offerDetails->costing->product_total_cost) - 1;
                        @endphp
                        <div class="card">
                            <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="checkbox-fade fade-in-primary">
                                                <label>
                                                    <input type="checkbox" class="checkbox" value="Primary" name="checked[{{$key}}]" @if($value->checked == 1)
                                                        checked=True
                                                    @endif>
                                                    <span class="cr">
                                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                                    </span>
                                                    <span>{{$value->frDetails->connectivity_point}}</span>
                                                    <input type="hidden" class="fr_no" name="fr_no[{{$key}}]" value="{{$value->fr_no}}">
                                                </label>
                                            </div>
                                            <div class="row">
                                                <x-input-box colGrid="3" name="delivery_date[{{$key}}]" value="{{ $value->delivery_date ?? '' }}" label="Delivery Date" class="date"/>
                                                <x-input-box colGrid="2" name="billing_address[{{$key}}]" value="{{ $value->billing_address ?? '' }}" label="Billing Address" />
                                                 <span class="btn btn-inverse btn-outline-inverse btn-icon" data-toggle="tooltip" title='Add Billing Address' id="add_billing"><i class="icofont icofont-ui-add"></i></span>
                                                <x-input-box colGrid="2" name="collection_address[{{$key}}]" value="{{ $value->collection_address ?? '' }}" label="Collection Address" />
                                                <span class="btn btn-inverse btn-outline-inverse btn-icon" data-toggle="tooltip" title='Add Collection Address' id="add_collection"><i class="icofont icofont-ui-add"></i></span>
                                                <x-input-box colGrid="3" name="bill_payment_date[{{$key}}]" value="{{ $value->bill_payment_date ?? '' }}" label="Bill Payment Date" class="date"/>
                                                <div class="col-3">
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label" for="prepaid">
                                                            <input type="radio" class="form-check-input payment_status" id="prepaid" name="payment_status[{{$key}}]"
                                                                value="prepaid" @checked(@$value->payment_status == 'prepaid' || ($form_method == 'POST' && !old()))>
                                                            Prepaid
                                                        </label>
                                                    </div>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label" for="postpaid">
                                                            <input type="radio" class="form-check-input payment_status" id="postpaid" name="payment_status[{{$key}}]"
                                                                value="postpaid" @checked(@$value->payment_status == 'postpaid')>
                                                                Postpaid
                                                        </label>
                                                    </div>
                                                </div>
                                                <x-input-box colGrid="3" name="mrc[{{$key}}]" value="{{$value->mrc}}" label="MRC" />
                                                <x-input-box colGrid="3" name="otc[{{$key}}]" value="{{$value->otc}}" label="OTC" />
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
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($value->saleLinkDetails as $key1 => $val)
                                                        <tr>
                                                            <td>
                                                                <div class="input-group input-group-sm input-group-primary">
                                                                    <input type="text" name="service[{{$key}}][]" class="form-control text-center"
                                                                        id="service" readonly value="{{$val->service_name}}">
                                                                </div>
                                                            </td>
                                                            <td> 
                                                                <div class="input-group input-group-sm input-group-primary">
                                                                    <input type="text" name="quantity[{{$key}}][]" class="form-control text-right"
                                                                        id="quantity" readonly value="{{$val->quantity}}">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-sm input-group-primary">
                                                                    <input type="text" name="unit[{{$key}}][]" class="form-control text-center"
                                                                        id="unit" readonly value="{{$val->unit}}">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-sm input-group-primary">
                                                                    <input type="text" name="rate[{{$key}}][]"
                                                                        class="form-control text-right" readonly value="{{$val->rate}}">
                                                                </div>
                                                            </td>
                                                            <td class="d-none">
                                                                <div class="input-group input-group-sm input-group-primary">
                                                                    <input type="text" name="price[{{$key}}][]"
                                                                        class="form-control text-right" readonly value="{{($percent * $val->rate) + $val->rate}}">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-sm input-group-primary">
                                                                    <input type="text" name="total_price[{{$key}}][]"
                                                                        class="form-control text-right" readonly value="{{((($percent * $val->rate) + $val->rate) * $val->quantity)}}">
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
                                                                    <input type="text" name="total_mrc[{{$key}}]" class="form-control text-right total_mrc" readonly value="{{$value->total_mrc}}">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
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
                                    <div class="input-group input-group-sm input-group-primary float-right" style="width:82%;">
                                        <input type="text" name="grand_total" class="form-control text-right"
                                            id="grand_total" readonly value="{{$grand_total}}">
                                    </div>
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

@endsection
@section('script')
    @include('sales::sales.js')
@endsection
