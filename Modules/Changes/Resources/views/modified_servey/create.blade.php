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
<style>
     
</style>
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
                                <input type="text" name="client_id" id="client_id" class="form-control" value="{{$connectivity_requirement->client_no}}">
                                <label for="client_id">Client ID <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="client_name" id="client_name" class="form-control" readonly value="{{$connectivity_requirement->client->client_name}}">
                                <label for="client_name">Client Name <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="name_of_the_link" id="name_of_the_link" class="form-control" value="{{$connectivity_requirement->FeasibilityRequirementDetail->connectivity_point}}">
                                <label for="name_of_the_link">Name Of The Link <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="date" id="date" class="form-control"
                                    value="">
                                <label for="date">Date<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="mq_id" id="mq_id" class="form-control" value="{{$connectivity_requirement->FeasibilityRequirementDetail->feasibilityRequirement->mq_no}}">
                                <label for="mq_id">MQ ID<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="fr_id" id="fr_id" class="form-control"
                                    value="{{$connectivity_requirement->fr_no}}" readonly>
                                <label for="fr_id">FR ID<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="client_gps" id="client_gps" class="form-control" value="{{$connectivity_requirement->FeasibilityRequirementDetail->lat}} : {{$connectivity_requirement->FeasibilityRequirementDetail->long}}">
                                <label for="client_gps">Client GPS<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="file" name="requirement" id="requirement" class="form-control"
                                    value="">
                                <label for="requirement">Requirement<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="division" id="division" class="form-control" value="{{$connectivity_requirement->FeasibilityRequirementDetail->division->name}}">
                                <label for="division">Division<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="district" id="district" class="form-control"
                                    value="{{$connectivity_requirement->FeasibilityRequirementDetail->district->name}}" readonly>
                                <label for="district">District<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="thana" id="thana" class="form-control" value="{{$connectivity_requirement->FeasibilityRequirementDetail->thana->name}}">
                                <label for="thana">Thana<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="location" id="location" class="form-control"
                                    value="{{$connectivity_requirement->FeasibilityRequirementDetail->location}}">
                                <label for="location">Location<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="file" name="survey_attached" id="survey_attached" class="form-control" value="">
                                <label for="survey_attached">Survey Attached<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="contact_name" id="contact_name" class="form-control"
                                    value="{{$connectivity_requirement->FeasibilityRequirementDetail->contact_name}}" readonly>
                                <label for="contact_name">Contact Name <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="designation" id="designation" class="form-control" value="{{$connectivity_requirement->FeasibilityRequirementDetail->contact_designation}}">
                                <label for="designation">Designation <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="contact_no" id="contact_no" class="form-control"
                                    value="{{$connectivity_requirement->FeasibilityRequirementDetail->contact_number}}">
                                <label for="contact_no">Contact No<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="contact_no" id="contact_no" class="form-control"
                                value="{{$connectivity_requirement->FeasibilityRequirementDetail->contact_number}}">
                                <label for="remarks">Remarks <span class="text-danger">*</span></label>
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
                                    <span>Method Change</span>
                                </label>
                            </div>
                            <div class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" name="change_type[]" value="Permanent Inactive">
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span>Redundant Link</span>
                                </label>
                            </div>
                            <div class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" name="change_type[]" value="Re-Inactive">
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span>Shifting</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    {{-- create a responsive table --}}
                    <div class="row">
                        <div class="col-6">
                            <div class="tableHeading">
                                <h5> <span> &#10070; </span> Connectivity Details <span>&#10070;</span> </h5>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <th>Link Type</th>
                                        <th>Method</th>
                                        <th>Capacity (%)</th>
                                        <th>Uptime Requirement / SLA</th>
                                        <th>Vendor</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($connectivity_requirement->connectivityRequirementDetails as $key =>$value )
                                        <tr>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="link_type[]" class="form-control text-center"
                                                        id="service_name" readonly value="{{$value->link_type}}">
                                                </div>
                                            </td>
                                            <td> 
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="method[]" class="form-control text-right"
                                                        id="quantity" readonly value="{{$value->method}}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="capacity[]" class="form-control text-center"
                                                        id="unit" readonly value="{{$value->connectivity_capacity}}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="sla[]"
                                                        class="form-control text-right" readonly value="{{$value->sla}}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="vendor[]"
                                                        class="form-control text-right" readonly value="{{$value->vendor->name}}">
                                                    <input type="hidden" name="vendor_id[]"
                                                        class="form-control text-right" readonly value="{{$value->vendor_id}}">
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="tableHeading">
                                <h5> <span> &#10070; </span> Product Requirement <span>&#10070;</span> </h5>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <th>Product/Service</th>
                                        <th>Prev Qty</th>
                                        <th>Req Qty</th>
                                        <th>Unit</th>
                                        <th>Remarks</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($grouped_qty as $key => $value )
                                        <tr>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="product_name[]" class="form-control text-center"
                                                        readonly value="{{ isset($grouped_current_qty[$key]) ? $grouped_current_qty[$key]->first()->product->name : $grouped_previous_qty[$key]->first()?->product?->name ?? ''}}">
                                                    <input type="hidden" name="product_id[]" class="form-control text-center"
                                                        readonly value="{{ isset($grouped_current_qty[$key]) ? $grouped_current_qty[$key]->first()->product_id : $grouped_previous_qty[$key]->first()?->product_id ?? ''}}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="rate[]"
                                                        class="form-control text-right" readonly value="{{ isset($grouped_previous_qty[$key]) ? $grouped_previous_qty[$key]->first()->capacity :0}}">
                                                </div>
                                            </td>
                                            <td> 
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="quantity[]" class="form-control text-right"
                                                        id="quantity" readonly value="{{ isset($grouped_current_qty[$key]) ? $grouped_current_qty[$key]->first()->capacity :0}}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="unit[]" class="form-control text-center"
                                                        id="unit" readonly value="{{$value->first()?->product?->unit ?? ''}}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="rate[]"
                                                        class="form-control text-right" readonly value="">
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <div class="tableHeading">
                            <h5> <span> &#10070; </span> Existing Connection <span>&#10070;</span> </h5>
                        </div>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <th>Link Type</th>
                                <th>Existing / New</th>
                                <th>Method</th>
                                <th>Vendor</th>
                                <th>BTS/POP/LDP</th>
                                <th>GPS</th>
                                <th>Distance</th>
                                <th>Current Capacity</th>
                                <th>Remarks</th>
                            </thead>
                            <tbody class="existingBody">
                                @foreach ($existingConnections as $key => $value )
                                <tr class="product_existing_row">
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="product_name" class="form-control text-center"
                                                id="service_name" readonly value="{{$value->link_type}}">
                                        </div>
                                    </td>
                                    <td> 
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="quantity" class="form-control text-right"
                                                id="quantity" readonly value="Existing">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="unit" class="form-control text-center"
                                                id="unit" readonly value="{{$value->connectivityLink->vendor->name}}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="rate"
                                                class="form-control text-right" readonly value="{{$value->method}}">
                                        </div>
                                    </td>
                                    <td class="d-none">
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="price"
                                                class="form-control text-right" readonly value="{{$value->ldp}}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="total_price"
                                                class="form-control text-right" readonly value="{{$value->connectivityLink->gps}}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="product_name" class="form-control text-center"
                                                id="service_name" readonly value="{{$value->connectivityLink->gps}}">
                                            <input type="hidden" name="product_id" class="form-control text-center"
                                                id="service" readonly value="">
                                        </div>
                                    </td>
                                    <td> 
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="quantity" class="form-control text-right"
                                                id="quantity" readonly value="{{$value->physicalConnectivity->planning->finalSurveyDetail->distance ?? 0}}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="unit" class="form-control text-center"
                                                id="unit" readonly value="{{$value->physicalConnectivity->planning->finalSurveyDetail->current_capacity ?? 0}}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="rate"
                                                class="form-control text-right" readonly value="">
                                        </div>
                                    </td>
                                    <td class="d-none">
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="price"
                                                class="form-control text-right" readonly value="">
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="table-responsive">
                        <div class="tableHeading">
                            <h5> <span> &#10070; </span> New Requirement Survey <span>&#10070;</span> </h5>
                        </div>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <th>Link Type</th>
                                <th>Option</th>
                                <th>Existing / New</th>
                                <th>Method</th>
                                <th>Vendor</th>
                                <th>BTS/POP/LDP</th>
                                <th>GPS</th>
                                <th>Distance</th>
                                <th>Current Capacity</th>
                                <th>Remarks</th>
                                <th><i class="btn btn-primary btn-sm fa fa-plus add_requirement_row"></i></th>
                            </thead>
                            <tbody class="requirementBody">
                                @foreach ($connectivity_requirement->connectivityRequirementDetails as $key => $value )
                                    
                               
                                <tr class="requirement_details_row">
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="product_name" class="form-control text-center"
                                                id="service_name" value="{{$value->link_type}}">
                                        </div>
                                    </td>
                                    <td> 
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="quantity" class="form-control text-right"
                                                id="quantity" value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="unit" class="form-control text-center"
                                                id="unit" value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="rate"
                                                class="form-control text-right" value="{{$value->sla}}">
                                        </div>
                                    </td>
                                    <td class="d-none">
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="price"
                                                class="form-control text-right" value="{{$value->method}}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="total_price"
                                                class="form-control text-right" value="{{$value->vendor->name}}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="product_name" class="form-control text-center"
                                                id="service_name" value="">
                                            <input type="hidden" name="product_id" class="form-control text-center"
                                                id="service" value="">
                                        </div>
                                    </td>
                                    <td> 
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="quantity" class="form-control text-right"
                                                id="quantity" value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="unit" class="form-control text-center"
                                                id="unit" value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="rate"
                                                class="form-control text-right" value="{{$value->connectivity_capacity}}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="total_price"
                                                class="form-control text-right" value="">
                                        </div>
                                    </td>
                                    <td>
                                        <i class="btn btn-danger btn-sm fa fa-minus remove_requirement_row"></i>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <button
                        class="py-2 btn btn-success float-right">{{ !empty($client_request->id) ? 'Update' : 'Save' }}</button>
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


                $('.add_requirement_row').on('click', function() {
                    addRequirementRow();
                });
                $(document).on('click','.remove_requirement_row', function() {
                    $(this).closest('tr').remove();
                });

                function addExistingRow() {
                    $('.product_existing_row').first().clone().appendTo('.existingBody');
                    $('.product_existing_row').last().find('input').val('').attr('readonly',false);
                    $('.product_existing_row').last().find('select').val('').attr('readonly',false);
                };

                function addRequirementRow() {
                    $('.requirement_details_row').first().clone().appendTo('.requirementBody');
                    $('.requirement_details_row').last().find('input').val('');
                    $('.requirement_details_row').last().find('select').val('');
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
                    $.ajax({
                        url: "{{ route('getLogicalConnectivityData') }}",
                        data: {
                            fr_no: fr_no,
                            client_no: client_no,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            $('#logical-table').html(data.logical_table_data);
                            $('#physical-table').html(data.physical_table_data);
                        }
                    });
                });


                $('#date, #activation_date').datepicker({
                    format: "dd-mm-yyyy",
                    autoclose: true,
                    todayHighlight: true,
                    showOtherMonths: true
                }).datepicker("setDate", new Date());
            </script>
        @endsection
