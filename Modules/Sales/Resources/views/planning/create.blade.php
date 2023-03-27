@extends('layouts.backend-layout')
@section('title', 'Planning')

@php
    $is_old = old() ? true : false;
    $form_heading = !empty($planning->id) ? 'Edit' : 'Create';
    $form_url = !empty($planning->id) ? route('planning.update', $planning->id) : route('planning.store');
    $form_method = !empty($planning->id) ? 'PUT' : 'POST';
@endphp

@section('breadcrumb-title')
    {{ ucfirst($form_heading) }} Planning
@endsection

@section('breadcrumb-button')
    <a href="{{ route('planning.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-list"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')

    {!! Form::open([
        'url' => $form_url,
        'method' => $form_method,
        'class' => 'custom-form',
    ]) !!}

    {{-- Comparative Statement --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="tableHeading">
                    <h5> <span> &#10070; </span> Planning <span>&#10070;</span> </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @php
                            
                        @endphp
                    </div>
                    <div class="row">
                        <div class="md-col-3 col-3">
                            <label for="client_id">Client ID <span class="text-danger">*</span></label>
                            <input type="text" name="client_id" id="client_id" class="form-control" value="">
                        </div>
                        <div class="md-col-3 col-3">
                            <label for="client_name">Client Name <span class="text-danger">*</span></label>
                            <input type="text" name="client_name" id="client_name" class="form-control" value=""
                                readonly>
                        </div>
                        <div class="md-col-3 col-3">
                            <label for="date">Date <span class="text-danger">*</span></label>
                            <input type="text" name="date" id="date" class="form-control" value=""
                                readonly>
                        </div>
                        <div class="md-col-3 col-3">
                            <label for="link_name">Link Name <span class="text-danger">*</span></label>
                            <input type="text" name="link_name" id="link_name" class="form-control" value=""
                                readonly>
                        </div>
                        <div class="md-col-3 col-3">
                            <label for="from_location">From Location <span class="text-danger">*</span></label>
                            <select name="from_location" id="from_location" class="form-control">
                                <option value="">Select From Location</option>
                                @foreach ($all_fr_list as $fr)
                                    <option value="{{ $fr->id }}" {{ $fr->id == $from_location ? 'selected' : '' }}>
                                        {{ $fr->fr_no }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md-col-3 col-3">
                            <label for="to_location">Type <span class="text-danger">*</span></label>
                            <select name="type" id="type" class="form-control">
                                <option value="">Select Type</option>
                                <option value="Primary">Primary</option>
                                <option value="Secondary">Secondary</option>
                                <option value="Tertiary">Tertiary</option>
                            </select>
                        </div>

                        <div class="md-col-3 col-3">
                            <label for="fr_no">FR No <span class="text-danger">*</span></label>
                            <input type="text" name="fr_no" id="fr_no" class="form-control" value=""
                                readonly>
                        </div>

                        <div class="md-col-3 col-3">
                            <label for="client_status">Client Status <span class="text-danger">*</span></label>
                            <input type="text" name="client_status" id="client_status" class="form-control"
                                value="" readonly>
                        </div>

                        <div class="md-col-3 col-3">
                            <label for="to_location">Vendor <span class="text-danger">*</span></label>
                            <input type="text" name="vendor" id="vendor" class="form-control" value=""
                                readonly>
                        </div>

                        <div class="md-col-3 col-3">
                            <label for="to_location">Method <span class="text-danger">*</span></label>
                            <input type="text" name="method" id="method" class="form-control" value=""
                                readonly>
                        </div>
                        <div class="md-col-3 col-3">
                            <label for="to_location">Option <span class="text-danger">*</span></label>
                            <select name="option" id="option" class="form-control">
                                <option value="">Select Option</option>
                                <option value="Option 1">Option 1</option>
                                <option value="Option 2">Option 2</option>
                                <option value="Option 3">Option 3
                                </option>
                            </select>
                        </div>
                        <div class="md-col-3 col-3">
                            <label for="to_location">Distance <span class="text-danger">*</span></label>
                            <input type="text" name="distance" id="distance" class="form-control" value=""
                                readonly>
                        </div>
                        <div class="md-col-3 col-3">
                            <label for="to_location">Connectivity Point <span class="text-danger">*</span></label>
                            <input type="text" name="connectivity_point" id="connectivity_point" class="form-control"
                                value="" readonly>
                        </div>
                        <div class="md-col-3 col-3">
                            <label for="to_location">GPS <span class="text-danger">*</span></label>
                            <input type="text" name="gps" id="gps" class="form-control" value=""
                                readonly>
                        </div>
                        <div class="md-col-3 col-3">
                            <label for="to_location">Connectivity Route <span class="text-danger">*</span></label>
                            <input type="text" name="connectivity_route" id="connectivity_route" class="form-control"
                                value="" readonly>
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
                                            <th colspan="5">Product Details</th>
                                        </tr>
                                        <tr>
                                            <th>Category</th>
                                            <th>Product</th>
                                            <th>Capacity</th>
                                            <th>Unit</th>
                                            <th>
                                                <button type="button" class="btn btn-sm btn-success"
                                                    id="addProductRow"><i class="fas fa-plus"></i></button>
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="md-col-6 col-6">
                            {{-- Connectivity Details --}}
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th colspan="5">Connectivity Details</th>
                                        </tr>
                                        <tr>
                                            <th>Link Type</th>
                                            <th>Method</th>
                                            <th>Capacity %</th>
                                            <th>Uptime Reg/SLA</th>
                                            <th>
                                                <button type="button" class="btn btn-sm btn-success"
                                                    id="addConnectivityRow"><i class="fas fa-plus"></i></button>
                                            </th>
                                        </tr>
                                    </thead>
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
                let products;
                $(document).on('change', '.category_id', function() {
                    console.log('fine')
                    var category_id = $(this).val();
                    var row = $(this).closest('tr').find('.product_id');
                    $.ajax({
                        url: "{{ route('get-products') }}",
                        data: {
                            category_id: category_id,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            products = data;
                            let html = '<option value="">Select Product</option>';
                            $.each(data, function(key, value) {
                                html += '<option value="' + value.id + '">' + value.name + '</option>';
                            });
                            row.html(html);
                        }
                    });
                });

                $(document).on('change', '.product_id', function() {
                    var product_id = $(this).val();
                    var row = $(this).closest('tr').find('.unit');
                    products.find(function(product) {
                        if (product.id == product_id) {
                            row.val(product.unit);
                        }
                    });
                })

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

                $(document).on('click', '.removeProductRow', function() {
                    let count = $('.product_details_row').length;
                    if (count > 1) {
                        $(this).closest('tr').remove();
                        //get attr_one value 
                        var attr_one = $(this).attr('product_attr');
                        //if attr_one value is not empty then delete from database
                        if (attr_one != '') {
                            $.ajax({
                                url: "{{ route('delete-product-requirement-details') }}",
                                data: {
                                    id: attr_one,
                                    _token: "{{ csrf_token() }}"
                                },
                                success: function(data) {
                                    console.log(data);
                                }
                            });
                        }
                    }
                });

                $(document).on('click', '.removeConnectivityRow', function() {
                    let count = $('.connectivity_details_row').length;
                    if (count > 1) {
                        $(this).closest('tr').remove();
                        //get attr_one value 
                        var attr_one = $(this).attr('connectivity_attr');
                        //if attr_one value is not empty then delete from database
                        if (attr_one != '') {
                            $.ajax({
                                url: "{{ route('delete-connectivity-requirement-details') }}",
                                data: {
                                    id: attr_one,
                                    _token: "{{ csrf_token() }}"
                                },
                                success: function(data) {
                                    console.log(data);
                                }
                            });
                        }
                    }
                });

                $('#client_id').on('input', function() {
                    var client_id = $(this).val();
                    console.log(client_id)
                    $(this).autocomplete({
                        source: function(request, response) {
                            $.ajax({
                                url: "{{ route('get-client') }}",
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
                            $('#client_id').val(ui.item.label);
                            $('#client_name').val(ui.item.value);
                            $('#lead_generation_id').val(ui.item.lead_generation_id);
                            return false;
                        }
                    });
                });

                $('#date').datepicker({
                    format: "dd-mm-yyyy",
                    autoclose: true,
                    todayHighlight: true,
                    showOtherMonths: true
                }).datepicker("setDate", new Date());
            </script>
        @endsection
