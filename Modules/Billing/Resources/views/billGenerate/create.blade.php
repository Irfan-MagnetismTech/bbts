@extends('layouts.backend-layout')
@section('title', 'Bill Generate')

@section('breadcrumb-title')
    @if (!empty($monthlyBill))
        Edit
    @else
    @endif
   Bill Generate (OTC)
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
        <form action="{{ !empty($monthlyBill) ? route('bill-generate.update', $branch->id) : route('bill-generate.store') }}"
            method="post" class="custom-form">
            @if (!empty($monthlyBill))
                @method('PUT')
            @endif
            @csrf
            <div class="row" style="padding:30px 0 30px">
                <x-input-box colGrid="3" name="client_no" value="" label="Client ID" attr="readonly" value="{{$BillLocations->first()->client_no}}"/>
                <x-input-box colGrid="3" name="client_name" value="" label="Client Name" attr="readonly" value="{{$BillLocations->first()->client->client_name}}"/>
                <x-input-box colGrid="3" name="date" value="" label="Date" attr="readonly" value={{now()}}/>
                <input type="hidden" class="form-control bill_type" name="bill_type"
                value="{{ 'OTC' }}">
                <div class="col-3">
                    <select name="billing_address_id" class="form-control">
                        <option value="">Select Billing Address</option>
                        @foreach ($BillingAddresses as $key => $value )
                            <option value="{{$value->id}}" @if($loop->first) Selected @endif>{{$value->address}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="offset-md-2 col-md-7 mt-1">
                    <table class="table table-bordered" id="service_table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Point Name</th>
                                <th>Contact info</th>
                                <th>Billing Address</th>
                                <th>Particulars</th>
                                <th>OTC</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($BillLocations))
                                @php($total = 0)
                                @foreach ($BillLocations as $key => $item)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="checkbox" value="Primary" name="checked[{{$key}}]">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control connectivity_point" name="connectivity_point[]"
                                                value="{{ $item->frDetail->connectivity_point }}" readonly>
                                            <input type="hidden" class="form-control connectivity_point" name="fr_no[]"
                                                value="{{ $item->fr_no }}">
                                            <input type="hidden" class="form-control otc_bill_id" name="otc_bill_id[]"
                                                value="{{ $item->id }}">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control contact" name="contact[]"
                                                value="{{ $item->frDetail->contact_name . '-' . $item->frDetail->contact_number }}" readonly>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control billing_address" name="child_billing_address[]"
                                                value="{{ $item->saleDetails->billingAddress->address }}" readonly>
                                            <input type="hidden" class="form-control billing_address" name="child_billing_address_id[]"
                                                value="{{ $item->saleDetails->billingAddress->id }}" readonly>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control particular" name="particular[]"
                                                value="">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control total_amount" name="total_amount[]"
                                                value="{{ $item->saleDetails->otc }}" readonly>
                                            <input type="hidden" class="form-control net_amount" name="net_amount[]"
                                                value="{{ $item->saleDetails->otc }}">
                                        </td>
                                    </tr>
                                @php($total+= $item->saleDetails->otc)
                                @endforeach
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="text-right" style="text-align: right;">Total Amount</td>
                                <td>
                                    <input type="number" class="form-control total" name="amount"
                                        value="{{$total}}" readonly>
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
