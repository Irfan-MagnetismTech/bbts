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
        <div class="form-group col-3">
            <label for="date">Applied Date:</label>
            <input class="form-control date" id="date" name="date" aria-describedby="date"
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

        <div class="form-group col-3">
            <label for="select2">From Branch</label>
            <select class="form-control select2" id="branch_id" name="branch_id">
                <option value="" selected>Select Branch</option>
            </select>
        </div>

        <div class="form-group col-3 assigned_person">
            <label for="assigned_person">Assigned Person:</label>
            <input type="text" class="form-control" id="assigned_person" aria-describedby="assigned_person"
                name="assigned_person" value="{{ old('assigned_person') ?? (@$assigned_person ?? '') }}">
        </div>

        <div class="form-group col-3 reason_of_inactive">
            <label for="reason_of_inactive">Reason of Inactive:</label>
            <input type="text" class="form-control" id="reason_of_inactive" aria-describedby="reason_of_inactive"
                name="reason_of_inactive" value="{{ old('reason_of_inactive') ?? (@$reason_of_inactive ?? '') }}">
        </div>

        <div class="form-group col-3 inactive_date">
            <label for="inactive_date">Permanently Inactive Date:</label>
            <input class="form-control date" id="inactive_date" name="inactive_date" aria-describedby="inactive_date"
                value="{{ old('inactive_date') ?? (@$inactive_date ?? '') }}" readonly placeholder="Select a Date">
        </div>
    </div>

    <div class="row">
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
            <input type="text" class="form-control" id="client_name" aria-describedby="client_name"
                name="client_name" value="{{ old('client_name') ?? (@$client_name ?? '') }}" placeholder="Search...">
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
            <input type="text" class="form-control" id="client_no" aria-describedby="client_no" name="client_no"
                readonly value="{{ old('client_no') ?? (@$client_no ?? '') }}">
        </div>

        <div class="form-group col-3 client_address">
            <label for="client_address">Client Address:</label>
            <input type="text" class="form-control" id="client_address" name="client_address"
                aria-describedby="client_address" readonly
                value="{{ old('client_address') ?? (@$client_address ?? '') }}">
        </div>
    </div>

    <table class="table table-bordered" id="errTable">
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
                <th colspan="2">Ownership</th>
                <th colspan="2">Damaged</th>
                <th colspan="2">Useable</th>
                <th rowspan="2">Quantity</th>
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

        </tbody>
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
        $('.date').datepicker({
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
                    $('#pop_id').trigger('change');

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
                $('.pop_name').show('slow');
                $('.pop_address').show('slow');
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

        @if ($form_method == 'PUT')
            $(document).on('DOMNodeInserted', '#branch_id', function() {
                let selectedValue = "{{ $branch_id }}"
                $('#branch_id').val(selectedValue)
            });
        @endif

        $(document).on('change', '#fr_no, #pop_id, #link_no', function() {
            emptyRow()
            let type = $("input[name='type']:checked").val();
            let fr_no = $('#fr_no').val();
            let pop_name = $('#pop_name').val();
            let client_no = $('#client_no').val();
            let equipment_type = $('#equipment_type').val();
            let link_no = $('#link_no').val();
            let pop_id = $('#pop_id').val();

            let url = "{{ route('clientMurWiseMaterials') }}";

            $.ajax({
                url: url,
                type: 'get',
                dataType: "json",
                data: {
                    type: type,
                    fr_no: fr_no,
                    pop_name: pop_name,
                    client_no: client_no,
                    equipment_type: equipment_type,
                    link_no: link_no,
                    pop_id: pop_id,
                },
                success: function(data) {
                    $.each(data, function(key, value) {
                        addRow(value)
                    });
                }
            });

        });

        function addRow(value) {
            let row = `<tr>
                            <td>
                                <input name="material_name[]" class="form-control material_name" readonly autocomplete="off" type="text" value="${value.material_name}" readonly>
                                <input name="material_id[]" class="form-control material_id" readonly autocomplete="off" type="hidden" value="${value.material_id}">
                            </td>
                            <td>
                                <input name="description[]" class="form-control description" autocomplete="off" type="text" value="">
                            </td>
                            <td>
                                <input name="utilized_quantity[]" class="form-control utilized_quantity" autocomplete="off" type="text" value="${value.utilized_quantity}" readonl>
                            </td>
                            <td>
                                <input name="item_code[]" class="form-control item_code" autocomplete="off" type="text" value="${value.item_code}" readonly>
                            </td>
                            <td>
                                <input name="unit[]" class="form-control unit" autocomplete="off" type="text" value="${value.unit}" readonly>
                            </td>
                            <td>
                                <input name="brand_name[]" class="form-control brand_name" autocomplete="off" type="text" value="${value.brand_name}" readonly>
                            </td>
                            <td>
                                <input name="model[]" class="form-control model" autocomplete="off" type="text" value="${value.model}" readonly>
                            </td>
                            <td>
                                <input name="serial_code[]" class="form-control serial_code" autocomplete="off" type="text" value="${value.serial_code}" readonly>
                            </td>
                            <td>
                                <input name="bbts_ownership[]" class="form-control bbts_ownership" autocomplete="off" type="text" value="${value.bbts_ownership}" readonly>
                            </td>
                            <td>
                                <input name="client_ownership[]" class="form-control client_ownership" autocomplete="off" type="text" value="${value.client_ownership}" readonly>
                            </td>
                            <td>
                                <input name="bbts_damaged[]" class="form-control bbts_damaged" autocomplete="off" type="number" value="0">
                            </td>
                            <td>
                                <input name="client_damaged[]" class="form-control client_damaged" autocomplete="off" type="number" value="0">
                            </td>
                            <td>
                                <input name="bbts_useable[]" class="form-control bbts_useable" autocomplete="off" type="number" value="0">
                            </td>
                            <td>
                                <input name="client_useable[]" class="form-control client_useable" autocomplete="off" type="number" value="0">   
                            </td>
                            <td>
                                <input name="quantity[]" class="form-control quantity" autocomplete="off" type="number" value="0" readonly>
                            </td>
                            <td>
                                <input name="remarks[]" class="form-control remarks" autocomplete="off" value="">
                            </td>
                        </tr>
                    `;
            $('#errTable tbody').append(row);
        }

        function emptyRow() {
            $('#errTable tbody').empty();
        }

        //on keyup bbts_damaged or client_damaged or bbts_useable or client_useable add value to quantity
        $(document).on('input', '.bbts_damaged, .client_damaged, .bbts_useable, .client_useable', function() {
            let bbts_damaged = $(this).closest('tr').find('.bbts_damaged').val();
            let client_damaged = $(this).closest('tr').find('.client_damaged').val();
            let bbts_useable = $(this).closest('tr').find('.bbts_useable').val();
            let client_useable = $(this).closest('tr').find('.client_useable').val();
            let quantity = $(this).closest('tr').find('.quantity').val();

            let total = parseInt(bbts_damaged) + parseInt(client_damaged) + parseInt(bbts_useable) + parseInt(
                client_useable);
            $(this).closest('tr').find('.quantity').val(total);
        });

        $(document).on('click', '.bbts_damaged, .client_damaged, .bbts_useable, .client_useable', function() {
            $(this).select();
        });

        //quantity cannot be greater than utilized_quantity
        $(document).on('input', '.bbts_damaged, .client_damaged, .bbts_useable, .client_useable', function() {
            let utilized_quantity = $(this).closest('tr').find('.utilized_quantity').val();
            let quantity = $(this).closest('tr').find('.quantity').val();

            if (parseInt(quantity) > parseInt(utilized_quantity)) {
                swal.fire({
                    title: "Quantity cannot be greater than utilized quantity",
                    type: "warning",
                })

                $(this).closest('tr').find('.quantity').val(0);
                $(this).closest('tr').find('.bbts_damaged').val(0);
                $(this).closest('tr').find('.client_damaged').val(0);
                $(this).closest('tr').find('.bbts_useable').val(0);
                $(this).closest('tr').find('.client_useable').val(0);
            }
        });
    </script>

    <script src="{{ asset('js/search-client.js') }}"></script>

@endsection
