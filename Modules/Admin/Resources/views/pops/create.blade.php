@extends('layouts.backend-layout')
@section('title', 'POP')

@php
    $is_old = old('supplier_name') ? true : false;
    $form_heading = !empty($pop) ? 'Update' : 'Add';
    $form_url = !empty($pop) ? route('pops.update', $pop->id) : route('pops.store');
    $form_method = !empty($pop) ? 'PUT' : 'POST';
    
    $branch_id = old('branch_id', !empty($pop) ? $pop->branch_id : null);
    $applied_date = old('date', !empty($pop) ? $pop->date : today()->format('d-m-Y'));
    $name = old('name', !empty($pop) ? $pop->purchaseOrder->name : null);
    $po_id = old('purchase_order_id', !empty($pop) ? $pop->purchase_order_id : null);
    $po_date = old('po_date', !empty($pop) ? $pop->purchaseOrder->date : null);
    $supplier_name = old('supplier_name', !empty($pop) ? $pop->supplier->name : null);
    $supplier_id = old('supplier_id', !empty($pop) ? $pop->supplier_id : null);
    
@endphp

@section('breadcrumb-title')
    {{ $form_heading }} new POP
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
    <a href="{{ route('pops.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
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
        <div class="form-group col-3">
            <label for="name">POP name:</label>
            <input type="text" class="form-control" id="name" aria-describedby="name" name="name"
                value="{{ $name }}" autocomplete="off" required>
        </div>

        {{-- <div class="form-group col-3">
            <div class="form-item">
                <input type="text" name="link_name" id="link_name" class="form-control" value="{{ $name }}" required>
                <label for="link_name">Name of the link</label>
            </div>
        </div> --}}

        <x-input-box colGrid="3" name="link_name" value="{{ $name }}" label="Name of the link" class="text-danger" />

        <div class="form-group col-3">
            <label for="pop_type">POP Type:</label>
            <select class="form-control" id="pop_type" name="pop_type" required>
                <option value="" selected disabled>Select POP Type</option>
                @foreach (config('businessinfo.popType') as $key => $value)
                    <option value="{{ $key }}" {{ old('pop_type', !empty($pop) ? $pop->pop_type : null) == $key ? 'selected' : '' }}>
                        {{ $value }}</option>
                @endforeach
            </select>
        </div>


        <div class="form-group col-3">
            <label for="applied_date">Applied Date:</label>
            <input class="form-control applied_date" name="date" aria-describedby="applied_date"
                value="{{ $applied_date }}" readonly placeholder="Select a Date" id="applied_date">
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

            @if (empty($pop) && empty(old('material_id')))
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

    </script>
@endsection
