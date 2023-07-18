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
                                    <td>{{ $plan->lead_generation->client_name }}</td>
                                    <th>Address</th>
                                    <td>{{ $plan->lead_generation->address }}</td>
                                </tr>
                                <tr>
                                    <th>Division</th>
                                    <td>{{ $plan->lead_generation->division->name ?? '' }}</td>
                                    <th>District</th>
                                    <td>{{ $plan->lead_generation->district->name ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th>Thana</th>
                                    <td>{{ $plan->lead_generation->thana->name ?? '' }}</td>
                                    <th>Landmark</th>
                                    <td>{{ $plan->lead_generation->landmark }}</td>
                                </tr>
                                <tr>
                                    <th>Lat-Long</th>
                                    <td>{{ $plan->lead_generation->lat_long }}</td>
                                    <th>Contact Person</th>
                                    <td>{{ $plan->lead_generation->contact_person }}</td>
                                </tr>
                                <tr>
                                    <th>Contact No</th>
                                    <td>{{ $plan->lead_generation->contact_no }}</td>
                                    <th>Email</th>
                                    <td>{{ $plan->lead_generation->email }}</td>
                                </tr>
                                <tr>
                                    <th>Website</th>
                                    <td>{{ $plan->lead_generation->website }}</td>
                                    <th>Document</th>
                                    <td>
                                        @if ($plan->lead_generation->document)
                                            <a href="{{ asset('uploads/lead_generation/' . $plan->lead_generation->document) }}"
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
                        <div class="md-col-5 col-5">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th colspan="5">Service Plan for
                                                {{ $plan->feasibilityRequirementDetail->connectivity_point }}</th>
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
                                        @foreach ($plan->servicePlans as $service_plan)
                                            <tr class="particular_row">
                                                <td style="width:30%">
                                                    <input type="hidden" name="detail_id[]" id="detail_id"
                                                        class="form-control form-control-sm"
                                                        value="{{ $service_plan->id ?? '' }}">
                                                    <span
                                                        class="form-control form-control-sm">{{ $service_plan->product->name ?? '' }}</span>

                                                </td>
                                                <td>
                                                    <span
                                                        class="form-control form-control-sm">{{ $service_plan->capacity ?? '' }}</span>
                                                </td>
                                                <td>
                                                    <input type="text" name="plan[]" id="plan"
                                                        class="form-control form-control-sm"
                                                        value="{{ $service_plan->plan ?? '' }}">
                                                </td>
                                                <td style="width:30%">
                                                    <span
                                                        class="form-control form-control-sm">{{ $service_plan->remarks ?? '' }}</span>
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
                        <div class="md-col-7 col-7">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th colspan="7">Equipment Plan for product</th>
                                        </tr>
                                        <tr>
                                            <th>Equipment Name</th>
                                            <th>Quantity</th>
                                            <th>Unit</th>
                                            <th>Brand</th>
                                            <th>Model</th>
                                            <th>Remarks</th>
                                            <th>
                                                <button type="button" class="btn btn-sm btn-success"
                                                    id="addEquipmentRow"><i class="fas fa-plus"></i></button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="equipment_body">
                                        @foreach ($plan->equipmentPlans as $equipment_plan)
                                            <tr class="equipment_row">
                                                <td>
                                                    <select name="equipment_id[]" id="equipment_id"
                                                        class="form-control form-control-sm equipment_id">
                                                        <option value="">Select Equipment</option>
                                                        @foreach ($materials as $material)
                                                            <option value="{{ $material->id }}"
                                                                {{ $equipment_plan->equipment_id == $material->id ? 'selected' : '' }}>
                                                                {{ $material->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="quantity[]" id="quantity"
                                                        class="form-control form-control-sm"
                                                        value="{{ $equipment_plan->quantity ?? '' }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="unit[]" id="unit"
                                                        class="form-control form-control-sm unit"
                                                        value="{{ $equipment_plan->unit ?? '' }}">
                                                </td>
                                                <td>
                                                    <select name="brand_id[]" id="brand_id"
                                                        class="form-control form-control-sm brand_id">
                                                        <option value="">Select Brand</option>
                                                        @foreach ($brands as $brand)
                                                            <option value="{{ $brand->id }}"
                                                                {{ $equipment_plan->brand_id == $brand->id ? 'selected' : '' }}>
                                                                {{ $brand->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="model[]" id="model"
                                                        class="form-control form-control-sm model"
                                                        value="{{ $equipment_plan->model ?? '' }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="equipment_remarks[]" id="equipment_remarks"
                                                        class="form-control form-control-sm equipment_remarks"
                                                        value="{{ $equipment_plan->remarks ?? '' }}">
                                                </td>
                                                <td>
                                                    <button type="button"
                                                        class="btn btn-sm btn-danger removeEquipmentRow"><i
                                                            class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <input type="hidden" id="client_id" name="client_id"
                            value="{{ $plan->lead_generation->client_no }}">
                        <input type="hidden" name="total_key" id="total_key"
                            value="{{ $plan->equipmentPlans->count() }}">
                        <div class="col-md-11 text-center">
                            <h5> <span> &#10070; </span> Link Information <span>&#10070;</span> </h5>
                        </div>
                        <div class="col-md-1" style="float: right">
                            <button type="button" class="btn btn-sm btn-success text-left" id="addLinkRow"><i
                                    class="fas fa-plus"></i></button>
                        </div>
                    </div>
                    <hr />
                    <div id="link_container">
                        @foreach ($plan->planLinks as $key => $plan_link)
                            @php $total_key = $key + 1; @endphp
                            <div class="main_link">
                                <h5 class="text-center mb-2">Link <span class="link_no">{{ $total_key }}</span></h5>
                                <hr/>
                                <div class="row">
                                    <div class="md-col-3 col-3">
                                        <div class="form-item">
                                            <select name="link_type_{{ $total_key }}"
                                                class="form-control form-control-sm link_type">
                                                <option value="">Select Type</option>
                                                <option value="Primary"
                                                    {{ $plan_link->link_type == 'Primary' ? 'selected' : '' }}>Primary
                                                </option>
                                                <option value="Secondary"
                                                    {{ $plan_link->link_type == 'Secondary' ? 'selected' : '' }}>
                                                    Secondary</option>
                                                <option value="Tertiary"
                                                    {{ $plan_link->link_type == 'Tertiary' ? 'selected' : '' }}>
                                                    Tertiary</option>
                                            </select>
                                            <label for="type">Type <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="md-col-3 col-3">
                                        <div class="form-item">
                                            <select name="option_{{ $total_key }}" id="option"
                                                class="form-control form-control-sm option"
                                                onchange="optionChange(event)">
                                                <option value="">Select Option</option>
                                                <option value="Option 1"
                                                    {{ $plan_link->option == 'Option 1' ? 'selected' : '' }}>
                                                    Option 1</option>
                                                <option value="Option 2"
                                                    {{ $plan_link->option == 'Option 2' ? 'selected' : '' }}>
                                                    Option 2</option>
                                                <option value="Option 3"
                                                    {{ $plan_link->option == 'Option 3' ? 'selected' : '' }}>
                                                    Option 3</option>
                                            </select>
                                            <label for="type">Option <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-3 col-md-3">
                                        <div class="form-item">
                                            <select name="existing_infrastructure_{{ $total_key }}"
                                                id="existing_infrastructure"
                                                class="form-control form-control-sm existing_infrastructure">
                                                <option value="">Select Status</option>
                                                <option value="Existing"
                                                    {{ $plan_link->existing_infrastructure == 'Existing' ? 'selected' : '' }}>
                                                    Existing</option>
                                                <option value="New"
                                                    {{ $plan_link->existing_infrastructure == 'New' ? 'selected' : '' }}>
                                                    New</option>
                                            </select>
                                            <label for="type">Link Status</label>
                                        </div>
                                    </div>
                                    <div class="md-col-3 col-3">
                                        <div class="form-item">
                                            <input type="text"
                                                name="existing_transmission_capacity_{{ $total_key }}"
                                                id="existing_transmission_capacity"
                                                class="form-control form-control-sm existing_transmission_capacity"
                                                value="{{ $plan_link->existing_transmission_capacity ?? '' }}">
                                            <label for="type">Existing Transmission Capacity</label>
                                        </div>
                                    </div>

                                    <div class="md-col-3 col-3 mt-3">
                                        <div class="form-item">
                                            <input type="text" name="increase_capacity_{{ $total_key }}"
                                                id="increase_capacity"
                                                class="form-control form-control-sm increase_capacity"
                                                value="{{ $plan_link->increase_capacity ?? '' }}">
                                            <label for="type">Increase Capacity</label>
                                        </div>
                                    </div>

                                    <div class="md-col-3 col-3  mt-3">
                                        <div class="form-item">
                                            <select name="link_availability_status_{{ $total_key }}"
                                                id="link_availability_status"
                                                class="form-control form-control-sm link_availability_status">
                                                <option value="">Select Status</option>
                                                <option value="Available"
                                                    {{ $plan_link->link_availability_status == 'Available' ? 'selected' : '' }}>
                                                    Available</option>
                                                <option value="Not Available"
                                                    {{ $plan_link->link_availability_status == 'Not Available' ? 'selected' : '' }}>
                                                    Not Available</option>
                                            </select>
                                            <label for="type">New Transmission Link</label>
                                        </div>
                                    </div>

                                    <div class="md-col-3 col-3  mt-3">
                                        <div class="form-item">
                                            <input type="text" name="new_transmission_capacity_{{ $total_key }}"
                                                id="new_transmission_capacity" class="form-control form-control-sm"
                                                value="{{ $plan_link->new_transmission_capacity ?? '' }}">
                                            <label for="type">New Transmission Capacity</label>
                                        </div>
                                    </div>

                                    <div class="md-col-3 col-3  mt-3">
                                        <div class="form-item">
                                            <input type="text" name="link_remarks_{{ $total_key }}"
                                                id="link_remarks" class="form-control form-control-sm"
                                                value="{{ $plan_link->link_remarks ?? '' }}">
                                            <label for="type">Remarks</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <hr />
                                        <h5 class="text-center">Survey Information</h5>
                                        <hr />
                                        <table class="table custom_table table-bordered surveyTable"
                                            style="font-size: 12px;">
                                            <tr>
                                                <th>Link Vendor</th>
                                                <td class="link_vendor" style="width:30%">
                                                    <input type="text" name="link_vendor_1" id="link_vendor"
                                                        class="form-control form-control-sm link_vendor_1" value=""
                                                        style="height: 25px !important">
                                                    <input type="hidden" name="link_vender_id_1" id="link_vendor_id"
                                                        class="form-control form-control-sm link_vender_id_1"
                                                        value="">
                                                </td>
                                                <th>Connecting POP Running Vendor</th>
                                                <td class="running_vendor_pop" style="width:30%"></td>
                                            </tr>
                                            <tr>
                                                <th>Link Availability Status</th>
                                                <td class="availability_status" style="width:30%">
                                                    <input type="text" name="availability_status_1"
                                                        id="availability_status"
                                                        class="form-control form-control-sm availability_status_1"
                                                        style="height: 25px !important"
                                                        value="{{ $plan_link->finalSurveyDetails->availability_status ?? '' }}">
                                                </td>
                                                <th>Connecting POP Running Vendor Capacity</th>
                                                <td class="running_vendor_capacity" style="width:30%"></td>
                                            </tr>
                                            <tr>
                                                <th>Link Connectivity POP</th>
                                                <td class="link_connecting_pop" style="width:30%">
                                                    <input type="text" name="link_connecting_pop_1"
                                                        id="link_connecting_pop"
                                                        class="form-control form-control-sm link_connecting_pop_1"
                                                        style="height: 25px !important"
                                                        value="{{ $plan_link->finalSurveyDetails->pop->name ?? '' }}">
                                                    <input type="hidden" name="link_connecting_pop_id_1"
                                                        id="link_connecting_pop_id" class="link_connecting_pop_id_1"
                                                        value="{{ $plan_link->finalSurveyDetails->pop_id ?? '' }}">
                                                </td>
                                                <th>Zone Area Running NTTN Vendor</th>
                                                <td class="nttn_vendor_zone" style="width:30%"></td>
                                            </tr>
                                            <tr>
                                                <th>Last Mile Connectivity Method</th>
                                                <td class="last_mile_connectivity_method" style="width:30%">
                                                    <input type="text" name="last_mile_connectivity_method_1"
                                                        id="last_mile_connectivity_method"
                                                        class="form-control form-control-sm last_mile_connectivity_method_1"
                                                        style="height: 25px !important"
                                                        value="{{ $plan_link->finalSurveyDetails->method }}">
                                                </td>
                                                <th>Zone Area Running NTTN BW</th>
                                                <td class="running_nttn_bw" style="width:30%"></td>
                                            </tr>
                                            <tr>
                                                <th>Last Connectivity Point Latitute</th>
                                                <td class="connectivity_lat_long" style="width:30%">
                                                    <input type="text" name="connectivity_lat_1"
                                                        id="connectivity_lat_long"
                                                        class="form-control form-control-sm connectivity_lat_1"
                                                        style="height: 25px !important"
                                                        value="{{ $plan_link->finalSurveyDetails->lat }}">
                                                </td>
                                                <th>Connectivity Route</th>
                                                <td class="connectivity_route" style="width:30%"></td>
                                            </tr>
                                            <tr>
                                                <th>Last Connectivity Point Longitute</th>
                                                <td class="connectivity_lat_long" style="width:30%">
                                                    <input type="text" name="connectivity_long_1"
                                                        id="connectivity_lat_long"
                                                        class="form-control form-control-sm connectivity_long_1"
                                                        style="height: 25px !important"
                                                        value="{{ $plan_link->finalSurveyDetails->long }}">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <hr />
                                        <h5> <span> &#10070; </span> Link Equipment <span>&#10070;</span> </h5>
                                    </div>
                                    <hr />
                                    <div class="table-responsive">
                                        <table class="table table-bordered" style="font-size: 12px;">
                                            <thead>
                                                <tr>
                                                    <th>Equipment Name</th>
                                                    <th>Quantity</th>
                                                    <th>Unit</th>
                                                    <th>Brand</th>
                                                    <th>Model</th>
                                                    <th>Description</th>
                                                    <th>Remarks</th>
                                                    <th>
                                                        <button type="button"
                                                            class="btn btn-success btn-sm addLinkEquipmentRow"
                                                            onclick="addLinkEquipmentRow(this)">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="link_equipment_table">
                                                @foreach ($plan_link->PlanLinkEquipments as $plan_equipment)
                                                    <tr>
                                                        <td>
                                                            <select name="material_id_{{ $total_key }}[]"
                                                                id="material_id"
                                                                class="form-control form-control-sm link_material_id">
                                                                <option value="">Select Equipment</option>
                                                                @foreach ($materials as $material)
                                                                    <option value="{{ $material->id }}"
                                                                        {{ $plan_equipment->material_id == $material->id ? 'selected' : '' }}>
                                                                        {{ $material->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="quantity_{{ $total_key }}[]"
                                                                id="quantity"
                                                                class="form-control form-control-sm link_quantity"
                                                                value="{{ $plan_equipment->quantity ?? '' }}">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="unit_{{ $total_key }}[]"
                                                                id="unit"
                                                                class="form-control form-control-sm link_unit"
                                                                value="{{ $plan_equipment->unit ?? '' }}">
                                                        </td>
                                                        <td>
                                                            <select name="brand_id_{{ $total_key }}[]" id="brand"
                                                                class="form-control form-control-sm link_brand">
                                                                <option value="">Select Brand</option>
                                                                @foreach ($brands as $brand)
                                                                    <option value="{{ $brand->id }}"
                                                                        {{ $plan_equipment->brand_id == $brand->id ? 'selected' : '' }}>
                                                                        {{ $brand->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="model_{{ $total_key }}[]"
                                                                id="model"
                                                                class="form-control form-control-sm link_model"
                                                                value="{{ $plan_equipment->model ?? '' }}">
                                                        </td>
                                                        <td>
                                                            <input type="text"
                                                                name="description_{{ $total_key }}[]" id="description"
                                                                class="form-control form-control-sm link_description"
                                                                value="{{ $plan_equipment->description ?? '' }}">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="remarks_{{ $total_key }}[]"
                                                                id="remarks"
                                                                class="form-control form-control-sm link_remarks"
                                                                value="{{ $plan_equipment->remarks ?? '' }}">
                                                        </td>
                                                        <td>
                                                            <button type="button"
                                                                class="btn btn-danger btn-sm removeLinkEquipmentRow"
                                                                onclick="removeLinkEquipmentRow(this)">
                                                                <i class="fas fa-minus"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <hr />
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{-- create a responsive table --}}
                    <div class="row">
                        <div class="col-md-12">
                            <hr />
                            <div class="text-center">
                                <h5> <span> &#10070; </span> Plan Preview <span>&#10070;</span> </h5>
                            </div>
                            <hr />
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
                    </div>
                    <input type="hidden" id="client_no" name="client_no"
                        value="{{ $plan->lead_generation->client_no }}">
                    <input type="hidden" id="fr_no" name="fr_no" value="{{ $plan->fr_no }}">
                </div>
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

            function optionChange(event) {
                let option = $(event.target).val();
                var link_type = $(event.target).closest('.main_link').find('.link_type').val();
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
                        console.log(data);
                        $(event.target).closest('.main_link').find('input[name^="link_vendor_"]').val(data.vendor
                            .name);
                        $(event.target).closest('.main_link').find('input[name^="link_vendor_id_"]').val(data.vendor
                            .id);
                        $(event.target).closest('.main_link').find('input[name^="availability_status_"]').val(data
                            .status);
                        $(event.target).closest('.main_link').find('input[name^="link_connecting_pop_"]').val(data
                            .pop.name);
                        $(event.target).closest('.main_link').find('input[name^="link_connecting_pop_id_"]').val(
                            data.pop
                            .id);
                        $(event.target).closest('.main_link').find('input[name^="last_mile_connectivity_method_"]')
                            .val(data
                                .method);
                        $(event.target).closest('.main_link').find('input[name^="connectivity_long_"]').val(data
                            .long);
                        $(event.target).closest('.main_link').find('input[name^="connectivity_lat_"]').val(data
                            .lat);
                        $(event.target).closest('.main_link').find('input[name^="distance_"]').val(data.distance);
                        $(event.target).closest('.main_link').find('input[name^="gps_"]').val(data.gps);
                        $(event.target).closest('.main_link').find('input[name^="connectivity_point_"]').val(data
                            .bts_pop_ldp)
                        // $(event.target).closest('.main_link').find('.link_vendor').html(data.vendor);
                        // $(event.target).closest('.main_link').find('.availability_status').html(data.status);
                        // $(event.target).closest('.main_link').find('.link_connecting_pop').html(data.bts_pop_ldp);
                        // $(event.target).closest('.main_link').find('.last_mile_connectivity_method').html(data
                        //     .method);
                        // $(event.target).closest('.main_link').find('.connectivity_lat_long').html(data.gps);
                        // $(event.target).closest('.main_link').find('.distance').val(data.distance);
                        // $(event.target).closest('.main_link').find('.gps').val(data.gps);
                        // $(event.target).closest('.main_link').find('.connectivity_point').val(data.bts_pop_ldp)
                    }
                });
            }

            function addLinkEquipmentRow(event) {
                var $table = $(event).closest('.table-bordered');
                var $clone = $table.find('tbody tr:first').clone();
                $clone.find('input').val('');
                $clone.find('select').val('');
                $table.find('tbody').append($clone);
            }

            function removeLinkEquipmentRow(event) {
                var $table = $(event).closest('.table-bordered');
                var $tr = $table.find('tbody tr');
                if ($tr.length > 1) {
                    $(event).closest('tr').remove();
                }
            }
            $('#addLinkRow').on('click', function() {
                addLinkRow();
            });

            function addLinkRow() {
                var clonedRow = $('.main_link').first().clone();
                var count_row = $('.main_link').length;
                var link_no = parseInt(count_row) + 1;
                $('#total_key').val(link_no);

                clonedRow.find('input, select').val('').attr('name', function(index, name) {
                    var underscoreIndex = name.lastIndexOf('_');
                    if (underscoreIndex !== -1) {
                        var baseName = name.substring(0, underscoreIndex);
                        var fieldName = name.substring(underscoreIndex + 1);
                        if (fieldName.includes('[]')) {
                            return baseName + '_' + link_no + '[]';
                        } else {
                            return baseName + '_' + link_no;
                        }
                    }
                });
                clonedRow.find('#addLinkEquipmentRow').attr('id', 'addLinkEquipmentRow_' + link_no);
                clonedRow.find('#removeLinkEquipmentRow').attr('id', 'removeLinkEquipmentRow_' + link_no);
                clonedRow.find('.link_no').html(link_no);
                clonedRow.appendTo('#link_container').find('.main_link').last();
                var $equipmentRow = clonedRow.find('.link_equipment_table').children('tr').length;
                console.log(
                    $equipmentRow);
                if ($equipmentRow > 1) {
                    clonedRow.find('.link_equipment_table tr').not(':first').remove();
                }
            }

            $(document).on('change', '.equipment_id', function() {
                var equipment_id = $(this).val();
                var equiments = {!! json_encode($materials) !!};
                var find_equipment = equiments.find(x => x.id == equipment_id);
                console.log(find_equipment);
                $(this).closest('tr').find('.unit').val(find_equipment.unit);
            });

            $(document).on('change', '.link_material_id', function() {
                var material_id = $(this).val();
                var materials = {!! json_encode($materials) !!};
                var find_material = materials.find(x => x.id == material_id);
                console.log(find_material);
                $(this).closest('tr').find('.link_unit').val(find_material.unit);
            });
        </script>
    @endsection
