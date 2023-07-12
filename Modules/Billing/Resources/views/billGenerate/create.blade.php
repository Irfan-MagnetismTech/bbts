@extends('layouts.backend-layout')
@section('title', 'Branchs')

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
        <form action="{{ !empty($monthlyBill) ? route('branchs.update', $branch->id) : route('branchs.store') }}"
            method="post" class="custom-form">
            @if (!empty($monthlyBill))
                @method('PUT')
            @endif
            @csrf
            <div class="row" style="padding:30px 0 30px">
                <x-input-box colGrid="3" name="client_no" value="" label="Client ID" attr="readonly" value="{{$BillLocations->first()->client_no}}"/>
                <x-input-box colGrid="3" name="client_name" value="" label="Client Name" attr="readonly" value="{{$BillLocations->first()->client->client_name}}"/>
                <x-input-box colGrid="3" name="date" value="" label="Date" attr="readonly" value={{now()}}/>
                <div class="col-3">
                    <select name="billing_address_id" class="form-control">
                        <option value="">Select Billing Address</option>
                        @foreach ($BillingAddresses as $key => $value )
                            <option value="{{$value->id}}">{{$value->address}}</option>
                        @endforeach
                        
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="offset-md-2 col-md-7 mt-1">
                    <table class="table table-bordered" id="service_table">
                        <thead>
                            <tr>
                                <th>Point Name</th>
                                <th>Contact info</th>
                                <th>Billing Address</th>
                                <th>Particulars</th>
                                <th>OTC</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($BillLocations))
                                @foreach ($BillLocations as $key => $item)
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control quantity" name="quantity[]"
                                                value="{{ $item->frDetail->connectivity_point }}" required>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control rate" name="rate[]"
                                                value="{{ $item->frDetail->contact_name . '-' . $item->frDetail->contact_number }}" required>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control amount" name="amount[]"
                                                value="{{ $item->quantity * $item->rate }}" readonly>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control remarks" name="remarks[]"
                                                value="{{ $item->remarks }}">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control remarks" name="remarks[]"
                                                value="{{ $item->remarks }}">
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3 text-right" style="text-align: right;">Total Amout</td>
                                <td>
                                    <input type="number" class="form-control total" name="total"
                                        value="0" required>
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
