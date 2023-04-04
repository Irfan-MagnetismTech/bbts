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
                value="{{ $mrs_no }}" placeholder="Ex: MRS-####-##">
            <input type="hidden" class="form-control" id="scm_requisition_id" name="scm_requisition_id"
                aria-describedby="scm_requisition_id" value="{{ $po_id }}">
        </div>

        <div class="form-group col-3">
            <label for="applied_date">Applied Date:</label>
            <input class="form-control applied_date" name="date" aria-describedby="applied_date"
                value="{{ $applied_date }}" readonly placeholder="Select a Date" id="applied_date">
        </div>

        <div class="form-group col-3">
            <label for="from_branch">From Branch:</label>
            <input type="text" class="form-control branch" id="from_branch" aria-describedby="from_branch"
                name="from_branch" value="{{ $mrs_no }}" placeholder="Search Branch....">
            <input type="hidden" class="form-control branch_id" id="from_branch_id" name="from_branch_id"
                aria-describedby="from_branch_id" value="{{ $po_id }}">
        </div>

        <div class="form-group col-3">
            <label for="to_branch">To Branch:</label>
            <input type="text" class="form-control branch" id="to_branch" aria-describedby="to_branch" name="to_branch"
                value="{{ $mrs_no }}" placeholder="Search Branch....">
            <input type="hidden" class="form-control branch_id" id="to_branch_id" name="to_branch_id"
                aria-describedby="to_branch_id" value="{{ $po_id }}">
        </div>

        <div class="form-group col-3">
            <label for="pop_name">POP Name:</label>
            <input type="text" class="form-control pop_name" name="pop_name" value="{{ $mrs_no }}"
                placeholder="Search POP....">
            <input type="hidden" class="form-control pop_id" id="pop_id" name="pop_id" aria-describedby="pop_id"
                value="{{ $po_id }}">
        </div>

        <div class="form-group col-3">
            <label for="pop_address">POP Address:</label>
            <input type="text" class="form-control" id="pop_address" aria-describedby="pop_address" name="pop_address"
                value="{{ $mrs_no }}" readonly>
        </div>

        <div class="form-group col-3">
            <label for="courier_nmae">Courier Name:</label>
            <input type="text" class="form-control" id="courier_nmae" aria-describedby="courier_nmae" name="courier_nmae"
                value="{{ $mrs_no }}" placeholder="Search Courier....">
            <input type="hidden" class="form-control" id="courier_id" name="courier_id" aria-describedby="courier_id"
                value="{{ $po_id }}">
        </div>

        <div class="form-group col-3">
            <label for="courier_serial_no">Courier Seriel No:</label>
            <input type="text" class="form-control" id="courier_serial_no" aria-describedby="courier_serial_no"
                name="courier_serial_no" value="{{ $mrs_no }}" placeholder="Search Courier No....">
        </div>
    </div>

    <table class="table table-bordered" id="material_requisition">
        <thead>
            <tr>
                <th>Received Type</th>
                <th>Type No</th>
                <th>Material Name</th>
                {{-- <th>Opening Balance</th> --}}
                <th>Brand</th>
                <th>Model</th>
                <th>Serial Code</th>
                <th>Unit</th>
                <th>Avaliable Qty</th>
                <th>Issued Qty</th>
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
                        <select name="received_type[]" class="form-control received_type" autocomplete="off">
                            <option value="">Select Out From</option>
                            @foreach ($received_type as $key1 => $value)
                                <option value="{{ $value }}" @selected($received_type[$key] == $value)>{{ $key1 }}
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
                        url: "{{ route('search_mrs_no') }}",
                        type: 'get',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term
                        },
                        success: function(data) {
                            if (data.length > 0) {
                                response(data);
                            } else {
                                response([{
                                    label: 'No Result Found',
                                    value: -1,
                                }]);
                            }
                        }
                    });
                },
                select: function(event, ui) {
                    if (ui.item.value == -1) {
                        $(this).val('');
                        return false;
                    }

                    $('#scm_requisition_id').val(ui.item.scm_requisition_id);
                    $('#mrs_no').val(ui.item.label);

                    return false;
                }
            })

            $('#mrs_no').on('change', function() {
                $('#material_requisition tbody').empty();
                appendCalculationRow();
            })

            $(".branch").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('searchBranch') }}",
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
                    $(this).val(ui.item.label);
                    $(this).closest('div').find('.branch_id').val(ui.item.id);
                    return false;
                }
            })

            $(".pop_name").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('searchPop') }}",
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
                    $(this).val(ui.item.label);
                    $(this).closest('div').find('.pop_id').val(ui.item.id);
                    $('#pop_address').val(ui.item.address);
                    return false;
                }
            })

            $('.select2').select2({
                maximumSelectionLength: 1
            });

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
                                <select name="received_type[]" class="form-control received_type" autocomplete="off">
                                    <option value="">Select Out From</option>
                                    @foreach ($received_type as $value)
                                        <option value="{{ $value }}">{{ strToUpper($value) }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" name="type_no[]" class="form-control type_no" autocomplete="off">
                                <input type="hidden" name="type_id[]" class="form-control type_id" autocomplete="off">
                            </td>
                            <td class="form-group">
                                <select class="form-control material_name select2" name="material_name[]">
                                </select>
                                <input type="hidden" name="item_code[]" class="form-control item_code" autocomplete="off"> 
                                <input type="hidden" name="material_type[]" class="form-control material_type" autocomplete="off"> 
                            </td>                            
                            <td>
                                <select class="form-control brand select2" name="brand[]">
                                </select>
                            </td>
                            <td>
                                <select class="form-control model select2" name="model[]">
                                </select>
                            </td>
                            <td>
                                <select class="form-control serial_code select2" name="serial_code[]" multiple="multiple">

                                </select>
                            </td>
                            <td>
                                <input name="unit[]" class="form-control unit" autocomplete="off" readonly>
                            </td>                                            
                            <td>
                                <input class="form-control avaiable_quantity" name="avaiable_quantity[]" aria-describedby="date" readonly>
                            </td>
                            <td>
                                <input name="unit_price[]" class="form-control unit_price" autocomplete="off" type="number">
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
                $('.select2').select2({
                    maximumSelectionLength: 1
                });
            }

            $(document).on('keyup', '.type_no', function() {
                var event_this = $(this).closest('tr');
                clearNext($(this));
                let myObject = {
                    type: event_this.find('.received_type').val().toUpperCase(),
                }
                jquaryUiAjax('.type_no', "{{ route('searchTypeNo') }}", uiList, myObject);

                function uiList(item) {
                    event_this.find('.type_no').val(item.label);
                    event_this.find('.type_id').val(item.id);
                    getMaterials(event_this)
                    return false;
                }
            })

            function clearNext(selector) {
                let siblings = $(selector).parent().nextAll('td');
                siblings.each(function() {
                    $(this).find('input').val('');
                    $(this).find('select').empty();
                });
            }
            $(document).on('change', '.received_type', function() {
                var event_this = $(this).closest('tr');
                clearNext($(this));

                if ($('#from_branch_id').val() == '') {
                    $(this).val('');
                    swal.fire({
                        title: "Please Select From Branch",
                        type: "warning",
                    }).then(function() {
                        $('#from_branch').focus();
                    });
                    return false;
                }

                if ($('#to_branch_id').val() == '') {
                    $(this).val('');
                    swal.fire({
                        title: "Please Select To Branch",
                        type: "warning",
                    }).then(function() {
                        $('#to_branch').focus();
                    });
                    return false;
                }
            })

            function getMaterials(event_this) {

                let scm_requisition_id = $('#scm_requisition_id').val();
                let received_type = event_this.find('.received_type').val().toUpperCase();
                let receivable_id = event_this.find('.type_id').val();
                let material_name = event_this.find('.material_name');

                populateDropdownByAjax("{{ route('mrsAndTypeWiseMaterials') }}", {
                    scm_requisition_id: scm_requisition_id,
                    received_type: received_type,
                    receivable_id: receivable_id,
                    from_branch: $('#from_branch_id').val(),
                    to_branch: $('#to_branch_id').val(),
                }, material_name, 'value', 'label', {
                    'data-type': 'type',
                })
            }

            $(document).on('change', '.material_name', function() {
                var event_this = $(this).closest('tr');
                clearNext($(this));
                let material_id = $(this).val();
                let scm_requisition_id = $('#scm_requisition_id').val();
                let received_type = event_this.find('.received_type').val().toUpperCase();
                let receivable_id = event_this.find('.type_id').val();
                let brand = $(this).closest('tr').find('.brand');

                populateDropdownByAjax("{{ route('materialWiseBrands') }}", {
                    material_id: material_id,
                    received_type: received_type,
                    receivable_id: receivable_id,
                }, brand, 'value', 'label');
            })

            $(document).on('change', '.brand', function() {
                var event_this = $(this).closest('tr');
                clearNext($(this));
                let brand_id = $(this).val();
                let material_id = event_this.find('.material_name').val();
                let scm_requisition_id = $('#scm_requisition_id').val();
                let received_type = event_this.find('.received_type').val().toUpperCase();
                let receivable_id = event_this.find('.type_id').val();
                let model = $(this).closest('tr').find('.model');

                populateDropdownByAjax("{{ route('brandWiseModels') }}", {
                    brand_id: brand_id,
                    material_id: material_id,
                    received_type: received_type,
                    receivable_id: receivable_id
                }, model, 'value', 'label');
            });

            $(document).on('change', '.model', function() {
                var event_this = $(this).closest('tr');
                clearNext($(this));
                let model = $(this).val();
                let material_id = event_this.find('.material_name').val();
                let scm_requisition_id = $('#scm_requisition_id').val();
                let received_type = event_this.find('.received_type').val().toUpperCase();
                let receivable_id = event_this.find('.type_id').val();
                let brand_id = event_this.find('.brand').val();
                let serial_code = $(this).closest('tr').find('.serial_code');
                let material_type = $(this).closest('tr').find('.material_name').find(':selected').data(
                    'type');

                if (material_type == 'Drum') {
                    serial_code.attr('multiple', false);
                }
                populateDropdownByAjax("{{ route('modelWiseSerialCodes') }}", {
                    model: model,
                    material_id: material_id,
                    brand_id: brand_id,
                    received_type: received_type,
                    receivable_id: receivable_id
                }, serial_code, 'value', 'label', null, false);
            });


            $(document).on('change', '.material_name', function() {
                var elemmtn = $(this);
                let unit = (elemmtn).find(':selected').data('unit');
                let type = $(this).find(':selected').data('type');

                (elemmtn).closest('tr').find('.unit').val(unit);

                $.ajax({
                    url: "{{ route('getMaterialStock') }}",
                    type: 'get',
                    dataType: "json",
                    data: {
                        material_id: $(this).val(),
                        from_branch_id: $('#from_branch_id').val(),
                        to_branch_id: $('#to_branch_id').val(),
                        type: type
                    },
                    success: function(data) {
                        (elemmtn).closest('tr').find('.opening_balance').val(data
                            .to_branch_balance);
                        (elemmtn).closest('tr').find('.avaiable_quantity').val(data
                            .from_branch_balance);
                    }
                })
            })

            /* Adds and removes quantity row on click */
            $("#material_requisition").on('click', '.add-requisition-row', () => {
                appendCalculationRow();
            }).on('click', '.remove-requisition-row', function() {
                if ($('#material_requisition tbody tr').length == 1) {
                    return false;
                }
                $(this).closest('tr').remove();
            });
        })
    </script>
@endsection
