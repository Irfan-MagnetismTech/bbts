<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Monthly Sales Report</title>
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

        .text-bold {
            font-weight: bold;
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
                <h4 style="margin: 2px; padding: 2px;">Monthly Sales Summary Report (Branch Wise)</h4>
                <hr />
            </div>
        </div>

    </htmlpageheader>

    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-bordered">
            <tbody>
                @foreach ($sales_data as $key => $monthly_summary)
                    <tr style="background-color: #c5d9f1;">
                        <th colspan="16" class="text-center">
                            {{ $key }}
                        </th>
                    </tr>
                    <tr style="background-color: #e2e2e2;">
                        <td class="text-bold">Client ID</td>
                        <td class="text-bold">Client Name</td>
                        <td class="text-bold">Connectivity Point</td>
                        <td class="text-bold">Pop</td>
                        <td class="text-bold">Method</td>
                        <td class="text-bold">Product</td>
                        <td class="text-bold">Quantity</td>
                        <td class="text-bold">Price</td>
                        <td class="text-bold">Total</td>
                        <td class="text-bold">OTC</td>
                        <td class="text-bold">MRC</td>
                        <td class="text-bold">Activation Date</td>
                        <td class="text-bold">Billing Start Date</td>
                        <td class="text-bold">Billing Address</td>
                        <td class="text-bold">Remarks</td>
                    </tr>
                    @foreach ($monthly_summary as $monthly_sales_summary)
                        @php
                            $max_rowspan = $monthly_sales_summary['products']->count();
                        @endphp

                        @for ($i = 0; $i < $max_rowspan; $i++)
                            <tr style="background-color: #f2f2f2;">
                                @if ($i == 0)
                                    <td rowspan="{{ $max_rowspan }}">
                                        {{ $monthly_sales_summary['client_no'] }}
                                    </td>
                                    <td rowspan="{{ $max_rowspan }}">
                                        {{ $monthly_sales_summary['client_name'] }}
                                    </td>
                                    <td rowspan="{{ $max_rowspan }}">
                                        {{ $monthly_sales_summary['connectivity_point'] }}
                                    </td>
                                @endif
                                @if (isset($monthly_sales_summary['pop'][$i]))
                                    <td>
                                        {!! $monthly_sales_summary['pop'][$i] !!}
                                    </td>
                                @else
                                    <td>-</td>
                                @endif

                                @if (isset($monthly_sales_summary['method'][$i]))
                                    <td>
                                        {!! $monthly_sales_summary['method'][$i] !!}
                                    </td>
                                @else
                                    <td>-</td>
                                @endif
                                <td>
                                    {{ $monthly_sales_summary['products'][$i]->product->name ?? '' }}
                                </td>
                                <td>
                                    {{ $monthly_sales_summary['products'][$i]->quantity ?? '' }}
                                </td>
                                <td>
                                    {{ $monthly_sales_summary['products'][$i]->price }}
                                </td>
                                <td>
                                    {{ $monthly_sales_summary['products'][$i]->quantity * $monthly_sales_summary['products'][$i]->price }}
                                </td>
                                @if ($i == 0)
                                    <td rowspan="{{ $max_rowspan }}">
                                        {{ $monthly_sales_summary['otc'] }}
                                    </td>
                                    <td rowspan="{{ $max_rowspan }}">
                                        {{ $monthly_sales_summary['mrc'] }}
                                    </td>
                                    <td rowspan="{{ $max_rowspan }}">
                                        {{ $monthly_sales_summary['activation_date'] }}
                                    </td>
                                    <td rowspan="{{ $max_rowspan }}">
                                        {{ $monthly_sales_summary['billing_date'] }}
                                    </td>
                                    <td rowspan="{{ $max_rowspan }}">
                                        {{ $monthly_sales_summary['billing_address'] }}
                                    </td>
                                    <td rowspan="{{ $max_rowspan }}">
                                        {{ $monthly_sales_summary['remarks'] }}</td>
                                @endif
                            </tr>
                        @endfor
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>

</body>

</html>
