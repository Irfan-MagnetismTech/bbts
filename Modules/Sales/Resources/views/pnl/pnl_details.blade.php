@extends('layouts.backend-layout')
@section('title', 'PNL Details')

@section('breadcrumb-title')
    PNL Details
@endsection

@section('style')
    <style>
        td {
            border: 1px solid rgb(183, 186, 187) !important;
        }

        /* th{
                                                border: 1px solid black!important;
                                            } */
    </style>
@endsection

@section('content-grid', null)

@section('content')
    <div>
        @foreach ($feasibility_requirement->feasibilityRequirementDetails as $details)
            @if ($details->costing && $details->costing->saleDetail)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th colspan="9" class="text-center" style="background-color: #024FA7">
                                {{ $details->connectivity_point . '-' . $details->fr_no }}
                            </th>
                        </tr>
                        <tr class="text-center">
                            <th style="background-color:#057097">Product</th>
                            <th style="background-color:#057097">Quantity</th>
                            <th style="background-color:#057097">Unit</th>
                            <th style="background-color:#057097">Rate</th>
                            <th style="background-color:#057097">Amount</th>
                            <th style="background-color:#057097">Operation Cost</th>
                            <th style="background-color:#057097">Total Amount</th>
                            <th style="background-color:#057097">Price</th>
                            <th style="background-color:#057097">Total Price</th>
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
                                <td class="text-right">@formatFloat($product?->sale_product?->price ?? '')</td>
                                <td class="text-right">@formatFloat($product?->sale_product?->total_price ?? '')</td>
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
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th style="background-color:#057097">Particulars</th>
                                <th style="background-color:#057097">Equipment Cost</th>
                                <th style="background-color:#057097">Deployment Cost</th>
                                <th style="background-color:#057097">Interest</th>
                                <th style="background-color:#057097">VAT</th>
                                <th style="background-color:#057097">Tax</th>
                                <th style="background-color:#057097">Total Inv</th>
                                <th style="background-color:#057097">OTC</th>
                                <th style="background-color:#057097">ROI</th>
                                <th style="background-color:#057097">Transmission Capacity</th>
                                <th style="background-color:#057097">Transmission Cost </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($details->costing->costingProductEquipments()->exists())
                                <?php
                                $equipment_investment = $details->costing->equipment_grand_total - $details->costing->equipment_price_for_client;
                                $equipment_roi = ($equipment_investment - $details->offerDetail->equipment_otc) / 12;
                                ?>
                                <tr>
                                    <td>Product Equipment</td>
                                    <td>{{ $details->costing->equipment_partial_total }}</td>
                                    <td>{{ $details->costing->equipment_deployment_cost }}</td>
                                    <td>{{ $details->costing->equipment_interest }}</td>
                                    <td>{{ $details->costing->equipment_vat }}</td>
                                    <td>{{ $details->costing->equipment_tax }}</td>
                                    <td>{{ $equipment_investment }}</td>
                                    <td>{{ $details->offerDetail->equipment_otc }}</td>
                                    <td>{{ $equipment_roi }}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endif

                            @php $total_link_roi = 0; @endphp
                            @foreach ($details->costing->costingLinks as $link)
                                @php
                                    $link_roi = ($link->investment - $link->offerLink->offer_otc) / 12;
                                    $total_link_roi += $link_roi;
                                @endphp
                                <tr>
                                    <td>{{ $link->link_type }}</td>
                                    <td>{{ $link->partial_total }}</td>
                                    <td>{{ $link->deployment_cost }}</td>
                                    <td>{{ $link->interest }}</td>
                                    <td>{{ $link->vat }}</td>
                                    <td>{{ $link->tax }}</td>
                                    <td class="text-right">{{ $link->investment }}</td>
                                    <td class="text-right">@formatFloat($link->offerLink->offer_otc)</td>
                                    <td class="text-right">@formatFloat($link_roi)</td>
                                    <td class="text-right">{{ $link->transmission_capacity }} X
                                        {{ $link->rate }}</td>
                                    <td class="text-right">@formatFloat($link->capacity_amount)</td>
                                </tr>
                            @endforeach
                            <tr style="font-weight: bold!important; background-color: #e3ecf6d8!important; ">
                                <td colspan="" class="text-right">Total</td>
                                <td colspan="" class="text-right">Total</td>
                                <td colspan="" class="text-right">Total</td>
                                <td colspan="" class="text-right">Total</td>
                                <td colspan="" class="text-right">Total</td>
                                <td colspan="" class="text-right">Total</td>
                                <td>{{ $details->costing->costingLinks->sum('investment') }}</td>
                                <td>{{ $details->costing->costingLinks->sum('otc') }}</td>
                                <td>@formatFloat($total_link_roi)</td>
                                <td>10000</td>
                                <td>10000</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr style="font-weight: bold!important; background-color: #e3ecf6d8!important; ">
                                <td colspan="3" rowspan="2"></td>
                                <td colspan="3" class="text-right">Revenue Per Month</td>
                                <td>{{ number_format($product_grand_total, 2) }}</td>
                                <td colspan="3">Investment Budget Per Month</td>
                                <td>{{ $details->costing->total_mrc }}</td>
                            </tr>
                            <tr style="font-weight: bold!important; background-color: #e3ecf6d8!important; ">
                                <td colspan="3" class="text-right">12 months total Revenue Budget</td>
                                <td>{{ number_format($product_grand_total * $details->costing->month, 2) }}
                                </td>
                                <td colspan="3">12 months total Investment Budget</td>
                                <td>{{ number_format($details->costing->total_mrc * $details->costing->month, 2) }}
                                </td>
                            </tr>
                            <tr style="font-weight: bold!important; background-color: #e3ecf6d8!important; ">
                                <td colspan="8" rowspan="2"></td>
                                <td colspan="2" class="text-right">Total PNL</td>
                                <td>{{ $details->costing->total_mrc * $details->costing->month - $product_grand_total * $details->costing->month }}
                                </td>
                            </tr>
                            <tr style="font-weight: bold!important; background-color: #e3ecf6d8!important; ">
                                <td colspan="2" class="text-right">Per Month PNL</td>
                                <td>{{ ($details->costing->total_mrc * $details->costing->month - $product_grand_total * $details->costing->month) / 12 }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @endif
        @endforeach
    </div>
@endsection
