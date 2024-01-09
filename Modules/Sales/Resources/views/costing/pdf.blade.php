<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> {{ $costing->lead_generation->client_name ?? '' }} Costing </title>
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
    <div>
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
                    <h4 style="margin: 2px; padding: 2px;">Costing</h4>
                    <hr />
                </div>
            </div>

        </htmlpageheader>
        <div>
            <div style="margin-bottom: 10px;">
                <table style="width: 100%">
                    <tbody>
                        <tr>
                            <td>
                                <span style="font-size: 12px;">Client No: </span><span class="font-weight-bold"
                                    style="font-size: 12px;">{{ $costing->client_no ?? '' }}</span>
                            </td>
                            <td>
                                <span style="font-size: 12px;">Month : </span><span class="font-weight-bold"
                                    style="font-size: 12px;">{{ $costing->month ?? '' }}</span>

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span style="font-size: 12px;">Connectivity Point : </span><span
                                    class="font-weight-bold"
                                    style="font-size: 12px;">{{ $costing->feasibilityRequirementDetail->connectivity_point ?? '' }}</span>
                            </td>
                            <td>
                                <span style="font-size: 12px;">Client Name: </span><span class="font-weight-bold"
                                    style="font-size: 12px;">{{ $costing->lead_generation->client_name ?? '' }}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div>
                <div>
                    <div>
                        <table class="productTable">
                            <thead>
                                <tr>
                                    <th colspan="11">Product Costing</th>
                                </tr>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                    <th>Rate</th>
                                    <th>Amount</th>
                                    <th>Operation Cost</th>
                                    <th>Total Amount</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                    <th>Vat Amount</th>
                                    <th>Total Price</th>
                                </tr>
                            </thead>
                            <tbody class="productBody">
                                @foreach ($costing->costingProducts as $costing_product)
                                    <tr class="product_details_row">
                                        <td>{{ $costing_product->product->name }}</td>
                                        <td>{{ $costing_product->quantity }}</td>
                                        <td>{{ $costing_product->unit }}</td>
                                        <td>{{ $costing_product->rate }}</td>
                                        <td class="text-right">@formatFloat($costing_product->sub_total)</td>
                                        <td class="text-right">@formatFloat($costing_product->operation_cost)</td>
                                        <td class="text-right">@formatFloat($costing_product->operation_cost_total)</td>
                                        <td class="text-right">@formatFloat($costing_product->offer_price)</td>
                                        <td class="text-right">@formatFloat($costing_product->total)</td>
                                        <td class="text-right">@formatFloat($costing_product->product_vat_amount)</td>
                                        <td class="text-right"><b>@formatFloat($costing_product->product_vat_amount + $costing_product->total)</b></td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="4" class="text-right"> <b>Total</b></td>
                                    <td class="text-right"> <b> @formatFloat($costing->costingProducts->sum('sub_total')) </b> </td>
                                    <td class="text-right"> <b> @formatFloat($costing->costingProducts->sum('operation_cost')) </b> </td>
                                    <td class="text-right"> <b> @formatFloat($costing->costingProducts->sum('operation_cost_total')) </b> </td>
                                    <td class="text-right"> <b> </b> </td>
                                    <td class="text-right"> <b> @formatFloat($total = $costing->costingProducts->sum('total')) </b> </td>
                                    <td class="text-right"> <b> @formatFloat($vat = $costing->costingProducts->sum('product_vat_amount')) </b> </td>
                                    <td class="text-right"> <b> @formatFloat($total + $vat)</b> </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($costing->costingProductEquipments()->exists())
                    <div>
                        <div>
                            <table class="productEquipmentTable">
                                <thead>
                                    <tr>
                                        <th colspan="6">Product Related Equipment</th>
                                    </tr>
                                    <tr>
                                        <th>Link Type</th>
                                        <th>Quantity</th>
                                        <th>Unit</th>
                                        <th>Ownership</th>
                                        <th>Rate</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody class="connectivityBody">
                                    @foreach ($costing->costingProductEquipments as $product_equipment)
                                        <tr class="connectivity_details_row">
                                            <td>{{ $product_equipment->material->name ?? '' }}</td>
                                            <td>{{ $product_equipment->quantity }}</td>
                                            <td>{{ $product_equipment->unit }}</td>
                                            <td>{{ $product_equipment->ownership }}</td>
                                            <td>{{ $product_equipment->rate }}</td>
                                            <td>{{ $product_equipment->total }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="5" class="text-right">Equipment Total</td>
                                        <td>{{ $costing->equipment_wise_total }}</td>
                                    </tr>

                                    <tr>
                                        <td colspan="5" class="text-right">Client Equipment Total
                                        </td>
                                        <td> {{ $costing->client_equipment_total }} </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-right">Partial Total</td>
                                        <td> {{ $costing->equipment_partial_total }} </td>
                                    </tr>

                                    <tr>
                                        <td colspan="5" class="text-right">Deployment Cost</td>
                                        <td> {{ $costing->equipment_deployment_cost }} </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-right">Interest</td>
                                        <td>{{ $costing->equipment_interest }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-right">VAT</td>
                                        <td>{{ $costing->equipment_vat }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-right">Tax</td>
                                        <td>{{ $costing->equipment_tax }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-right">Total</td>
                                        <td>{{ $costing->equipment_grand_total }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-right">OTC</td>
                                        <td>{{ $costing->equipment_otc }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-right">ROI</td>
                                        <td>{{ $costing->equipment_roi }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

            </div>
            <div class="text-center">
                <h5 style="margin: 0px; padding:0px; margin-top:10px;"> Link Details </h5>
            </div>
            <hr />
            @foreach ($costing->costingLinks as $costing_link)
                <div style="border: 2px solid gray; border-radius: 15px; padding: 15px; margin-top: 15px;">
                    <div>
                        <table style="width: 100%">
                            <tbody>
                                <tr>
                                    <td>
                                        <span style="font-size: 14px;">Link Type: </span> <span
                                            style="font-size: 14px; font-weight:bold">{{ $costing_link->link_type }}</span>
                                    </td>
                                    <td>
                                        <span style="font-size: 14px;">Option: </span> <span
                                            style="font-size: 14px; font-weight:bold">{{ $costing_link->option }}</span>
                                    </td>
                                    <td>
                                        <span style="font-size: 14px;">Capacity: </span> <span
                                            style="font-size: 14px; font-weight:bold">{{ $costing_link->transmission_capacity }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span style="font-size: 14px;">Quantity: </span> <span
                                            style="font-size: 14px; font-weight:bold">{{ $costing_link->quantity }}</span>
                                    </td>
                                    <td>
                                        <span style="font-size: 14px;">Rate: </span> <span
                                            style="font-size: 14px; font-weight:bold">{{ $costing_link->rate }}</span>
                                    </td>
                                    <td>
                                        <span style="font-size: 14px;">Total: </span> <span
                                            style="font-size: 14px; font-weight:bold">{{ $costing_link->total }}</span>
                                    </td>
                                </tr>
                            </tbody>

                        </table>
                    </div>
                    <hr />
                    <div>
                        <table class="equipementTable">
                            <thead>
                                <tr class="text-center">
                                    <th colspan="6">Equipment</th>
                                </tr>
                                <tr>
                                    <th>Material</th>
                                    <th>Unit</th>
                                    <th>Ownership</th>
                                    <th>Quantity</th>
                                    <th>Rate</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody class="tbody">
                                @foreach ($costing_link->costingLinkEquipments as $link_equipment)
                                    <tr>
                                        <td>
                                            <span>{{ $link_equipment->material->name ?? '' }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $link_equipment->unit ?? '' }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $link_equipment->ownership }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $link_equipment->quantity ?? '' }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $link_equipment->rate ?? '' }}</span>
                                        </td>
                                        <td class="text-right">
                                            <span><b>@formatFloat($link_equipment->total)</b></span>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="5" class="text-right"> <b>Plan Equipment Total</b> </td>
                                    <td class="text-right">
                                        <span><b>{{ $costing_link->plan_all_equipment_total }}</b></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right"> <b>Client Equipment Total</b> </td>
                                    <td class="text-right">
                                        <span><b>{{ $costing_link->plan_client_equipment_total }}</b></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right"> <b>Total</b> </td>
                                    <td class="text-right"><span><b>{{ $costing_link->partial_total }}</b></span>
                                    </td>
                                </tr>
                                <tr class="text-right">
                                    <td colspan="3"><span><b>OTC</b></span></td>
                                    <td class="text-right"><span><b>{{ $costing_link->otc }}</b></span></td>
                                    <td><span><b>Deployment Cost</b></span></td>
                                    <td class="text-right"><span><b>{{ $costing_link->deployment_cost }}</b></span>
                                    </td>
                                </tr>
                                <tr class="text-right">
                                    <td colspan="3"><span><b>ROI</b></span></td>
                                    <td class="text-right"><span><b>{{ $costing_link->roi }}</b></span></td>
                                    <td><span><b>Interest</b></span></td>
                                    <td class="text-right"><span><b>{{ $costing_link->interest }}</b></span></td>
                                </tr>
                                <tr class="text-right">
                                    <td colspan="3"><span><b>Capacity</b></span></td>
                                    <td class="text-right"><span><b>{{ $costing_link->capacity_amount }}</b></span>
                                    </td>
                                    <td><span><b>Total</b></span></td>
                                    <td class="text-right"><span><b>{{ $costing_link->grand_total }}</b></span></td>
                                </tr>
                                <tr class="text-right">
                                    <td colspan="3"><span><b>Operation Cost</b></span></td>
                                    <td class="text-right"><span><b>{{ $costing_link->operation_cost }}</b></span>
                                    </td>
                                    <td><span><b>VAT</b></span></td>
                                    <td class="text-right"><span><b>{{ $costing_link->vat }}</b></span></td>
                                </tr>
                                <tr class="text-right">
                                    <td colspan="3"><span><b>Total MRC</b></span></td>
                                    <td class="text-right"><span><b>{{ $costing_link->total_mrc }}</b></span></td>
                                    <td><span><b>Tax</b></span></td>
                                    <td class="text-right"><span><b>{{ $costing_link->tax }}</b></span></td>
                                </tr>
                                <tr class="text-right">
                                    <td colspan="5"><span><b>Total Inv</b></span></td>
                                    <td class="text-right"><span><b>{{ $costing_link->investment }}</b></span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
            <div style="display: block; margin-top: 20px;">
                <div style="width: 100%">
                    <div style="width: 20%; float: left;">&nbsp;</div>
                    <div style="width: 60%; float: left;">
                        <table class="totalInvestment">
                            <tbody>
                                <tr>
                                    <th colspan="4" style="text-align: center; font-size: 13px; font-weight:bold;">
                                        FR Wise Cost Calculation
                                    </th>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <span>Total Investment</span>
                                    </td>
                                    <td colspan="2">
                                        {{ $costing->total_investment }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <span>Total OTC</span>
                                    </td>
                                    <td colspan="2">
                                        {{ $costing->total_otc }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <span>Total Product Cost</span>
                                    </td>
                                    <td colspan="2">
                                        {{ $costing->total_product_cost }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <span>Total Service Cost</span>
                                    </td>
                                    <td colspan="2">
                                        {{ $costing->total_service_cost }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <span>Total MRC</span>
                                    </td>
                                    <td colspan="2">
                                        {{ $costing->total_mrc }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span>Margin</span>
                                    </td>
                                    <td>
                                        {{ $costing->management_percentage }}
                                    </td>
                                    <td>
                                        {{ $costing->management_cost_amount }}
                                    </td>
                                    <td>
                                        {{ $costing->management_cost_total }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <span>Equipment Price for Client</span>
                                    </td>
                                    <td colspan="2">
                                        {{ $costing->equipment_price_for_client }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <span>Total OTC</span>
                                    </td>
                                    <td colspan="2">
                                        {{ $costing->total_otc_with_client_equipment }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div style="width: 20%; float:right">&nbsp;</div>

                </div>
                <div class="col-3 col-md-3">
                </div>
            </div>
        </div>
    </div>
</body>

</html>
