@extends('layouts.backend-layout')
@section('title', 'Client Offer')





@section('content-grid', null)

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title text-center">Client Offer</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-xl-3 col-md-3">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="client_id">Client Name<span class="text-danger">*</span></label>
                        <span class="form-control">{{ $sale->client->name }}</span>
                    </div>
                </div>
                <div class="col-xl-3 col-md-3">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="client_id">Client Name<span
                                class="text-danger">*</span></label>
                        <span class="form-control">{{ $sale->client_no }}</span>
                    </div>
                </div>
                <div class="col-xl-3 col-md-3">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="client_id">Client Name<span
                                class="text-danger">*</span></label>
                        <span class="form-control">{{ $sale->mq_no }}</span>
                    </div>
                </div>
            </div>




            @foreach ($sale->saleDetails as $details)
                <hr />
                <h4 class="text-center">Connectivity Point:
                    {{ $details->feasibilityRequirementDetails->connectivity_point }}</h4>
                <hr />
                <div class="row">
                    <div class="col-xl-4 col-md-4">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="client_id">OTC<span class="text-danger">*</span></label>
                            <span class="form-control">{{ $details->otc }}</span>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="client_id">Month<span class="text-danger">*</span></label>
                            <span class="form-control">{{ $details->costing->month }}</span>
                        </div>
                    </div>
                </div>
                <hr />
                <div class="row">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Unit</th>
                                <th>Rate</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($details->saleProductDetails as $product)
                                <tr class="text-center">
                                    <td>{{ $product->product->name }}</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>{{ $product->unit }}</td>
                                    <td>{{ $product->rate }}</td>
                                    <td>{{ $product->total_price }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="text-center">
                                <td colspan="4">Total</td>
                                <td>{{ $details->saleProductDetails->sum('total_price') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="row">
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
                            @foreach ($details->costing->costingProductEquipments as $equipment)
                                <tr>
                                    <td>{{ $equipment->material->name }}</td>
                                    <td>{{ $equipment->quantity }}</td>
                                    <td>{{ $equipment->unit }}</td>
                                    <td>{{ $equipment->ownership }}</td>
                                    <td>{{ $equipment->rate }}</td>
                                    <td>{{ $equipment->total }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>
    </div>
@endsection
