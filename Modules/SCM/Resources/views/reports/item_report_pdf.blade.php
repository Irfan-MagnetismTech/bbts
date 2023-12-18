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
    <h3 style="text-align: center"><u>Item Report</u></h3>
    <div>
        <table class="table table-striped table-bordered" style="width: 100%">
            <thead>
            <tr>
                <th>Date</th>
                <th>Branch</th>
                <th>Material</th>
                <th>Unit</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Type</th>
                <th>Quantity</th>
                <th>Rate</th>
                <th>Serial Code</th>
                <th>Supplier</th>
                <th>Client</th>
                <th>Client Code</th>
                <th>Indent No</th>
                <th>PRS No</th>
                <th>PO No</th>
                <th>Challan No</th>
                <th>Invoice No</th>
                <th>Issued to Branch</th>
                <th>Location</th>
                <th>Issue Purpose</th>
            </tr>
            </thead>
            <tbody>
            @foreach($stocks as $key => $material)
                <tr>
                    <td>{{ $material['date'] }}</td>

                    <td>{{ $material['branch'] }}</td>

                    <td>{{ $material['name'] }}</td>

                    <td>{{ $material['unit'] }}</td>

                    <td>{{ $material['brand'] }}</td>
                    @if($material['model'] == null || $material['model'] == 'null')
                        <td></td>
                    @else
                        <td>{{ $material['model'] }}</td>
                    @endif
                    @if($material['type'] === 'Modules\SCM\Entities\OpeningStock')
                        <td>OS</td>
                    @elseif($material['type'] === 'Modules\SCM\Entities\ScmMrr')
                        <td>MRR</td>
                    @elseif($material['type'] === 'Modules\SCM\Entities\ScmMir')
                        @if($material['quantity'] < 0)
                            <td>MIR</td>
                        @else
                            <td>Transfer</td>
                        @endif
                    @elseif($material['type'] === 'Modules\SCM\Entities\ScmMur')
                        <td>MUR</td>
                    @elseif($material['type'] === 'Modules\SCM\Entities\ScmErr')
                        <td>ERR</td>
                    @elseif($material['type'] === 'Modules\SCM\Entities\ScmWor')
                        <td>WOR</td>
                    @elseif($material['type'] === 'Modules\SCM\Entities\ScmWcr')
                        <td>WCR</td>
                    @elseif($material['type'] === 'Modules\SCM\Entities\ScmWcrr')
                        <td>WCRR</td>
                    @elseif($material['type'] === 'Modules\SCM\Entities\ScmChallan')
                        <td>CHALLAN</td>
                    @endif
                    <td>{{ $material['quantity'] }}</td>
                    <td>{{ $material['rate'] }}</td>
                    <td>{{ $material['serial'] }}</td>
                    <td>{{ $material['supplier'] }}</td>
                    <td>{{ $material['client'] }}</td>
                    <td>{{ $material['client_no'] }}</td>
                    <td>{{ $material['indent_no'] }}</td>
                    <td>{{ $material['prs_no'] }}</td>
                    <td>{{ $material['po_no'] }}</td>
                    <td>{{ $material['challan_no'] }}</td>
                    <td>{{ $material['invoice_no'] }}</td>
                    <td>{{ $material['to_branch'] }}</td>
                    <td>{{ $material['location'] }}</td>
                    <td>{{ $material['issue_purpose'] }}</td>
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
