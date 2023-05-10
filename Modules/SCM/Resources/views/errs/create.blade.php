@extends('layouts.backend-layout')
@section('title', 'Equipment Restore Report')
@php
    $is_old = old('type') ? true : false;
    $form_heading = !empty($challan) ? 'Update' : 'Add';
    $form_url = !empty($challan) ? route('errs.update', $challan->id) : route('errs.store');
    $form_method = !empty($challan) ? 'PUT' : 'POST';
    
    $date = old('date', !empty($challan) ? $challan->date : null);
    $type = old('date', !empty($challan) ? $challan->type : null);
    
    $scm_requisition_id = old('scm_requisition_id', !empty($challan) ? $challan->scm_requisition_id : null);
    $purpose = old('purpose', !empty($challan) ? $challan->purpose : null);
    $equipment_type = old('equipment_type', !empty($challan) ? $challan?->equipment_type : null);
    $client_id = old('client_id', !empty($challan) ? $challan->client_id : null);
    $fr_composite_key = old('fr_composite_key', !empty($challan) ? $challan->fr_composite_key : null);
    $fr_id = old('fr_composite_key', !empty($challan) ? $challan->clientDetails?->fr_id : null);
    $client_name = old('client_name', !empty($challan) ? $challan?->client?->name : null);
    $client_no = old('client_no', !empty($challan) ? $challan?->client?->client_no : null);
    $client_address = old('client_address', !empty($challan) ? $challan?->client?->address : null);
    $branch_id = old('branch_id', !empty($challan) ? $challan->branch_id : null);
    $branch_name = old('branch_id', !empty($challan) ? $challan?->branch?->name : null);
    $pop_id = old('pop_id', !empty($challan) ? $challan->pop_id : null);
    $pop_name = old('pop_name', !empty($challan) ? $challan?->pop?->name : null);
    $pop_address = old('pop_address', !empty($challan) ? $challan?->pop?->address : null);
    
@endphp

