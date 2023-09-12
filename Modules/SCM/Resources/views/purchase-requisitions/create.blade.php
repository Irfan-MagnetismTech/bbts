@extends('layouts.backend-layout')
@section('title', 'Purchase Requisitions Slip')

@php
    $is_old = old('type') ? true : false;
    $form_heading = !empty($purchaseRequisition) ? 'Update' : 'Add';
    $form_url = !empty($purchaseRequisition) ? route('errs.update', $purchaseRequisition->id) : route('errs.store');
    $form_method = !empty($purchaseRequisition) ? 'PUT' : 'POST';
    
    $client_id = old('client_id', !empty($purchaseRequisition) ? $purchaseRequisition->client_id : null);
    $fr_no = old('fr_no', !empty($purchaseRequisition) ? $purchaseRequisition->fr_no : null);
    $client_name = old('client_name', !empty($purchaseRequisition) ? $purchaseRequisition?->client?->client_name : null);
    $client_no = old('client_no', !empty($purchaseRequisition) ? $purchaseRequisition?->client_no : null);
    $client_link_no = old('client_link_no', !empty($purchaseRequisition) ? $purchaseRequisition?->link_no : null);
    $client_address = old('client_address', !empty($purchaseRequisition) ? $purchaseRequisition?->client?->location : null);
@endphp

