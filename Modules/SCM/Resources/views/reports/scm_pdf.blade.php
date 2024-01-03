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
    <h3 style="text-align: center"><u>Material Stock Details</u></h3>
    <div>
        <table class="table table-striped table-bordered" style="width: 100%">
            <thead>
            <tr>
                <th>Material</th>
                <th>Unit</th>
                <th>Opening Stock</th>
                <th>MRR</th>
                <th>MIR</th>
                <th>MUR</th>
                <th>ERR</th>
                <th>Transfer</th>
                <th>Damage</th>
                <th>Warranty</th>
                <th>Grand Total</th>
            </tr>
            </thead>
            <tbody>
            @if($from_date == null && $to_date == null)
                @foreach($groupedStocks as $key => $stock)
                    <tr>
                        <td>{{ $stock['material_id'] }}</td>
                        <td>{{ $stock['unit'] }}</td>
                        <td>{{ $stock['opening_stock_qty'] }}</td>
                        <td>{{ $stock['scm_mrr_qty'] }}</td>
                        <td>{{ $stock['scm_mir_qty'] }}</td>
                        <td>{{ $stock['scm_mur_qty'] }}</td>
                        <td>{{ $stock['scm_err_qty'] }}</td>
                        <td>{{ $stock['transfer_qty'] }}</td>
                        <td></td>
                        <td></td>
                        <td><b>{{ $stock['total'] }}</b></td>
                    </tr>
                @endforeach
            @else
                @foreach($groupedStocks as $key => $stock)
                    @foreach($openingStocks as $openingKey => $openingStock)
                        @if($stock['material_id'] === $openingStock['material_id'])
                            <tr>
                                <td>{{ $stock['material_id'] }}</td>
                                <td>{{ $stock['unit'] }}</td>
                                <td>{{ $openingStock['opening_stock_qty'] }}</td>
                                <td>{{ $stock['scm_mrr_qty'] }}</td>
                                <td>{{ $stock['scm_mir_qty'] }}</td>
                                <td>{{ $stock['scm_mur_qty'] }}</td>
                                <td>{{ $stock['scm_err_qty'] }}</td>
                                <td>{{ $stock['transfer_qty'] }}</td>
                                <td></td>
                                <td></td>
                                <td><b>{{ $stock['total'] }}</b></td>
                            </tr>
                        @endif
                    @endforeach
                @endforeach
            @endif
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
