<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        table {
            font-size: 12px;
        }

        #table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #table td,
        #table th {
            border: 1px solid #ddd;
            padding: 5px;
        }

        #table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #table tr:hover {
            background-color: #ddd;
        }

        #table th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            background-color: #98acc3;
        }

        .tableHead {
            text-align: center;
            font-weight: bold;
            font-size: 13px;
        }

        p {
            margin: 0;
        }

        h1 {
            margin: 0;
        }

        h2 {
            margin: 0;
        }

        .container {
            margin: 20px;
        }

        #logo {
            clear: both;
            width: 100%;
            display: block;
            text-align: center;
            position: relative;
        }


        .infoTable {
            font-size: 12px;
            width: 100%;
        }

        .infoTableTable td:nth-child(2) {
            text-align: center;
            width: 20px;
        }

        .pdflogo a {
            font-size: 18px;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        @page {
            margin: 40px 0 0 0;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
         }
        .col-12 {
            float: left;
            width: 100%;
        }
        .col-3 {
            width: 25%;
            float: left;
        }
        .col-1 {
            width: 8.33333333333%;
            float: left;
        }
        .col-7 {
            width: 58.3333333333%;
            float: left;
        }

        .col-5 {
            width: 41.6666666667%;
            float: left;
        }
        .col-9 {
            width: 75%;
            float: left;
        }
        .col-2-5 {
            width: 20%;
            float: left;
        }
        .col-4 {
            float: left;
            width: 33.333333%;
        }
        @page {
        header: page-header;
        footer: page-footer;
        }
    </style>
</head>

<body>
    <htmlpageheader name="page-header">
        <div>
            &nbsp;
        </div>
    <div>
        <div id="logo" class="pdflogo">
            <img src="{{ asset('images/bbts_logo.png') }}" alt="Logo" class="pdfimg">
            <div class="clearfix"></div>
            <h5>Ispahani Building (2nd Floor), Agrabad C/A, Chittagong-4100.</h5>
        </div>
    </div>
    </htmlpageheader>
    <html-separator/>
    <div class="container">
            <div class="row" style="padding:30px 0 30px;">
                <div class="col-5" style="border: 1px solid #000000; border-radius: 5px;margin-top: 40px">
                    <table class="table rounded-table infoTable">
                        <thead>
                            <tr>
                                <td>Client : </td>
                                <td>{{$billData->client->client_name ?? ''}}</td>
                            </tr>
                            <tr>
                                <td>Address : </td>
                                <td>{{$billData->billingAddress->address ?? ''}}</td>
                            </tr>
                            <tr>
                                <td>Attention : </td>
                                <td>{{$billData->billingAddress->contact_person ?? ''}}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>{{$billData->billingAddress->designation ?? ''}}</td>
                            </tr>
                            <tr>
                                <td>BIN NO : </td>
                                <td>{{$billData?->client?->bin_no ?? ''}}</td>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="col-2"></div>
                <div class="col-4" style="border: 1px solid #000000; border-radius: 5px;margin: 0;float:right;">

                    <table class="table infoTable">
                        <thead>
                            <tr>
                                <td>Invoice No : </td>
                                <td>{{$billData->client->client_name ?? ''}}</td>
                            </tr>
                            <tr>
                                <td>Invoice Date : </td>
                                <td>{{$billData->billingAddress->address ?? ''}}</td>
                            </tr>
                            <tr>
                                <td>Invoice Period : </td>
                                <td>{{$billData->billingAddress->contact_person ?? ''}}</td>
                            </tr>
                            <tr>
                                <td>BBTSL BIN No</td>
                                <td>{{$billData?->client?->bin_no ?? ''}}</td>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="">
                <div>
                    <h2 style="text-align: center; width: 30%; border: 1px solid #000000; border-radius: 5px; margin: 10px auto">
                        {{$billData->bill_type}}</h2>
                </div>
                <div>
                    <table class="table table-bordered" id="table">
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
                                        <td style="text-align: center;" rowspan="{{count($value->billingOtcBill->lines) + 1 }}">{{$value->frDetail->connectivity_point??''}}</td>
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
            </div>
    </div>

</body>

</html>
