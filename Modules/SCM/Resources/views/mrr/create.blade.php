@extends('layouts.backend-layout')
@section('title', 'Material Receiving Report')

@php
    $is_old = old('supplier_name') ? true : false;
    $form_heading = !empty($materialReceive) ? 'Update' : 'Add';
    $form_url = !empty($materialReceive) ? route('material-receives.update', $materialReceive->id) : route('material-receives.store');
    $form_method = !empty($materialReceive) ? 'PUT' : 'POST';

    $branch_id = old('branch_id', !empty($materialReceive) ? $materialReceive->branch_id : null);
    $material_list = old('branch_id') ? old('select_array') : (!empty($materialReceive) ? $material_list : []);
    $applied_date = old('applied_date', !empty($materialReceive) ? $materialReceive->date : null);
    $po_no = old('po_no', !empty($materialReceive) ? $materialReceive->purchaseOrder->po_no : null);
    $po_id = old('purchase_order_id', !empty($materialReceive) ? $materialReceive->purchase_order_id : null);
    $po_date = old('po_date', !empty($materialReceive) ? $materialReceive->purchaseOrder->date : null);
    $supplier_name = old('supplier_name', !empty($materialReceive) ? $materialReceive->supplier->name : null);
    $supplier_id = old('supplier_id', !empty($materialReceive) ? $materialReceive->supplier_id : null);
    $challan_no = old('challan_no', !empty($materialReceive) ? $materialReceive->challan_no : null);
    $challan_date = old('challan_date', !empty($materialReceive) ? $materialReceive->challan_date : null);
    $bill_reg_no = old('bill_reg_no', !empty($materialReceive) ? $materialReceive->bill_reg_no : null);
    $bill_date = old('bill_date', !empty($materialReceive) ? $materialReceive->bill_date : null);
@endphp

@section('breadcrumb-title')
    {{ $form_heading }} MRR (Material Receiving Report)
@endsection

