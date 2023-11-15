@extends('layouts.backend-layout')
@section('title', 'Client Profile')

@php
    $is_old = old('client_name') ? true : false;
    $form_heading = !empty($client_profile->id) ? 'Update' : 'Add';
    $form_url = !empty($client_profile->id) ? route('client-profile.update', $client_profile->id) : route('client-profile.store');
    $form_method = !empty($client_profile->id) ? 'PUT' : 'POST';
@endphp

@section('breadcrumb-title')
    {{ ucfirst($form_heading) }} Client Profile
@endsection

@section('breadcrumb-button')
    <a href="{{ route('client-profile.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('style')
    <style>
        .floating-label {
            font-size: 11px;
            top: -5px;
            position: absolute;
            left: 10px;
            color: #999;
            transition: all 0.2s ease-in-out;
        }
    </style>
@endsection

@php
    $client_no = $is_old ? old('client_id') : $client_profile->client_no ?? null;
    $client_name = $is_old ? old('client_name') : $client_profile->client_name ?? null;
    $location = $is_old ? old('location') : $client_profile->location ?? null;
    $single_division = $is_old ? old('division') : $client_profile->division_id ?? null;
    $single_district = $is_old ? old('district') : $client_profile->district_id ?? null;
    $single_thana = $is_old ? old('thana') : $client_profile->thana_id ?? null;
    $lat = $is_old ? old('lat_long') : $client_profile->lat ?? null;
    $long = $is_old ? old('lat_long') : $client_profile->long ?? null;
    $contact_person = $is_old ? old('contact_person') : $client_profile->contact_person ?? null;
    $designation = $is_old ? old('designation') : $client_profile->designation ?? null;
    $contact_no = $is_old ? old('contact_no') : $client_profile->contact_no ?? null;
    $email = $is_old ? old('email') : $client_profile->email ?? null;
    $client_type = $is_old ? old('client_type') : $client_profile->client_type ?? null;
    $business_type = $is_old ? old('business_type') : $client_profile->business_type ?? null;
    $thanas = $thanas ?? null;
    $districts = $districts ?? null;
    $billing_thanas = $billing_thanas ?? null;
    $billing_districts = $billing_districts ?? null;
    $collection_thanas = $collection_thanas ?? null;
    $collection_districts = $collection_districts ?? null;
    $reg_no = $is_old ? old('reg_no') : $client_profile->reg_no ?? null;
    //billing info
    $billing_contact_person = $is_old ? old('billing_contact_person') : $client_profile->billingAddres->contact_person ?? null;
    $billing_designation = $is_old ? old('billing_designation') : $client_profile->billingAddres->designation ?? null;
    $billing_contact_no = $is_old ? old('billing_contact_no') : $client_profile->billingAddres->phone ?? null;
    $billing_email = $is_old ? old('billing_email') : $client_profile->billingAddres->email ?? null;
    $billing_address = $is_old ? old('billing_address') : $client_profile->billingAddres->address ?? null;
    $single_billing_division = $is_old ? old('billing_division') : $client_profile->billingAddres->division_id ?? null;
    $single_billing_district = $is_old ? old('billing_district') : $client_profile->billingAddres->district_id ?? null;
    $single_billing_thana = $is_old ? old('billing_thana') : $client_profile->billingAddres->thana_id ?? null;
    $submission_by = $is_old ? old('submission_by') : $client_profile->billingAddres->submission_by ?? null;
    $submission_date = $is_old ? old('submission_date') : $client_profile->billingAddres->submission_date ?? null;
    //collection info
    $collection_contact_person = $is_old ? old('collection_contact_person') : $client_profile->collectionAddres->contact_person ?? null;
    $collection_designation = $is_old ? old('collection_designation') : $client_profile->collectionAddres->designation ?? null;
    $collection_contact_no = $is_old ? old('collection_contact_no') : $client_profile->collectionAddres->phone ?? null;
    $collection_email = $is_old ? old('collection_email') : $client_profile->collectionAddres->email ?? null;
    $collection_address = $is_old ? old('collection_address') : $client_profile->collectionAddres->address ?? null;
    $single_collection_division = $is_old ? old('collection_division') : $client_profile->collectionAddres->division_id ?? null;
    $single_collection_district = $is_old ? old('collection_district') : $client_profile->collectionAddres->district_id ?? null;
    $single_collection_thana = $is_old ? old('collection_thana') : $client_profile->collectionAddres->thana_id ?? null;
    $payment_method = $is_old ? old('payment_method') : $client_profile->collectionAddres->payment_method ?? null;
    $payment_date = $is_old ? old('payment_date') : $client_profile->collectionAddres->payment_date ?? null;
    //document
    $nid = $is_old ? old('nid') : $client_profile->nid ?? null;
    $trade_license = $is_old ? old('trade_license') : $client_profile->trade_license ?? null;
    $photo = $is_old ? old('photo') : $client_profile->photo ?? null;
