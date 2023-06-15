@extends('layouts.backend-layout')
@section('title', 'Services')

@php
    $is_old = old('client_id') ? true : false;
    $form_heading = !empty($survey->id) ? 'Update' : 'Add';
    $form_url = !empty($survey->id) ? route('services.update', $survey->id) : route('services.store');
    $form_method = !empty($survey->id) ? 'PUT' : 'POST';
@endphp

@section('breadcrumb-title')
    {{ ucfirst($form_heading) }} Services
@endsection

@section('breadcrumb-button')
    <a href="{{ route('services.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
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
                <div class="tableHeading">
                    <h5> <span> &#10070; </span> New Service <span>&#10070;</span> </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <x-input-box colGrid="2" name="reference" label="Reference" value="" />
                        <x-input-box colGrid="2" name="bbts_link_id" id="bbts_link_id" label="BBTS Link Id"
                            value="" attr="required" />
                        <div class="col-2">
                            <div class="mt-2 mb-4">
                                <div class="form-check-inline">
                                    <label class="form-check-label" for="new">
                                        <input type="radio" class="form-check-input service_type" id="new"
                                            name="service_type" value="new" @checked(@$signboard == 'new' || ($form_method == 'POST' && !old()))>
                                        New
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label" for="existing">
                                        <input type="radio" class="form-check-input service_type" id="existing"
                                            name="service_type" value="existing" @checked(@$signboard == 'existing')>
                                        Existing
                                    </label>
                                </div>
                            </div>
                        </div>
                        <x-input-box colGrid="2" name="link_name" label="Link Name" value="" attr="readonly" />
                        <x-input-box colGrid="2" name="vendor" label="Vendor" value="" attr="readonly" />
                        <x-input-box colGrid="2" id="vendor_id" name="vendor_id" label="Vendor Link ID" value=""
                            attr="readonly" />
                    </div>
                    <div class="row">
                        <div class="col-1"></div>
                        <div class="col-6 mb-4 display-6">From Info :</div>
                        <div class="col-3 mb-4 display-6">To Info :</div>
                    </div>
                    <div class="row">
                        <div class="col-1"></div>
                        <x-input-box colGrid="2" name="from_location" label="From Location1" value=""
                            placeholder="POP" attr="readonly" />
                        <input type="hidden" id="from_pop_id" name="from_pop_id">
                        <div class="col-2"></div>
                        <div class="col-2">
                        </div>
                        <x-input-box colGrid="2" name="division_id" label="Division" value=""
                            placeholder="Division name" attr="readonly" />
                        <x-input-box colGrid="2" name="to_location" label="To Location" value="" attr="readonly" />
                        <input type="hidden" id="to_pop_id" name="to_pop_id">
                    </div>
                    <div class="row">
                        <div class="col-1"></div>
                        <x-input-box colGrid="2" name="from_site" label="From Site" value="" placeholder="LDP"
                            attr="readonly" />
                        <div class="col-4"></div>
                        <x-input-box colGrid="2" name="district_id" label="District" value=""
                            placeholder="District name" attr="readonly" />
                        <x-input-box colGrid="2" name="to_site" label="To Site" value="" placeholder="LDP/POC"
                            attr="readonly" />
                    </div>
                    <div class="row">
                        <div class="col-2"></div>
                        <div class="col-3"></div>
                        <div class="col-2"></div>
                        <x-input-box colGrid="2" name="thana_id" label="Thana" value=""
                            placeholder="Thana name" attr="readonly" />
                        <x-input-box colGrid="2" name="gps" label="GPS" value="" placeholder="Lat/Long"
                            attr="readonly" />
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <select class="form-control" id="service_status" name="service_status" required>
                                <option value="" selected disabled>Select Status</option>
                                <option value="Increase">Increase</option>
                                <option value="Decrease">Decrease</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                        <x-input-box colGrid="5" name="remarks" label="Remarks" value="" attr="readonly" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="offset-md-3 col-md-6 mt-1">
                    <table class="table table-bordered" id="service_table">
                        <thead>
                            <tr>
                                <th>Service Name</th>
                                <th>Quantity</th>
                                <th>Rate</th>
                                <th>Amount</th>
                                <th>Remarks</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select class="form-control select2 service_id" name="service_id[]" required>
                                        <option value="0" selected disabled>Select Service</option>
                                        @foreach (@$products as $product)
                                            <option value="{{ $product->id }}">
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" class="form-control quantity" name="quantity[]" required>
                                </td>
                                <td>
                                    <input type="number" class="form-control rate" name="rate[]" required>
                                </td>
                                <td>
                                    <input type="number" class="form-control amount" name="amount[]" required>
                                </td>
                                <td>
                                    <input type="text" class="form-control remarks" name="remarks[]" required>
                                </td>
                                <td>
                                    <button type="button"
                                        class="btn btn-success btn-sm fa fa-plus add-service-row"></button>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3 text-right" style="text-align: right;">Total Amout</td>
                                <td>
                                    <input type="number" class="form-control total" name="total" required>
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <button class="py-2 btn btn-success ">{{ !empty($service->id) ? 'Update' : 'Save' }}</button>
        </div>
    </div>

    {!! Form::close() !!}
@endsection

@include('admin::services.js')
