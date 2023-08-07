@extends('layouts.backend-layout')
@section('title', 'Connectivity Requirement')

@php
    $is_old = old() ? true : false;
    $form_heading = !empty($client_request->id) ? 'Update' : 'Add';
    $form_url = !empty($client_request->id) ? route('client-request.update', $client_request->id) : route('client-request.store');
    $form_method = !empty($client_request->id) ? 'PUT' : 'POST';
@endphp

@section('breadcrumb-title')
    {{ ucfirst($form_heading) }} Client Request
@endsection

@section('breadcrumb-button')
    <a href="{{ route('client-request.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-list"></i></a>

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
                    <h5> <span> &#10070; </span> Client Request <span>&#10070;</span> </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @php
                            
                        @endphp
                    </div>
                    <div class="row">
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="client_no" id="client_id" class="form-control" value=""
                                    readonly>
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
                                <input type="text" name="date" id="date" class="form-control" value=""
                                    readonly>
                                <label for="date">Date <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="activation_date" id="activation_date" class="form-control"
                                    value="" readonly>
                                <label for="activation_date">Activation Date <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="fr_no" id="fr_no" class="form-control"
                                    value="{{ $fr_no }}" readonly>
                                <label for="fr_no">FR No <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        {{-- file upload --}}
                        <div class="md-col-3 col-3">
                            <input type="file" name="document" id="file" class="form-control" title="Upload File">
                        </div>
                    </div>
                    <div class="row">


                    </div>

                    <hr />
                    <div class="text-center">
                        <h5> <span> &#10070; </span> Connectivity Details <span>&#10070;</span> </h5>
                    </div>
                    <hr />
                    {{-- create a responsive table --}}
                    <div class="row">
                        <div class="md-col-6 col-6">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th colspan="6">Product Details</th>
                                        </tr>
                                        <tr>
                                            <th style="width:25%">Category</th>
                                            <th style="width:25%">Product</th>
                                            <th>Capacity</th>
                                            <th>Unit</th>
                                            <th>Remarks</th>
                                            <th>
                                                <button type="button" class="btn btn-sm btn-success" id="addProductRow"><i
                                                        class="fas fa-plus"></i></button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="productBody">
                                        <tr class="product_details_row">
                                            <td>
                                                <select name="category_id[]" class="form-control category_id">
                                                    <option value="">Select Category</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="product_id[]" class="form-control product_id">
                                                    <option value="">Select Product</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" name="capacity[]" class="form-control capacity"
                                                    placeholder="Capacity" />
                                            </td>
                                            <td>
                                                <input type="text" name="unit[]" class="form-control unit"
                                                    placeholder="Unit" />
                                            </td>
                                            <td>
                                                <input type="text" name="remarks[]" class="form-control remarks"
                                                    placeholder="Remarks" />
                                            </td>
                                            <td>
                                                <button type="button" producut_attr=""
                                                    class="btn btn-sm btn-danger removeProductRow"><i
                                                        class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="md-col-6 col-6">
                            {{-- Connectivity Details --}}
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th colspan="6">Connectivity Details</th>
                                        </tr>
                                        <tr>
                                            <th style="width:15%">Link Type</th>
                                            <th style="width:25%">Method</th>
                                            <th>Capacity %</th>
                                            <th>Uptime Reg/SLA</th>
                                            <th style="width:25%">Vendor</th>
                                            <th>
                                                <button type="button" class="btn btn-sm btn-success"
                                                    id="addConnectivityRow"><i class="fas fa-plus"></i></button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="connectivityBody">
                                        <tr class="connectivity_details_row">
                                            <td>
                                                <select name="link_type[]" class="form-control link_type">
                                                    <option value="">Select Link Type</option>
                                                    <option value="Primary">Primary</option>
                                                    <option value="Secondary">Secondary</option>
                                                    <option value="Tertiary">Tertiary</option>

                                                </select>
                                            </td>
                                            <td>
                                                <select name="method[]" class="form-control method">
                                                    <option value="">Select Method</option>
                                                    <option value="Fiber">Fiber</option>
                                                    <option value="Radio">Radio</option>
                                                    <option value="GSM">GSM</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" name="connectivity_capacity[]"
                                                    class="form-control capacity" placeholder="Capacity %" />
                                            </td>
                                            <td>
                                                <input type="text" name="uptime_req[]" id="uptime_req"
                                                    class="form-control" placeholder="Uptime Reg/SLA" />
                                            </td>
                                            <td>
                                                <select name="vendor_id[]" class="form-control vendor_id">
                                                    <option value="">Select Vendor</option>
                                                    @foreach ($vendors as $vendor)
                                                        <option value="{{ $vendor->id }}">
                                                            {{ $vendor->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <button type="button" connectivity_attr=""
                                                    class="btn btn-sm btn-danger removeConnectivityRow"><i
                                                        class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <button
                        class="py-2 btn btn-success float-right">{{ !empty($connectivity_requirement->id) ? 'Update' : 'Save' }}</button>
                </div>
            </div>
            {!! Form::close() !!}

        @endsection

        @section('script')
            <script>
                // let products;
                // $(document).on('change', '.category_id', function() {
                //     console.log('fine')
                //     var category_id = $(this).val();
                //     var row = $(this).closest('tr').find('.product_id');
                //     $.ajax({
                //         url: "{{ route('get-products') }}",
                //         data: {
                //             category_id: category_id,
                //             _token: "{{ csrf_token() }}"
                //         },
                //         success: function(data) {
                //             products = data;
                //             let html = '<option value="">Select Product</option>';
                //             $.each(data, function(key, value) {
                //                 html += '<option value="' + value.id + '">' + value.name + '</option>';
                //             });
                //             row.html(html);
                //         }
                //     });
                // });

                /* $(document).on('change', '.product_id', function() {
                    var product_id = $(this).val();
                    var row = $(this).closest('tr').find('.unit');
                    products.find(function(product) {
                        if (product.id == product_id) {
                            row.val(product.unit);
                        }
                    });
                }) */

                $('#addProductRow').on('click', function() {
                    addProductRow();
                });

                $('#addConnectivityRow').on('click', function() {
                    addConnectivityRow();
                });

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

                // $('#client_id').on('input', function() {
                //     var client_id = $(this).val();
                //     console.log(client_id)
                //     $(this).autocomplete({
                //         source: function(request, response) {
                //             $.ajax({
                //                 url: "{{ route('get-client') }}",
                //                 data: {
                //                     client_id: client_id,
                //                     _token: "{{ csrf_token() }}"
                //                 },
                //                 success: function(data) {
                //                     response(data);
                //                 }
                //             });
                //         },
                //         select: function(event, ui) {
                //             $('#client_id').val(ui.item.label).attr('value', ui.item.label);
                //             $('#client_name').val(ui.item.value).attr('value', ui.item.value);
                //             $('#lead_generation_id').val(ui.item.lead_generation_id).attr('value', ui.item
                //                 .lead_generation_id);
                //             return false;
                //         }
                //     });
                // });


                $('#date').datepicker({
                    format: "dd-mm-yyyy",
                    autoclose: true,
                    todayHighlight: true,
                    showOtherMonths: true
                }).datepicker("setDate", new Date());
            </script>
        @endsection
