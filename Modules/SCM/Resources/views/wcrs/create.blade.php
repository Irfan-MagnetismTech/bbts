@extends('layouts.backend-layout')
@section('title', 'Warranty Claim')
@php
    $is_old = old('type') ? true : false;
    $form_heading = !empty($warranty_claim) ? 'Update' : 'Add';
    $form_url = !empty($warranty_claim) ? route('warranty-claims.update', $warranty_claim->id) : route('warranty-claims.store');
    $form_method = !empty($warranty_claim) ? 'PUT' : 'POST';

    $date = old('date', !empty($warranty_claim) ? $warranty_claim->date : today()->format('d-m-Y'));
    $type = old('type', !empty($warranty_claim) ? $warranty_claim->type : null);
    $wcr_no = old('wcr_no', !empty($warranty_claim) ? $warranty_claim->wcr_no : null);
    $supplier_id = old('supplier_id', !empty($warranty_claim) ? $warranty_claim->supplier_id : null);
    $supplier_name = old('supplier_name', !empty($warranty_claim) ? $warranty_claim->supplier->name : null);
    $supplier_address = old('supplier_address', !empty($warranty_claim) ? $warranty_claim->supplier->address : null);
    $branch_id = old('branch_id', !empty($warranty_claim) ? $warranty_claim->branch_id : null);
    $branch_name = old('branch_id', !empty($warranty_claim) ? $warranty_claim?->branch?->name : null);
    $client_name = old('client_name', !empty($warranty_claim) ? $warranty_claim?->client?->client_name : null);
    $client_no = old('client_no', !empty($warranty_claim) ? $warranty_claim?->client?->client_no : null);
    $client_address = old('client_address', !empty($warranty_claim) ? $warranty_claim?->client?->location : null);

@endphp

