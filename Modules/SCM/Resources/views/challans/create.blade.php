@extends('layouts.backend-layout')
@section('title', 'Challan')
@php
    $is_old = old('type') ? true : false;
    $form_heading = !empty($challan) ? 'Update' : 'Add';
    $form_url = !empty($challan) ? route('challans.update', $challan->id) : route('challans.store');
    $form_method = !empty($challan) ? 'PUT' : 'POST';

    $date = old('date', !empty($challan) ? $challan->date : null);
    $type = old('date', !empty($challan) ? $challan->type : null);
    $scm_requisition_id = old('scm_requisition_id', !empty($challan) ? $challan->scm_requisition_id : null);
    $scm_requisition_no = old('mrs_no', !empty($challan) ? $challan->scmRequisition->mrs_no : null);
    $purpose = old('purpose', !empty($challan) ? $challan->purpose : null);
    $fr_no = old('fr_no', !empty($challan) ? $challan->fr_no : null);
    $link_no = old('link_no', !empty($challan) ? $challan->link_no : null);
    $client_name = old('client_name', !empty($challan) ? $challan?->client?->client_name : null);
    $equipment_type = old('equipment_type', !empty($challan) ? $challan?->equipment_type : null);
    $client_no = old('client_no', !empty($challan) ? $challan?->client?->client_no : null);
    $client_address = old('client_address', !empty($challan) ? $challan?->feasibilityRequirementDetail?->location : null);
    $branch_id = old('branch_id', !empty($challan) ? $challan->branch_id : null);
    $branch_name = old('branch_id', !empty($challan) ? $challan?->branch?->name : null);
    $pop_id = old('pop_id', !empty($challan) ? $challan->pop_id : null);
    $pop_name = old('pop_name', !empty($challan) ? $challan?->pop?->name : null);
    $pop_address = old('pop_address', !empty($challan) ? $challan?->pop?->address : null);

@endphp

