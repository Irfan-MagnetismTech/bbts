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
        .select2-container--default .select2-selection--multiple .select2-selection__choice span {
            color: #b10000;
        }

        .select2_container {
            max-width: 200px;
            white-space: inherit;
        }
        .custom-spinner-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 40vh;
        }

        .custom-spinner {
            width: 4rem;
            height: 4rem;
            border: .5em solid transparent;
            border-top-color: currentColor;
            border-radius: 50%;
            animation: spinner-animation 1s linear infinite;
        }

        @keyframes spinner-animation {
            to {
                transform: rotate(360deg);
            }
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
                @php $fr_no = json_decode($fr_no); @endphp

                <div class="form-group col-3 fr_no select2_container">
                    <label for="select2">FR No</label>
                    <select class="form-control select2 serial_code" id="fr_no" multiple name="fr_no[]">
                        <option value="" readonly >Select FR No</option>
                        @if ($form_method == 'POST')
                            <option value="{{ old('fr_no') }}" >{{ old('fr_no') }}</option>
                        @elseif($form_method == 'PUT')
                            @forelse ($fr_nos as $key => $value)
                                <option value="{{ $value->fr_no }}" @if (in_array($value->fr_no, $fr_no)) selected @endif>
                                    {{ $value->fr_no }}
                                </option>
                            @empty
                            @endforelse
                        @endif
                    </select>
                </div>
                {{-- <td class="select2_container">
                    <select class="form-control select2 serial_code" multiple
                        name="serial_code[{{ $key }}][]">
                        @foreach ($serial_codes[$key] as $key1 => $value)
                            <option value="{{ $value->serial_code }}" @selected(in_array($value->serial_code, json_decode($serial_code[$key])))>
                                {{ $value->serial_code }}
                            </option>
                        @endforeach
                    </select>
                </td> --}}

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
                <div class="row loading" style="display: none;">
                    <div class="col-md-12">
                        <div class="custom-spinner-container">
                            <div class="custom-spinner text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>

                            <!-- Optional text -->
                            <div class="mt-2">Loading...</div>
                        </div>
                    </div>
                </div>
            <table class="table table-bordered" id="material_requisition">
                <thead>
                    <tr>
                        <th> Material Name</th>
                        <th> Item Code</th>
                        <th> Unit</th>
                        <th> Brand</th>
                        <th> Model </th>
                        <th> Quantity </th>
                        <th> Unit Price </th>
                        <th> Total Amount </th>
                        <th> Purpose </th>
                        <th> Remarks </th>
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
                        $remarks = old('remarks', !empty($purchaseRequisition) ? $purchaseRequisition->scmPurchaseRequisitionDetails->pluck('remarks') : []);
                    @endphp
                    @foreach ($material_name_with_code as $key => $requisitionDetail)
                        <tr>
                            <td>
                                <input type="text" name="material_name[]" class="form-control material_name" required
                                    autocomplete="off" value="{{ $material_name_with_code[$key] }}">
                                <input type="hidden" name="material_id[]" class="form-control material_id"
                                    value="{{ $material_id[$key] }}">
                            </td>
                            <td>
                                <input type="text" name="item_code[]" class="form-control item_code" autocomplete="off"
                                       readonly value="{{ $item_code[$key] }}" id="item_code">
                            </td>
                            <td>
                                <input type="text" name="unit[]" class="form-control unit" autocomplete="off"
                                    readonly value="{{ $unit[$key] }}" id="unit">
                            </td>
                            <td>
                                <select name="brand_id[]" class="form-control brand_id select2" autocomplete="off">
                                    <option value="">Select Brand</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}" @selected($brand->id == $brand_id[$key])>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                @if(isset($model[$key]))
                                    <input list="models" name="model[]" id="model[]" class="form-control model" value="{{ $model[$key] }}">
                                @else
                                    <input list="models" name="model[]" id="model[]" class="form-control model" value="">
                                @endif
                                <datalist id="models">
                                    @foreach ($models as $model)
                                        <option value="{{ $model }}">
                                    @endforeach
                                </datalist>
                            </td>
                            <td>
                                <input type="number" name="quantity[]" class="form-control quantity" autocomplete="off"
                                       step="0.01" value="{{ $quantity[$key] }}">
                            </td>
                            <td>
                                <input type="number" name="unit_price[]" class="form-control unit_price"
                                    autocomplete="off" step="0.01" value="{{ $unit_price[$key] }}">
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
                                <input type="text" name="remarks[]" class="form-control remarks" autocomplete="off"
                                       value="{{ $remarks[$key] }}">
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

        // $('#date').datepicker({
        //     format: "dd-mm-yyyy",
        //     autoclose: true,
        //     todayHighlight: true,
        //     showOtherMonths: true
        // }).datepicker("setDate", new Date());

        if ($('#date').val() != null)
        {
            $('#date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                showOtherMonths: true
            });
        }else {
            $('#date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                showOtherMonths: true
            }).datepicker("setDate", new Date());
        }
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
                            </td>
                            <td>
                                <input type="text" name="item_code[]" class="form-control item_code" autocomplete="off" readonly>
                            </td>
                            <td>
                                <input type="text" name="unit[]" class="form-control unit" autocomplete="off" readonly>
                            </td>
                            <td>
                                <select name="brand_id[]" class="form-control brand_id select2" autocomplete="off">
                                    <option value="">Select Brand</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                             <input list="models" name="model[]" id="model[]" class="form-control model">
                             <datalist id="models">
                            @foreach ($models as $model)
                            <option value="{{ $model }}">
                            @endforeach
                            </datalist>
                            </td>
                            <td>
                                <input type="number" name="quantity[]" class="form-control quantity" autocomplete="off" step="0.01">
                            </td>
                            <td>
                                <input type="number" name="unit_price[]" class="form-control unit_price" autocomplete="off" step="0.01">
                            </td>
                            <td>
                                <input name="total_amount[]" class="form-control total_amount" autocomplete="off" readonly>
                            </td>
                            <td>
                                <input type="text" name="purpose[]" class="form-control purpose" autocomplete="off">
                            </td>
                            <td>
                                <input type="text" name="remarks[]" class="form-control remarks" autocomplete="off">
                            </td>
                            <td>
                                <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i>
                            </td>
                        </tr>`;
            $('#material_requisition tbody').append(row);
            $('.select2').select2({});
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
                    $('.loading').show();
                    $(this).closest('tr').find('.material_name').val(ui.item.label);
                    $(this).closest('tr').find('.material_id').val(ui.item.value);
                    $(this).closest('tr').find('.item_code').val(ui.item.item_code);
                    $(this).closest('tr').find('.unit').val(ui.item.unit);

                    //Search Brand
                    var this_event = $(this);
                    var material_id = ui.item.value;
                    $.get('{{ route('getMaterialWiseBrands') }}', {
                        material_id: material_id
                    }, function (data) {
                        var html = '<option value="">Select Brand</option>';
                        $.each(data, function (key, item) {
                            html += '<option value="' + item.id + '">' +
                                item.name + '</option>';
                        });
                        this_event.closest('tr').find('.brand_id').html(html);
                        $('.loading').hide();
                    })
                    return false;
                }
            });
        });

        $(document).on('change', '.brand_id', function() {
            $('.loading').show();
            var material_id = $(this).closest('tr').find('.material_id').val();
            var brand_id = $(this).val();
            getModel(material_id, brand_id);
        });

        function getModel(material_id,brand_id) {
            $.get('{{ route('getMaterialWiseModels') }}', {
                material_id: material_id,
                brand_id: brand_id,
            }, function(data) {
                var html = '';
                $.each(data, function(key, item) {
                    html += '<option value="' + item + '">' + item + '</option>';
                });
                $('#models').empty().append(html);
                $('.loading').hide();
            });
        }

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
