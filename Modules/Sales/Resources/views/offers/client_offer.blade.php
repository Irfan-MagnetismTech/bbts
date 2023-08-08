@extends('layouts.backend-layout')
@section('title', 'Client Offer')





@section('content-grid', null)
@section('style')
    <style>
        .section-label {
            background: #ffffff;
            margin-left: 25px;
            font-size: 15px;
            font-weight: bold;
            padding: 17px;
            transition: 0.3s;
        }
    </style>
@endsection
@section('content')

    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title text-center">Client Offer</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-xl-4 col-md-4">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="client_id">Client Name<span class="text-danger">*</span></label>
                        <span class="form-control">{{ $offer->client->client_name ?? null }}</span>
                    </div>
                </div>
                <div class="col-xl-3 col-md-3">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="client_id">Client No<span class="text-danger">*</span></label>
                        <span class="form-control">{{ $offer->client_no }}</span>
                    </div>
                </div>
                <div class="col-xl-3 col-md-3">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="client_id">MQ No<span class="text-danger">*</span></label>
                        <span class="form-control">{{ $offer->mq_no }}</span>
                    </div>
                </div>
            </div>
            @php
                $total_mrc = 0;
            @endphp
            @foreach ($offerData as $data)
                <div style="border: 2px solid gray; border-radius: 15px; margin-top: 30px;" class="row">
                    <div class="col-12 col-md-12" style="margin-top: -11px;">
                        <span class="section-label">
                            {{ $data->frDetails->connectivity_point }}</span>
                    </div>
                    <div class="col-12 mt-3">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                    <th>Rate</th>
                                    <th>Amount</th>
                                    <th>Vat</th>
                                    <th>Total Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                @endphp
                                @foreach ($data->costing->costingProducts as $product)
                                    @php
                                        $productPrice = number_format($product->product_price, 2);
                                        $totalProductPrice = $product->quantity * $productPrice;
                                        $vat = $product->product_vat_amount;
                                        $total += $totalProductPrice + $vat;
                                        $total_mrc += $totalProductPrice + $vat;
                                    @endphp
                                    <tr class="text-center">
                                        <td>{{ $product->product->name }}</td>
                                        <td>{{ $product->quantity }}</td>
                                        <td>{{ $product->unit }}</td>
                                        <td>{{ $productPrice }}</td>
                                        <td>{{ $totalProductPrice }}</td>
                                        <td>{{ $vat }}</td>
                                        <td class="text-right"><b>@formatFloat($totalProductPrice + $vat)</b></td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-right" colspan="6"><b>Total Product Price</b></td>
                                    <td class="text-right"><b>@formatFloat($total )</b></td>
                                </tr>
                                <tr>
                                    <td class="text-right" colspan="6"><b>OTC</b></td>
                                    <td class="text-right"><b>@formatFloat($data->total_offer_otc )</b></td>
                                </tr>
                                <tr>
                                    <td colspan="6" class="text-right"><b>Total</b></td>
                                    <td class="text-right"><b>@formatFloat($total + $data->total_offer_otc)</b></td>

                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="col-12 mt-3">
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
                                @foreach ($uniqueEquipments as $equipment)
                                    <tr>
                                        <td>{{ $equipment->material->name }}</td>
                                        <td>{{ $equipment->sum_quantity }}</td>
                                        <td>{{ $equipment->unit }}</td>
                                        <td>{{ $equipment->ownership }}</td>
                                        <td>{{ $equipment->rate }}</td>
                                        <td>{{ $equipment->total_price }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
            <div class="float-right" style="margin-top: 20px;">
                <span class="p-2 border bg-primary">
                    Total MRC
                </span>
                <span class="p-2 border border-primary text-dark">
                    {{ $total_mrc }}
                </span>
            </div>
        </div>
    </div>
@endsection
