@extends('layouts.backend-layout')
@section('title', 'PNL Details')

@section('breadcrumb-title')
    <div class="row mb-1">
        <div class="col-10 text-left">
            <h4>PNL Details</h4>
        </div>
        <div class="col-2 text-right">
            <a class="btn btn-outline-success" style="transition: 0.5s"
                href="{{ route('generate_pnl_details_pdf', $connectivity_requirement_id) }}">Generate Pdf</a>
        </div>
    </div>
@endsection

@section('style')
    <style>
        td {
            border: 1px solid rgb(183, 186, 187) !important;
        }
    </style>
@endsection

@section('content-grid', null)

@section('content')
    <div class="table-responsive">
        @if ($connectivity_requirement->costing && $connectivity_requirement->costingByConnectivity->saleDetail)
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="9" class="text-center" style="background-color: #024FA7">
                            {{ $connectivity_requirement->FeasibilityRequirementDetail->connectivity_point . '-' . $connectivity_requirement->fr_no }}
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
                    @foreach ($connectivity_requirement->costingByConnectivity->costingProducts as $product)
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
                            <td class="text-right">@formatFloat($product?->sale_product?->price ?? 0)</td>
                            <td class="text-right">@formatFloat($product?->sale_product?->total_price ?? '')</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="text-right" style="font-weight: bold!important; background-color: #e3ecf6d8!important; ">
                        <td colspan="4">Total</td>
                        <td style="border:1px solid black">
                            {{ number_format($connectivity_requirement->costingByConnectivity->costingProducts->sum('sub_total'), 2) }}
                        </td>
                        <td>{{ number_format($connectivity_requirement->costingByConnectivity->costingProducts->sum('operation_cost'), 2) }}
                        </td>
                        <td>{{ number_format($connectivity_requirement->costingByConnectivity->costingProducts->sum('operation_cost_total'), 2) }}
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
                        {{-- @dd( $connectivity_requirement->offer) --}}
                        <?php $equipment_roi = 0; ?>
                        @if ($connectivity_requirement->costingByConnectivity->costingProductEquipments()->exists())
                            <?php
                            $equipment_investment = $connectivity_requirement->costingByConnectivity->equipment_grand_total - $connectivity_requirement->costingByConnectivity->equipment_price_for_client;
                            $equipment_roi = ($equipment_investment - $connectivity_requirement->offerByConnectivity->offerDetails->first()->equipment_offer_price) / 12;
                            ?>
                            <tr>
                                <td>Product Equipment</td>
                                <td class="text-right">@formatInt($connectivity_requirement->costingByConnectivity->equipment_partial_total)</td>
                                <td class="text-right">@formatInt($connectivity_requirement->costingByConnectivity->equipment_deployment_cost)</td>
                                <td>{{ $connectivity_requirement->costingByConnectivity->equipment_interest }}</td>
                                <td>{{ $connectivity_requirement->costingByConnectivity->equipment_vat }}</td>
                                <td>{{ $connectivity_requirement->costingByConnectivity->equipment_tax }}</td>
                                <td class="text-right">@formatFloat($equipment_investment)</td>
                                <td class="text-right">
                                    {{ $connectivity_requirement->offerByConnectivity->offerDetails->first()->product_equipment_price }}
                                </td>
                                <td class="text-right">{{ $equipment_roi }}</td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endif

                        @php $total_link_roi = 0; @endphp
                        @foreach ($connectivity_requirement->costingByConnectivity->costingLinks as $link)
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
                        $capacity_amount = $connectivity_requirement->costingByConnectivity->costingLinks->sum('capacity_amount');
                        $monthly_cost = $total_roi + $capacity_amount + $connectivity_requirement->costingByConnectivity->costingProducts->sum('operation_cost_total');
                        ?>
                        <tr style="font-weight: bold!important; background-color: #e3ecf6d8!important; ">
                            <td class="text-right">Total</td>
                            <td class="text-right">@formatInt($connectivity_requirement->costingByConnectivity->costingLinks->sum('partial_total') + $connectivity_requirement->costingByConnectivity->equipment_partial_total)</td>
                            <td class="text-right">@formatInt($connectivity_requirement->costingByConnectivity->equipment_deployment_cost + $connectivity_requirement->costingByConnectivity->costingLinks->sum('deployment_cost'))</td>
                            <td>@formatFloat($connectivity_requirement->costingByConnectivity->costingLinks->sum('interest') + $connectivity_requirement->costingByConnectivity->equipment_interest)</td>
                            <td>@formatFloat($connectivity_requirement->costingByConnectivity->costingLinks->sum('vat') + $connectivity_requirement->costingByConnectivity->equipment_vat)</td>
                            <td>@formatFloat($connectivity_requirement->costingByConnectivity->costingLinks->sum('tax') + $connectivity_requirement->costingByConnectivity->equipment_tax)</td>
                            <td class="text-right">@formatFloat($connectivity_requirement->costingByConnectivity->costingLinks->sum('investment') + $connectivity_requirement->costingByConnectivity->equipment_partial_total)</td>
                            <td class="text-right">@formatFloat($connectivity_requirement->offerDetail->total_offer_otc)</td>
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
                            <td class="text-right">@formatFloat($product_grand_total * $connectivity_requirement->costingByConnectivity->month)</td>
                            <td colspan="2" class="text-right">12 Months Total Investment Budget</td>
                            <td class="text-right">@formatFloat($monthly_cost * $connectivity_requirement->costingByConnectivity->month)</td>
                        </tr>
                        <tr style="font-weight: bold!important; background-color: #e3ecf6d8!important; ">
                            <td colspan="4" rowspan="2"></td>
                            <td colspan="2" class="text-right">Per Month PNL</td>
                            <td class="text-right">@formatFloat($product_grand_total - $monthly_cost)</td>
                        </tr>
                        <tr style="font-weight: bold!important; background-color: #e3ecf6d8!important; ">
                            <td colspan="2" class="text-right">Total PNL</td>
                            <td class="text-right">@formatFloat(($product_grand_total - $monthly_cost) * $connectivity_requirement->costingByConnectivity->month)</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @endif
    </div>
@endsection