@section('breadcrumb-title')
    {{ $form_heading }} Equipment Restore Report (ERR)
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
    <a href="{{ route('errs.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
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
                    <label class="form-check-label" for="internal">
                        <input type="radio" class="form-check-input radioButton" id="internal" name="type"
                            value="internal" @checked(@$type == 'internal')>
                        internal
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-3 date">
            <label for="date">Applied Date:</label>
            <input class="form-control" id="date" name="date" aria-describedby="date"
                value="{{ old('date') ?? (@$date ?? '') }}" readonly placeholder="Select a Date">
        </div>
        <div class="form-group col-3">
            <label for="select2">Purpose</label>
            <select class="form-control select2" id="purpose" name="purpose">
                <option value="" selected>Select Purpose</option>
                @foreach (config('businessinfo.errReturnFor') as $key => $value)
                    <option value="{{ $value }}" {{ old('purpose', @$purpose) == $value ? 'selected' : '' }}>
                        {{ $value }}
                    </option>
                @endforeach
            </select>
        </div>        
    </div>

    <div class="row">
        <div class="form-group col-3 equipment_type">
            <label for="equipment_type">Type:</label>
            <select class="form-control select2" id="equipment_type" name="equipment_type">
                <option value="Service Equipment" @if ($equipment_type == 'Service Equipment') selected @endif>Service Equipment
                </option>
                <option value="Link" @if ($equipment_type == 'Link') selected @endif>Link</option>
            </select>

        </div>
        <div class="form-group col-3 client_name">
            <label for="client_name">Client Name:</label>
            <input type="text" class="form-control" id="client_name" aria-describedby="client_name" name="client_name"
                value="{{ old('client_name') ?? (@$client_name ?? '') }}" placeholder="Search...">
        </div>
        <div class="form-group col-3 fr_no">
            <label for="select2">FR No</label>
            <select class="form-control select2" id="fr_no" name="fr_no">
                <option value="" readonly selected>Select FR No</option>
                @if ($form_method == 'POST')
                    <option value="{{ old('fr_no') }}" selected>{{ old('fr_no') }}</option>
                @endif
                @if ($form_method == 'PUT')
                    @foreach ($fr_no_list as $key => $value)
                        <option value="{{ $value }}" @selected($value == @$fr_no)>
                            {{ $value }}</option>
                    @endforeach
                @endif
            </select>
        </div>

        <div class="form-group col-3 link_no">
            <label for="link_no">Link No:</label>
            <select class="form-control select2" id="link_no" name="link_no">
                <option value="" readonly selected>Select Link No</option>
                @if ($form_method == 'POST')
                    <option value="{{ old('link_no') }}" selected>{{ old('link_no') }}</option>
                @endif
                @if ($form_method == 'PUT')
                    @foreach ($client_links as $key => $value)
                        <option value="{{ $value }}" @selected($value == @$link_no)>
                            {{ $value }}</option>
                    @endforeach
                @endif
            </select>
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

        <div class="form-group col-3 pop_name" style="display: none">
            <label for="select2">Pop Name</label>
            <input class="form-control" id="pop_name" name="pop_name" aria-describedby="pop_name"
                value="{{ old('pop_name') ?? (@$pop_name ?? '') }}" placeholder="Search a POP Name">
            <input type="hidden" class="form-control" id="pop_id" name="pop_id" aria-describedby="pop_id"
                value="{{ old('pop_id') ?? (@$pop_id ?? '') }}">
        </div>
        <div class="form-group col-3 pop_address" style="display: none">
            <label for="select2">Pop Address</label>
            <input class="form-control" id="pop_address" name="pop_address" aria-describedby="pop_address"
                value="{{ old('pop_address') ?? (@$pop_address ?? '') }}" readonly placeholder="Select a POP Address">
        </div>
    </div>

    <table class="table table-bordered" id="challan">
        <thead>
            <tr>
                <th rowspan="2">Material Name</th>
                <th rowspan="2">Description</th>
                <th rowspan="2">Provided Qty</th>
                <th rowspan="2">Item Code</th>
                <th rowspan="2">Unit</th>
                <th rowspan="2">Brand</th>
                <th rowspan="2">Model</th>
                <th rowspan="2">Serial/Drum Code <br /> No</th>
                <th rowspan="2">Quantity</th>
                <th colspan="2">Damaged</th>
                <th colspan="2">Useable</th>
                <th colspan="2">Ownership</th>
                <th rowspan="2">Remarks</th>
            </tr>
            <tr>
                <th>BBTS</th>
                <th>CLIENT</th>
                <th>BBTS</th>
                <th>CLIENT</th>
                <th>BBTS</th>
                <th>CLIENT</th>
            </tr>
        </thead>
        <tbody>
            @php
                $Challan_Lines = old('material_id', !empty($challan) ? $challan->scmChallanLines->pluck('material_id') : []);
                $received_type = old('received_type', !empty($challan) ? $challan->scmChallanLines->pluck('received_type') : []);
                $received_no = old('type_no', !empty($challan) ? $challan->scmChallanLines->pluck('received_no') : []);
                $receiveable_id = old('type_id', !empty($challan) ? $challan->scmChallanLines->pluck('receiveable_id') : []);
                $type_id = old('type_id', !empty($challan) ? $challan->scmChallanLines->pluck('type_id') : []);
                $item_code = old('item_code', !empty($challan) ? $challan->scmChallanLines->pluck('material.code') : []);
                $material_type = old('material_type', !empty($challan) ? $challan->scmChallanLines->pluck('material.type') : []);
                $brand_id = old('brand_id', !empty($challan) ? $challan->scmChallanLines->pluck('brand_id') : []);
                $model = old('model', !empty($challan) ? $challan->scmChallanLines->pluck('model') : []);
                $material_id = old('material_id', !empty($challan) ? $challan->scmChallanLines->pluck('material_id') : []);
                $serial_code = old('material_id', !empty($challan) ? json_decode($challan->scmChallanLines->pluck('serial_code')) : []);
                
                $unit = old('unit', !empty($challan) ? $challan->scmChallanLines->pluck('material.unit') : []);
                $quantity = old('final_mark', !empty($challan) ? $challan->scmChallanLines->pluck('quantity') : []);
                $remarks = old('warranty_period', !empty($challan) ? $challan->scmChallanLines->pluck('remarks') : []);
                
            @endphp
            @foreach ($Challan_Lines as $key => $Challan_Line)
                <tr>
                    <td>
                        <select name="received_type[{{ $key }}]" class="form-control received_type"
                            autocomplete="off">
                            <option value="">Select Out From</option>
                            @foreach (config('businessinfo.receivedTypes') as $typeKey => $typevalue)
                                <option value="{{ $typevalue }}" @selected($received_type[$key] == $typevalue)>
                                    {{ strToUpper($typevalue) }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="text" name="type_no[{{ $key }}]" class="form-control type_no"
                            autocomplete="off" value="{{ $received_no[$key] }}">
                        <input type="hidden" name="type_id[{{ $key }}]" class="form-control type_id"
                            autocomplete="off" value="{{ $receiveable_id[$key] }}">
                    </td>
                    <td class="form-group">
                        <select class="form-control material_name select2" name="material_name[{{ $key }}]">
                            <option value="" readonly selected>Select Material</option>
                            @foreach ($materials[$key] as $key1 => $value)
                                <option value="{{ $value->material->id }}" data-type="{{ $value->material->type }}"
                                    data-unit="{{ $value->material->unit }}" data-code="{{ $value->material->code }}"
                                    readonly @selected($material_id[$key] == $value->material->id)>
                                    {{ $value->material->name }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="item_code[{{ $key }}]" class="form-control item_code"
                            autocomplete="off" value="{{ $item_code[$key] }}">
                        <input type="hidden" name="material_type[{{ $key }}]"
                            class="form-control material_type" autocomplete="off" value="{{ $material_type[$key] }}">
                    </td>

                    <td>

                        <select name="brand[{{ $key }}]" class="form-control brand select2" autocomplete="off">
                            <option value="">Select Brand</option>
                            @foreach ($brands[$key] as $key1 => $value)
                                <option value="{{ $value?->brand?->id ?? null }}" @selected($value?->brand?->id == $brand_id[$key])>
                                    {{ $value?->brand?->name ?? null }}
                                </option>
                            @endforeach
                        </select>
                    </td>

                    <td>
                        <select class="form-control model select2" name="model[{{ $key }}]">
                            <option value="" readonly selected>Select Model</option>
                            @foreach ($models[$key] as $key1 => $value)
                                <option value="{{ $value->model }}" @selected($value->model == $model[$key])>
                                    {{ $value->model }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td class="select2_container">
                        <select class="form-control select2 serial_code" multiple
                            name="serial_code[{{ $key }}][]">
                            @foreach ($serial_codes[$key] as $key1 => $value)
                                <option value="{{ $value->serial_code }}" @selected(in_array($value->serial_code, json_decode($serial_code[$key])))>
                                    {{ $value->serial_code }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input name="unit[{{ $key }}]" class="form-control unit" readonly autocomplete="off"
                            type="text" value="{{ $unit[$key] }}">
                    </td>
                    <td>
                        <input name="avaiable_quantity[{{ $key }}]" class="form-control avaiable_quantity"
                            autocomplete="off" value="{{ $branch_stock[$key] }}" readonly>
                    </td>
                    <td>
                        <input name="quantity[{{ $key }}]" class="form-control quantity" autocomplete="off"
                            @if ($material_type[$key] == 'Item' && !empty(json_decode($serial_code[$key]))) readonly @endif value="{{ $quantity[$key] }}">
                    </td>
                    <td>
                        <input name="remarks[{{ $key }}]" class="form-control remarks" autocomplete="off"
                            value="{{ $remarks[$key] }}">
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
        $('#date').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true,
            showOtherMonths: true
        }).datepicker("setDate", new Date());;

        $(function() {
            onChangeRadioButton();

            $('.select2').select2({
                maximumSelectionLength: 5,
                scrollAfterSelect: true
            });

            //using form custom function js file
            fillSelect2Options("{{ route('searchBranch') }}", '#branch_id');

            $(".radioButton").click(function() {
                onChangeRadioButton()
            });

            $("#pop_name").autocomplete({
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
                    $('#pop_id').val(ui.item.id);
                    $('#pop_address').val(ui.item.address);
                    return false;
                }
            })

        });

        function onChangeRadioButton() {
            var radioValue = $("input[name='type']:checked").val();
            if (radioValue == 'client') {
                $('.pop_id').hide('slow');
                $('.pop_name').hide('slow');
                $('.pop_address').hide('slow');
                $('.equipment_type').show('slow');
                $('.address').show('slow');
                $('.client_name').show('slow');
                $('.client_no').show('slow');
                $('.client_address').show('slow');
                $('.type').show('slow');
                $('.link_no').show('slow');
                $('.fr_no').show('slow');
                $('.fr_id').show('slow');
            } else if (radioValue == 'internal') {
                $('.pop_id').hide('slow');
                $('.pop_name').hide('slow');
                $('.pop_address').hide('slow');
                $('.equipment_type').hide('slow');
                $('.address').hide('slow');
                $('.client_name').hide('slow');
                $('.client_no').hide('slow');
                $('.client_address').hide('slow');
                $('.type').hide('slow');
                $('.link_no').hide('slow');
                $('.fr_no').hide('slow');
                $('.fr_id').show('slow');
            }
        }

        $(document).on('keyup', '.type_no', function() {
            var event_this = $(this).closest('tr');
            ClearNext($(this));
            let myObject = {
                type: event_this.find('.received_type').val().toUpperCase(),
            }
            jquaryUiAjax(this, "{{ route('searchTypeNo') }}", uiList, myObject);

            function uiList(item) {
                event_this.find('.type_no').val(item.label);
                event_this.find('.type_id').val(item.id);
                getMaterials(event_this)
                return false;
            }
        })

        function ClearNext(selector) {
            let sib = $(selector).parent().nextAll('td');
            // loop siblings
            sib.each(function() {
                let input = $(this).find('input');
                let select = $(this).find('select');
                if (!input.hasClass('unit')) {
                    input.val('');
                }
                select.empty();
            });
        }
        $(document).on('change', '.received_type', function() {
            var event_this = $(this).closest('tr');
            ClearNext($(this));
        })

        function getMaterials(event_this) {

            let scm_requisition_id = $('#scm_requisition_id').val();
            let received_type = event_this.find('.received_type').val().toUpperCase();
            let receiveable_id = event_this.find('.type_id').val();
            let material_name = event_this.find('.material_name');
            populateDropdownByAjax("{{ route('mrsAndTypeWiseMaterials') }}", {
                scm_requisition_id: scm_requisition_id,
                received_type: received_type,
                receiveable_id: receiveable_id,
                from_branch: $('#branch_id').val(),
                to_branch: $('#branch_id').val(),
            }, material_name, 'value', 'label', {
                'data-type': 'type',
                'data-unit': 'unit',
                'data-code': 'code',
            })
        }

        $(document).on('change', '.material_name', function() {
            checkUniqueMaterial(this);
            var event_this = $(this).closest('tr');
            ClearNext($(this));
            let material_id = $(this).val();
            let scm_requisition_id = $('#scm_requisition_id').val();
            let received_type = event_this.find('.received_type').val().toUpperCase();
            let receiveable_id = event_this.find('.type_id').val();
            let brand = $(this).closest('tr').find('.brand');

            event_this.find('.unit').val($(this).closest('tr').find('.material_name').find(':selected').data(
                'unit'));
            event_this.find('.item_code').val($(this).closest('tr').find('.material_name').find(':selected').data(
                'code'));
            event_this.find('.material_type').val($(this).closest('tr').find('.material_name').find(':selected')
                .data('type'));

            populateDropdownByAjax("{{ route('materialWiseBrands') }}", {
                material_id: material_id,
                received_type: received_type,
                receiveable_id: receiveable_id,
                from_branch_id: $('#branch_id').val(),
            }, brand, 'value', 'label');
        })

        $(document).on('change', '.brand', function() {
            checkUniqueMaterial(this);
            var event_this = $(this).closest('tr');
            ClearNext($(this));
            let brand_id = $(this).val();
            let material_id = event_this.find('.material_name').val();
            let scm_requisition_id = $('#scm_requisition_id').val();
            let received_type = event_this.find('.received_type').val().toUpperCase();
            let receiveable_id = event_this.find('.type_id').val();
            let model = $(this).closest('tr').find('.model');

            populateDropdownByAjax("{{ route('brandWiseModels') }}", {
                brand_id: brand_id,
                material_id: material_id,
                received_type: received_type,
                receiveable_id: receiveable_id,
                from_branch_id: $('#branch_id').val(),
            }, model, 'value', 'label');
        });

        $(document).on('change', '.model', function() {
            checkUniqueMaterial(this);
            var event_this = $(this).closest('tr');
            ClearNext($(this));
            let model = $(this).val();
            let material_id = event_this.find('.material_name').val();
            let scm_requisition_id = $('#scm_requisition_id').val();
            let received_type = event_this.find('.received_type').val().toUpperCase();
            let receiveable_id = event_this.find('.type_id').val();
            let brand_id = event_this.find('.brand').val();
            let serial_code = $(this).closest('tr').find('.serial_code');
            let material_type = $(this).closest('tr').find('.material_name').find(':selected').data(
                'type');


            populateDropdownByAjax("{{ route('modelWiseSerialCodes') }}", {
                model: model,
                material_id: material_id,
                brand_id: brand_id,
                received_type: received_type,
                receiveable_id: receiveable_id,
                from_branch_id: $('#branch_id').val(),
            }, serial_code, 'value', 'label', null, false);
        });

        $(document).on('change', '.serial_code', function() {
            let material_type = $(this).closest('tr').find('.material_name').find(':selected').data('type');
            if (material_type == 'Item') {
                $(this).closest('tr').find('.quantity').val($(this).val().length);
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

        $(document).on('change', '.serial_code', function() {
            let elemmtn = $(this).closest('tr');
            let material_type = (elemmtn).find('.material_name').find(':selected').data(
                'type');
            if (material_type == 'Item') {
                (elemmtn).find('.quantity').attr('readonly', true);
                (elemmtn).find('.quantity').val($(this).val().length);
            } else {
                (elemmtn).find('.quantity').attr('readonly', false);
            }
        });

        $(document).on('change', '.received_type', function() {
            var event_this = $(this).closest('tr');
            ClearNext($(this));
            if ($('#branch_id').val() == '') {
                $(this).val('');
                swal.fire({
                    title: "Please Select From Branch",
                    type: "warning",
                }).then(function() {
                    $('#branch_id').focus();
                });
                return false;
            }


        })
        $(document).on('change', '.model, .material_name, .brand', function() {
            var elemmtn = $(this);
            $.ajax({
                url: "{{ route('getMaterialStock') }}",
                type: 'get',
                dataType: "json",
                data: {
                    material_id: (elemmtn).closest('tr').find('.material_name').val(),
                    brand_id: (elemmtn).closest('tr').find('.brand').val(),
                    model: (elemmtn).closest('tr').find('.model').val(),
                    received_type: (elemmtn).closest('tr').find('.received_type').val()
                        .toUpperCase(),
                    receiveable_id: (elemmtn).closest('tr').find('.type_id').val(),
                    from_branch_id: $('#branch_id').val(),
                    to_branch_id: null
                },
                success: function(data) {
                    (elemmtn).closest('tr').find('.available_quantity').val(data
                        .from_branch_balance);
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

        function getMaterials(event_this) {

            let scm_requisition_id = $('#scm_requisition_id').val();
            let received_type = event_this.find('.received_type').val().toUpperCase();
            let receiveable_id = event_this.find('.type_id').val();
            let material_name = event_this.find('.material_name');
            populateDropdownByAjax("{{ route('mrsAndTypeWiseMaterials') }}", {
                scm_requisition_id: scm_requisition_id,
                received_type: received_type,
                receiveable_id: receiveable_id,
                from_branch: $('#branch_id').val(),
                to_branch: $('#branch_id').val(),
            }, material_name, 'value', 'label', {
                'data-type': 'type',
                'data-unit': 'unit',
                'data-code': 'code',
            })
        }

        $(document).on('change', '.material_name', function() {
            checkUniqueMaterial(this);
            var event_this = $(this).closest('tr');
            ClearNext($(this));
            let material_id = $(this).val();
            let scm_requisition_id = $('#scm_requisition_id').val();
            let received_type = event_this.find('.received_type').val().toUpperCase();
            let receiveable_id = event_this.find('.type_id').val();
            let brand = $(this).closest('tr').find('.brand');

            event_this.find('.unit').val($(this).closest('tr').find('.material_name').find(':selected').data(
                'unit'));
            event_this.find('.item_code').val($(this).closest('tr').find('.material_name').find(':selected').data(
                'code'));
            event_this.find('.material_type').val($(this).closest('tr').find('.material_name').find(':selected')
                .data('type'));

            populateDropdownByAjax("{{ route('materialWiseBrands') }}", {
                material_id: material_id,
                received_type: received_type,
                receiveable_id: receiveable_id,
                from_branch_id: $('#branch_id').val(),
            }, brand, 'value', 'label');
        })

        $(document).on('change', '.brand', function() {
            checkUniqueMaterial(this);
            var event_this = $(this).closest('tr');
            ClearNext($(this));
            let brand_id = $(this).val();
            let material_id = event_this.find('.material_name').val();
            let scm_requisition_id = $('#scm_requisition_id').val();
            let received_type = event_this.find('.received_type').val().toUpperCase();
            let receiveable_id = event_this.find('.type_id').val();
            let model = $(this).closest('tr').find('.model');

            populateDropdownByAjax("{{ route('brandWiseModels') }}", {
                brand_id: brand_id,
                material_id: material_id,
                received_type: received_type,
                receiveable_id: receiveable_id,
                from_branch_id: $('#branch_id').val(),
            }, model, 'value', 'label');
        });

        $(document).on('change', '.model', function() {
            checkUniqueMaterial(this);
            var event_this = $(this).closest('tr');
            ClearNext($(this));
            let model = $(this).val();
            let material_id = event_this.find('.material_name').val();
            let scm_requisition_id = $('#scm_requisition_id').val();
            let received_type = event_this.find('.received_type').val().toUpperCase();
            let receiveable_id = event_this.find('.type_id').val();
            let brand_id = event_this.find('.brand').val();
            let serial_code = $(this).closest('tr').find('.serial_code');
            let material_type = $(this).closest('tr').find('.material_name').find(':selected').data(
                'type');


            populateDropdownByAjax("{{ route('modelWiseSerialCodes') }}", {
                model: model,
                material_id: material_id,
                brand_id: brand_id,
                received_type: received_type,
                receiveable_id: receiveable_id,
                from_branch_id: $('#branch_id').val(),
            }, serial_code, 'value', 'label', null, false);
        });

        $(document).on('change', '.serial_code', function() {
            let material_type = $(this).closest('tr').find('.material_name').find(':selected').data('type');
            if (material_type == 'Item') {
                $(this).closest('tr').find('.quantity').val($(this).val().length);
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

        $(document).on('change', '.serial_code', function() {
            let elemmtn = $(this).closest('tr');
            let material_type = (elemmtn).find('.material_name').find(':selected').data(
                'type');
            if (material_type == 'Item') {
                (elemmtn).find('.quantity').attr('readonly', true);
                (elemmtn).find('.quantity').val($(this).val().length);
            } else {
                (elemmtn).find('.quantity').attr('readonly', false);
            }
        });

        $(document).on('change', '.received_type', function() {
            var event_this = $(this).closest('tr');
            ClearNext($(this));
            if ($('#branch_id').val() == '') {
                $(this).val('');
                swal.fire({
                    title: "Please Select From Branch",
                    type: "warning",
                }).then(function() {
                    $('#branch_id').focus();
                });
                return false;
            }


        })
        $(document).on('change', '.model, .material_name, .brand', function() {
            var elemmtn = $(this);
            $.ajax({
                url: "{{ route('getMaterialStock') }}",
                type: 'get',
                dataType: "json",
                data: {
                    material_id: (elemmtn).closest('tr').find('.material_name').val(),
                    brand_id: (elemmtn).closest('tr').find('.brand').val(),
                    model: (elemmtn).closest('tr').find('.model').val(),
                    received_type: (elemmtn).closest('tr').find('.received_type').val()
                        .toUpperCase(),
                    receiveable_id: (elemmtn).closest('tr').find('.type_id').val(),
                    from_branch_id: $('#branch_id').val(),
                    to_branch_id: null
                },
                success: function(data) {
                    (elemmtn).closest('tr').find('.available_quantity').val(data
                        .from_branch_balance);
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
    </script>

    <script src="{{ asset('js/search-client.js') }}"></script>

@endsection