@section('breadcrumb-title')
    @if (!empty($purchaseRequisition))
        Edit
    @else
        Create
    @endif
    PRS (Purchaase Requisition Slip)
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
                <div class="col-12">
                    <div class="typeSection mt-2 mb-4">
                        <div class="form-check-inline">
                            <label class="form-check-label" for="client">
                                <input type="radio" class="form-check-input radioButton" id="client" name="type"
                                    value="client" @checked(@$purchaseRequisition->type == 'client' || old('type') == 'client') required> Client Purpose
                            </label>
                        </div>

                        <div class="form-check-inline">
                            <label class="form-check-label" for="internal">
                                <input type="radio" class="form-check-input radioButton" id="internal" name="type"
                                    @checked(@$purchaseRequisition->type == 'internal' || old('type') == 'internal') value="internal" required>
                                Internal Purpose
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-3">
                    <label for="prs_type">PRS Type <span class="text-danger">*</span></label>
                    <select class="form-control" name="prs_type" id="prs_type" required>
                        <option value="" disabled selected>Select PRS Type</option>
                        <option value="Purchase Order" @selected('Purchase Order' == @$purchaseRequisition->prs_type)>Purchase Order</option>
                        <option value="Work Order" @selected('Work Order' == @$purchaseRequisition->prs_type)>Work Order</option>
                    </select>
                </div>

                <div class="form-group col-3">
                    <label for="date">Applied Date:</label>
                    <input class="form-control" id="date" name="date" aria-describedby="date"
                        value="{{ old('date') ?? (@$purchaseRequisition->date ?? '') }}" readonly
                        placeholder="Select a Date">
                </div>

                <div class="form-group col-3 client_name">
                    <label for="client_name">Client Name:</label>
                    <input type="text" class="form-control" id="client_name" aria-describedby="client_name"
                        name="client_name" value="{{ old('client_name') ?? ($client_name ?? '') }}" placeholder="Search...">
                </div>

                <div class="form-group col-3 fr_no">
                    <label for="select2">FR No</label>
                    <select class="form-control select2" id="fr_no" name="fr_no">
                        <option value="" readonly selected>Select FR No</option>
                        @if ($form_method == 'POST')
                            <option value="{{ old('fr_no') }}" selected>{{ old('fr_no') }}</option>
                        @elseif($form_method == 'PUT')
                            @forelse ($fr_nos as $key => $value)
                                <option value="{{ $value->fr_no }}" @if ($fr_no == $value->fr_no) selected @endif>
                                    {{ $value->fr_no }}
                                </option>
                            @empty
                            @endforelse
                        @endif
                    </select>
                </div>

                {{-- <div class="form-group col-3 link_no">
                    <label for="link_no">Link No:</label>
                    <select class="form-control select2" id="link_no" name="link_no">
                        <option value="" readonly selected>Select Link No</option>
                        @if ($form_method == 'POST')
                            <option value="{{ old('link_no') }}" selected>{{ old('link_no') }}</option>
                        @elseif($form_method == 'PUT')
                            @forelse ($client_links as $key => $value)
                                <option value="{{ $value->link_no }}" @if ($client_link_no == $value->link_no) selected @endif>
                                    {{ $value->link_no }}
                                </option>
                            @empty
                            @endforelse
                        @endif
                    </select>
                </div> --}}

                <div class="form-group col-3 client_no">
                    <label for="client_no">Client No:</label>
                    <input type="text" class="form-control" id="client_no" aria-describedby="client_no" name="client_no"
                        readonly value="{{ old('client_no') ?? (@$client_no ?? '') }}">
                </div>

                <div class="form-group col-3 client_address">
                    <label for="client_address">Client Address:</label>
                    <input type="text" class="form-control" id="client_address" name="client_address"
                        aria-describedby="client_address" readonly
                        value="{{ old('client_address') ?? (@$client_address ?? '') }}">
                </div>

                <div class="form-group col-3 assesment_no">
                    <label for="select2">Assesment No</label>
                    <select class="form-control select2" id="assesment_no" name="assesment_no">
                        <option value="" readonly selected>Select Assesment No</option>
                    </select>
                </div>
            </div>

            <table class="table table-bordered" id="material_requisition">
                <thead>
                    <tr>
                        <th> Material Name</th>
                        <th> Unit</th>
                        <th> Brand</th>
                        <th> Model </th>
                        <th> Unit Price </th>
                        <th> Quantity </th>
                        <th> Total Amount </th>
                        <th> Purpose </th>
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
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}" @selected($brand->id == $brand_id[$key])>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
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
    <script src="{{ asset('js/search-client.js') }}"></script>
    <script>
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
                                <select name="brand_id[]" class="form-control brand" autocomplete="off">
                                    <option value="">Select Brand</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>    
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
                                <input name="total_amount[]" class="form-control total_amount" autocomplete="off" readonly>
                            </td>
                            <td>
                                <input type="text" name="purpose[]" class="form-control purpose" autocomplete="off">
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

        //Search Material
        $(document).on('keyup focus', '.material_name', function() {
            $(this).autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ url('search-material') }}",
                        type: 'get',
                        dataType: "json",
                        data: {
                            search: request.term
                        },
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                select: function(event, ui) {
                    $(this).closest('tr').find('.material_name').val(ui.item.label);
                    $(this).closest('tr').find('.material_id').val(ui.item.value);
                    $(this).closest('tr').find('.item_code').val(ui.item.item_code);
                    $(this).closest('tr').find('.unit').val(ui.item.unit);
                    return false;
                }
            });
        });

        $(function() {
            onChangeRadioButton();
            $('.select2').select2();

            //using form custom function js file
            fillSelect2Options("{{ route('searchBranch') }}", '#branch_id');
            associativeDropdown("{{ route('searchPopByBranchId') }}", 'search', '#branch_id', '#pop_id', 'get',
                null)

            $(".radioButton").click(function() {
                onChangeRadioButton()
            });
        });

        function onChangeRadioButton() {
            var radioValue = $("input[name='type']:checked").val();
            if (radioValue == 'client') {
                $('.pop_id').hide('slow');
                $('.fr_id').show('slow');
                $('.client_name').show('slow');
                $('.client_no').show('slow');
                $('.client_links').show('slow');
                $('.assesment_no').show('slow');
                $('.fr_no').show('slow');
                $('.link_no').show('slow');
                $('.client_address').show('slow');
            } else if (radioValue == 'internal') {
                $('.pop_id').hide('slow');
                $('.fr_id').hide('slow');
                $('.client_name').hide('slow');
                $('.client_no').hide('slow');
                $('.client_links').hide('slow');
                $('.assesment_no').hide('slow');
                $('.fr_no').hide('slow');
                $('.link_no').hide('slow');
                $('.client_address').hide('slow');
            }
        }
    </script>
@endsection
