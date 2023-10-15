@extends('layouts.backend-layout')
@section('title', 'Purchase Order')

@php
    $is_old = old('supplier_name') ? true : false;
    $form_heading = !empty($purchaseOrder->id) ? 'Update' : 'Add';
    $form_url = !empty($purchaseOrder->id) ? route('purchase-orders.update', $purchaseOrder->id) : route('purchase-orders.store');
    $form_method = !empty($purchaseOrder->id) ? 'PUT' : 'POST';
@endphp

@section('breadcrumb-title')
    {{ $form_heading }} PO (Purchase Order)
@endsection

@section('style')
    <style>
        .input-group-addon {
            min-width: 120px;
        }

        .input-group-info .input-group-addon {
            /*background-color: #04748a!important;*/
        }

        .btn-custom {
            padding: 6px 4px;
            line-height: 3px;
            font-size: 11px;
            border-radius: 50%;
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
                transform: rotate(-360deg);
            }
        }

        /* Custom CSS for animation */
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('purchase-orders.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
    <div class="alert alert-danger icons-alert mt-2 mb-2 p-2 d-none" id="errorlist">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="icofont icofont-close-line-circled"></i>
        </button>
    </div>

@endsection

@section('content-grid', null)

@section('content')
    {!! Form::open([
        'url' => $form_url,
        'method' => $form_method,
        'encType' => 'multipart/form-data',
        'class' => 'custom-form',
    ]) !!}
    <div class="row">
        @if (!empty($purchaseOrder->id))
            <div class="form-group col-4">
                <label for="po_no">PO No <span class="text-danger">*</span></label>
                <input class="form-control" id="po_no" name="po_no" aria-describedby="po_no"
                    value="{{ old('po_no') ?? ($purchaseOrder->po_no ?? '') }}" readonly>
            </div>
        @endif
        <div class="form-group col-4">
            <label for="po_type">PRS Type <span class="text-danger">*</span></label>
            <select class="form-control" name="po_type" id="po_type" required>
                <option value="" disabled selected>Select PRS Type</option>
                <option value="Purchase Order" @selected('Purchase Order' == @$purchaseOrder->po_type)>Purchase Order</option>
                <option value="Work Order" @selected('Work Order' == @$purchaseOrder->po_type)>Work Order</option>
            </select>
        </div>

        <div class="form-group col-4">
            <label for="date">Purchase Date:</label>
            <input class="form-control purchase_date" name="date" aria-describedby="date"
                value="{{ old('date') ?? (@$purchaseOrder->date ?? '') }}" readonly placeholder="Select a Date">
        </div>

        <div class="form-group col-4 delivery_location">
            <label for="delivery_location">Delivery Location:</label>
            <input type="text" class="form-control" id="delivery_location" aria-describedby="delivery_location"
                name="delivery_location"
                value="{{ old('delivery_location') ?? (@$purchaseOrder->delivery_location ?? '') }}">
        </div>

        <div class="form-group col-4 supplier_name">
            <label for="supplier_name">Supplier Name: <span class="text-danger">*</span></label>
            <input type="text" class="form-control supplier_name" aria-describedby="supplier_name" id="supplier_name"
                autocomplete="off" name="supplier_name"
                value="{{ old('supplier_name') ?? (@$purchaseOrder->supplier->name ?? '') }}" placeholder="Search..."
                required>
            <input type="hidden" class="supplier_id" name="supplier_id" id="supplier_id"
                value="{{ old('supplier_id') ?? @$purchaseOrder?->supplier_id }}">
        </div>

        <div class="form-group col-4 indent_no">
            <label for="indent_no">Indent No: <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="indent_no" aria-describedby="indent_no" name="indent_no"
                autocomplete="off" value="{{ old('indent_no') ?? (@$purchaseOrder->indent->indent_no ?? '') }}"
                placeholder="Search...">
            <input type="hidden" name="indent_id" id="indent_id"
                value="{{ old('indent_id') ?? @$purchaseOrder?->indent_id }}">
        </div>
        <div class="form-gorup col-4 cs_no">
            <label for="cs_no">CS No: <span class="text-danger">*</span></label>

            <select class="form-control select2" name="cs_id" id="cs_id" required>
                <option value="" disabled selected>Select CS No</option>

                @if (!empty($purchaseOrder->id))
                    @foreach ($indent_wise_cs as $cs)
                        <option value="{{ $cs->cs_no }}" @selected($cs->cs_no == @$purchaseOrder->cs_no)>
                            {{ $cs->cs_no }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <input type="hidden" name="cs_no" id="cs_no" value="{{ old('cs_no') ?? @$purchaseOrder?->cs_no }}">

        <div class="form-group col-4 remarks">
            <label for="remarks">Remarks</label>
            <input type="text" class="form-control" id="remarks" aria-describedby="remarks" name="remarks"
                value="{{ old('remarks') ?? (@$purchaseOrder->remarks ?? '') }}">
        </div>
    </div>
    {{-- create a loading design --}}
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

    <table class="table table-bordered" id="material_requisition">
        <thead>
            <tr>
                <th>Material Name</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Description</th>
                <th>Unit</th>
                <th> Quantity </th>
                <th>Warranty Period</th>
                <th>Price </th>
                <th style="width: 80px !important">Vat</th>
                <th style="width: 80px !important">Tax</th>
                <th> Sub Total Amount </th>
                <th> Required Date </th>
                <th><i class="btn btn-primary btn-sm fa fa-plus add-requisition-row"></i></th>
            </tr>
        </thead>
        <tbody>
            @php
                // $purchase_requisition = old('purchase_requisition_id', !empty($purchaseOrder) ? $purchaseOrder->purchaseOrderLines->pluck('scmPurchaseRequisition.prs_no') : []);
                // $purchase_requisition_id = old('purchase_requisition_id', !empty($purchaseOrder) ? $purchaseOrder->purchaseOrderLines->pluck('scm_purchase_requisition_id') : []);

                $quotation_no = old('quotation_no', !empty($purchaseOrder) ? $purchaseOrder->purchaseOrderLines->pluck('quotation_no') : []);

                $material_name = old('material_name', !empty($purchaseOrder) ? $purchaseOrder->purchaseOrderLines->pluck('material.name') : []);
                $material_id = old('material_id', !empty($purchaseOrder) ? $purchaseOrder->purchaseOrderLines->pluck('material.id') : []);

                $single_model = old('model', !empty($purchaseOrder) ? $purchaseOrder->purchaseOrderLines->pluck('model') : []);

                $brand = old('brand', !empty($purchaseOrder) ? $purchaseOrder->purchaseOrderLines->pluck('brand') : []);
                $brand_id = old('brand_id', !empty($purchaseOrder) ? $purchaseOrder->purchaseOrderLines->pluck('brand_id') : []);

                $description = old('description', !empty($purchaseOrder) ? $purchaseOrder->purchaseOrderLines->pluck('description') : []);

                $unit = old('unit', !empty($purchaseOrder) ? $purchaseOrder->purchaseOrderLines->pluck('material.unit') : []);

                $quantity = old('quantity', !empty($purchaseOrder) ? $purchaseOrder->purchaseOrderLines->pluck('quantity') : []);

                $warranty_period = old('warranty_period', !empty($purchaseOrder) ? $purchaseOrder->purchaseOrderLines->pluck('warranty_period') : []);

                $unit_price = old('unit_price', !empty($purchaseOrder) ? $purchaseOrder->purchaseOrderLines->pluck('unit_price') : []);
                $vat = old('vat', !empty($purchaseOrder) ? $purchaseOrder->purchaseOrderLines->pluck('vat') : []);

                $tax = old('tax', !empty($purchaseOrder) ? $purchaseOrder->purchaseOrderLines->pluck('tax') : []);

                $total_amount = old('total_amount', !empty($purchaseOrder) ? $purchaseOrder->purchaseOrderLines->pluck('total_amount') : []);

                $required_date = old('required_date', !empty($purchaseOrder) ? $purchaseOrder->purchaseOrderLines->pluck('required_date') : []);
            @endphp
            @if (!empty($purchaseOrder))
                @foreach ($purchaseOrder->purchaseOrderLines as $key => $purchaseOrderLine)
                    <tr>
                        <td>
                            <select class="form-control text-center material_name select2" name="material_id[]">
                                <option value="" readonly selected>Select Material</option>
                                @foreach ($cs_materials as $cs_material)
                                    <option value="{{ $cs_material->material_id }}"
                                        {{ $cs_material->material_id == $material_id[$key] ? 'selected' : '' }}>
                                        {{ $cs_material->material->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        {{-- @dd($cs_brands, $brand_id) --}}
                        <td>
                            <select class="form-control text-center brand_name select2" name="brand_id[]">
                                <option value="" readonly selected>Select Brand</option>
                                @foreach ($cs_brands as $cs_brand)
                                    <option value="{{ $cs_brand->brand_id }}"
                                        {{ $cs_brand->brand_id == $brand_id[$key] ? 'selected' : '' }}>
                                        {{ $cs_brand->brand->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="form-control text-center model select2" name="model[]">
                                <option value="" readonly selected>Select Model</option>
                                @foreach ($cs_models as $cs_model)
                                    <option value="{{ $cs_model->model }}"
                                        {{ $cs_model->model == $single_model[$key] ? 'selected' : '' }}>
                                        {{ $cs_model->model }}</option>
                                @endforeach
                            </select>
                        </td>

                    $quotation_no = old('quotation_no', !empty($purchaseOrder) ? $purchaseOrder->purchaseOrderLines->pluck('quotation_no') : []);

                    $material_name = old('material_name', !empty($purchaseOrder) ? $purchaseOrder->purchaseOrderLines->pluck('material.name') : []);
                    $material_id = old('material_id', !empty($purchaseOrder) ? $purchaseOrder->purchaseOrderLines->pluck('material.id') : []);

                    $single_model = old('model', !empty($purchaseOrder) ? $purchaseOrder->purchaseOrderLines->pluck('model') : []);

                    $brand = old('brand', !empty($purchaseOrder) ? $purchaseOrder->purchaseOrderLines->pluck('brand') : []);
                    $brand_id = old('brand_id', !empty($purchaseOrder) ? $purchaseOrder->purchaseOrderLines->pluck('brand_id') : []);

                    $description = old('description', !empty($purchaseOrder) ? $purchaseOrder->purchaseOrderLines->pluck('description') : []);

                    $unit = old('unit', !empty($purchaseOrder) ? $purchaseOrder->purchaseOrderLines->pluck('material.unit') : []);

                    $quantity = old('quantity', !empty($purchaseOrder) ? $purchaseOrder->purchaseOrderLines->pluck('quantity') : []);

                    $warranty_period = old('warranty_period', !empty($purchaseOrder) ? $purchaseOrder->purchaseOrderLines->pluck('warranty_period') : []);

                    $unit_price = old('unit_price', !empty($purchaseOrder) ? $purchaseOrder->purchaseOrderLines->pluck('unit_price') : []);
                    $vat = old('vat', !empty($purchaseOrder) ? $purchaseOrder->purchaseOrderLines->pluck('vat') : []);

                    $tax = old('tax', !empty($purchaseOrder) ? $purchaseOrder->purchaseOrderLines->pluck('tax') : []);

                    $total_amount = old('total_amount', !empty($purchaseOrder) ? $purchaseOrder->purchaseOrderLines->pluck('total_amount') : []);

                    $required_date = old('required_date', !empty($purchaseOrder) ? $purchaseOrder->purchaseOrderLines->pluck('required_date') : []);
                @endphp
                @if (!empty($purchaseOrder))
                    @foreach ($purchaseOrder->purchaseOrderLines as $key => $purchaseOrderLine)
                        <tr>
                            <td>
                                <select class="form-control text-center material_name select2" name="material_id[]">
                                    <option value="" readonly selected>Select Material</option>
                                    @foreach ($cs_materials as $cs_material)
                                        <option value="{{ $cs_material->material_id }}"
                                            {{ $cs_material->material_id == $material_id[$key] ? 'selected' : '' }}>
                                            {{ $cs_material->material->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            {{-- @dd($cs_brands, $brand_id) --}}
                            <td>
                                <select class="form-control text-center brand_name select2" name="brand_id[]">
                                    <option value="" readonly selected>Select Brand</option>
                                    @foreach ($cs_brands as $cs_brand)
                                        <option value="{{ $cs_brand->brand_id }}"
                                            {{ $cs_brand->brand_id == $brand_id[$key] ? 'selected' : '' }}>
                                            {{ $cs_brand->brand->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select class="form-control text-center model select2" name="model[]">
                                    <option value="" readonly selected>Select Model</option>
                                    @foreach ($cs_models as $cs_model)
                                        <option value="{{ $cs_model->model }}"
                                            {{ $cs_model->model == $single_model[$key] ? 'selected' : '' }}>
                                            {{ $cs_model->model }}</option>
                                    @endforeach
                                </select>
                            </td>

                            <td>
                                <input type="text" name="description[]" class="form-control text-center description"
                                    autocomplete="off" value="{{ $description[$key] }}">
                            </td>

                            <td>
                                <input type="text" name="unit[]" class="form-control text-center unit"
                                    autocomplete="off" readonly value="{{ $unit[$key] }}">
                            </td>

                            <td>
                                <input type="number" name="quantity[]" class="form-control text-center quantity"
                                    autocomplete="off" value="{{ $quantity[$key] }}">
                            </td>

                            <td>
                                <input type="text" name="warranty_period[]"
                                    class="form-control text-center warranty_period" autocomplete="off"
                                    value="{{ $warranty_period[$key] }}">
                            </td>

                            <td>
                                <input type="number" name="unit_price[]" class="form-control text-center unit_price"
                                    autocomplete="off" readonly value="{{ $unit_price[$key] }}">
                            </td>

                            <td>
                                <select class="form-control text-center" name="vat[]">
                                    @foreach ($vatOrTax as $value)
                                        <option value="{{ $vat[$key] }}" @selected($value == $vat[$key])>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>

                            <td>
                                <select class="form-control text-center" name="tax[]">
                                    @foreach ($vatOrTax as $value)
                                        <option value="{{ $tax[$key] }}" @selected($value == $tax[$key])>
                                            {{ $value }}</option>
                                    @endforeach
                                </select>
                            </td>

                            <td>
                                <input name="total_amount[]" class="form-control text-center total_amount"
                                    autocomplete="off" readonly value="{{ $total_amount[$key] }}">
                            </td>
                            <td>
                                <input class="form-control text-center date" name="required_date[]"
                                    aria-describedby="date" value="{{ $required_date[$key] }}" readonly>
                            </td>
                            <td>
                                <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="11" class="text-right">Total Amount</td>
                    <td colspan="3">
                        <input type="text" name="final_total_amount"
                            class="form-control text-center final_total_amount" autocomplete="off"
                            value="{{ old('final_total_amount', !empty($purchaseOrder) ? $purchaseOrder->purchaseOrderLines->sum('total_amount') : 0) }}"
                            readonly>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="form-group col-4">
        <label for="terms_and_conditions" class="terms_label">Terms and Conditions
            <i class="btn-primary btn-custom fa fa-plus add-terms-row"></i>
        </label>
        @if (isset($purchaseOrder) && $purchaseOrder?->poTermsAndConditions->count() > 0)
            @foreach ($purchaseOrder->poTermsAndConditions as $key => $value)
                <div class="input-group">
                    <input type="text" name="terms_and_conditions[]" class="form-control terms_and_conditions"
                        autocomplete="off" value="{{ $value->particular }}">
                    <i class="btn btn-danger btn-sm fa fa-minus remove-terms-row"></i>
                </div>
            @endforeach
        @else
            <div class="input-group">
                <input type="text" name="terms_and_conditions[]" class="form-control terms_and_conditions"
                    autocomplete="off">
            </div>
        @endif
    </div>

    <div class="row">
        <div class="offset-md-4 col-md-4 mt-2">
            <div class="input-group input-group-sm ">
                <button class="btn btn-success btn-round btn-block py-2" type="submit">Submit</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section('script')
    <script>
        let material_items = [];
        let materials = [];
        let brands = [];
        var req_options = null;

        @if (!empty($purchaseOrder->id))
            var indentWiseRequisitions = @json($indentWiseRequisitions);
            var options = '<option value="">Select PRS No</option>';

            indentWiseRequisitions.forEach(function(value, element) {
                // let output = JSON.parse(key);
                const keys = Object.keys(value);
                console.log("keys", keys[0])

                console.log("value", value[keys])
                options +=
                    `<option value="${keys[0]}">${value[keys]}</option>`;
            });
            req_options = options;
        @endif

        $('.select2').select2();
        $('.purchase_date').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true,
            showOtherMonths: true
        }).datepicker("setDate", new Date());

        //submit form with ajax and validation response
        // document.querySelector('.custom-form').addEventListener('submit', function(e) {
        //     e.preventDefault(); // prevent default form submit
        //     var form_data = new FormData(this); // get form data
        //     fetch(this.action, {
        //             method: this.method,
        //             body: form_data
        //         })
        //         .then(function(response) {
        //             if (!response.ok) {
        //                 // throw new Error('Network response was not ok');
        //                 console.log("not okay", response.responseJSON);

        //             }
        //             return response.json();
        //         })
        //         .then(function(response) {
        //             // handle success response
        //             if (response.status == 'success') {
        //                 window.location.href =
        //                     "{{ route('purchase-orders.index') }}?message=Purchase Order Created Successfully";
        //             } else {
        //                 $('#errorlist').empty();
        //                 $('#errorlist').removeClass('d-none');

        //                 $.each(response, function(key, value) {
        //                     $('#errorlist').append('<p>' + value + '</p>');
        //                 });
        //             }
        //         })
        //         .catch(function(error) {
        //             console.log("not okay", error);
        //         });
        // });

        $(document).on('click', '.add-terms-row', function() {
            var terms_and_conditions = $(this).closest('.terms_label').find('.terms_and_conditions').val();
            if (terms_and_conditions == '') {
                alert('Please enter terms and conditions');
                return false;
            }
            $(this).closest('.terms_label').find('.terms_and_conditions').val('');

            $(this).closest('.terms_label').after(
                '<div class="input-group mt-2">' +
                '<input type="text" name="terms_and_conditions[]" class="form-control terms_and_conditions" autocomplete="off" value="">' +
                '<i class="btn btn-danger btn-sm fa fa-minus remove-terms-row"></i>' +
                '</div>'
            );
        });

        $(document).on('click', '.remove-terms-row', function() {
            $(this).closest('div').remove();
        });

        $(document).on('keyup', '.unit_price, .quantity', function() {
            var unit_price = $(this).closest('tr').find('.unit_price').val();
            var quantity = $(this).closest('tr').find('.quantity').val();
            var total_amount = unit_price * quantity;
            $(this).closest('tr').find('.total_amount').val(total_amount);
            calculateTotalAmount()

        });

        //function for calculate total amount from all sub total amount            
        function calculateTotalAmount() {
            var final_total_amount = 0;
            $('.total_amount').each(function() {
                final_total_amount += parseFloat($(this).val()) || 0;
            });
            $('.final_total_amount').val(final_total_amount.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));
        }

        $(document).on('keyup', "#supplier_name", function() {
            $('.supplier_id').val('');
            $('.cs_id').val('');
            $('.cs_no').val('');
            $('.material_name').text('');
            $('.unit').val('');
            $('.price').val('');
            $('.unit_price').val('');

            $(this).autocomplete({
                minlenght: 1,
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('searchSupplier') }}",
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
                    $('#supplier_name').val(ui.item.label);
                    $('#supplier_id').val(ui.item.value);

                    return false;
                }
            });
        });

        $(document).on('keyup', '#indent_no', function() {
            if ($('#supplier_name').val() == '') {
                alert('Please select supplier name first!');
                $('#indent_no').val('');
                return false;
            }
            $(this).autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ url('search-indent-no') }}",
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
                    $('#indent_no').val(ui.item.label);
                    $('#indent_id').val(ui.item.value);
                    console.log(ui.item.requisition_nos);
                    $('#cs_id').html('');
                    $('#client_links').html('');
                    var options = '<option value="">Select CS No</option>';
                    ui.item.cs_no.forEach(function(element) {
                        options +=
                            `<option value="${element.id}">${element.cs_no}</option>`;
                    });
                    $('#cs_id').html(options);
                    return false;
                }
            });
        });

        $(document).on('mouseenter', '.date', function() {
            $(this).datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                todayHighlight: true,
            });
        });

        //get cs no on keyup get 5 value evey time
        $(document).on('change', '#cs_id', function() {
            $('.loading').show();
            let cs_id = $(this).val();
            $('#cs_no').val($(this).find('option:selected').text());
            let cs_materials = '<option>Select Materials</option>';
            $.ajax({
                url: "{{ route('search-material-by-cs-requisition') }}",
                type: 'get',
                dataType: "json",
                data: {
                    cs_id: cs_id,
                },
                success: function(data) {
                    $('.loading').hide();
                    $.each(data, function(key, value) {
                        cs_materials +=
                            `<option value="${value.material.id}">${value.material.name}</option>`;
                        material_items.push(value.material)
                    });
                    $('.material_name').html(cs_materials);
                    appendCalculationRow();
                }
            });
        });

        /* Append row */
        @if (empty($purchaseOrder) && empty(old('material_name')))
            // appendCalculationRow();
        @endif
        function appendCalculationRow() {
            let cs_id = $('#cs_id').val();
            let supplier_id = $('#supplier_id').val();
            const materialUrl = '{{ url('/scm/get-material-by-cs') }}/' + cs_id + '/' + supplier_id;
            $.getJSON(materialUrl, function(materials) {
                $.each(materials, function(key, data) {
                    let model = data.model != null ? data.model : '';
                    let row = `<tr>
                            <td>
                                <input type="text" name="material_name[]" class="form-control material_name" value="${data.cs_material.material.name}" autocomplete="off">
                                <input type="hidden" name="material_id[]" class="form-control material_id" value="${data.cs_material.material.id}" autocomplete="off">
                            </td>

                            <td>
                                <input type="text" name="brand_name[]" class="form-control brand_name" value="${data.brand.name}" autocomplete="off">
                                <input type="hidden" name="brand_id[]" class="form-control brand_id" value="${data.brand.id}" autocomplete="off">
                            </td>

                            <td>
                                <input type="text" name="model[]" class="form-control model" value="${model}" autocomplete="off">
                            </td>

                            <td>
                                <input type="text" name="description[]" class="form-control description" autocomplete="off">
                            </td>

                            <td>
                                <input type="text" name="unit[]" class="form-control unit" autocomplete="off" readonly>
                            </td>

                            <td>
                                <input type="number" name="quantity[]" class="form-control quantity" autocomplete="off">
                            </td>

                            <td>
                                <input type="text" name="warranty_period[]" class="form-control warranty_period" autocomplete="off">
                            </td>

                            <td>
                                <input type="number" name="unit_price[]" class="form-control unit_price" value=${data.price} autocomplete="off" readonly>
                            </td>

                            <td>
                                <select class="form-control" name="vat[]">
                                    @foreach ($vatOrTax as $key => $value)
                                        <option value="{{ $value }}" @selected($key == @$purchaseOrder->vat)>
                                            {{ $value }}</option>
                                    @endforeach
                                </select>
                            </td>

                            <td>
                                <select class="form-control" name="tax[]">
                                    @foreach ($vatOrTax as $key => $value)
                                        <option value="{{ $value }}" @selected($key == @$purchaseOrder->tax)>
                                            {{ $value }}</option>
                                    @endforeach
                                </select>
                            </td>

                            <td>
                                <input name="total_amount[]" class="form-control total_amount" autocomplete="off" readonly>
                            </td>
                            <td>
                                <input class="form-control date" name="required_date[]" aria-describedby="date" value="{{ old('required_date') ?? (@$purchaseOrder->required_date ?? '') }}" readonly>
                            </td>
                            <td>
                                <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i>
                            </td>
                        </tr>
                    `;

                    $('#material_requisition tbody').append(row);
                })
            });



            // getMaterial(this)
            $('.select2').select2();
            $('.date').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                todayHighlight: true,
            }).datepicker("setDate", new Date());
        }



        $(document).on('change', '.purchase_requisition_id', function() {
            getMaterial(this)
        })

        /* Adds and removes quantity row on click */
        $("#material_requisition")
            .on('click', '.add-requisition-row', () => {
                appendCalculationRow();
                $('.purchase_requisition_id').last().html(req_options);
                $('.select2').select2();
            })
            .on('click', '.remove-calculation-row', function() {
                if ($('#material_requisition tbody tr').length == 1) {
                    return false;
                }
                $(this).closest('tr').remove();
            });

        //Search Material
        function getMaterial(e) {
            let cs_id = $(e).closest('tr').find('.cs_id').val();
            let purchase_requisition_id = $(e).closest('tr').find('.purchase_requisition_id').val();

            if (purchase_requisition_id != '' && cs_id != '') {
                const url = '{{ url('/scm/search-material-by-cs-requisition') }}/' + cs_id + '/' +
                    purchase_requisition_id;
                let dropdown;

                dropdown = $(e).closest('tr').find('.material_name');
                // $('.material_name').each(function() {
                // });
                dropdown.empty();
                dropdown.append('<option selected disabled>Select Material</option>');
                dropdown.prop('selectedIndex', 0);

                $.getJSON(url, function(items) {
                    materials = items;
                    $.each(items, function(key, material) {
                        dropdown.append($('<option></option>')
                            .attr('value', material.material.id)
                            .text(material.material.name))
                    })
                });
            }
        }


        $(document).on('change', '.material_name', function() {
            let material_id = $(this).val();
            let cs_id = $('#cs_id').val();
            let supplier_id = $('#supplier_id').val();
            var selectedIndex = this;

            if (supplier_id == '') {
                alert('Please select a supplier first');
                return false;
            }

            const url = '{{ url('/scm/search-material-brand-by-cs-requisition') }}/' + cs_id + '/' +
                supplier_id +
                '/' + material_id;

            let dropdown;

            dropdown = $(this).closest('tr').find('.brand_name');
            dropdown.empty();
            dropdown.append('<option selected disabled>Select Brand</option>');
            dropdown.prop('selectedIndex', 0);

            $.getJSON(url, function(items) {
                // console.log(items);
                materials = items;
                $.each(items, function(key, material) {
                    // console.log(material.brand);
                    dropdown.append($('<option></option>')
                        .attr('value', material.brand.id)
                        .text(material.brand.name))
                })

                // console.log(items);
                //check if item is empty or not
                if (items === null) {
                    alert('No price found for this material');
                    return false;
                }
                // $(selectedIndex).closest('tr').find('.unit').val(item.cs_material.material.unit);
                // $(selectedIndex).closest('tr').find('.unit_price').val(item.price);
            });
        })

        $(document).on('change', '.brand_name', function() {
            let brand_id = $(this).val();
            let find_materials = materials.find(material => material.cs_material.brand.id == brand_id);
            let model_html = '<option selected disabled>Select Model</option>';
            if (find_materials.length > 1) {
                find_materials.forEach(function(value, element) {
                    model_html +=
                        `<option value="${value.cs_material.model}">${value.cs_material.model}</option>`;
                });
            } else {
                model_html +=
                    `<option value="${find_materials.cs_material.model}">${find_materials.cs_material.model}</option>`;
            }
            $(this).closest('tr').find('.model').html(model_html);
        })

        $(document).on('change', '.model', function() {
            let model = $(this).val();
            let brand_id = $(this).closest('tr').find('.brand_name').val();
            let material_id = $(this).closest('tr').find('.material_name').val();
            let find_materials = materials.find(material => material.cs_material.brand.id == brand_id && material
                .cs_material.model == model && material.cs_material.material.id == material_id);
            $(this).closest('tr').find('.unit').val(find_materials.cs_material.material.unit);
            $(this).closest('tr').find('.unit_price').val(find_materials.price);
            calculateTotalAmount()
        })
    </script>
@endsection
