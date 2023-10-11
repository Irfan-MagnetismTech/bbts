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

<html-separator />

<div style="width: 100%;">
    <div style="text-align: center; width: 100%" >
        <div class="table-responsive" style="width: 100%">
            @foreach ($feasibility_requirement->feasibilityRequirementDetails  as $index => $details)
                @if ($details->costing && $details->costing->saleDetail)
                    <div>
                        <div>
                            &nbsp;
                        </div>
                        <table class="table table-bordered" style="width: 100%">
                            <thead>
                            <tr>
                                <th colspan="9" class="text-center" style="background-color: #024FA7; color: white">
                                    {{ $details->connectivity_point . '-' . $details->fr_no }}
                                </th>
                            </tr>
                            <tr class="text-center">
                                <th style="background-color:#057097; color: white">Product</th>
                                <th style="background-color:#057097; color: white">Quantity</th>
                                <th style="background-color:#057097; color: white">Unit</th>
                                <th style="background-color:#057097; color: white">Rate</th>
                                <th style="background-color:#057097; color: white">Amount</th>
                                <th style="background-color:#057097; color: white">Operation Cost</th>
                                <th style="background-color:#057097; color: white">Total Amount</th>
                                <th style="background-color:#057097; color: white">Price</th>
                                <th style="background-color:#057097; color: white">Total Price</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $product_sale_total = 0;
                                $product_grand_total = 0;
                            @endphp
                            @foreach ($details->costing->costingProducts as $product)
                                @php
                                    $product_sale_total += $product->sale_product?->price ?? 0;
                                    $product_grand_total += $product->sale_product?->total_price ?? 0;
                                @endphp
                                <tr class="text-center">
                                    <td>{{ $product->product->name }}</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>{{ $product->unit }}</td>
                                    <td>{{ $product->rate }}</td>
                                    <td class="text-right">@formatFloat($product->sub_total)</td>
                                    <td class="text-right">@formatFloat($product->operation_cost)</td>
                                    <td class="text-right">@formatFloat($product->operation_cost_total)</td>
                                    {{-- <td class="text-right">@formatFloat($product?->sale_product?->price ?? 0)</td> --}}
                                    {{-- <td class="text-right">@formatFloat($product?->sale_product?->total_price ?? '')</td> --}}
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr class="text-right" style="font-weight: bold!important; background-color: #e3ecf6d8!important; ">
                                <td colspan="4">Total</td>
                                <td style="border:1px solid black">
                                    {{ number_format($details->costing->costingProducts->sum('sub_total'), 2) }}</td>
                                <td>{{ number_format($details->costing->costingProducts->sum('operation_cost'), 2) }}</td>
                                <td>{{ number_format($details->costing->costingProducts->sum('operation_cost_total'), 2) }}
                                </td>
                                <td></td>
                                <td>{{ number_format($product_grand_total, 2) }}</td>

                            </tr>
                            </tfoot>
                        </table>
                        <div style="margin-top: 25px;">
                            <table class="table table-bordered" style="width: 100%">
                                <thead>
                                <tr class="text-center">
                                    <th style="background-color:#057097; color: white">Particulars</th>
                                    <th style="background-color:#057097; color: white">Equipment Cost</th>
                                    <th style="background-color:#057097; color: white">Deployment Cost</th>
                                    <th style="background-color:#057097; color: white">Interest</th>
                                    <th style="background-color:#057097; color: white">VAT</th>
                                    <th style="background-color:#057097; color: white">Tax</th>
                                    <th style="background-color:#057097; color: white">Total Inv</th>
                                    <th style="background-color:#057097; color: white">OTC</th>
                                    <th style="background-color:#057097; color: white">ROI</th>
                                    <th style="background-color:#057097; color: white">Transmission Capacity</th>
                                    <th style="background-color:#057097; color: white">Transmission Cost </th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $equipment_roi =0; ?>
                                @if ($details->costing->costingProductEquipments()->exists())
                                    <?php
                                    $equipment_investment = $details->costing->equipment_grand_total - $details->costing->equipment_price_for_client;
                                    $equipment_roi = ($equipment_investment - $details->offerDetail->equipment_offer_price) / 12;
                                    ?>
                                    <tr>
                                        <td>Product Equipment</td>
                                        <td class="text-right">@formatInt($details->costing->equipment_partial_total)</td>
                                        <td class="text-right">@formatInt($details->costing->equipment_deployment_cost)</td>
                                        <td>{{ $details->costing->equipment_interest }}</td>
                                        <td>{{ $details->costing->equipment_vat }}</td>
                                        <td>{{ $details->costing->equipment_tax }}</td>
                                        <td class="text-right">@formatFloat($equipment_investment)</td>
                                        <td class="text-right">{{ $details->offerDetail->product_equipment_price }}</td>
                                        <td class="text-right">{{ $equipment_roi }}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @endif

                                @php $total_link_roi = 0; @endphp
                                @foreach ($details->costing->costingLinks as $link)
                                    <?php
                                    $link_roi = ($link->investment - $link->offerLink?->offer_otc) / 12;
                                    $total_link_roi += $link_roi;
                                    ?>

                                    <tr>
                                        <td>{{ $link->link_type }}</td>
                                        <td class="text-right">@formatInt($link->partial_total)</td>
                                        <td class="text-right">@formatFloat($link->deployment_cost)</td>
                                        <td>{{ $link->interest }}</td>
                                        <td>{{ $link->vat }}</td>
                                        <td>{{ $link->tax }}</td>
                                        <td class="text-right">@formatFloat($link->investment)</td>
                                        <td class="text-right">@formatFloat($link->offerLink?->offer_otc)</td>
                                        <td class="text-right">@formatFloat($link_roi)</td>
                                        <td class="text-right">{{ $link->transmission_capacity }} X
                                            {{ $link->rate }}</td>
                                        <td class="text-right">@formatFloat($link->capacity_amount)</td>
                                    </tr>
                                @endforeach
                                <?php
                                $total_roi = $total_link_roi + $equipment_roi;
                                $capacity_amount = $details->costing->costingLinks->sum('capacity_amount');
                                $monthly_cost = $total_roi + $capacity_amount + $details->costing->costingProducts->sum('operation_cost_total');
                                ?>
                                <tr style="font-weight: bold!important; background-color: #e3ecf6d8!important; ">
                                    <td class="text-right">Total</td>
                                    <td class="text-right">@formatInt($details->costing->costingLinks->sum('partial_total') + $details->costing->equipment_partial_total)</td>
                                    <td class="text-right">@formatInt($details->costing->equipment_deployment_cost + $details->costing->costingLinks->sum('deployment_cost'))</td>
                                    <td >@formatFloat($details->costing->costingLinks->sum('interest') + $details->costing->equipment_interest)</td>
                                    <td >@formatFloat($details->costing->costingLinks->sum('vat') + $details->costing->equipment_vat)</td>
                                    <td >@formatFloat($details->costing->costingLinks->sum('tax') + $details->costing->equipment_tax)</td>
                                    <td class="text-right">@formatFloat($details->costing->costingLinks->sum('investment') + $details->costing->equipment_partial_total)</td>
                                    <td class="text-right">@formatFloat( $details->offerDetail->total_offer_otc)</td>
                                    <td class="text-right">@formatFloat($total_roi)</td>
                                    <td></td>
                                    <td class="text-right">@formatFloat($capacity_amount)</td>
                                </tr>
                                </tbody>
                                <tfoot>
                                <tr style="font-weight: bold!important; background-color: #e3ecf6d8!important; ">
                                    <td colspan="4" rowspan="4"></td>
                                    <td colspan="3" class="text-right">Revenue Per Month</td>
                                    <td class="text-right">@formatFloat($product_grand_total)</td>
                                    <td colspan="2" class="text-right">Investment Budget Per Month</td>
                                    <td class="text-right">@formatFloat($monthly_cost)</td>
                                </tr>
                                <tr style="font-weight: bold!important; background-color: #e3ecf6d8!important; ">
                                    <td colspan="3" class="text-right">12 Months Total Revenue Budget</td>
                                    <td class="text-right">@formatFloat($product_grand_total * $details->costing->month)</td>
                                    <td colspan="2" class="text-right">12 Months Total Investment Budget</td>
                                    <td class="text-right">@formatFloat($monthly_cost * $details->costing->month)</td>
                                </tr>
                                <tr style="font-weight: bold!important; background-color: #e3ecf6d8!important; ">
                                    <td colspan="4" rowspan="2"></td>
                                    <td colspan="2" class="text-right">Per Month PNL</td>
                                    <td class="text-right">@formatFloat($product_grand_total - $monthly_cost)</td>
                                </tr>
                                <tr style="font-weight: bold!important; background-color: #e3ecf6d8!important; ">
                                    <td colspan="2" class="text-right">Total PNL sdfsdfs</td>
                                    <td class="text-right">@formatFloat(($product_grand_total - $monthly_cost) * $details->costing->month)</td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                @endif
                    @if ($index < count($feasibility_requirement->feasibilityRequirementDetails) - 3)
                        <div style="page-break-after: always;"></div>
                    @endif
            @endforeach
        </div>
    </div>
</div>

<htmlpagefooter name="page-footer">
    <div class=" text-xs justify-between">
        <div>
            <div style="width:33%; float:left; margin-left: 5px;">
                <div>
                    <div class="text-center"> </div>
                    <hr class="w-32 border-gray-700" />
                    <div class="text-center">Finance Approved</div>
                </div>
            </div>
            <div style="width:33%; float:left; margin-left: 5px;">
                <div>

                    <hr class="w-32 border-gray-700" />
                    <div class="text-center">CMO Approved</div>
                </div>
            </div>
            <div style="width:33%; float:left; margin-left: 5px;">
                <div>

                    <hr class="w-32 border-gray-700" />
                    <div class="text-center">Management Approved </div>
                </div>
            </div>
             

        </div>
        <div>
            &nbsp;
        </div>
    </div>
</htmlpagefooter>
</body>
</html>
