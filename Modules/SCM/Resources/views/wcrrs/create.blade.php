@extends('layouts.backend-layout')
@section('title', 'Warranty Claim Receive')
@php
    $is_old = old('type') ? true : false;
    $form_heading = !empty($warranty_claims_receife) ? 'Update' : 'Add';
    $form_url = !empty($warranty_claims_receife) ? route('warranty-claims-receives.update', $warranty_claims_receife->id) : route('warranty-claims-receives.store');
    $form_method = !empty($warranty_claims_receife) ? 'PUT' : 'POST';

    $date = old('date', !empty($warranty_claims_receife) ? $warranty_claims_receife->date : null);
    $wcr_no = old('wcr_no', !empty($warranty_claims_receife) ? $warranty_claims_receife->wcr->wcr_no : null);
    $wcr_id = old('wcr_id', !empty($warranty_claims_receife) ? $warranty_claims_receife->wcr_id : null);
    $send_date = old('send_date', !empty($warranty_claims_receife) ? $warranty_claims_receife->wcr->sending_date : null);
    $branch_id = old('branch_id', !empty($warranty_claims_receife) ? $warranty_claims_receife->branch_id : null);
    $branch_name = old('branch_id', !empty($warranty_claims_receife) ? $warranty_claims_receife?->branch?->name : null);

@endphp

