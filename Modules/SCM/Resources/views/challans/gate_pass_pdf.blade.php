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

        table,
        td,
        th {
            padding: 5px;
            border-collapse: collapse;
            border: 1px solid #000;
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
        .col-5 {
            float: right;
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
        <div class="col-4" style="border: 1px solid #000000; border-radius: 5px;margin-top: 40px;margin-left: 20px">
            <table class="table rounded-table infoTable">
                <thead>
                <tr>
                    <td>Gate Pass No :</td>
                    <td>{{$challan->challan_no ?? ''}}</td>
                </tr>
                <tr>
                    <td>Client :</td>
                    <td>{{$challan->client->client_name ?? ''}}</td>
                </tr>
                <tr>
                    <td>Purpose :</td>
                    <td>{{$challan->purpose ?? ''}}</td>
                </tr>
                <tr>
                    <td>Connectivity Point :</td>
                    <td>{{ $challan->feasibilityRequirementDetail->connectivity_point ?? ''}}</td>
                </tr>
                <tr>
                    <td>Address :</td>
                    <td>{{$challan->billingAddress->address ?? ''}}</td>
                </tr>
                <tr>
                    <td>Contact Person :</td>
                    <td>{{$challan->billingAddress->contact_person ?? ''}}</td>
                </tr>
                <tr>
                    <td>Contact Number :</td>
                    <td>{{$challan->billingAddress->phone ?? ''}}</td>
                </tr>
                <tr>
                    <td>Date :</td>
                    <td>{{$challan->date ?? ''}}</td>
                </tr>
                </thead>
            </table>
        </div>
    </div>
    <div class="">
        <div>
            <h2 style="text-align: center; width: 30%; border: 1px solid #000000; border-radius: 5px; margin: 10px auto">
                GATE PASS</h2>
        </div>
        <div>
            <table class="table table-striped table-bordered" style="width: 100%">
                <thead>
                <tr>
                    <th>Challan No.</th>
                    <th>Material Name</th>
                    <th>Item Code</th>
                    <th>Unit</th>
                    <th>Quantity</th>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Purpose</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($challan->scmChallanLines as $key => $scmChallanLine)
                    <tr>
                        <td> {{ $challan->challan_no }} </td>
                        <td> {{ $scmChallanLine->material->name }} </td>
                        <td> {{ $scmChallanLine->item_code }} </td>
                        <td> {{ $scmChallanLine->material->unit }} </td>
                        <td> {{ $scmChallanLine->quantity }} </td>
                        <td> {{ $scmChallanLine->brand->name }} </td>
                        <td> {{ $scmChallanLine->model }} </td>
                        <td> {{ $scmChallanLine->purpose }} </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>

</html>
