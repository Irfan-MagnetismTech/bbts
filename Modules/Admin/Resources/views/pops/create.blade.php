@extends('layouts.backend-layout')
@section('title', 'POP')

@php
    $is_old = old('supplier_name') ? true : false;
    $form_heading = !empty($pop) ? 'Update' : 'Add';
    $form_url = !empty($pop) ? route('pops.update', $pop->id) : route('pops.store');
    $form_method = !empty($pop) ? 'PUT' : 'POST';
    
    $branch_id = old('branch_id', !empty($pop) ? $pop->branch_id : null);
    $applied_date = old('date', !empty($pop) ? $pop->date : today()->format('d-m-Y'));
    $name = old('name', !empty($pop) ? $pop->purchaseOrder->name : null);
    $po_id = old('purchase_order_id', !empty($pop) ? $pop->purchase_order_id : null);
    $po_date = old('po_date', !empty($pop) ? $pop->purchaseOrder->date : null);
    $supplier_name = old('supplier_name', !empty($pop) ? $pop->supplier->name : null);
    $supplier_id = old('supplier_id', !empty($pop) ? $pop->supplier_id : null);
    
@endphp

@section('breadcrumb-title')
    {{ $form_heading }} new POP
@endsection

@section('style')
    <style>
        .input-group-addon {
            min-width: 120px;
        }

        .input-group-info .input-group-addon {
            background-color: #04748a !important;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-tagsinput.css') }}">
@endsection
@section('breadcrumb-button')
    <a href="{{ route('pops.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')

    {!! Form::open([
        'url' => $form_url,
        'method' => $form_method,
        'encType' => 'multipart/form-data',
        'class' => 'custom-form',
    ]) !!}
    <div class="row mb-2">
        <x-input-box colGrid="3" name="name" value="{{ $name }}" label="POP name" attr="required" />

        <div class="form-group col-3">
            <select class="form-control" id="pop_type" name="pop_type" required>
                <option value="" selected disabled>Select POP Type</option>
                @foreach (config('businessinfo.popType') as $key => $value)
                    <option value="{{ $key }}"
                        {{ old('pop_type', !empty($pop) ? $pop->pop_type : null) == $key ? 'selected' : '' }}>
                        {{ $value }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-3">
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

        <div class="form-group col-3">
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

        <div class="form-group col-3">
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

        <x-input-box colGrid="3" name="address" value="{{ $name }}" label="Address" />

        <div class="form-group col-3">
            <select name="branch_id" id="branch_id" class="form-control select2">
                <option value="" selected disabled>Search Branch</option>
            </select>
        </div>

        <x-input-box colGrid="3" name="lat_long" value="{{ $name }}" label="Lat/Long" />
        <x-input-box colGrid="3" name="owners_name" value="{{ $name }}" label="Owners Name" />
        <x-input-box colGrid="3" name="contact_person" value="{{ $name }}" label="Contact Person" />
        <x-input-box colGrid="3" name="designation" value="{{ $name }}" label="Designation" />
        <x-input-box colGrid="3" name="contact_no" value="{{ $name }}" label="Contact No." />
        <x-input-box colGrid="3" name="email" value="{{ $name }}" label="Email Address" />
        <x-input-box colGrid="9" name="description" value="{{ $name }}" label="Description" />
        <x-input-box colGrid="3" name="applied_date" value="{{ $name }}" label="Aproval Date" />
        <x-input-box colGrid="3" name="applied_date" value="{{ $name }}" label="BTRC Aproval Date" />
        <x-input-box colGrid="3" name="applied_date" value="{{ $name }}" label="Commissioning Date" />
        <x-input-box colGrid="3" name="applied_date" value="{{ $name }}" label="Termination Date" />
        <x-input-box colGrid="3" name="applied_date" value="{{ $name }}" label="Website Published Date" />
        <x-input-box colGrid="3" name="applied_date" value="{{ $name }}" label="Next Renewal Date" />

        <div class="col-md-3">
            <div class="
                     mt-2 mb-4">
                <label class="mr-2" for="yes">Signboard</label>
                <div class="form-check-inline">
                    <label class="form-check-label" for="yes">
                        <input type="radio" class="form-check-input radioButton" id="yes" name="signboard"
                            value="yes" @checked(@$type == 'yes' || ($form_method == 'POST' && !old()))>
                        Yes
                    </label>
                </div>
                <div class="form-check-inline">
                    <label class="form-check-label" for="no">
                        <input type="radio" class="form-check-input radioButton" id="no" name="signboard"
                            value="no" @checked(@$type == 'no')>
                        No
                    </label>
                </div>
            </div>
        </div>

        <hr class="col-12">
        
    </div>

    <div class="row">
        <div class="offset-md-4 col-md-4 mt-2">
            <div class="input-group input-group-sm ">
                <button class="btn btn-success btn-round btn-block py-2">Submit</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section('script')
    <script src="{{ asset('js/custom-function.js') }}"></script>
    <script>
        // get data by associative dropdown
        associativeDropdown("{{ route('get-districts') }}", 'division_id', '#division_id', '#district_id', 'get', null)
        associativeDropdown("{{ route('get-thanas') }}", 'district_id', '#district_id', '#thana_id', 'get', null)

        select2Ajax("{{ route('searchBranch') }}", '#branch_id')

        $('#applied_date').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true,
            showOtherMonths: true
        });
    </script>
@endsection
