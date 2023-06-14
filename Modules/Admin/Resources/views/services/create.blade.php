@extends('layouts.backend-layout')
@section('title', 'Services')

@php
    $is_old = old('client_id') ? true : false;
    $form_heading = !empty($survey->id) ? 'Update' : 'Add';
    $form_url = !empty($survey->id) ? route('services.update', $survey->id) : route('services.store');
    $form_method = !empty($survey->id) ? 'PUT' : 'POST';
@endphp

@section('breadcrumb-title')
    {{ ucfirst($form_heading) }} Services
@endsection

@section('breadcrumb-button')
    <a href="{{ route('services.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-database"></i></a>
@endsection

@section('sub-title')
@endsection

@section('content-grid', null)

@section('content')
    {!! Form::open([
        'url' => $form_url,
        'method' => $form_method,
        'class' => 'custom-form',
    ]) !!}

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="text-center mt-4">
                    <h5> <span> &#10070; </span> New Service <span>&#10070;</span> </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <x-input-box colGrid="2" name="reference" label="Reference" value="" />
                        <x-input-box colGrid="2" name="bbts_link_id" id="bbts_link_id" label="BBTS Link Id" value="" attr="required" />
                        <x-input-box colGrid="2" name="link_type" label="Link Type" value="" attr="readonly" />
                        <x-input-box colGrid="2" name="link_name" label="Link Name" value="" attr="readonly" />
                        <x-input-box colGrid="2" name="vendor" label="Vendor" value="" attr="readonly" />
                        <x-input-box colGrid="2" id="vendor_id" name="vendor_id" label="Vendor Link ID" value="" attr="readonly" />
                    </div>
                    <div class="row">
                        <div class="col-1"></div>
                        <div class="col-6 mb-4 display-6">From Info :</div>
                        <div class="col-3 mb-4 display-6">To Info :</div>
                    </div>
                    <div class="row">
                        <div class="col-1"></div>
                        <x-input-box colGrid="2" name="from_location" label="From Location1" value=""
                            placeholder="POP" attr="readonly" />
                        <input type="hidden" id="from_pop_id" name="from_pop_id">
                        <div class="col-2"></div>
                        <div class="col-2">
                        </div>
                        <x-input-box colGrid="2" name="division_id" label="Division" value=""
                            placeholder="Division name" attr="readonly" />
                        <x-input-box colGrid="2" name="to_location" label="To Location" value="" attr="readonly" />
                        <input type="hidden" id="to_pop_id" name="to_pop_id">
                    </div>
                    <div class="row">
                        <div class="col-1"></div>
                        <x-input-box colGrid="2" name="from_site" label="From Site" value="" placeholder="LDP" attr="readonly" />
                        <div class="col-4"></div>
                        <x-input-box colGrid="2" name="district_id" label="District" value=""
                            placeholder="District name" attr="readonly" />
                        <x-input-box colGrid="2" name="to_site" label="To Site" value="" placeholder="LDP/POC" attr="readonly" />
                    </div>
                    <div class="row">
                        <div class="col-2"></div>
                        <div class="col-3"></div>
                        <div class="col-2"></div>
                        <x-input-box colGrid="2" name="thana_id" label="Thana" value=""
                            placeholder="Thana name" attr="readonly" />
                        <x-input-box colGrid="2" name="gps" label="GPS" value="" placeholder="Lat/Long" attr="readonly" />
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <select class="form-control" id="status" name="status" required>
                                <option value="" selected disabled>Select Status</option>
                                <option value="Increase">Increase</option>
                                <option value="Decrease">Decrease</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                        <x-input-box colGrid="5" name="remarks" label="Remarks" value="" attr="readonly" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="offset-md-4 col-md-4 mt-1">
                    <table class="table table-bordered" id="service_table">
                        <thead>
                            <tr>
                                <th>Service Name</th>
                                <th>Quantity</th>
                                <th>Rate</th>
                                <th>Amount</th>
                                <th>Remarks</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select class="form-control select2" id="service_id" name="service_id" required>
                                        <option value="" selected disabled>Select Service</option>
                                        @foreach (@$products as $product)
                                            <option value="{{ $product->id }}"
                                                {{ (old('service_id') ?? ($product->id ?? '')) == $product->id ? 'selected' : '' }}>
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" class="form-control" id="quantity" name="quantity" required>
                                </td>
                                <td>
                                    <input type="number" class="form-control" id="rate" name="rate" required>
                                </td>
                                <td>
                                    <input type="number" class="form-control" id="amount" name="amount" required>
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="remarks" name="remarks" required>
                                </td>
                                <td>
                                    <button type="button"
                                        class="btn btn-success btn-sm fa fa-plus add-service-row"></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <button class="py-2 btn btn-success ">{{ !empty($lead_generation->id) ? 'Update' : 'Save' }}</button>
        </div>
    </div>
    </div>
    {!! Form::close() !!}
@endsection

@section('script')
    <script>
        $('.date').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true,
            showOtherMonths: true
        });

        /* Adds and removes quantity row on click */
        $("#service_table").on('click', '.add-service-row', () => {
            appendServiceRow();
        }).on('click', '.remove-requisition-row', function() {
            if ($('#service_table tbody tr').length == 1) {
                return false;
            }
            $(this).closest('tr').remove();
        });


        function appendServiceRow() {
            let row = `<tr>
                        <td>
                            <select class="form-control select2" id="service_id" name="service_id" required>
                                <option value="" selected disabled>Select Service</option>
                                @foreach (@$products as $product)
                                    <option value="{{ $product->id }}"
                                        {{ (old('service_id') ?? ($product->id ?? '')) == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" class="form-control" id="quantity" name="quantity" required>
                        </td>
                        <td>
                            <input type="number" class="form-control" id="rate" name="rate" required>
                        </td>
                        <td>
                            <input type="number" class="form-control" id="amount" name="amount" required>
                        </td>
                        <td>
                            <input type="text" class="form-control" id="remarks" name="remarks" required>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm fa fa-minus remove-requisition-row"></button>
                        </td>
                    </tr>`;
            $('#service_table tbody').append(row);
        }

        $('#bbts_link_id').on('keyup', function() {
            let myObject = {}
            jquaryUiAjax(this, "{{ route('get_bbts_link_id') }}", uiList, myObject);

            function uiList(item) {
                $('#bbts_link_id').val(item.label).attr('value', item.label);
                $('#division_id').val(item.division_id).trigger('change');
                $('#link_name').val(item.link_name).attr('value', item.link_name);
                $('#link_type').val(item.link_type).attr('value', item.link_type);
                $('#vendor_id').val(item.vendor_id).attr('value', item.vendor_id);
                $('#vendor').val(item.vendor_name).attr('value', item.vendor_name);
                $('#from_location').val(item.from_location).attr('value', item.from_location);
                $('#to_location').val(item.to_location).attr('value', item.to_location);
                $('#from_site').val(item.from_site).attr('value', item.from_site);
                $('#to_site').val(item.to_site).attr('value', item.to_site);
                $('#gps').val(item.gps).attr('value', item.gps);
                $('#vendor_link_id').val(item.vendor_link_id).attr('value', item.vendor_link_id);
                $('#remarks').val(item.remarks).attr('value', item.remarks);        
                $('#district_id').val(item.district_id).trigger('change');
                $('#thana_id').val(item.thana_id).trigger('change');
                return false;
            }
        })


        $('.select2').select2({
            placeholder: 'Select an option'
        });
    </script>
@endsection
