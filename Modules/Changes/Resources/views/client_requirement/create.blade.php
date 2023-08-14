@extends('layouts.backend-layout')
@section('title', 'Client Requirement Modification')

@php
    $mod = !empty($clientRequirementModification) ? $clientRequirementModification : null;
    $is_old = old() ? true : false;
    $form_heading = !empty($mod->id) ? 'Update' : 'Add';
    $form_url = !empty($mod->id) ? route('client-requirement-modification.update', $mod->id) : route('client-requirement-modification.store');
    $form_method = !empty($mod->id) ? 'PUT' : 'POST';
    
    $client_no = !empty($mod) ? $mod->client_no : (old('client_no') ? old('client_no') : '');
    $client_name = !empty($mod) ? $mod->client->client_name : (old('client_name') ? old('client_name') : '');
    $date = !empty($mod) ? $mod->date : (old('date') ? old('date') : today()->format('d-m-Y'));
    $activation_date = !empty($mod) ? $mod->activation_date : (old('activation_date') ? old('activation_date') : today()->format('d-m-Y'));
    $fr_no = !empty($mod) ? $mod->fr_no : (old('fr_no') ? old('fr_no') : '');
    $connectivity_remarks = !empty($mod) ? $mod->connectivity_remarks : (old('connectivity_remarks') ? old('connectivity_remarks') : '');
    $change_types = !empty($mod) ? json_decode($mod->change_type) : [];
    $from_date = !empty($mod) ? $mod->from_date : (old('from_date') ? old('from_date') : today()->format('d-m-Y'));
    $to_date = !empty($mod) ? $mod->to_date : (old('to_date') ? old('to_date') : today()->format('d-m-Y'));
    $existing_mrc = !empty($mod) ? $mod->existing_mrc : (old('existing_mrc') ? old('existing_mrc') : '');
    $decrease_mrc = !empty($mod) ? $mod->decrease_mrc : (old('decrease_mrc') ? old('decrease_mrc') : '');
    
@endphp

@section('breadcrumb-title')
    {{ ucfirst($form_heading) }} Client Requirement Modification
@endsection

@section('breadcrumb-button')
    <a href="{{ route('client-requirement-modification.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-list"></i></a>

