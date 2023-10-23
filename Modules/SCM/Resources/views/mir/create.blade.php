@extends('layouts.backend-layout')
@section('title', 'Material Issuing Report')

@php
    $is_old = old('supplier_name') ? true : false;
    $form_heading = !empty($material_issue) ? 'Update' : 'Add';
    $form_url = !empty($material_issue) ? route('material-issues.update', $material_issue->id) : route('material-issues.store');
    $form_method = !empty($material_issue) ? 'PUT' : 'POST';

    $mrs_no = $is_old ? old('mrs_no') : (!empty($material_issue) ? $material_issue->scmRequisition->mrs_no : '');
    $mrs_id = $is_old ? old('scm_requisition_id') : (!empty($material_issue) ? $material_issue->scm_requisition_id : '');
    $date = $is_old ? old('date') : (!empty($material_issue) ? $material_issue->date : '');
    $from_branch = $is_old ? old('from_branch') : (!empty($material_issue) ? $material_issue->fromBranch->FormattedAddress : '');
    $from_branch_id = $is_old ? old('from_branch_id') : (!empty($material_issue) ? $material_issue->branch_id : '');
    $to_branch = $is_old ? old('to_branch') : (!empty($material_issue) ? $material_issue->toBranch->FormattedAddress : '');
    $to_branch_id = $is_old ? old('to_branch_id') : (!empty($material_issue) ? $material_issue->to_branch_id : '');
    $courier = $is_old ? old('courier') : (!empty($material_issue) ? $material_issue->courier->name : '');
    $courier_id = $is_old ? old('courier_id') : (!empty($material_issue) ? $material_issue->courier_id : '');
    $courier_code = $is_old ? old('courier_code') : (!empty($material_issue) ? $material_issue->courier_code : '');
    $pop = $is_old ? old('pop') : (!empty($material_issue) ? $material_issue->pop->name : '');
    $pop_id = $is_old ? old('pop_id') : (!empty($material_issue) ? $material_issue->pop_id : '');
    $pop_address = $is_old ? old('pop_address') : (!empty($material_issue) ? $material_issue->pop->address : '');
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

        .select2container {
            max-width: 350px;
            white-space: inherit;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice span {
            color: #000;
            font-size: 11px;
            font-weight: bold;
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
    <a href="{{ route('material-issues.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
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
        @if (!empty($material_issue->id))
            <div class="form-group col-3">
                <label for="mrr_no">MIR No</label>
                <input type="text" class="form-control" id="mrr_no" name="mrr_no" aria-describedby="mrr_no"
                    value="{{ old('mrr_no') ?? ($material_issue->mir_no ?? '') }}" readonly>
            </div>
        @endif

        <div class="form-group col-3">
            <label for="mrs_no">MRS No:</label>
            <input type="text" class="form-control" id="mrs_no" aria-describedby="mrs_no" name="mrs_no"
                value="{{ $mrs_no }}" placeholder="Ex: MRS-####-##">
            <input type="hidden" class="form-control" id="scm_requisition_id" name="scm_requisition_id"
                aria-describedby="scm_requisition_id" value="{{ $mrs_id }}">
        </div>

        <div class="form-group col-3">
            <label for="applied_date">Applied Date:</label>
            <input class="form-control applied_date" name="date" aria-describedby="applied_date"
                value="{{ $date }}" readonly placeholder="Select a Date" id="applied_date">
        </div>

        <div class="form-group col-3">
            <label for="from_branch">From Branch:</label>
            <input type="text" class="form-control branch" id="from_branch" aria-describedby="from_branch"
                name="from_branch" value="{{ $from_branch }}" placeholder="Search Branch....">
            <input type="hidden" class="form-control branch_id" id="from_branch_id" name="branch_id"
                aria-describedby="from_branch_id" value="{{ $from_branch_id }}">
        </div>

        <div class="form-group col-3">
            <label for="to_branch">To Branch:</label>
            <input type="text" class="form-control branch" id="to_branch" aria-describedby="to_branch" name="to_branch"
                value="{{ $to_branch }}" placeholder="Search Branch....">
            <input type="hidden" class="form-control branch_id" id="to_branch_id" name="to_branch_id"
                aria-describedby="to_branch_id" value="{{ $to_branch_id }}">
        </div>

        <div class="form-group col-3">
            <label for="pop_name">POP Name:</label>
            <input type="text" class="form-control pop_name" name="pop_name" value="{{ $pop }}"
                placeholder="Search POP....">
            <input type="hidden" class="form-control pop_id" id="pop_id" name="pop_id" aria-describedby="pop_id"
                value="{{ $pop_id }}">
        </div>

        <div class="form-group col-3">
            <label for="pop_address">POP Address:</label>
            <input type="text" class="form-control" id="pop_address" aria-describedby="pop_address" name="pop_address"
                value="{{ $pop_address }}" readonly>
        </div>

        <div class="form-group col-3">
            <label for="courier_nmae">Courier Name:</label>
            <input type="text" class="form-control" id="courier_nmae" aria-describedby="courier_nmae" name="courier_nmae"
                value="{{ $courier }}" placeholder="Search Courier....">
            <input type="hidden" class="form-control" id="courier_id" name="courier_id" aria-describedby="courier_id"
                value="{{ $courier_id }}">
        </div>

        <div class="form-group col-3">
            <label for="courier_serial_no">Courier Seriel No:</label>
            <input type="text" class="form-control" id="courier_serial_no" aria-describedby="courier_serial_no"
                name="courier_serial_no" value="{{ $courier_code }}" placeholder="Search Courier No....">
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
    <hr />
    <div class="table-responsive" @if (empty($material_issue)) style="display: none;" @endif>
        <table class="table table-bordered" id="material_requisition">
            <thead>
                <tr>
                    <th>Material Name</th>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Received Type</th>
                    <th>Type No</th>
                    <th>Serial Code</th>
                    <th>Unit</th>
                    <th>Current Stock(Form)</th>
                    <th>Current Stock(To)</th>
                    <th>Issued Qty</th>
                    <th>Remarks</th>
                    <th><i class="btn btn-primary btn-sm fa fa-plus add-requisition-row"></i></th>
                </tr>
            </thead>
            <tbody id="materialRequisitionBody">
                @php
                    $receiveable_type = old('received_type', !empty($material_issue) ? $material_issue?->lines->pluck('received_type') : []);
                    $mrr_no = old('type_no', !empty($material_issue) ? $material_issue?->lines->pluck('receiveable.mrr_no') : []);
                    $mrr_id = old('type_id', !empty($material_issue) ? $material_issue?->lines->pluck('receiveable_id') : []);
                    $material_id = old('material_id', !empty($material_issue) ? $material_issue?->lines->pluck('material_id') : []);
                    $material_data = old('material_name', !empty($material_issue) ? $material_issue?->lines->pluck('material') : []);
                    $brand_id = old('brand_id', !empty($material_issue) ? $material_issue?->lines->pluck('brand_id') : []);
                    $brand_name = old('brand_name', !empty($material_issue) ? $material_issue?->lines->pluck('brand.name') : []);
                    $model = old('model', !empty($material_issue) ? $material_issue?->lines->pluck('model') : []);
                    $serial_code = old('serial_code', !empty($material_issue) ? $material_issue?->lines->pluck('serial_code') : []);
                    $unit_name = old('unit_name', !empty($material_issue) ? $material_issue?->lines->pluck('material.unit') : []);
                    $issued_qty = old('issued_qty', !empty($material_issue) ? $material_issue?->lines->pluck('quantity') : []);
                @endphp
                @foreach ($receiveable_type as $key => $value)
                    <tr>
                        <td>
                            <select class="form-control material_name select2" name="material_name[]">
                                @foreach ($materials[$key] as $key1 => $value)
                                    <option value="{{ $value->material->id }}"
                                        {{ $material_id[$key] == $value->material->id ? 'selected' : '' }}
                                        data-type="{{ $material_data[$key]->type }}"
                                        data-unit="{{ $material_data[$key]->unit }}"
                                        data-code="{{ $material_data[$key]->code }}">
                                        {{ $value->material->name }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="code[{{ $key }}]" class="form-control code"
                                autocomplete="off" value="{{ $material_data[$key]->code }}">
                            <input type="hidden" name="type[{{ $key }}]" class="form-control type"
                                autocomplete="off" value="{{ $material_data[$key]->type }}">
                        </td>
                        <td>
                            <select class="form-control brand select2" name="brand[]">
                                @foreach ($brands[$key] as $key1 => $value)
                                    <option value="{{ $value->brand->id }}"
                                        {{ $brand_id[$key] == $value->brand->id ? 'selected' : '' }}>
                                        {{ $value->brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="form-control model select2" name="model[]">
                                @foreach ($models[$key] as $key1 => $value)
                                    <option value="{{ $value->model }}"
                                        {{ $model[$key] == $value->model ? 'selected' : '' }}>
                                        {{ $value->model }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="form-control received_type" name="received_type[]">
                                <option value="">Select</option>
                                @foreach (config('businessinfo.receivedTypes') as $typeKey => $typeValue)
                                    <option value="{{ $typeValue }}"
                                        {{ $receiveable_type[$key] == $typeValue ? 'selected' : '' }}>
                                        {{ $typeValue }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select name="type_id[{{ $key }}]" class="form-control type_id select2"
                                autocomplete="off">
                                <option value="">Select Type</option>
                                @foreach ($type_no[$key] as $typeKey => $typevalue)
                                    <option value="{{ $typevalue['id'] }}" @selected($mrr_id[$key] == $typevalue['id'])>
                                        {{ $typevalue['type_no'] }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="select2container">
                            <select class="form-control serial_code select2" name="serial_code[{{ $key }}][]"
                                multiple="multiple">
                                @foreach ($serial_codes[$key] as $key1 => $value)
                                    <option value="{{ $value->serial_code }}" @selected(in_array($value->serial_code, json_decode($serial_code[$key])))>
                                        {{ $value->serial_code }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="text" class="form-control unit" name="unit[]"
                                value="{{ $unit_name[$key] }}" readonly>
                        </td>
                        <td>
                            <input type="text" class="form-control from_current_quantity"
                                name="from_current_quantity[]" value="{{ $from_branch_stock[$key] }}" readonly>
                        </td>
                        <td>
                            <input type="text" class="form-control to_current_quantity" name="to_current_quantity[]"
                                value="{{ $to_branch_stock[$key] }}" readonly>
                        </td>
                        <td>
                            <input type="number" class="form-control issued_qty" name="issued_qty[]"
                                value="{{ $issued_qty[$key] }}" @if ($material_data[$key]->type == 'Item' && !empty($serial_code[$key])) readonly @endif>
                        </td>
                        <td>
                            <input type="text" class="form-control" name="remarks[]"
                                value="{{ old('remarks')[$key] ?? ($material_issue->lines->pluck('remarks')[$key] ?? '') }}">
                        </td>
                        <td>
                            <i class="btn btn-danger btn-sm fa fa-minus remove-requisition-row"></i>
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
    </div>

    {!! Form::close() !!}
@endsection

@section('script')
    <script>
        $('#applied_date').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true,
            showOtherMonths: true
        }).datepicker("setDate", new Date());
        const CSRF_TOKEN = "{{ csrf_token() }}";
        $(document).ready(function() {
            let tr_length = $('#material_requisition tbody tr').length;
            if (tr_length == 0) {
                appendCalculationRow();
            } else {
                $('.select2').select2({
                    maximumSelectionLength: 5,
                    width: '100%'
                }).on('select2:select', function(e) {
                    if ($(this).val().length === 5) {
                        $(this).next().find('.select2-selection').addClass('narrow-selection');
                    }
                });
            }
        })

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
                $('.loading').show();

                $('#scm_requisition_id').val(ui.item.scm_requisition_id);
                $('#mrs_no').val(ui.item.label);
                // console.log(ui.item.label);
                $.ajax({
                    url: "{{ route('get-requisition-data-by-mrs-no') }}",
                    type: 'get',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        mrs_no: ui.item.label
                    },
                    success: function(data) {
                        // console.log(data);
                        scmMatareialDetailWithMaterial = data
                            .scm_requisitiondetails_with_material;
                        $('#fr_no').val(data.fr_no);
                        $('#link_no').val(data.link_no);
                        $('#client_no').val(data.client_no);
                        $('#branch_id').val(data.branch?.id);
                        $('#branch_name').val(data.branch?.name);
                        $('#client_name').val(data.client?.client_name);
                        $('#client_address').val(data.feasibility_requirement_detail
                            ?.location);
                        if (data.link_no != null) {
                            $('#equipment_type').val('Link');
                        } else {
                            $('#equipment_type').val('Service Equipment');
                        }

                        $('#pop_name').val(data.pop?.name);
                        $('#pop_address').val(data.pop?.address);
                        $('#pop_id').val(data.pop?.id);
                        $('#employee').val(data.employee?.name);
                        $('#employee_id').val(data.employee?.id);
                        var material_options =
                            '<option value="" readonly selected>Select Material</option>';
                        $.each(data.scm_requisitiondetails_with_material, function(
                            key,
                            value) {
                            material_options += '<option value="' + value
                                .material_id + '"data-unit="' + value.material
                                .unit +
                                '"data-code="' + value.material.code +
                                '"data-type="' + value.material.type +
                                '">' + value.material.name +
                                '</option>';
                        })

                        $('.material_name').html(material_options);
                        $('.table-responsive').show();
                        $('.loading').hide();
                    }
                });

                return false;

            }
        })

        function checkUniqueMaterial(currentValue) {
            var current_selector = $(currentValue);
            var current_material = $(currentValue).closest('tr').find('.material_name').val();
            var current_value_brand = $(currentValue).closest('tr').find('.brand').val();
            var current_value_model = $(currentValue).closest('tr').find('.model').val();
            var current_key = `${current_material}_${current_value_brand}_${current_value_model}`;
            console.log(current_key);
            var count_row = $('#challan tbody tr').length;
            var thisMaterial = $(currentValue).closest('tr').find('.material_name');
            let material_list = $('.material_name').not($(thisMaterial));

            material_list.each(function() {
                var material_name = $(this).val();
                var brand = $(this).closest('tr').find('.brand').val();
                var model = $(this).closest('tr').find('.model').val();
                var key = `${material_name}_${brand}_${model}`;
                console.log(key);
                if (key === current_key && count_row > 1) {
                    swal.fire({
                        title: "Material Already Selected",
                        type: "warning",
                    }).then(function() {
                        $(current_selector).val($(current_selector).find('option:first').val())
                            .trigger('change.select2');
                    });
                    return false;
                }
            });
        }

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


        $(document).on('change', '.material_name', function() {
            let from_branch_id = $('#from_branch_id').val();
            if (from_branch_id == '' || from_branch_id == null && to_branch_id == '' || to_branch_id == null) {
                swal.fire({
                    title: "Please Select From Branch and To Branch First",
                    type: "warning",
                }).then(function() {
                    $(this).val($(this).find('option:first').val())
                        .trigger('change.select2');
                });
                return false;
            }
            checkUniqueMaterial(this);
            var event_this = $(this).closest('tr');
            let material_id = $(this).val();
            let scm_requisition_id = $('#scm_requisition_id').val();
            let brand = $(this).closest('tr').find('.brand');
            console.log(scm_requisition_id);
            event_this.find('.unit').val($(this).closest('tr').find('.material_name').find(':selected')
                .data(
                    'unit'));
            event_this.find('.item_code').val($(this).closest('tr').find('.material_name').find(
                ':selected').data(
                'code'));
            event_this.find('.material_type').val($(this).closest('tr').find('.material_name').find(
                    ':selected')
                .data('type'));

            populateDropdownByAjax("{{ route('materialWiseBrands') }}", {
                material_id: material_id,
                from_branch_id: from_branch_id,
            }, brand, 'value', 'label');
        })

        $(document).on('change', '.brand', function() {
            checkUniqueMaterial(this);
            var event_this = $(this).closest('tr');
            let brand_id = $(this).val();
            let material_id = event_this.find('.material_name').val();
            let scm_requisition_id = $('#scm_requisition_id').val();
            let model = $(this).closest('tr').find('.model');

            populateDropdownByAjax("{{ route('brandWiseModels') }}", {
                brand_id: brand_id,
                material_id: material_id,
                from_branch_id: $('#from_branch_id').val(),
            }, model, 'value', 'label');
        });

        // $(document).on('change', '.model', function() {
        //     checkUniqueMaterial(this);
        //     var event_this = $(this).closest('tr');
        //     let model = $(this).val();
        //     let material_id = event_this.find('.material_name').val();
        //     let scm_requisition_id = $('#scm_requisition_id').val();
        //     let brand_id = event_this.find('.brand').val();
        //     let serial_code = $(this).closest('tr').find('.serial_code');
        //     let material_type = $(this).closest('tr').find('.material_name').find(':selected').data(
        //         'type');

        //     populateDropdownByAjax("{{ route('modelWiseSerialCodes') }}", {
        //         model: model,
        //         material_id: material_id,
        //         brand_id: brand_id,
        //         from_branch_id: $('#from_branch_id').val(),
        //     }, serial_code, 'value', 'label', null, false);
        // });

        $(document).on('change', '.model, .material_name, .brand', function() {
            var elemmtn = $(this);
            $.ajax({
                url: "{{ route('get-from-and-to-branch-stock') }}",
                type: 'get',
                dataType: "json",
                data: {
                    material_id: (elemmtn).closest('tr').find('.material_name').val(),
                    brand_id: (elemmtn).closest('tr').find('.brand').val(),
                    model: (elemmtn).closest('tr').find('.model').val(),
                    from_branch_id: $('#from_branch_id').val(),
                    to_branch_id: $('#to_branch_id').val(),
                    scm_requisition_id: $('#scm_requisition_id').val(),
                },
                success: function(data) {
                    (elemmtn).closest('tr').find('.from_current_quantity').val(data
                        .from_branch_balance);
                    (elemmtn).closest('tr').find('.to_current_quantity').val(data.to_branch_balance);
                }
            })
        })

        function getMaterials(event_this) {
            let scm_requisition_id = $('#scm_requisition_id').val();
            let material_name = event_this.find('.material_name');
            let brand = event_this.find('.brand');
            let model = event_this.find('.model');
            let receiveable_id = event_this.find('.type_id').val();
            let received_type = event_this.find('.received_type').val().toUpperCase();
            let from_branch_id = $('#from_branch_id').val();

            $.ajax({
                url: "{{ route('search-mrs-type-wise-material-quantity') }}",
                type: 'get',
                data: {
                    scm_requisition_id: scm_requisition_id,
                    branch: $('#branch_id').val(),
                    material_id: material_name.val(),
                    brand_id: brand.val(),
                    model: model.val(),
                    stockable_id: receiveable_id,
                    received_type: received_type,
                    branch_id: from_branch_id,
                },
                success: function(data) {
                    console.log(data);
                    (event_this).closest('tr').find('.from-current_quantity').val(data.current_stock);
                }
            });
        }

        $(document).on('change', '.received_type', function() {
            let event_this = $(this);
            let received_type = $(this).val().toUpperCase();
            let material_name = $(this).closest('tr').find('.material_name');
            let brand = $(this).closest('tr').find('.brand');
            let model = $(this).closest('tr').find('.model');
            let receiveable_id = $(this).closest('tr').find('.type_id').val();
            let branch_id = $('#from_branch_id').val();
            if (received_type == '') {
                alert('Please Select Received Type');
                return false;
            }
            $.ajax({
                url: "{{ route('receeive-type-wise-list') }}",
                type: 'get',
                data: {
                    scm_requisition_id: $('#scm_requisition_id').val(),
                    branch: $('#branch_id').val(),
                    material_id: material_name.val(),
                    brand_id: brand.val(),
                    model: model.val(),
                    stockable_id: receiveable_id,
                    received_type: received_type,
                    branch_id: branch_id,
                },
                success: function(data) {
                    var html = '<option value="" readonly selected>Select</option>';
                    $.each(data, function(key, item) {
                        html += `<option value="${item.id}">${item.type_no}</option>`;
                    });
                    event_this.closest('tr').find('.type_no').html(html);
                }
            });
        })

        $(document).on('change', '.type_no', function() {
            var event_this = $(this).closest('tr');
            let model = $(this).val();
            let material_id = event_this.find('.material_name').val();
            let scm_requisition_id = $('#scm_requisition_id').val();
            let received_type = event_this.find('.received_type').val().toUpperCase();
            let receiveable_id = event_this.find('.type_no').val();
            let brand_id = event_this.find('.brand').val();
            let serial_code = $(this).closest('tr').find('.serial_code');
            let material_type = $(this).closest('tr').find('.material_name').find(':selected').data(
                'type');
            $.ajax({
                url: "{{ route('modelWiseSerialCodes') }}",
                type: 'get',
                data: {
                    model: model,
                    material_id: material_id,
                    brand_id: brand_id,
                    received_type: received_type,
                    receiveable_id: receiveable_id,
                    branch_id: $('#from_branch_id').val(),
                },
                success: function(data) {
                    let html = '';
                    $.each(data, function(key, item) {

                        html += `<option value="${item.value}">${item.label}</option>`;
                    });
                    event_this.find('.serial_code').html(html);
                }
            });
        })

        $("#material_requisition").on('click', '.add-requisition-row', () => {
            appendCalculationRow();
        }).on('click', '.remove-requisition-row', function() {
            if ($('#material_requisition tbody tr').length == 1) {
                return false;
            }
            $(this).closest('tr').remove();
        });

        var indx = 0;

        @if ($form_method == 'PUT')
            indx = {{ count($material_issue->lines) }};
        @endif
        function appendCalculationRow() {
            let row = `<tr>
                            <td class="form-group">
                                <select class="form-control material_name select2" name="material_name[${indx}]">
                                    <option value="">Select Material</option>
                                </select>
                                <input type="hidden" name="code[${indx}]" class="form-control code" autocomplete="off"> 
                                <input type="hidden" name="type[${indx}]" class="form-control type" autocomplete="off"> 
                            </td>                            
                            <td>
                                <select class="form-control brand select2" name="brand[${indx}]">
                                </select>
                            </td>
                            <td>
                                <select class="form-control model select2" name="model[${indx}]">
                                </select>
                            </td>
                            <td>
                                <select name="received_type[${indx}]" class="form-control received_type" autocomplete="off">
                                    <option value="">Select Out From</option>
                                    @foreach (config('businessinfo.receivedTypes') as $value)
                                        <option value="{{ $value }}">{{ strToUpper($value) }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select class="form-control type_no select2" name="type_id[${indx}]">
                                    <option value="">Select</option>
                                </select>
                            </td>
                            <td class="select2container float">
                                <select class="form-control serial_code select2" name="serial_code[${indx}][]" multiple="multiple">

                                </select>
                            </td>
                            <td>
                                <input name="unit[${indx}]" class="form-control unit" autocomplete="off" readonly>
                            </td>                                           
                            <td>
                                <input class="form-control from_current_quantity" name="from_current_quantity[${indx}]" aria-describedby="date" readonly>
                            </td>
                            <td>
                                <input class="form-control to_current_quantity" name="to_current_quantity[${indx}]" aria-describedby="date" readonly>
                            </td>
                            <td>
                                <input name="issued_qty[${indx}]" class="form-control issued_qty" autocomplete="off" type="number">
                            </td>
                            <td>
                                <input name="remarks[${indx}]" class="form-control remarks" autocomplete="off">
                            </td>
                            <td>
                                <i class="btn btn-danger btn-sm fa fa-minus remove-requisition-row"></i>
                            </td>
                        </tr>
                    `;
            let material_values = $('#materialRequisitionBody').first().find('.material_name').html();
            row = row.replace('Select Material', material_values);
            indx++;
            $('#material_requisition tbody').append(row);
            $('.select2').select2({
                maximumSelectionLength: 5,
                width: '100%'
            }).on('select2:select', function(e) {
                if ($(this).val().length === 5) {
                    $(this).next().find('.select2-selection').addClass('narrow-selection');
                }
            });
        }

        $(document).on('change', '.serial_code ', function() {
            let count_sl = $('.serial_code').length;
            let count_sl_selected = $('.serial_code').find(':selected').length;
            console.log(count_sl_selected);
            console.log(count_sl)
            $(this).closest('tr').find('.issued_qty').val(count_sl_selected);
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
    </script>
@endsection