@section('breadcrumb-title')
    {{ $form_heading }} Warranty Claim Receive
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/switchery.min.css') }}" />
@endsection
@section('breadcrumb-button')
    <a href="{{ route('warranty-claims-receives.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
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
        <div class="form-group col-3 date">
            <label for="date">Date:</label>
            <input type="text" class="form-control" id="date" aria-describedby="date" name="date" readonly
                value="{{ old('date') ?? (@$date ?? '') }}">
        </div>
        <div class="form-group col-3 wcr_no">
            <label for="wcr_no">Wcr No:</label>
            <input type="text" class="form-control" id="wcr_no" aria-describedby="wcr_no" name="wcr_no"
                value="{{ old('wcr_no') ?? (@$wcr_no ?? '') }}">
            <input type="hidden" class="form-control" id="wcr_id" aria-describedby="wcr_id" name="wcr_id"
                value="{{ old('wcr_id') ?? (@$wcr_id ?? '') }}">

        </div>
        <div class="form-group col-3 send_date">
            <label for="send_date">Send Date:</label>
            <input type="text" class="form-control" id="send_date" aria-describedby="send_date" name="send_date" readonly
                value="{{ old('send_date') ?? (@$send_date ?? '') }}">
        </div>
        <div class="form-group col-3 branch_name">
            <label for="">Branch</label>
            <select class="form-control " id="branch_id" name="branch_id">
                <option value="">Select Branch</option>
                @foreach ($branches as $branch)
                    <option value="{{ $branch->id }}" @if ($branch_id == $branch->id) selected @endif>
                        {{ $branch->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <table class="table table-bordered" id="challan">
        <thead>
            <tr>
                <th>Receive Status</th>
                <th>Material Name</th>
                <th>Model</th>
                <th>Brand</th>
                <th>Serial Code</th>
                <th>Unit</th>
            </tr>
        </thead>
        <tbody>
            @php
                $material_id = old('material_id', !empty($warranty_claims_receife) ? $warranty_claims_receife->lines->pluck('material_id') : []);
                $material_name = old('material_name', !empty($warranty_claims_receife) ? $warranty_claims_receife->lines->pluck('material.name') : []);
                $item_code = old('item_code', !empty($warranty_claims_receife) ? $warranty_claims_receife->lines->pluck('material.code') : []);
                $material_type = old('material_type', !empty($warranty_claims_receife) ? $warranty_claims_receife->lines->pluck('material.type') : []);
                $serial_code = old('serial_code', !empty($warranty_claims_receife) ? $warranty_claims_receife->lines->pluck('serial_code') : []);
                $brand_id = old('brand_id', !empty($warranty_claims_receife) ? $warranty_claims_receife->lines->pluck('brand_id') : []);
                $brand_name = old('brand_name', !empty($warranty_claims_receife) ? $warranty_claims_receife->lines->pluck('brand.name') : []);
                $model = old('model', !empty($warranty_claims_receife) ? $warranty_claims_receife->lines->pluck('model') : []);
                $unit = old('unit', !empty($warranty_claims_receife) ? $warranty_claims_receife->lines->pluck('material.unit') : []);

            @endphp
            @foreach ($material_id as $key => $wcr_Line)
                <tr>
                    <td>
                        <input type="checkbox" class="js-primary" checked name="status[{{ $key }}]"
                            value="1" />
                    </td>
                    <td>
                        <input type="text" name="material_name[{{ $key }}]" class="form-control material_name"
                            autocomplete="off" value="{{ $material_name[$key] }}">
                        <input type="hidden" name="material_id[{{ $key }}]" class="form-control material_id"
                            autocomplete="off" value="{{ $material_id[$key] }}">
                        <input type="hidden" name="item_code[{{ $key }}]" class="form-control item_code"
                            autocomplete="off" value="{{ $item_code[$key] }}">
                        <input type="hidden" name="material_type[{{ $key }}]" class="form-control material_type"
                            autocomplete="off" value="{{ $material_type[$key] }}">
                    </td>
                    <td class="form-group">
                        <input type="text" name="brand_name[{{ $key }}]" class="form-control brand_name"
                            autocomplete="off" readonly value="{{ $brand_name[$key] }}">
                        <input type="hidden" name="brand_id[{{ $key }}]" class="form-control brand_id"
                            autocomplete="off" value="{{ $brand_id[$key] }}">
                    </td>
                    <td>
                        <input type="text" name="model[{{ $key }}]" class="form-control model"
                            autocomplete="off" readonly value="{{ $model[$key] }}">
                    </td>
                    <td>
                        <input type="text" name="serial_code[{{ $key }}]" class="form-control serial_code"
                            autocomplete="off" readonly value="{{ $serial_code[$key] }}">
                    </td>
                    <td class="">
                        <input type="text" name="unit[{{ $key }}]" class="form-control unit" autocomplete="off"
                            readonly value="{{ $unit[$key] }}">
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
    <script src="{{ asset('/js/switchery.min.js') }}"></script>
    <script>
        const CSRF_TOKEN = "{{ csrf_token() }}";
        $('#date').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true,
            showOtherMonths: true
        }).datepicker("setDate", new Date());;

        function switchInitialization() {
            var elemsPrimary = document.querySelectorAll('.js-primary');
            elemsPrimary.forEach(function(elem) {
                new Switchery(elem, {
                    color: '#4099ff',
                    jackColor: '#fff',
                    size: 'small'
                });
            });
        }
        var indx = 1;
        @if ($form_method == 'PUT')

            indx = {{ count($warranty_claims_receife->lines) + 1 }}
        @endif

        function addRow(val) {
            let row = `<tr>
                     <td>
                        <input type="checkbox" class="js-primary" name="status[${indx}]" value="1"/>
                    </td>
                        <td>
                            <input type="text" name="material_name[${indx}]" class="form-control material_name" autocomplete="off" value="${val.material_name}">
                            <input type="hidden" name="material_id[${indx}]" class="form-control material_id" autocomplete="off" value="${val.material_id}">
                            <input type="hidden" name="item_code[${indx}]" class="form-control item_code" autocomplete="off" value="${val.item_code}"> 
                            <input type="hidden" name="material_type[${indx}]" class="form-control material_type" autocomplete="off" value="${val.item_type}"> 
                        </td>
                        <td class="form-group">
                            <input type="text" name="brand_name[${indx}]" class="form-control brand_name" autocomplete="off" readonly value="${val.brand_name}">
                            <input type="hidden" name="brand_id[${indx}]" class="form-control brand_id" autocomplete="off" value="${val.brand_id}">
                        </td>                            
                        <td>
                            <input type="text" name="model[${indx}]" class="form-control model" autocomplete="off" readonly value="${val.model}">
                        </td>
                        <td>
                            <input type="text" name="serial_code[${indx}]" class="form-control serial_code" autocomplete="off" readonly value="${val.serial_code}">
                        </td>
                        <td class="">
                            <input type="text" name="unit[${indx}]" class="form-control unit" autocomplete="off" readonly value="${val.unit}">
                        </td>
                    </tr>
                `;

            $('#challan tbody').append(row);
            var lastRow = $('#challan tbody tr:last');
            var elemPrimary = lastRow.find('.js-primary')[0];
            new Switchery(elemPrimary, {
                color: '#4099ff',
                jackColor: '#fff',
                size: 'small'
            });
            indx++
        }

        /* Adds and removes quantity row on click */
        $("#challan")
            .on('click', '.add-challan-row', () => {
                appendCalculationRow();
            })
            .on('click', '.remove-challan-row', function() {
                $(this).closest('tr').remove();
            });









        $(document).on('keyup', '.material_name', function() {
            var event_this = $(this).closest('tr');
            let myObject = {
                sl_no: null
            }
            jquaryUiAjax(this, "{{ route('searchMaterialForWcrr') }}", uiList, myObject);

            function uiList(item) {
                event_this.find('.material_name').val(item.value);
                event_this.find('.material_id').val(item.material_id);
                event_this.find('.brand_name').val(item.brand_name);
                event_this.find('.brand_id').val(item.brand_id);
                event_this.find('.unit').val(item.unit);
                event_this.find('.serial_code').val(item.serial_code);
                event_this.find('.model').val(item.model);
                event_this.find('.item_code').val(item.item_code);
                event_this.find('.material_type').val(item.item_type);
                event_this.find('.receiving_date').val(item.receiving_date);
                event_this.find('.warranty_period').val(item.warranty_period);
                event_this.find('.remaining_days').val(item.remaining_days);
                event_this.find('.challan_no').val(item.challan_no);
                event_this.find('.receiveable_id').val(item.receiveable_id);
                return false;
            }
        })

        $('#wcr_no').on('keyup', function() {
            var event_this = $(this).closest('tr');
            let myObject = {
                sl_no: null
            }
            jquaryUiAjax(this, "{{ route('searchWcrForWcrr') }}", uiList, myObject);

            function uiList(item) {
                console.log(item);
                $('#wcr_no').val(item.label);
                $('#wcr_id').val(item.wcr_id);
                $('#send_date').val(item.sending_date);
                $('#wcr_id').trigger('change');
                return false;
            }
        })
        $(document).ready(function() {
            switchInitialization();
            $('#branch_id').select2({
                placeholder: 'Select an option'
            });
        })
        $(document).on('change', '#wcr_id', function() {
            let wcr_id = $('#wcr_id').val();

            let url = "{{ route('searchMaterialForWcrr') }}";

            $.ajax({
                url: url,
                type: 'get',
                dataType: "json",
                data: {
                    wcr_id,
                },
                success: function(data) {
                    $.each(data, function(key, value) {
                        addRow(value)
                    });
                }
            });

        });



        // $(function() {
        //     fillSelect2Options("{{ route('searchBranch') }}", '#branch_id');
        //     @if ($form_method == 'PUT')
        //         $(document).on('DOMNodeInserted', '#branch_id', function() {
        //             console.log('DOM changed');
        //             let selectedValue = "{{ $branch_id }}"
        //             $('#branch_id').val(selectedValue);
        //         });
        //         $('#branch_id').trigger('change');
        //     @endif
        // });
    </script>
@endsection
