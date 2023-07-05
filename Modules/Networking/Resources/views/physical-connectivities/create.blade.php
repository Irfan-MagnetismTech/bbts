@extends('layouts.backend-layout')
@section('title', 'Pyhsical Connectivity')

@php
    $is_old = old('type') ? true : false;
    $form_heading = !empty($purchaseRequisition) ? 'Update' : 'Add';
    $form_url = !empty($purchaseRequisition) ? route('errs.update', $purchaseRequisition->id) : route('errs.store');
    $form_method = !empty($purchaseRequisition) ? 'PUT' : 'POST';
    
    $client_id = old('client_id', !empty($purchaseRequisition) ? $purchaseRequisition->client_id : null);
    $connectivity_point = old('connectivity_point', !empty($purchaseRequisition) ? $purchaseRequisition->fr_no : null);
    $client_name = old('client_name', !empty($purchaseRequisition) ? $purchaseRequisition?->client?->client_name : null);
    $client_no = old('client_no', !empty($purchaseRequisition) ? $purchaseRequisition?->client_no : null);
    $client_link_no = old('client_link_no', !empty($purchaseRequisition) ? $purchaseRequisition?->link_no : null);
    $contact_person = old('contact_person', !empty($purchaseRequisition) ? $purchaseRequisition?->client?->location : null);
@endphp

@section('breadcrumb-title')
    @if (!empty($purchaseRequisition))
        Edit
    @else
        Create
    @endif
    Physical Connectivity
@endsection

@section('style')
    <style>
        .input-group-addon {
            min-width: 120px;
        }

        .input-group-info .input-group-addon {
            /*background-color: #04748a!important;*/
        }
    </style>
@endsection