@section('breadcrumb-title')
    {{ $form_heading }} Challan
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
@endsection
@section('breadcrumb-button')
    <a href="{{ route('challans.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
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
            <div class="mt-2 mb-4">
                <div class="form-check-inline">
                    <label class="form-check-label" for="client">
                        <input type="radio" class="form-check-input radioButton" id="client" name="type"
                            value="client" @checked(@$type == 'client' || ($form_method == 'POST' && !old()))> Client
                    </label>
                </div>
                <div class="form-check-inline">
                    <label class="form-check-label" for="pop">
                        <input type="radio" class="form-check-input radioButton" id="pop" name="type"
                            value="pop" @checked(@$type == 'pop')>
                        POP
                    </label>
                </div>
                <div class="form-check-inline">
                    <label class="form-check-label" for="general">
                        <input type="radio" class="form-check-input radioButton" id="general" name="type"
                            value="general" @checked(@$type == 'general')>
                        General
                    </label>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-3 date">
            <label for="date">Applied Date <span class="text-danger">*</span>:</label>
            <input class="form-control" id="date" name="date" aria-describedby="date"
                value="{{ old('date') ?? (@$date ?? '') }}" readonly placeholder="Select a Date">
        </div>
        <div class="form-group col-3 mrs_no">
            <label for="select2">MRS No <span class="text-danger">*</span></label>
            <input class="form-control" id="mrs_no" name="mrs_no" aria-describedby="mrs_no"
                value="{{ old('mrs_no') ?? (@$scm_requisition_no ?? '') }}" placeholder="Search a MRS No">
            <input class="form-control" id="scm_requisition_id" name="scm_requisition_id"
                aria-describedby="scm_requisition_id"
                value="{{ old('scm_requisition_id') ?? (@$scm_requisition_id ?? '') }}" type="hidden">
        </div>
        <div class="form-group col-3">
            <label for="select2">Purpose <span class="text-danger">*</span></label>
            <select class="form-control select2" id="purpose" name="purpose">
                <option value="" selected>Select Purpose</option>
                @foreach (config('businessinfo.challanPurpose') as $key => $value)
                    <option value="{{ $value }}" {{ old('purpose', @$purpose) == $value ? 'selected' : '' }}>
                        {{ $value }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-3 branch_name">
            <label for="select2">Branch Name <span class="text-danger">*</span></label>
            <input class="form-control" type="text" id="branch_name" name="branch_name" readonly
                value="{{ old('branch_name') ?? (@$branch_name ?? '') }}">
            <input type="hidden" name="branch_id" value="{{ old('branch_id') ?? (@$branch_id ?? '') }}" id="branch_id">
        </div>
        {{-- <div class="form-group col-3 branch_name">
            <label for="client_no">Branch Name:</label>
            <input type="text" class="form-control" id="branch_name" aria-describedby="branch_name" name="branch_name"
                readonly value="{{ old('branch_name') ?? (@$branch_name ?? '') }}">
                <input type="hidden" id="branch_id" name="branch_id" value="{{ old('branch_id') ?? (@$branch_id ?? '') }}">
            </div>
        </div> --}}

    </div>
    <div class="row">
        <div class="form-group col-3 employee">
            {{-- @dd($requisition) --}}
            <input type="hidden" id="employee_id" name="employee_id"
                value="{{ !empty($requisition->employee) ? $requisition->employee->id : '' }}">
            <label for="employee">Employee</label>
            <input type="text" class="form-control" readonly id="employee" aria-describedby="employee" name="employee"
                value="{{ old('employee') ?? (@$requisition->employee->name ?? '') }}" placeholder="Employee Name">

        </div>
        {{-- <div class="pop-up-type">

        </div> --}}
        {{-- <div class="form-group col-3 equipment_type type">
            <label for="equipment_type">Type:</label>
            <select class="form-control select2" id="equipment_type" name="equipment_type">
                <option value="Service Equipment" @if ($equipment_type == 'Service Equipment') selected @endif>Service Equipment
                </option>
                <option value="Link" @if ($equipment_type == 'Link') selected @endif>Link</option>
            </select>

        </div> --}}
        <div class="form-group col-3 equipment_type type" id="pop-up-type">
            <label for="client_name">Type:</label>
            <input type="text" class="form-control" id="equipment_type" aria-describedby="equipment_type"
                name="equipment_type" readonly value="{{ old('equipment_type') ?? (@$equipment_type ?? '') }}">
        </div>




        <div class="form-group col-3 client_no">
            <label for="client_no">Client Name:</label>
            <input type="text" class="form-control" id="client_name" aria-describedby="client_name"
                name="client_name" readonly value="{{ old('client_name') ?? (@$client_name ?? '') }}">
        </div>
        {{-- <div class="form-group col-3 fr_no">
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
        </div> --}}
        <div class="form-group col-3 client_no">
            <label for="client_no">Fr No:</label>
            <input type="text" class="form-control" id="fr_no" aria-describedby="fr_no" name="fr_no" readonly
                value="{{ old('fr_no') ?? (@$fr_no ?? '') }}">
        </div>

        {{-- <div class="form-group col-3 link_no">
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
        </div> --}}
        <div class="form-group col-3 client_no">
            <label for="client_no">Link No:</label>
            <input type="text" class="form-control" id="link_no" aria-describedby="link_no" name="link_no"
                readonly value="{{ old('link_no') ?? (@$link_no ?? '') }}">
        </div>

        <div class="form-group col-3 client_no">
            <label for="client_no">Client No:</label>
            <input type="text" class="form-control" id="client_no" aria-describedby="client_no" name="client_no"
                readonly value="{{ old('client_no') ?? (@$client_no ?? '') }}">
        </div>

        <div class="form-group col-3 client_address">
            <label for="client_address">Client Address:</label>
            <input type="text" class="form-control" id="client_address" name="client_address"
                aria-describedby="client_address" readonly
                value="{{ old('client_address') ?? (@$client_address ?? '') }}">
        </div>

        <div class="form-group col-3 pop_name">
            <label for="select2">Pop Name</label>
            <input class="form-control" id="pop_name" name="pop_name" aria-describedby="pop_name"
                value="{{ old('pop_name') ?? (@$pop_name ?? '') }}" readonly placeholder="POP Name">
            <input type="hidden" class="form-control" id="pop_id" name="pop_id" aria-describedby="pop_id"
                value="{{ old('pop_id') ?? (@$pop_id ?? '') }}">
        </div>
        <div class="form-group col-3 pop_address">
            <label for="select2">Pop Address</label>
            <input class="form-control" id="pop_address" name="pop_address" readonly aria-describedby="pop_address"
                value="{{ old('pop_address') ?? (@$pop_address ?? '') }}" readonly placeholder="POP Address">
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
    <div class="row" id="dataContainer" @if (empty($challan) && empty(old('material_name'))) style="display: none;" @endif>
        <table class="table table-bordered" id="challan">
            <thead>
                <tr>
                    <th>Material Name</th>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Received Type</th>
                    <th>Type No</th>
                    <th>Serial/Drum Code <br /> No</th>
                    <th>Unit</th>
                    <th>Available</th>
                    <th>MRS Quantity</th>
                    <th>Issued Qty</th>
                    <th>Remarks</th>
                    <th><i class="btn btn-primary btn-sm fa fa-plus add-challan-row"></i></th>
                </tr>
            </thead>
            <tbody id="challanDataBody">
                @php
                    $Challan_Lines = old('material_id', !empty($challan) ? $challan->scmChallanLines->pluck('material_id') : []);
                    $received_type = old('received_type', !empty($challan) ? $challan->scmChallanLines->pluck('received_type') : []);
                    $received_no = old('type_no', !empty($challan) ? $challan->scmChallanLines->pluck('received_no') : []);
                    $receiveable_id = old('type_id', !empty($challan) ? $challan->scmChallanLines->pluck('receiveable_id') : []);
                    $item_code = old('item_code', !empty($challan) ? $challan->scmChallanLines->pluck('material.code') : []);
                    $material_type = old('material_type', !empty($challan) ? $challan->scmChallanLines->pluck('material.type') : []);
                    $brand_id = old('brand_id', !empty($challan) ? $challan->scmChallanLines->pluck('brand_id') : []);
                    $model = old('model', !empty($challan) ? $challan->scmChallanLines->pluck('model') : []);
                    $material_id = old('material_id', !empty($challan) ? $challan->scmChallanLines->pluck('material_id') : []);
                    $serial_code = old('material_id', !empty($challan) ? json_decode($challan->scmChallanLines->pluck('serial_code')) : []);
                    $unit = old('unit', !empty($challan) ? $challan->scmChallanLines->pluck('material.unit') : []);
                    $quantity = old('final_mark', !empty($challan) ? $challan->scmChallanLines->pluck('quantity') : []);
                    $remarks = old('warranty_period', !empty($challan) ? $challan->scmChallanLines->pluck('remarks') : []);
                    $mrs_quantity = old('mrs_quantity', !empty($challan) ? $challan->scmChallanLines->pluck('mrs_quantity') : []);

                @endphp
                @foreach ($Challan_Lines as $key => $Challan_Line)
                    {{-- @dd($materials[$key]) --}}
                    <tr>
                        <td class="form-group">
                            <select class="form-control material_name select2" name="material_name[{{ $key }}]"
                                required>
                                <option value="" readonly selected>Select Material</option>

                                @foreach ($materials[$key] as $key1 => $value)
                                    <option value="{{ $value->material->id }}" data-type="{{ $value->material->type }}"
                                        data-unit="{{ $value->material->unit }}"
                                        data-code="{{ $value->material->code }}" readonly @selected($material_id[$key] == $value->material->id)>
                                        {{ $value->material->name }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="item_code[{{ $key }}]" class="form-control item_code"
                                autocomplete="off" value="{{ $item_code[$key] }}">
                            <input type="hidden" name="material_type[{{ $key }}]"
                                class="form-control material_type" autocomplete="off"
                                value="{{ $material_type[$key] }}">
                        </td>

                        <td>

                            <select name="brand[{{ $key }}]" class="form-control brand select2"
                                autocomplete="off" required>
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
                        <td>
                            <select name="received_type[{{ $key }}]" class="form-control received_type"
                                autocomplete="off" required>
                                <option value="">Select Out From</option>
                                @foreach (config('businessinfo.receivedTypes') as $typeKey => $typevalue)
                                    <option value="{{ $typevalue }}" @selected($received_type[$key] == $typevalue)>
                                        {{ strToUpper($typevalue) }}</option>
                                @endforeach
                            </select>
                        </td>

                        <td>
                            <select name="type_id[{{ $key }}]" class="form-control type_id select2"
                                autocomplete="off" required>
                                <option value="">Select Type</option>
                                @foreach ($type_no[$key] as $typeKey => $typevalue)
                                    <option value="{{ $typevalue['id'] }}" @selected($receiveable_id[$key] == $typevalue['id'])>
                                        {{ $typevalue['type_no'] }}</option>
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
                            <input name="unit[{{ $key }}]" class="form-control unit" readonly
                                autocomplete="off" type="text" value="{{ $unit[$key] }}">
                        </td>
                        <td>
                            <input name="avaiable_quantity[{{ $key }}]" class="form-control avaiable_quantity"
                                autocomplete="off" value="{{ $branch_stock[$key] }}" readonly>
                        </td>
                        <td>
                            <input name="mrs_quantity[{{ $key }}]" class="form-control mrs_quantity"
                                autocomplete="off" value="{{ $mrs_quantity[$key] }}" readonly>
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
        // $('#date').datepicker({
        //     format: "dd-mm-yyyy",
        //     autoclose: true,
        //     todayHighlight: true,
        //     showOtherMonths: true
        // }).datepicker("setDate", new Date());

        if ($('#date').val() != null) {
            $('#date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                showOtherMonths: true
            });
        } else {
            $('#date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                showOtherMonths: true
            }).datepicker("setDate", new Date());
        }

        /* Append row */
        $(document).ready(function() {
            @if (empty($challan) && empty(old('material_name')))
                appendCalculationRow();
            @endif
        })

        var indx = 0;
        @if ($form_method == 'PUT')
            indx = {{ count($Challan_Lines) }}
        @endif

        let global_challan_row;

        function appendCalculationRow() {
            let row = `<tr>
                            <td class="form-group">
                                <select class="form-control material_name select2" name="material_name[${indx}]" required>
                                    <option value="" readonly selected>Select Material</option>
                                </select>
                                <input type="hidden" name="item_code[${indx}]" class="form-control item_code" autocomplete="off">
                                <input type="hidden" name="material_type[${indx}]" class="form-control material_type" autocomplete="off">
                            </td>
                            <td>
                                <select class="form-control brand select2" name="brand[${indx}]" autocomplete="off" required>
                                    <option value="" readonly selected>Select Brand</option>

                                </select>
                            </td>
                            <td>
                                <select class="form-control model select2" name="model[${indx}]">
                                    <option value="" readonly selected>Select Model</option>
                                </select>
                            </td>
                            <td>
                                <select name="received_type[${indx}]" class="form-control received_type" autocomplete="off" required>
                                    <option value="">Select Out From</option>
                                    @foreach (config('businessinfo.receivedTypes') as $value)
            <option value="{{ $value }}">{{ strToUpper($value) }}</option>
                                    @endforeach
            </select>
        </td>
        <td>
            <select name="type_id[${indx}]" class="form-control type_id select2" autocomplete="off" required>
                                    <option value="">Select Type No</option>
                                </select>
                            </td>

                            <td class="select2_container">
                                <select class="form-control serial_code select2" name='serial_code[${indx}][]' multiple="multiple">

                                </select>
                            </td>
                            <td>
                                <input name="unit[${indx}]" class="form-control unit" readonly autocomplete="off" type="text">
                            </td>
                            <td>
                                <input class="form-control available_quantity" name="available_quantity[${indx}]" aria-describedby="available_quantity" readonly>
                            </td>
                            <td>
                                <input class="form-control mrs_quantity" name="mrs_quantity[${indx}]" aria-describedby="mrs_quantity" readonly>
                            </td>
                            <td>
                                <input name="quantity[${indx}]" class="form-control quantity" autocomplete="off">
                            </td>
                            <td>
                                <input name="remarks[${indx}]" class="form-control remarks" autocomplete="off">
                            </td>
                            <td>
                                <i class="btn btn-danger btn-sm fa fa-minus remove-challan-row"></i>
                            </td>
                        </tr>
                    `;

            @if ($form_method == 'PUT')
                indx = {{ count($Challan_Lines) }}
                let materials = @json($materials[0]);
                let material_options = '<option value="" readonly selected>Select Material</option>';
                materials.forEach((material, index) => {
                    material_options += '<option value="' + material.material.id + '"data-unit="' + material
                        .material.unit + '"data-code="' + material.material.code + '"data-type="' + material
                        .material.type + '">' + material.material.name + '</option>';
                });
                row = row.replace('Select Material', material_options);
                $('#challan tbody').append(row);
                $('.select2').select2({});
            @else
                if ($('#challan tbody tr').length > 0) {
                    // row = $('#challan tbody tr').last().clone();
                    // row.find('input').val('');
                    // //change index name from name attribute of input like material_name[0] to material_name[1]

                    // row.find('select').val('');
                    // row.find('span').remove();
                    // $('#challan tbody').append(row);
                    // $('.select2').select2({});
                    let row = $('#challan tbody tr').last().clone();

                    // Increment the index in the name attributes
                    row.find('[name]').each(function() {
                        let nameAttr = $(this).attr('name');
                        if (nameAttr) {
                            let newName = nameAttr.replace(/\[(\d+)\]/, '[' + indx + ']');
                            $(this).attr('name', newName);
                        }
                    });

                    // Clear input values
                    row.find('input').val('');

                    // Clear select values
                    row.find('select').val('');
                    row.find('span').remove();

                    // Append the modified row to the tbody
                    $('#challan tbody').append(row);

                    // Initialize Select2
                    $('.select2').select2({});
                } else {
                    row.find('[name]').each(function() {
                        let nameAttr = $(this).attr('name');
                        if (nameAttr) {
                            let newName = nameAttr.replace(/\[(\d+)\]/, '[' + indx + ']');
                            $(this).attr('name', newName);
                        }
                    });
                    row.find('input').val('');
                    row.find('select').val('');
                    row.find('span').remove();

                    $('#challan tbody').append(row);
                    $('.select2').select2({});
                    $('.select2.serial_code').select2({
                        multiple: true,
                    });
                }
            @endif
            indx++;

        }

        /* Adds and removes quantity row on click */
        $("#challan")
            .on('click', '.add-challan-row', () => {
                if (global_challan_row) {
                    global_challan_row.find('input').val('');
                    global_challan_row.find('select').val('');
                    global_challan_row.find('span').remove();
                    $('#challan tbody').append(global_challan_row);
                    $('.select2').select2({});
                } else {
                    console.log('append');
                    appendCalculationRow();
                }
            })
            .on('click', '.remove-challan-row', function() {
                global_challan_row = $(this).closest('tr').clone();
                $(this).closest('tr').remove();
            });


        $(function() {
            onChangeRadioButton();

            $('.select2').select2({
                maximumSelectionLength: 5,
                scrollAfterSelect: true
            });

            //using form custom function js file
            // fillSelect2Options("{{ route('searchBranch') }}", '#branch_id');
            // associativeDropdown("{{ route('searchPop') }}", 'search', '#branch_id', '#pop_name', 'get', null)

            $(".radioButton").click(function() {
                onChangeRadioButton()
            });

            var scmMatareialDetailWithMaterial;

            $("#mrs_no").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('search_mrs_for_challan') }}",
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
                                ?.connectivity_point);
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
                            $('#dataContainer').show();
                            $('.loading').hide();
                        }
                    });
                    return false;
                }
            })
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
                $('.pop_name').hide('slow').addClass("d-none");
                $('.pop_address').hide('slow').addClass("d-none");
                $('.address').show('slow');
                $('.client_name').show('slow');
                $('.client_no').show('slow');
                $('.client_address').show('slow');
                $('.type').show('slow').removeClass("d-none");
                $('.link_no').show('slow');
                $('.fr_no').show('slow');
                $('.fr_id').show('slow');
                $('.employee').show('slow').addClass("d-none");
            } else if (radioValue == 'pop') {
                $('.pop_id').show('slow');
                $('.pop_name').show('slow').removeClass("d-none");
                $('.pop_address').show('slow').removeClass("d-none");
                $('.address').hide('slow');
                $('.client_name').hide('slow');
                $('.client_no').hide('slow');
                $('.client_address').hide('slow');
                $('.type').hide('slow').addClass("d-none")
                $('.link_no').hide('slow');
                $('.fr_no').hide('slow');
                $('.fr_id').hide('slow');
                $('.employee').show('slow').addClass("d-none");
            } else if (radioValue == 'general') {
                $('.pop_id').show('slow');
                $('.pop_name').show('slow').removeClass("d-none");
                $('.pop_address').show('slow').removeClass("d-none");
                $('.address').hide('slow');
                $('.client_name').hide('slow');
                $('.client_no').hide('slow');
                $('.client_address').hide('slow');
                $('.type').hide('slow').addClass("d-none")
                $('.link_no').hide('slow');
                $('.fr_no').hide('slow');
                $('.fr_id').show('slow');
                $('.employee').show('slow').removeClass("d-none");
            }
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
                        if (item.type_no != null) {
                            html +=
                                `<option value="${item.id}" data-quantity="${item.quantity}" data-type_no="${item.type_no}">${item.type_no}</option>`;
                        }
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
            let available_quantity = $(this).closest('tr').find('.type_id').find(':selected').data(
                'quantity');
            console.log('avaiable_quantity', available_quantity);
            $(this).closest('tr').find('.available_quantity').val(available_quantity);
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
                },
                success: function(data) {
                    let html = '';
                    $.each(data, function(key, item) {
                        if (item.value != null) {
                            html += `<option value="${item.value}">${item.label}</option>`;
                        }
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
            let material_type = $(this).closest('tr').find('.material_name').find(':selected').data(
                'type');
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
    </script>
    <script src="{{ asset('js/search-client.js') }}"></script>
@endsection
