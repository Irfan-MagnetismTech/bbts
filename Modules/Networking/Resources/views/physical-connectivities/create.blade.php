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
    Pyhsical Connectivity
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

                <div class="form-group col-3 connectivity_point">
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

                <div class="form-group col-3 lat_long">
                    <label for="lat_long">Lat. Long:</label>
                    <input type="text" class="form-control" id="lat_long" name="lat_long" aria-describedby="lat_long"
                        readonly value="{{ old('lat_long') ?? (@$lat_long ?? '') }}">
                </div>

                <div class="form-group col-3 remarks">
                    <label for="remarks">Remarks:</label>
                    <input type="text" class="form-control" id="remarks" name="remarks" aria-describedby="remarks"
                        value="{{ old('remarks') ?? (@$remarks ?? '') }}">
                </div>
            </div>

            <table class="table table-bordered" id="material_requisition">
                <thead>
                    <tr>
                        <th> Link Type</th>
                        <th> Method</th>
                        <th> POP</th>
                        <th> Link ID </th>
                        <th> Device IP </th>
                        <th> PORT </th>
                        <th> VLAN </th>
                        <th> Distance </th>
                        <th> Connectivity Details </th>
                        <th> Backbone </th>
                        <th> Comment </th>
                        <th><i class="btn btn-primary btn-sm fa fa-plus add-requisition-row"></i></th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
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
                </tfoot>
            </table>

            <div class="row">
                <div class="offset-md-4 col-md-4 mt-2">
                    <div class="input-group input-group-sm ">
                        <button class="btn btn-success btn-round btn-block py-2">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script>
        $(document).on("keyup focus", "#client_name", function() {
            $(this).autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('searchClientWithFrDetails') }}",
                        type: "get",
                        dataType: "json",
                        data: {
                            search: request.term,
                        },
                        success: function(data) {
                            response(data);
                        },
                    });
                },
                select: function(event, ui) {
                    $("#client_name").val(ui.item.label);
                    $("#client_no").val(ui.item.client_no);
                    $('#client_type').val(ui.item.client_type);

                    $("#connectivity_point").html("");
                    var link_options = '<option value="">Select Option</option>';

                    ui.item.frDetails.forEach(function(element) {
                        console.log(element)
                        link_options +=
                            `<option value="${element.fr_no}">${element.connectivity_point + '-' + element.fr_no}</option>`;
                    });

                    $("#connectivity_point").html(link_options);

                    return false;
                },
            });
        });

        $("#connectivity_point").on("change", function() {
            let connectivity_point = $(this).val();

            $.ajax({
                url: "{{ route('getFrDetailsData') }}",
                type: "get",
                dataType: "json",
                data: {
                    connectivity_point: connectivity_point,
                },
                success: function(data) {
                    $("#fr_no").val(data.fr_no);
                    $("#contact_person").val(data.contact_name);
                    $("#contact_number").val(data.contact_number);
                    $("#email").val(data.contact_email);
                    $("#contact_address").val(data.location);
                    $("#lat_long").val(data.lat_long);

                    appendNetworkInfoRow(data.planning.final_survey_details);
                },
            });
        });

        function appendNetworkInfoRow(data) {
            //loop through the data
            data.forEach(function(element) {
                let row = `<tr>
                            <td>
                                <input type="text" name="link_type[]" class="form-control link_type" required
                                    autocomplete="off" value="${element.link_type}">
                            </td>
                            <td>
                                <input type="text" name="method[]" class="form-control method"
                                    autocomplete="off" value="${element.method}">
                            </td>
                            <td>
                                <i class="btn btn-danger btn-sm fa fa-minus remove-network-info-row"></i>
                            </td>
                        </tr>`;
                $("#material_requisition tbody").append(row);
            }); //end of loop
        }

        $(document).on('keyup', '.unit_price, .quantity', function() {
            var unit_price = $(this).closest('tr').find('.unit_price').val();
            var quantity = $(this).closest('tr').find('.quantity').val();
            var total_amount = unit_price * quantity;
            $(this).closest('tr').find('.total_amount').val(total_amount);
        });

        $('#date').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true,
            showOtherMonths: true
        }).datepicker("setDate", new Date());
        /* Append row */
        @if (empty($purchaseRequisition) && empty(old('material_name')))
            appendCalculationRow();
        @endif
        function appendCalculationRow() {
            var type = $("input[name=type]:checked").val()
            let row = `<tr>
                            <td>
                                <input type="text" name="material_name[]" class="form-control material_name" required autocomplete="off">
                                <input type="hidden" name="material_id[]" class="form-control material_id">
                                <input type="hidden" name="item_code[]" class="form-control item_code">
                            </td>                            
                            <td>
                                <input type="text" name="unit[]" class="form-control unit" autocomplete="off" readonly>
                            </td>
                            <td>
                                <input type="text" name="model[]" class="form-control model" autocomplete="off" readonly>
                            </td>
                            <td>
                                <input type="text" name="model[]" class="form-control model" autocomplete="off">
                            </td>
                            <td>
                                <input type="number" name="unit_price[]" class="form-control unit_price" autocomplete="off">
                            </td>
                            <td>
                                <input type="number" name="quantity[]" class="form-control quantity" autocomplete="off">
                            </td>
                            <td>
                                <input name="total_amount[]" class="form-control total_amount" autocomplete="off">
                            </td>
                            <td>
                                <input type="text" name="purpose[]" class="form-control purpose" autocomplete="off">
                            </td>
                            <td>
                                <input type="text" name="model[]" class="form-control model" autocomplete="off">
                            </td>
                            <td>
                                <input type="text" name="model[]" class="form-control model" autocomplete="off">
                            </td>
                            <td>
                                <input type="text" name="model[]" class="form-control model" autocomplete="off">
                            </td>
                            <td>
                                <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i>
                            </td>
                        </tr>`;
            $('#material_requisition tbody').append(row);
        }

        /* Adds and removes quantity row on click */
        $("#material_requisition")
            .on('click', '.add-requisition-row', () => {
                appendCalculationRow();
            })
            .on('click', '.remove-calculation-row', function() {
                $(this).closest('tr').remove();
            });

        $(function() {
            $('.select2').select2();
        });
    </script>
@endsection
