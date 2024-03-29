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
            text-align: center;
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

        .signature-container {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .signature-line {
            border: none;
            border-top: 1px solid black;
            width: 150px; /* Adjust the width as needed */
            margin-bottom: 5px; /* Add some spacing between the line and the text */
            margin-top: 100px;
        }

        .signature-container span {
            text-align: right;
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

<html-separator/>

<div style="width: 100%; flex: max-content">
    <h3 style="text-align: center"><u>Product Cost Report</u></h3>
    <div>
        <table class="table table-striped table-bordered" style="width: 100%">
            <thead>
            <tr>
                <th>Client</th>
                <th>Item Code</th>
                <th>Material</th>
                <th>Quantity</th>
                <th>Unit</th>
                <th>Rate</th>
                <th>Total Price</th>
                <th>Serial Code</th>
                <th>Challan No</th>
                <th>Challan Date</th>
                <th>Product Ownership</th>
                <th>Total Cost of Product<br>for this Client</th>
                <th>Total Cost of Product<br>for this Client (BBTS Ownership)</th>
                <th>Total Cost of Product<br>for this Client (Client Ownership)</th>
                <th>Remarks</th>
            </tr>
            </thead>
            <tbody>
            @php $prevConnectivityPoint = null; @endphp
            @foreach($stocks as $key => $material)
                @if($prevConnectivityPoint !== $material['connectivity_point'])
                    <tr>
                        <td>{{ $material['client'] }}</td>
                        <td>{{ $material['item_code'] }}</td>
                        <td>{{ $material['name'] }}</td>
                        <td>{{ $material['quantity'] }}</td>
                        <td>{{ $material['unit'] }}</td>
                        <td>{{ $material['rate'] }}</td>
                        <td>{{ $material['total_price'] }}</td>
                        <td>{{ $material['serial'] }}</td>
                        <td>{{ $material['challan_no'] }}</td>
                        <td>{{ $material['challan_date'] }}</td>
                        <td></td>
                        <td rowspan="{{ $material['row_span'] }}">{{ $material['total_product_cost'] }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    @php $prevConnectivityPoint = $material['connectivity_point']; @endphp
                @else
                    <tr>
                        <td>{{ $material['client'] }}</td>
                        <td>{{ $material['item_code'] }}</td>
                        <td>{{ $material['name'] }}</td>
                        <td>{{ $material['quantity'] }}</td>
                        <td>{{ $material['unit'] }}</td>
                        <td>{{ $material['rate'] }}</td>
                        <td>{{ $material['total_price'] }}</td>
                        <td>{{ $material['serial'] }}</td>
                        <td>{{ $material['challan_no'] }}</td>
                        <td>{{ $material['challan_date'] }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>

    {{--    <div class="signature-container">--}}
    {{--        <div class="signature-line" style="border: 1px solid black;"></div>--}}
    {{--        <span style="color: black;">Authorised Signature</span>--}}
    {{--    </div>--}}
</div>
</body>
</html>
