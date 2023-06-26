<!DOCTYPE html>
<html>

<head>
    <style>
        .row {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }

        .col {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 5px;
            text-align: left;
        }

        table tr:nth-child(even) {
            background-color: #eee;
        }

        table tr:nth-child(odd) {
            background-color: #fff;
        }

        table th {
            background-color: black;
            color: white;
        }

        .page-break {
            page-break-after: always;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        .text-underline {
            text-decoration: underline;
        }

        .text-bold {
            font-weight: bold;
        }

        .text-italic {
            font-style: italic;
        }

        .text-uppercase {
            text-transform: uppercase;
        }

        .text-capitalize {
            text-transform: capitalize;
        }

        .text-lowercase {
            text-transform: lowercase;
        }

        .text-justify {
            text-align: justify;
        }

        .text-nowrap {
            white-space: nowrap;
        }

        .col-1 {
            width: 8.33%;
        }

        .col-2 {
            width: 16.66%;
        }

        .col-3 {
            width: 25%;
        }

        .col-4 {
            width: 33.33%;
        }

        .col-5 {
            width: 41.66%;
        }

        .col-6 {
            width: 50%;
        }

        .col-7 {
            width: 58.33%;
        }

        .col-8 {
            width: 66.66%;
        }

        .col-9 {
            width: 75%;
        }

        .col-10 {
            width: 83.33%;
        }

        .col-11 {
            width: 91.66%;
        }

        .col-12 {
            width: 100%;
        }

        .image-margin {
            margin-top: 5px;
            margin-left: 10px;
        }

        .row h1,
        h3,
        h2,
        h4 {
            margin: 0;
        }

        .mb-0 {
            margin-bottom: 0;
        }

        .mb-1 {
            margin-bottom: 1rem;
        }

        .mb-2 {
            margin-bottom: 2rem;
        }

        .mb-3 {
            margin-bottom: 3rem;
        }

        .mb-4 {
            margin-bottom: 4rem;
        }

        .row p {
            margin: 2px;
        }

        .d-flex {
            display: flex;
        }

        .justify-content-center {
            justify-content: center;
        }

        .justify-content-between {
            justify-content: space-between;
        }

        .justify-content-evenly {
            justify-content: space-evenly;
        }

        .btn {
            border: none;
            color: white;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 12px;
            margin: 2px 1px;
            cursor: pointer;
            border-radius: 5px;
        }

        .btn-primary {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 12px;
            margin: 2px 1px;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="row mb-1">
        <div class="col-2 image-margin">
            <img src="{{ asset('images/bbts_logo_big.png') }}" alt="logo" style="height: 60px; width: 60px;">
        </div>
        <div class="col-8 text-center">
            <h2>Broad Band Telecom Services Limited</h2>
            <h4>Ispahani Building (5th Floor) Argrabad, Chittagong.</h4>
        </div>
        <div class="col-2">
            <p style="font-size: 15px;"><span style="text-bold">Client No:</span> 2023-08 </p>
            <p style="font-size: 15px;"><span style="text-bold">Client Name:</span> Jahirul Islam </p>
            <p style="font-size: 15px;"><span style="text-bold">Month:</span> 12 </p>
        </div>
    </div>
    <div class="row mb-1">
        <div class="col-12 text-center">
            <h2>Profit and Loss Statement</h2>
            <hr />
        </div>
    </div>
    <div>
        <table>
            <thead>
                <tr class="text-center">
                    <th>Link Name</th>
                    <th>Total Inv</th>
                    <th>OTC</th>
                    <th>Equipment Price</th>
                    <th>Total OTC</th>
                    <th>Product Cost</th>
                    <th>Monthly Cost</th>
                    <th>Total Budget</th>
                    <th>Monthly Revenue</th>
                    <th>Total Revenue</th>
                    <th>Monthly PNL</th>
                    <th>Total PNL</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Link 1</td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>
                </tr>
                <tr>
                    <td>Link 2</td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>
                </tr>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-right">Total</td>
                    <td>10000</td>
                    <td colspan="2"></td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>
                    <td>10000</td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="d-flex justify-content-evenly" style="margin-top: 20px;">
        <button class="btn btn-primary">Details</button>
        <button class="btn btn-primary">Approval Finance</button>
        <button class="btn btn-primary">Approval CMO</button>
    </div>
</body>

</html>
