<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            margin: 20px !important;
            padding: 20px !important;
        }

        table {
            font-size: 10px;
        }

        p {
            margin: 0;
        }

        h1 {
            margin: 0;
        }


        .text-center {
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .justify-between {
            justify-content: space-between;
        }

        .justify-between {
            justify-content: space-between;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        table,
        td,
        th {
            padding: 5px;
            border-collapse: collapse;
            border: 1px solid #000;

        }

        #orderinfo-table tr td {
            border: 1px solid #000000;
        }

        #orderinfo-table2 tr td {
            border: 1px solid #000000;
            text-align: left;
        }

        @page {
            header: page-header;
            footer: page-footer;
            margin: 120px 50px 50px 50px;
        }
    </style>
</head>

<body>
<htmlpageheader name="page-header">
    <div style="width: 100%; text-align: center">
        <img src="{{ asset('images/bbts_logo.png') }}" alt="Logo" class="pdfimg">
        <h5>Ispahani Building (2nd Floor), Agrabad C/A, Chittagong-4100.</h5>
    </div>
</htmlpageheader>

<html-separator />

<div style="width: 100%; flex: max-content">
    <div style="text-align: start">
        <div>
            <h3>PURCHASE ORDER</h3>
            <span>Purchase Order No: {{$purchase_order->po_no}}</span><br>
            <span>Date Issued: {{$purchase_order->date}}</span><br>
            <span>Ref Indent No: {{$purchase_order->indent->indent_no}}</span>
        </div>
        <br>
        <div style="display: flex;">
            <table class="table table-striped table-bordered" style="width: 20%;text-align: left">
                <thead>
                <tr style="background-color: #668ba6;color: black">
                    <th style="text-align: start">To</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td style="text-align: start">{{ $purchase_order->supplier->name ??''}}<br>
                        {{ $purchase_order->supplier->address_1 ??''}}<br>
                        {{ $purchase_order->supplier->mobile_no??'' }}<br>
                        {{ $purchase_order->supplier->email ??''}}<br>
                    </td>
                </tr>
                </tbody>
            </table>
            <table class="table table-striped table-bordered" style="width: 20%; text-align: end; margin: 0 auto">
                    <thead>
                    <tr style="background-color: #668ba6;color: black">
                        <th style="text-align: start">Ship To</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td style="text-align: start">Broad Band Telecom Services Limited<br>
                            Ispahani Building(5th Floor),<br>
                            Agrabad C/A<br>
                            Chattogram 4100<br>
                            Bangladesh<br>
                        </td>
                    </tr>
                    </tbody>
                </table>
        </div>
        <br>
        <div>
            Dear Sir,<br>
            With reference to the above, we are pleased to place order for supply of the following materials to Head Office, Agrabad, Chattogram and condition mentioned below :
        </div>
        <br>
    </div>
    <table class="table table-striped table-bordered" style="width: 100%">
        <thead>
        <tr style="background-color: #668ba6;color: black">
            <th>Item</th>
            <th>Description</th>
            <th>Quantity</th>
            <th>Unit</th>
            <th>Unit Cost</th>
            <th>Amount</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($purchase_order->purchaseOrderLines as $key => $value)
                    <tr>
                        <td class="text-center">{{ $value->material->name ??''}}</td>
                        <td class="text-center">{{ $value->description ??''}}</td>
                        <td class="text-center">{{ $value->quantity??'' }}</td>
                        <td class="text-center">{{ $value->material->unit ??''}}
                        <td class="text-center">{{ $value->unit_price??'' }}</td>
                        <td class="text-center">{{ $value->total_amount??'' }}</td>
                    </tr>
                @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="5" class="text-right"><b>Total Amount</b></td>
            <td class="text-center"><b>{{ $purchase_order->purchaseOrderLines->sum('total_amount') }}</b></td>
        </tr>
        </tfoot>
    </table>
    <div>
        <br>
        <div>
            <b>Time of Delivery: </b> Prompt after receiving purchase order.<br>
            <b>Places of Supply: </b> Delivery to Head Office, Agrabad, Chattogram.<br>
            <b>Terms of Payment: </b> Payment will be made within short time after receiving of product and submission of bill by A/C Payee Cheque.<br>
        </div>
        <br>
        <br>
        <br>
        <div style="text-align: end">
            <div>
                For Broad Band Telecom Services Ltd.<br><br><br><br>
                General Manager --Supply Chain
            </div>
            <br>
        </div>
        <br>
        <div class="form-group col-4">
            <label for="terms_and_conditions"><u><b>Terms and Conditions :</b></u></label>
            <div class="input-group">
                <ol>
                    @foreach ($purchase_order->poTermsAndConditions as $term)
                        <li>{{ $term->particular }}</li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
</div>
</body>
</html>
