@extends('layouts.backend-layout')
@section('title', 'Opening Stock')

@php
    $is_old = old('type') ? true : false;
    $form_heading = !empty($openingStock) ? 'Update' : 'Add';
    $form_url = !empty($openingStock) ? route('errs.update', $openingStock->id) : route('errs.store');
    $form_method = !empty($openingStock) ? 'PUT' : 'POST';
    $branch_id = old('branch_id', !empty($openingStock) ? $openingStock->branch_id : null);
    $date = old('client_id', !empty($openingStock) ? $openingStock->date : null);
@endphp

@section('breadcrumb-title')
    @if (!empty($openingStock))
        Edit
    @else
        Create
    @endif
    Opening Stock
@endsection

@section('style')
    <style>
        .input-group-addon {
            min-width: 120px;
        }

        .input-group-info .input-group-addon {
            background-color: #04748a !important;
        }

        .bootstrap-tagsinput {
            /* ... other properties ... */
            max-width: 200px !important;
            /* Ensure it doesn't exceed its container */
            display: flex !important;
            /* Use flex display */
            flex-wrap: wrap !important;
            /* Allow tags to wrap to the next line */
        }

        .bootstrap-tagsinput .tag {
            margin-bottom: 4px !important;
            /* Adjust spacing below tags */
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
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-tagsinput.css') }}">
@endsection
@section('breadcrumb-button')
    <a href="{{ route('opening-stocks.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
    <div class="">
        <form
            action="{{ !empty($openingStock) ? route('opening-stocks.update', @$openingStock->id) : route('opening-stocks.store') }}"
            method="post" class="custom-form">
            @if (!empty($openingStock))
                @method('PUT')
            @endif
            @csrf

            <div class="row">
                <div class="form-group col-3">
                    <label for="date">Date: <span
                            class="text-danger">*</span></label>
                    <input class="form-control" id="date" name="date" aria-describedby="date" required
                           value="{{ old('date') ?? (@$openingStock->date ?? '') }}" readonly
                           placeholder="Select a Date">
                </div>
                <div class="form-group col-3">
                <label for="branch">Warehouse: <span
                        class="text-danger">*</span></label>
                <select name="branch_id" class="form-control branch select2" required autocomplete="off">
                    <option value="">Select Branch</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}" @selected($branch->id == $branch_id)>
                            {{ $branch->name }}
                        </option>
                    @endforeach
                </select>
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
            <table class="table table-bordered" id="opening_stock">
                <thead>
                <tr>
                    <th> Material Name <span
                            class="text-danger">*</span></th>
                    <th> Unit</th>
                    <th> Brand <span
                            class="text-danger">*</span></th>
                    <th> Model</th>
                    <th>Serial/Drum Code <br /> No</th>
                    <th> Unit Price</th>
                    <th> Quantity</th>
                    <th> Total Amount</th>
                    <th><i class="btn btn-primary btn-sm fa fa-plus add-stock-row"></i></th>
                </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                @php
                        $lines = old('material_id', !empty($openingStock) ? $openingStock->lines->pluck('material_id') : []);
                        $material_name_with_code = old('material_name', !empty($openingStock) ? $openingStock->lines->pluck('material.materialNameWithCode') : []);
                        $material_id = old('material_id', !empty($openingStock) ? $openingStock->lines->pluck('material_id') : []);
                        $unit = old('unit', !empty($openingStock) ? $openingStock->lines->pluck('material.unit') : []);
                        $brand_id = old('brand_id', !empty($openingStock) ? $openingStock->lines->pluck('brand_id') : []);
                        $quantity = old('quantity', !empty($openingStock) ? $openingStock->lines->pluck('quantity') : []);
                        $unit_price = old('unit_price', !empty($openingStock) ? $openingStock->lines->pluck('unit_price') : []);
                        $material_type = old('material_id', !empty($openingStock) ? $openingStock->lines->pluck('material.type') : []);
                        $total_amount = old('total_amount', !empty($openingStock) ? $openingStock->lines->pluck('total_amount') : []);
                        $model = old('model', !empty($openingStock) ? $openingStock->lines->pluck('model') : []);
                        $serial_code = old(
                        'serial_code',
                        !empty($openingStock)
                            ? $openingStock->lines->map(function ($item) {
                                return implode(',', $item->serialCodeLines->pluck('serial_or_drum_key')->toArray());
                            })
                            : '',
                    );
                @endphp
                @foreach ($material_name_with_code as $key => $detail)
                    @php
                        if ($material_type[$key] == 'Drum') {
                            $max_tag = 1;
                        } else {
                            $max_tag = null;
                        }
                    @endphp
                    <tr>
                        <td>
                            <input type="text" name="material_name[]" class="form-control material_name" required
                                   autocomplete="off" value="{{ $material_name_with_code[$key] }}">
                            <input type="hidden" name="material_id[]" class="form-control material_id"
                                   value="{{ $material_id[$key] }}">
                            <input type="hidden" name="material_type[]" class="form-control material_type"
                                   autocomplete="off" value="{{ $material_type[$key] }}">
                        </td>
                        <td>
                            <input type="text" name="unit[]" class="form-control unit" autocomplete="off"
                                   readonly value="{{ $unit[$key] }}" id="unit">
                        </td>
                        <td>
                            <select name="brand_id[]" class="form-control brand_id select2" autocomplete="off" required>
                                <option value="">Select Brand</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}" @selected($brand->id == $brand_id[$key])>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            @if(isset($model[$key]))
                                <input list="models" name="model[]" id="model[]" class="form-control model" value="{{ $model[$key] }}">
                            @else
                                <input list="models" name="model[]" id="model[]" class="form-control model" value="">
                            @endif
                            <datalist id="models">
                                @foreach ($models as $model)
                                    <option value="{{ $model }}">
                                @endforeach
                            </datalist>
                        </td>
                        <td>
                            <div class="tags_add_multiple select2container">
                                <input class="" type="text" name="serial_code[]" value="{{ $serial_code[$key] }}"
                                       data-role="tagsinput" data-max-tags="{{ $max_tag }}">
                            </div>
                        </td>
                        <td>
                            <input type="number" name="unit_price[]" class="form-control unit_price"
                                   step="0.01" autocomplete="off" value="{{ $unit_price[$key] }}">
                        </td>
                        <td>
                            <input type="number" name="quantity[]" class="form-control quantity"
                                   step="0.01" autocomplete="off" value="{{ $quantity[$key] }}">
                        </td>
                        <td>
                            <input name="total_amount[]" class="form-control total_amount" autocomplete="off"
                                   value="{{ $total_amount[$key] }}" readonly>
                        </td>
                        <td>
                            <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i>
                        </td>
                    </tr>
                @endforeach
                </tfoot>
            </table>

            <div class="row">
                <div class="offset-md-4 col-md-4 mt-2">
                    <div class="input-group input-group-sm ">
                        <button class="btn btn-success btn-round btn-block py-2">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/search-client.js') }}"></script>
    <script src="{{ asset('js/bootstrap-tagsinput.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.10.4/typeahead.bundle.min.js"></script>
    <script>
        $(document).on('keyup', '.unit_price, .quantity', function () {
            var unit_price = $(this).closest('tr').find('.unit_price').val();
            var quantity = $(this).closest('tr').find('.quantity').val();
            var total_amount = unit_price * quantity;
            $(this).closest('tr').find('.total_amount').val(total_amount);
        });

        // $('#date').datepicker({
        //     format: "dd-mm-yyyy",
        //     autoclose: true,
        //     todayHighlight: true,
        //     showOtherMonths: true
        // }).datepicker("setDate", new Date());

        if ($('#date').val() != null)
        {
            $('#date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                showOtherMonths: true
            });
        }else {
            $('#date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                showOtherMonths: true
            }).datepicker("setDate", new Date());
        }
        /* Append row */
        @if (empty($openingStock) && empty(old('material_name')))
        appendCalculationRow();
        @endif

        function appendCalculationRow() {
            let row = `<tr>
                            <td>
                                <input type="text" name="material_name[]" class="form-control material_name" required autocomplete="off">
                                <input type="hidden" name="material_id[]" class="form-control material_id">
                                <input type="hidden" name="material_type[]" class="form-control material_type" autocomplete="off">
                            </td>
                            <td>
                                <input type="text" name="unit[]" class="form-control unit" autocomplete="off" readonly>
                            </td>
                             <td>
                             <select name="brand_id[]" class="form-control brand_id select2" required autocomplete="off">
                             <option value="">Select Brand</option>
                             @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                             @endforeach
                             </select>
                             </td>
                            <td>
                             <input list="models" name="model[]" id="model[]" class="form-control model">
                             <datalist id="models">
                            @foreach ($models as $model)
                            <option value="{{ $model }}">
                            @endforeach
                            </datalist>
                            </td>
                            <td>
                                <div class="tags_add_multiple select2container">
                                    <input class="" type="text" name="serial_code[]" value="" data-role="tagsinput" readonly>
                                </div>
                            </td>
                            <td>
                                <input type="number" name="unit_price[]" class="form-control unit_price" autocomplete="off" step="0.01">
                            </td>
                            <td>
                                <input type="number" name="quantity[]" class="form-control quantity" autocomplete="off" step="0.01">
                            </td>
                            <td>
                                <input name="total_amount[]" class="form-control total_amount" autocomplete="off" readonly>
                            </td>
                            <td>
                                <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i>
                            </td>
                        </tr>`;
            $('#opening_stock tbody').append(row);
            $('.select2').select2({});
        }

        $(document).ready(function() {
            $("#opening_stock")
                .on('click', '.add-stock-row', () => {
                    appendCalculationRow();
                    // Initialize "tagsinput" for the newly added row
                    $('input[data-role="tagsinput"]').tagsinput();
                })
                .on('click', '.remove-calculation-row', function () {
                    $(this).closest('tr').remove();
                });
        });

        //Search Material
        $(document).on('keyup focus', '.material_name', function () {
            $(this).autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: "{{ url('search-material') }}",
                        type: 'get',
                        dataType: "json",
                        data: {
                            search: request.term
                        },
                        success: function (data) {
                            response(data);
                        }
                    });
                },
                select: function (event, ui) {
                    $('.loading').show();
                    $(this).closest('tr').find('.material_name').val(ui.item.label);
                    $(this).closest('tr').find('.material_id').val(ui.item.value);
                    $(this).closest('tr').find('.unit').val(ui.item.unit);

                    //Search Brand
                    var this_event = $(this);
                    var material_id = ui.item.value;
                    $.get('{{ route('getMaterialWiseBrands') }}', {
                        material_id: material_id
                    }, function (data) {
                        var html = '<option value="">Select Brand</option>';
                        $.each(data, function (key, item) {
                            html += '<option value="' + item.id + '">' +
                                item.name + '</option>';
                        });
                        this_event.closest('tr').find('.brand_id').html(html);
                        $('.loading').hide();
                    })
                    return false;
                }
            });
        });

        $(document).on('change', '.brand_id', function() {
            $('.loading').show();
            var material_id = $(this).closest('tr').find('.material_id').val();
            var brand_id = $(this).val();
            getModel(material_id, brand_id);
        });

        function getModel(material_id,brand_id) {
                $.get('{{ route('getMaterialWiseModels') }}', {
                    material_id: material_id,
                    brand_id: brand_id,
                }, function(data) {
                    var html = '';
                    $.each(data, function(key, item) {
                        html += '<option value="' + item + '">' + item + '</option>';
                    });
                    $('#models').empty().append(html);
                    $('.loading').hide();
                });
        }
    </script>
@endsection
