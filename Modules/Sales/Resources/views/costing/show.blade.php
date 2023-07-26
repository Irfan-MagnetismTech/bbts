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
            <div class="row">
                <div class="col-xl-3 col-md-3">
                    <div class="form-item">
                        <label for="client_id">Client ID<span class="text-danger">*</span></label>
                        <p>{{ $costing->client_no }} </p>
                    </div>
                </div>
                <div class="col-xl-3 col-md-3">
                    <div class="form-item">
                        <label for="client_name">Client Name<span class="text-danger">*</span></label>
                        <p>{{ $costing->lead_generation->client_name ?? '' }}</p>
                    </div>
                </div>
                <div class="col-xl-3 col-md-3">
                    <div>
                        <div class="form-item">
                            <label for="connectivity_point">Connectivity Point</label>
                            <p>{{ $costing->feasibilityRequirementDetail->connectivity_point ?? '' }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-3">
                    <div class="form-item">
                        <label for="month">Month</label>
                        <p>{{ $costing->month }}</p>
                    </div>
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
                                @foreach ($planning->equipmentPlans as $equipment_plan)
                                    <tr class="connectivity_details_row">
                                        <td>{{ $equipment_plan->material->name ?? '' }}</td>
                                        <td>{{ $equipment_plan->quantity }}</td>
                                        <td>{{ $equipment_plan->unit }}</td>
                                        <td>BBTCL</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="5" class="text-right" style="font-size: 14px;">Equipment Total</td>
                                    <td></td>
                                </tr>

                                <tr>
                                    <td colspan="5" class="text-right" style="font-size: 14px;">Client Equipment Total
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right" style="font-size: 14px;">Partial Total</td>
                                    <td></td>
                                </tr>

                                <tr>
                                    <td colspan="5" class="text-right" style="font-size: 14px;">Deployment Cost</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right" style="font-size: 14px;">Interest</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right" style="font-size: 14px;">VAT</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right" style="font-size: 14px;">Tax</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right" style="font-size: 14px;">Total</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right" style="font-size: 14px;">OTC</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right" style="font-size: 14px;">ROI</td>
                                    <td></td>
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
            @foreach ($planning->PlanLinks as $key => $plan_link)
                @php $row_no = $key + 1; @endphp
                <div class="PlanLinkMainRow"
                    style="border: 2px solid gray; border-radius: 15px; padding: 15px; margin-top: 15px;">
                    <div class="row">
                        <div class="col-1 col-md-1">
                            <input type="hidden" name="total_key" value="{{ $row_no }}">
                            <input type="checkbox" disabled>
                        </div>
                        <div class="col-2 col-md-2">
                            <span>{{ $plan_link->link_type }}</span>
                        </div>
                        <div class="col-2 col-md-2">
                            <span>{{ $plan_link->option }}</span>
                        </div>
                        <div class="col-2 col-md-2">
                            <span>{{ $plan_link->existing_transmission_capacity ?? $plan_link->new_transmission_capacity }}</span>
                        </div>
                        <div class="col-2 col-md-2">
                            <span></span>
                        </div>
                        <div class="col-1 col-md-1">
                            <span></span>
                        </div>
                        <div class="col-2 col-md-2">
                            <span></span>
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
                                @foreach ($plan_link->PlanLinkEquipments as $plan_link_equipment)
                                    <tr>
                                        <td>
                                            <span>{{ $plan_link_equipment->material->name ?? '' }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $plan_link_equipment->unit ?? '' }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $plan_link_equipment->ownership }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $plan_link_equipment->quantity ?? '' }}</span>
                                        </td>
                                        <td>
                                            <span></span>
                                        </td>
                                        <td>
                                            <span></span>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="5" class="text-right" style="font-size:14px;">Plan Equipment Total</td>
                                    <td>
                                        <span></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right" style="font-size:14px;">Client Equipment Total
                                    </td>
                                    <td>
                                        <span></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right" style="font-size:14px;">Total</td>
                                    <td>
                                        <span></span>
                                    </td>
                                </tr>
                                <tr class="text-right">
                                    <td colspan="3">
                                        <span style="font-size: 14px;">OTC</span>
                                    </td>
                                    <td>
                                        <span></span>
                                    </td>
                                    <td>
                                        <span style="font-size: 14px;">Deployment Cost</span>
                                    </td>
                                    <td>
                                        <span></span>
                                    </td>
                                </tr>
                                <tr class="text-right">
                                    <td colspan="3">
                                        <span style="font-size: 14px;">ROI</span>
                                    </td>
                                    <td>
                                        <span></span>
                                    </td>
                                    <td>
                                        <span style="font-size: 14px;">Interest</span>
                                    </td>
                                    <td>
                                        <span></span>
                                    </td>
                                </tr>
                                <tr class="text-right">
                                    <td colspan="3">
                                        <span style="font-size: 14px;">Capacity</span>
                                    </td>
                                    <td>
                                        <span></span>
                                    </td>
                                    <td>
                                        <span style="font-size: 14px;">Total</span>
                                    </td>
                                    <td>
                                        <span></span>
                                    </td>
                                </tr>
                                <tr class="text-right">
                                    <td colspan="3">
                                        <span style="font-size: 14px;">Operation Cost</span>
                                    </td>
                                    <td>
                                        <span></span>
                                    </td>
                                    <td>
                                        <span style="font-size: 14px;">VAT</span>
                                    </td>
                                    <td>
                                        <span></span>
                                    </td>
                                </tr>
                                <tr class="text-right">
                                    <td colspan="3">
                                        <span style="font-size: 14px;">Total MRC</span>
                                    </td>
                                    <td>
                                        <span></span>
                                    </td>
                                    <td>
                                        <span style="font-size: 14px;">Tax</span>
                                    </td>
                                    <td>
                                        <span></span>
                                    </td>
                                </tr>
                                <tr class="text-right">
                                    <td colspan="5">
                                        <span style="font-size: 14px;">Total Inv</span>
                                    </td>
                                    <td>
                                        <span></span>
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
                                    <input type="number" name="total_investment" id="total_investment"
                                        class="form-control form-control-sm text-center plan_fr_total_investment input"
                                        placeholder="Total Investment" value="">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <span style="font-size:14px;">Total OTC</span>
                                </td>
                                <td colspan="2">
                                    <input type="number" name="total_otc" id="total_otc"
                                        class="form-control form-control-sm text-center total_otc input"
                                        placeholder="Total OTC" value="">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <span style="font-size:14px;">Total Product Cost</span>
                                </td>
                                <td colspan="2">
                                    <input type="number" name="total_product_cost" id="total_product_cost"
                                        class="form-control form-control-sm text-center total_product_cost input"
                                        placeholder="Total Product Cost" value="">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <span style="font-size:14px;">Total Service Cost</span>
                                </td>
                                <td colspan="2">
                                    <input type="number" name="total_service_cost" id="total_service_cost"
                                        class="form-control form-control-sm text-center total_service_cost input"
                                        placeholder="Total Service Cost" value="">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <span style="font-size:14px;">Total MRC</span>
                                </td>
                                <td colspan="2">
                                    <input type="number" name="total_mrc" id="total_mrc"
                                        class="form-control form-control-sm text-center total_mrc input"
                                        placeholder="Total MRC" value="" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span style="font-size:14px;">Margin</span>
                                </td>
                                <td>
                                    <input type="number" name="management_perchantage" id="management_perchantage"
                                        class="form-control form-control-sm text-center margin input" placeholder="Margin"
                                        value="">
                                </td>
                                <td>
                                    <input type="number" name="management_cost_amount" id="management_cost_amount"
                                        class="form-control form-control-sm text-center management_cost_amount input"
                                        placeholder="Margin Amount" value="" readonly>
                                </td>
                                <td>
                                    <input type="number" name="management_cost_total" id="management_cost_total"
                                        class="form-control form-control-sm text-center management_cost_total input"
                                        placeholder="Margin Amount" value="" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <span style="font-size:14px;">Equipment Price for Client</span>
                                </td>
                                <td colspan="2">
                                    <input type="number" name="equipment_price_for_client"
                                        id="equipment_price_for_client"
                                        class="form-control form-control-sm text-center equipment_price_for_client input"
                                        placeholder="Equipment Price for Client" value="" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <span style="font-size:14px;">Total OTC</span>
                                </td>
                                <td colspan="2">
                                    <input type="number" name="total_otc_with_client_equipment"
                                        id="total_otc_with_client_equipment"
                                        class="form-control form-control-sm text-center total_otc_with_client_equipment input"
                                        placeholder="Total OTC" value="" readonly>
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
