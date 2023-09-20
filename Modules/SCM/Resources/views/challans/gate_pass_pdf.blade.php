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
<div>
    &nbsp;
</div>
<div style="width: 100%; flex: max-content">
    <div style="text-align: center">
        <h2 style="text-align: center; width: 40%; border: 1px solid #000000; border-radius: 5px; margin: 20px auto">GATE PASS</h2>
    </div>
    <div style="text-align: end">
        <h4>Date: {{$challan->date}}</h4>
    </div>
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
{{--<htmlpagefooter name="page-footer">--}}
{{--    <div class="text-xs justify-between">--}}
{{--            <div style="width:24%; float:left; margin-left: 5px;">--}}
{{--                <div>--}}
{{--                    <div class="text-center"> </div>--}}
{{--                    <hr class="w-32 border-gray-700" />--}}
{{--                    <div class="text-center">Prepared By</div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div style="width:24%; float:left; margin-left: 5px;">--}}
{{--                <div>--}}

{{--                    <hr class="w-32 border-gray-700" />--}}
{{--                    <div class="text-center">Client Sign</div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div style="width:24%; float:left; margin-left: 5px;">--}}
{{--                <div>--}}

{{--                    <hr class="w-32 border-gray-700" />--}}
{{--                    <div class="text-center">Driver Sign</div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div style="width:24%; float:left; margin-left: 5px;">--}}
{{--                <div>--}}
{{--                    <div class="text-center"></div>--}}
{{--                    <hr class="w-32 border-gray-700" />--}}
{{--                    <div class="text-center">MD</div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--</htmlpagefooter>--}}
</body>
</html>
