@extends('layouts.backend-layout')
@section('title', 'Service Requisition')
<style>
    fieldset {
   display: block!important;
   margin-left: 2px!important;
   margin-right: 2px!important;
   padding-left: 0.75em!important;
   padding-bottom: 0%!important;
   padding-right: 0.75em!important;
   border: #eeeeee 2px silid;
   border: 2px black (internal value)!important;
 }
 fieldset {
   background-color: #eeeeee!important;
 }
 
 legend {
   color: white!important;
   display: block!important;
   width: 90%!important;
   max-width: 100%!important;
   font-size: 0.7rem!important;
   line-height: inherit!important;
   font-weight: 500!important;
   color: inherit!important;
   white-space: normal!important;
 }
 
 
 </style>
@php
    $is_old = old('type') ? true : false;
    $form_heading = !empty($err) ? 'Update' : 'Add';
    $form_url = !empty($err) ? route('service-requisitions.update', $err->id) : route('service-requisitions.store');
    $form_method = !empty($err) ? 'PUT' : 'POST';
    
    $type = old('type', !empty($err) ? $err->type : null);
    $from = old('from', !empty($err) ? $err->from : null);
    $to = old('to', !empty($err) ? $err->to : null);
    $from_pop_id = old('from_pop_id', !empty($err) ? $err->from_pop_id : null);
    $to_pop_id = old('to_pop_id', !empty($err) ? $err->to_pop_id : null);
    $capacity_type = old('capacity_type', !empty($err) ? $err->capacity_type : null);
    $capacity = old('capacity', !empty($err) ? $err->capacity : null);
    $client_name = old('client_name', !empty($err) ? $err->client_name : null);
    $fr_no = old('fr_no', !empty($err) ? $err->fr_no : null);
    $reason_of_inactive = old('reason_of_inactive', !empty($err) ? $err->reason_of_inactive : null);
    $equipment_type = old('equipment_type', !empty($err) ? $err?->equipment_type : null);
    $client_id = old('client_id', !empty($err) ? $err->client_id : null);
    $fr_no = old('fr_no', !empty($err) ? $err->fr_no : null);
    $client_name = old('client_name', !empty($err) ? $err?->client?->client_name : null);
    $client_no = old('client_no', !empty($err) ? $err?->client_no : null);
    $required_date = old('required_date', !empty($err) ? $err?->required_date : today()->format('d-m-Y'));
    $date = old('date', !empty($err) ? $err?->date : today()->format('d-m-Y'));
    $vendor = old('vendor', !empty($err) ? $err?->vendor->name : null);
    $vendor_id = old('vendor_id', !empty($err) ? $err?->vendor_id : null);
    $remarks = old('remarks', !empty($err) ? $err?->remarks : null);
@endphp

@section('breadcrumb-title')
    {{ $form_heading }} Service Requisition
@endsection

