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

        #dataTable td {
            text-align: center;
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
    <h3 style="text-align: center"><u>IP Information</u></h3>
    <div>
        <table id="dataTable" class="table table-striped table-bordered" style="width: 100%">
            <thead>
            <tr>
                <th>Sl No</th>
                <th>Description</th>
                <th>IPv4</th>
                <th>IPv6</th>
                <th>Zone Name</th>
                <th>Remarks</th>
            </tr>
            </thead>
            <tbody>
            @php($i=1)
            @foreach($logical_connectivities as $key => $connectivity)
                @foreach($connectivity->lines as $subKey => $value)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{ $value->data_type ?? ''}}</td>
                        <td>{{ $value->ip_ipv4 ?? ''}}</td>
                        <td>{{ $value->ip_ipv6 ?? ''}}</td>
                        <td>{{$connectivity->feasibilityRequirementDetails->branch->name ?? ''}}</td>
                        <td>{{ $value->remarks ?? ''}}</td>
                    </tr>
                @endforeach
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