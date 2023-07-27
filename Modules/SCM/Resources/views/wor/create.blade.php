@extends('layouts.backend-layout')
@section('title', 'Work Order Receiving Report')

@php
    $is_old = old('supplier_name') ? true : false;
    $form_heading = !empty($work_order_receife) ? 'Update' : 'Add';
    $form_url = !empty($work_order_receife) ? route('work-order-receives.update', $work_order_receife->id) : route('work-order-receives.store');
    $form_method = !empty($work_order_receife) ? 'PUT' : 'POST';
    
    $branch_id = old('branch_id', !empty($work_order_receife) ? $work_order_receife->branch_id : null);
    $applied_date = old('date', !empty($work_order_receife) ? $work_order_receife->date : today()->format('d-m-Y'));
    $po_no = old('po_no', !empty($work_order_receife) ? $work_order_receife->purchaseOrder->po_no : null);
    $po_id = old('purchase_order_id', !empty($work_order_receife) ? $work_order_receife->purchase_order_id : null);
    $po_date = old('po_date', !empty($work_order_receife) ? $work_order_receife->purchaseOrder->date : null);
    $supplier_name = old('supplier_name', !empty($work_order_receife) ? $work_order_receife->supplier->name : null);
    $supplier_id = old('supplier_id', !empty($work_order_receife) ? $work_order_receife->supplier_id : null);
    
@endphp

