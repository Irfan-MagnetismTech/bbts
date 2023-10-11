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
<div>
    &nbsp;
</div>
    <div style="width: 100%;">
        <div style="text-align: center">
            <h2 style="text-align: center; width: 65%; border: 1px solid #000000; border-radius: 5px; margin: 20px auto">
                {{ $feasibility_requirement->lead_generation->client_name }}</h2>
        </div>
        <table id="orderinfo-table">
                <thead>
                <tr class="text-center">
                    <th>Connectivity Point Name</th>
                    <th>Total Inv</th>
                    <th>OTC</th>
                    <th>Client Equipment</th>
                    <th>Total OTC</th>
                    <th>Product Cost</th>
                    <th>Monthly Cost</th>
                    <th>Total Monthly Cost</th>
                    <th>Yearly Cost</th>
                    <th>Monthly Revenue</th>
                    <th>Yearly Revenue</th>
                    <th>Monthly PNL</th>
                    <th>Yearly PNL</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $total_investment = 0;
                $total_budget = 0;
                $total_revenue = 0;
                $total_monthly_pnl = 0;
                $total_pnl = 0;
                $grand_total_monthly_cost = 0;
                $total_yearly_pnl = 0;
                $grand_total_otc = 0;
                $total_product_cost = 0;
                $sum_of_monthly_cost = 0;
                $yearly_revenue = 0;
                ?>
                @foreach ($feasibility_requirement->feasibilityRequirementDetails as $details)
                    @if ($details->costing)
                        @php
                            $month = $details->costing->month;
                            $total_otc = $details->offerDetail->total_offer_otc;
                            $investment = $details->costing->costingLinks->sum('investment');
                            $product_cost = $details->costing->product_total_cost + $details->costing->total_operation_cost;
                            $monthly_cost = ($investment - $total_otc) / $month + $details->costing->costingLinks->sum('capacity_amount') + $details->offerDetail->equipment_total_mrc;
                            $total_monthly_cost = $monthly_cost + $product_cost;
                            $monthly_revenue = $details->offerDetail->grand_total;
                            $total_investment += $investment;
                            $grand_total_otc += $total_otc;
                            $total_product_cost += $product_cost;
                            $sum_of_monthly_cost += $monthly_cost;
                            $total_budget += $total_monthly_cost;
                            $grand_total_monthly_cost += $total_monthly_cost * $month;
                            $total_revenue += $monthly_revenue;
                            $yearly_revenue += $monthly_revenue * $month;
                            $monthly_pnl = $monthly_revenue - $total_monthly_cost;
                            $total_monthly_pnl += $monthly_pnl;
                            $total_yearly_pnl += $monthly_pnl * $month;
                        @endphp
                        <tr>
                            <td class="text-left">{{ $details->connectivity_point }} ({{ $details->fr_no }}) </td>
                            <td class="text-right">@formatFloat($investment + ($details->costing->equipment_grand_total - $details->costing->equipment_price_for_client))</td>
                            <td class="text-right">{{ $total_otc }}</td>
                            <td class="text-right">{{ $details->costing->equipment_price_for_client }}</td>
                            <td class="text-right">
                                {{ $details->costing->equipment_price_for_client + $details->offerDetail->total_offer_otc }}
                            </td>
                            <td class="text-right">@formatFloat($product_cost)</td>
                            <td class="text-right">@formatFloat($monthly_cost)</td>
                            <td class="text-right">@formatFloat($total_monthly_cost)</td>
                            <td class="text-right">@formatFloat($total_monthly_cost * $month)</td>
                            <td class="text-right">@formatFloat($monthly_revenue)</td>
                            <td class="text-right">@formatFloat($monthly_revenue * $month)</td>
                            <td class="text-right">@formatFloat($monthly_pnl)</td>
                            <td class="text-right">@formatFloat($monthly_pnl * $month)</td>
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
                <tfoot>
                <tr style="font-weight: bold!important; background-color: #e3ecf6d8!important; ">
                    <td colspan="" class="text-right"> <b>Total</b> </td>
                    <td class="text-right"><b>@formatFloat($total_investment)</b></td>
                    <td></td>
                    <td></td>
                    <td class="text-right"><b>@formatFloat($grand_total_otc)</b></td>
                    <td class="text-right"><b>@formatFloat($total_product_cost)</b></td>
                    <td class="text-right"><b>@formatFloat($sum_of_monthly_cost)</b></td>
                    <td class="text-right"><b>@formatFloat($total_budget)</b></td>
                    <td class="text-right"><b>@formatFloat($grand_total_monthly_cost)</b></td>
                    <td class="text-right"><b>@formatFloat($total_revenue)</b></td>
                    <td class="text-right"><b>@formatFloat($yearly_revenue)</b></td>
                    <td class="text-right"><b>@formatFloat($total_monthly_pnl)</b></td>
                    <td class="text-right"><b>@formatFloat($total_yearly_pnl)</b></td>
                </tr>
                </tfoot>
        </table>
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
