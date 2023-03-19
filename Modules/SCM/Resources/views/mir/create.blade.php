@extends('layouts.backend-layout')
@section('title', 'Material Issuing Report')

@php
    $is_old = old('supplier_name') ? true : false;
    $form_heading = !empty($materialReceive) ? 'Update' : 'Add';
    $form_url = !empty($materialReceive) ? route('material-receives.update', $materialReceive->id) : route('material-receives.store');
    $form_method = !empty($materialReceive) ? 'PUT' : 'POST';
    
    $branch_id = old('branch_id', !empty($materialReceive) ? $materialReceive->branch_id : null);
    $material_list = old('branch_id') ? old('select_array') : (!empty($materialReceive) ? $material_list : []);
    $applied_date = old('applied_date', !empty($materialReceive) ? $materialReceive->date : null);
    $mrs_no = old('mrs_no', !empty($materialReceive) ? $materialReceive->purchaseOrder->mrs_no : null);
    $po_id = old('po_id', !empty($materialReceive) ? $materialReceive->purchase_order_id : null);
    $po_date = old('po_date', !empty($materialReceive) ? $materialReceive->purchaseOrder->date : null);
    $supplier_name = old('supplier_name', !empty($materialReceive) ? $materialReceive->supplier->name : null);
    $supplier_id = old('supplier_id', !empty($materialReceive) ? $materialReceive->supplier_id : null);
    $challan_no = old('challan_no', !empty($materialReceive) ? $materialReceive->challan_no : null);
    $challan_date = old('challan_date', !empty($materialReceive) ? $materialReceive->challan_date : null);
    
@endphp

@section('breadcrumb-title')
    {{ $form_heading }} MIR (Material Issuing Report)
@endsection

