@extends('layouts.backend-layout')
@section('title', 'Sales')

@php
    $is_old = old('client_no') ? true : false;
    $form_heading = !empty($sale->id) ? 'Update' : 'Add';
    $form_url = !empty($sale->id) ? route('sales.update', $sale->id) : route('sales.store');
    $form_method = !empty($sale->id) ? 'PUT' : 'POST';
@endphp

@section('breadcrumb-title')
    {{ ucfirst($form_heading) }} Sale
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
.btn.btn-icon {
    border-radius: 50%!important;
    width: 25px!important;
    line-height: 20px!important;
    height: 25px!important;
    padding: 0px!important;
    text-align: center!important;
}
.day_td {
    cursor:pointer;
}

.day_td:hover {
    color:blue;
    background-color: yellow;
}

.box {
  position: absolute;
  width: 30px;
  height: 30px;
  display:hidden;
}
.container {
  position: relative;
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
                        @endphp
                        <x-input-box colGrid="4" name="client_name" value="{{ $client_name }}" label="Client Name" />
                        <x-input-box colGrid="4" name="client_no" value="{{ $client_no }}" label="Client Id" />
                        <x-input-box colGrid="4" name="account_holder" value="{{ $account_holder }}" label="Account Holder" />
                        <input type="hidden" id="employee_id" name="employee_id" value="{{ $employee_id }}">
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
                                    <div class="col-3">
                                            <div class="checkbox-fade fade-in-primary">
                                                <label>
                                                    <input type="checkbox" class="checkbox" value="Primary" name="checked[{{$key}}]" @if($value->checked == 1)
                                                        checked=True
                                                    @endif>
                                                    <span class="cr">
                                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                                    </span>
                                                    <span>{{$value->frDetails->connectivity_point}} ( {{$value->fr_no}} )</span>
                                                    <input type="hidden" class="fr_no" name="fr_no[{{$key}}]" value="{{$value->fr_no}}">
                                                    <input type="hidden" class="costing_id" name="costing_id[{{$key}}]" value="{{$value->costing_id}}">
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-9">
                                                @foreach($value->saleLinkDetails as $link_key => $link_value)
                                                <span>{{$link_value->link_type}}</span>
                                                <input type="hidden" name="link_no[{{$key}}][]"value="{{$link_value->link_no}}">
                                                <input type="hidden" name="link_type[{{$key}}][]"value="{{$link_value->link_type}}">
                                                @endforeach
                                        </div>
                                    </div>
                                            <div class="row">
                                                <x-input-box colGrid="3" name="delivery_date[{{$key}}]" value="{{ $value->delivery_date ?? '' }}" label="Delivery Date" class="date"/>
                                                <div class="col-md-2">
                                                        <div class="row">
                                                            <div class="col-md-10">
                                                                <select name="billing_address_id[{{$key}}]">
                                                                @foreach ($billing_address as $bil_key => $bil_val)
                                                                    <option value="{{$bil_val->id}}" @if($bil_val->id == $value->billing_address_id)  selected  @endif>{{$bil_val->address}}</option>
                                                                @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <span class="btn btn-inverse btn-sm btn-outline-inverse btn-icon" data-toggle="tooltip" title='Add Billing Address' id="add_billing"><i class="icofont icofont-ui-add" onClick="ShowModal('billing','{{$value->fr_no}}',this)"></i></span>
                                                            </div>
                                                        </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <select name="collection_address_id[{{$key}}]">
                                                                @foreach ($collection_address as $col_key => $col_val)
                                                                    <option value="{{$col_val->id}}" @if($col_val->id == $value->collection_address_id)  selected  @endif>{{$col_val->address}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <span class="btn btn-inverse btn-sm btn-outline-inverse btn-icon" data-toggle="tooltip" title='Add Collection Address' id="add_collection"><i class="icofont icofont-ui-add" onClick="ShowModal('collection','{{$value->fr_no}}',this)"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <x-input-box colGrid="3" name="bill_payment_date[{{$key}}]" value="{{ $value->bill_payment_date ?? '' }}" label="Bill Payment Date" class="container"/>

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
                                                <x-input-box colGrid="3" name="mrc[{{$key}}]" value="{{$value->mrc}}" label="MRC" attr="readonly"/>
                                                <x-input-box colGrid="3" name="otc[{{$key}}]" value="{{$value->otc}}" label="OTC" attr="readonly"/>
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
                                                                    <input type="text" name="product_name[{{$key}}][]" class="form-control text-center"
                                                                        id="service_name" readonly value="{{$val->product_name}}">
                                                                    <input type="hidden" name="product_id[{{$key}}][]" class="form-control text-center"
                                                                        id="service" readonly value="{{$val->product_id}}">
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
                                                            <td>
                                                                <div class="input-group input-group-sm input-group-primary">
                                                                    <input type="text" name="vat_percent[{{$key}}][]"
                                                                        class="form-control text-right vat_percent" value="0">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-sm input-group-primary">
                                                                    <input type="text" name="vat_amount[{{$key}}][]"
                                                                        class="form-control text-right vat_amount" readonly value="0">
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
            <div class="card">
                <button class="py-2 btn btn-success">
                    {{ !empty($sale->id) ? 'Update' : 'Save' }}
                </button>
            </div>
        </div>
    </div>
    
    {!! Form::close() !!}
    <div class="md-modal md-effect-13" id="modal-13">
        <div class="md-content">
            <h3 id="title"></h3>
            <div>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>Client No</td>
                            <td><input type="text" id="client_no_add" name="client_no_add" value="{{ $client_no }}" class="modal_data form-control"/></td>
                            <input type="hidden" name="client_id" id="client_id" value="{{$client_id}}" class="modal_data">
                            <input type="hidden" name="update_type" id="update_type" class="modal_data">
                            <input type="hidden" name="fr" id="fr" class="modal_data">
                        </tr>
                        <tr>
                            <td>Contact Person</td>
                            <td>
                                <input type="text" id="contact_person_add" name="contact_person_add" class="modal_data form-control"/>
                            </td>
                        </tr>
                        <tr>
                            <td>Designation</td>
                            <td>
                                <input type="text" id="designation_add" name="designation_add" class="modal_data form-control"/>
                            </td>
                        </tr>
                        <tr>
                            <td>Phone</td>
                            <td>
                                <input type="text" id="phone_add" name="phone_add"  class="modal_data form-control"/>
                            </td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>
                                <input type="text" id="email_add" name="email_add" class="modal_data form-control"/>
                            </td>
                        </tr>
                        <tr>
                            <td>Division</td>
                            <td>
                                <div class="input-group input-group-sm input-group-primary">
                                    <select class="form-control modal_data" id="division_id" name="division_id">
                                        <option value="">Select division</option>
                                        @foreach (@$divisions as $division)
                                            <option value="{{ $division->id }}">
                                                {{ $division->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>District</td>
                            <td>
                                <div class="input-group input-group-sm input-group-primary">
                                    <select class="form-control modal_data" id="district_id" name="district_id">
                                        <option value="">Select district</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Thana</td>
                            <td>
                                <div class="input-group input-group-sm input-group-primary">
                                    <select class="form-control  modal_data" id="thana_id" name="thana_id">
                                        <option value="">Select thana</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>
                                <input type="text" id="address_add" name="address_add" class="modal_data form-control"/>
                            </td>
                        </tr>
                        <tr>
                            <td>Payment Method</td>
                            <td>
                                <input type="text" id="payment_method_add" name="payment_method_add" class="modal_data form-control"/>
                            </td>
                        </tr>
                        <tr>
                            <td>Payment Date</td>
                            <td>
                                <input type="text" id="payment_date_add" name="payment_date_add" class="modal_data form-control"/>
                            </td>
                        </tr>
                    </tbody>
                </table>
                
            </div>
            <div class="row">
                <button type="button" class="btn btn-primary waves-effect col-2 offset-col-4" onClick="updateAddress()">Add</button>
                <button type="button" class="btn btn-primary waves-effect col-2" onClick="HideModal()">Close</button>
            </div>
        </div>
    </div>
    <div class="md-overlay"></div>
    <div class="box bg-secondary">
        <div style="">
            <div class="">
                <table class="table-condensed bg-secondary">
                    <tbody>
                        <tr>
                            <td class="day_td">1</td>
                            <td class="day_td">2</td>
                            <td class="day_td">3</td>
                            <td class="day_td">4</td>
                            <td class="day_td">5</td>
                            <td class="day_td">6</td>
                            <td class="day_td">7</td>
                        </tr>
                        <tr>
                            <td class="day_td">8</td>
                            <td class="day_td">9</td>
                            <td class="day_td">10</td>
                            <td class="day_td">11</td>
                            <td class="day_td">12</td>
                            <td class="day_td">13</td>
                            <td class="day_td">14</td>
                        </tr>
                        <tr>
                            <td class="day_td">15</td>
                            <td class="day_td">16</td>
                            <td class="day_td">17</td>
                            <td class="day_td">18</td>
                            <td class="day_td">19</td>
                            <td class="day_td">20</td>
                            <td class="day_td">21</td>
                        </tr>
                        <tr>
                            <td class="day_td">22</td>
                            <td class="day_td">23</td>
                            <td class="day_td">24</td>
                            <td class="day_td">25</td>
                            <td class="day_td">26</td>
                            <td class="day_td">27</td>
                            <td class="day_td">28</td>
                        </tr>
                        <tr>
                            <td class="day_td">29</td>
                            <td class="day_td">30</td>
                            <td class="day_td">31</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('script')
    @include('sales::sales.js')
@endsection
