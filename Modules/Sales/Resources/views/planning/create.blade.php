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
                            <label for="from_location">From Location <span class="text-danger">*</span></label>
                            <select name="from_location" id="from_location" class="form-control">
                                <option value="">Select From Location</option>
                            </select>
                        </div>

                    </div>
                    <div class="row mt-4">
                        <div class="md-col-2 col-2">
                            <label for="type">Type <span class="text-danger">*</span></label>
                            <select name="type" id="type" class="form-control">
                                <option value="">Select Type</option>
                                <option value="Primary">Primary</option>
                                <option value="Secondary">Secondary</option>
                                <option value="Tertiary">Tertiary</option>
                            </select>
                        </div>

                        <div class="md-col-2 col-2">
                            <label for="fr_no">FR No <span class="text-danger">*</span></label>
                            <input type="text" name="fr_no" id="fr_no" class="form-control" value=""
                                readonly>
                        </div>

                        <div class="md-col-2 col-2">
                            <label for="is_existing">Client Status <span class="text-danger">*</span></label>
                            <div class="row" style="justify-content: space-evenly">
                                <div>
                                    <input type="radio" name="is_existing" id="is_new" value="New"
                                        autocomplete="off" required>
                                    <label style="font-size: 15px; margin-left:5px;" for="is_new">New</label>
                                </div>
                                <div>
                                    <input type="radio" name="is_existing" id="is_existing" value="Existing"
                                        autocomplete="off" required>
                                    <label style="font-size: 15px; margin-left:5px;" for="is_existing">Existing</label>
                                </div>

                            </div>
                        </div>

                        <div class="md-col-3 col-3">
                            <label for="vendor">Vendor <span class="text-danger">*</span></label>
                            <input type="text" name="vendor" id="vendor" class="form-control" value=""
                                readonly>
                        </div>
                        <div class="md-col-3 col-3">
                            <label for="method">Method <span class="text-danger">*</span></label>
                            <input type="text" name="method" id="method" class="form-control" value=""
                                readonly>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="md-col-2 col-2">
                            <label for="option">Option <span class="text-danger">*</span></label>
                            <select name="option" id="option" class="form-control">
                                <option value="">Select Option</option>
                                <option value="Option 1">Option 1</option>
                                <option value="Option 2">Option 2</option>
                                <option value="Option 3">Option 3
                                </option>
                            </select>
                        </div>
                        <div class="md-col-2 col-2">
                            <label for="distance">Distance <span class="text-danger">*</span></label>
                            <input type="text" name="distance" id="distance" class="form-control" value=""
                                readonly>
                        </div>
                        <div class="md-col-2 col-2">
                            <label for="to_location">Connectivity Point <span class="text-danger">*</span></label>
                            <input type="text" name="connectivity_point" id="connectivity_point" class="form-control"
                                value="" readonly>
                        </div>
                        <div class="md-col-3 col-3">
                            <label for="gps">GPS <span class="text-danger">*</span></label>
                            <input type="text" name="gps" id="gps" class="form-control" value=""
                                readonly>
                        </div>
                        <div class="md-col-3 col-3">
                            <label for="connectivity_route">Connectivity Route <span class="text-danger">*</span></label>
                            <input type="text" name="connectivity_route" id="connectivity_route" class="form-control"
                                value="" readonly>
                        </div>
                    </div>
                    <hr />
                    <div class="text-center">
                        <h5> <span> &#10070; </span> Connectivity Details <span>&#10070;</span> </h5>
                    </div>
                    <hr />
                    {{-- create a responsive table --}}
                    <div class="row ">
                        <div class="md-col-6 col-6">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th colspan="4">Service Plan</th>
                                        </tr>
                                        <tr>
                                            <th>Particulars</th>
                                            <th>Client Req.</th>
                                            <th>Plan</th>
                                            <th>
                                                <button type="button" class="btn btn-sm btn-success"
                                                    id="addParticularRow"><i class="fas fa-plus"></i></button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="particular_body">
                                        <tr class="particular_row">
                                            <td>
                                                <select name="particulars[]" id="particulars" class="form-control">
                                                    <option value="">Select Particulars</option>
                                                    @foreach ($particulars as $particular)
                                                        <option value="{{ $particular->id }}">
                                                            {{ $particular->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="client_req[]" id="client_req"
                                                    class="form-control" value="">
                                            </td>
                                            <td>
                                                <input type="text" name="plan[]" id="plan" class="form-control"
                                                    value="">
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-danger removeProductRow"><i
                                                        class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                </table>
                            </div>
                        </div>
                        <div class="md-col-6 col-6">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th colspan="4">Equipment Plan</th>
                                        </tr>
                                        <tr>
                                            <th>Material</th>
                                            <th>Unit</th>
                                            <th>Quantity</th>
                                            <th>
                                                <button type="button" class="btn btn-sm btn-success"
                                                    id="addEquipmentRow"><i class="fas fa-plus"></i></button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="equipment_body">
                                        <tr class="equipment_row">
                                            <td>
                                                <select name="material[]" id="material" class="form-control">
                                                    <option value="">Select Material</option>
                                                    <option value="Bandwidth">Bandwidth</option>
                                                    <option value="Bandwidth">Bandwidth</option>
                                                    <option value="Bandwidth">Bandwidth</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="unit[]" id="unit" class="form-control"
                                                    value="">
                                            </td>
                                            <td>
                                                <input type="text" name="quantity[]" id="quantity"
                                                    class="form-control" value="">
                                            </td>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-sm btn-danger removeConnectivityRow"><i
                                                        class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class="text-center">
                        <h5> <span> &#10070; </span> Plan Preview <span>&#10070;</span> </h5>
                    </div>
                    <hr />
                    {{-- create a responsive table --}}
                    <div class="row">
                        <div class="md-col-6 col-6">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th colspan="4">Equipment Plan</th>
                                        </tr>
                                        <tr>
                                            <th>Material</th>
                                            <th>Unit</th>
                                            <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <select name="material[]" id="material" class="form-control">
                                                    <option value="">Select Material</option>
                                                    <option value="Bandwidth">Bandwidth</option>
                                                    <option value="Bandwidth">Bandwidth</option>
                                                    <option value="Bandwidth">Bandwidth</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="unit[]" id="unit" class="form-control"
                                                    value="">
                                            </td>
                                            <td>
                                                <input type="text" name="quantity[]" id="quantity"
                                                    class="form-control" value="">
                                            </td>
                                        </tr>
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

                $('#addParticularRow').on('click', function() {
                    addParticularRow();
                });

                $('#addEquipmentRow').on('click', function() {
                    addEquipmentRow();
                });

                function addParticularRow() {
                    $('.particular_row').first().clone().appendTo('#particular_body');
                    $('.particular_row').last().find('input').val('');
                    $('.particular_row').last().find('select').val('');
                };

                function addEquipmentRow() {
                    $('.equipment_row').first().clone().appendTo('#equipment_body');
                    $('.equipment_row').last().find('input').val('');
                    $('.equipment_row').last().find('select').val('');
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
                            getClientFrList(ui.item.label);
                            return false;
                        }

                    })
                });

                $('#date').datepicker({
                    format: "dd-mm-yyyy",
                    autoclose: true,
                    todayHighlight: true,
                    showOtherMonths: true
                }).datepicker("setDate", new Date());
                var fr_link_list;

                function getClientFrList(client_id) {
                    $.ajax({
                        url: "{{ route('get-client-fr-list') }}",
                        data: {
                            client_id: client_id,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            fr_link_list = data;
                            let html = '<option value="">Select FR</option>';
                            $.each(data, function(key, value) {
                                html += '<option value="' + value.id + '">' + value.link_name + '</option>';
                            });
                            $('#from_location').html(html);
                        }
                    });
                }

                $('#from_location').on('change', function() {
                    var from_location = $(this).val();
                    fr_link_list.find(function(fr) {
                        console.log(fr.link_name)
                        console.log(from_location)
                        if (fr.id == from_location) {
                            $('#fr_no').val(fr.fr_no);
                        }
                    });
                });

                $('#option').on('change', function() {
                    var option = $('#option').val();
                    var type = $('#type').val();
                    let client_id = $('#client_id').val();
                    let fr_no = $('#fr_no').val();
                    $.ajax({
                        url: "{{ route('get-survey-details') }}",
                        data: {
                            option: option,
                            type: type,
                            client_id: client_id,
                            fr_no: fr_no,
                        },
                        success: function(data) {
                            console.log(data)
                            if (data.status == 'Existing') {
                                $('#is_existing').prop('checked', true);
                            } else {
                                $('#is_new').prop('checked', true);
                            }
                            $('#vendor').val(data.vendor);
                            $('#method').val(data.method);
                            $('#distance').val(data.distance);
                            $('#gps').val(data.gps);
                            $('#connectivity_point').val(data.bts_pop_ldp)
                        }
                    });

                });
            </script>
        @endsection