@section('breadcrumb-title')
    {{ $form_heading }} Warranty Claim
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
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('warranty-claims.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'col-12')

@section('content')
    {!! Form::open([
        'url' => $form_url,
        'method' => $form_method,
        'encType' => 'multipart/form-data',
        'class' => 'custom-form',
    ]) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="
                     mt-2 mb-4">
                <div class="form-check-inline">
                    <label class="form-check-label" for="client">
                        <input type="radio" class="form-check-input radioButton" id="client" name="type"
                            value="client" @checked(@$type == 'client' || ($form_method == 'POST' && !old()))> Client
                    </label>
                </div>
                <div class="form-check-inline">
                    <label class="form-check-label" for="warehouse">
                        <input type="radio" class="form-check-input radioButton" id="warehouse" name="type"
                            value="warehouse" @checked(@$type == 'warehouse')>
                        Warehouse
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-3 date">
            <label for="date">Applied Date:</label>
            <input class="form-control" id="date" name="date" aria-describedby="date"
                value="{{ old('date') ?? @$date }}" readonly placeholder="Select a Date">
        </div>
        <div class="form-group col-3 supplier_name">
            <label for="select2">Supplier Name</label>
            <input class="form-control" id="supplier_name" name="supplier_name" aria-describedby="supplier_name"
                value="{{ old('supplier_name') ?? (@$supplier_name ?? '') }}" placeholder="Search a Supplier Name"
                autocomplete="off">
            <input class="form-control" id="supplier_id" name="supplier_id" aria-describedby="supplier_id"
                value="{{ old('supplier_id') ?? (@$supplier_id ?? '') }}" type="hidden">
        </div>
        <div class="form-group col-3 supplier_address">
            <label for="select2">Supplier Address</label>
            <input class="form-control" id="supplier_address" name="supplier_address" aria-describedby="supplier_address"
                value="{{ old('supplier_address') ?? (@$supplier_address ?? '') }}" readonly
                placeholder="Search a Supplier Name">
        </div>
        <div class="form-group col-3 branch_name">
            <label for="select2">From Branch</label>
            <select class="form-control select2" id="branch_id" name="branch_id">
                <option value="" selected>Select Branch</option>
                @if ($form_method == 'PUT')
                    {{-- <option value="{{ $branch_id }}" selected>
                        {{ $branch_name }}
                    </option> --}}
                @endif
            </select>
        </div>
        {{-- <div class="form-group col-3 equipment_type">
            <label for="equipment_type">Type:</label>
            <select class="form-control select2" id="equipment_type" name="equipment_type">
                <option value="Service Equipment" @if ($equipment_type == 'Service Equipment') selected @endif>Service Equipment</option>
                <option value="Link" @if ($equipment_type == 'Link') selected @endif>Link</option>
            </select>

        </div> --}}
    </div>

    <div class="row">
        <div class="form-group col-3 client_name">
            <label for="client_name">Client Name:</label>
            <input type="text" class="form-control" id="client_name" aria-describedby="client_name" name="client_name"
                value="{{ old('client_name') ?? (@$client_name ?? '') }}" placeholder="Search...">
        </div>
        <div class="form-group col-3 client_no">
            <label for="client_no">Client No:</label>
            <input type="text" class="form-control" id="client_no" aria-describedby="client_no" name="client_no" readonly
                value="{{ old('client_no') ?? (@$client_no ?? '') }}">

        </div>


        <div class="form-group col-3 client_address">
            <label for="client_address">Client Address:</label>
            <input type="text" class="form-control" id="client_address" name="client_address"
                aria-describedby="client_address" readonly value="{{ old('client_address') ?? (@$client_address ?? '') }}">
        </div>
    </div>

    <table class="table table-bordered" id="challan">
        <thead>
            <tr>
                <th>Material Name</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Received Type</th>
                <th>Type No</th>
                <th>Serial Code</th>
                <th>Unit</th>
                <th>Receiving Date</th>
                <th>Warranty Period</th>
                <th>Remaining Day</th>
                <th>Challan No</th>
                <th>Description</th>
                <th><i class="btn btn-primary btn-sm fa fa-plus add-challan-row"></i></th>
            </tr>
        </thead>
        <tbody>
            @php
                $material_id = old('material_id', !empty($warranty_claim) ? $warranty_claim->lines->pluck('material_id') : []);
                $material_name = old('material_name', !empty($warranty_claim) ? $warranty_claim->lines->pluck('material.name') : []);
                $received_type = old('received_type', !empty($warranty_claim) ? $warranty_claim->lines->pluck('received_type') : []);
                $receiveable_id = old('receiveable_id', !empty($warranty_claim) ? $warranty_claim->lines->pluck('receiveable_id') : []);
                $item_code = old('item_code', !empty($warranty_claim) ? $warranty_claim->lines->pluck('material.code') : []);
                $material_type = old('material_type', !empty($warranty_claim) ? $warranty_claim->lines->pluck('material.type') : []);
                $serial_code = old('serial_code', !empty($warranty_claim) ? $warranty_claim->lines->pluck('serial_code') : []);
                $brand_id = old('brand_id', !empty($warranty_claim) ? $warranty_claim->lines->pluck('brand_id') : []);
                $brand_name = old('brand_name', !empty($warranty_claim) ? $warranty_claim->lines->pluck('brand.name') : []);
                $model = old('model', !empty($warranty_claim) ? $warranty_claim->lines->pluck('model') : []);
                $challan_no = old('challan_no', !empty($warranty_claim) ? $warranty_claim->lines->pluck('challan_no') : []);
                $receiving_date = old('receiving_date', !empty($warranty_claim) ? $warranty_claim->lines->pluck('receiving_date') : []);
                $warranty_period = old('warranty_period', !empty($warranty_claim) ? $warranty_claim->lines->pluck('warranty_period') : []);
                $remaining_days = old('remaining_days', !empty($warranty_claim) ? $warranty_claim->lines->pluck('remaining_days') : []);
                $serial_code = old('serial_code', !empty($warranty_claim) ? json_decode($warranty_claim->lines->pluck('serial_code')) : []);
                $unit = old('unit', !empty($warranty_claim) ? $warranty_claim->lines->pluck('material.unit') : []);
                $description = old('warranty_period', !empty($warranty_claim) ? $warranty_claim->lines->pluck('description') : []);
            @endphp
            @foreach ($material_id as $key => $wcr_Line)
                <tr>
                    <td>
                        <select name="material_id[]" class="form-control material_name" autocomplete="off">
                            <option value="" disabled>Select Material</option>
                            @foreach ($materials as $material)
                                <option value="{{ $material->id }}" @selected($material_id[$key] == $material->id)>
                                    {{ $material->name }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="item_code[]" class="form-control item_code" autocomplete="off"
                            value="{{ $item_code[$key] }}">
                        <input type="hidden" name="material_type[]" class="form-control material_type"
                            autocomplete="off" value="{{ $material_type[$key] }}">
                    </td>
                    <td class="form-group">
                        <select class="form-control brand select2" name="brand_id[]" autocomplete="off">
                            <option value="" disabled>Select Brand</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" @selected($brand_id[$key] == $brand->id)>
                                    {{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="text" name="model[]" class="form-control model" autocomplete="off" readonly
                            value="{{ $model[$key] }}">
                    </td>
                    <td>
                        <select name="received_type[]" class="form-control received_type" autocomplete="off">
                            <option value="" disabled>Select Out From</option>
                            @if (in_array($received_type[$key], ['MRR', 'WCR']))
                                <option value="mrr" @selected($received_type[$key] == 'MRR')>{{ strToUpper('mrr') }}</option>
                                <option value="wcr" @selected($received_type[$key] == 'WCR')>{{ strToUpper('wcr') }}</option>
                            @else
                                <option value="err" @selected($received_type[$key] == 'ERR')>{{ strToUpper('err') }}</option>
                            @endif
                        </select>
                    </td>
                    <td>
                        <select name="receiveable_id[{{ $key }}]" class="form-control type_id select2"
                            autocomplete="off">
                            <option value="">Select Type</option>
                            @foreach ($type_no[$key] as $typeKey => $typevalue)
                                <option value="{{ $typevalue['id'] }}" @selected($receiveable_id[$key] == $typevalue['id'])>
                                    {{ $typevalue['type_no'] }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="text" name="serial_code[]" class="form-control serial_code" autocomplete="off"
                            readonly value="{{ $serial_code[$key] }}">
                    </td>
                    <td class="select2_container">
                        <input type="text" name="unit[]" class="form-control unit" autocomplete="off" readonly
                            value="{{ $unit[$key] }}">
                    </td>

                    <td>
                        <input name="receiving_date[]" class="form-control receiving_date" autocomplete="off" readonly
                            value="{{ $receiving_date[$key] }}">
                    </td>
                    <td>
                        <input name="warranty_period[]" class="form-control warranty_period" autocomplete="off" readonly
                            value="{{ $warranty_period[$key] }}">
                    </td>
                    <td>
                        <input class="form-control remaining_days" name="remaining_days[]"
                            aria-describedby="remaining_days" readonly value="{{ $remaining_days[$key] }}">
                    </td>
                    <td>
                        <input name="challan_no[]" class="form-control challan_no" autocomplete="off" readonly
                            value="{{ $challan_no[$key] }}">
                    </td>
                    <td>
                        <input class="form-control description" name="description[]" aria-describedby="description"
                            value="{{ $description[$key] }}">
                    </td>
                    <td>
                        <i class="btn btn-danger btn-sm fa fa-minus remove-challan-row"></i>
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
    </div>

@endsection

@section('script')
    <script>
        const CSRF_TOKEN = "{{ csrf_token() }}";
        $('#date').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true,
            showOtherMonths: true,
        });

        /* Append row */
        $(document).ready(function() {
            @if (empty($warranty_claim) && empty(old('material_id')))
                appendCalculationRow();
            @endif
        })


        function appendCalculationRow() {
            var type = $("input[name=type]:checked").val()
            let row = `<tr>
                            <td class="form-group">
                                <select class="form-control material_name select2" name="material_id[]">
                                    <option value="" readonly selected>Select Material</option>
                                    @foreach ($materials as $material)
                                        <option value="{{ $material->id }}" data-code="{{ $material->code }}" data-type="{{ $material->type }}" data-unit="{{ $material->unit }}">{{ $material->name }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="item_code[]" class="form-control item_code" autocomplete="off">
                                <input type="hidden" name="material_type[]" class="form-control material_type" autocomplete="off">
                            </td>
                            <td>
                                <select class="form-control brand select2" name="brand_id[]">
                                    <option value="" readonly selected>Select Brand</option>

                                </select>
                            </td>
                            <td>
                                <select class="form-control model select2" name="model[]">
                                    <option value="" readonly selected>Select Model</option>
                                </select>
                            </td>
                            <td>
                                <select name="received_type[]" class="form-control received_type" autocomplete="off">
                                    <option value="">Select Out From</option>
                                    @foreach (config('businessinfo.receivedTypes') as $value)
                                        <option value="{{ $value }}">{{ strToUpper($value) }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="receiveable_id[]" class="form-control type_id select2" autocomplete="off">
                                    <option value="">Select Type</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-control serial_code select2" name='serial_code[]'>
                                </select>
                            </td>
                        
                        <td >
                            <input type="text" name="unit[]" class="form-control unit" autocomplete="off" readonly>
                        </td>
                        
                        <td>
                            <input name="receiving_date[]" class="form-control receiving_date" autocomplete="off" readonly>
                        </td>
                        <td>
                            <input name="warranty_period[]" class="form-control warranty_period" autocomplete="off" readonly>
                        </td>
                        <td>
                            <input class="form-control remaining_days" name="remaining_days[]" aria-describedby="available_quantity" readonly>
                        </td>
                        <td>
                            <input name="challan_no[]" class="form-control challan_no" autocomplete="off" readonly>
                        </td>
                        <td>
                            <input class="form-control description" name="description[]" aria-describedby="description">
                        </td>
                        <td>
                            <i class="btn btn-danger btn-sm fa fa-minus remove-challan-row"></i>
                        </td>
                    </tr>
                `;
            $('#challan tbody').append(row);
            $('.select2').select2({});
        }

        /* Adds and removes quantity row on click */
        $("#challan")
            .on('click', '.add-challan-row', () => {
                appendCalculationRow();
            })
            .on('click', '.remove-challan-row', function() {
                $(this).closest('tr').remove();
            });

        $(function() {
            onChangeRadioButton();

            $('.select2').select2({
                maximumSelectionLength: 5,
                scrollAfterSelect: true
            });

            //using form custom function js file
            fillSelect2Options("{{ route('searchBranch') }}", '#branch_id');
            associativeDropdown("{{ route('searchPop') }}", 'search', '#branch_id', '#pop_name', 'get', null)

            $(".radioButton").click(function() {
                onChangeRadioButton()
            });




        });

        @if ($form_method == 'PUT')

            $(document).on('DOMNodeInserted', '#branch_id', function() {
                let selectedValue = "{{ $branch_id }}"
                $('#branch_id').val(selectedValue)
            });
        @endif

        function onChangeRadioButton() {
            var radioValue = $("input[name='type']:checked").val();
            if (radioValue == 'client') {
                $('.pop_id').hide('slow');
                $('.pop_name').hide('slow');
                $('.pop_address').hide('slow');
                $('.address').show('slow');
                $('.client_name').show('slow');
                $('.client_no').show('slow');
                $('.client_address').show('slow');
                $('.type').show('slow');
                $('.link_no').show('slow');
                $('.fr_no').show('slow');
                $('.fr_id').show('slow');
            } else if (radioValue == 'warehouse') {
                $('.pop_id').show('slow');
                $('.pop_name').show('slow');
                $('.pop_address').show('slow');
                $('.address').hide('slow');
                $('.client_name').hide('slow');
                $('.client_no').hide('slow');
                $('.client_address').hide('slow');
                $('.type').hide('slow');
                $('.link_no').hide('slow');
                $('.fr_no').hide('slow');
                $('.fr_id').hide('slow');
            }
        }


        $(document).on('keyup', "#supplier_name", function() {
            $(this).autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('searchSupplier') }}",
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
                    $('#supplier_name').val(ui.item.label);
                    $('#supplier_id').val(ui.item.value);
                    $('#supplier_address').val(ui.item.address);
                    return false;
                }
            });
        });


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
                    branch_id: $('#branch_id').val(),
                    material_id: material_name.val(),
                    brand_id: brand.val(),
                    model: model.val(),
                    stockable_id: receiveable_id,
                    received_type: received_type,
                },
                success: function(data) {
                    var html = '<option value="" readonly selected>Select</option>';
                    $.each(data, function(key, item) {
                        html += `<option value="${item.id}">${item.type_no}</option>`;
                    });
                    event_this.closest('tr').find('.type_id').html(html);
                }
            });
        })

        $(document).on('change', '.type_id', function() {
            var event_this = $(this).closest('tr');
            let model = $(this).val();
            let material_id = event_this.find('.material_name').val();
            let scm_requisition_id = $('#scm_requisition_id').val();
            let received_type = event_this.find('.received_type').val().toUpperCase();
            let receiveable_id = event_this.find('.type_id').val();
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
                    branch_id: $('#branch_id').val(),
                    entry_type: 'warranty_claim',
                },
                success: function(data) {
                    let html = '<option value="" readonly selected>Select</option>';
                    $.each(data, function(key, item) {

                        html += `<option value="${item.value}">${item.label}</option>`;
                    });
                    event_this.find('.serial_code').html(html);
                }
            });
        })

        $(document).on('change', '.material_name', function() {
            checkUniqueMaterial(this);
            var event_this = $(this).closest('tr');
            let material_id = $(this).val();
            let scm_requisition_id = $('#scm_requisition_id').val();
            let brand = $(this).closest('tr').find('.brand');

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
                from_branch_id: $('#branch_id').val(),
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
                from_branch_id: $('#branch_id').val(),
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
        //         from_branch_id: $('#branch_id').val(),
        //     }, serial_code, 'value', 'label', null, false);
        // });

        $(document).on('change', '.serial_code', function() {
            let serial_code = $(this).val();
            let event = $(this).closest('tr');

            $.get("{{ route('get-warrenty-info-by-serial-code') }}", {
                serial_code: serial_code,
                entry_type: 'warranty_claim',
            }, function(data) {
                event.find('.receiving_date').val(data.receiving_date);
                event.find('.warranty_period').val(data.warranty_period);
                event.find('.remaining_days').val(data.remaining_days);
                event.find('.challan_no').val(data.challan_no);
            });
        });

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

        $(document).on('change', '.model, .material_name, .brand', function() {
            var elemmtn = $(this);
            $.ajax({
                url: "{{ route('get-stock') }}",
                type: 'get',
                dataType: "json",
                data: {
                    material_id: (elemmtn).closest('tr').find('.material_name').val(),
                    brand_id: (elemmtn).closest('tr').find('.brand').val(),
                    model: (elemmtn).closest('tr').find('.model').val(),
                    branch_id: $('#branch_id').val(),
                    scm_requisition_id: $('#scm_requisition_id').val(),
                },
                success: function(data) {
                    (elemmtn).closest('tr').find('.available_quantity').val(data
                        .current_stock);
                    (elemmtn).closest('tr').find('.mrs_quantity').val(data.mrs_quantity);
                }
            })
        })

        //issued quantity cannot be greater than avaiable_quantity
        $(document).on('keyup', '.quantity', function() {
            let elemmtn = $(this).closest('tr');
            let avaiable_quantity = parseFloat((elemmtn).find('.available_quantity').val());
            let quantity = parseFloat((elemmtn).find('.quantity').val());
            if (quantity > avaiable_quantity) {
                swal.fire({
                    title: "Issued Quantity Cannot Be Greater Than Avaiable Quantity",
                    type: "warning",
                }).then(function() {
                    (elemmtn).find('.quantity').val(avaiable_quantity);
                });
            }
        });

        $("input[name='type']").on('change', function() {
            $('#challan tbody').empty();
            appendCalculationRow();
        });
    </script>

    <script src="{{ asset('js/search-client.js') }}"></script>
@endsection