@section('style')
    <style>
        .input-group-addon {
            min-width: 120px;
        }

        .input-group-info .input-group-addon {
            background-color: #04748a !important;
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
        @if (!empty($materialReceive->id))
            <div class="form-group col-3">
                <label for="mrr_no">MIR No</label>
                <input type="text" class="form-control" id="mrr_no" name="mrr_no" aria-describedby="mrr_no"
                    value="{{ old('mrr_no') ?? ($materialReceive->mrr_no ?? '') }}" readonly>
            </div>
        @endif

        <div class="form-group col-3">
            <label for="mrs_no">MRS No:</label>
            <input type="text" class="form-control" id="mrs_no" aria-describedby="mrs_no" name="mrs_no"
                value="{{ $mrs_no }}">
            <input type="hidden" class="form-control" id="purchase_order_id" name="purchase_order_id"
                aria-describedby="purchase_order_id" value="{{ $po_id }}">
        </div>

        <div class="form-group col-3">
            <label for="applied_date">Applied Date:</label>
            <input class="form-control applied_date" name="date" aria-describedby="applied_date"
                value="{{ $applied_date }}" readonly placeholder="Select a Date" id="applied_date">
        </div>

        <div class="form-group col-3">
            <label for="from_branch">From Branch:</label>
            <input type="text" class="form-control" id="from_branch" aria-describedby="from_branch" name="from_branch"
                value="{{ $mrs_no }}">
            <input type="hidden" class="form-control" id="from_branch_id" name="from_branch_id"
                aria-describedby="from_branch_id" value="{{ $po_id }}">
        </div>

        <div class="form-group col-3">
            <label for="to_branch">To Branch:</label>
            <input type="text" class="form-control" id="to_branch" aria-describedby="to_branch" name="to_branch"
                value="{{ $mrs_no }}">
            <input type="hidden" class="form-control" id="to_branch_id" name="to_branch_id"
                aria-describedby="to_branch_id" value="{{ $po_id }}">
        </div>

        <div class="form-group col-3">
            <label for="pop_name">POP Name:</label>
            <input type="text" class="form-control" id="pop_name" aria-describedby="pop_name" name="pop_name"
                value="{{ $mrs_no }}">
            <input type="hidden" class="form-control" id="pop_id" name="pop_id"
                aria-describedby="pop_id" value="{{ $po_id }}">
        </div>

        <div class="form-group col-3">
            <label for="courier_nmae">Courier Name:</label>
            <input type="text" class="form-control" id="courier_nmae" aria-describedby="courier_nmae" name="courier_nmae"
                value="{{ $mrs_no }}">
            <input type="hidden" class="form-control" id="courier_id" name="courier_id"
                aria-describedby="courier_id" value="{{ $po_id }}">
        </div>

        <div class="form-group col-3">
            <label for="courier_serial_no">Courier Seriel No:</label>
            <input type="text" class="form-control" id="courier_serial_no" aria-describedby="courier_serial_no" name="courier_serial_no"
                value="{{ $mrs_no }}">
        </div>

        <div class="form-group col-3">
            <label for="pop_address">POP Address:</label>
            <input type="text" class="form-control" id="pop_address" aria-describedby="pop_address" name="pop_address"
                value="{{ $mrs_no }}">
        </div>
    </div>

    <table class="table table-bordered" id="material_requisition">
        <thead>
            <tr>
                <th>Out From</th>
                <th>Description</th>
                <th>Material Name</th>
                <th>Opening Balance</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Serial/Drum Code <br /> No</th>
                <th>Initial Mark</th>
                <th>Final Mark</th>
                <th>Unit</th>
                <th>Issued Quantity</th>
                <th>Total Quantity</th>
                <th>Remarks</th>
                <th><i class="btn btn-primary btn-sm fa fa-plus add-requisition-row"></i></th>
            </tr>
        </thead>
        <tbody>
            @php
                $mrr_lines = old('material_id', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('material_id') : []);
                $material_id = old('material_id', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('material_id') : []);
                $item_code = old('item_code', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('material.code') : []);
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
                
                $quantity = old('quantity', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('quantity') : []);
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
                <tr>
                    <td>
                        <select name="out_from[]" class="form-control out_from" autocomplete="off">
                            <option value="">Select Out From</option>
                            @foreach ($out_from as $key1 => $value)
                                <option value="{{ $value }}" @selected($out_from[$key] == $value)>{{ $key1 }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td class="form-group">
                        <select class="form-control material_name" name="material_id[]">
                            <option value="" readonly selected>Select Material</option>
                            @foreach ($material_list as $key1 => $value)
                                <option value="{{ $value }}" readonly @selected($material_id[$key] == $value)>
                                    {{ $key1 }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="item_code[]" class="form-control item_code" autocomplete="off"
                            value="{{ $item_code[$key] }}">
                        <input type="hidden" name="material_type[]" class="form-control material_type"
                            autocomplete="off" value="{{ $material_type[$key] }}">
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
                        <input type="text" name="description[]" class="form-control description" autocomplete="off"
                            value="{{ $description[$key] }}">
                    </td>
                    <td>
                        <div class="tags_add_multiple">
                            <input class="" type="text" name="sl_code[]" value="{{ $sl_code[$key] }}"
                                data-role="tagsinput">
                        </div>
                    </td>

                    <td>
                        <input type="text" name="initial_mark[]" class="form-control initial_mark" autocomplete="off"
                            value="{{ $initial_mark[$key] }}">
                    </td>
                    <td>
                        <input type="text" name="final_mark[]" class="form-control final_mark" autocomplete="off"
                            value="{{ $final_mark[$key] }}">
                    </td>
                    <td>
                        <input type="text" name="warranty_period[]" class="form-control warranty_period"
                            autocomplete="off" value="{{ $warranty_period[$key] }}">
                    </td>
                    <td>
                        <input type="text" name="unit[]" class="form-control unit" autocomplete="off"
                            value="{{ $unit[$key] }}" readonly>
                    </td>
                    <td>
                        <input class="form-control quantity" name="quantity[]" aria-describedby="date"
                            value="{{ $quantity[$key] }}">
                    </td>
                    <td>
                        <input name="unit_price[]" class="form-control unit_price" autocomplete="off" readonly
                            value="10" value="{{ $unit_price[$key] }}">
                    </td>
                    <td>
                        <input name="amount[]" class="form-control amount" autocomplete="off" readonly
                            value="{{ $amount[$key] }}">
                    </td>
                    <td>
                        <i class="btn btn-danger btn-sm fa fa-minus remove-requisition-row"></i>
                    </td>
                </tr>
            @endforeach

        </tbody>
        <tfoot>
            <tr>
                <td colspan="11" class="text-right">Total Amount</td>
                <td>
                    <input type="text" name="total_amount" class="form-control total_amount" autocomplete="off"
                        value="{{ old('total_amount', !empty($materialReceive) ? $materialReceive->total_amount : 0) }}"
                        readonly>
                </td>
            </tr>
        </tfoot>
    </table>
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
    <script>
        /*****/
        const CSRF_TOKEN = "{{ csrf_token() }}";

        $(document).ready(function() {
            $("#mrs_no").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('search_po_with_date') }}",
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
                    $('#purchase_order_id').val(ui.item.value);
                    $('#mrs_no').val(ui.item.label);
                    $('#po_date').val(ui.item.date);
                    $('#supplier_id').val(ui.item.supplier_id);
                    $('#supplier_name').val(ui.item.supplier_name);
                    loadMateaials();
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
                appendCalculationRow();
            @endif
            function appendCalculationRow() {

                let row = `<tr>
                            <td>
                                <select name="out_from[]" class="form-control out_from" autocomplete="off">
                                    <option value="">Select Out From</option>
                                    @foreach ($out_from as $value)
                                        <option value="{{ $value }}">{{ strToUpper($value) }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" name="description[]" class="form-control description" autocomplete="off">
                            </td>
                            <td class="form-group">
                                <select class="form-control material_name" name="material_id[]">
                                    <option value="" readonly selected>Select Material</option>
                                   
                                </select>
                                <input type="hidden" name="item_code[]" class="form-control item_code" autocomplete="off"> 
                                <input type="hidden" name="material_type[]" class="form-control material_type" autocomplete="off"> 
                            </td>
                            <td>
                                <input type="text" name="description[]" class="form-control description" autocomplete="off">
                            </td>
                            <td>
                                <select name="brand_id[]" class="form-control brand" autocomplete="off">
                                    <option value="">Select Brand</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}">
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" name="description[]" class="form-control description" autocomplete="off">
                            </td>
                            <td>
                                <input type="text" name="initial_mark[]" class="form-control initial_mark" autocomplete="off" readonly>
                            </td>
                            <td>
                                <input type="number" name="final_mark[]" class="form-control final_mark" autocomplete="off" readonly>
                            </td>                        
                            <td>
                                <input type="number" name="warranty_period[]" class="form-control warranty_period" autocomplete="off">
                            </td>                        
                            <td>
                                <input name="unit[]" class="form-control unit" autocomplete="off" readonly>
                            </td>
                            <td>
                                <input class="form-control quantity" name="quantity[]" aria-describedby="date" value="{{ old('required_date') ?? (@$materialReceive->required_date ?? '') }}" >
                            </td>
                            <td>
                                <input name="unit_price[]" class="form-control unit_price" autocomplete="off" readonly value="10">
                            </td>
                            <td>
                                <input name="amount[]" class="form-control amount" autocomplete="off" readonly>
                            </td>
                            <td>
                                <i class="btn btn-danger btn-sm fa fa-minus remove-requisition-row"></i>
                            </td>
                        </tr>
                    `;
                $('#material_requisition tbody').append(row);
            }
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
                let purchase_order_id = $("#purchase_order_id").val();
                if (purchase_order_id) {
                    const url = '{{ url('scm/get_materials_for_po') }}/' + purchase_order_id;
                    let dropdown;

                    $('.material_name').each(function() {
                        dropdown = $(this).closest('tr').find('.material_name');
                    });
                    dropdown.empty();
                    dropdown.append('<option selected disabled>Select Material</option>');
                    dropdown.prop('selectedIndex', 0);

                    $.getJSON(url, function(items) {
                        $.each(items, function(key, data) {
                            dropdown.append($(`<option>Select Material</option>`)
                                .attr('value', data.material_id)
                                .text(data.material.name + " - " + data.material.code));
                        })
                    });
                }
            };
            $(document).on('change', '.material_name', function() {
                let material_id = $(this).closest('tr').find('.material_name').val();
                console.log();
                const url = '{{ url('scm/get_unit') }}/' + material_id;
                var elemmtn = $(this);
                (elemmtn).closest('tr').find('.final_mark').attr('readonly', true).val(null);
                (elemmtn).closest('tr').find('.initial_mark').attr('readonly', true).val(null);
                $.getJSON(url, function(item) {
                    (elemmtn).closest('tr').find('.unit').val(item.unit);
                    (elemmtn).closest('tr').find('.item_code').val(item.code);
                    (elemmtn).closest('tr').find('.material_type').val(item.type);
                    if (item.type == 'Drum') {
                        (elemmtn).closest('tr').find('.final_mark').attr('readonly', false);
                        (elemmtn).closest('tr').find('.initial_mark').attr('readonly', false);
                    }
                });
            })

            $(document).on('keyup', '.unit_price, .quantity', function() {
                var unit_price = $(this).closest('tr').find('.unit_price').val();
                var quantity = $(this).closest('tr').find('.quantity').val();
                var amount = unit_price * quantity;
                $(this).closest('tr').find('.amount').val(amount);
                calculateTotalAmount()

                //function for calculate total amount from all sub total amount
                function calculateTotalAmount() {
                    var final_total_amount = 0;
                    $('.amount').each(function() {
                        final_total_amount += parseFloat($(this).val());
                    });
                    $('.total_amount').val(final_total_amount.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }));
                }
            });

        })

        /*****/
    </script>
@endsection
