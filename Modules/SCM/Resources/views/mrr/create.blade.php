@extends('layouts.backend-layout')
@section('title', 'Material Receiving Report')

@php
    $is_old = old('supplier_name') ? true : false;
    $form_heading = !empty($purchase_order->id) ? 'Update' : 'Add';
    $form_url = !empty($purchase_order->id) ? route('material-receiving-reports.update', $purchase_order->id) : route('material-receiving-reports.store');
    $form_method = !empty($purchase_order->id) ? 'PUT' : 'POST';
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
            /*background-color: #04748a!important;*/
        }
        
    </style>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-tagsinput.css') }}">
@endsection
@section('breadcrumb-button')
    <a href="{{ route('material-receiving-reports.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
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
                    <select class="form-control select2" id="warehouse_id" name="warehouse_id">
                        <option value="0" selected>Select Branch</option>
                       
                    </select>
        </div>
      
        @if (!empty($purchaseOrder->id))
        <div class="form-group col-3">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="po_no">PO No <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="po_no" name="po_no" aria-describedby="po_no"
                    value="{{ old('po_no') ?? ($purchaseOrder->po_no ?? '') }}">
               
            </div>
        </div>
        <div class="form-group col-6">
        </div>
        @else
        <div class="form-group col-8">
        </div>
        @endif
        <div class="form-group col-3 mrr_no">
            <label for="mrr_no">MRR No:</label>
            <input type="text" class="form-control" id="mrr_no" aria-describedby="mrr_no"
                name="warehouse_id"
                value="{{ old('warehouse_id') ?? (@$purchaseOrder->delivery_location ?? '') }}">
        </div>
        <div class="form-group col-3">
            <label for="applied_date">Applied Date:</label>
            <input class="form-control applied_date" name="applied_date" aria-describedby="applied_date"
                value="{{ old('applied_date') ?? (@$purchaseOrder->applied_date ?? '') }}" readonly placeholder="Select a Date">
        </div>

        <div class="form-group col-3">
            <label for="po_no">PO No:</label>
            <input type="text" class="form-control" id="po_no" aria-describedby="po_no"
                name="po_no"
                value="{{ old('delivery_location') ?? (@$purchaseOrder->delivery_location ?? '') }}">
                <input type="hidden" class="form-control" id="po_id" name="po_id" aria-describedby="po_id"
                value="{{ old('po_id') ?? ($purchaseOrder->po_id ?? '') }}">
        </div>
        <div class="form-group col-3">
            <label for="date">PO Date:</label>
            <input class="form-control po_date" name="po_date" aria-describedby="po_date" id="po_date"
                value="{{ old('po_date') ?? (@$purchaseOrder->po_date ?? '') }}" readonly placeholder="PO Date">
        </div>
        <div class="form-group col-3 supplier_name">
            <label for="supplier_name">Supplier Name:</label>
            <input type="text" class="form-control supplier_name" aria-describedby="supplier_name" id="supplier_name"
                name="supplier_name" value="{{ old('supplier_name') ?? (@$purchaseOrder->supplier->name ?? '') }}"
                placeholder="Supplier Name" readonly>
            <input type="hidden" name="supplier_id" id="supplier_id"
                value="{{ old('supplier_id') ?? @$purchaseOrder?->supplier_id }}">
        </div>

        <div class="form-group col-3 chalan_no">
            <label for="chalan_no">Chalan No:</label>
            <input type="text" class="form-control" id="chalan_no" aria-describedby="chalan_no" name="chalan_no"
                value="{{ old('chalan_no') ?? (@$purchaseOrder->indent->indent_no ?? '') }}" placeholder="Search...">
            <input type="hidden" name="chalan_no" id="chalan_no"
                value="{{ old('chalan_no') ?? @$purchaseOrder?->chalan_no }}">
        </div>

        <div class="form-group col-3">
            <label for="date">Chalan Date:</label>
            <input class="form-control chalan_date" name="chalan_date" aria-describedby="chalan_date" id="chalan_date"
                value="{{ old('chalan_date') ?? (@$purchaseOrder->chalan_date ?? '') }}" placeholder="Select a Date" readonly>
        </div>
    </div>

    <table class="table table-bordered" id="material_requisition">
        <thead>
            <tr>
                <th>Material Name</th>
                <th>Description</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Serial/Drum Code <br/> No</th>
                <th>Initial Mark</th>
                <th>Final Mark</th>
                <th>Item Code</th>
                <th>Unit</th>
                <th>Quantity</th>
                <th><i class="btn btn-primary btn-sm fa fa-plus add-requisition-row"></i></th>
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot>
            @php
                $purchase_requisition_id = old('purchase_requisition_id', !empty($purchaseOrder) ? $purchaseOrder->scmPurchaseRequisition->pluck('prs_no') : []);
                $material_name_with_code = old('material_name', !empty($purchaseOrder) ? $purchaseOrder->scmPurchaseRequisitionDetails->pluck('material.materialNameWithCode') : []);
                $material_id = old('material_id', !empty($purchaseOrder) ? $purchaseOrder->scmPurchaseRequisitionDetails->pluck('material_id') : []);
                $item_code = old('item_code', !empty($purchaseOrder) ? $purchaseOrder->scmPurchaseRequisitionDetails->pluck('material.code') : []);
                $unit = old('unit', !empty($purchaseOrder) ? $purchaseOrder->scmPurchaseRequisitionDetails->pluck('material.unit') : []);
                $brand_id = old('brand_id', !empty($purchaseOrder) ? $purchaseOrder->scmPurchaseRequisitionDetails->pluck('brand_id') : []);
                $quantity = old('quantity', !empty($purchaseOrder) ? $purchaseOrder->scmPurchaseRequisitionDetails->pluck('quantity') : []);
                $unit_price = old('unit_price', !empty($purchaseOrder) ? $purchaseOrder->scmPurchaseRequisitionDetails->pluck('unit_price') : []);
                $total_amount = old('total_amount', !empty($purchaseOrder) ? $purchaseOrder->scmPurchaseRequisitionDetails->pluck('total_amount') : []);
                $model = old('model', !empty($purchaseOrder) ? $purchaseOrder->scmPurchaseRequisitionDetails->pluck('model') : []);
                $purpose = old('purpose', !empty($purchaseOrder) ? $purchaseOrder->scmPurchaseRequisitionDetails->pluck('purpose') : []);
            @endphp
            @foreach ($material_name_with_code as $key => $requisitionDetail)
                <tr>
                    <td class="form-group">
                        <select class="form-control purchase_requisition_id" name="purchase_requisition_id[]">
                            <option value="" readonly selected>Select Requisiiton</option>
                            
                        </select>
                    </td>

                    <td>
                        <input type="text" class="form-control cs_no" aria-describedby="cs_no" name="cs_no[]"
                            value="{{ old('cs_no') ?? (@$purchaseOrder->client->name ?? '') }}" placeholder="Search...">
                        <input type="hidden" name="cs_id[]" class="form-control cs_id"
                            value="{{ old('cs_id') ?? @$purchaseOrder?->client->id }}">
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
                        <input type="text" name="quatation_no[]" class="form-control quatation_no" autocomplete="off">
                    </td>

                    <td>
                        <input type="text" name="description[]" class="form-control description" autocomplete="off">
                    </td>

                    <td>
                        <input type="text" name="unit[]" class="form-control unit" autocomplete="off" readonly>
                    </td>

                    <td>
                        <input type="number" name="quantity[]" class="form-control quantity" autocomplete="off">
                    </td>

                    <td>
                        <input type="text" name="warranty_period[]" class="form-control warranty_period"
                            autocomplete="off">
                    </td>

                    <td>
                        <input type="number" name="brand[]" class="form-control unit_price" autocomplete="off"
                            readonly>
                    </td>
                    <td>
                        <input class="form-control quantity" name="quantity[]" aria-describedby="date"
                            value="{{ old('required_date') ?? (@$purchaseOrder->required_date ?? '') }}"
                            placeholder="Select a required date">
                    </td>
                    <td>
                        <i class="btn btn-danger btn-sm fa fa-minus remove-requisition-row"></i>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="9" class="text-right">Total Amount</td>
                <td>
                    <input type="text" name="total_amount" class="form-control total_amount" autocomplete="off"
                        value="{{ old('total_amount', !empty($purchaseOrder) ? $purchaseOrder->total_amount : 0) }}"
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
                            search: request.term
                        },
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                select: function(event, ui) {
                    $('#po_id').val(ui.item.value);
                    $('#po_no').val(ui.item.label);
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
            fillSelect2Options("{{ route('searchBranch') }}", '#warehouse_id');
            //using form custom function js file
            $('#chalan_date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                showOtherMonths: true
            }).datepicker("setDate", new Date());

            @if (empty($purchaseOrder) && empty(old('material_name')))
            appendCalculationRow();
        @endif
        function appendCalculationRow() {
            
            let row = `<tr>
                            <td class="form-group">
                                <select class="form-control material_name" name="material_name[]">
                                    <option value="" readonly selected>Select Material</option>
                                   
                                </select>
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
                                <input type="text" name="model[]" class="form-control model" autocomplete="off"> 
                            </td>

                            <td>
                                <div class="tags_add_multiple">
                                    <input class="" type="text" name="sl_code[]" value="Amsterdam,Washington,Sydney" data-role="tagsinput">
                                </div>
                            </td>

                            <td>
                                <input type="text" name="initial_mark[]" class="form-control initial_mark" autocomplete="off" readonly>
                            </td>

                            <td>
                                <input type="number" name="final_mark[]" class="form-control final_mark" autocomplete="off" readonly>
                            </td>

                            <td>
                                <input type="text" name="item_code[]" class="form-control item_code" autocomplete="off"> 
                            </td>
                            
                            <td>
                                <input name="unit[]" class="form-control unit" autocomplete="off" readonly>
                            </td>
                            <td>
                                <input class="form-control quantity" name="quantity[]" aria-describedby="date" value="{{ old('required_date') ?? (@$purchaseOrder->required_date ?? '') }}" >
                            </td>
                            <td>
                                <i class="btn btn-danger btn-sm fa fa-minus remove-requisition-row"></i>
                            </td>
                        </tr>
                    `;
            $('#material_requisition tbody').append(row);
            $('input[data-role="tagsinput"]').tagsinput({
            });
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
                let po_id = $("#po_id").val();
                if (po_id) {
                    const url = '{{ url('scm/get_materials_for_po') }}/' + po_id;
                    let dropdown;+

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
                                .text(data.material.name));
                        })
                    });
                }
            };
        $(document).on('change','.material_name',function(){
            let material_id = $(this).closest('tr').find('.material_name').val();
            const url = '{{ url('scm/get_unit') }}/' + material_id;
            var elemmtn = $(this);
            (elemmtn).closest('tr').find('.final_mark').attr('readonly',true);
            (elemmtn).closest('tr').find('.initial_mark').attr('readonly',true);
            $.getJSON(url, function(item) {
                (elemmtn).closest('tr').find('.unit').val(item.unit)
                if(item.type == 'Drum'){
                    (elemmtn).closest('tr').find('.final_mark').attr('readonly',false);
                    (elemmtn).closest('tr').find('.initial_mark').attr('readonly',false);
                    }
                });
            })
            
        })
        
        /*****/
    </script>
@endsection
