0.@extends('layouts.backend-layout')
@section('title', 'Warranty Claim')
@php
    $is_old = old('type') ? true : false;
    $form_heading = !empty($warranty_claim) ? 'Update' : 'Add';
    $form_url = !empty($warranty_claim) ? route('warranty-claims.update', $warranty_claim->id) : route('warranty-claims.store');
    $form_method = !empty($warranty_claim) ? 'PUT' : 'POST';
    
    $date = old('date', !empty($warranty_claim) ? $warranty_claim->date : null);
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
    {{ $form_heading }} Warranty Claim Receive
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
       <link rel="stylesheet" type="text/css" href="{{ asset('css/switchery.min.css') }}">
       <link rel="stylesheet" type="text/css" href="{{ asset('/css/style.css') }}">
@endsection
@section('breadcrumb-button')
    <a href="{{ route('warranty-claims.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
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
        <div class="form-group col-3 wcr_no">
            <label for="wcr_no">Wcr No:</label>
            <input type="text" class="form-control" id="wcr_no" aria-describedby="wcr_no" name="wcr_no"
                value="{{ old('wcr_no') ?? (@$wcr_no ?? '') }}">
             <input type="hidden" class="form-control" id="wcr_id" aria-describedby="wcr_id" name="wcr_id"
                value="{{ old('wcr_id') ?? (@$wcr_id ?? '') }}">
                <input type="checkbox" class="js-primary" checked />
        </div>
        <div class="form-group col-3 send_date">
            <label for="send_date">Send Date:</label>
            <input type="text" class="form-control" id="send_date" aria-describedby="send_date" name="send_date"
                readonly value="{{ old('send_date') ?? (@$send_date ?? '') }}">
        </div>
        <div class="form-group col-3 branch_name">
            <label for="select2">Branch</label>
            <select class="form-control select2" id="branch_id" name="branch_id">
                <option value="" selected>Select Branch</option>
                @if ($form_method == 'PUT')
                    {{-- <option value="{{ $branch_id }}" selected>
                        {{ $branch_name }}
                    </option> --}}
                @endif
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
            @foreach ($material_id  as $key => $wcr_Line)
                <tr>
                    <td>
                        <select name="received_type[]" class="form-control received_type" autocomplete="off">
                            <option value="" disabled>Select Out From</option>
                            @if(in_array($type, ['MRR', 'WCR'])) 
                            <option value="mrr" @selected($type == 'MRR')>{{ strToUpper('mrr') }}</option>
                            <option value="wcr" @selected($type == 'WCR')>{{ strToUpper('wcr') }}</option>
                            @else
                            <option value="err" @selected($type == 'ERR')>{{ strToUpper('err') }}</option>
                            @endif 
                        </select>
                    </td>
                    <td>
                        <input type="text" name="material_name[]" class="form-control material_name" autocomplete="off" value="{{$material_name[$key]}}">
                        <input type="hidden" name="material_id[]" class="form-control material_id" autocomplete="off" value="{{$material_id[$key]}}">
                        <input type="hidden" name="item_code[]" class="form-control item_code" autocomplete="off" value="{{$item_code[$key]}}"> 
                        <input type="hidden" name="material_type[]" class="form-control material_type" autocomplete="off" value="{{$material_type[$key]}}"> 
                        <input type="hidden" name="receiveable_id[]" class="form-control receiveable_id" autocomplete="off" value="{{$receiveable_id[$key]}}"> 
                    </td>
                    <td class="form-group">
                        <input type="text" name="brand_name[]" class="form-control brand_name" autocomplete="off" readonly value="{{$brand_name[$key]}}">
                        <input type="hidden" name="brand_id[]" class="form-control brand_id" autocomplete="off" value="{{$brand_id[$key]}}">
                    </td>                            
                    <td>
                        <input type="text" name="model[]" class="form-control model" autocomplete="off" readonly value="{{$model[$key]}}">
                    </td>
                    <td>
                        <input type="text" name="serial_code[]" class="form-control serial_code" autocomplete="off" readonly value="{{$serial_code[$key]}}">
                    </td>
                    <td class="select2_container">
                        <input type="text" name="unit[]" class="form-control unit" autocomplete="off" readonly value="{{$unit[$key]}}">
                    </td>
                    
                    <td>
                        <input name="receiving_date[]" class="form-control receiving_date" autocomplete="off" readonly value="{{$receiving_date[$key]}}">
                    </td>
                    <td>
                        <input name="warranty_period[]" class="form-control warranty_period" autocomplete="off" readonly value="{{$warranty_period[$key]}}">
                    </td>
                    <td>
                        <input class="form-control remaining_days" name="remaining_days[]" aria-describedby="remaining_days" readonly value="{{$remaining_days[$key]}}">
                    </td>
                    <td>
                        <input name="challan_no[]" class="form-control challan_no" autocomplete="off" readonly value="{{$challan_no[$key]}}">
                    </td>
                    <td>
                        <input class="form-control description" name="description[]" aria-describedby="description" value="{{$description[$key]}}">
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
<script  src="{{ asset('/js/switchery.min.js')}}"></script>
<script  src="{{ asset('/js/swithces.js')}}"></script>
<script  src="{{ asset('/js/script.js') }}"></script>
    <script>
        const CSRF_TOKEN = "{{ csrf_token() }}";
        $('#date').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true,
            showOtherMonths: true
        }).datepicker("setDate", new Date());;
        
      
        
        function addRow(val) {
            let row = `<tr>
                         <td>
                            <input type="checkbox" class="js-primary" checked />
                        </td>
                            <td>
                                <input type="text" name="material_name[]" class="form-control material_name" autocomplete="off" value="${val.material_name}">
                                <input type="hidden" name="material_id[]" class="form-control material_id" autocomplete="off" value="${val.material_id}">
                                <input type="hidden" name="item_code[]" class="form-control item_code" autocomplete="off" value="${val.item_code}"> 
                                <input type="hidden" name="material_type[]" class="form-control material_type" autocomplete="off" value="${val.item_type}"> 
                            </td>
                            <td class="form-group">
                                <input type="text" name="brand_name[]" class="form-control brand_name" autocomplete="off" readonly value="${val.brand_name}">
                                <input type="hidden" name="brand_id[]" class="form-control brand_id" autocomplete="off" value="${val.brand_id}">
                            </td>                            
                            <td>
                                <input type="text" name="model[]" class="form-control model" autocomplete="off" readonly value="${val.model}">
                            </td>
                            <td>
                                <input type="text" name="serial_code[]" class="form-control serial_code" autocomplete="off" readonly value="${val.serial_code}">
                            </td>
                            <td class="">
                                <input type="text" name="unit[]" class="form-control unit" autocomplete="off" readonly value="${val.unit}">
                            </td>
                            <td>
                                <i class="btn btn-danger btn-sm fa fa-minus remove-challan-row"></i>
                            </td>
                        </tr>
                    `;
            $('#challan tbody').append(row);
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

        $('#wcr_no').on('keyup',function(){
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

        // $('#wcr_id').on('change',function(){
        //     var event_this = $(this).closest('tr');
        //     let myObject = {
        //         wcr_id: $('#wcr_id').val();
        //     }
        //     jquaryUiAjax(this, "{{ route('searchMaterialForWcrr') }}", uiList, myObject);

        //     function uiList(item) {
        //         console.log(item);
                
        //         return false;
        //     }
        // })
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
                    console.log(data);
                    $.each(data, function(key, value) {
                        addRow(value)
                    });
                }
            });

        });
      
        $(function() {

            //using form custom function js file
            fillSelect2Options("{{ route('searchBranch') }}", '#branch_id');

        });
        @if($form_method=='PUT')

            $(document).on('DOMNodeInserted', '#branch_id', function() {
                    let selectedValue = "{{$branch_id}}"
                    $('#branch_id').val(selectedValue)
                    });
        @endif
    </script>
@endsection
