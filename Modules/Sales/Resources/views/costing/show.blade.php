@extends('layouts.backend-layout')
@section('title', 'consting')

@php
    $is_old = old('client_id') ? true : false;
    $form_heading = !empty($costing->id) ? 'Update' : 'Add';
    $form_url = !empty($costing->id) ? route('survey.update', $costing->id) : route('costing.store');
    $form_method = !empty($costing->id) ? 'PUT' : 'POST';
@endphp

@section('breadcrumb-title')
    {{ ucfirst($form_heading) }} Costing Sheet
@endsection
@section('style')
    <style>
        .table th {
            background: #006b8d !important;
        }
    </style>
@endsection

@section('breadcrumb-button')
    <a href="{{ route('costing.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')

    {!! Form::open([
        'url' => $form_url,
        'method' => $form_method,
    ]) !!}

    {{-- Comparative Statement --}}
    <div class="card">
        <div class="tableHeading">
            <h5> <span> &#10070; </span> Costing Sheet <span>&#10070;</span> </h5>
        </div>
        <div class="card-body">
            <!-- Assuming you are inside a form element and $costing is the model instance you are editing -->

            <div class="row mb-2">
                <div class="col-md-3">
                    <span style="font-size: 13px;">Client No: </span><span class="font-weight-bold"
                        style="font-size: 13px;">{{ $costing->client_no ?? '' }}</span>

                </div>
                <div class="col-md-3">
                    <span style="font-size: 13px;">Client Name: </span><span class="font-weight-bold"
                        style="font-size: 13px;">{{ $costing->lead_generation->client_name ?? '' }}</span>
                </div>
                <div class="col-md-4">
                    <span style="font-size: 13px;">Connectivity Point : </span><span class="font-weight-bold"
                        style="font-size: 13px;">{{ $costing->feasibilityRequirementDetail->connectivity_point ?? '' }}</span>
                </div>
                <div class="col-md-2">
                    <span style="font-size: 13px;">Month : </span><span class="font-weight-bold"
                        style="font-size: 13px;">{{ $costing->month ?? '' }}</span>
                </div>
            </div>

            <div class="row">
                <div class="md-col-12 col-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
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
                    <div class="md-col-12 col-12">
                        <div class="table-responsive">
                            <table class="table table-bordered">
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
                                            <td class="text-right">{{ $product_equipment->quantity }}</td>
                                            <td>{{ $product_equipment->unit }}</td>
                                            <td>{{ $product_equipment->ownership }}</td>
                                            <td class="text-right">{{ $product_equipment->rate }}</td>
                                            <td class="text-right">{{ $product_equipment->total }}</td>
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
            <hr />
            <div class="text-center">
                <h5> <span> &#10070; </span> Link Details <span>&#10070;</span> </h5>
            </div>
            <hr />
            @foreach ($costing->costingLinks as $costing_link)
                <div class="PlanLinkMainRow"
                    style="border: 2px solid gray; border-radius: 15px; padding: 15px; margin-top: 15px;">
                    <div class="row">
                        <div class="col-4 col-md-4 mb-2" style="padding-right: 0px;">
                            <span style="font-size: 14px; ">Link Type : </span> <span
                                style="font-size: 14px; font-weight:bold">{{ $costing_link->link_type }}</span>
                        </div>
                        <div class="col-4 col-md-4 mb-2">
                            <span style="font-size: 14px;">Option : </span> <span
                                style="font-size: 14px; font-weight:bold">{{ $costing_link->option }}</span>
                        </div>
                        <div class="col-4 col-md-4 mb-2">
                            <span style="font-size: 14px;">Capacity : </span> <span
                                style="font-size: 14px; font-weight:bold">{{ $costing_link->transmission_capacity }}</span>
                        </div>
                        <div class="col-4 col-md-4 mb-2">
                            <span style="font-size: 14px;">Quantity : </span> <span
                                style="font-size: 14px; font-weight:bold">{{ $costing_link->quantity }}</span>
                        </div>
                        <div class="col-4 col-md-4 mb-2">
                            <span style="font-size: 14px;">Rate : </span> <span
                                style="font-size: 14px; font-weight:bold">{{ $costing_link->rate }}</span>
                        </div>
                        <div class="col-4 col-md-4 mb-2">
                            <span style="font-size: 14px;">Total : </span> <span
                                style="font-size: 14px; font-weight:bold">{{ $costing_link->total }}</span>
                        </div>
                    </div>
                    <hr />
                    <div class="table-responsive">
                        <table class="table table-bordered">
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
                                        <td class="text-right">
                                            <span>{{ $link_equipment->quantity ?? '' }}</span>
                                        </td>
                                        <td class="text-right">
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
                                        <span><b>{{ $costing_link->plan_all_equipment_total }}</b></span></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right"> <b>Client Equipment Total</b> </td>
                                    <td class="text-right">
                                        <span><b>{{ $costing_link->plan_client_equipment_total }}</b></span></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right"> <b>Total</b> </td>
                                    <td class="text-right"><span><b>{{ $costing_link->partial_total }}</b></span> </td>
                                </tr>
                                <tr class="text-right">
                                    <td colspan="3"><span><b>OTC</b></span></td>
                                    <td class="text-right"><span><b>{{ $costing_link->otc }}</b></span></td>
                                    <td><span><b>Deployment Cost</b></span></td>
                                    <td class="text-right"><span><b>{{ $costing_link->deployment_cost }}</b></span></td>
                                </tr>
                                <tr class="text-right">
                                    <td colspan="3"><span><b>ROI</b></span></td>
                                    <td class="text-right"><span><b>{{ $costing_link->roi }}</b></span></td>
                                    <td><span><b>Interest</b></span></td>
                                    <td class="text-right"><span><b>{{ $costing_link->interest }}</b></span></td>
                                </tr>
                                <tr class="text-right">
                                    <td colspan="3"><span><b>Capacity</b></span></td>
                                    <td class="text-right"><span><b>{{ $costing_link->capacity_amount }}</b></span></td>
                                    <td><span><b>Total</b></span></td>
                                    <td class="text-right"><span><b>{{ $costing_link->grand_total }}</b></span></td>
                                </tr>
                                <tr class="text-right">
                                    <td colspan="3"><span><b>Operation Cost</b></span></td>
                                    <td class="text-right"><span><b>{{ $costing_link->operation_cost }}</b></span></td>
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
            <hr />
            <div class="text-center">
                <h5>FR Wise Cost Calculation</h5>
            </div>
            <hr />
            <div class="row p-0 m-0">
                <div class="col-3 col-md-3">
                </div>
                <div class="col-6 col-md-6">
                    <table class="table table-bordered w-full">
                        <tbody>
                            <tr>
                                <td colspan="2">
                                    <span style="font-size:14px;">Total Investment</span>
                                </td>
                                <td colspan="2">
                                    {{ $costing->total_investment }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <span style="font-size:14px;">Total OTC</span>
                                </td>
                                <td colspan="2">
                                    {{ $costing->total_otc }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <span style="font-size:14px;">Total Product Cost</span>
                                </td>
                                <td colspan="2">
                                    {{ $costing->total_product_cost }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <span style="font-size:14px;">Total Service Cost</span>
                                </td>
                                <td colspan="2">
                                    {{ $costing->total_service_cost }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <span style="font-size:14px;">Total MRC</span>
                                </td>
                                <td colspan="2">
                                    {{ $costing->total_mrc }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span style="font-size:14px;">Margin</span>
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
                                    <span style="font-size:14px;">Equipment Price for Client</span>
                                </td>
                                <td colspan="2">
                                    {{ $costing->equipment_price_for_client }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <span style="font-size:14px;">Total OTC</span>
                                </td>
                                <td colspan="2">
                                    {{ $costing->total_otc_with_client_equipment }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-3 col-md-3">
                </div>
            </div>
        </div>
    </div>
    <button class="py-2 btn btn-success ">{{ !empty($costing->id) ? 'Update' : 'Save' }}</button>
    </div>
    {!! Form::close() !!}
@endsection
