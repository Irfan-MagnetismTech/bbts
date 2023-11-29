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
    <div>
        &nbsp;
    </div>
    <div>
        &nbsp;
    </div>
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
            <span><b>Purchase Order No:</b> {{$purchase_order->po_no ?? ''}}</span><br>
            <span><b>CS No:</b> {{$purchase_order->cs_no ?? ''}}</span><br>
            <span><b>Ref Indent No:</b> {{$purchase_order->indent->indent_no ?? ''}}</span><br>
            <span>
                <b>PRS No:</b>
                @foreach ($purchase_order->indent->indentLines as $line)
                    {{ $line->scmPurchaseRequisition->prs_no ?? ''}}
                    @if (!$loop->last)
                        ,
                    @endif
                @endforeach
            </span><br>
            <span><b>Date Issued:</b> {{$purchase_order->date ?? ''}}</span>
        </div>
        <br>

        <div style="width: 100%;">
            <div style="width: 25%; float: left;">
                <table class="table table-striped table-bordered" style="width: 100%;">
                    <thead>
                    <tr style="background-color: #668ba6; color: black">
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
            </div>

            <div style="width: 25%; float: right;">
                <table class="table table-striped table-bordered" style="width: 100%;">
                    <thead>
                    <tr style="background-color: #668ba6; color: black">
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
            <th>Brand</th>
            <th>Model</th>
            <th>Warranty Period</th>
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
                        <td class="text-center">{{ $value->material->name ?? ''}}</td>
                        <td class="text-center">{{ $value->brand->name ?? ''}}</td>
                        <td class="text-center">{{ $value->model ?? ''}}</td>
                        <td class="text-center">{{ $value->warranty_period ?? '' }}</td>
                        <td class="text-center">{{ $value->description ?? ''}}</td>
                        <td class="text-center">{{ $value->quantity ?? '' }}</td>
                        <td class="text-center">{{ $value->material->unit ?? ''}}
                        <td class="text-center">{{ $value->unit_price ?? '' }}</td>
                        <td class="text-center">{{ number_format($value->total_amount) ?? '' }}</td>
                    </tr>
                @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="8" class="text-right"><b>Total Amount</b></td>
{{--            <td class="text-center"><b>{{ $purchase_order->purchaseOrderLines->sum('total_amount') ?? ''}}</b></td>--}}
            <td class="text-center"><b>{{ number_format(ceil($purchase_order->purchaseOrderLines->sum('total_amount'))) ?? '' }}</b></td>

        </tr>
        </tfoot>
    </table>
    <div>
        <br>
        <div>
            <b>Time of Delivery: </b> Prompt after receiving purchase order.<br><br>
            <b>Places of Supply: </b> {{$purchase_order->delivery_location ?? ''}}<br><br>
            <b>Terms of Payment: </b>
            <div class="input-group">
                <ol>
                    @foreach ($purchase_order->poTermsAndConditions as $term)
                        <li>{{ $term->particular ?? ''}}</li>
                    @endforeach
                </ol>
            </div>
        </div>

        <br>
        <div style="text-align: end">
            <div>
                For Broad Band Telecom Services Ltd.<br><br><br>
                General Manager --Supply Chain
            </div>
            <br>
        </div>
    </div>
</div>
</body>
</html>
