@extends('layouts.backend-layout')
@section('title', 'Bill Generate')

@section('breadcrumb-title')
    @if (!empty($monthlyBill))
        Edit
    @else
    @endif
    Bill Generate ({{$bill_type}})
@endsection

@section('style')
    <style>
        .input-group-addon {
            min-width: 120px;
        }

        .input-group-info .input-group-addon {
            /*background-color: #04748a!important;*/
        }

        table {
            border-collapse: collapse;
            border: 1px solid black;
            border-top: 2px solid black;
        }

        #service_table1 {
            border-radius: 100px !important;
        }

        .rounded-table {
            border-radius: 30px; /* Adjust the value as per your preference */
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
        <form action="{{ route('generate_bill_pdf', $billData->id) }}"
              method="get" class="custom-form">
            <div class="row" style="padding:30px 0 30px">
                <div class="col-7">
                    <table class="table rounded-table" id="service_table1">
                        <thead>
                        <tr>
                            <td>Client :</td>
                            <td>{{$billData->client->client_name ?? ''}}</td>
                        </tr>
                        <tr>
                            <td>Address :</td>
                            <td>{{$billData->billingAddress->address ?? ''}}</td>
                        </tr>
                        <tr>
                            <td>Attention :</td>
                            <td>{{$billData->billingAddress->contact_person ?? ''}}</td>
                        </tr>
                        <tr>
                            <td>Designation :</td>
                            <td>{{$billData->billingAddress->designation ?? ''}}</td>
                        </tr>
                        <tr>
                            <td>BIN NO :</td>
                            <td>{{$billData->billingAddress->phone ?? ''}}</td>
                        </tr>
                        </thead>
                    </table>
                </div>
                <div class="col-5">
                    <table class="table" id="service_table2">
                        <thead>
                        <tr>
                            <td>Invoice No :</td>
                            <td>{{$billData->bill_no ?? ''}}</td>
                        </tr>
                        <tr>
                            <td>Invoice Date :</td>
                            <td>{{$billData->date ?? ''}}</td>
                        </tr>
                        <tr>
                            <td>Invoice Period :</td>
                            <td>{{$billData->month ?? ''}}</td>
                        </tr>
                        <tr>
                            <td>BBTSL BIN No :</td>
                            <td>{{$billData->client->bin_no ?? ''}}</td>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="row">
                <table class="table table-bordered" id="service_table">
                    @if(isset($billData->lines) && count($billData->lines))
                        @php
                            $g_total = 0;
                        @endphp
                        <thead>
                        @if(isset($billData->lines[0]->billingOtcBill) && count($billData->lines[0]->billingOtcBill->lines))
                            <tr>
                                <th>Connectivity Point</th>
                                <th>Material</th>
                                <th>Quantity</th>
                                <th>Unit</th>
                                <th>Rate</th>
                                <th>Amount</th>
                                <th>Total Amount</th>
                            </tr>
                        @else
                            <tr>
                                <th>Connectivity Point</th>
                                <th>Total Amount</th>
                            </tr>
                        @endif
                        </thead>
                        <tbody>
                        @foreach ($billData->lines as $key=>$value )
                            @if(isset($value->billingOtcBill) && count($value->billingOtcBill->lines))
                                @php
                                    $total = $value->billingOtcBill->lines->sum('amount') + $value->billingOtcBill->installation_charge;
                                    $g_total += $total;
                                @endphp
                                @foreach ($value->billingOtcBill->lines as $key1 => $value1 )
                                    <tr>
                                        @if($loop->first)
                                            <td rowspan="{{count($value->billingOtcBill->lines) + 1 }}">{{$value->frDetail->connectivity_point??''}}</td>
                                        @endif
                                        <td style="text-align: center;">{{$value1->material->name}}</td>
                                        <td style="text-align: center;">{{$value1->quantity}}</td>
                                        <td style="text-align: center;">{{$value1->material->unit}}</td>
                                        <td style="text-align: center;">{{$value1->rate}}</td>
                                        <td style="text-align: center;">{{$value1->amount}}</td>
                                        @if($loop->first)
                                            <td rowspan="{{count($value->billingOtcBill->lines) + 1 }}" style="text-align: center;">{{$total}}</td>
                                        @endif
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="4" style="text-align: center">Installation Charge</td>
                                    <td style="text-align: center;">{{$value->billingOtcBill->installation_charge}}</td>
                                </tr>
                            @else
                                @php
                                    $total = $value->total_amount;
                                    $g_total += $total;
                                @endphp
                                <tr>
                                    <td style="text-align: center;">{{$value->frDetail->connectivity_point ?? ''}}</td>
                                    <td style="text-align: center;">{{$value->total_amount ?? ''}}</td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                        <tfoot>
                        @if(isset($billData->lines[0]->billingOtcBill) && count($billData->lines[0]->billingOtcBill->lines))
                            <tr>
                                <td colspan="6" class="text-right" style="text-align: right;">Total Amount</td>
                                <td style="text-align: center;">{{$g_total}}</td>
                            </tr>
                        @else
                            <tr>
                                <td class="text-right" style="text-align: right;">Total Amount</td>
                                <td style="text-align: center;">{{$g_total}}</td>
                            </tr>
                        @endif
                        </tfoot>
                    @endif
                </table>


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
