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
            fieldset {
                display: block!important;
                margin-left: 2px!important;
                margin-right: 2px!important;
                padding-left: 0.75em!important;
                padding-bottom: 0%!important;
                padding-right: 0.75em!important;
                border: #eeeeee 2px silid;
                border: 2px black (internal value)!important;
            }
            fieldset {
                background-color: #eeeeee!important;
            }

            legend {
                color: white!important;
                display: block!important;
                width: 90%!important;
                max-width: 100%!important;
                font-size: 0.7rem!important;
                line-height: inherit!important;
                font-weight: 100!important;
                color: inherit!important;
                white-space: normal!important;
                margin-bottom:0%!important; 
                padding-bottom:0%!important; 
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
                <div class="col-2">
                    <fieldset>
                        <legend>Link Type</legend>
                   
                    {{-- <label class="mr-2" for="yes">Signboard</label> --}}
                        <div class="form-check-inline pt-0 mt-0">
                            <label class="form-check-label" for="new">
                                <input type="radio" class="form-check-input link_type" id="new" name="link_type"
                                    value="new" @checked(@$link_type == 'new' && !old()))>
                                NEW
                            </label>
                        </div>
                        <div class="form-check-inline mt-0 pt-0">
                            <label class="form-check-label" for="existing">
                                <input type="radio" class="form-check-input link_type" id="existing" name="link_type"
                                    value="existing" @checked(@$link_type == 'existing')>
                                EXISTING
                            </label>
                        </div>
                    </fieldset>
                 </div>
                 <x-input-box colGrid="3" name="billing_date" value="" label="Billing Date" attr="readonly" value={{now()}}/>
                 <x-input-box colGrid="3" name="last_mod_date" value="" label="Last Modification Date" attr="readonly" value={{now()}}/>
                 <x-input-box colGrid="3" name="days" value="" label="Days" attr="readonly" value={{now()}}/>
            </div>
    </div>
    <div class="row">
        <div class="offset-md-2 col-md-7 mt-1">
            <table class="table table-bordered" id="service_table">
                <thead>
                    <tr>
                        <th>Particulars</th>
                        <th>Description</th>
                        <th>Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                            <tr>
                                <td>
                                    <input type="text" class="form-control connectivity_point" name="connectivity_point[]"
                                        value="" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control contact" name="contact[]"
                                        value="" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control billing_address" name="child_billing_address[]"
                                        value="" readonly>
                                </td>
                            </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="text-right" style="text-align: right;">Total Amount</td>
                        <td>
                            <input type="number" class="form-control total" name="amount"
                                value="" readonly>
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="offset-md-2 col-md-7 mt-1">
            <table class="table table-bordered" id="service_table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Rate</th>
                        <th>Amount</th>
                        <th>VAT</th>
                        <th>Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                            <tr>
                                <td>
                                    <input type="text" class="form-control connectivity_point" name="connectivity_point[]"
                                        value="" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control contact" name="contact[]"
                                        value="" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control billing_address" name="child_billing_address[]"
                                        value="" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control connectivity_point" name="connectivity_point[]"
                                        value="" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control contact" name="contact[]"
                                        value="" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control billing_address" name="child_billing_address[]"
                                        value="" readonly>
                                </td>
                            </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="text-right" style="text-align: right;">Total Amount</td>
                        <td>
                            <input type="number" class="form-control total" name="amount"
                                value="" readonly>
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-right" style="text-align: right;">Receivable</td>
                        <td>
                            <input type="number" class="form-control total" name="amount"
                                value="" readonly>
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
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