@section('style')
    <style>
        .input-group-addon {
            min-width: 120px;
        }

        .input-group-info .input-group-addon {
            /*background-color: #04748a!important;*/
        }
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('service-requisitions.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
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
     <div class="row pb-2">
        <div class="col-3">
            <fieldset class="mb-2 pb-2">
                <legend>Requisition Type</legend>
                <div class="form-check-inline pt-0 mt-0">
                    <label class="form-check-label" for="new">
                        <input type="radio" class="form-check-input type" id="new" name="type"
                            value="new" @checked(@$type == 'new' || ($form_method == 'POST' && !old()))>
                        NEW
                    </label>
                </div>
                <div class="form-check-inline mt-0 pt-0">
                    <label class="form-check-label" for="existing">
                        <input type="radio" class="form-check-input type" id="existing" name="type"
                            value="existing" @checked(@$type == 'existing')>
                        EXISTING
                    </label>
                </div>
                <div class="form-check-inline pt-0 mt-0">
                    <label class="form-check-label" for="service">
                        <input type="radio" class="form-check-input type" id="service" name="type"
                            value="service" @checked(@$type == 'service' || ($form_method == 'POST' && !old()))>
                        Service
                    </label>
                </div>
                <div class="form-check-inline mt-0 pt-0">
                    <label class="form-check-label" for="vas_service">
                        <input type="radio" class="form-check-input type" id="vas_service" name="type"
                            value="vas_service" @checked(@$type == 'vas_service')>
                        VAS Service
                    </label>
                </div>
            </fieldset>
        </div>
    </div>
    <div class="row">
        <x-input-box colGrid="3" name="from" value="{{ $from }}" label="From" />
        <input type="hidden" id="from_pop_id" name="from_pop_id" value="{{$from_pop_id}}">
        <x-input-box colGrid="3" name="to" value="{{ $to }}" label="To" />
        <input type="hidden" id="to_pop_id" name="to_pop_id" value="{{$to_pop_id}}">
        <x-input-box colGrid="3" name="capacity_type" value="{{ $capacity_type }}" label="Capacity Type" />
        <x-input-box colGrid="3" name="capacity" value="{{ $capacity }}" label="Capacity" />
    </div>

    <div class="row">
        <x-input-box colGrid="3" name="client_name" value="{{ $client_name }}" label="Client Name" />
        <div class="form-group col-3 fr_no">
            <select class="form-control select2" id="fr_no" name="fr_no">
                <option value="" readonly selected>Select FR No</option>
                @if ($form_method == 'POST')
                    <option value="{{ old('fr_no') }}" selected>{{ old('fr_no') }}</option>
                @elseif($form_method == 'PUT')
                    @forelse ($fr_nos as $key => $value)
                        <option value="{{ $value->fr_no }}" @if ($fr_no == $value->fr_no) selected @endif>
                            {{ $value->fr_no }}
                        </option>
                    @empty
                    @endforelse
                @endif
            </select>
        </div>
        <x-input-box colGrid="3" name="client_no" value="{{ $client_no }}" label="Client No" attr="readonly"/>
    </div>
    <div class="row">
        <x-input-box colGrid="3" name="date" value="{{ $date }}" label="Date" class="date"/>
        <x-input-box colGrid="3" name="required_date" value="{{ $required_date }}" label="Required Date" class="date"/>
        <x-input-box colGrid="3" name="vendor" value="{{ $vendor }}" label="Vendor"/>
        <input type="hidden" name="vendor_id" value="{{ $vendor_id }}" id="vendor_id"/>
        <x-input-box colGrid="3" name="remark" value="{{ $remark }}" label="Remark" />
    </div>
    <div class="row">
        <div class="offset-md-3 col-md-6 mt-1">
            <table class="table table-bordered" id="service_table">
                <thead>
                    <tr>
                        <th>Service Name</th>
                        <th>Quantity</th>
                        <th>Remarks</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($service->id))
                        @foreach ($service->servicelines as $key => $item)
                            <tr>
                                <td>
                                    <select class="form-control select2 service_id" name="service_id[]" required>
                                        <option value="" selected disabled>Select Service</option>
                                        @foreach ($products as $key => $value)
                                            <option value="{{ $value->id }}" @selected($value->id == $item->product_id)>
                                                {{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" class="form-control quantity" name="quantity[]"
                                        value="{{ $item->quantity }}" required>
                                </td>
                                <td>
                                    <input type="text" class="form-control remarks" name="remarks[]"
                                        value="{{ $item->remarks }}">
                                </td>
                                <td>
                                    @if ($loop->first)
                                        <button type="button"
                                            class="btn btn-success btn-sm fa fa-plus add-service-row"></button>
                                    @else
                                        <button type="button"
                                            class="btn btn-danger btn-sm fa fa-minus remove-requisition-row"></button>
                                    @endif
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
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
    <script src="{{ asset('js/search-client.js') }}"></script>
    <script>
        @if ($form_method == 'POST')
            $('.date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                showOtherMonths: true
            }).datepicker("setDate", new Date());;
        @else
            $('.date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                showOtherMonths: true
            });
        @endif

        $(function() {

            $('.select2').select2({
                maximumSelectionLength: 5,
                scrollAfterSelect: true
            });

            //using form custom function js file
            fillSelect2Options("{{ route('searchBranch') }}", '#branch_id');

         
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

        

        @if ($form_method == 'PUT')
            $(document).on('DOMNodeInserted', '#branch_id', function() {
                let selectedValue = "{{ $branch_id }}"
                $('#branch_id').val(selectedValue)
            });
        @endif

        $('#from,#to').on('keyup', function(event) {
            let selector = this;
            let myObject = { 
                        }
                jquaryUiAjax(this, "{{ route('get_pop') }}", uiList, myObject);
                
                function uiList(item) {
                    $(selector).val(item.label).attr('value',item.label);
                    if(event.target.id == "from"){
                        $('#from_pop_id').val(item.id);
                    }else{
                        $('#to_pop_id').val(item.id);
                    }
                    return false;
                }
        })

        $('#vendor').on('keyup', function() {
            let myObject = { 
            }
            jquaryUiAjax(this, "{{ route('get_vendors') }}", uiList, myObject);

            function uiList(item) {
                $('#vendor').val(item.label);
                $('#vendor_id').val(item.id);
                return false;
            }
        });
        function appendServiceRow() {
            let row_index = $("#service_table tr:last").prop('rowIndex');
            console.log(row_index);
            let row = `<tr>
                        <td>
                            <select class="form-control select2 service_id" name="service_id[]" required>
                                <option value="" selected disabled>Select Service</option>
                                @foreach (@$products as $product)
                                    <option value="{{ $product->id }}">
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" class="form-control quantity" name="quantity[]" required>
                        </td>
                        <td>
                            <input type="text" class="form-control remarks" name="remarks[]" required>
                        </td>
                        ${(row_index > 0) ? 
                            `<td>
                                <button type="button" class="btn btn-danger btn-sm fa fa-minus remove-requisition-row"></button>
                            </td>`:
                            `<td>
                                <button type="button" class="btn btn-success btn-sm fa fa-plus add-service-row"></button>
                            </td>`
                        }
                    </tr>`;
            $('#service_table tbody').append(row);
        }
        $("#service_table").on('click', '.add-service-row', () => {
            appendServiceRow();
            initializeSelect2();
        }).on('click', '.remove-requisition-row', function() {
            if ($('#service_table tbody tr').length == 1) {
                return false;
            }
            $(this).closest('tr').remove();
        });
        $(document).ready(function() {
            @if ($form_method == 'POST')
                appendServiceRow();
                initializeSelect2();
            @endif
        });

        function initializeSelect2() {
            $('.select2').select2({
                placeholder: 'Select an option'
            });
        }
       
    </script>

@endsection