@extends('layouts.backend-layout')
@section('title', 'PNL Details')



@section('breadcrumb-title')
    PNL Details
@endsection

@section('content-grid', null)

@section('content')
    <div>
        @foreach ($feasibility_requirement->feasibilityRequirementDetails as $details)
            @if ($details->costing && $details->costing->saleDetail)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th colspan="9" class="text-center">{{ $details->connectivity_point . '-' . $details->fr_no }}
                            </th>
                        </tr>
                        <tr class="text-center">
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Unit</th>
                            <th>Rate</th>
                            <th>Amount</th>
                            <th>Operation Cost</th>
                            <th>Total Amount</th>
                            <th>Price</th>
                            <th>Total Price</th>
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
                                <td>{{ $product->sub_total }}</td>
                                <td>{{ $product->operation_cost }}</td>
                                <td>{{ $product->operation_cost_total }}</td>
                                <td>{{ number_format($product?->sale_product?->price, 2) ?? '' }}</td>
                                <td>{{ number_format($product?->sale_product?->total_price, 2) ?? '' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="text-center">
                            <td colspan="4">Total</td>
                            <td>{{ number_format($details->costing->costingProducts->sum('sub_total'), 2) }}</td>
                            <td>{{ number_format($details->costing->costingProducts->sum('operation_cost'), 2) }}</td>
                            <td>{{ number_format($details->costing->costingProducts->sum('operation_cost_total'), 2) }}
                            </td>
                            <td>{{ number_format($product_sale_total, 2) }}</td>
                            <td>{{ number_format($product_grand_total, 2) }}</td>

                        </tr>
                    </tfoot>
                </table>
                <div style="margin-top: 25px;">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>Particulars</th>
                                <th>Equipment Cost</th>
                                <th>Deployment Cost</th>
                                <th>Interest</th>
                                <th>VAT</th>
                                <th>Tax</th>
                                <th>Total Inv</th>
                                <th>OTC</th>
                                <th>ROI</th>
                                <th>Capacity</th>
                                <th>Capacity</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @dd($details->costing->total_investment, $details->costing->saleDetail->otc); --}}
                            @php $product_roi = ($details->costing->total_investment - $details->costing->saleDetail->otc) / 12 ;  @endphp
                            <tr>
                                <td>Product Equipment</td>
                                <td>{{ $details->costing->equipment_partial_total }}</td>
                                <td>{{ $details->costing->equipment_deployment_cost }}</td>
                                <td>{{ $details->costing->equipment_interest }}</td>
                                <td>{{ $details->costing->equipment_vat }}</td>
                                <td>{{ $details->costing->equipment_tax }}</td>
                                <td>{{ $details->costing->total_investment }}</td>
                                <td>{{ $details->costing->saleDetail->otc }}</td>
                                <td>{{ $product_roi }}</td>
                                <td>10000</td>
                                <td>10000</td>
                            </tr>
                            @php $link_roi = 0; @endphp
                            @foreach ($details->costing->costingLinks as $link)
                                @php @$link_roi += ($link->investment - $link->offerLink->otc) / 12 ;  @endphp
                                <tr>
                                    <td>{{ $link->link_type }}</td>
                                    <td>{{ $link->partial_total }}</td>
                                    <td>{{ $link->interest }}</td>
                                    <td>{{ $link->vat }}</td>
                                    <td>{{ $link->tax }}</td>
                                    <td>{{ $link->investment }}</td>
                                    <td>{{ $link->offerLink->otc }}</td>
                                    <td>{{ ($link->investment - $link->offerLink->otc) / 12 }}</td>
                                    <td>10000</td>
                                    <td>10000</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="6" class="text-right">Total</td>
                                <td>{{ $details->costing->costingLinks->sum('investment') }}</td>
                                <td>{{ $details->costing->costingLinks->sum('otc') }}</td>
                                <td>{{ $link_roi }}</td>
                                <td>10000</td>
                                <td>10000</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="text-right">Revenue Per Month</td>
                                <td>{{ number_format($product_grand_total, 2) }}</td>
                                <td colspan="4">Investment Budget Per Month</td>
                                <td>{{ $details->costing->total_mrc }}</td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-right">12 months total Revenue Budget</td>
                                <td>{{ number_format($product_grand_total * $details->costing->month, 2) }}
                                </td>
                                <td colspan="4">12 months total Investment Budget</td>
                                <td>{{ number_format($details->costing->total_mrc * $details->costing->month, 2) }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="10" class="text-right">Total PNL</td>
                                <td>{{ $details->costing->total_mrc * $details->costing->month - $product_grand_total * $details->costing->month }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="10" class="text-right">Per Month PNL</td>
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

