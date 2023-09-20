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
@php
    $iteration = 1;
@endphp
<htmlpageheader name="page-header">
    <div style="width: 100%; text-align: center">
        <img src="{{ asset('images/bbts_logo.png') }}" alt="Logo" class="pdfimg">
        <h5>Ispahani Building (2nd Floor), Agrabad C/A, Chittagong-4100.</h5>
    </div>
</htmlpageheader>

<html-separator />

<div style="width: 100%; flex: max-content">
    <h3 style="text-align: center"><u>REQUISITION FORM</u></h3>
    <div style="text-align: end">
        To: SUPPLY CHAIN DEPT.
    </div>
    <div style="text-align: start">
        <div>
            <span>Indent No: {{$indent->indent_no}}</span><br>
            <span>Date: {{$indent->date}}</span><br>
        </div>
        <br>
        <br>
        <div>
            Please arrange to supply the following item:
        </div>
        <br>
    </div>

    <table class="table table-striped table-bordered" style="width: 100%">
        <thead>
        <tr style="background-color: #668ba6;color: black">
            <th>SL#</th>
            <th>Material Name</th>
            <th>Total Quantity</th>
            <th>Unit</th>
            <th>Last Receiving Date</th>
            <th>PRS No.</th>
            <th>Item Code</th>
        </tr>
        </thead>
        <tbody>
        @php
            $materialQuantities = [];
            $iteration = 1;
        @endphp

        @foreach ($indent->indentLines as $key => $value)
            @foreach ($value->scmPurchaseRequisition->scmPurchaseRequisitionDetails as $key1 => $value1)
                @php
                    $materialName = $value1->material->name ?? '';
                    $quantity = $value1->quantity ?? 0;
                    $unit = $value1->material->unit ?? '';
                    $date = $value->scmPurchaseRequisition->date ?? '';
                    $prsNo = $value->scmPurchaseRequisition->prs_no ?? '';
                    $itemCode = $value1->material->code ?? '';

                    if (!isset($materialQuantities[$materialName])) {
                        $materialQuantities[$materialName] = [
                            'totalQuantity' => 0,
                            'unit' => $unit,
                            'date' => $date,
                            'prsNo' => $prsNo,
                            'itemCode' => $itemCode,
                        ];
                    }

                    $materialQuantities[$materialName]['totalQuantity'] += $quantity;
                @endphp

            @endforeach
        @endforeach

        @foreach ($materialQuantities as $materialName => $data)
            <tr>
                <td class="text-center">{{ $iteration++ }}</td>
                <td class="text-center">{{ $materialName }}</td>
                <td class="text-center">{{ $data['totalQuantity'] }}</td>
                <td class="text-center">{{ $data['unit'] }}</td>
                <td class="text-center">{{ $data['date'] }}</td>
                <td class="text-center">{{ $data['prsNo'] }}</td>
                <td class="text-center">{{ $data['itemCode'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="signature-container">
        <div class="signature-line" style="border: 1px solid black;"></div>
        <span style="color: black;">Authorised Signature</span>
    </div>
</div>
</body>
</html>
