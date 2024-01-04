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
    <h3 style="text-align: center"><u>Dues Report</u></h3>
    <div>
        <table id="dataTable" class="table table-striped table-bordered" style="width: 100%">
            <thead>
            <tr>
                <th>Sl</th>
                <th>Client No</th>
                <th>Client Name</th>
                <th>Bill No</th>
                <th>Bill Type</th>
                <th>Amount</th>
                <th>Penalty</th>
                <th>Discount</th>
                <th>Vat</th>
                <th>Tax</th>
                <th>Net Amount</th>
                <th>Received Amount</th>
                <th>Due Amount</th>
                <th>Date</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>Sl</th>
                <th>Client No</th>
                <th>Client Name</th>
                <th>Bill No</th>
                <th>Bill Type</th>
                <th>Amount</th>
                <th>Penalty</th>
                <th>Discount</th>
                <th>Vat</th>
                <th>Tax</th>
                <th>Net Amount</th>
                <th>Received Amount</th>
                <th>Due Amount</th>
                <th>Date</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($collection as $key => $value)
                <tr>
                    <td style="text-align: center">{{$key + 1}}</td>
                    <td style="text-align: start">{{ $value->client_no ?? ''}}</td>
                    <td style="text-align: start">{{ $value->client->client_name ?? ''}}</td>
                    <td style="text-align: start">
                        @foreach ($value->collectionBills as $subKey => $data)
                            {{ $data->bill_no ?? ''}} <br>
                        @endforeach
                    </td>
                    <td style="text-align: start">
                        @foreach ($value->collectionBills as $subKey => $data)
                            {{ $data->billGenerate->bill_type ?? ''}} <br>
                        @endforeach
                    </td>
                    <td style="text-align: right">
                        @foreach ($value->collectionBills as $subKey => $data)
                            {{ $data->amount ?? ''}} <br>
                        @endforeach
                    </td>
                    <td style="text-align: right">
                        @foreach ($value->collectionBills as $subKey => $data)
                            {{ $data->penalty ?? ''}} <br>
                        @endforeach
                    </td>
                    <td style="text-align: right">
                        @foreach ($value->collectionBills as $subKey => $data)
                            {{ $data->discount ?? ''}} <br>
                        @endforeach
                    </td>
                    <td style="text-align: right">
                        @foreach ($value->collectionBills as $subKey => $data)
                            {{ $data->vat ?? ''}} <br>
                        @endforeach
                    </td>
                    <td style="text-align: right">
                        @foreach ($value->collectionBills as $subKey => $data)
                            {{ $data->tax ?? ''}} <br>
                        @endforeach
                    </td>
                    <td style="text-align: right">
                        @foreach ($value->collectionBills as $subKey => $data)
                            {{ $data->net_amount ?? ''}} <br>
                        @endforeach
                    </td>
                    <td style="text-align: right">
                        @foreach ($value->collectionBills as $subKey => $data)
                            {{ $data->receive_amount ?? ''}} <br>
                        @endforeach
                    </td>
                    <td style="text-align: right">
                        @foreach ($value->collectionBills as $subKey => $data)
                            {{ $data->due ?? ''}} <br>
                        @endforeach
                    </td>
                    <td style="text-align: center">{{ $value->date ?? ''}}</td>
                </tr>
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
