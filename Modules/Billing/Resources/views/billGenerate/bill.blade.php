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
        <form action="{{ !empty($monthlyBill) ? route('bill-generate.update', $branch->id) : route('bill-generate.store') }}"
            method="post" class="custom-form">
            @if (!empty($monthlyBill))
                @method('PUT')
            @endif
            @csrf
            <div class="row" style="padding:30px 0 30px">
                Client : {{$billData->client->client_name}}<br/>
                Address :{{$billData->billingAddress->address}}<br/>
                Attention :{{$billData->billingAddress->contact_person}}<br/>
                 :{{$billData->billingAddress->designation}}<br/>
                BIN NO :{{$billData?->client?->bin_no ?? ''}}<br/>
                <div class="col-3">
                </div>
            </div>
            <div class="row">
                <div class="offset-md-2 col-md-7 mt-1">
                    <table class="table table-bordered" id="service_table">
                        <thead>
                            <tr>
                                <th>Connectivity Point</th>
                                <th>Material</th>
                                <th>Quantity</th>
                                <th>Unit</th>
                                <th>Rate</th>
                                <th>Amount</th>
                                <th>Total Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $g_total = 0;
                            @endphp
                           @foreach ($billData->lines as $key=>$value )
                               @if(count($value->billingOtcBill->lines))
                                @php
                                    $total = $value->billingOtcBill->lines->sum('amount') + $value->billingOtcBill->installation_charge;
                                    $g_total += $total;
                                @endphp
                                @foreach ($value->billingOtcBill->lines as $key1 => $value1 )
                                    <tr>
                                        @if($loop->first)
                                        <td rowspan="{{count($value->billingOtcBill->lines) + 1 }}">{{$value->frDetail->connectivity_point}}</td>
                                        @endif
                                        <td>{{$value1->material->name}}</td>
                                        <td>{{$value1->quantity}}</td>
                                        <td>{{$value1->material->unit}}</td>
                                        <td>{{$value1->rate}}</td>
                                        <td>{{$value1->amount}}</td>
                                        @if($loop->first)
                                        <td rowspan="{{count($value->billingOtcBill->lines) + 1 }}">{{$total}}</td>
                                        @endif
                                        </tr>
                                @endforeach
                               
                                @else
                                <tr>
                                    <td>{{$value->frDetail->connectivity_point}}</td>
                                </tr>
                               @endif
                               <tr>
                                    <td colspan="4">{{$value->billingOtcBill->particular}}</td>
                                    <td>{{$value->billingOtcBill->installation_charge}}</td>
                               </tr>
                           @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6" class="text-right" style="text-align: right;">Total Amount</td>
                                <td style="text-align: center;">
                                    {{$g_total}}
                                </td>
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
