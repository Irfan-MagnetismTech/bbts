@extends('layouts.backend-layout')
@section('title', 'Purchase Order')

@php
    $is_old = old('effective_date') ? true : false;
    $form_heading = !empty($cs->id) ? 'Update' : 'Add';
    $form_url = !empty($cs->id) ? route('cs.update', $cs->id) : route('cs.store');
    $form_method = !empty($cs->id) ? 'PUT' : 'POST';
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
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('purchase-requisitions.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
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
        <div class="form-group col-4">
            <label for="date">Purchase Date:</label>
            <input class="form-control date" name="date" aria-describedby="date"
                value="{{ old('date') ?? (@$purchaseRequisition->date ?? '') }}" readonly placeholder="Select a Date">
        </div>

        <div class="form-group col-4 delivery_location">
            <label for="delivery_location">Delivery Location:</label>
            <input type="text" class="form-control" id="delivery_location" aria-describedby="delivery_location"
                name="delivery_location"
                value="{{ old('delivery_location') ?? (@$purchaseRequisition->client->delivery_location ?? '') }}">
        </div>

        <div class="form-group col-4 supplier_name">
            <label for="supplier_name">Supplier Name:</label>
            <input type="text" class="form-control supplier_name" aria-describedby="supplier_name" id="supplier_name"
                name="supplier_name" value="{{ old('supplier_name') ?? (@$purchaseRequisition->client->name ?? '') }}"
                placeholder="Search...">
            <input type="hidden" name="supplier_id" id="supplier_id"
                value="{{ old('supplier_id') ?? @$purchaseRequisition?->client->id }}">
        </div>

        <div class="form-group col-4 indent_no">
            <label for="indent_no">Indent No:</label>
            <input type="text" class="form-control" id="indent_no" aria-describedby="indent_no" name="indent_no"
                value="{{ old('indent_no') ?? (@$purchaseRequisition->client->name ?? '') }}" placeholder="Search...">
            <input type="hidden" name="indent_id" id="indent_id"
                value="{{ old('indent_id') ?? @$purchaseRequisition?->client->id }}">
        </div>

        <div class="form-group col-4 remarks">
            <label for="remarks">Remarks</label>
            <input type="text" class="form-control" id="remarks" aria-describedby="remarks" name="remarks"
                value="{{ old('remarks') ?? (@$purchaseRequisition->client->remarks ?? '') }}">
        </div>
    </div>

    <table class="table table-bordered" id="material_requisition">
        <thead>
            <tr>
                <th>Requisiiton No.</th>
                <th>CS No.</th>
                <th>Quotation No</th>
                <th> Material Name</th>
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
                $material_name_with_code = old('material_name', !empty($purchaseRequisition) ? $purchaseRequisition->scmPurchaseRequisitionDetails->pluck('material.materialNameWithCode') : []);
                $material_id = old('material_id', !empty($purchaseRequisition) ? $purchaseRequisition->scmPurchaseRequisitionDetails->pluck('material_id') : []);
                $item_code = old('item_code', !empty($purchaseRequisition) ? $purchaseRequisition->scmPurchaseRequisitionDetails->pluck('material.code') : []);
                $unit = old('unit', !empty($purchaseRequisition) ? $purchaseRequisition->scmPurchaseRequisitionDetails->pluck('material.unit') : []);
                $brand_id = old('brand_id', !empty($purchaseRequisition) ? $purchaseRequisition->scmPurchaseRequisitionDetails->pluck('brand_id') : []);
                $quantity = old('quantity', !empty($purchaseRequisition) ? $purchaseRequisition->scmPurchaseRequisitionDetails->pluck('quantity') : []);
                $unit_price = old('unit_price', !empty($purchaseRequisition) ? $purchaseRequisition->scmPurchaseRequisitionDetails->pluck('unit_price') : []);
                $total_amount = old('total_amount', !empty($purchaseRequisition) ? $purchaseRequisition->scmPurchaseRequisitionDetails->pluck('total_amount') : []);
                $model = old('model', !empty($purchaseRequisition) ? $purchaseRequisition->scmPurchaseRequisitionDetails->pluck('model') : []);
                $purpose = old('purpose', !empty($purchaseRequisition) ? $purchaseRequisition->scmPurchaseRequisitionDetails->pluck('purpose') : []);
            @endphp
            @foreach ($material_name_with_code as $key => $requisitionDetail)
                <tr>
                    <td class="client_links">
                        <label for="select2">Client Links</label>
                        <select class="form-control select2" id="client_links" name="client_links">
                            <option value="" readonly selected>Select Client Link</option>
                            @if (!empty($purchaseRequisition))
                                @foreach ($clientInfos as $clientInfo)
                                    <option value="{{ $clientInfo->link_name }}" @selected($clientInfo->fr_composite_key == @$purchaseRequisition->fr_composite_key)>
                                        {{ $clientInfo->link_name }}</option>
                                @endforeach
                            @else
                                <option value="{{ old('client_links') }}" selected>{{ old('client_links') }}</option>
                            @endif
                        </select>
                    </td>
                    <td>
                        <input type="text" name="material_name[]" class="form-control material_name" required
                            autocomplete="off" value="{{ $material_name_with_code[$key] }}">
                        <input type="hidden" name="material_id[]" class="form-control material_id"
                            value="{{ $material_id[$key] }}">
                        <input type="hidden" name="item_code[]" class="form-control item_code"
                            value="{{ $item_code[$key] }}">
                    </td>
                    <td>
                        <input type="text" name="unit[]" class="form-control unit" autocomplete="off" readonly
                            value="{{ $unit[$key] }}" id="unit">
                    </td>
                    <td>
                        <select name="brand_id[]" class="form-control brand" autocomplete="off">
                            <option value="">Select Brand</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" @selected($brand->id == $brand_id[$key])>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="text" name="model[]" class="form-control model" autocomplete="off"
                            value="{{ $model[$key] }}">
                    </td>
                    <td>
                        <input type="number" name="unit_price[]" class="form-control unit_price" autocomplete="off"
                            value="{{ $unit_price[$key] }}">
                    </td>
                    <td>
                        <input type="number" name="quantity[]" class="form-control quantity" autocomplete="off"
                            value="{{ $quantity[$key] }}">
                    </td>
                    <td>
                        <input name="total_amount[]" class="form-control total_amount" autocomplete="off"
                            value="{{ $total_amount[$key] }}" readonly>
                    </td>
                    <td>
                        <input type="text" name="purpose[]" class="form-control purpose" autocomplete="off"
                            value="{{ $purpose[$key] }}">
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
    {!! Form::close() !!}
@endsection

@section('script')
    <script>
        var req_options = null;
        $(document).on('keyup', '.unit_price, .quantity', function() {
            var unit_price = $(this).closest('tr').find('.unit_price').val();
            var quantity = $(this).closest('tr').find('.quantity').val();
            var total_amount = unit_price * quantity;
            $(this).closest('tr').find('.total_amount').val(total_amount);
        });

        $(document).on('keyup', "#supplier_name", function() {
            $('.supplier_id').val('');
            $('.cs_id').val('');
            $('cs_no').val('');
            $('.material_name').text('');
            $('.unit').val('');
            $('.price').val('');
            $('.unit_price').val('');

            $(this).autocomplete({
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
                    $('.requisition_no').html('');
                    $('#client_links').html('');
                    var options = '<option value="">Select PRS No</option>';


                    ui.item.requisition_nos.forEach(function(element) {
                        options +=
                            `<option value="${element.requisition_id}">${element.requisition_no}</option>`;
                    });
                    req_options = options;
                    $('.requisition_no').html(options);

                    return false;
                }
            });
        });

        $('.date').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true,
            showOtherMonths: true
        }).datepicker("setDate", new Date());
        /* Append row */
        @if (empty($purchaseRequisition) && empty(old('material_name')))
            appendCalculationRow();
        @endif
        function appendCalculationRow() {
            var type = $("input[name=type]:checked").val()
            let row = `<tr>
                            <td class="form-group">
                                <select class="form-control requisition_no" name="requisition_no[]">
                                    <option value="" readonly selected>Select Requisiiton</option>
                                   
                                </select>
                            </td>

                            <td>
                                <input type="text" class="form-control cs_no" aria-describedby="cs_no" name="cs_no[]"
                                    value="{{ old('cs_no') ?? (@$purchaseRequisition->client->name ?? '') }}" placeholder="Search...">
                                <input type="hidden" name="cs_id[]" class="form-control cs_id"
                                    value="{{ old('cs_id') ?? @$purchaseRequisition?->client->id }}">
                            </td>

                            <td>
                                <input type="text" name="quatation_no[]" class="form-control quatation_no" autocomplete="off">  
                            </td>

                            <td>
                                <select class="form-control material_name select2" name="material_name[]">
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
                                <select class="form-control" name="vat_or_tax[]">
                                    @foreach ($vatOrTax as $key => $value)
                                        <option value="{{ $value }}" @selected($key == @$purchaseRequisition->vat_or_tax)>
                                            {{ $value }}</option>
                                    @endforeach
                                </select>
                            </td>

                            <td>
                                <select class="form-control" name="vat_or_tax[]">
                                    @foreach ($vatOrTax as $key => $value)
                                        <option value="{{ $value }}" @selected($key == @$purchaseRequisition->vat_or_tax)>
                                            {{ $value }}</option>
                                    @endforeach
                                </select>
                            </td>
                            
                            <td>
                                <input name="total_amount[]" class="form-control total_amount" autocomplete="off" readonly>
                            </td>
                            <td>
                                <input class="form-control date" name="required_date[]" aria-describedby="date" value="{{ old('required_date') ?? (@$purchaseRequisition->required_date ?? '') }}" readonly placeholder="Select a required date">
                            </td>
                            <td>
                                <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i>
                            </td>
                        </tr>
                    `;
            $('#material_requisition tbody').append(row);

            $('.select2').select2();

            $('.date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                showOtherMonths: true
            }).datepicker("setDate", new Date());

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
        }

        $(document).on('change', '.requisition_no', function() {
            getMaterial(this)
        })

        /* Adds and removes quantity row on click */
        $("#material_requisition")
            .on('click', '.add-requisition-row', () => {
                appendCalculationRow();
                $('.requisition_no').last().html(req_options);

            })
            .on('click', '.remove-calculation-row', function() {
                $(this).closest('tr').remove();
            });

        //Search Client
        var client_details = [];
        @if (!empty($purchaseRequisition))
            client_details = {!! collect($clientInfos) !!}
        @endif
        $(document).on('keyup', '#client_name', function() {
            $(this).autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ url('search-client') }}",
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
                    $('#client_name').val(ui.item.label);
                    $('#client_id').val(ui.item.value);
                    $('#client_no').val(ui.item.client_no);

                    $('#client_links').html('');
                    var link_options = '<option value="">Select link</option>';

                    ui.item.details.forEach(function(element) {
                        link_options +=
                            `<option value="${element.link_name}">${element.link_name}</option>`;
                    });
                    client_details = ui.item.details;
                    $('#client_links').html(link_options);

                    return false;
                }
            });
        });

        //Select FR key based on link name
        $('#client_links').on('change', function() {
            var link_name = $("input[name='gender']:checked").val();
            var link_name = $(this).val();
            var client_id = $('#client_id').val();
            var client = client_details.find(function(element) {
                return element.link_name == link_name;
            });
            $('#fr_id').val(client.fr_id);
            $('#fr_composite_key').val(client.fr_composite_key);
        });

        //Search Material
        function getMaterial(e) {

            let cs_id = $(e).closest('tr').find('.cs_id').val();
            let requisition_no = $(e).closest('tr').find('.requisition_no').val();

            if (requisition_no != '' && cs_id != '') {
                const url = '{{ url('/scm/search-material-by-cs-requisition') }}/' + cs_id + '/' + requisition_no;
                let dropdown;

                $('.material_name').each(function() {
                    dropdown = $(this).closest('tr').find('.material_name');
                });
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

            $.getJSON(url, function(item) {
                console.log(item);
                //check if item is empty or not
                if (item === null) {
                    alert('No price found for this material');
                    return false;
                }
                $(selectedIndex).closest('tr').find('.unit').val(item.cs_material.material.unit);
                $(selectedIndex).closest('tr').find('.unit_price').val(item.price);
            });
        })

        // $(document).on('keyup', '.material_name', function() {
        //     $(this).autocomplete({
        //         source: function(request, response) {
        //             $.ajax({
        //                 url: "{{ url('search-material') }}",
        //                 type: 'get',
        //                 dataType: "json",
        //                 data: {
        //                     search: request.term
        //                 },
        //                 success: function(data) {
        //                     response(data);
        //                 }
        //             });
        //         },
        //         select: function(event, ui) {
        //             $(this).closest('tr').find('.material_name').val(ui.item.label);
        //             $(this).closest('tr').find('.material_id').val(ui.item.value);
        //             $(this).closest('tr').find('.item_code').val(ui.item.item_code);
        //             $(this).closest('tr').find('.unit').val(ui.item.unit);
        //             return false;
        //         }
        //     });

        // });


        // associativeDropdown("{{ route('searchPop') }}", 'search', '#branch_id', '#pop_id', 'get', null)

        function onChangeRadioButton() {
            var radioValue = $("input[name='type']:checked").val();
            if (radioValue == 'client') {
                $('.pop_id').hide('slow');
                $('.fr_id').show('slow');
                $('.client_name').show('slow');
                $('.client_no').show('slow');
                $('.client_links').show('slow');
                $('.assesment_no').show('slow');
            } else if (radioValue == 'internal') {
                $('.pop_id').hide('slow');
                $('.fr_id').hide('slow');
                $('.client_name').hide('slow');
                $('.client_no').hide('slow');
                $('.client_links').hide('slow');
                $('.assesment_no').hide('slow');
            }
        }
    </script>
@endsection
