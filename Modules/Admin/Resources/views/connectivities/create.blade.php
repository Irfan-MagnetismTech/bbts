@extends('layouts.backend-layout')
@section('title', 'link')

<style>
   fieldset {
        display: block!important;
        margin-left: 2px!important;
        margin-right: 2px!important;
        padding-left: 0.75em!important;
        padding-bottom: 0%!important;
        padding-right: 0.75em!important;
        border: #1a1111 2px silid;
        border: 2px black (internal value)!important;
    }
fieldset {
  /* background-color: #eeeeee!important; */
}

legend {
  color: white!important;
  display: block!important;
  width: 90%!important;
  max-width: 100%!important;
  font-size: 0.7rem!important;
  line-height: inherit!important;
  font-weight: 100!important;
  color: inherit!important;
  white-space: normal!important;
  margin-bottom:0%!important; 
  padding-bottom:0%!important; 
}
.section-label {
    background: #ffffff;
    margin-left: 25px;
    font-size: 15px;
    font-weight: bold;
    padding: 17px;
    transition: 0.3s;
}


</style>

@php
    $is_old = old('link_name') ? true : false;
    $form_heading = !empty($connectivity->id) ? 'Update' : 'Add';
    $form_url = !empty($connectivity->id) ? route('connectivity.update', $connectivity->id) : route('connectivity.store');
    $form_method = !empty($connectivity->id) ? 'PUT' : 'POST';
    $reference = old('reference', !empty($connectivity) ? $connectivity->reference : null);
    $increament_type = old('increament_type', !empty($connectivity) ? $connectivity->increament_type : null);
    $link_type = old('link_type', !empty($connectivity) ? $connectivity->link_type : null);
    $link_name = old('link_name', !empty($connectivity) ? $connectivity->link_name : null);
    $vendor_id = old('vendor_id', !empty($connectivity) ? $connectivity->vendor_id : null);
    $vendor_name = old('vendor', !empty($connectivity) ? $connectivity->vendor->name : null);
    $bbts_link_id = old('bbts_link_id', !empty($connectivity) ? $connectivity->bbts_link_id : null);
    $from_location = old('from_location', !empty($connectivity) ? $connectivity->from_location : null);
    $from_pop_id = old('from_pop_id', !empty($connectivity) ? $connectivity->from_pop_id : null);
    $to_location = old('to_location', !empty($connectivity) ? $connectivity->to_location : null);
    $to_pop_id = old('to_pop_id', !empty($connectivity) ? $connectivity->to_pop_id : null);
    $from_site = old('from_site', !empty($connectivity) ? $connectivity->from_site : null);
    $division_id = old('division_id', !empty($connectivity) ? $connectivity->division_id : null);
    $district_id = old('district_id', !empty($connectivity) ? $connectivity->district_id : null);
    $to_site = old('to_site', !empty($connectivity) ? $connectivity->to_site : null);
    $thana_id = old('thana_id', !empty($connectivity) ? $connectivity->thana_id : null);
    $gps = old('gps', !empty($connectivity) ? $connectivity->gps : null);
    $teck_type = old('teck_type', !empty($connectivity) ? $connectivity->teck_type : null);
    $link_from = old('link_from', !empty($connectivity) ? $connectivity->link_from : null);
    $vendor_link_id = old('vendor_link_id', !empty($connectivity) ? $connectivity->vendor_link_id : null);
    $vendor_vlan = old('vendor_vlan', !empty($connectivity) ? $connectivity->vendor_vlan : null);
    $port = old('port', !empty($connectivity) ? $connectivity->port : null);
    $date_of_commissioning = old('date_of_commissioning', !empty($connectivity) ? $connectivity->date_of_commissioning : today()->format('d-m-Y'));
    $date_of_termination = old('date_of_termination', !empty($connectivity) ? $connectivity->date_of_termination :  today()->format('d-m-Y'));
    $activation_date = old('activation_date', !empty($connectivity) ? $connectivity->activation_date : today()->format('d-m-Y'));
    $remarks = old('remarks', !empty($connectivity) ? $connectivity->remarks : null);
    $capacity_type = old('capacity_type', !empty($connectivity) ? $connectivity->capacity_type : null);
    $existing_capacity = old('existing_capacity', !empty($connectivity) ? $connectivity->existing_capacity : null);
    $new_capacity = old('new_capacity', !empty($connectivity) ? $connectivity->new_capacity : null);
    $terrif_per_month = old('terrif_per_month', !empty($connectivity) ? $connectivity->terrif_per_month : null);
    $amount = old('amount', !empty($connectivity) ? $connectivity->amount : null);
    $vat = old('vat', !empty($connectivity) ? $connectivity->vat : null);
    $vat_percent = old('vat_percent', !empty($connectivity) ? $connectivity->vat_percent : null);
    $total = old('total', !empty($connectivity) ? $connectivity->total : null);