@section('breadcrumb-title')
    {{ $form_heading }} WOR (Work Order Receive)
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
    <a href="{{ route('work-order-receives.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
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
            <label for="select2">Warehouse Name</label>
            <select class="form-control select2" id="branch_id" name="branch_id">
                <option value="0" selected>Select Branch</option>
                @foreach ($branches as $option)
                    <option value="{{ $option->id }}" {{ $branch_id == $option->id ? 'selected' : '' }}>
                        {{ $option->name }}
                    </option>
                @endforeach
            </select>
        </div>

        @if (!empty($work_order_receife->id))
            <div class="form-group col-3">
                <label for="wor_no">WOR No</label>
                <input type="text" class="form-control" id="wor_no" name="wor_no" aria-describedby="wor_no"
                    value="{{ old('wor_no') ?? ($work_order_receife->wor_no ?? '') }}" readonly>
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
    </div>

    <table class="table table-bordered" id="wor_table">
        <thead>
            <tr>
                <th>Material Name</th>
                <th>Model</th>
                <th>Brand</th>
                <th>Serial Code</th>
                <th>Unit</th>
                <th><i class="btn btn-primary btn-sm fa fa-plus add-wor-row"></i></th>
            </tr>
        </thead>
        <tbody>
            @php
                $lines = old('material_id', !empty($work_order_receife) ? $work_order_receife->lines->pluck('material_id') : []);
                $material_name = old('material_name', !empty($work_order_receife) ? $work_order_receife->lines->pluck('material.name') : []);
                $item_code = old('item_code', !empty($work_order_receife) ? $work_order_receife->lines->pluck('material.code') : []);
                $model = old('model', !empty($work_order_receife) ? $work_order_receife->lines->pluck('model') : []);
                $brand = old('brand', !empty($work_order_receife) ? $work_order_receife->lines->pluck('brand.name') : []);
                $brand_id = old('brand_id', !empty($work_order_receife) ? $work_order_receife->lines->pluck('brand_id') : []);
                $serial_code = old('serial_code', !empty($work_order_receife) ? $work_order_receife->lines->pluck('serial_code') : []);
                $unit = old('unit', !empty($work_order_receife) ? $work_order_receife->lines->pluck('material.unit') : []);
            @endphp

            @foreach ($lines as $line)
                <tr>
                    <td>
                        <input type="text" class="form-control material_name" id="material_name" name="material_name[]"
                            value="{{ $material_name[$loop->index] ?? '' }}" placeholder="Material Name">
                        <input type="hidden" class="form-control material_id" id="material_id" name="material_id[]"
                            value="{{ $lines[$loop->index] }}" placeholder="Material Name" readonly>
                        <input type="hidden" class="form-control item_code" id="item_code" name="item_code[]"
                            value="{{ $item_code[$loop->index] ?? '' }}" placeholder="Item Code" readonly>
                    </td>
                    <td>
                        <input type="text" class="form-control model" id="model" name="model[]"
                            value="{{ $model[$loop->index] ?? '' }}" placeholder="Model" readonly>
                    </td>
                    <td>
                        <input type="text" class="form-control brand" id="brand" name="brand[]"
                            value="{{ $brand[$loop->index] ?? '' }}" placeholder="Brand" readonly>
                        <input type="hidden" class="form-control brand_id" id="brand_id" name="brand_id[]"
                            value="{{ $brand_id[$loop->index] ?? '' }}" placeholder="Brand" readonly>
                    </td>
                    <td>
                        <input type="text" class="form-control serial_code" id="serial_code" name="serial_code[]"
                            value="{{ $serial_code[$loop->index] ?? '' }}" placeholder="Serial Code" readonly>
                    </td>
                    <td>
                        <input type="text" class="form-control unit" id="unit" name="unit[]"
                            value="{{ $unit[$loop->index] ?? '' }}" placeholder="Unit" readonly>
                    </td>
                    <td>
                        <i class="btn btn-danger btn-sm fa fa-trash remove-wor-row"></i>
                    </td>
                </tr>
            @endforeach
        </tbody>
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
    <script src="{{ asset('js/bootstrap-tagsinput.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.10.4/typeahead.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#po_no").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('search_po_with_date') }}",
                        type: 'get',
                        dataType: "json",
                        data: {
                            search: request.term,
                            po_type: 'Work Order'
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
                    return false;
                }
            })

            //using form custom function js file
            fillSelect2Options("{{ route('searchBranch') }}", '#branch_id');
            //using form custom function js file

            $('#applied_date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                showOtherMonths: true
            });

            @if (empty($work_order_receife) && empty(old('material_id')))
                appendDataRow();
            @endif
            function appendDataRow() {
                let row = `<tr>
                            <td>
                                <input type="text" name="material_name[]" class="form-control material_name" autocomplete="off">
                                <input type="hidden" name="material_id[]" class="form-control material_id" autocomplete="off">
                                <input type="hidden" name="item_code[]" class="form-control item_code" autocomplete="off"> 
                                <input type="hidden" name="material_type[]" class="form-control material_type" autocomplete="off"> 
                                <input type="hidden" name="receiveable_id[]" class="form-control receiveable_id" autocomplete="off"> 
                            </td>
                            <td class="form-group">
                                <input type="text" name="brand_name[]" class="form-control brand_name" autocomplete="off" readonly>
                                <input type="hidden" name="brand_id[]" class="form-control brand_id" autocomplete="off">
                            </td>                            
                            <td>
                                <input type="text" name="model[]" class="form-control model" autocomplete="off" readonly>
                            </td>
                            <td>
                                <input type="text" name="serial_code[]" class="form-control serial_code" autocomplete="off" readonly>
                            </td>
                            <td class="select2_container">
                                <input type="text" name="unit[]" class="form-control unit" autocomplete="off" readonly>
                            </td>
                            <td>
                                <i class="btn btn-danger btn-sm fa fa-minus remove-wor-row"></i>
                            </td>
                        </tr>
                    `;
                $('#wor_table tbody').append(row);
            }
            /* Adds and removes quantity row on click */
            $("#wor_table")
                .on('click', '.add-wor-row', () => {
                    appendDataRow();
                })
                .on('click', '.remove-wor-row', function() {
                    $(this).closest('tr').remove();
                });
        });

        $(document).on('keyup', '.material_name', function() {
            var event_this = $(this).closest('tr');
            let myObject = {
                po_id: $('#purchase_order_id').val(),
                @if (!empty($work_order_receife))
                    wor_id: {{ $work_order_receife->id }},
                @endif
            }
            jquaryUiAjax(this, "{{ route('searchSerialForWor') }}", uiList, myObject);

            function uiList(item) {
                event_this.find('.material_name').val(item.value);
                event_this.find('.material_id').val(item.material_id);
                event_this.find('.brand_name').val(item.brand_name);
                event_this.find('.brand_id').val(item.brand_id);
                event_this.find('.unit').val(item.unit);
                event_this.find('.serial_code').val(item.serial_code);
                event_this.find('.model').val(item.model);
                event_this.find('.item_code').val(item.item_code);
                event_this.find('.material_type').val(item.item_type);
                event_this.find('.receiving_date').val(item.receiving_date);
                event_this.find('.warranty_period').val(item.warranty_period);
                event_this.find('.remaining_days').val(item.remaining_days);
                event_this.find('.challan_no').val(item.challan_no);
                event_this.find('.receiveable_id').val(item.receiveable_id);
                return false;
            }
        })
    </script>
@endsection
