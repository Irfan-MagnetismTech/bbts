@extends('layouts.backend-layout')
@section('title', 'Purchase Order')

@php
    $is_old = old('supplier_name') ? true : false;
    $form_heading = !empty($purchaseOrder->id) ? 'Update' : 'Add';
    $form_url = !empty($purchaseOrder->id) ? route('purchase-orders.update', $purchaseOrder->id) : route('purchase-orders.store');
    $form_method = !empty($purchaseOrder->id) ? 'PUT' : 'POST';
@endphp

@section('breadcrumb-title')
    {{ $form_heading }} PO (Purchaase Order)
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
                name="supplier_name" value="{{ old('supplier_name') ?? (@$purchaseOrder->supplier->name ?? '') }}"
                placeholder="Search..." required>
            <input type="hidden" class="supplier_id" name="supplier_id" id="supplier_id"
                value="{{ old('supplier_id') ?? @$purchaseOrder?->supplier_id }}">
        </div>

        <div class="form-group col-4 indent_no">
            <label for="indent_no">Indent No: <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="indent_no" aria-describedby="indent_no" name="indent_no"
                value="{{ old('indent_no') ?? (@$purchaseOrder->indent->indent_no ?? '') }}" placeholder="Search...">
            <input type="hidden" name="indent_id" id="indent_id"
                value="{{ old('indent_id') ?? @$purchaseOrder?->indent_id }}">
        </div>

        <div class="form-group col-4 remarks">
            <label for="remarks">Remarks</label>
            <input type="text" class="form-control" id="remarks" aria-describedby="remarks" name="remarks"
                value="{{ old('remarks') ?? (@$purchaseOrder->remarks ?? '') }}">
        </div>
    </div>

    <table class="table table-bordered" id="material_requisition">
        <thead>
            <tr>
                <th>Requisiiton No.</th>
                <th>CS No.</th>
                <th>Quotation No</th>
                <th> Material Name</th>
                <th>Brand</th>
                <th>Description</th>
                <th>Unit</th>
                <th> Quantity </th>
                <th>Warranty Period</th>
                <th>Price </th>
                <th>Vat</th>
                <th>Tax</th>
                <th> Sub Total Amount </th>
                <th> Required Date </th>
                <th><i class="btn btn-primary btn-sm fa fa-plus add-requisition-row"></i></th>
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot>
            @php
                $purchase_requisition = old('purchase_requisition_id', !empty($purchaseOrder) ? $purchaseOrder->purchaseOrderLines->pluck('scmPurchaseRequisition.prs_no') : []);
                $purchase_requisition_id = old('purchase_requisition_id', !empty($purchaseOrder) ? $purchaseOrder->purchaseOrderLines->pluck('scm_purchase_requisition_id') : []);
                
                $cs_no = old('cs_no', !empty($purchaseOrder) ? $purchaseOrder->purchaseOrderLines->pluck('cs.cs_no') : []);
                $cs_id = old('cs_id', !empty($purchaseOrder) ? $purchaseOrder->purchaseOrderLines->pluck('cs.id') : []);
                
                $quotation_no = old('quotation_no', !empty($purchaseOrder) ? $purchaseOrder->purchaseOrderLines->pluck('quotation_no') : []);
                
                $material_name = old('material_name', !empty($purchaseOrder) ? $purchaseOrder->purchaseOrderLines->pluck('material.name') : []);
                $material_id = old('material_id', !empty($purchaseOrder) ? $purchaseOrder->purchaseOrderLines->pluck('material.id') : []);
                
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
            @foreach ($purchase_requisition as $key => $value)
                <tr>
                    <td class="form-group">
                        <select class="form-control text-center purchase_requisition_id" name="purchase_requisition_id[]">
                            <option value="" readonly selected>Select Requisiiton</option>
                            @foreach ($indentWiseRequisitions as $data)
                                @foreach ($data as $id => $prs_no)
                                    <option value="{{ $id }}"
                                        {{ $id == $purchase_requisition_id[$key] ? 'selected' : '' }}>
                                        {{ $prs_no }}</option>
                                @endforeach
                            @endforeach
                        </select>
                    </td>

                    <td>
                        <input type="text" class="form-control text-center cs_no" aria-describedby="cs_no" name="cs_no[]"
                            value="{{ $cs_no[$key] }}" placeholder="Search...">
                        <input type="hidden" name="cs_id[]" class="form-control text-center cs_id"
                            value="{{ $cs_id[$key] }}">
                    </td>

                    <td>
                        <input type="text" name="quotation_no[]" class="form-control text-center quotation_no"
                            autocomplete="off" value="{{ $quotation_no[$key] }}">
                    </td>

                    <td>
                        <select class="form-control text-center material_name select2" name="material_name[]">
                            <option value="" readonly selected>Select Material</option>
                            @foreach ($materials[$key] as $material)
                                <option value="{{ $material->material_id }}"
                                    {{ $material->material_id == $material_id[$key] ? 'selected' : '' }}>
                                    {{ $material->material->name }}</option>
                            @endforeach
                        </select>
                    </td>

                    <td>
                        <select class="form-control text-center brand_name select2" name="brand[]">
                            <option value="" readonly selected>Select Brand</option>
                            <option value="{{ $brand_id[$key] }}" selected>{{ $brand[$key] }}</option>
                        </select>
                    </td>

                    <td>
                        <input type="text" name="description[]" class="form-control text-center description"
                            autocomplete="off" value="{{ $description[$key] }}">
                    </td>

                    <td>
                        <input type="text" name="unit[]" class="form-control text-center unit" autocomplete="off"
                            readonly value="{{ $unit[$key] }}">
                    </td>

                    <td>
                        <input type="number" name="quantity[]" class="form-control text-center quantity"
                            autocomplete="off" value="{{ $quantity[$key] }}">
                    </td>

                    <td>
                        <input type="text" name="warranty_period[]" class="form-control text-center warranty_period"
                            autocomplete="off" value="{{ $warranty_period[$key] }}">
                    </td>

                    <td>
                        <input type="number" name="unit_price[]" class="form-control text-center unit_price"
                            autocomplete="off" readonly value="{{ $unit_price[$key] }}">
                    </td>

                    <td>
                        <select class="form-control text-center" name="vat[]">
                            @foreach ($vatOrTax as $value)
                                <option value="{{ $vat[$key] }}" @selected($value == $vat[$key])>{{ $value }}
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
                        <input name="total_amount[]" class="form-control text-center total_amount" autocomplete="off"
                            readonly value="{{ $total_amount[$key] }}">
                    </td>
                    <td>
                        <input class="form-control text-center date" name="required_date[]" aria-describedby="date"
                            value="{{ $required_date[$key] }}" readonly>
                    </td>
                    <td>
                        <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="11" class="text-right">Total Amount</td>
                <td>
                    <input type="text" name="final_total_amount" class="form-control text-center final_total_amount"
                        autocomplete="off"
                        value="{{ old('final_total_amount', !empty($purchaseOrder) ? $purchaseOrder->purchaseOrderLines->sum('total_amount') : 0) }}"
                        readonly>
                </td>
            </tr>
        </tfoot>
    </table>

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
        $('.select2').select2();
        $('.purchase_date').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true,
            showOtherMonths: true
        }).datepicker("setDate", new Date());

        //submit form with ajax and validation response
        document.querySelector('.custom-form').addEventListener('submit', function(e) {
            e.preventDefault(); // prevent default form submit
            var form_data = new FormData(this); // get form data
            fetch(this.action, {
                    method: this.method,
                    body: form_data
                })
                .then(function(response) {
                    if (!response.ok) {
                        // throw new Error('Network response was not ok');
                        console.log("not okay", response.responseJSON);

                    }
                    return response.json();
                })
                .then(function(response) {
                    // handle success response
                    if (response.status == 'success') {
                        window.location.href =
                            "{{ route('purchase-orders.index') }}?message=Purchase Order Created Successfully";
                    } else {
                        $('#errorlist').empty();
                        $('#errorlist').removeClass('d-none');

                        $.each(response, function(key, value) {
                            $('#errorlist').append('<p>' + value + '</p>');
                        });
                    }
                })
                .catch(function(error) {
                    console.log("not okay", error);
                });
        });

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

        var req_options = null;
        $(document).on('keyup', '.unit_price, .quantity', function() {
            var unit_price = $(this).closest('tr').find('.unit_price').val();
            var quantity = $(this).closest('tr').find('.quantity').val();
            var total_amount = unit_price * quantity;
            $(this).closest('tr').find('.total_amount').val(total_amount);
            calculateTotalAmount()

            //function for calculate total amount from all sub total amount
            function calculateTotalAmount() {
                var final_total_amount = 0;
                $('.total_amount').each(function() {
                    final_total_amount += parseFloat($(this).val());
                });
                $('.final_total_amount').val(final_total_amount.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }));
            }
        });

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
                    $('.purchase_requisition_id').html('');
                    $('#client_links').html('');
                    var options = '<option value="">Select PRS No</option>';


                    ui.item.requisition_nos.forEach(function(element) {
                        options +=
                            `<option value="${element.purchase_requisition_id}">${element.requisition_no}</option>`;
                    });
                    req_options = options;
                    $('.purchase_requisition_id').html(options);

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

        /* Append row */
        @if (empty($purchaseOrder) && empty(old('material_name')))
            appendCalculationRow();
        @endif
        function appendCalculationRow() {
            let row = `<tr>
                            <td class="form-group">
                                <select class="form-control purchase_requisition_id" name="purchase_requisition_id[]">
                                    <option value="" readonly selected>Select Requisiiton</option>

                                </select>
                            </td>

                            <td>
                                <input type="text" class="form-control cs_no" aria-describedby="cs_no" name="cs_no[]"
                                    value="{{ old('cs_no') ?? (@$purchaseOrder->client->name ?? '') }}" placeholder="Search...">
                                <input type="hidden" name="cs_id[]" class="form-control cs_id"
                                    value="{{ old('cs_id') ?? @$purchaseOrder?->client->id }}">
                            </td>

                            <td>
                                <input type="text" name="quotation_no[]" class="form-control quotation_no" autocomplete="off">
                            </td>

                            <td>
                                <select class="form-control material_name select2" name="material_id[]">
                                    <option value="" readonly selected>Select Material</option>

                                </select>
                            </td>

                            <td>
                                <select class="form-control brand_name select2" name="brand_id[]">
                                    <option value="" readonly selected>Select Material</option>

                                </select>
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
                                <input type="number" name="unit_price[]" class="form-control unit_price" autocomplete="off" readonly>
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
                                <input class="form-control date" name="required_date[]" aria-describedby="date" value="{{ old('required_date') ?? (@$purchaseOrder->required_date ?? '') }}" readonly placeholder="Select a required date">
                            </td>
                            <td>
                                <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i>
                            </td>
                        </tr>
                    `;
            $('#material_requisition tbody').append(row);
            getMaterial(this)
            $('.select2').select2();
        }

        //get cs no on keyup get 5 value evey time
        $(document).on('keyup', '.cs_no', function() {
            let supplier_id = $('#supplier_id').val();

            $(this).autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ url('search-cs-no') }}/" + supplier_id,
                        type: 'get',
                        dataType: "json",
                        data: {
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

                    $(this).closest('tr').find('.cs_no').val(ui.item.label);
                    $(this).closest('tr').find('.cs_id').val(ui.item.value);

                    getMaterial(this)
                    return false;
                }
            });
        });

        $(document).on('change', '.purchase_requisition_id', function() {
            getMaterial(this)
        })

        $(document).on('select2:open', '.material_name', function() {
            // Attach mouseover event to options inside Select2 dropdown
            $('.select2-results__options').on('mouseover', '.select2-results__option', function() {
                //call getMaterial function
                getMaterial(this)
            });
        });

        $(document).on('select2:close', '.material_name', function() {
            // Remove mouseover event from options inside Select2 dropdown
            $('.select2-results__options').off('mouseover', '.select2-results__option');
        });

        /* Adds and removes quantity row on click */
        $("#material_requisition")
            .on('click', '.add-requisition-row', () => {
                // $('.purchase_requisition_id').last().html(req_options);
                appendCalculationRow();
                $('.select2').select2();
            })
            .on('click', '.remove-calculation-row', function() {
                $(this).closest('tr').remove();
            });

        //Search Material
        function getMaterial(e) {
            let cs_id = $(e).closest('tr').find('.cs_id').val();
            let purchase_requisition_id = $(e).closest('tr').find('.purchase_requisition_id').val();

            if (purchase_requisition_id != '' && cs_id != '') {
                const url = '{{ url('/scm/search-material-by-cs-requisition') }}/' + cs_id + '/' + purchase_requisition_id;
                let dropdown;

                dropdown = $(e).closest('tr').find('.material_name');
                // $('.material_name').each(function() {
                // });
                dropdown.empty();
                dropdown.append('<option selected disabled>Select Material</option>');
                dropdown.prop('selectedIndex', 0);

                $.getJSON(url, function(items) {
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
            let cs_id = $(this).closest('tr').find('.cs_id').val();
            let supplier_id = $('#supplier_id').val();
            var selectedIndex = this;

            if (supplier_id == '') {
                alert('Please select a supplier first');
                return false;
            }

            const url = '{{ url('/scm/search-material-price-by-cs-requisition') }}/' + cs_id + '/' + supplier_id +
                '/' + material_id;

            let dropdown;

            dropdown = $(this).closest('tr').find('.brand_name');
            // $('.material_name').each(function() {
            // });
            dropdown.empty();
            dropdown.append('<option selected disabled>Select Material</option>');
            dropdown.prop('selectedIndex', 0);

            $.getJSON(url, function(items) {

                $.each(items, function(key, material) {
                    dropdown.append($('<option></option>')
                        .attr('value', material.cs_material.brand.id)
                        .attr('data-price', material.price)
                        .attr('data-unit', material.cs_material.material.unit)
                        .text(material.cs_material.brand.name))
                })

                console.log(items);
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
            let price = $(this).find(':selected').data('price');
            let unit = $(this).find(':selected').data('unit');

            $(this).closest('tr').find('.unit').val(unit);
            $(this).closest('tr').find('.unit_price').val(price);
        })
    </script>
@endsection
