@extends('layouts.backend-layout')
@section('title', 'Pop Wise Equipment')
@php
    $is_old = old('type') ? true : false;
    $form_heading = !empty($err) ? 'Update' : 'Add';
    $form_url = !empty($err) ? route('pop-equipments.update', $err->id) : route('pop-equipments.store');
    $form_method = !empty($err) ? 'PUT' : 'POST';
    
    $date = old('date', !empty($err) ? $err->date : null);
    $type = old('date', !empty($err) ? $err->type : null);
    $purpose = old('purpose', !empty($err) ? $err->purpose : null);
    $assigned_person = old('assigned_person', !empty($err) ? $err->assigned_person : null);
    $reason_of_inactive = old('reason_of_inactive', !empty($err) ? $err->reason_of_inactive : null);
    $equipment_type = old('equipment_type', !empty($err) ? $err?->equipment_type : null);
    $client_id = old('client_id', !empty($err) ? $err->client_id : null);
    $fr_no = old('fr_no', !empty($err) ? $err->fr_no : null);
    $client_name = old('client_name', !empty($err) ? $err?->client?->client_name : null);
    $client_no = old('client_no', !empty($err) ? $err?->client_no : null);
    $client_link_no = old('client_link_no', !empty($err) ? $err?->link_no : null);
    $client_address = old('client_address', !empty($err) ? $err?->client?->location : null);
    $branch_id = old('branch_id', !empty($err) ? $err->branch_id : null);
    $branch_name = old('branch_id', !empty($err) ? $err?->branch?->name : null);
    $pop_id = old('pop_id', !empty($err) ? $err->pop_id : null);
    $pop_name = old('pop_name', !empty($err) ? $err?->pop?->name : null);
    $wo_no = old('wo_no', !empty($err) ? $err?->wo_no : null);
    $pop_address = old('pop_address', !empty($err) ? $err?->pop?->address : null);
    $inactive_date = old('inactive_date', !empty($err) ? $err->inactive_date : null);
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
                    <option value="">Select pop</option>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-3">
            <div class="input-group input-group-sm input-group-primary">
                <select class="form-control" id="material_id" name="material_id" required>
                    <option value="">Select Equipment</option>
                </select>
            </div>
        </div>
        <x-input-box colGrid="3" name="serial_code" value="{{ $wo_no }}" label="Serial Code" />
        <x-input-box colGrid="3" name="brand" value="{{ $wo_no }}" label="Brand" />
        <x-input-box colGrid="3" name="model" value="{{ $wo_no }}" label="Model" />
    </div>

    <div class="row">
        <div class="form-group col-3">
            <div class="input-group input-group-sm input-group-primary">
                <select class="form-control" id="equipment_type" name="equipment_type" required>
                    <option value="">Equipment Type</option>
                    @foreach (config('businessinfo.equipmentType') as $key => $value)
                        <option value="{{ $key }}" {{ $equipment_type == $key ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group col-3">
            <div class="input-group input-group-sm input-group-primary">
                <select class="form-control" id="ip_id" name="ip_id" required>
                    <option value="" selected disabled>Select Ip Address</option>
                </select>
            </div>
        </div>

        <x-input-box colGrid="3" name="subnet_mask" value="{{ $wo_no }}" label="Subnet Mask" />
        <x-input-box colGrid="3" name="gateway" value="{{ $wo_no }}" label="Gate Way" />
    </div>

    <div class="row">
        <div class="form-group col-3">
            <div class="input-group input-group-sm input-group-primary">
                <select class="form-control" id="tower_type" name="tower_type" required>
                    <option value="">Tower Type</option>
                    <option value="leg_4">4 Leg</option>
                    <option value="leg_3">3 Leg </option>
                </select>
            </div>
        </div>
        <x-input-box colGrid="3" name="tower_height" value="{{ $wo_no }}" label="Tower Height" />
        <x-input-box colGrid="3" name="made_by" value="{{ $wo_no }}" label="Made By" />
        <x-input-box colGrid="3" name="maintenance_date" value="{{ $wo_no }}" label="Maintenance Date"
            class="date" />
    </div>

    <div class="row">
        <x-input-box colGrid="3" name="capacity" value="{{ $wo_no }}" label="Capacity" />
        <x-input-box colGrid="3" name="port_no" value="{{ $wo_no }}" label="Port No" />
        <x-input-box colGrid="3" name="installation_date" value="{{ $wo_no }}" label="Installation Date"
            class="date" />
        <x-input-box colGrid="3" name="remarks" value="{{ $wo_no }}" label="Remarks" />
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
        $('.date').datepicker()
        $('.select2').select2();

        //using form custom function js file
        fillSelect2Options("{{ route('searchPop') }}", '#pop_id');
        fillSelect2Options("{{ route('searchIp') }}", '#ip_id');

        $('#pop_id').on('change', function() {
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
                success: function(data) {
                    let dropdown;

                    dropdown = $('#material_id');
                    dropdown.empty();
                    dropdown.append('<option selected disabled>Select Material</option>');
                    dropdown.prop('selectedIndex', 0);
                    data.map(function(item) {
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

        $('#material_id').on('change', function() {
            let brand = $(this).find(':selected').data('brand');
            let model = $(this).find(':selected').data('model');
            let serial_code = $(this).find(':selected').data('serial_code');

            $('#brand').val(brand).attr('value', brand);
            $('#model').val(model).attr('value', model);
            $('#serial_code').val(serial_code).attr('value', serial_code);
        })
    </script>

@endsection
