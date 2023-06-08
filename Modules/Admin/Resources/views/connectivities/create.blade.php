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
                        <x-input-box colGrid="2" name="type" label="Type" value=""/>
                        <x-input-box colGrid="2" name="link_name" label="Link Name" value=""/>
                        <x-input-box colGrid="2" name="vendor" label="Vendor" value=""/>
                        <x-input-box colGrid="2" name="link_id" label="BBTS Link Id" value=""/>
                        <div class="col-1"></div>
                    </div>
                    <div class="row">
                        <div class="col-1"></div>
                        <div class="col-6">From Info :</div>
                        <div class="col-3">To Info :</div>
                    </div>
                    <div class="row">
                        <div class="col-1"></div>
                        <x-input-box colGrid="2" name="from_location" label="From Location" value=""/>
                        <div class="col-4"></div>
                        <x-input-box colGrid="2" name="division" label="Division" value=""/>
                        <x-input-box colGrid="2" name="to_location" label="To Location" value=""/>
                    </div>
                    <div class="row">
                        <div class="col-1"></div>
                        <x-input-box colGrid="2" name="from_site" label="From Site" value=""/>
                        <div class="col-4"></div>
                        <x-input-box colGrid="2" name="district" label="District" value=""/>
                        <x-input-box colGrid="2" name="to_site" label="To Site" value=""/>
                    </div>
                    <div class="row">
                        <div class="col-2"></div>
                        <div class="col-3"></div>
                        <div class="col-2"></div>
                        <x-input-box colGrid="2" name="thana" label="Thana" value=""/>
                        <x-input-box colGrid="2" name="gps" label="GPS" value=""/>
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
                        <x-input-box colGrid="3" name="type" label="Type" value=""/>
                        <x-input-box colGrid="2" name="vendor_link_id" label="Vendor Link Id" value=""/>
                        <x-input-box colGrid="2" name="vendor_vlan" label="Vendor VLAN" value=""/>
                        <x-input-box colGrid="3" name="port" label="Port" value=""/>
                        <div class="col-1"></div>
                    </div>
                    <div class="row">
                        <div class="col-1"></div>
                        <x-input-box colGrid="3" name="date_of_commissioning" label="Date Of Commissioning" value=""/>
                        <x-input-box colGrid="2" name="date_of_termination" label="Date Of Termination" value=""/>
                        <x-input-box colGrid="2" name="activation_date" label="Activation Date" value=""/>
                        <div class="col-4"></div>
                    </div>
                    <div class="row">
                        <div class="col-1"></div>
                        <x-input-box colGrid="4" name="remarks" label="Remarks" value=""/>
                        <div class="col-4"></div>
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
                        <div class="col-1"></div>
                        <x-input-box colGrid="2" name="amount" label="Amount" value=""/>
                        <x-input-box colGrid="3" name="vat" label="VAT" value=""/>
                    </div>
                    <div class="row">
                        <div class="col-8"></div>
                        <x-input-box colGrid="3" name="total" label="Total" value=""/>
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
         $('#date_of_commissioning,#date_of_termination,#activation_date').datepicker({
                    format: "dd-mm-yyyy",
                    autoclose: true,
                    todayHighlight: true,
                    showOtherMonths: true
                });
               
    </script>
@endsection
