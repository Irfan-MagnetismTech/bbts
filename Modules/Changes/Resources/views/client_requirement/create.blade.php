@extends('layouts.backend-layout')
@section('title', 'Client Requirement Modification')

@php
    $is_old = old() ? true : false;
    $form_heading = !empty($requirement_modification->id) ? 'Update' : 'Add';
    $form_url = !empty($requirement_modification->id) ? route('client-requirement-modification.update', $requirement_modification->id) : route('client-requirement-modification.store');
    $form_method = !empty($requirement_modification->id) ? 'PUT' : 'POST';
@endphp

@section('breadcrumb-title')
    {{ ucfirst($form_heading) }} Client Requirement Modification
@endsection

@section('breadcrumb-button')
    <a href="{{ route('client-requirement-modification.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-list"></i></a>

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

    {{-- Comparative Statement --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="tableHeading">
                    <h5> <span> &#10070; </span> Client Requirement Modification <span>&#10070;</span> </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @php
                            
                        @endphp
                    </div>
                    <div class="row">
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="client_id" id="client_id" class="form-control" value="">
                                <label for="client_id">Client ID <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="client_name" id="client_name" class="form-control"
                                    value="" readonly>
                                <label for="client_name">Client Name <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="date" id="date" class="form-control" value="">
                                <label for="date">Date <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="activation_date" id="activation_date" class="form-control"
                                    value="">
                                <label for="activation_date">Activation Date <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <select name="fr_no" id="fr_no" class="form-control">
                                    <option value="">Select FR No</option>
                                </select>
                                <label for="fr_no">FR No <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        {{-- file upload --}}
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="reason" id="reason" class="form-control">
                                <label for="fr_no">Reason <span class="text-danger">*</span></label>
                            </div>

                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" name="change_type[]" value="Temporary-Inactive">
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span>Temporary-Inactive</span>
                                </label>
                            </div>
                            <div class="checkbox-fade fade-in-primar  y">
                                <label>
                                    <input type="checkbox" name="change_type[]" value="Permanent Inactive">
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span>Permanent Inactive</span>
                                </label>
                            </div>
                            <div class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" name="change_type[]" value="Re-Inactive">
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span>Re-Inactive</span>
                                </label>
                            </div>
                            <div class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" name="change_type[]" value="B/W Increase/Decrease">
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span>B/W Increase/Decrease</span>
                                </label>
                            </div>
                            <div class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" name="change_type[]" value="IP Increase/Decrease">
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span>IP Increase/Decrease</span>
                                </label>
                            </div>
                            <div class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" name="change_type[]" value="MRC Decrease">
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span>MRC Decrease</span>
                                </label>
                            </div>
                            <div class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" name="change_type[]"
                                        value="Price Increase/Decrease with BW Change">
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span>Price Increase/Decrease with BW Change</span>
                                </label>
                            </div>
                            <div class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" name="change_type[]" value="Method Change">
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span>Method Change</span>
                                </label>
                            </div>
                            <div class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" name="change_type[]" value="Redundant Link">
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span>Redundant Link</span>
                                </label>
                            </div>
                            <div class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" name="change_type[]" value="Shifting">
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span>Shifting</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    {{-- create a responsive table --}}
                    <div class="row mt-3">
                        <div id="logical-table" class="md-col-12 col-12" style="display:none">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th colspan="7">Product Details</th>
                                        </tr>
                                        <tr>
                                            <th>Category</th>
                                            <th>Product</th>
                                            <th>Prev Quantity</th>
                                            <th>Unit</th>
                                            <th>Plan</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody class="productBody">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="physical-table" class="md-col-12 col-12" style="display:none">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th colspan="7">Existing Link</th>
                                        </tr>
                                        <tr>
                                            <th>Link Type</th>
                                            <th>Method</th>
                                            <th>Vendor</th>
                                            <th>BTS/POP</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="connectivityBody">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div id="logical-table-edit" class="md-col-12 col-12" style="display: none">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th colspan="7">New Product Details</th>
                                        </tr>
                                        <tr>
                                            <th>Category</th>
                                            <th>Product</th>
                                            <th>Prev Quantity</th>
                                            <th>Unit</th>
                                            <th>Plan</th>
                                            <th>Remarks</th>
                                            <th>
                                                <button type="button" class="btn btn-sm btn-success addProductEdit"
                                                    onclick="addProductEdit()"><i class="fas fa-plus"></i></button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="productEditBody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div id="physical-table-edit" class="md-col-12 col-12" style="display: none">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th colspan="7">New / Update Connectivity Link</th>
                                        </tr>
                                        <tr>
                                            <th>Link Type</th>
                                            <th>Method</th>
                                            <th>Capacity(%)</th>
                                            <th>Uptime Reg/SLA</th>
                                            <th>Vendor</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="connectivityEditBody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <button
                        class="py-2 btn btn-success float-right">{{ !empty($client_request->id) ? 'Update' : 'Save' }}</button>
                </div>
            </div>
            {!! Form::close() !!}

        @endsection

        @section('script')
            <script>
                function addProductEdit() {
                    let table_row = `
                            <tr class="product_details_row">
                                <td>
                                    <select name="product_category[]" class="form-control product_category">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="product[]" class="form-control product">
                                        <option value="">Select Product</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="capacity[]" class="form-control capacity" value="">
                                </td>
                                <td>
                                    <input type="text" name="unit[]" class="form-control unit" value="">
                                </td>
                                <td>
                                    <input type="text" name="plan[]" class="form-control unit" value="">
                                </td>
                                <td>
                                    <input type="text" name="remarks[]" class="form-control remarks" value="">
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-danger removeProductRow"><i class="fas fa-minus"></i></button>
                                </td>
                            </tr>
                        `;
                    $('.productEditBody').append(table_row);
                };

                function addProductRow() {
                    $('.product_details_row').first().clone().appendTo('.productBody');
                    $('.product_details_row').last().find('input').val('');
                    $('.product_details_row').last().find('select').val('');
                };

                function addConnectivityRow() {
                    $('.connectivity_details_row').first().clone().appendTo('.connectivityBody');
                    $('.connectivity_details_row').last().find('input').val('');
                    $('.connectivity_details_row').last().find('select').val('');
                };

                $('#client_id').on('input', function() {
                    var client_id = $(this).val();
                    var html = '<option value="">Select Fr No</option>';
                    $(this).autocomplete({
                        source: function(request, response) {
                            $.ajax({
                                url: "{{ route('searchClient') }}",
                                data: {
                                    client_id: client_id,
                                    _token: "{{ csrf_token() }}"
                                },
                                success: function(data) {
                                    response(data);
                                }
                            });
                        },
                        select: function(event, ui) {
                            $('#client_id').val(ui.item.value).attr('value', ui.item.value);
                            $('#client_name').val(ui.item.label).attr('value', ui.item.label);
                            //foreach loop for fr no
                            $.each(ui.item.frDetails, function(key, value) {
                                html += '<option value="' + value + '">' + value +
                                    '</option>';
                            });
                            $('#fr_no').html(html);
                            return false;
                        }
                    });
                });

                $('#fr_no').on('change', function() {
                    var fr_no = $(this).val();
                    var client_no = $('#client_id').val();
                    var logical_table = '';
                    var physical_table = '';
                    $.ajax({
                        url: "{{ route('getLogicalConnectivityData') }}",
                        data: {
                            fr_no: fr_no,
                            client_no: client_no,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            console.log(data)
                            $.each(data.logical_connectivity.lines, function(key, value) {
                                logical_table += `
                                        <tr class="product_details_row">
                                            <td>
                                                <select name="product_category[]" class="form-control product_category">
                                                    <option value="">Select Category</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}" ${value.product_category === "{{ $category->name }}" ? 'selected' : ''}>{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="product[]" class="form-control product">
                                                    <option value="">Select Product</option>
                                                    @foreach ($products->where('category_id') as $product)
                                                        <option value="{{ $product->id }}" ${value.product_id == {{ $product->id }} ? 'selected' : ''}>{{ $product->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="capacity[]" class="form-control capacity" value="${value.quantity}">
                                            </td>
                                            <td>
                                                <input type="text" name="unit[]" class="form-control unit" value="${value.product.unit}">
                                            </td>
                                            <td>
                                                <input type="text" name="plan[]" class="form-control plan" value="">
                                            </td>
                                            <td>
                                                <input type="text" name="remarks[]" class="form-control remarks" value="${value.remarks}">
                                            </td>
                                        </tr>
                                    `;
                            });
                            $('.productBody').html(logical_table);
                            $.each(data.physical_connectivity.lines, function(key, value) {
                                physical_table += `
                                        <tr class="connectivity_details_row">
                                            <td>
                                                <input type="text" name="link_type[]" class="form-control link_type" value="${value.link_type}">
                                            </td>
                                            <td>
                                                <input type="text" name="method[]" class="form-control method" value="${value.method}">
                                            </td>
                                            <td>
                                                <input type="text" name="vendor[]" class="form-control vendor" value="${value?.connectivity_link?.vendor?.name}">
                                            </td>
                                            <td>
                                                <input type="text" name="bts_pop[]" class="form-control bts_pop" value="${value.pop}">
                                            </td>
                                            <td>
                                                <a href="#" title="Edit" class="btn btn-sm btn-outline-warning physicalLinkEdit"><i class="fas fa-pen"></i></a>
                                            </td>
                                        </tr>
                                    `;
                            });
                            $('.connectivityBody').html(physical_table);
                            $('#logical-table').fadeIn();
                            $('#physical-table').fadeIn();
                            $('#logical-table-edit').fadeIn();
                            $('#physical-table-edit').fadeIn();
                        }
                    });
                });

                $(document).on('change', '.product_category', function(e) {
                    let category_id = $(this).val();
                    console.log(category_id)
                    let all_products = {!! json_encode($products) !!};
                    let products = all_products.filter(product => product.category_id == category_id);
                    console.log(products)
                    let html = '<option value="">Select Product</option>';
                    products.forEach(product => {
                        html += `<option value="${product.id}">${product.name}</option>`;
                    });
                    $(this).closest('tr').find('.product').html(html);
                });

                $(document).on('change', '.product', function(e) {
                    let products = {!! json_encode($products) !!};
                    let product_id = $(this).val();
                    let product = products.find(product => product.id == product_id);
                    $(this).closest('tr').find('.unit').val(product.unit);
                });

                $(document).on('click', '.physicalLinkEdit', function(e) {
                    e.preventDefault();
                    let link_type = $(this).closest('tr').find('.link_type').val();
                    let method = $(this).closest('tr').find('.method').val();
                    let html = `
                            <tr class="connectivity_details_row">
                                <td>
                                    <input type="text" name="link_type[]" class="form-control link_type" value="${link_type}">
                                </td>
                                <td>
                                    <input type="text" name="method[]" class="form-control method" value="${method}">
                                </td>
                                <td>
                                    <input type="text" name="connectivity_capacity[]" class="form-control connectivity_capacity" value="">
                                </td>
                                <td>
                                    <input type="text" name="uptime_req[]" class="form-control uptime_req" value="">
                                </td>
                                <td>
                                    <select name="vendor_id[]" class="form-control vendor_id">
                                        <option value="">Select Vendor</option>
                                        @foreach ($vendors as $vendor)
                                            <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-danger removeConnectivityRow"><i class="fas fa-minus"></i></button>
                                </td>
                            </tr>
                        `;
                    $('.connectivityEditBody').append(html);
                });


                $('#date, #activation_date').datepicker({
                    format: "dd-mm-yyyy",
                    autoclose: true,
                    todayHighlight: true,
                    showOtherMonths: true
                }).datepicker("setDate", new Date());
            </script>
        @endsection
