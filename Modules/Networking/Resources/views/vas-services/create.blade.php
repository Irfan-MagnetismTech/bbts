@extends('layouts.backend-layout')
@section('title', 'VAS Service')
<style>
    fieldset {
        display: block !important;
        margin-left: 2px !important;
        margin-right: 2px !important;
        padding-left: 0.75em !important;
        padding-bottom: 0% !important;
        padding-right: 0.75em !important;
        border: #eeeeee 2px silid;
        border: 2px black (internal value) !important;
    }

    fieldset {
        background-color: #eeeeee !important;
    }

    legend {
        color: white !important;
        display: block !important;
        width: 90% !important;
        max-width: 100% !important;
        font-size: 0.7rem !important;
        line-height: inherit !important;
        font-weight: 500 !important;
        color: inherit !important;
        white-space: normal !important;
    }
</style>
@php
    $is_old = old('type') ? true : false;
    $form_heading = !empty($vasService) ? 'Update' : 'Add';
    $form_url = !empty($vasService) ? route('vas-services.update', $vasService->id) : route('vas-services.store');
    $form_method = !empty($vasService) ? 'PUT' : 'POST';
    
    $client_name = old('client_name', !empty($vasService) ? $vasService->client_name : null);
    $fr_no = old('fr_no', !empty($vasService) ? $vasService->fr_no : null);
    $reason_of_inactive = old('reason_of_inactive', !empty($vasService) ? $vasService->reason_of_inactive : null);
    $equipment_type = old('equipment_type', !empty($vasService) ? $vasService?->equipment_type : null);
    $client_id = old('client_id', !empty($vasService) ? $vasService->client_id : null);
    $client_name = old('client_name', !empty($vasService) ? $vasService?->client?->client_name : null);
    $client_no = old('client_no', !empty($vasService) ? $vasService?->client_no : null);
    $required_date = old('required_date', !empty($vasService) ? $vasService?->required_date : today()->format('d-m-Y'));
    $date = old('date', !empty($vasService) ? $vasService?->date : today()->format('d-m-Y'));
    $vendor = old('vendor', !empty($vasService) ? $vasService?->vendor->name : null);
    $vendor_id = old('vendor_id', !empty($vasService) ? $vasService?->vendor_id : null);
    $reference_no = old('reference_no', !empty($vasService) ? $vasService?->reference_no : null);
    $remarks = old('remarks', !empty($vasService) ? $vasService?->remarks : null);
@endphp

@section('breadcrumb-title')
    {{ $form_heading }} VAS Service
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
    <a href="{{ route('vas-services.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
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
        <x-input-box colGrid="3" name="reference_no" value="{{ $reference_no }}" label="Reference No" />

        <div class="form-group col-3 vendor">
            <select class="form-control select2" id="vendor" name="vendor_id" placeholder="faf">
                <option value="" disabled selected>Select Vendor</option>
                @if ($form_method == 'PUT')
                    <option value="{{ $vendor_id }}" @selected($vendor_id)>{{ $vendor }}</option>                    
                @endif
            </select>
        </div>
        <input name="client_no" class="client_no" id="client_no" value="{{ $client_no }}" type="hidden" />
    </div>
    <div class="row">
        <x-input-box colGrid="3" name="date" value="{{ $date }}" label="Date" class="date" />
        <x-input-box colGrid="3" name="required_date" value="{{ $required_date }}" label="Required Date"
            class="date" />
        <x-input-box colGrid="3" name="remarks" value="{{ $remarks }}" label="Remarks" />
    </div>

    <div class="row">
        <div class="offset-md-3 col-md-6 mt-1">
            <table class="table table-bordered" id="product_table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Unit</th>
                        <th>Quantity</th>
                        <th>Rate</th>
                        <th>Total</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($vasService))
                        @foreach ($vasService->lines as $key => $item)
                            <tr>
                                <td>
                                    <select class="form-control select2 product_id" name="product_id[]" required>
                                        <option value="" selected disabled>Select Product</option>
                                        @foreach ($products as $key => $value)
                                            <option value="{{ $value->id }}" @selected($value->id == $item->product_id)>
                                                {{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-control unit" name="unit[]"
                                        value="{{ $item->unit }}" required>
                                </td>
                                <td>
                                    <input type="number" class="form-control quantity" name="quantity[]"
                                        value="{{ $item->quantity }}" required>
                                </td>
                                <td>
                                    <input type="number" class="form-control rate" name="rate[]"
                                        value="{{ $item->rate }}" required>
                                </td>
                                <td>
                                    <input type="number" class="form-control total" name="total[]"
                                        value="{{ $item->total }}" required>
                                </td>
                                <td>
                                    <input type="text" class="form-control description" name="description[]"
                                        value="{{ $item->description }}">
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
        //on change quantity and rate get total amount
        $(document).ready(function() {
            calculateTotal("#product_table", ".quantity", ".rate", ".total");
        })

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
            fillSelect2Options("{{ route('searchVendor') }}", '#vendor');

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

        $('#from,#to').on('keyup', function(event) {
            let selector = this;
            let myObject = {}
            jquaryUiAjax(this, "{{ route('get_pop') }}", uiList, myObject);

            function uiList(item) {
                $(selector).val(item.label).attr('value', item.label);
                if (event.target.id == "from") {
                    $('#from_pop_id').val(item.id);
                } else {
                    $('#to_pop_id').val(item.id);
                }
                return false;
            }
        })

        $('#vendor').on('keyup', function() {
            let myObject = {}
            jquaryUiAjax(this, "{{ route('get_vendors') }}", uiList, myObject);

            function uiList(item) {
                $('#vendor').val(item.label);
                $('#vendor_id').val(item.id);
                return false;
            }
        });

        function appendServiceRow() {
            let row_index = $("#product_table tr:last").prop('rowIndex');
            let row = `<tr>
                        <td>
                            <select class="form-control select2 product_id" name="product_id[]" required>
                                <option value="" selected disabled>Select Service</option>
                                @foreach (@$products as $product)
                                    <option value="{{ $product->id }}" data-unit="{{ $product->unit }}">
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="text" class="form-control unit" name="unit[]" readonly>
                        </td>
                        <td>
                            <input type="number" class="form-control quantity" name="quantity[]" required>
                        </td>
                        <td>
                            <input type="number" class="form-control rate" name="rate[]" required>
                        </td>
                        <td>
                            <input type="number" class="form-control total" name="total[]" readonly>
                        </td>
                        <td>
                            <input type="text" class="form-control description" name="description[]" required>
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
            $('#product_table tbody').append(row);
        }
        $("#product_table").on('click', '.add-service-row', () => {
            appendServiceRow();
            initializeSelect2();
        }).on('click', '.remove-requisition-row', function() {
            if ($('#product_table tbody tr').length == 1) {
                return false;
            }
            $(this).closest('tr').remove();
        });

        //on change product id get unit
        $("#product_table").on('change', '.product_id', function() {
            let unit = $(this).find(':selected').data('unit');
            $(this).closest('tr').find('.unit').val(unit);
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
