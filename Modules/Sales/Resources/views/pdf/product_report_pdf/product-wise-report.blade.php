<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product Wise Report</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid black;
            padding: 5px;
        }

        th {
            text-align: center;
        }

        .dt-responsive {
            overflow: auto;
            padding: 0 5%;
        }

        thead tr th {
            background-color: #f2f2f2;
            font-size: 12px;
        }

        tbody tr td {
            font-size: 12px;
        }

        @page {
            header: page-header;
            footer: page-footer;
        }

        #logo {
            clear: both;
            width: 100%;
            display: block;
            text-align: center;
            position: relative;
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
            margin: 150px 0px 40px 0px;
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
                <h5 style="margin: 2px; padding: 2px;">Ispahani Building (2nd Floor), Agrabad C/A, Chittagong-4100.</h5>
                <h4 style="margin: 2px; padding: 2px;">Product Wise Report</h4>
                <hr />
            </div>
        </div>

    </htmlpageheader>

  
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <tbody>
                @foreach ($product_data as $key => $product)
                    <tr style="background-color: rgb(213, 255, 177) !important; font-weight:bold;">
                        <td colspan="10" class="text-center font-weight-bold">{{ $key }}</td>
                    </tr>
                    <tr style="background-color: rgb(177, 255, 229) !important; font-weight:bold;">
                        <td>#SL</td>
                        <td>Client No</td>
                        <td>Client Name</td>
                        <td>Quantity</td>
                        <td>Price</td>
                        <td>Total</td>
                        <td>Activation Date</td>
                        <td>Billing Start Date</td>
                        <td>Account Holder</td>
                    </tr>
                    @foreach ($product as $single_product)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $single_product['client_no'] }}</td>
                            <td>{{ $single_product['client_name'] }}</td>
                            <td>{{ $single_product['quantity'] }}</td>
                            <td>{{ $single_product['price'] }}</td>
                            <td>{{ $single_product['total'] }}</td>
                            <td>{{ $single_product['activation_date'] }}</td>
                            <td>{{ $single_product['billing_date'] }}</td>
                            <td>{{ $single_product['account_holder'] }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
