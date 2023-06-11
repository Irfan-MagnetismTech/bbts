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
    $type = old('type', !empty($pop) ? $pop->purchaseOrder->type : null);
    $address = old('address', !empty($pop) ? $pop->purchaseOrder->address : null);
    $latLong = old('lat_long', !empty($pop) ? $pop->purchaseOrder->lat_long : null);
    $owners_name = old('owners_name', !empty($pop) ? $pop->purchaseOrder->owners_name : null);
    $contact_person = old('contact_person', !empty($pop) ? $pop->purchaseOrder->contact_person : null);
    $designation = old('designation', !empty($pop) ? $pop->purchaseOrder->designation : null);
    $contact_no = old('contact_no', !empty($pop) ? $pop->purchaseOrder->contact_no : null);
    $email = old('email', !empty($pop) ? $pop->purchaseOrder->email : null);
    $description = old('description', !empty($pop) ? $pop->purchaseOrder->description : null);
    $approval_date = old('approval_date', !empty($pop) ? $pop->approval_date : null);
    $btrc_approval_date = old('btrc_approval_date', !empty($pop) ? $pop->btrc_approval_date : null);
    $commissioning_date = old('commissioning_date', !empty($pop) ? $pop->commissioning_date : null);
    $termination_date = old('termination_date', !empty($pop) ? $pop->termination_date : null);
    $website_published_date = old('website_published_date', !empty($pop) ? $pop->website_published_date : null);
    $signboard = old('signboard', !empty($pop) ? $pop->signboard : null);
    $advance_amount = old('advance_amount', !empty($pop) ? $pop->advance_amount : null);
    $rent = old('rent', !empty($pop) ? $pop->rent : null);
    $advance_reduce = old('advance_reduce', !empty($pop) ? $pop->advance_reduce : null);
    $monthly_rent = old('monthly_rent', !empty($pop) ? $pop->monthly_rent : null);
    $paymet_method = old('paymet_method', !empty($pop) ? $pop->paymet_method : null);
    $bank_id = old('bank_id', !empty($pop) ? $pop->bank_id : null);
    $account_no = old('account_no', !empty($pop) ? $pop->account_no : null);
    $payment_date = old('payment_date', !empty($pop) ? $pop->payment_date : null);
    $routing_no = old('routing_no', !empty($pop) ? $pop->routing_no : null);
    $remarks = old('remarks', !empty($pop) ? $pop->remarks : null);
    $attached_file = old('attached_file', !empty($pop) ? $pop->attached_file : null);
    
    $particular_ids = old('particular_id', !empty($pop) ? $pop->popLines->pluck('particular_id') : []);
    $amounts = old('amount', !empty($pop) ? $pop->popLines->groupBy('particular_id') : []);
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
            <select class="form-control" id="type" name="type" required>
                <option value="" selected disabled>Select POP Type</option>
                @foreach (config('businessinfo.popType') as $key => $value)
                    <option value="{{ $key }}" {{ $type == $key ? 'selected' : '' }}>
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

        <x-input-box colGrid="3" name="address" value="{{ $address }}" label="Address" />

        <div class="form-group col-3">
            <select name="branch_id" id="branch_id" class="form-control select2">
                <option value="" selected disabled>Search Branch</option>
            </select>
        </div>

        <x-input-box colGrid="3" name="lat_long" value="{{ $latLong }}" label="Lat/Long" />
        <x-input-box colGrid="3" name="owners_name" value="{{ $owners_name }}" label="Owners Name" />
        <x-input-box colGrid="3" name="contact_person" value="{{ $contact_person }}" label="Contact Person" />
        <x-input-box colGrid="3" name="designation" value="{{ $designation }}" label="Designation" />
        <x-input-box colGrid="3" name="contact_no" value="{{ $contact_no }}" label="Contact No." />
        <x-input-box colGrid="3" name="email" value="{{ $email }}" label="Email Address" />
        <x-input-box colGrid="3" name="description" value="{{ $description }}" label="Description" />
        <x-input-box colGrid="3" name="approval_date" class="date" value="{{ $approval_date }}"
            label="Approval Date" />
        <x-input-box colGrid="3" name="btrc_approval_date" class="date" value="{{ $btrc_approval_date }}"
            label="BTRC Approval Date" />
        <x-input-box colGrid="3" name="commissioning_date" class="date" value="{{ $commissioning_date }}"
            label="Commissioning Date" />
        <x-input-box colGrid="3" name="termination_date" class="date" value="{{ $termination_date }}"
            label="Termination Date" />
        <x-input-box colGrid="3" name="website_published_date" class="date" value="{{ $website_published_date }}"
            label="Website Published Date" />

        <div class="col-md-3">
            <div class="
                     mt-2 mb-4">
                <label class="mr-2" for="yes">Signboard</label>
                <div class="form-check-inline">
                    <label class="form-check-label" for="yes">
                        <input type="radio" class="form-check-input radioButton" id="yes" name="signboard"
                            value="yes" @checked(@$signboard == 'yes' || ($form_method == 'POST' && !old()))>
                        Yes
                    </label>
                </div>
                <div class="form-check-inline">
                    <label class="form-check-label" for="no">
                        <input type="radio" class="form-check-input radioButton" id="no" name="signboard"
                            value="no" @checked(@$signboard == 'no')>
                        No
                    </label>
                </div>
            </div>
        </div>
        <hr class="col-12">
    </div>
    <p class="text-center h5">Billing Information</p>
    <div class="row mb-2">
        <x-input-box colGrid="3" name="advance_amount" value="{{ $advance_amount }}" label="Advance Amount" />
        <x-input-box colGrid="3" name="rent" value="{{ $rent }}" label="Rent" />
        <x-input-box colGrid="3" name="advance_reduce" value="{{ $advance_reduce }}" label="Advance Reduce" />
        <x-input-box colGrid="3" name="monthly_rent" value="{{ $monthly_rent }}" label="Monthly Rent" />
        <x-input-box colGrid="3" name="paymet_method" value="{{ $paymet_method }}" label="Paymet Method" />
        <div class="col-md-3">
            <select class="form-control bankList" id="bank_id" name="bank_id" required>
                <option value="">Select Bank</option>
                @foreach (@$banks as $bank)
                    <option value="{{ $bank->id }}" {{ $bank_id == $bank->id ? 'selected' : '' }}>
                        {{ $bank->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <x-input-box colGrid="3" name="account_no" value="{{ $account_no }}" label="Account No" />
        <x-input-box colGrid="3" name="payment_date" class="date" value="{{ $payment_date }}"
            label="Payment Date" />
        <x-input-box colGrid="3" name="routing_no" value="{{ $routing_no }}" label="Routing No" />
        <x-input-box colGrid="6" name="remarks" value="{{ $remarks }}" label="Remarks" />
        <x-input-box colGrid="3" name="attached_file" value="{{ $attached_file }}" label="Attached File" />
    </div>

    <div class="row">
        <div class="offset-md-4 col-md-4 mt-1">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Particulars</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($particulars as $particular)
                        <tr>
                            <td>
                                {{ $particular->name }}
                                <input type="hidden" name="particular_id[]" value="{{ $particular->id }}">
                            </td>
                            <td><input type="number" class="form-control form-control-sm"
                                    value="{{ isset($amounts[$particular->id]) ? $amounts[$particular->id]->amount : 0 }}"
                                    name="amount[]">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
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

        $('.date').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true,
            showOtherMonths: true
        });

        $('.bankList').select2({
            placeholder: 'Select an option'
        });
    </script>
@endsection
