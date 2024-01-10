@extends('layouts.backend-layout')
@section('title', 'Pop Wise Equipment')
@php
    $is_old = old('type') ? true : false;
    $form_heading = !empty($pop_equipment) ? 'Update' : 'Add';
    $form_url = !empty($pop_equipment) ? route('pop-equipments.update', $pop_equipment->id) : route('pop-equipments.store');
    $form_method = !empty($pop_equipment) ? 'PUT' : 'POST';

    $pop_id = old('pop_id', !empty($pop_equipment) ? $pop_equipment->pop_id : null);
    $material_id = old('material_id', !empty($pop_equipment) ? $pop_equipment->material_id : null);
    $serial_code = old('serial_code', !empty($pop_equipment) ? $pop_equipment->serial_code : null);
    $brand = old('brand', !empty($pop_equipment) ? $pop_equipment->brand : null);
    $model = old('model', !empty($pop_equipment) ? $pop_equipment->model : null);
    $equipment_type = old('equipment_type', !empty($pop_equipment) ? $pop_equipment?->equipment_type : null);
    $quantity = old('quantity', !empty($pop_equipment) ? $pop_equipment->quantity : null);
    $status = old('status', !empty($pop_equipment) ? $pop_equipment->status : null);
    $tower_type = old('tower_type', !empty($pop_equipment) ? $pop_equipment?->tower_type : null);
    $tower_height = old('tower_height', !empty($pop_equipment) ? $pop_equipment?->tower_height : null);
    $made_by = old('made_by', !empty($pop_equipment) ? $pop_equipment?->made_by : null);
    $maintenance_date = old('maintenance_date', !empty($pop_equipment) ? $pop_equipment?->maintenance_date : null);
    $capacity = old('capacity', !empty($pop_equipment) ? $pop_equipment->capacity : null);
    $port_no = old('port_no', !empty($pop_equipment) ? $pop_equipment?->port_no : null);
    $installation_date = old('installation_date', !empty($pop_equipment) ? $pop_equipment->installation_date : null);
    $remarks = old('remarks', !empty($pop_equipment) ? $pop_equipment?->remarks : null);
@endphp

