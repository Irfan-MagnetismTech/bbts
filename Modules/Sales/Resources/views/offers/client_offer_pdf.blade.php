<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> {{ $survey->lead_generation->client_name ?? '' }} Client Offer PDF</title>
    <style>
        .text-center {
            text-align: center;
        }

        .font-weight-bold {
            font-weight: bold;
        }

        .productTable {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid black;
            font-size: 12px;
        }

        .productTable th {
            border: 1px solid rgb(61, 66, 65);
            padding: 5px;
            background: #f2f2f2;
        }

        .productTable td {
            border: 1px solid rgb(61, 66, 65);
            padding: 5px;
        }

        .equipementTable {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid black;
            font-size: 12px;
        }

        .equipementTable th {
            border: 1px solid rgb(61, 66, 65);
            padding: 5px;
            background: #f2f2f2;
        }

        .equipementTable td {
            border: 1px solid rgb(61, 66, 65);
            padding: 5px;
        }

        .totalInvestment {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid black;
            font-size: 12px;
        }

        .totalInvestment th {
            border: 1px solid rgb(61, 66, 65);
            padding: 5px;
            background: #f2f2f2;
        }

        .totalInvestment td {
            border: 1px solid rgb(61, 66, 65);
            padding: 5px;
        }

        .productEquipmentTable {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid black;
            font-size: 12px;
        }

        .productEquipmentTable th {
            border: 1px solid rgb(61, 66, 65);
            padding: 5px;
            background: #f2f2f2;
        }

        .productEquipmentTable td {
            border: 1px solid rgb(61, 66, 65);
            padding: 5px;
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
            margin: 150px 10px 40px 10px;
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
                <h5 style="margin: 2px; padding: 2px;">Ispahani Building (2nd Floor), Agrabad C/A, Chittagong-4100.
                </h5>
                <h4 style="margin: 2px; padding: 2px;">Client Offer</h4>
                <hr />
            </div>
        </div>

    </htmlpageheader>
    <div class="card card-primary card-outline">
        <table style="width:100%;">
            <tr>
                <td>
                    <div>
                        <label>
                            <span style="font-size: 13px;"><b>Client Name:</b>
                                {{ $offer->lead_generation->client_name ?? null }}</span>
                        </label>
                    </div>
                </td>
                <td>
                    <div>
                        <label>
                            <span style="font-size: 13px;"><b>Client No: </b>{{ $offer->client_no }}</span>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="input-group input-group-sm input-group-primary">
                        <label>
                            <span style="font-size: 13px;"><b>MQ No: </b>{{ $offer->mq_no }}</span>
                        </label>
                    </div>
                </td>
            </tr>
        </table>

        @php
            $total_mrc = 0;
        @endphp
        @foreach ($offerData as $data)
            <div>
                <div class="col-12 mt-3">
                    <table class="productTable">
                        <thead>
                            <tr>
                                <th colspan="7">{{ $data->frDetails->connectivity_point ?? '' }}</th>
                            </tr>
                            <tr class="text-center">
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Unit</th>
                                <th>Rate</th>
                                <th>Amount</th>
                                <th>Vat</th>
                                <th>Total Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total = 0;
                            @endphp
                            @foreach ($data->costing->costingProducts as $product)
                                @php
                                    $totalProductPrice = $product->quantity * $product->product_price;
                                    $vat = $product->product_vat_amount;
                                    $total += $totalProductPrice + $vat;
                                    $total_mrc += $totalProductPrice + $vat;
                                @endphp

                                <tr class="text-center">
                                    <td>{{ $product->product->name }}</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>{{ $product->unit }}</td>
                                    <td>{{ number_format($product->product_price, 2) }}</td>
                                    <td>{{ number_format($totalProductPrice, 2) }}</td>
                                    <td>{{ number_format($vat, 2) }}</td>
                                    <td class="text-right"><b>@formatFloat($totalProductPrice + $vat)</b></td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="text-right" colspan="6"><b>Total Product Price</b></td>
                                <td class="text-right"><b>@formatFloat($total)</b></td>
                            </tr>
                            <tr>
                                <td class="text-right" colspan="6"><b>OTC</b></td>
                                <td class="text-right"><b>@formatFloat($data->total_offer_otc)</b></td>
                            </tr>
                            <tr>
                                <td colspan="6" class="text-right"><b>Total</b></td>
                                <td class="text-right"><b>@formatFloat($total + $data->total_offer_otc)</b></td>

                            </tr>
                        </tfoot>
                    </table>
                </div>
                {{-- @dd($uniqueEquipments); --}}
                @if (!isset($uniqueEquipments))
                    <div class="col-12 mt-3">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th>Equipment</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                    <th>Ownership</th>
                                    <th>Rate</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($uniqueEquipments as $equipment)
                                    <tr>
                                        <td>{{ $equipment->material->name }}</td>
                                        <td>{{ $equipment->sum_quantity }}</td>
                                        <td>{{ $equipment->unit }}</td>
                                        <td>{{ $equipment->ownership }}</td>
                                        <td>{{ number_format($equipment->rate, 2) }}</td>
                                        <td>{{ number_format($equipment->total_price, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

            </div>
        @endforeach
        <div class="float-right" style="margin-top: 20px; font-size:14px;">
            <span class="p-2 border bg-primary">
                Total MRC
            </span>
            <span class="p-2 border border-primary text-dark">
                {{ number_format($total_mrc, 2) }}
            </span>
        </div>
    </div>
    </div>
</body>

</html>
