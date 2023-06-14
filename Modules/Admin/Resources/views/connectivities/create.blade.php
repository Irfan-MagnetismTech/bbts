@extends('layouts.backend-layout')
@section('title', 'link')

@php
    $is_old = old('client_id') ? true : false;
    $form_heading = !empty($survey->id) ? 'Update' : 'Add';
    $form_url = !empty($survey->id) ? route('connectivity.update', $survey->id) : route('connectivity.store');
    $form_method = !empty($survey->id) ? 'PUT' : 'POST';
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

    {{-- Comparative Statement --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="text-center mt-4">
                    <h5> <span> &#10070; </span> Connectivity / Link Information <span>&#10070;</span> </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-1"></div>
                        <x-input-box colGrid="2" name="reference" label="Reference" value=""/>
                        <div class="col-2">
                                <div class="mt-2 mb-4">
                                    {{-- <label class="mr-2" for="yes">Signboard</label> --}}
                                    <div class="form-check-inline">
                                        <label class="form-check-label" for="new">
                                            <input type="radio" class="form-check-input link_type" id="new" name="link_type"
                                                value="new" @checked(@$signboard == 'new' || ($form_method == 'POST' && !old()))>
                                            New
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <label class="form-check-label" for="existing">
                                            <input type="radio" class="form-check-input link_type" id="existing" name="link_type"
                                                value="existing" @checked(@$signboard == 'existing')>
                                            Existing
                                        </label>
                                    </div>
                                </div>
                        </div>
                        <x-input-box colGrid="2" name="link_name" label="Link Name" value=""/>
                        <x-input-box colGrid="2" name="vendor" label="Vendor" value=""/>
                        <input type="hidden" id="vendor_id" name="vendor_id">
                        <x-input-box colGrid="2" name="bbts_link_id" label="BBTS Link Id" value=""/>
                        <div class="col-1"></div>
                    </div>
                    <div class="row">
                        <div class="col-1"></div>
                        <div class="col-6 mb-4 display-6">From Info :</div>
                        <div class="col-3 mb-4 display-6">To Info :</div>
                    </div>
                    <div class="row">
                        <div class="col-1"></div>
                        <x-input-box colGrid="2" name="from_location" label="From Location" value="" placeholder="POP"/>
                        <input type="hidden" id="from_pop_id" name="from_pop_id">
                        <div class="col-2"></div>
                        <div class="col-2">
                            <div class="mt-2 mb-4">
                                    {{-- <label class="mr-2" for="yes">Signboard</label> --}}
                                    <div class="form-check-inline">
                                        <label class="form-check-label" for="link">
                                            <input type="radio" class="form-check-input link_type" id="link" name="link_type"
                                                value="link" @checked(@$signboard == 'link' || ($form_method == 'POST' && !old()))>
                                            Link
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <label class="form-check-label" for="backbone">
                                            <input type="radio" class="form-check-input link_type" id="backbone" name="link_type"
                                                value="backbone" @checked(@$signboard == 'backbone')>
                                                Backbone
                                        </label>
                                    </div>
                                </div>
                        </div>
                        <div class="form-group col-2">
                            <div class="input-group input-group-sm input-group-primary">
                                <select class="form-control" id="division_id" name="division_id" required>
                                    <option value="">Select division</option>
                                    @foreach (@$divisions as $division)
                                        <option value="{{ $division->id }}"
                                            {{ (old('division_id') ?? ($branch->division_id ?? '')) == $division->id ? 'selected' : '' }}>
                                            {{ $division->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <x-input-box colGrid="2" name="to_location" label="To Location" value=""/>
                        <input type="hidden" id="to_pop_id" name="to_pop_id">
                    </div>
                    <div class="row">
                        <div class="col-1"></div>
                        <x-input-box colGrid="2" name="from_site" label="From Site" value="" placeholder="LDP"/>
                        <div class="col-4"></div>
                        <div class="form-group col-2">
                            <div class="input-group input-group-sm input-group-primary">
                                <select class="form-control" id="district_id" name="district_id" required>
                                    <option value="">Select district</option>
                                    @if ($formType == 'edit')
                                        @foreach (@$districts as $district)
                                            <option value="{{ $district->id }}"
                                                {{ (old('district_id') ?? ($branch->district_id ?? '')) == $district->id ? 'selected' : '' }}>
                                                {{ $district->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <x-input-box colGrid="2" name="to_site" label="To Site" value="" placeholder="LDP/POC"/>
                    </div>
                    <div class="row">
                        <div class="col-2"></div>
                        <div class="col-3"></div>
                        <div class="col-2"></div>
                        <div class="form-group col-2">
                            <div class="input-group input-group-sm input-group-primary">
                                <select class="form-control" id="thana_id" name="thana_id" required>
                                    <option value="">Select thana</option>
                                    @if ($formType == 'edit')
                                        @foreach (@$thanas as $thana)
                                            <option value="{{ $thana->id }}"
                                                {{ (old('thana_id') ?? ($branch->thana_id ?? '')) == $thana->id ? 'selected' : '' }}>
                                                {{ $thana->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <x-input-box colGrid="2" name="gps" label="GPS" value="" placeholder="Lat/Long"/>
                    </div>
                </div>
            </div>
            <hr class="text-danger"/>
            <div class="card">
                <div class="text-center mt-4">
                    <h5> <span> &#10070; </span> Technical Information <span>&#10070;</span> </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-1"></div>
                        <x-input-box colGrid="2" name="vendor_link_id" label="Vendor Link Id" value=""/>
                        <x-input-box colGrid="2" name="vendor_vlan" label="Vendor VLAN" value=""/>
                        <x-input-box colGrid="2" name="port" label="Port" value=""/>
                        <x-input-box colGrid="2" name="date_of_commissioning" label="Date Of Commissioning" value="" class="date"/>
                        <x-input-box colGrid="2" name="date_of_termination" label="Date Of Termination" value="" class="date"/>
                    </div>
                    <div class="row">
                        <div class="col-1"></div>
                        <x-input-box colGrid="2" name="activation_date" label="Activation Date" value="" class="date"/>
                        <x-input-box colGrid="4" name="remarks" label="Remarks" value=""/>
                    </div>
                </div>
            </div>
            <hr class="text-danger"/>
            <div class="card">
                <div class="text-center mt-4">
                    <h5> <span> &#10070; </span> Billing Information <span>&#10070;</span> </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-1"></div>
                        <x-input-box colGrid="3" name="capacity_type" label="Capacity Type" value=""/>
                        <x-input-box colGrid="2" name="existing_capacity" label="Existing Capacity" value=""/>
                        <x-input-box colGrid="2" name="new_capacity" label="New Capacity" value=""/>
                        <x-input-box colGrid="3" name="terrif_per_month" label="Terrif Per Month" value=""/>
                        <div class="col-1"></div>
                    </div>
                    <div class="row">
                        <div class="col-1"></div>
                        <div class="col-2">
                            <label>
                                <input type="radio" name="increament_type" value="increase" id="increase">
                                <i class="helper"></i>Increase
                            </label>
                        </div>
                        <div class="col-2">
                            <label>
                                <input type="radio" name="increament_type" value="decrease" id="decrease">
                                <i class="helper"></i>Decrease
                            </label>
                        </div>
                        <div class="col-3"></div>
                        <x-input-box colGrid="3" name="amount" label="Amount" value=""/>
                    </div>
                    <div class="row">
                        <div class="col-6"></div>
                        <x-input-box colGrid="2" name="vat_percent" label="VAT (%)" value=""/>
                        <x-input-box colGrid="3" name="vat" label="VAT" value=""/>
                    </div>
                    <div class="row">
                        <div class="col-8"></div>
                        <x-input-box colGrid="3" name="total" label="Total" value="" attr="readonly"/>
                    </div>
                </div>
            </div>
            <button class="py-2 btn btn-success ">{{ !empty($lead_generation->id) ? 'Update' : 'Save' }}</button>
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
                    $('#link_name').val('');
                })
                $('#link_name').on('keyup', function() {
                    if($('input[name="link_type"]:checked').val() === 'existing'){
                        let myObject = { 
                                }
                        jquaryUiAjax(this, "{{ route('get_location_info_for_link') }}", uiList, myObject);
                       
                        function uiList(item) {
                            $('#division_id').val(item.division_id).trigger('change');
                            $('#link_name').val(item.link_name).attr('value',item.link_name);
                            $('#vendor_id').val(item.vendor_id).attr('value',item.vendor_id);
                            $('#vendor').val(item.vendor_name).attr('value',item.vendor_name);
                            $('#bbts_link_id').val(item.bbts_link_id).attr('value',item.bbts_link_id);
                            $('#from_location').val(item.from_location).attr('value',item.from_location);
                            $('#from_site').val(item.from_site).attr('value',item.from_site);
                            $('#teck_type').val(item.teck_type).attr('value',item.teck_type);
                            $('#vendor_link_id').val(item.vendor_link_id).attr('value',item.vendor_link_id);
                            $('#vendor_vlan').val(item.vendor_vlan).attr('value',item.vendor_vlan);
                            $('#port').val(item.port).attr('value',item.port);
                            $('#date_of_commissioning').val(item.date_of_commissioning).attr('value',item.date_of_commissioning);
                            $('#date_of_termination').val(item.date_of_termination).attr('value',item.date_of_termination);
                            $('#activation_date').val(item.activation_date).attr('value',item.activation_date);
                            $('#remarks').val(item.remarks).attr('value',item.remarks);
                            $('#capacity_type').val(item.capacity_type).attr('value',item.capacity_type);
                            $('#existing_capacity').val(item.existing_capacity).attr('value',item.existing_capacity);
                            $('#new_capacity').val(item.new_capacity).attr('value',item.new_capacity);
                            $('#terrif_per_month').val(item.terrif_per_month).attr('value',item.terrif_per_month);
                            $('#amount').val(item.amount).attr('value',item.amount);
                            $('#vat_percent').val(item.vat_percent).attr('value',item.vat_percent);
                            $('#vat').val(item.vat).attr('value',item.vat);
                            $('#total').val(item.total).attr('value',item.total);
                            if(item.increament_type == 'increase'){
                                $('#increase').attr('checked',true);
                            }else{
                                $('#decrease').attr('checked',true);
                            }
                            $('#district_id').on('DOMNodeInserted', function() {
                                $('#district_id').val(item.district_id).trigger('change');
                            });
                            $('#thana_id').on('DOMNodeInserted',function() {
                                $('#thana_id').val(item.thana_id).trigger('change');
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
                    let myObject = { 
                                }
                        jquaryUiAjax(this, "{{ route('get_pops') }}", uiList, myObject);
                       
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
                    let myObject = { 
                                }
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
                    let myObject = { 
                    }
                    jquaryUiAjax(this, "{{ route('get_vendors') }}", uiList, myObject);

                    function uiList(item) {
                        $('#vendor').val(item.label);
                        $('#vendor_id').val(item.id);
                        return false;
                    }
                });
                
            })
            $('#link_type').on('change',function(){
                emptyField();
            })
            function emptyField(){
                            $('#division_id').val(null);
                            $('#from_location').val(null).attr('value',null);
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
                console.log(amount);
                if(amount != 0 && vat_percent){
                    var vat = Number(amount) * Number(vat_percent) / 100;
                }else{
                    var vat = 0;
                }
                console.log(vat);
                $('#vat').val(vat).attr('value',vat);
                let total = Number(amount) + Number(vat);
                $('#amount').val(amount).attr('value',amount);
                $('#total').val(total).attr('value',total);
            }
    </script>
@endsection