@endphp

@section('content-grid', null)

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="tableHeading">
                    <h5> <span> &#10070; </span> Client Profile <span>&#10070;</span> </h5>
                </div>
                <br>
                <br>
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div id="wizarda">
                                <section>
                                    <form class="wizard-form" id="basic-forms"
                                        action="{{ !empty($client_profile->id) ? route('client-profile.update', $client_profile->id) : route('client-profile.store') }}"
                                        method="post" enctype="multipart/form-data">
                                        @if (!empty($client_profile->id))
                                            @method('PUT')
                                        @endif
                                        @csrf
                                        <h3>
                                            Client Information
                                        </h3>
                                        <fieldset>
                                            <div class="card">
                                                <div class="card-title">
                                                    <h4 class="text-center mt-3">Client Information</h4>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group row">
                                                        <div class="col-sm-4">
                                                            <div class="form-item">
                                                                <input type="text" id="client_name" name="client_name"
                                                                    class="form-control" autocomplete="off"
                                                                    value="{{ $client_name }}" required>
                                                                <label for="client_name">Client Name</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-item">
                                                                <input type="text" id="client_no" name="client_no"
                                                                    class="form-control" autocomplete="off"
                                                                    value="{{ $client_no }}" required readonly>
                                                                <label for="client_id">Client ID</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-md-4">
                                                            <div class="input-group input-group-sm input-group-primary">
                                                                <select name="client_type" id="client_type"
                                                                    class="form-control select2" required>
                                                                    <option>Client Type</option>
                                                                    <option value="Corporate"
                                                                        {{ $client_type == 'Corporate' ? 'selected' : '' }}>
                                                                        Corporate</option>
                                                                    <option value="Individual"
                                                                        {{ $client_type == 'Individual' ? 'selected' : '' }}>
                                                                        Individual</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        {{-- reg_no --}}
                                                        <div class="col-xl-4 col-md-4">
                                                            <div class="form-item">
                                                                <input type="text" id="reg_no" name="reg_no"
                                                                    class="form-control" autocomplete="off"
                                                                    value="{{ $reg_no }}" required>
                                                                <label for="reg_no">Registration No</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-md-4">
                                                            <div class="input-group input-group-sm input-group-primary">
                                                                <select name="business_type" id="business_type"
                                                                    class="form-control select2">
                                                                    <option>Business Type</option>
                                                                    @foreach ($organizations as $organization)
                                                                        <option value="{{ $organization }}"
                                                                            {{ $organization == $business_type ? 'selected' : '' }}>
                                                                            {{ $organization }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-item">
                                                                <select name="division_id" id="division"
                                                                    class="form-control select2">
                                                                    <option value="">Select Division</option>
                                                                    @foreach ($divisions as $division)
                                                                        <option value="{{ $division->id }}"
                                                                            {{ $single_division == $division->id ? 'selected' : '' }}>
                                                                            {{ $division->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-item">
                                                                <select name="district_id" id="district"
                                                                    class="form-control select2">
                                                                    <option value="">Select District</option>
                                                                    @if ($districts)
                                                                        @foreach ($districts as $district)
                                                                            <option value="{{ $district->id }}"
                                                                                {{ $single_district == $district->id ? 'selected' : '' }}>
                                                                                {{ $district->name }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-item">
                                                                <select name="thana_id" id="thana"
                                                                    class="form-control select2">
                                                                    <option value="">Select Thana</option>
                                                                    @if ($thanas)
                                                                        @foreach ($thanas as $thana)
                                                                            <option value="{{ $thana->id }}"
                                                                                {{ $single_thana == $thana->id ? 'selected' : '' }}>
                                                                                {{ $thana->name }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-item">
                                                                <input type="text" id="location" name="location"
                                                                    class="form-control" autocomplete="off"
                                                                    value="{{ $location }}" required>
                                                                <label for="location">Location</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-item">
                                                                <input type="text" id="lat" name="lat"
                                                                    class="form-control" autocomplete="off"
                                                                    value="{{ $lat }}" required>
                                                                <label for="lat">Lat</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-item">
                                                                <input type="text" id="long" name="long"
                                                                    class="form-control" autocomplete="off"
                                                                    value="{{ $long }}" required>
                                                                <label for="long">Long</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-md-4">
                                                            <div class="form-item">
                                                                <input type="text" id="contact_person"
                                                                    name="contact_person" class="form-control"
                                                                    autocomplete="off" value="{{ $contact_person }}"
                                                                    required>
                                                                <label for="contact_person">Contact Person</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-md-4">
                                                            <div class="form-item">
                                                                <input type="text" id="designation" name="designation"
                                                                    class="form-control" autocomplete="off"
                                                                    value="{{ $designation }}" required>
                                                                <label for="designation">Designation</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-md-4">
                                                            <div class="form-item">
                                                                <input type="text" id="contact_no" name="contact_no"
                                                                    class="form-control" autocomplete="off"
                                                                    value="{{ $contact_no }}" required>
                                                                <label for="contact_no">Contact No</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-md-4">
                                                            <div class="form-item">
                                                                <input type="text" id="email" name="email"
                                                                    class="form-control" autocomplete="off"
                                                                    value="{{ $email }}" required>
                                                                <label for="email">Email</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <h3>
                                            Billing
                                            information
                                        </h3>
                                        <fieldset>
                                            <div class="card">
                                                <div class="card-title">
                                                    <h5 class="text-center mt-3">Billing Information</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group row">
                                                        <div class="col-xl-4 col-md-4">
                                                            <div class="form-item">
                                                                <input type="text" id="billing_contact_person"
                                                                    name="billing_contact_person" class="form-control"
                                                                    autocomplete="off"
                                                                    value="{{ $billing_contact_person }}" required>
                                                                <label for="billing_contact_person">Contact Person</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-md-4">
                                                            <div class="form-item">
                                                                <input type="text" id="billing_designation"
                                                                    name="billing_designation" class="form-control"
                                                                    autocomplete="off" value="{{ $billing_designation }}"
                                                                    required>
                                                                <label for="billing_designation">Designation</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-md-4">
                                                            <div class="form-item">
                                                                <input type="text" id="billing_contact_no"
                                                                    name="billing_contact_no" class="form-control"
                                                                    autocomplete="off" value="{{ $billing_contact_no }}"
                                                                    required>
                                                                <label for="billing_contact_no">Contact No</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-md-4">
                                                            <div class="form-item">
                                                                <input type="text" id="billing_email"
                                                                    name="billing_email" class="form-control"
                                                                    autocomplete="off" value="{{ $billing_email }}"
                                                                    required>
                                                                <label for="billing_email">Email</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-item">
                                                                <select name="billing_division" id="billing_division"
                                                                    class="form-control select2"
                                                                    onchange="getDistrict('billing',this.value)">
                                                                    <option value="">Select Division</option>
                                                                    @foreach ($divisions as $division)
                                                                        <option value="{{ $division->id }}"
                                                                            {{ $single_billing_division == $division->id ? 'selected' : '' }}>
                                                                            {{ $division->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-item">
                                                                <select name="billing_district" id="billing_district"
                                                                    class="form-control select2"
                                                                    onchange="getThana('billing',this.value)">
                                                                    <option value="">Select District</option>
                                                                    @if ($districts)
                                                                        @foreach ($billing_districts as $district)
                                                                            <option value="{{ $district->id }}"
                                                                                {{ $single_billing_district == $district->id ? 'selected' : '' }}>
                                                                                {{ $district->name }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-item">
                                                                <select name="billing_thana" id="billing_thana"
                                                                    class="form-control select2">
                                                                    <option value="">Select Thana</option>
                                                                    @if ($thanas)
                                                                        @foreach ($billing_thanas as $thana)
                                                                            <option value="{{ $thana->id }}"
                                                                                {{ $single_billing_thana == $thana->id ? 'selected' : '' }}>
                                                                                {{ $thana->name }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-item">
                                                                <input type="text" id="billing_address"
                                                                    name="billing_address" class="form-control"
                                                                    autocomplete="off" value="{{ $billing_address }}"
                                                                    required>
                                                                <label for="billing_address">Billing Address</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-item">
                                                                <input type="text" id="submitted_user_id"
                                                                    name="submitted_user_id" class="form-control"
                                                                    autocomplete="off" value="{{ $submission_by }}"
                                                                    required>
                                                                <label for="submitted_user_id">Bill to be submission
                                                                    by</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-item">
                                                                <input type="text" id="bill_submission_date"
                                                                    name="bill_submission_date" class="form-control"
                                                                    autocomplete="off" value="{{ $submission_date }}"
                                                                    required>
                                                                <label for="bill_submission_date">Bill Submission
                                                                    Date</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <h3>
                                            Collection
                                            information
                                        </h3>
                                        <fieldset>
                                            <div class="card">
                                                <div class="card-title">
                                                    <h5 class="text-center mt-3">Collection Information</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group row">
                                                        <div class="col-xl-4 col-md-4">
                                                            <div class="form-item">
                                                                <input type="text" id="collection_contact_person"
                                                                    name="collection_contact_person" class="form-control"
                                                                    autocomplete="off"
                                                                    value="{{ $collection_contact_person }}" required>
                                                                <label for="collection_contact_person">Contact
                                                                    Person</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-md-4">
                                                            <div class="form-item">
                                                                <input type="text" id="collection_designation"
                                                                    name="collection_designation" class="form-control"
                                                                    autocomplete="off"
                                                                    value="{{ $collection_designation }}" required>
                                                                <label for="collection_designation">Designation</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-md-4">
                                                            <div class="form-item">
                                                                <input type="text" id="collection_contact_no"
                                                                    name="collection_contact_no" class="form-control"
                                                                    autocomplete="off"
                                                                    value="{{ $collection_contact_no }}" required>
                                                                <label for="collection_contact_no">Contact No</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-md-4">
                                                            <div class="form-item">
                                                                <input type="text" id="collection_email"
                                                                    name="collection_email" class="form-control"
                                                                    autocomplete="off" value="{{ $collection_email }}"
                                                                    required>
                                                                <label for="collection_email">Email</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-item">
                                                                <select name="collection_division"
                                                                    id="collection_division" class="form-control select2"
                                                                    onchange="getDistrict('collection',this.value)">
                                                                    <option value="">Select Division</option>
                                                                    @foreach ($divisions as $division)
                                                                        <option value="{{ $division->id }}"
                                                                            {{ $single_collection_division == $division->id ? 'selected' : '' }}>
                                                                            {{ $division->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-item">
                                                                <select name="collection_district"
                                                                    id="collection_district" class="form-control select2"
                                                                    onchange="getThana('collection',this.value)">
                                                                    <option value="">Select District</option>
                                                                    @if ($districts)
                                                                        @foreach ($collection_districts as $district)
                                                                            <option value="{{ $district->id }}"
                                                                                {{ $single_collection_district == $district->id ? 'selected' : '' }}>
                                                                                {{ $district->name }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-item">
                                                                <select name="collection_thana" id="collection_thana"
                                                                    class="form-control select2">
                                                                    <option value="">Select Thana</option>
                                                                    @if ($thanas)
                                                                        @foreach ($collection_thanas as $thana)
                                                                            <option value="{{ $thana->id }}"
                                                                                {{ $single_collection_thana == $thana->id ? 'selected' : '' }}>
                                                                                {{ $thana->name }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-item">
                                                                <input type="text" id="collection_address"
                                                                    name="collection_address" class="form-control"
                                                                    autocomplete="off" value="{{ $collection_address }}"
                                                                    required>
                                                                <label for="location">Address</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-item">
                                                                <input type="text" id="payment_method"
                                                                    name="payment_method" class="form-control"
                                                                    autocomplete="off" value="{{ $payment_method }}"
                                                                    required>
                                                                <label for="payment_method">Payment Method</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-item">
                                                                <input type="text" id="approximate_payment_date"
                                                                    name="approximate_payment_date" class="form-control"
                                                                    autocomplete="off" value="{{ $payment_date }}"
                                                                    required>
                                                                <label for="approximate_payment_date">Approximate Payment
                                                                    Date
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <h3>
                                            Required Documents
                                        </h3>
                                        <fieldset>
                                            <div class="card">
                                                <div class="card-title">
                                                    <h5 class="text-center mt-3">Required Documents</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group row">
                                                        <div class="col-sm-4">
                                                            <div>
                                                                <label for="trade_license">Trade License</label>
                                                                <input type="file" id="trade_license"
                                                                    name="trade_license" class="form-control"
                                                                    autocomplete="off" value="" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div>
                                                                <label for="nid">NID</label>
                                                                <input type="file" id="nid" name="nid"
                                                                    class="form-control" autocomplete="off"
                                                                    value="" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div>
                                                                <label for="nid">Photo</label>
                                                                <input type="file" id="photo" name="photo"
                                                                    class="form-control" autocomplete="off"
                                                                    value="" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        @if ($trade_license)
                                                            <div class="col-sm-4 col-4 text-center">
                                                                <a class="btn btn-sm btn-success"
                                                                    href="{{ asset('uploads/client_profile/trade_license/' . $trade_license) }}"
                                                                    target="_blank"><i class="fa fa-eye"></i></a>
                                                            </div>
                                                        @endif
                                                        @if ($nid)
                                                            <div class="col-sm-4 col-4 text-center">
                                                                <a href="{{ asset('uploads/client_profile/nid/' . $nid) }}"
                                                                    target="_blank" class="btn btn-sm btn-success"><i
                                                                        class="fa fa-eye"></i></a>
                                                            </div>
                                                        @endif
                                                        @if ($photo)
                                                            <div class="col-sm-4 col-4 text-center">
                                                                <a href="{{ asset('uploads/client_profile/photo/' . $photo) }}"
                                                                    target="_blank" class="btn btn-sm btn-success"><i
                                                                        class="fa fa-eye"></i></a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </form>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('script')

        <script>
            function getDistrict(prefix, division_id) {
                var html = '<option value="">Select District</option>';
                $.ajax({
                    url: "{{ route('get-districts') }}",
                    data: {
                        division_id: division_id,
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        data.forEach(element => {
                            html += '<option value="' + element.id + '">' + element
                                .text +
                                '</option>';
                        });
                        $('#' + prefix + '_' + 'district').html(html);
                    }
                });
            }

            function getThana(prefix, district_id) {
                var html = '<option value="">Select Thana</option>';
                $.ajax({
                    url: "{{ route('get-thanas') }}",
                    data: {
                        district_id: district_id,
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        data.forEach(element => {
                            html += '<option value="' + element.id + '">' + element
                                .text +
                                '</option>';
                        });
                        $('#' + prefix + '_' + 'thana').html(html);
                    }
                });
            }

            $(document).ready(function() {
                $('#division').on('change', function() {
                    var division_id = $(this).val();
                    var html = '';
                    $.ajax({
                        url: "{{ route('get-districts') }}",
                        data: {
                            division_id: division_id,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            html += '<option value="">Select District</option>';
                            data.forEach(element => {
                                html += '<option value="' + element.id + '">' + element
                                    .text +
                                    '</option>';
                            });
                            $('#district').html(html);
                        }
                    });
                });

                $('#district').on('change', function() {
                    var district_id = $(this).val();
                    var html = '';
                    $.ajax({
                        url: "{{ route('get-thanas') }}",
                        data: {
                            district_id: district_id,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            html += '<option value="">Select Thana</option>';
                            data.forEach(element => {
                                html += '<option value="' + element.id + '">' + element
                                    .text +
                                    '</option>';
                            });
                            $('#thana').html(html);
                        }
                    });
                });

                $('#client_name').on('input', function() {
                    var client_name = $(this).val();
                    $(this).autocomplete({
                        source: function(request, response) {
                            $.ajax({
                                url: "{{ route('get-client-information-for-profile') }}",
                                data: {
                                    client_name: client_name,
                                    _token: "{{ csrf_token() }}"
                                },
                                success: function(data) {
                                    setDistrict(data.districts);
                                    setThana(data.thanas);
                                    response(data.lead_generation);
                                }
                            });
                        },
                        select: function(event, ui) {
                            $('#client_no').val(ui.item.value).attr('value', ui.item.value);
                            $('#client_name').val(ui.item.client_name).attr('value', ui.item
                                .client_name);
                            $('#client_type').val(ui.item.client_type).attr('value', ui.item
                                .client_type).trigger(
                                'change');
                            $('#business_type').val(ui.item.business_type).attr('value', ui.item
                                .business_type).trigger(
                                'change');
                            $('#division').val(ui.item.division).attr('value', ui.item.division)
                                .trigger(
                                    'change');
                            $('#district').val(ui.item.district).attr('value', ui.item.district)
                                .trigger('change');
                            $('#thana').val(ui.item.thana).attr('value', ui.item.thana).trigger(
                                'change');
                            $('#location').val(ui.item.location).attr('value', ui.item.location);
                            $('#contact_person').val(ui.item.contact_person).attr('value', ui.item
                                .contact_person);
                            $('#contact_no').val(ui.item.contact_no).attr('value', ui.item
                                .contact_no);
                            $('#email').val(ui.item.email).attr('value', ui.item.email);
                            $('#designation').val(ui.item.designation).attr('value', ui.item
                                .designation);
                            $('#lat').val(ui.item.lat).attr('value', ui.item.lat);
                            $('#long').val(ui.item.long).attr('value', ui.item.long);
                            return false;
                        }
                    });
                });

                function setDistrict(district) {
                    var html = '<option value="">Select District</option>';
                    district.forEach(element => {
                        html += '<option value="' + element.id + '">' + element.name +
                            '</option>';
                    });
                    $('#district').html(html);
                }

                function setThana(thana) {
                    var html = '<option value="">Select Thana</option>';
                    thana.forEach(element => {
                        html += '<option value="' + element.id + '">' + element.name +
                            '</option>';
                    });
                    $('#thana').html(html);
                }
                $('#finishButton').on('click', function() {
                    $('#basic-forms').submit();
                });
            });
        </script>
    @endsection