@section('style')
    <style>
        .input-group-addon {
            min-width: 120px;
        }

        .input-group-info .input-group-addon {
            background-color: #04748a !important;
        }

        .bootstrap-tagsinput {
            /* ... other properties ... */
            max-width: 200px !important;
            /* Ensure it doesn't exceed its container */
            display: flex !important;
            /* Use flex display */
            flex-wrap: wrap !important;
            /* Allow tags to wrap to the next line */
        }

        .bootstrap-tagsinput .tag {
            margin-bottom: 4px !important;
            /* Adjust spacing below tags */
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
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-tagsinput.css') }}">
@endsection
@section('breadcrumb-button')
    <a href="{{ route('material-receives.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')

    {!! Form::open([
        'url' => $form_url,
        'method' => $form_method,
        'encType' => 'multipart/form-data',
        'class' => 'custom-form',
    ]) !!}
    <div class="row">
        <div class="form-group col-3 warehouse_name">
            {{-- @dd($branches) --}}
            <label for="select2">Warehouse Name</label>
            <select class="form-control select2" id="branch_id" name="branch_id">
                <option value="0" selected>Select Branch</option>
                @foreach ($branches as $option)
                    <option value="{{ $option->id }}" {{ $branch_id == $option->id ? 'selected' : '' }}>
                        {{ $option->name ?? '' }}
                    </option>
                @endforeach
            </select>
        </div>

        @if (!empty($materialReceive->id))
            <div class="form-group col-3">
                <label for="mrr_no">MRR No</label>
                <input type="text" class="form-control" id="mrr_no" name="mrr_no" aria-describedby="mrr_no"
                    value="{{ old('mrr_no') ?? ($materialReceive->mrr_no ?? '') }}" readonly>
            </div>
            <div class="form-group col-6">
            </div>
        @else
            <div class="form-group col-8">
            </div>
        @endif

        <div class="form-group col-3">
            <label for="applied_date">Applied Date:</label>
            <input class="form-control applied_date" name="date" aria-describedby="applied_date"
                value="{{ $applied_date }}" readonly placeholder="Select a Date" id="applied_date">
        </div>

        <div class="form-group col-3">
            <label for="po_no">PO No:</label>
            <input type="text" class="form-control" id="po_no" aria-describedby="po_no" name="po_no"
                value="{{ $po_no }}" autocomplete="off">
            <input type="hidden" class="form-control" id="purchase_order_id" name="purchase_order_id"
                aria-describedby="purchase_order_id" value="{{ $po_id }}">
        </div>

        <div class="form-group col-3">
            <label for="date">PO Date:</label>
            <input class="form-control po_date" name="po_date" aria-describedby="po_date" id="po_date"
                value="{{ $po_date }}" readonly placeholder="PO Date">
        </div>

        <div class="form-group col-3 supplier_name">
            <label for="supplier_name">Supplier Name:</label>
            <input type="text" class="form-control supplier_name" aria-describedby="supplier_name" id="supplier_name"
                name="supplier_name" value="{{ $supplier_name }}" placeholder="Supplier Name" readonly>
            <input type="hidden" name="supplier_id" id="supplier_id" value="{{ $supplier_id }}">
        </div>

        <div class="form-group col-3 challan_no">
            <label for="challan_no">Chalan No:</label>
            <input type="text" class="form-control" id="challan_no" aria-describedby="challan_no" name="challan_no"
                value="{{ $challan_no }}" placeholder="Type Chalan No">
        </div>

        <div class="form-group col-3">
            <label for="date">Chalan Date:</label>
            <input class="form-control challan_date" name="challan_date" aria-describedby="challan_date" id="challan_date"
                value="{{ $challan_date }}" placeholder="Select a Date" readonly>
        </div>

        <div class="form-group col-3">
            <label for="bill_reg_no">Bill Register No:</label>
            <input type="text" class="form-control" id="bill_reg_no" aria-describedby="bill_reg_no" name="bill_reg_no"
                value="{{ $bill_reg_no }}" autocomplete="off">
        </div>

        <div class="form-group col-3">
            <label for="date">Bill Date:</label>
            <input class="form-control bill_date" name="bill_date" aria-describedby="bill_date" id="bill_date"
                value="{{ $bill_date }}" placeholder="Select a Date" readonly>
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
    <div class="table-responsive" @if (empty($materialReceive)) style="display: none;" @endif>
        <table class="table table-bordered" id="material_requisition">
            <thead>
                <tr>
                    <th>Material Name</th>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Description</th>
                    <th>Serial/Drum Code <br /> No</th>
                    <th id="initial_mark_head">Initial Mark</th>
                    <th id="final_mark_head">Final Mark</th>
                    <th>Warranty Period</th>
                    <th>Unit</th>
                    <th>Order Quantity</th>
                    <th>left Quantity</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $grand_total = 0;
                    $mrr_lines = old('material_id', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('material_id') : []);
                    $material_id = old('material_id', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('material_id') : []);
                    $item_code = old('item_code', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('material.code') : []);
                    $item_type = old('item_code', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('material.type') : []);
                    $material_type = old('item_code', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('material.type') : []);
                    $brand_id = old('brand_id', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('brand_id') : []);
                    $model = old('model', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('model') : []);
                    $description = old('description', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('description') : []);
                    $sl_code = old(
                        'sl_code',
                        !empty($materialReceive)
                            ? $materialReceive->scmMrrLines->map(function ($item) {
                                return implode(',', $item->scmMrrSerialCodeLines->pluck('serial_or_drum_key')->toArray());
                            })
                            : '',
                    );

                    $initial_mark = old('initial_mark', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('initial_mark') : []);
                    $final_mark = old('final_mark', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('final_mark') : []);
                    $warranty_period = old('warranty_period', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('warranty_period') : []);
                    $unit = old('unit', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('material.unit') : []);
                    $po_composit_key = old('po_composit_key', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('po_composit_key') : []);

                    $quantity = old('quantity', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('quantity') : []);
                    $order_quantity = old('order_quantity', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('order_quantity') : []);
                    $left_quantity = old('left_quantity', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('left_quantity') : []);
                    $unit_price = old('unit_price', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('unit_price') : []);
                    $amount = old(
                        'amount',
                        !empty($materialReceive)
                            ? collect($quantity)
                                ->map(function ($value, $key) use ($unit_price) {
                                    return $value * $unit_price[$key];
                                })
                                ->toArray()
                            : [],
                    );
                @endphp
                @foreach ($mrr_lines as $key => $requisitionDetail)
                    @php
                        if ($item_type[$key] == 'Drum') {
                            $max_tag = 1;
                        } else {
                            $max_tag = null;
                        }
                    @endphp
                    <tr>
                        <td class="form-group">
                            <select class="form-control material_name" name="material_id[]">
                                <option value="" readonly selected>Select Material</option>
                                @foreach ($material_list as $key1 => $value)
                                    <option value="{{ $value->material->id }}" data-unit="{{ $value->material->unit }}"
                                        data-type="{{ $value->material->type }}"
                                        data-code="{{ $value->material->code }}" readonly @selected($material_id[$key] == $value->material->id)>
                                        {{ $value->material->materialNameWithCode }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="item_code[]" class="form-control item_code" autocomplete="off"
                                value="{{ $item_code[$key] }}">
                            <input type="hidden" name="material_type[]" class="form-control material_type"
                                autocomplete="off" value="{{ $material_type[$key] }}">
                            <input type="hidden" name="po_composit_key[]" class="form-control po_composit_key"
                                autocomplete="off" value="{{ $po_composit_key[$key] }}">
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
                            <input type="text" name="description[]" class="form-control description"
                                autocomplete="off" value="{{ $description[$key] }}">
                        </td>
                        <td>
                            <div class="tags_add_multiple select2container">
                                <input class=".sl_code" type="text" name="sl_code[]" value="{{ $sl_code[$key] }}"
                                    data-role="tagsinput" data-max-tags="{{ $max_tag }}">
                            </div>
                        </td>

                        <td>
                            <input type="text" name="initial_mark[]" class="form-control initial_mark"
                                autocomplete="off" value="{{ $initial_mark[$key] ?? '' }}"
                                @if ($item_type[$key] == 'Drum') required @endif>
                        </td>
                        <td>
                            <input type="text" name="final_mark[]" class="form-control final_mark" autocomplete="off"
                                value="{{ $final_mark[$key] ?? '' }}" @if ($item_type[$key] == 'Drum') required @endif>
                        </td>
                        <td>
                            <input type="text" name="warranty_period[]" class="form-control warranty_period"
                                autocomplete="off" value="{{ $warranty_period[$key] }}" readonly>
                        </td>
                        <td>
                            <input type="text" name="unit[]" class="form-control unit" autocomplete="off"
                                value="{{ $unit[$key] }}" readonly />
                        </td>
                        <td>
                            <input class="form-control order_quantity" name="order_quantity[]" aria-describedby="date"
                                value="{{ $order_quantity[$key] }}" readonly>
                        </td>
                        <td>
                            <input class="form-control left_quantity" name="left_quantity[]" aria-describedby="date"
                                value="{{ $left_quantity[$key] }}" readonly>
                        </td>
                        <td>
                            <input class="form-control quantity" name="quantity[]" aria-describedby="date"
                                value="{{ $quantity[$key] }}">
                        </td>
                        <td>
                            <input type="text" name="unit_price[]" class="form-control unit_price" autocomplete="off"
                                readonly value="{{ $unit_price[$key] }}" readonly>
                        </td>
                        <td>
                            <input type="text" name="amount[]" class="form-control amount" autocomplete="off"
                                readonly value="{{ $amount[$key] }}" readonly>
                        </td>
                        <td>
                            <i class="btn btn-danger btn-sm fa fa-minus remove-requisition-row"></i>
                        </td>
                    </tr>
                    @php
                        $grand_total += $amount[$key];
                    @endphp
                @endforeach

            </tbody>
            <tfoot>
                <tr>
                    <td class="text-right" id="total_amount_first_row"
                        @if (!empty($materialReceive) && $item_type[0] == 'Drum') colspan="11" @else colspan="13" @endif>Total Amount</td>
                    <td>
                        <input type="text" name="total_amount" class="form-control total_amount" autocomplete="off"
                            value="{{ old('total_amount', !empty($materialReceive) ? $grand_total : 0) }}" readonly>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="row">
        <div class="offset-md-4 col-md-4 mt-2">
            <div class="input-group input-group-sm ">
                <button class="btn btn-success btn-round btn-block py-2">Submit</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section('script')
    <script src="{{ asset('js/bootstrap-tagsinput.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.10.4/typeahead.bundle.min.js"></script>

    <script>
        /*****/
        const CSRF_TOKEN = "{{ csrf_token() }}";

        $(document).ready(function() {
            $("#po_no").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('search_po_with_date') }}",
                        type: 'get',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term,
                            po_type: "Purchase Order"
                        },
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                select: function(event, ui) {
                    $('#purchase_order_id').val(ui.item.value);
                    $('#po_no').val(ui.item.label);
                    $('#po_date').val(ui.item.date);
                    $('#supplier_id').val(ui.item.supplier_id);
                    $('#supplier_name').val(ui.item.supplier_name);
                    loadMateaials();
                    return false;
                }
            })

            $("#bill_reg_no").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('searchBillRegisterNoWithDate') }}",
                        type: 'get',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term
                        },
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                select: function(event, ui) {
                    $('#bill_reg_no').val(ui.item.label);
                    $('#bill_date').val(ui.item.date);
                    return false;
                }
            })

            $('.select2').select2({
                maximumSelectionLength: 1
            });

            //using form custom function js file
            fillSelect2Options("{{ route('searchBranch') }}", '#branch_id');
            //using form custom function js file
            $('#challan_date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                showOtherMonths: true
            }).datepicker("setDate", new Date());
            $('#applied_date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                showOtherMonths: true
            }).datepicker("setDate", new Date());

            @if (empty($materialReceive) && empty(old('material_id')))
                // appendCalculationRow();
            @endif

            /* Adds and removes quantity row on click */
            $("#material_requisition")
                .on('click', '.add-requisition-row', () => {
                    appendCalculationRow();
                    loadMateaials();
                })
                .on('click', '.remove-requisition-row', function() {
                    $(this).closest('tr').remove();
                });

            function loadMateaials() {
                $('.loading').show();
                let purchase_order_id = $("#purchase_order_id").val();
                if (purchase_order_id) {
                    const url = '{{ url('scm/get_materials_for_po') }}/' + purchase_order_id;
                    let material_row = '';
                    let grand_total = 0;
                    $.getJSON(url, function(items) {
                        $.each(items, function(key, data) {
                            if (data.material.type == 'Drum') {
                                $('.tags_add_multiple').tagsinput('destroy');
                                $('#initial_mark_head').show();
                                $('#final_mark_head').show();
                                $('#total_amount_first_row').attr('colspan', 13);
                            } else {
                                $('#initial_mark_head').hide();
                                $('#final_mark_head').hide();
                                $('#total_amount_first_row').attr('colspan', 11);
                            }
                            material_row += `
                            <tr>
                                <td class="form-group">
                                    <input type="text" class="form-control" value="${data.material.name} - ${data.material.code}" readonly>
                                    <input type="hidden" name="material_id[]" class="form-control" value="${data.material.id}" readonly>
                                    <input type="hidden" name="item_code[]" class="form-control item_code" autocomplete="off" value="${data.material.code}">
                                    <input type="hidden" name="material_type[]" class="form-control material_type" autocomplete="off" value="${data.material.type}">
                                    <input type="hidden" name="po_composit_key[]" class="form-control po_composit_key" autocomplete="off" value="${data.po_composit_key}">
                                </td>
                                <td>
                                    <input type="text" name="brand_name[]" class="form-control brand" autocomplete="off" value="${data.brand.name}" readonly>
                                    <input type="hidden" name="brand_id[]" class="form-control brand" autocomplete="off" value="${data.brand.id}">
                                </td>
                                <td>
                                    <input type="text" name="model[]" class="form-control model" autocomplete="off" value="${data.model}" readonly>
                                </td>
                                <td>
                                    <input type="text" name="description[]" class="form-control description" autocomplete="off" value="${data.description ?? ''}" readonly>
                                </td>
                                <td>
                                    <div class="tags_add_multiple select2container">
                                        <input class="sl_code" type="text" name="sl_code[]" value="" data-role="tagsinput" readonly>
                                    </div>
                                </td>
                                ${data.material.type == 'Drum' ? `
                                                                                                                                                        <td>
                                                                                                                                                            <input type="text" name="initial_mark[]" class="form-control initial_mark" autocomplete="off" readonly>
                                                                                                                                                        </td>
                                                                                                                                                        ` : ''}
                                ${data.material.type == 'Drum' ? `
                                                                                                                                                    <td>
                                                                                                                                                        <input type="text" name="final_mark[]" class="form-control final_mark" autocomplete="off" readonly>
                                                                                                                                                    </td>
                                                                                                                                                        ` : ''}

                                <td>
                                    <input type="text" name="warranty_period[]" class="form-control warranty_period" autocomplete="off" value="${data.warranty_period ?? 0}" readonly>
                                </td>
                                <td>
                                    <input name="unit[]" class="form-control unit" autocomplete="off" value="${data.material.unit ?? ''}" readonly>
                                </td>
                                <td>
                                    <input class="form-control quantity" name="order_quantity[]" aria-describedby="date" value="${data.quantity}" readonly>
                                </td>
                                <td>
                                    <input class="form-control left_quantity" name="left_quantity[]" aria-describedby="date" value="${data.left_quantity}" readonly>
                                </td>
                                <td>
                                    <input class="form-control quantity" name="quantity[]" aria-describedby="date" value="" ${data.left_quantity == 0 ? 'readonly' : ''}>
                                </td>
                                <td>
                                    <input name="unit_price[]" class="form-control unit_price" autocomplete="off" value="${data.unit_price}" readonly>
                                </td>
                                <td>
                                    <input name="amount[]" class="form-control amount" autocomplete="off" value="" readonly>
                                </td>
                                <td>
                                    <i class="btn btn-danger btn-sm fa fa-minus remove-requisition-row"></i>
                                </td>
                            </tr>`;
                        })
                        $('#material_requisition tbody').html(material_row);
                        $(".sl_code").tagsinput();
                        // $('.total_amount').val(grand_total);
                        $('.loading').hide();
                        $('.table-responsive').show();
                    });

                }
            };

            function calculateTotalAmount() {
                var final_total_amount = 0;
                $('.amount').each(function() {
                    final_total_amount += parseFloat($(this).val()) || 0;
                });
                $('.total_amount').val(final_total_amount.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }));
            }

            $(document).on('keyup', '.quantity', function() {
                var quantity = $(this).val();
                var left_quantity = $(this).closest('tr').find('.left_quantity').val();
                if (parseFloat(quantity) > parseFloat(left_quantity)) {
                    alert('Quantity can not be greater than left quantity');
                    $(this).val(left_quantity);
                }
                var unit_price = $(this).closest('tr').find('.unit_price').val();
                var amount = parseFloat(unit_price) * parseFloat(quantity);
                amount = amount != 'NaN' ? amount : 0;
                $(this).closest('tr').find('.amount').val(amount)
                calculateTotalAmount();
            })
        })
    </script>
@endsection
