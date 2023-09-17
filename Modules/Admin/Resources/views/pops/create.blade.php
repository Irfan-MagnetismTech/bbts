@extends('layouts.backend-layout')
@section('title', 'POP')

<style>
    .previous-image {
        width: 272px;
        border: 1px solid #ccc;
        padding: 5px;
    }

    .previous-image img {
        max-width: 100%;
        max-height: 100%;
    }
</style>

@php
    $is_old = old('supplier_name') ? true : false;
    $form_heading = !empty($pop) ? 'Update' : 'Add';
    $form_url = !empty($pop) ? route('pops.update', $pop->id) : route('pops.store');
    $form_method = !empty($pop) ? 'PUT' : 'POST';

    $name = old('name', !empty($pop) ? $pop->name : null);
    $type = old('type', !empty($pop) ? $pop->type : null);
    $division_id = old('division_id', !empty($pop) ? $pop->division_id : null);
    $district_id = old('district_id', !empty($pop) ? $pop->district_id : null);
    $thana_id = old('thana_id', !empty($pop) ? $pop->thana_id : null);
    $address = old('address', !empty($pop) ? $pop->address : null);
    $branch_id = old('branch_id', !empty($pop) ? $pop->branch_id : null);
    $latLong = old('lat_long', !empty($pop) ? $pop->lat_long : null);
    $room_size = old('room_size', !empty($pop) ? $pop->room_size : null);
    $tower = old('tower', !empty($pop) ? $pop->tower : null);
    $tower_height = old('tower_height', !empty($pop) ? $pop->tower_height : null);
    $electric_meter_no = old('electric_meter_no', !empty($pop) ? $pop->electric_meter_no : null);
    $deed_duration = old('deed_duration', !empty($pop) ? $pop->deed_duration : null);
    $renewal_condition = old('renewal_condition', !empty($pop) ? $pop->renewal_condition : null);
    $renewal_date = old('renewal_date', !empty($pop) ? $pop->renewal_date : today()->format('d-m-Y'));
    $owners_name = old('owners_name', !empty($pop) ? $pop->owners_name : null);
    $owners_nid = old('owners_nid', !empty($pop) ? $pop->owners_nid : null);
    $owners_address = old('owners_address', !empty($pop) ? $pop->owners_address : null);
    $contact_person = old('contact_person', !empty($pop) ? $pop->contact_person : null);
    $designation = old('designation', !empty($pop) ? $pop->designation : null);
    $contact_no = old('contact_no', !empty($pop) ? $pop->contact_no : null);
    $email = old('email', !empty($pop) ? $pop->email : null);
    $description = old('description', !empty($pop) ? $pop->description : null);
    $approval_date = old('approval_date', !empty($pop) ? $pop->approval_date : today()->format('d-m-Y'));
    $btrc_approval_date = old('btrc_approval_date', !empty($pop) ? $pop->btrc_approval_date : today()->format('d-m-Y'));
    $commissioning_date = old('commissioning_date', !empty($pop) ? $pop->commissioning_date : today()->format('d-m-Y'));
    $termination_date = old('termination_date', !empty($pop) ? $pop->termination_date : today()->format('d-m-Y'));
    $website_published_date = old('website_published_date', !empty($pop) ? $pop->website_published_date : today()->format('d-m-Y'));
    $signboard = old('signboard', !empty($pop) ? $pop->signboard : null);
    $advance_amount = old('advance_amount', !empty($pop) ? $pop->advance_amount : null);
    $rent = old('rent', !empty($pop) ? $pop->rent : null);
    $advance_reduce = old('advance_reduce', !empty($pop) ? $pop->advance_reduce : null);
    $monthly_rent = old('monthly_rent', !empty($pop) ? $pop->monthly_rent : null);
    $payment_method = old('payment_method', !empty($pop) ? $pop->payment_method : null);
    $bank_id = old('bank_id', !empty($pop) ? $pop->bank_id : null);
    $account_no = old('account_no', !empty($pop) ? $pop->account_no : null);
    $payment_date = old('payment_date', !empty($pop) ? $pop->payment_date : today()->format('d-m-Y'));
    $routing_no = old('routing_no', !empty($pop) ? $pop->routing_no : null);
    $remarks = old('remarks', !empty($pop) ? $pop->remarks : null);
    $attached_file = old('attached_file', !empty($pop) ? $pop->attached_file : null);

    $particular_ids = old('particular_id', !empty($pop) ? $pop->popLines->pluck('particular_id') : []);
    $amounts = old('amount', !empty($pop) ? $pop->popLines->groupBy('particular_id') : []);
    $total_rent = old('total_rent', !empty($pop) ? $pop->total_rent : null);
@endphp

