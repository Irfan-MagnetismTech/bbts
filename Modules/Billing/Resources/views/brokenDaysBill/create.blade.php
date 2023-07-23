@extends('layouts.backend-layout')
@section('title', 'Broken Days Bill')

@section('breadcrumb-title')
    @if (!empty($monthlyBill))
        Edit
    @else
    @endif
   Broken Days Bill Generate
@endsection

@section('style')
    <style>
        .input-group-addon {
            min-width: 120px;
        }

        .input-group-info .input-group-addon {
            /*background-color: #04748a!important;*/
        }
    </style>
@endsection
@section('breadcrumb-button')
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
    <div class="container">
        <form action="{{ !empty($monthlyBill) ? route('broken-days-bills.update', $branch->id) : route('broken-days-bills.store') }}"
            method="post" class="custom-form">
            @if (!empty($monthlyBill))
                @method('PUT')
            @endif
            @csrf
            <div class="row" style="padding:30px 0 30px">
                <x-input-box colGrid="3" name="client_no" value="" label="Client ID" attr="readonly" value=""/>
                <x-input-box colGrid="3" name="client_name" value="" label="Client Name" attr="readonly" value=""/>
                <x-input-box colGrid="3" name="date" value="" label="Date" attr="readonly" value={{now()}}/>
                <input type="hidden" class="form-control bill_type" name="bill_type"
                value="{{ 'Broken Days' }}">
                <div class="col-3">
                    <select name="billing_address_id" class="form-control">
                        <option value="">Select Billing Address</option>
                    </select>
                </div>
            </div>
    </div>

    <div class="row">
        <div class="offset-md-4 col-md-4 mt-2">
            <div class="input-group input-group-sm ">
                <button class="btn btn-success btn-round btn-block py-2">Generate</button>
            </div>
        </div>
    </div>
    </form>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/custom-function.js') }}"></script>
    <script>
        $('#date').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true,
            showOtherMonths: true
        }).datepicker("setDate", new Date());
    </script>
@endsection