@section('breadcrumb-title')
    {{ $form_heading }} Pop Wise Equipment
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
    <a href="{{ route('pop-equipments.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
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
        <div class="form-group col-3">
            <div class="input-group input-group-sm input-group-primary">
                <select class="form-control" id="pop_id" name="pop_id" required>
                    <option value="">Select POP</option>
                </select>
            </div>
        </div>
        <div class="form-group col-3">
            <div class="input-group input-group-sm input-group-primary">
                <select class="form-control" id="equipment_type" name="equipment_type" required>
                    <option value="">Select Equipment</option>
                    @foreach (config('businessinfo.equipmentType') as $key => $value)
                        <option value="{{ $key }}" {{ $equipment_type == $key ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-3" id="material_div">
            <div class="input-group input-group-sm input-group-primary">
                <select class="form-control" id="material_id" name="material_id" required>
                    <option value="">Select Material</option>
                </select>
            </div>
        </div>
        <div class="form-group col-3" id="serial_code_div">
            <x-input-box colGrid="15" name="serial_code" value="{{ $serial_code }}" label="Serial Code"/>
        </div>
        <div class="form-group col-3" id="brand_div">
            <x-input-box colGrid="15" name="brand" value="{{ $brand }}" label="Brand"/>
        </div>
        <div class="form-group col-3" id="model_div">
            <x-input-box colGrid="15" name="model" value="{{ $model }}" label="Model"/>
        </div>
{{--        <div class="form-group col-3" id="supplier_div">--}}
{{--        <x-input-box colGrid="3" name="supplier_id" value="{{ $wo_no }}" label="Purchased From"/>--}}
{{--        </div>--}}
{{--        <div class="form-group col-3" id="purchase_date_div">--}}
{{--        <x-input-box colGrid="3" name="date" value="{{ $wo_no }}" label="Purchase Date"/>--}}
{{--        </div>--}}
        <div class="form-group col-3" id="tower_type_div">
            <div class="input-group input-group-sm input-group-primary">
                <select class="form-control" id="tower_type" name="tower_type">
                    <option value="">Tower Type</option>
                    <option value="leg_4">4 Leg</option>
                    <option value="leg_3">3 Leg</option>
                </select>
            </div>
        </div>
        <div class="form-group col-3" id="tower_height_div">
            <x-input-box colGrid="15" name="tower_height" value="{{ $tower_height }}" label="Tower Height (Ft)"/>
        </div>
        <div class="form-group col-3" id="quantity_div">
        <x-input-box colGrid="15" name="quantity" value="{{ $quantity }}" label="Quantity"/>
        </div>
        <div class="form-group col-3" id="made_by_div">
        <x-input-box colGrid="15" name="made_by" value="{{ $made_by }}" label="Made By"/>
        </div>
        <div class="form-group col-3" id="capacity_div">
        <x-input-box colGrid="15" name="capacity" value="{{ $capacity }}" label="Capacity"/>
        </div>
        <div class="form-group col-3" id="port_no_div">
        <x-input-box colGrid="15" name="port_no" value="{{ $port_no }}" label="Port No"/>
        </div>
        <div class="form-group col-3" id="installation_date_div">
        <x-input-box colGrid="15" name="installation_date" value="{{ $installation_date }}" label="Installation Date"
                     class="date"/>
        </div>
        <div class="form-group col-3" id="maintenance_date_div">
        <x-input-box colGrid="15" name="maintenance_date" value="{{ $maintenance_date }}" label="Maintenance Date"
                     class="date"/>
        </div>
        <div class="form-group col-3" id="status_div">
            <div class="input-group input-group-sm input-group-primary">
                <select class="form-control" id="status" name="status">
                    <option value="">Status</option>
                    <option value="Online">Online</option>
                    <option value="Offline">Offline</option>
                </select>
            </div>
        </div>
        <div class="form-group col-3" id="remarks_div">
        <x-input-box colGrid="15" name="remarks" value="{{ $remarks }}" label="Remarks"/>
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
    </div>
@endsection

@section('script')
    <script>
        $('.date').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        })
        $('.select2').select2();

        //using form custom function js file
        fillSelect2Options("{{ route('searchPop') }}", '#pop_id');
        fillSelect2Options("{{ route('searchIp') }}", '#ip_id');

        $('#pop_id').on('change', function () {
            getEquipment()
        })

        function getEquipment() {
            let pop_id = $('#pop_id').val();

            $.ajax({
                url: "{{ route('getPopEquipments') }}",
                type: 'get',
                dataType: "json",
                data: {
                    pop_id: pop_id
                },
                success: function (data) {
                    let dropdown;

                    dropdown = $('#material_id');
                    dropdown.empty();
                    dropdown.append('<option selected disabled>Select Material</option>');
                    dropdown.prop('selectedIndex', 0);
                    data.map(function (item) {
                        dropdown.append($('<option></option>')
                            .attr('value', item.material_id)
                            .attr('data-material_name', item.material)
                            .attr('data-brand', item.brand)
                            .attr('data-model', item.model)
                            .attr('data-serial_code', item.serial_code)
                            .text(item.label)
                        )
                    });
                    dropdown.select2()
                }
            })
        }

        $('#material_id').on('change', function () {
            let brand = $(this).find(':selected').data('brand');
            let model = $(this).find(':selected').data('model');
            let serial_code = $(this).find(':selected').data('serial_code');

            $('#brand').val(brand).attr('value', brand);
            $('#model').val(model).attr('value', model);
            $('#serial_code').val(serial_code).attr('value', serial_code);
        })

        $('#equipment_type').on('change', function () {
            onChangeEquipmentType();
        })

        function onChangeEquipmentType() {
            let type = $("#equipment_type").val();
            if (type == 'Network') {
                $('#tower_type_div').hide('slow');
                $('#tower_height_div').hide('slow');
                $('#made_by_div').hide('slow');
                $('#maintenance_date_div').hide('slow');
                $('#status_div').hide('slow');

                $('#material_div').show('slow');
                $('#serial_code_div').show('slow');
                $('#brand_div').show('slow');
                $('#model_div').show('slow');
                $('#port_no_div').show('slow');
                $('#capacity_div').show('slow');
                $('#installation_date_div').show('slow');
                $('#quantity_div').show('slow');
                $('#remarks_div').show('slow');
            } else if (type == 'Power') {
                $('#tower_type_div').hide('slow');
                $('#tower_height_div').hide('slow');
                $('#made_by_div').hide('slow');
                $('#maintenance_date_div').hide('slow');
                $('#port_no_div').hide('slow');

                $('#material_div').show('slow');
                $('#serial_code_div').show('slow');
                $('#brand_div').show('slow');
                $('#model_div').show('slow');
                $('#capacity_div').show('slow');
                $('#installation_date_div').show('slow');
                $('#quantity_div').show('slow');
                $('#remarks_div').show('slow');
                $('#status_div').show('slow');
            } else if (type == 'Tower') {
                $('#material_div').hide('slow');
                $('#serial_code_div').hide('slow');
                $('#brand_div').hide('slow');
                $('#model_div').hide('slow');
                $('#port_no_div').hide('slow');
                $('#capacity_div').hide('slow');
                $('#status_div').hide('slow');

                $('#tower_type_div').show('slow');
                $('#tower_height_div').show('slow');
                $('#made_by_div').show('slow');
                $('#maintenance_date_div').show('slow');
                $('#installation_date_div').show('slow');
                $('#quantity_div').show('slow');
                $('#remarks_div').show('slow');
            } else if (type == 'WireLess') {
                $('#tower_type_div').hide('slow');
                $('#tower_height_div').hide('slow');
                $('#made_by_div').hide('slow');
                $('#maintenance_date_div').hide('slow');
                $('#installation_date_div').hide('slow');
                $('#port_no_div').hide('slow');
                $('#status_div').hide('slow');

                $('#material_div').show('slow');
                $('#serial_code_div').show('slow');
                $('#brand_div').show('slow');
                $('#model_div').show('slow');
                $('#capacity_div').show('slow');
                $('#quantity_div').show('slow');
                $('#remarks_div').show('slow');
            }
        }
    </script>

@endsection
