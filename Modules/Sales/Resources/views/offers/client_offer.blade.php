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
                <div class="col-xl-3 col-md-3">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="client_id">Client Name<span class="text-danger">*</span></label>
                        <span class="form-control">{{ $offer->client->client_name }}</span>
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
                                        $vat = number_format($totalProductPrice * ($product->product->vat / 100), 2);
                                        $total += $totalProductPrice + $vat;
                                    @endphp
                                    <tr class="text-center">
                                        <td>{{ $product->product->name }}</td>
                                        <td>{{ $product->quantity }}</td>
                                        <td>{{ $product->unit }}</td>
                                        <td>{{ $productPrice }}</td>
                                        <td>{{ $totalProductPrice }}</td>
                                        <td>{{ $vat }}</td>
                                        <td>{{ $totalProductPrice + $vat }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-right" colspan="6">Total Product Price</td>
                                    <td class="text-center">{{ $total }}</td>
                                </tr>
                                <tr>
                                    <td class="text-right" colspan="6">OTC</td>
                                    <td class="text-center">{{ $data->total_offer_otc }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" class="text-right">Total</td>
                                                <td class="text-center">{{ $total + $data->total_offer_otc }}</td>

                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                {{-- <div class="col-12 mt-3">
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
                                @foreach ($details->costing->costingProductEquipments->where('ownership', 'Client') as $equipment)
                                    <tr>
                                        <td>{{ $equipment->material->name }}</td>
                                        <td>{{ $equipment->quantity }}</td>
                                        <td>{{ $equipment->unit }}</td>
                                        <td>{{ $equipment->ownership }}</td>
                                        <td>{{ $equipment->rate }}</td>
                                        <td>{{ $equipment->total }}</td>
                                    </tr>
                                @endforeach
                                @foreach ($details->costing->costingLinkEquipments->where('ownership', 'Client') as $link_equipment)
                                    <tr>
                                        <td>{{ $link_equipment->material->name }}</td>
                                        <td>{{ $link_equipment->quantity }}</td>
                                        <td>{{ $link_equipment->unit }}</td>
                                        <td>{{ $link_equipment->ownership }}</td>
                                        <td>{{ $link_equipment->rate }}</td>
                                        <td>{{ $link_equipment->total }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> --}}
                            </div>
    @endforeach
                    </div>
                </div>
@endsection