@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('style')
    <style>
        .custom-loader {
            border: 20px solid #f3f3f3;
            border-top: 20px solid #3498db;
            border-radius: 50%;
            width: 100px;
            height: 100px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
            margin-top: 100px;
            display: none;
            /* Hide the loader by default */
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endsection

@section('content')

    {!! Form::open([
        'url' => $form_url,
        'method' => $form_method,
        'encType' => 'multipart/form-data',
        'class' => 'custom-form',
    ]) !!}

    {{-- Comparative Statement --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="tableHeading">
                    <h5> <span> &#10070; </span> Client Requirement Modification <span>&#10070;</span> </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                    </div>
                    <div class="row">
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="client_no" id="client_no" class="form-control"
                                    value="{{ $client_no }}">
                                <label for="client_id">Client ID <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="client_name" id="client_name" class="form-control"
                                    value="{{ $client_name }}" readonly>
                                <label for="client_name">Client Name <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="date" id="date" class="form-control"
                                    value="{{ $date }}">
                                <label for="date">Date <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="activation_date" id="activation_date" class="form-control"
                                    value="{{ $activation_date }}">
                                <label for="activation_date">Activation Date <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <select name="fr_no" id="fr_no" class="form-control">
                                    <option value="">Select FR No</option>
                                    @if (!empty($mod))
                                        @foreach ($frList as $fr_no)
                                            <option value="{{ $fr_no }}" @selected($fr_no == $fr_no)>
                                                {{ $fr_no }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <label for="fr_no">FR No <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="connectivity_remarks" id="connectivity_remarks"
                                    class="form-control" value="{{ $connectivity_remarks }}">
                                <label for="fr_no">Remarks <span class="text-danger">*</span></label>
                            </div>
                        </div>

                        <div class="md-col-3 col-3" {!! in_array('Temporary-Inactive', $change_types) ? 'style="display: block;"' : 'style="display: none;"' !!}>
                            <div class="form-item">
                                <input type="text" name="from_date" id="from_date" class="form-control"
                                    value="{{ $from_date }}">
                                <label for="fr_no">From date <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3" {!! in_array('Temporary-Inactive', $change_types) ? 'style="display: block;"' : 'style="display: none;"' !!}>
                            <div class="form-item">
                                <input type="text" name="to_date" id="to_date" class="form-control"
                                    value="{{ $to_date }}">
                                <label for="fr_no">To date <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3" {!! in_array('MRC-Decrease', $change_types) ? 'style="display: block;"' : 'style="display: none;"' !!}>
                            <div class="form-item">
                                <input type="text" name="existing_mrc" id="existing_mrc" class="form-control"
                                    value="{{ $existing_mrc }}">
                                <label for="fr_no">Existing MRC <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3" {!! in_array('MRC-Decrease', $change_types) ? 'style="display: block;"' : 'style="display: none;"' !!}>
                            <div class="form-item">
                                <input type="text" name="decrease_mrc" id="decrease_mrc" class="form-control"
                                    value="{{ $decrease_mrc }}">
                                <label for="fr_no">Decrease MRC<span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" name="change_type[]" id="temporary_inactive"
                                        value="Temporary-Inactive" @checked(in_array('Temporary-Inactive', $change_types))>
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span>Temporary-Inactive</span>
                                </label>
                            </div>
                            <div class="checkbox-fade fade-in-primar  y">
                                <label>
                                    <input type="checkbox" name="change_type[]" value="Permanent-Inactive"
                                        @checked(in_array('Temporary-Inactive', $change_types))>
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span>Permanent Inactive</span>
                                </label>
                            </div>
                            <div class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" name="change_type[]" value="Re-Inactive"
                                        @checked(in_array('Re-Inactive', $change_types))>
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span>Re-Inactive</span>
                                </label>
                            </div>
                            <div class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" name="change_type[]" value="B/W Increase/Decrease"
                                        @checked(in_array('B/W Increase/Decrease', $change_types))>
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span>B/W Increase/Decrease</span>
                                </label>
                            </div>
                            <div class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" name="change_type[]" value="IP Increase/Decrease"
                                        @checked(in_array('IP Increase/Decrease', $change_types))>
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span>IP Increase/Decrease</span>
                                </label>
                            </div>
                            <div class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" name="change_type[]" id="mrc_decrease" value="MRC-Decrease"
                                        @checked(in_array('MRC-Decrease', $change_types))>
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span>MRC Decrease</span>
                                </label>
                            </div>
                            <div class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" name="change_type[]"
                                        value="Price Increase/Decrease with BW Change" @checked(in_array('Price Increase/Decrease with BW Change', $change_types))>
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span>Price Increase/Decrease with BW Change</span>
                                </label>
                            </div>
                            <div class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" name="change_type[]" value="Method Change"
                                        @checked(in_array('Method Change', $change_types))>
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span>Method Change</span>
                                </label>
                            </div>
                            <div class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" name="change_type[]" value="Redundant Link"
                                        @checked(in_array('Redundant Link', $change_types))>
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span>Redundant Link</span>
                                </label>
                            </div>
                            <div class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" name="change_type[]" value="Shifting"
                                        @checked(in_array('Shifting', $change_types))>
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span>Shifting</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    {{-- create a responsive table --}}
                    {{-- jquery loader --}}
                    <div id="loader" class="custom-loader"></div>
                    <div id="main-content">
                        <div class="row mt-3">
                            <div id="logical-table" class="md-col-12 col-12" {!! !empty($mod->connectivityProductRequirementDetails) ? 'style="display:block"' : 'style="display:none"' !!}>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th colspan="7">Product Details</th>
                                            </tr>
                                            <tr>
                                                <th>Category</th>
                                                <th>Product</th>
                                                <th>Prev Quantity</th>
                                                <th>Unit</th>
                                                <th>Plan</th>
                                                <th>Remarks</th>
                                                <th>
                                                    <button type="button" class="btn btn-sm btn-success addProductEdit"
                                                        onclick="addProductEdit()"><i class="fas fa-plus"></i></button>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="productBody">
                                            @if (!empty($mod->connectivityProductRequirementDetails))
                                                @foreach ($mod->connectivityProductRequirementDetails as $product)
                                                    <tr>
                                                        <td>
                                                            <select name="category[]" class="form-control category">
                                                                <option value="">Select Category</option>
                                                                @foreach ($categories as $category)
                                                                    <option value="{{ $category->id }}"
                                                                        @if ($category->id == $product->category_id) selected @endif>
                                                                        {{ $category->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select name="product[]" class="form-control product">
                                                                <option value="">Select Product</option>
                                                                @foreach ($products as $data)
                                                                    <option value="{{ $data->id }}"
                                                                        @if ($data->id == $product->product_id) selected @endif>
                                                                        {{ $data->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="prev_quantity[]"
                                                                class="form-control prev_quantity"
                                                                value="{{ $product->prev_quantity }}">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="unit[]"
                                                                class="form-control unit"
                                                                value="{{ $product->product->unit }}">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="plan[]"
                                                                class="form-control plan"
                                                                value="{{ $product->capacity }}">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="remarks[]"
                                                                class="form-control remarks"
                                                                value="{{ $product->remarks }}">
                                                        </td>
                                                        <td>
                                                            <button type="button"
                                                                class="btn btn-sm btn-danger removeProductRow"><i
                                                                    class="fas fa-minus"></i></button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="physical-table" class="md-col-12 col-12" {!! !empty($physicalConnectivity) ? 'style="display:block"' : 'style="display:none"' !!}>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th colspan="7">Existing Link</th>
                                            </tr>
                                            <tr>
                                                <th>Link Type</th>
                                                <th>Method</th>
                                                <th>Vendor</th>
                                                <th>BTS/POP</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="connectivityBody">
                                            @if (!empty($physicalConnectivity))
                                                @foreach ($physicalConnectivity->lines as $line)
                                                    <tr class="connectivity_details_row">
                                                        <td>
                                                            <select class="form-control link_type">
                                                                <option value="">Select Link Type</option>
                                                                <option value="Primary" @selected($line->link_type === 'Primary')>
                                                                    Primary</option>
                                                                <option value="Secondary" @selected($line->link_type === 'Secondary')>
                                                                    Secondary</option>
                                                                <option value="Tertiary" @selected($line->link_type === 'Tertiary')>
                                                                    Tertiary</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select class="form-control method">
                                                                <option value="">Select Method</option>
                                                                <option value="Fiber" @selected($line->method === 'Fiber')>Fiber
                                                                </option>
                                                                <option value="Radio" @selected($line->method === 'Radio')>Radio
                                                                </option>
                                                                <option value="GSM" @selected($line->method === 'GSM')>GSM
                                                                </option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control vendor"
                                                                value="{{ $line->connectivityLink->vendor->name }}">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control bts_pop"
                                                                value="{{ $line->pop }}">
                                                        </td>
                                                        <td>
                                                            <a href="#" title="Edit"
                                                                class="btn btn-sm btn-outline-warning physicalLinkEdit"><i
                                                                    class="fas fa-pen"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div id="physical-table-edit" class="md-col-12 col-12" {!! !empty($mod->connectivityRequirementDetails) ? 'style="display:block"' : 'style="display:none"' !!}>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th colspan="7">New / Update Connectivity Link</th>
                                            </tr>
                                            <tr>
                                                <th>Link Type</th>
                                                <th>Method</th>
                                                <th>Capacity(%)</th>
                                                <th>Uptime Reg/SLA</th>
                                                <th>Vendor</th>
                                                <th>
                                                    <button type="button"
                                                        class="btn btn-sm btn-success addConnectivityEdit"
                                                        onclick="addConnectivityEdit()"><i
                                                            class="fas fa-plus"></i></button>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="connectivityEditBody">
                                            @if (!empty($mod->connectivityRequirementDetails))
                                                @foreach ($mod->connectivityRequirementDetails as $details)
                                                    <tr class="connectivity_details_row">
                                                        <td>
                                                            <select name="link_type[]" class="form-control link_type">
                                                                <option value="">Select Link Type</option>
                                                                <option value="Primary" @selected($details->link_type === 'Primary')>
                                                                    Primary</option>
                                                                <option value="Secondary" @selected($details->link_type === 'Secondary')>
                                                                    Secondary</option>
                                                                <option value="Tertiary" @selected($details->link_type === 'Tertiary')>
                                                                    Tertiary</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select name="method[]" class="form-control method">
                                                                <option value="">Select Method</option>
                                                                <option value="Fiber" @selected($details->method === 'Fiber')>Fiber
                                                                </option>
                                                                <option value="Radio" @selected($details->method === 'Radio')>Radio
                                                                </option>
                                                                <option value="GSM" @selected($details->method === 'GSM')>GSM
                                                                </option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="connectivity_capacity[]"
                                                                class="form-control connectivity_capacity" value="{{ $details->connectivity_capacity }}">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="uptime_req[]"
                                                                class="form-control uptime_req" value="{{ $details->sla }}">
                                                        </td>
                                                        <td>
                                                            <select name="vendor_id[]" class="form-control vendor_id">
                                                                <option value="">Select Vendor</option>
                                                                @foreach ($vendors as $vendor)
                                                                    <option value="{{ $vendor->id }}">
                                                                        {{ $vendor->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <button type="button"
                                                                class="btn btn-sm btn-danger removeConnectivityRow"><i
                                                                    class="fas fa-minus"></i></button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button
                        class="py-2 btn btn-success float-right">{{ !empty($client_request->id) ? 'Update' : 'Save' }}</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

@endsection

@section('script')
    @include('changes::client_requirement.js')
@endsection