@section('breadcrumb-title')
    {{ $form_heading }} POP
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
                        <option value="{{ $division->id }}" {{ $division_id == $division->id ? 'selected' : '' }}>
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
                            <option value="{{ $district->id }}" {{ $district_id == $district->id ? 'selected' : '' }}>
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
                            <option value="{{ $thana->id }}" {{ $thana_id == $thana->id ? 'selected' : '' }}>
                                {{ $thana->name }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        <x-input-box colGrid="3" name="address" value="{{ $address }}" label="Address" />
        <div class="form-group col-3">
            <div class="input-group input-group-sm input-group-primary">
                <select class="form-control" id="branch_id" name="branch_id" required>
                    <option value="">Select Branch</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}" {{ $branch_id == $branch->id ? 'selected' : '' }}>
                            {{ $branch->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="
                     mt-2 mb-4">
                <label class="mr-2" for="yes">Tower</label>
                <div class="form-check-inline">
                    <label class="form-check-label" for="yes">
                        <input type="radio" class="form-check-input radioButton" id="yes" name="tower"
                               value="yes" @checked(@$signboard == 'yes' || ($form_method == 'POST' && !old()))>
                        Yes
                    </label>
                </div>
                <div class="form-check-inline">
                    <label class="form-check-label" for="no">
                        <input type="radio" class="form-check-input radioButton" id="no" name="tower"
                               value="no" @checked(@$signboard == 'no')>
                        No
                    </label>
                </div>
            </div>
        </div>
        <x-input-box colGrid="3" name="tower_height" value="{{ $tower_height }}" label="Tower Height (m)" />
        <x-input-box colGrid="3" name="lat_long" value="{{ $latLong }}" label="Lat/Long" />
        <x-input-box colGrid="3" name="room_size" value="{{ $room_size }}" label="Room Size" />
        <x-input-box colGrid="3" name="electric_meter_no" value="{{ $electric_meter_no }}" label="Electric Meter No" />
        <x-input-box colGrid="3" name="owners_name" value="{{ $owners_name }}" label="Owners Name" />
        <x-input-box colGrid="3" name="owners_nid" value="{{ $owners_nid }}" label="Owners NID" />
        <x-input-box colGrid="3" name="owners_address" value="{{ $owners_address }}" label="Owners Address" />
        <x-input-box colGrid="3" name="contact_person" value="{{ $contact_person }}" label="Contact Person" />
        <x-input-box colGrid="3" name="designation" value="{{ $designation }}" label="Designation" />
        <x-input-box colGrid="3" type="number" name="contact_no" value="{{ $contact_no }}" label="Contact No." />
        <x-input-box colGrid="3" name="email" value="{{ $email }}" label="Email Address" />
        <x-input-box colGrid="3" name="description" value="{{ $description }}" label="Description" />
        <x-input-box colGrid="3" name="deed_duration" value="{{ $deed_duration }}" label="Deed Duration" />
        <x-input-box colGrid="3" name="renewal_condition" value="{{ $renewal_condition }}" label="Renewal Condition" />
        <x-input-box colGrid="3" name="renewal_date" class="date" value="{{ $renewal_date }}" label="Renewal Date" />
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
        <x-input-box colGrid="3" type="number" name="advance_amount" value="{{ $advance_amount }}"
            label="Advance Amount" />
        <x-input-box colGrid="3" type="number" name="rent" value="{{ $rent }}" label="Rent" class="rent" />
        <x-input-box colGrid="3" type="number" name="advance_reduce" value="{{ $advance_reduce }}"
                     label="Advance Reduce" class="advance_reduce" />
        <x-input-box colGrid="3" type="number" name="monthly_rent" value="{{ $monthly_rent ?? 0 }}"
                     label="Monthly Rent" class="monthly_rent" />
        <x-input-box colGrid="3" name="payment_method" value="{{ $payment_method }}" label="Payment Method" />
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
        <x-input-box colGrid="3" type="file" name="attached_file" value="{{ $attached_file }}"
            label="Attached File" />
        {{-- <div class="offset-md-9 col-md-3">
            <div class="previous-image">
                @if (!empty($pop->attached_file))
                    <img src="{{ asset($pop->attached_file) }}" alt="Previous Image" />
                @else
                    <p>No previous image available</p>
                @endif
            </div>
        </div> --}}
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
                            <td>
                                <input type="number" class="form-control form-control-sm amount"
                                       value="{{ isset($amounts[$particular->id]) ? $amounts[$particular->id][0]->amount : 0 }}"
                                       name="amount[]"
                                       data-amount="{{ isset($amounts[$particular->id]) ? $amounts[$particular->id][0]->amount : 0 }}">
                            </td>

                        </tr>
                    @endforeach
                    <tr>
                        <td><b>Total Rent</b></td>
                        <td>
                            <div class="input-group input-group-sm input-group-primary">
                                <input type="text" name="total_rent" class="form-control"
                                       id="total_rent" autocomplete="off" placeholder="0" readonly value="{{$total_rent}}">
                            </div>
                        </td>
                    </tr>
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
    @include('admin::pops.js')

    <script>
        $(document).ready(function () {
            $(document).on("keyup focus", ".amount", function () {
                calculateTotalAmount();
            });

            function calculateTotalAmount() {
                var monthlyRentInput = $(".monthly_rent");
                var monthlyRent = parseFloat(monthlyRentInput.val()) || 0;
                var amount = 0;
                $(".amount").each(function () {
                    amount += parseFloat($(this).val()) || 0;
                });
                amount += monthlyRent;
                $('#total_rent').val(amount.toFixed(2));
            }
        });
    </script>

    <script>
        $(document).ready(function () {
            var rentInput = $(".rent");
            var advanceReduceInput = $(".advance_reduce");
            var monthlyRentInput = $(".monthly_rent");

            rentInput.on("keyup", function () {
                calculateMonthlyRent();
            });

            advanceReduceInput.on("keyup", function () {
                calculateMonthlyRent();
            });

            function calculateMonthlyRent() {
                var rentValue = parseFloat(rentInput.val()) || 0;
                var advanceReduceValue = parseFloat(advanceReduceInput.val()) || 0;
                var monthlyRent = rentValue - advanceReduceValue;

                monthlyRentInput.val(monthlyRent.toFixed(2));
            }
        });
    </script>

@endsection