@endphp

@section('breadcrumb-title')
    {{ ucfirst($form_heading) }} Link
@endsection

@section('breadcrumb-button')
    <a href="{{ route('connectivity.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
@endsection

@section('content-grid', null)

@section('content')

    {!! Form::open([
        'url' => $form_url,
        'method' => $form_method,
        'class' => 'custom-form',
    ]) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="text-center mt-4 bg-info pt-2 pb-2">
                    <h5 class="text-dark"> <span> &#10070; </span> Connectivity / Link Information <span>&#10070;</span> </h5>
                </div>
                <div class="card-body">
                    <div class="row" >
                        <x-input-box colGrid="2" name="reference" label="Reference" value="{{$reference}}"/>
                        <div class="col-2">
                            <div class="form-check-inline pt-0 mt-0">
                                <label class="form-check-label" for="new">
                                    <input type="radio" class="form-check-input link_type" id="new" name="link_type"
                                        value="new" @checked(@$link_type == 'new' || ($form_method == 'POST' && !old()))>
                                    NEW
                                </label>
                            </div>
                            <div class="form-check-inline mt-0 pt-0">
                                <label class="form-check-label" for="existing">
                                    <input type="radio" class="form-check-input link_type" id="existing" name="link_type"
                                        value="existing" @checked(@$link_type == 'existing')>
                                    EXISTING
                                </label>
                            </div>
                        </div>
                        <x-input-box colGrid="3" name="link_name" label="Link Name" value="{{$link_name}}"/>
                        <x-input-box colGrid="3" name="vendor" label="Vendor" value="{{$vendor_name}}"/>
                        <input type="hidden" id="vendor_id" name="vendor_id" value="{{$vendor_id}}">
                        <x-input-box colGrid="2" name="bbts_link_id" label="BBTS Link Id" value="{{$bbts_link_id}}"/>
                    </div>
                    <div class="row"> 
                        <div class="col-md-4">
                            <div class="col-md-12">
                                <div style="border: 2px solid gray; border-radius: 15px; margin-top: 30px;" class="row">
                                    <div class="col-12 col-md-12" style="margin-top: -11px;">
                                        <span class="section-label">  From Info</span>
                                    </div>
                                    <x-input-box colGrid="12" name="from_location" label="From Location" value="{{$from_location}}" placeholder="POP"/>
                                    <input type="hidden" id="from_pop_id" name="from_pop_id" value="{{$from_pop_id}}">
                                    <x-input-box colGrid="12" name="from_site" label="From Site" value="{{$from_site}}" placeholder="LDP"/> 
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="col-md-12">
                                <div style="border: 2px solid gray; border-radius: 15px; margin-top: 30px;" class="row">
                                    <div class="col-12 col-md-12" style="margin-top: -11px;">
                                        <span class="section-label">  To Info </span>
                                    </div>
                                    <div class="form-group col-4">
                                        <div class="input-group input-group-sm input-group-primary">
                                            <select class="form-control" id="division_id" name="division_id" required>
                                                <option value="">Select division</option>
                                                @foreach (@$divisions as $division)
                                                    <option value="{{ $division->id }}"
                                                        {{ (old('division_id') ?? ($division_id ?? '')) == $division->id ? 'selected' : '' }}>
                                                        {{ $division->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-4">
                                        <div class="input-group input-group-sm input-group-primary">
                                            <select class="form-control" id="district_id" name="district_id" required>
                                                <option value="">Select district</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-4">
                                        <div class="input-group input-group-sm input-group-primary">
                                            <select class="form-control" id="thana_id" name="thana_id" required>
                                                <option value="">Select thana</option>
                                            </select>
                                        </div>
                                    </div> 

                                    <div class="col-3">
                                        {{-- <legend>Link From</legend> --}}
                                        <div class="form-check-inline">
                                            <label class="form-check-label" for="bbts">
                                                <input type="radio" class="form-check-input link_from" id="bbts" name="link_from"
                                                    value="bbts" @checked(@$link_from == 'bbts' || ($form_method == 'POST' && !old()))>
                                                BBTS
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label" for="vendor">
                                                <input type="radio" class="form-check-input link_from" id="vendor" name="link_from"
                                                    value="vendor" @checked(@$link_from == 'vendor')>
                                                    VENDOR
                                            </label>
                                        </div> 
                                    </div>
                                    <x-input-box colGrid="3" name="to_location" label="To Location" value="{{$to_location}}"/>
                                    <input type="hidden" id="to_pop_id" name="to_pop_id"> 
            
                                    <x-input-box colGrid="3" name="to_site" label="To Site" value="{{$to_site}}" placeholder="LDP/POC"/>
                                    <x-input-box colGrid="3" name="gps" label="GPS" value="{{$gps}}" placeholder="Lat/Long"/> 
                                </div>
                            </div>
                        </div>
                    </div>    
                </div>
            </div>
            <div class="card">
                <div class="text-center mt-4 bg-info pt-2 pb-2">
                    <h5 class="text-dark"> <span> &#10070; </span> Technical Information <span>&#10070;</span> </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <x-input-box colGrid="2" name="vendor_link_id" label="Vendor Link Id" value="{{$vendor_link_id}}"/>
                        <x-input-box colGrid="2" name="vendor_vlan" label="Vendor VLAN" value="{{$vendor_vlan}}"/>
                        <x-input-box colGrid="2" name="port" label="Port" value="{{$port}}"/>
                        <x-input-box colGrid="3" name="date_of_commissioning" label="Date Of Commissioning" value="{{$date_of_commissioning}}" class="date" attr="readonly"/>
                        <x-input-box colGrid="3" name="date_of_termination" label="Date Of Termination" value="{{$date_of_termination}}" class="date" attr="readonly"/>
                    </div>
                    <div class="row">
                        <x-input-box colGrid="2" name="activation_date" label="Activation Date" value="{{$activation_date}}" class="date" attr="readonly"/>
                        <x-input-box colGrid="10" name="remarks" label="Remarks" value="{{$remarks}}"/>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="text-center mt-4 bg-info pt-2 pb-2">
                    <h5 class="text-dark"> <span> &#10070; </span> Billing Information <span>&#10070;</span> </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <select name="capacity_type" id="capacity_type" class="form-control">
                                <option value="">Select Capacity Type</option>
                                <option value="mpls" @if($capacity_type =='mpls' ) selected @endif>MPLS</option>
                                <option value="e1" @if($capacity_type =='e1' ) selected @endif>E1</option>
                                <option value="stm1" @if($capacity_type =='stm1' ) selected @endif>STM-1</option>
                                <option value="core" @if($capacity_type =='core' ) selected @endif>Core</option>
                                <option value="stm2" @if($capacity_type =='stm2' ) selected @endif>STM-2</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <select name="status" id="status" class="form-control">
                                <option value="">SELECT STATUS</option>
                                @foreach (config('businessinfo.linkStatus') as $typeKey => $typevalue)
                                    <option value="{{ $typevalue }}">
                                    {{ strToUpper($typevalue) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <x-input-box colGrid="3" name="existing_capacity" label="Existing Capacity" value="{{$existing_capacity}}"/>
                        <x-input-box colGrid="3" name="new_capacity" label="New Capacity" value="{{$new_capacity}}"/>
                    </div>
                    <div class="row">
                        <div class="col-6"></div>
                        <x-input-box colGrid="3" name="terrif_per_month" label="Terrif Per Month" value="{{$terrif_per_month}}"/>
                        <x-input-box colGrid="3" name="amount" label="Amount" value="{{$amount}}"/>
                    </div>
                    <div class="row">
                        <div class="col-5"></div>
                        <x-input-box colGrid="2" name="vat_percent" label="VAT (%)" value="{{$vat_percent}}"/>
                        <x-input-box colGrid="2" name="vat" label="VAT" value="{{$vat}}"/>
                        <x-input-box colGrid="3" name="total" label="Total" value="{{$total}}" attr="readonly"/>
                    </div> 
                </div>
            </div>
            <button class="py-2 btn btn-success btn-block">{{ !empty($lead_generation->id) ? 'Update' : 'Save' }}</button>
        </div>
    </div>
    </div>
    {!! Form::close() !!}
@endsection

@section('script')
    <script>
         $('.date').datepicker({
                    format: "dd-mm-yyyy",
                    autoclose: true,
                    todayHighlight: true,
                    showOtherMonths: true
                });
      
                $('.link_type').on('change',function(){
                    emptyField();
                    changeInput();
                })
                $('#link_name').on('keyup', function() {
                    if($('input[name="link_type"]:checked').val() === 'existing'){
                        let myObject = {}
                        jquaryUiAjax(this, "{{ route('get_location_info_for_link') }}", uiList, myObject);
                        function uiList(item) {
                            $('#division_id').val(item.data.division_id).trigger('change');
                            $('#link_name').val(item.data.link_name).attr('value',item.data.link_name);
                            $('#vendor_id').val(item.data.vendor_id).attr('value',item.data.vendor_id);
                            $('#vendor').val(item.data.vendor_name).attr('value',item.data.vendor_name);
                            $('#bbts_link_id').val(item.data.bbts_link_id).attr('value',item.data.bbts_link_id);
                            $('#from_location').val(item.data.from_location).attr('value',item.data.from_location);
                            $('#from_site').val(item.data.from_site).attr('value',item.data.from_site);
                            $('#vendor_link_id').val(item.data.vendor_link_id).attr('value',item.data.vendor_link_id);
                            $('#vendor_vlan').val(item.data.vendor_vlan).attr('value',item.data.vendor_vlan);
                            $('#port').val(item.data.port).attr('value',item.data.port);
                            $('#date_of_commissioning').val(item.data.date_of_commissioning).attr('value',item.data.date_of_commissioning);
                            $('#date_of_termination').val(item.data.date_of_termination).attr('value',item.data.date_of_termination);
                            $('#activation_date').val(item.data.activation_date).attr('value',item.data.activation_date);
                            $('#remarks').val(item.data.remarks).attr('value',item.data.remarks);
                            $('#capacity_type').val(item.data.capacity_type).attr('value',item.data.capacity_type);
                            $('#existing_capacity').val(item.data.existing_capacity).attr('value',item.data.existing_capacity);
                            $('#new_capacity').val(item.data.new_capacity).attr('value',item.data.new_capacity);
                            $('#terrif_per_month').val(item.data.terrif_per_month).attr('value',item.data.terrif_per_month);
                            $('#amount').val(item.data.amount).attr('value',item.data.amount);
                            $('#vat_percent').val(item.data.vat_percent).attr('value',item.data.vat_percent);
                            $('#vat').val(item.data.vat).attr('value',item.data.vat);
                            $('#total').val(item.data.total).attr('value',item.data.total);
                            if(item.data.increament_type == 'increase'){
                                $('#increase').attr('checked',true);
                            }else{
                                $('#decrease').attr('checked',true);
                            }
                            $('#teck_type').val(item.data.teck_type).attr('value',item.data.teck_type);
                            if(item.data.teck_type == 'link'){
                                $('#link').attr('checked',true);
                            }else{
                                $('#backbone').attr('checked',true);
                            }
                            $('#district_id').on('DOMNodeInserted', function() {
                                $('#district_id').val(item.data.district_id).trigger('change');
                            });
                            $('#thana_id').on('DOMNodeInserted',function() {
                                $('#thana_id').val(item.data.thana_id).trigger('change');
                            });
                            return false;
                        }
                    }else{
                        if($(this).autocomplete()){
                            $(this).autocomplete('destroy');
                        }  
                    }
                })


                $('#from_location,#to_location').on('keyup', function(event) {
                    let selector = this;
                    let myObject = {}
                        jquaryUiAjax(this, "{{ route('get_pop') }}", uiList, myObject);
                        function uiList(item) {
                            $(selector).val(item.label).attr('value',item.label);
                            if(event.target.id == "from_location"){
                                $('#from_pop_id').val(item.id);
                            }else{
                                $('#to_pop_id').val(item.id);
                            }
                            return false;
                        }
                })
                $('#from_site').on('keyup', function(event) {
                    let selector = this;
                    let myObject = {}
                        jquaryUiAjax(this, "{{ route('get_link_sites') }}", uiList, myObject);
                        function uiList(item) {
                            $(selector).val(item.label).attr('value',item.label);
                            return false;
                        }
                })
        $(document).ready(function(){
            associativeDropdown("{{ route('get-districts') }}", 'division_id', '#division_id', '#district_id', 'get', null)
            associativeDropdown("{{ route('get-thanas') }}", 'district_id', '#district_id', '#thana_id', 'get', null)
            $('#vendor').on('keyup', function() {
                    let myObject = {}
                    jquaryUiAjax(this, "{{ route('get_vendors') }}", uiList, myObject);
                    function uiList(item) {
                        $('#vendor').val(item.label);
                        $('#vendor_id').val(item.id);
                        return false;
                    }
                });
                
            })
            $('#link_type').on('change',function(){
               
            })
            $(document).ready(function(){
                    changeInput();
            })
            function changeInput(){
                if($('input[name="link_type"]:checked').val() == 'existing'){
                    $('#bbts_link_id').parent().removeClass('d-none');
                }else{
                    $('#bbts_link_id').parent().addClass('d-none');
                }
            }
            function emptyField(){
                            $('#division_id').val(null);
                            $('#from_location').val(null).attr('value',null);
                            $('#bbts_link_id').val(null).attr('value',null);
                            $('#vendor').val(null).attr('value',null);
                            $('#vendor_id').val(null).attr('value',null);
                            $('#link_name').val(null).attr('value',null);
                            $('#from_site').val(null).attr('value',null);
                            $('#district_id').val(null).attr('value',null);
                            $('#thana_id').val(null).attr('value',null);
                            $('#vendor_link_id').val(null).attr('value',null);
                            $('#vendor_vlan').val(null).attr('value',null);
                            $('#port').val(null).attr('value',null);
                            $('#date_of_commissioning').val(null).attr('value',null);
                            $('#date_of_termination').val(null).attr('value',null);
                            $('#activation_date').val(null).attr('value',null);
                            $('#remarks').val(null).attr('value',null);
                            $('#capacity_type').val(null).attr('value',null);
                            $('#existing_capacity').val(null).attr('value',null);
                            $('#new_capacity').val(null).attr('value',null);
                            $('#terrif_per_month').val(null).attr('value',null);
                            $('#amount').val(null).attr('value',null);
                            $('#vat_percent').val(null).attr('value',null);
                            $('#vat').val(null).attr('value',null);
                            $('#total').val(null).attr('value',null);
                            $('#increase').attr('checked',false);
                            $('#decrease').attr('checked',false);
            }
            $('#new_capacity,#existing_capacity,#terrif_per_month,#vat_percent,#vat').on('keyup',function(){
                Calculatetotal();
            })
            function Calculatevat(){
                
            }
            function Calculatetotal(){
                $('#amount').val(0).attr('value',0);
                $('#total').val(0).attr('value',0);
                let new_capacity = $('#new_capacity').val() ?? 0;
                let existing_capacity = $('#existing_capacity').val() ?? 0;
                let used_capacity = new_capacity - existing_capacity;
                let terrif_per_month = $('#terrif_per_month').val() ?? 0;
                let vat_percent = $('#vat_percent').val() ?? 0;
                if(Math.sign(used_capacity) == -1 && used_capacity != 0){
                    used_capacity = -1 * used_capacity;
                }
                amount = used_capacity * terrif_per_month;
                if(amount != 0 && vat_percent){
                    var vat = Number(amount) * Number(vat_percent) / 100;
                }else{
                    var vat = 0;
                }
                $('#vat').val(vat).attr('value',vat);
                let total = Number(amount) + Number(vat);
                $('#amount').val(amount).attr('value',amount);
                $('#total').val(total).attr('value',total);
            }

    </script>
@endsection
