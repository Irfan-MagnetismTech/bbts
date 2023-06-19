@extends('layouts.backend-layout')
@section('title', 'Services')

@php
    $is_old = old('client_id') ? true : false;
    $form_heading = !empty($service->id) ? 'Update' : 'Add';
    $form_url = !empty($service->id) ? route('services.update', $service->id) : route('services.store');
    $form_method = !empty($service->id) ? 'PUT' : 'POST';
    $reference = old('reference', !empty($service) ? $service->reference : null);
    $bbts_link_id = old('bbts_link_id', !empty($service) ? $service->bbts_link_id : null);
    $service_type = old('service_type', !empty($service) ? $service->service_type : null);
    $service_status = old('service_status', !empty($service) ? $service->service_status : null);
    $link_name = old('link_name', !empty($service) ? $service->bbtsLink->link_name : null);
    $vendor = old('vendor', !empty($service) ? $service->bbtsLink->vendor->name : null);
    $vendor_link_id = old('vendor_link_id', !empty($service) ? $service->bbtsLink->vendor_link_id : null);
    $from_location = old('from_location', !empty($service) ? $service->bbtsLink->from_location : null);
    $from_site = old('from_site', !empty($service) ? $service->bbtsLink->from_site : null);
    $to_location = old('to_location', !empty($service) ? $service->bbtsLink->to_location : null);
    $to_site = old('to_site', !empty($service) ? $service->bbtsLink->to_site : null);
    $division_id = old('division_id', !empty($service) ? $service->bbtsLink->division->name : null);
    $district_id = old('district_id', !empty($service) ? $service->bbtsLink->district->name : null);
    $thana_id = old('thana_id', !empty($service) ? $service->bbtsLink->thana->name : null);
    $gps = old('gps', !empty($service) ? $service->bbtsLink->gps : null);
    $remarks = old('remarks', !empty($service) ? $service->bbtsLink->remarks : null);
    $total = old('total', !empty($service) ? $service->total : 0);
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
                    <h5> <span> &#10070; </span> {{ ucfirst($form_heading) }} Service <span>&#10070;</span> </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <x-input-box colGrid="2" name="reference" label="Reference" value="{{ $reference }}" />
                        <x-input-box colGrid="2" name="bbts_link_id" id="bbts_link_id" label="BBTS Link Id"
                            value="{{ $bbts_link_id }}" attr="required" />
                        <div class="col-2">
                            <div class="mt-2 mb-4">
                                <div class="form-check-inline">
                                    <label class="form-check-label" for="new">
                                        <input type="radio" class="form-check-input service_type" id="new"
                                            name="service_type" value="new" @checked(@$service_type == 'new' || ($form_method == 'POST' && !old()))>
                                        New
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label" for="existing">
                                        <input type="radio" class="form-check-input service_type" id="existing"
                                            name="service_type" value="existing" @checked(@$service_type == 'existing')>
                                        Existing
                                    </label>
                                </div>
                            </div>
                        </div>
                        <x-input-box colGrid="2" name="link_name" label="Link Name" value="{{ $link_name }}"
                            attr="readonly" />
                        <x-input-box colGrid="2" name="vendor" label="Vendor" value="{{ $vendor }}"
                            attr="readonly" />
                        <x-input-box colGrid="2" id="vendor_link_id" name="vendor_link_id" label="Vendor Link ID"
                            value="{{ $vendor_link_id }}" attr="readonly" />
                    </div>
                    <div class="row">
                        <div class="col-1"></div>
                        <div class="col-6 mb-4 display-6">From Info :</div>
                        <div class="col-3 mb-4 display-6">To Info :</div>
                    </div>
                    <div class="row">
                        <div class="col-1"></div>
                        <x-input-box colGrid="2" name="from_location" label="From Location1" value="{{ $from_location }}"
                            placeholder="POP" attr="readonly" />
                        <input type="hidden" id="from_pop_id" name="from_pop_id">
                        <div class="col-2"></div>
                        <div class="col-2">
                        </div>
                        <x-input-box colGrid="2" name="division_id" label="Division" value="{{ $division_id }}"
                            placeholder="Division name" attr="readonly" />
                        <x-input-box colGrid="2" name="to_location" label="To Location" value="{{ $to_location }}"
                            attr="readonly" />
                        <input type="hidden" id="to_pop_id" name="to_pop_id">
                    </div>
                    <div class="row">
                        <div class="col-1"></div>
                        <x-input-box colGrid="2" name="from_site" label="From Site" value="{{ $from_site }}"
                            placeholder="LDP" attr="readonly" />
                        <div class="col-4"></div>
                        <x-input-box colGrid="2" name="district_id" label="District" value="{{ $district_id }}"
                            placeholder="District name" attr="readonly" />
                        <x-input-box colGrid="2" name="to_site" label="To Site" value="{{ $to_site }}"
                            placeholder="LDP/POC" attr="readonly" />
                    </div>
                    <div class="row">
                        <div class="col-2"></div>
                        <div class="col-3"></div>
                        <div class="col-2"></div>
                        <x-input-box colGrid="2" name="thana_id" label="Thana" value="{{ $thana_id }}"
                            placeholder="Thana name" attr="readonly" />
                        <x-input-box colGrid="2" name="gps" label="GPS" value="{{ $gps }}"
                            placeholder="Lat/Long" attr="readonly" />
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <select class="form-control" id="service_status" name="service_status" required>
                                <option value="" selected disabled>Select Status</option>
                                @foreach (config('businessinfo.serviceStatus') as $key => $value)
                                    <option value="{{ $key }}" @selected($key == @$service_status)>
                                        {{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <x-input-box colGrid="5" name="remarks" label="Remarks" value="{{ $remarks }}"
                            attr="readonly" />
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
                            @if (!empty($service->id))
                                @foreach ($service->servicelines as $key => $item)
                                    <tr>
                                        <td>
                                            <select class="form-control select2 service_id" name="service_id[]" required>
                                                <option value="" selected disabled>Select Service</option>
                                                @foreach ($products as $key => $value)
                                                    <option value="{{ $value->id }}" @selected($value->id == $item->product_id)>
                                                        {{ $value->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control quantity" name="quantity[]"
                                                value="{{ $item->quantity }}" required>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control rate" name="rate[]"
                                                value="{{ $item->rate }}" required>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control amount" name="amount[]"
                                                value="{{ $item->quantity * $item->rate }}" readonly>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control remarks" name="remarks[]"
                                                value="{{ $item->remarks }}">
                                        </td>
                                        <td>
                                            @if ($loop->first)
                                                <button type="button"
                                                    class="btn btn-success btn-sm fa fa-plus add-service-row"></button>
                                            @else
                                                <button type="button"
                                                    class="btn btn-danger btn-sm fa fa-minus remove-requisition-row"></button>
                                            @endif
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3 text-right" style="text-align: right;">Total Amout</td>
                                <td>
                                    <input type="number" class="form-control total" name="total"
                                        value="{{ $total }}" required>
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mt-2">
            <div class="card">                
                        <button class="py-2 btn btn-primary ">{{ !empty($service->id) ? 'Update' : 'Save' }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {!! Form::close() !!}
@endsection

@include('admin::services.js')
