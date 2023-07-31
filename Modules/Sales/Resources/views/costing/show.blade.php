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

            <div class="row">
                <div class="col-md-2">
                    <label for="client_no" style="font-size: 13px">Client No:</label>
                    <input type="text" id="client_no" name="client_no" class="form-control"
                        value="{{ $costing->client_no ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label for="client_name" style="font-size: 13px">Client Name:</label>
                    <input type="text" id="client_name" name="client_name" class="form-control"
                        value="{{ $costing->lead_generation->client_name ?? '' }}">
                </div>
                <div class="col-md-5">
                    <label for="connectivity_point" style="font-size: 13px">Connectivity Point:</label>
                    <input type="text" id="connectivity_point" name="connectivity_point" class="form-control"
                        value="{{ $costing->feasibilityRequirementDetail->connectivity_point ?? '' }}">
                </div>
                <div class="col-md-2">
                    <label for="month" style="font-size: 13px">Month:</label>
                    <input type="text" id="month" name="month" class="form-control"
                        value="{{ $costing->month ?? '' }}">
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
                                    <th>Rate</th>
                                    <th>Unit</th>
                                    <th>Amount</th>
                                    <th>Vat(%)</th>
                                    <th>Vat Amount</th>
                                    <th>Operation Cost</th>
                                    <th>Total Amount</th>
                                    <th>Price</th>
                                    <th>Total Price</th>
                                </tr>
                            </thead>
                            <tbody class="productBody">
                                @foreach ($costing->costingProducts as $costing_product)
                                    <tr class="product_details_row">
                                        <td>{{ $costing_product->product->name }}</td>
                                        <td>{{ $costing_product->quantity }}</td>
                                        <td>{{ $costing_product->rate }}</td>
                                        <td>{{ $costing_product->unit }}</td>
                                        <td>{{ $costing_product->sub_total }}</td>
                                        <td>{{ $costing_product->product_vat }}</td>
                                        <td>{{ $costing_product->product_vat_amount }}</td>
                                        <td>{{ $costing_product->operation_cost }}</td>
                                        <td>{{ $costing_product->operation_cost_total }}</td>
                                        <td>{{ $costing_product->offer_price }}</td>
                                        <td>{{ $costing_product->total }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="4" class="text-right">Total</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="md-col-12 col-12">
                    {{-- Connectivity Details --}}
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
                                        <td>{{ $product_equipment->quantity }}</td>
                                        <td>{{ $product_equipment->unit }}</td>
                                        <td>{{ $product_equipment->ownership }}</td>
                                        <td>{{ $product_equipment->rate }}</td>
                                        <td>{{ $product_equipment->total }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="5" class="text-right" style="font-size: 14px;">Equipment Total</td>
                                    <td>{{ $costing->equipment_wise_total }}</td>
                                </tr>

                                <tr>
                                    <td colspan="5" class="text-right" style="font-size: 14px;">Client Equipment Total
                                    </td>
                                    <td> {{ $costing->client_equipment_total }} </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right" style="font-size: 14px;">Partial Total</td>
                                    <td> {{ $costing->equipment_partial_total }} </td>
                                </tr>

                                <tr>
                                    <td colspan="5" class="text-right" style="font-size: 14px;">Deployment Cost</td>
                                    <td> {{ $costing->equipment_deployment_cost }} </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right" style="font-size: 14px;">Interest</td>
                                    <td>{{ $costing->equipment_interest }}</td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right" style="font-size: 14px;">VAT</td>
                                    <td>{{ $costing->equipment_vat }}</td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right" style="font-size: 14px;">Tax</td>
                                    <td>{{ $costing->equipment_tax }}</td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right" style="font-size: 14px;">Total</td>
                                    <td>{{ $costing->equipment_grand_total }}</td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right" style="font-size: 14px;">OTC</td>
                                    <td>{{ $costing->equipment_otc }}</td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right" style="font-size: 14px;">ROI</td>
                                    <td>{{ $costing->equipment_roi }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
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
                        <div class="col-2 col-md-2">
                            <span>{{ $costing_link->link_type }}</span>
                        </div>
                        <div class="col-2 col-md-2">
                            <span>{{ $costing_link->option }}</span>
                        </div>
                        <div class="col-2 col-md-2">
                            <span>{{ $costing_link->transmission_capacity }}</span>
                        </div>
                        <div class="col-2 col-md-2">
                            <span>{{ $costing_link->quantity }}</span>
                        </div>
                        <div class="col-1 col-md-1">
                            <span>{{ $costing_link->rate }}</span>
                        </div>
                        <div class="col-2 col-md-2">
                            <span>{{ $costing_link->total }}</span>
                        </div>
                    </div>
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
                                        <td>
                                            <span>{{ $link_equipment->quantity ?? '' }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $link_equipment->rate ?? '' }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $link_equipment->total ?? '' }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="5" class="text-right" style="font-size:14px;">Plan Equipment Total
                                    </td>
                                    <td>
                                        <span>{{ $costing_link->plan_all_equipment_total }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right" style="font-size:14px;">Client Equipment Total
                                    </td>
                                    <td>
                                        <span>{{ $costing->plan_client_equipment_total }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right" style="font-size:14px;">Total</td>
                                    <td>
                                        <span>{{ $costing->plan_equipment_partial_total }}</span>
                                    </td>
                                </tr>
                                <tr class="text-right">
                                    <td colspan="3">
                                        <span style="font-size: 14px;">OTC</span>
                                    </td>
                                    <td>
                                        <span>{{ $costing->plan_equipment_otc }}</span>
                                    </td>
                                    <td>
                                        <span style="font-size: 14px;">Deployment Cost</span>
                                    </td>
                                    <td>
                                        <span>{{ $costing->plan_equipment_deployment_cost }}</span>
                                    </td>
                                </tr>
                                <tr class="text-right">
                                    <td colspan="3">
                                        <span style="font-size: 14px;">ROI</span>
                                    </td>
                                    <td>
                                        <span>{{ $costing->plan_equipment_roi }}</span>
                                    </td>
                                    <td>
                                        <span style="font-size: 14px;">Interest</span>
                                    </td>
                                    <td>
                                        <span>{{ $costing->plan_equipment_interest }}</span>
                                    </td>
                                </tr>
                                <tr class="text-right">
                                    <td colspan="3">
                                        <span style="font-size: 14px;">Capacity</span>
                                    </td>
                                    <td>
                                        <span>{{ $costing->plan_equipment_capacity }}</span>
                                    </td>
                                    <td>
                                        <span style="font-size: 14px;">Total</span>
                                    </td>
                                    <td>
                                        <span>{{ $costing->plan_equipment_grand_total }}</span>
                                    </td>
                                </tr>
                                <tr class="text-right">
                                    <td colspan="3">
                                        <span style="font-size: 14px;">Operation Cost</span>
                                    </td>
                                    <td>
                                        <span>{{ $costing->plan_equipment_operation_cost }}</span>
                                    </td>
                                    <td>
                                        <span style="font-size: 14px;">VAT</span>
                                    </td>
                                    <td>
                                        <span>{{ $costing->plan_equipment_vat }}</span>
                                    </td>
                                </tr>
                                <tr class="text-right">
                                    <td colspan="3">
                                        <span style="font-size: 14px;">Total MRC</span>
                                    </td>
                                    <td>
                                        <span>{{ $costing->plan_equipment_total_mrc }}</span>
                                    </td>
                                    <td>
                                        <span style="font-size: 14px;">Tax</span>
                                    </td>
                                    <td>
                                        <span>{{ $costing->plan_equipment_tax }}</span>
                                    </td>
                                </tr>
                                <tr class="text-right">
                                    <td colspan="5">
                                        <span style="font-size: 14px;">Total Inv</span>
                                    </td>
                                    <td>
                                        <span>{{ $costing->plan_equipment_total_inv }}</span>
                                    </td>
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
