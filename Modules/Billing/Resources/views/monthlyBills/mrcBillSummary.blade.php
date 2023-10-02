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

        /* Define the fixed header styles */
        .header {
            clear: both;
            width: 100%;
            display: block;
            text-align: center;
        }

        #fixed_header {
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            right: 0;
        }
    </style>
</head>

<body>

<div class="fixed_header">
    @if($withPad==1)
        <div id="logo" class="pdflogo">
            <img src="{{ asset('images/bbts_logo.png') }}" alt="Logo" class="pdfimg">
            <div class="clearfix" style="margin-top: 10px"></div>
            <h5 style="margin: 0 !important; padding: 0 !important">Ispahani Building (2nd Floor), Agrabad C/A,
                Chittagong-4100.</h5>
            <h5 style="margin: 0 !important; padding: 0 !important">Billing Contact: 01800000000, Hot Line: 01900000000,
                Support Contact: 01700000000</h5>
        </div>
    @endif

    <div>
        <h2 style="background-color: #e3e3e3; text-align: center; width: 30%; border: 1px solid #000000; border-radius: 5px; margin: 20px auto">
            Monthly Connectivity Charge</h2>
    </div>
</div>
<html-separator/>
<div class="container" style="margin-top: 50%!important; width: 96%;">
    <div class="row">
        <div class="col-3 mb-3">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="client_no">Client ID <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="client_no" name="client_no" placeholder="Client No"
                       value="{{ old('client_no') ?? ($monthlyBill->client_no ?? '') }}" required>
            </div>
        </div>
        <div class="col-3 mb-3">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="client_name">Client Name <span
                        class="text-danger">*</span></label>
                <input type="text" class="form-control" id="client_name" name="client_name"
                       aria-describedby="client_name"
                       placeholder="Enter Client Name"
                       value="{{ old('client_name') ?? ($monthlyBill->client->client_name ?? '') }}" required>
            </div>
        </div>
        <div class="col-3 mb-3">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="bill_type">Bill Type <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="bill_type" name="bill_type" placeholder="Enter Bill Type"
                       value="Summary" required>
            </div>
        </div>
        <div class="col-3 mb-3">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="date">Month<span class="text-danger">*</span></label>
                <input type="month" class="form-control" id="month" name="month" aria-describedby="month"
                       placeholder="Enter  month" value="{{ old('month') ?? ($monthlyBill->month ?? '') }}" required>
            </div>
        </div>
    </div>
    <div class="row" style="padding:30px 0 30px;">

        <div class="col-5" style="border: 1px solid #000000; border-radius: 5px;margin: 0;">
            <table class="table rounded-table infoTable">
                <thead>
                <tr>
                    <td>Client :</td>
                    <td>{{$monthlyBill->client->client_name}}</td>
                </tr>
                <tr>
                    <td>Address :</td>
                    <td>{{$monthlyBill->billingAddress->address}}</td>
                </tr>
                <tr>
                    <td>Attention :</td>
                    <td>{{$monthlyBill->billingAddress->contact_person}}</td>
                </tr>
                <tr>
                    <td>Designation :</td>
                    <td>{{$monthlyBill->billingAddress->designation}}</td>
                </tr>
                <tr>
                    <td>BIN No :</td>
                    <td>{{$monthlyBill?->billingAddress->phone ?? ''}}</td>
                </tr>
                </thead>
            </table>
        </div>
        <div class="col-2"></div>
        <div class="col-4" style="border: 1px solid #000000; border-radius: 5px;margin: 0;float:right;">
            <table class="table infoTable">
                <thead>
                <tr>
                    <td>Invoice No :</td>
                    <td>{{$monthlyBill->client->client_name}}</td>
                </tr>
                <tr>
                    <td>Invoice Date :</td>
                    <td>{{$monthlyBill->billingAddress->address}}</td>
                </tr>
                <tr>
                    <td>Invoice Period :</td>
                    <td>{{$monthlyBill->billingAddress->contact_person}}</td>
                </tr>
                <tr>
                    <td>BBTSL BIN No :</td>
                    <td>{{$monthlyBill?->client?->bin_no ?? ''}}</td>
                </tr>
                </thead>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="offset-md-2 col-md-7 mt-1">
            <table class="table table-bordered" id="table">
                <thead>
                <tr>
                    <th width="14.28%">Point Name</th>
                    <th width="14.28%">Total</th>
                    <th width="14.28%">Vat</th>
                    <th width="14.28%">Total Amount</th>
                    @if($withDue==1)
                        <th width="14.28%">Due</th>
                    @endif
                    <th width="14.28%">Net Amount</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $g_total_price = 0;
                    $g_vat = 0;
                @endphp
                @foreach ($groupedLines as $key1=>$values )
                    <tr>
                        <td style="text-align: center;">{{$values->first()->frDetail->connectivity_point}}</td>
                        <td style="text-align: center;">{{$values->sum('total_price')}}</td>
                        <td style="text-align: center;">{{$values->sum('vat')}}</td>
                        <td style="text-align: center;">{{$values->sum('total_price') + $values->sum('vat')}}</td>
                        @if($withDue==1)
                            <td style="text-align: center;">0</td>
                        @endif
                        <td style="text-align: center;">{{$values->sum('total_price') + $values->sum('vat')}}</td>
                    </tr>
                    @php
                        $g_total_price += $values->sum('total_price');
                        $g_vat += $values->sum('vat');
                    @endphp
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td class="text-right" style="text-align: right;">Total Amount</td>
                    <td style="text-align: center;">{{$g_total_price}}</td>
                    <td style="text-align: center;">{{$g_vat}}</td>
                    <td style="text-align: center;">{{$g_total_price + $g_vat}}</td>
                    @if($withDue==1)
                        <td style="text-align: center;">0</td>
                    @endif
                    <td style="text-align: center;">{{$g_total_price + $g_vat}}</td>
                </tr>
                @if($monthlyBill->penalty != null || $monthlyBill->penalty != 0)
                    @if($withDue==1)
                        <tr>
                            <td colspan="5" style="text-align: right;">Penalty Amount</td>
                            <td style="text-align: center;">{{$monthlyBill?->penalty}}</td>
                        </tr>
                        <tr>
                            <td colspan="5" style="text-align: right;">Gross Total</td>
                            <td style="text-align: center;">{{$g_total_price + $g_vat - $monthlyBill?->penalty}}</td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="4" style="text-align: right;">Penalty Amount</td>
                            <td style="text-align: center;">{{$monthlyBill?->penalty}}</td>
                        </tr>
                        <tr>
                            <td colspan="4" style="text-align: right;">Gross Total</td>
                            <td style="text-align: center;">{{$g_total_price + $g_vat - $monthlyBill?->penalty}}</td>
                        </tr>
                    @endif
                @endif
                </tfoot>
            </table>
        </div>
    </div>
    </form>
</div>
</body>

</html>
