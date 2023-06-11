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
                            <select class="form-control" id="link_type" name="link_type">
                                <option value="new">New</option>
                                <option value="existing">Existing</option>
                            </select>
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
                        <div class="col-4"></div>
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
                        <div class="col-2">
                            <select class="form-control" id="teck_type" name="teck_type">
                                <option value="link">Link</option>
                                <option value="backbone">Backbone</option>
                            </select>
                        </div>
                        <x-input-box colGrid="2" name="vendor_link_id" label="Vendor Link Id" value=""/>
                        <x-input-box colGrid="2" name="vendor_vlan" label="Vendor VLAN" value=""/>
                        <x-input-box colGrid="2" name="port" label="Port" value=""/>
                    </div>
                    <div class="row">
                        <div class="col-1"></div>
                        <x-input-box colGrid="2" name="date_of_commissioning" label="Date Of Commissioning" value="" class="date"/>
                        <x-input-box colGrid="2" name="date_of_termination" label="Date Of Termination" value="" class="date"/>
                        <x-input-box colGrid="2" name="activation_date" label="Activation Date" value="" class="date"/>
                    </div>
                    <div class="row">
                        <div class="col-1"></div>
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
                                <input type="radio" name="mail_domain" value="Yes">
                                <i class="helper"></i>Increase
                            </label>
                        </div>
                        <div class="col-2">
                            <label>
                                <input type="radio" name="mail_domain" value="No">
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
                })
            })
            $('#new_capacity,#existing_capacity,#terrif_per_month,#vat_percent,#vat').on('keyup',function(){
                Calculatevat();
                Calculatetotal();
            })
            function Calculatevat(){
                $('#vat').val(0);
                   $('#vat').attr('value',0);
               let amount = $('#amount').val() ?? 0;
               let vat_percent = $('#vat_percent').val() ?? 0;
               if(amount && vat_percent){
                   let vat = Number(amount) / Number(vat_percent);
                   $('#vat').val(vat);
                   $('#vat').attr('value',total);
               }
            }
            function Calculatetotal(){
                $('#amount').val(0);
                $('#amount').attr('value',0);
                $('#total').val(0);
                $('#total').attr('value',0);
               let new_capacity = $('#new_capacity').val() ?? 0;
               let existing_capacity = $('#existing_capacity').val() ?? 0;
               let used_capacity = new_capacity - existing_capacity;
               let terrif_per_month = $('#terrif_per_month').val() ?? 0;
               let vat = $('#vat').val() ?? 0;
               if(used_capacity){
                let amount = used_capacity * terrif_per_month;
                let total = Number(amount) + Number(vat);
                $('#amount').val(amount);
                $('#amount').attr('value',amount);
                $('#total').val(total);
                $('#total').attr('value',total);
               }
            }
          
    </script>
@endsection
