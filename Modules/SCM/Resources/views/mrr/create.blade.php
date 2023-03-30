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
            background-color: #04748a!important;
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
            <label for="select2">Warehouse Name</label>
            <select class="form-control select2" id="branch_id" name="branch_id">
                <option value="0" selected>Select Branch</option>
                @foreach ($branches as $option)
                    <option value="{{ $option->id }}"
                        {{ $branch_id == $option->id ? 'selected' : '' }}>
                        {{ $option->name }}
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
            <input type="text" class="form-control" id="po_no" aria-describedby="po_no"
                name="po_no"
                value="{{ $po_no }}" autocomplete="off">
                <input type="hidden" class="form-control" id="purchase_order_id" name="purchase_order_id" aria-describedby="purchase_order_id"
                value="{{ $po_id }}">
        </div>
       
        <div class="form-group col-3">
            <label for="date">PO Date:</label>
            <input class="form-control po_date" name="po_date" aria-describedby="po_date" id="po_date"
                value="{{ $po_date }}" readonly placeholder="PO Date">
        </div>
       
        <div class="form-group col-3 supplier_name">
            <label for="supplier_name">Supplier Name:</label>
            <input type="text" class="form-control supplier_name" aria-describedby="supplier_name" id="supplier_name"
                name="supplier_name" value="{{ $supplier_name }}"
                placeholder="Supplier Name" readonly>
            <input type="hidden" name="supplier_id" id="supplier_id"
                value="{{ $supplier_id }}">
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
    </div>
   
    <table class="table table-bordered" id="material_requisition">
        <thead>
            <tr>
                <th>Material Name</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Description</th>
                <th>Serial/Drum Code <br/> No</th>
                <th>Initial Mark</th>
                <th>Final Mark</th>
                <th>Warranty Period</th>
                <th>Unit</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Amount</th>
                <th><i class="btn btn-primary btn-sm fa fa-plus add-requisition-row"></i></th>
            </tr>
        </thead>
        <tbody>
        @php
            $mrr_lines = old('material_id', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('material_id') : []);
            $material_id = old('material_id', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('material_id') : []);
            $item_code = old('item_code', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('material.code') : []);
            $item_type = old('item_code', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('material.type') : []);
            $material_type = old('item_code', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('material.type') : []);
            $brand_id = old('brand_id', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('brand_id') : []);
            $model = old('model', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('model') : []);
            $description = old('description', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('description') : []);
            $sl_code = old('sl_code', !empty($materialReceive) ? $materialReceive->scmMrrLines->map(function ($item) {
                return implode(',', $item->scmMrrSerialCodeLines->pluck('serial_or_drum_key')->toArray());
            }) : '');
          
            $initial_mark = old('initial_mark', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('initial_mark') : []);
            $final_mark = old('final_mark', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('final_mark') : []);
            $warranty_period = old('warranty_period', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('warranty_period') : []);
            $unit = old('unit', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('material.unit') : []);
            $po_composit_key = old('po_composit_key', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('po_composit_key') : []);
           
            $quantity = old('quantity', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('quantity') : []);
            $unit_price = old('unit_price', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('unit_price') : []);
            $amount = old('amount', !empty($materialReceive) ? collect($quantity)->map(function ($value, $key) use ($unit_price) {
                    return $value * $unit_price[$key];
                })->toArray() : []);
        @endphp 
            @foreach ($mrr_lines as $key => $requisitionDetail)
                @php
                    if($item_type[$key] == "Drum"){
                        $max_tag = 1;
                    }else{
                        $max_tag = null;
                    }
                @endphp
                <tr>
                    <td class="form-group">
                        <select class="form-control material_name" name="material_id[]">
                            <option value="" readonly selected>Select Material</option>
                            @foreach ($material_list as $key1 => $value )
                            <option value="{{$value->material->id}}" data-unit="{{$value->material->unit}}" data-type="{{$value->material->type}}" data-code="{{$value->material->code}}" readonly @selected($material_id[$key] == $value->material->id)>{{$value->material->materialNameWithCode}}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="item_code[]" class="form-control item_code" autocomplete="off" value="{{ $item_code[$key]  }}"> 
                        <input type="hidden" name="material_type[]" class="form-control material_type" autocomplete="off" value="{{ $material_type[$key]  }}"> 
                        <input type="hidden" name="po_composit_key[]" class="form-control po_composit_key" autocomplete="off" value="{{ $po_composit_key[$key]  }}"> 
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
                        <input type="text" name="model[]" class="form-control model" autocomplete="off" value="{{ $model[$key]  }}">
                    </td>
                    <td>
                        <input type="text" name="description[]" class="form-control description" autocomplete="off" value="{{ $description[$key]  }}">
                    </td>
                    <td>
                        <div class="tags_add_multiple">
                            <input class="" type="text" name="sl_code[]" value="{{$sl_code[$key]}}" data-role="tagsinput" data-max-tags="{{ $max_tag }}">
                        </div>
                    </td>

                    <td>
                        <input type="text" name="initial_mark[]" class="form-control initial_mark" autocomplete="off" value="{{ $initial_mark[$key]  }}">
                    </td>
                    <td>
                        <input type="text" name="final_mark[]" class="form-control final_mark" autocomplete="off" value="{{ $final_mark[$key]  }}">
                    </td>
                    <td>
                        <input type="text" name="warranty_period[]" class="form-control warranty_period" autocomplete="off" value="{{ $warranty_period[$key]  }}">
                    </td>
                    <td>
                        <input type="text" name="unit[]" class="form-control unit" autocomplete="off" value="{{ $unit[$key]  }}" readonly>
                    </td>
                    <td>
                        <input class="form-control quantity" name="quantity[]" aria-describedby="date" value="{{ $quantity[$key] }}" >
                    </td>
                    <td>
                        <input name="unit_price[]" class="form-control unit_price" autocomplete="off" readonly value="10" value="{{ $unit_price[$key] }}">
                    </td>
                    <td>
                        <input name="amount[]" class="form-control amount" autocomplete="off" readonly value="{{ $amount[$key] }}">
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
                    $('#purchase_order_id').val(ui.item.value);
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
                            <td class="form-group">
                                <select class="form-control material_name" name="material_id[]">
                                    <option value="" readonly selected>Select Material</option>
                                   
                                </select>
                                <input type="hidden" name="item_code[]" class="form-control item_code" autocomplete="off"> 
                                <input type="hidden" name="material_type[]" class="form-control material_type" autocomplete="off"> 
                                <input type="hidden" name="po_composit_key[]" class="form-control po_composit_key" autocomplete="off"> 
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
                                <input type="text" name="description[]" class="form-control description" autocomplete="off">
                            </td>
                            <td>
                                <div class="tags_add_multiple">
                                    <input class="" type="text" name="sl_code[]" value="111" data-role="tagsinput">
                                </div>
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
                                <input name="unit_price[]" class="form-control unit_price" autocomplete="off" readonly>
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
                                .attr('data-code', data.material.code)
                                .attr('data-type', data.material.type)
                                .attr('data-unit', data.material.unit)
                                .text(data.material.name + " - " + data.material.code));
                        })
                    });

                    
                }
            };
        $(document).on('change','.material_name',function(){
            let material_id = $(this).closest('tr').find('.material_name').val();
            let code = $(this).find(':selected').data('code');
            let type = $(this).find(':selected').data('type');
            let unit = $(this).find(':selected').data('unit');
            var elemmtn = $(this);
            (elemmtn).closest('tr').find('.final_mark').attr('readonly',true).val(null);
            (elemmtn).closest('tr').find('.initial_mark').attr('readonly',true).val(null);
                (elemmtn).closest('tr').find('.unit').val(unit);
                (elemmtn).closest('tr').find('.item_code').val(code);
                (elemmtn).closest('tr').find('.material_type').val(type);

                if(type == 'Drum'){
                    (elemmtn).closest('tr').find('.final_mark').attr('readonly',false);
                    (elemmtn).closest('tr').find('.initial_mark').attr('readonly',false);
                    (elemmtn).closest('tr').find('input[data-role="tagsinput"]').tagsinput('destroy');
                    (elemmtn).closest('tr').find('input[data-role="tagsinput"]').tagsinput({
                            maxTags: 1
                        });
                    }else{
                    (elemmtn).closest('tr').find('input[data-role="tagsinput"]').tagsinput('destroy');
                    (elemmtn).closest('tr').find('input[data-role="tagsinput"]').tagsinput({
                        });
                    }
            })


            $(document).on('change','.brand',function(){
            let material_id = $(this).closest('tr').find('.material_name').val();
            let brand_id = $(this).closest('tr').find('.brand').val();
            let purchase_order_id = $("#purchase_order_id").val();

            const url = '{{ url('scm/get_pocomposite_with_price') }}/' + purchase_order_id + '/' + material_id + '/' + brand_id;
            var elemmtn = $(this);
            (elemmtn).closest('tr').find('.unit_price').val(null);
            (elemmtn).closest('tr').find('.po_composit_key').val(null);
           
            $.getJSON(url, function(item) {
                if(item.length){
                    (elemmtn).closest('tr').find('.unit_price').val(item[0].unit_price);
                    (elemmtn).closest('tr').find('.po_composit_key').val(item[0].po_composit_key);
                    var maxTags = 1; // maximum number of tags allowed
                   
                }else{
                    alert('No po is given for this Brand of that material');
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