@section('breadcrumb-button')
    <a href="{{ route('purchase-requisitions.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
    <div class="">
        <form
            action="{{ !empty($purchaseRequisition) ? route('purchase-requisitions.update', @$purchaseRequisition->id) : route('purchase-requisitions.store') }}"
            method="post" class="custom-form">
            @if (!empty($purchaseRequisition))
                @method('PUT')
            @endif
            @csrf

            <div class="row">
                <div class="form-group col-3 client_name">
                    <label for="client_name">Client Name:</label>
                    <input type="text" class="form-control" id="client_name" aria-describedby="client_name"
                        name="client_name" value="{{ old('client_name') ?? ($client_name ?? '') }}" placeholder="Search...">
                    <input type="hidden" name="client_no" id="client_no"
                        value="{{ old('client_no') ?? ($client_no ?? '') }}">
                </div>

                <div class="form-group col-3 client_type">
                    <label for="client_type">Client Type:</label>
                    <input type="text" class="form-control" id="client_type" name="client_type"
                        aria-describedby="client_type" readonly value="{{ old('client_type') ?? (@$client_type ?? '') }}">
                </div>

                <div class="form-group col-3 connectivity_point1">
                    <label for="select2">Connectivity Point</label>
                    <select class="form-control select2" id="connectivity_point" name="connectivity_point">
                        <option value="" readonly selected>Select FR No</option>
                        @if ($form_method == 'POST')
                            <option value="{{ old('connectivity_point') }}" selected>{{ old('connectivity_point') }}
                            </option>
                        @elseif($form_method == 'PUT')
                            @forelse ($connectivity_points as $key => $value)
                                <option value="{{ $value->connectivity_point }}"
                                    @if ($connectivity_point == $value->connectivity_point) selected @endif>
                                    {{ $value->connectivity_point }}
                                </option>
                            @empty
                            @endforelse
                        @endif
                    </select>
                </div>

                <div class="form-group col-3 contact_person">
                    <label for="contact_person">Contact Person:</label>
                    <input type="text" class="form-control" id="contact_person" name="contact_person"
                        aria-describedby="contact_person" readonly
                        value="{{ old('contact_person') ?? (@$contact_person ?? '') }}">
                </div>

                <div class="form-group col-3 contact_number">
                    <label for="contact_number">Contact Number:</label>
                    <input type="text" class="form-control" id="contact_number" aria-describedby="contact_number"
                        name="contact_number" readonly value="{{ old('contact_number') ?? (@$contact_number ?? '') }}">
                </div>

                <div class="form-group col-3 email">
                    <label for="email">Email:</label>
                    <input type="text" class="form-control" id="email" name="email" aria-describedby="email"
                        readonly value="{{ old('email') ?? (@$email ?? '') }}">
                </div>

                <div class="form-group col-3 contact_address">
                    <label for="contact_address">Contact Address:</label>
                    <input type="text" class="form-control" id="contact_address" name="contact_address"
                        aria-describedby="contact_address" readonly
                        value="{{ old('contact_address') ?? (@$contact_address ?? '') }}">
                </div>

                <div class="form-group col-3 lat">
                    <label for="lat">Lat. Long:</label>
                    <input type="text" class="form-control" id="lat" name="lat" aria-describedby="lat"
                        readonly value="{{ old('lat') ?? (@$lat ?? '') }}">
                </div>

                <div class="form-group col-3 long">
                    <label for="long">Lat. Long:</label>
                    <input type="text" class="form-control" id="long" name="long" aria-describedby="long"
                        readonly value="{{ old('long') ?? (@$long ?? '') }}">
                </div>

                <div class="form-group col-3 remarks">
                    <label for="remarks">Remarks:</label>
                    <input type="text" class="form-control" id="remarks" name="remarks" aria-describedby="remarks"
                        value="{{ old('remarks') ?? (@$remarks ?? '') }}">
                </div>
            </div>

            <table class="table table-bordered" id="physical_connectivity">
                <thead>
                    <tr>
                        <th> Link Type</th>
                        <th> Method</th>
                        <th> POP</th>
                        <th>LDP</th>
                        <th> Link ID </th>
                        <th> Device IP </th>
                        <th> PORT </th>
                        <th> VLAN </th>
                        <th> Distance </th>
                        <th> Connectivity Details </th>
                        <th> Backbone </th>
                        <th> Comment </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $material_name_with_code = old('material_name', !empty($purchaseRequisition) ? $purchaseRequisition->scmPurchaseRequisitionDetails->pluck('material.materialNameWithCode') : []);
                        $material_id = old('material_id', !empty($purchaseRequisition) ? $purchaseRequisition->scmPurchaseRequisitionDetails->pluck('material_id') : []);
                        $item_code = old('item_code', !empty($purchaseRequisition) ? $purchaseRequisition->scmPurchaseRequisitionDetails->pluck('material.code') : []);
                        $unit = old('unit', !empty($purchaseRequisition) ? $purchaseRequisition->scmPurchaseRequisitionDetails->pluck('material.unit') : []);
                        $brand_id = old('brand_id', !empty($purchaseRequisition) ? $purchaseRequisition->scmPurchaseRequisitionDetails->pluck('brand_id') : []);
                        $quantity = old('quantity', !empty($purchaseRequisition) ? $purchaseRequisition->scmPurchaseRequisitionDetails->pluck('quantity') : []);
                        $unit_price = old('unit_price', !empty($purchaseRequisition) ? $purchaseRequisition->scmPurchaseRequisitionDetails->pluck('unit_price') : []);
                        $total_amount = old('total_amount', !empty($purchaseRequisition) ? $purchaseRequisition->scmPurchaseRequisitionDetails->pluck('total_amount') : []);
                        $model = old('model', !empty($purchaseRequisition) ? $purchaseRequisition->scmPurchaseRequisitionDetails->pluck('model') : []);
                        $purpose = old('purpose', !empty($purchaseRequisition) ? $purchaseRequisition->scmPurchaseRequisitionDetails->pluck('purpose') : []);
                    @endphp
                    @foreach ($material_name_with_code as $key => $requisitionDetail)
                        <tr>
                            <td>
                                <input type="text" name="material_name[]" class="form-control material_name" required
                                    autocomplete="off" value="{{ $material_name_with_code[$key] }}">
                                <input type="hidden" name="material_id[]" class="form-control material_id"
                                    value="{{ $material_id[$key] }}">
                                <input type="hidden" name="item_code[]" class="form-control item_code"
                                    value="{{ $item_code[$key] }}">
                            </td>
                            <td>
                                <input type="text" name="unit[]" class="form-control unit" autocomplete="off"
                                    readonly value="{{ $unit[$key] }}" id="unit">
                            </td>
                            <td>
                                <select name="brand_id[]" class="form-control brand" autocomplete="off">
                                    <option value="">Select Brand</option>

                                </select>
                            </td>
                            <td>
                                <input type="text" name="model[]" class="form-control model" autocomplete="off"
                                    value="{{ $model[$key] }}">
                            </td>
                            <td>
                                <input type="number" name="unit_price[]" class="form-control unit_price"
                                    autocomplete="off" value="{{ $unit_price[$key] }}">
                            </td>
                            <td>
                                <input type="number" name="quantity[]" class="form-control quantity" autocomplete="off"
                                    value="{{ $quantity[$key] }}">
                            </td>
                            <td>
                                <input name="total_amount[]" class="form-control total_amount" autocomplete="off"
                                    value="{{ $total_amount[$key] }}" readonly>
                            </td>
                            <td>
                                <input type="text" name="purpose[]" class="form-control purpose" autocomplete="off"
                                    value="{{ $purpose[$key] }}">
                            </td>
                            <td>
                                <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h6>Material Utilizations</h6>
            {{-- @forelse (@$challans as $challan)
                <button type="button" class="btn btn-primary" data-toggle="modal"
                    data-target="#challan{{ $challan->id }}">
                    {{ $challan->challan_no }}
                </button>
            @empty
            @endforelse --}}
            <div id="challans">

            </div>

            <div class="row">
                <div class="offset-md-4 col-md-4 mt-2">
                    <div class="input-group input-group-sm ">
                        <button class="btn btn-success btn-round btn-block py-2">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="modal fade" id="challaModal" tabindex="-1" role="dialog" aria-labelledby="challaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content" id="challanModalContent">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            {{-- <h5 class="text-center">Challan No: {{ @$challan->challan_no }}</h5> --}}
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>FR No</th>
                                        <th>Purpose</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach (@$challan->scmChallanDetails as $challanDetail)
                                        <tr>
                                            <td>{{ $challanDetail->material->materialNameWithCode }}</td>
                                            <td>{{ $challanDetail->brand->name }}</td>
                                            <td>{{ $challanDetail->model }}</td>
                                            <td>{{ $challanDetail->material->unit }}</td>
                                            <td>{{ $challanDetail->quantity }}</td>
                                            <td>{{ $challanDetail->unit_price }}</td>
                                            <td>{{ $challanDetail->total_amount }}</td>
                                        </tr>
                                    @endforeach --}}
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        $('#connectivity_point').on('change', function() {
            var connectivity_point = $(this).val();

            $.ajax({
                url: "{{ route('getChallanInfoByLinkNo') }}",
                type: 'GET',
                data: {
                    link_no: "fr-2023-03-1-P1"
                },
                success: function(data) {
                    console.log(data);
                    //foreach data and append to challans div
                    var html = '';
                    $.each(data, function(key, value) {
                        html +=
                            '<button type="button" class="btn btn-primary challanButton" data-toggle="modal" data-target="#challaModal" >' +
                            value.challan_no + '</button>';
                    });
                    $('#challans').html(html);
                }
            });
        });
        //on click modal button get challan info
        $('#challans').on('click', '.challanButton', function() {
            var challan_no = $(this).text();
            $.ajax({
                url: "{{ route('getChallanInfoByChallanNo') }}",
                type: 'GET',
                data: {
                    challan_no: challan_no
                },
                success: function(data) {
                    console.log(data);
                    //foreach data and append to challans div
                    var html = '';
                    $.each(data, function(key, value) {
                        html +=
                            '<tr><td>' + value.fr_no + '</td><td>' + value
                            .purpose + '</td>';
                    });
                    $('#challanModalContent tbody').html(html);
                }
            });
        });

        //open modal for challan
        function openChallanModal(id) {
            $('#challaModal').modal('show');
        }
    </script>

    @include('networking::physical-connectivities.js')
@endsection
