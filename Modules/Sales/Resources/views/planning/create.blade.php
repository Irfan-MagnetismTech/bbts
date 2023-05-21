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
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <h5 class="text-center">Client Information</h5>
                            <hr />
                            <table class="table custom_table table-bordered" style="font-size: 12px;">
                                <tr>
                                    <th>Client Name</th>
                                    <td>{{ $lead_generation->client_name }}</td>
                                    <th>Address</th>
                                    <td>{{ $lead_generation->address }}</td>
                                </tr>
                                <tr>
                                    <th>Division</th>
                                    <td>{{ $lead_generation->division->name ?? '' }}</td>
                                    <th>District</th>
                                    <td>{{ $lead_generation->district->name ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th>Thana</th>
                                    <td>{{ $lead_generation->thana->name ?? '' }}</td>
                                    <th>Landmark</th>
                                    <td>{{ $lead_generation->landmark }}</td>
                                </tr>
                                <tr>
                                    <th>Lat-Long</th>
                                    <td>{{ $lead_generation->lat_long }}</td>
                                    <th>Contact Person</th>
                                    <td>{{ $lead_generation->contact_person }}</td>
                                </tr>
                                <tr>
                                    <th>Contact No</th>
                                    <td>{{ $lead_generation->contact_no }}</td>
                                    <th>Email</th>
                                    <td>{{ $lead_generation->email }}</td>
                                </tr>
                                <tr>
                                    <th>Website</th>
                                    <td>{{ $lead_generation->website }}</td>
                                    <th>Document</th>
                                    <td>
                                        @if ($lead_generation->document)
                                            <a href="{{ asset('uploads/lead_generation/' . $lead_generation->document) }}"
                                                target="_blank" class="btn btn-sm btn-warning" style="font-size:14px;"><i
                                                    class="fas fa-eye"></i></a>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <hr />
                    <div class="text-center">
                        <h5> <span> &#10070; </span> Plan Details <span>&#10070;</span> </h5>
                    </div>
                    <hr />
                    {{-- create a responsive table --}}
                    <div class="row ">
                        <div class="md-col-6 col-6">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th colspan="5">Service Plan for
                                                {{ $feasibilityRequirementDetail->location }}</th>
                                        </tr>
                                        <tr>
                                            <th>Particulars</th>
                                            <th>Client Req.</th>
                                            <th>Plan</th>
                                            <th>Remarks</th>
                                            <th>
                                                <button type="button" class="btn btn-sm btn-success"
                                                    id="addParticularRow"><i class="fas fa-plus"></i></button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="particular_body">
                                        @foreach ($connectivityProductRequirementDetails as $detail)
                                            <tr class="particular_row">
                                                <td style="width:30%">
                                                    <input type="hidden" name="detail_id[]" id="detail_id"
                                                        class="form-control" value="{{ $detail->id ?? '' }}">
                                                    <span class="form-control">{{ $detail->product->name ?? '' }}</span>

                                                </td>
                                                <td>
                                                    <span class="form-control">{{ $detail->capacity ?? '' }}</span>
                                                </td>
                                                <td>
                                                    <input type="text" name="plan[]" id="plan" class="form-control"
                                                        value="">
                                                </td>
                                                <td style="width:30%">
                                                    <span class="form-control">{{ $detail->remarks ?? '' }}</span>
                                                </td>
                                                <td>
                                                    <button type="button"
                                                        class="btn btn-sm btn-danger removeParticularRow"><i
                                                            class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                </table>
                            </div>
                        </div>
                        <div class="md-col-6 col-6">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th colspan="5">Equipment Plan for product</th>
                                        </tr>
                                        <tr>
                                            <th>Equipment Name</th>
                                            <th>Quantity</th>
                                            <th>Unit</th>
                                            <th>Remarks</th>
                                            <th>
                                                <button type="button" class="btn btn-sm btn-success"
                                                    id="addEquipmentRow"><i class="fas fa-plus"></i></button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="equipment_body">
                                        <tr class="equipment_row">
                                            <td>
                                                <input type="text" name="equipment_name[]" id="equipment_name"
                                                    class="form-control" value="">
                                            </td>
                                            <td>
                                                <input type="text" name="quantity[]" id="quantity" class="form-control"
                                                    value="">
                                            </td>
                                            <td>
                                                <input type="text" name="unit[]" id="unit" class="form-control"
                                                    value="">
                                            </td>
                                            <td>
                                                <input type="text" name="equipment_remarks[]" id="equipment_remarks"
                                                    class="form-control" value="">
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-danger removeEquipmentRow"><i
                                                        class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class="text-center">
                        <h5> <span> &#10070; </span> Link Information <span>&#10070;</span> </h5>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <select name="link_type" id="link_type" class="form-control">
                                    <option value="">Select Type</option>
                                    <option value="Primary">Primary</option>
                                    <option value="Secondary">Secondary</option>
                                    <option value="Tertiary">Tertiary</option>
                                </select>
                                <label for="type">Type <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <select name="option" id="option" class="form-control">
                                    <option value="">Select Option</option>
                                    <option value="Option 1">Option 1</option>
                                    <option value="Option 2">Option 2</option>
                                    <option value="Option 3">Option 3
                                    </option>
                                </select>
                                <label for="type">Option <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="existing_capacity" id="existing_capacity"
                                    class="form-control" value="" required>
                                <label for="type">Existing Capacity</label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="new_capacity" id="new_capacity" class="form-control"
                                    value="" required>
                                <label for="type">New Capacity</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <hr />
                            <h5 class="text-center">Survey Information</h5>
                            <hr />
                            <table class="table custom_table table-bordered" style="font-size: 12px;">
                                <tr>
                                    <th>Link Vendor</th>
                                    <td id="link_vendor" style="width:30%">
                                    </td>
                                    <input type="hidden" id="client_id" name="client_id"
                                        value="{{ $lead_generation->client_id }}">
                                    <th>Connecting POP Running Vendor</th>
                                    <td id="running_vendor_pop" style="width:30%"></td>
                                </tr>
                                <tr>
                                    <th>Link Availability Status</th>
                                    <td id="availability_status" style="width:30%"></td>
                                    <th>Connecting POP Running Vendor Capacity</th>
                                    <td id="running_vendor_capacity" style="width:30%"></td>
                                </tr>
                                <tr>
                                    <th>Link Connectivity POP</th>
                                    <td id="link_connecting_pop" style="width:30%"></td>
                                    <th>Zone Area Running NTTN Vendor</th>
                                    <td id="nttn_vendor_zone" style="width:30%"></td>
                                </tr>
                                <tr>
                                    <th>Last Mile Connectivity Method</th>
                                    <td id="last_mile_connectivity_method" style="width:30%"></td>
                                    <th>Zone Area Running NTTN BW</th>
                                    <td id="running_nttn_bw" style="width:30%"></td>
                                </tr>
                                <tr>
                                    <th>Last Connectivity Point Lat/Lon</th>
                                    <td id="connectivity_lat_long" style="width:30%"></td>
                                    <th>Connectivity Route</th>
                                    <td id="connectivity_route" style="width:30%"></td>
                                </tr>
                            </table>
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
                                                Demo Material
                                            </td>
                                            <td>
                                                PCS
                                            </td>
                                            <td>
                                                10
                                            </td>
                                        </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="client_no" name="client_no" value="{{ $lead_generation->client_no }}">
                    <input type="hidden" id="fr_no" name="fr_no"
                        value="{{ $feasibilityRequirementDetail->fr_no }}">

                    <button
                        class="py-2 btn btn-success float-right">{{ !empty($connectivity_requirement->id) ? 'Update' : 'Save' }}</button>
                </div>
            </div>
            {!! Form::close() !!}

        @endsection

        @section('script')
            <script>
                $('#addEquipmentRow').on('click', function() {
                    addEquipmentRow();
                });

                function addEquipmentRow() {
                    $('.equipment_row').first().clone().appendTo('#equipment_body');
                    $('.equipment_row').last().find('input').val('');
                    $('.equipment_row').last().find('select').val('');
                };

                $(document).on('click', '.removeEquipmentRow', function() {
                    let count = $('.equipment_row').length;
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

                $('#date').datepicker({
                    format: "dd-mm-yyyy",
                    autoclose: true,
                    todayHighlight: true,
                    showOtherMonths: true
                }).datepicker("setDate", new Date());

                $('#option').on('change', function() {
                    var option = $('#option').val();
                    var link_type = $('#link_type').val();
                    let client_id = $('#client_no').val();
                    let fr_no = $('#fr_no').val();
                    $.ajax({
                        url: "{{ route('get-survey-details') }}",
                        data: {
                            option: option,
                            link_type: link_type,
                            client_id: client_id,
                            fr_no: fr_no,
                        },
                        success: function(data) {
                            $('#link_vendor').html(data.vendor);
                            $('#availability_status').html(data.status);
                            $('#link_connecting_pop').html(data.bts_pop_ldp);
                            $('#last_mile_connectivity_method').html(data.method);
                            $('#connectivity_lat_long').html(data.gps);

                            $('#distance').val(data.distance);
                            $('#gps').val(data.gps);
                            $('#connectivity_point').val(data.bts_pop_ldp)
                        }
                    });

                });
            </script>
        @endsection
