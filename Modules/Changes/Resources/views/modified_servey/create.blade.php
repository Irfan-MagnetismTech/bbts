@extends('layouts.backend-layout')
@section('title', 'Survey Modification')

@php
    $is_old = old() ? true : false;
    $form_heading = !empty($requirement_modification->id) ? 'Update' : 'Add';
    $form_url = !empty($requirement_modification->id) ? route('survey-modification.update', $requirement_modification->id) : route('survey-modification.store');
    $form_method = !empty($requirement_modification->id) ? 'PUT' : 'POST';

    if (!empty($survey)) { 
        $selected_vendors = $survey->surveyDetails->pluck('vendor')->toArray();
     
    } 
    $selected_vendors = $is_old ? old('vendor') : $selected_vendors ?? [];
    $methods = $is_old ? old('method') : $methods ?? [];
@endphp

@section('breadcrumb-title')
    {{ ucfirst($form_heading) }} Survey Modification
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
                                <input type="text" name="client_no" id="client_no" class="form-control client_no"
                                    value="{{ $connectivity_requirement->client_no }}">
                                <input type="hidden" name="connectivity_requirement_id" id="connectivity_requirement_id"
                                    class="form-control connectivity_requirement_id"
                                    value="{{ $connectivity_requirement->id }}">
                                <input type="hidden" name="feasibility_requirement_details_id"
                                    id="feasibility_requirement_details_id"
                                    class="form-control feasibility_requirement_details_id"
                                    value="{{ $connectivity_requirement->FeasibilityRequirementDetail->id }}">
                                <label for="client_id">Client ID <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="client_name" id="client_name" class="form-control client_name"
                                    readonly value="{{ $connectivity_requirement->client->client_name }}">
                                <label for="client_name">Client Name <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="name_of_the_link" id="name_of_the_link"
                                    class="form-control name_of_the_link"
                                    value="{{ $connectivity_requirement->FeasibilityRequirementDetail->connectivity_point }}">
                                <label for="name_of_the_link">Name Of The Link <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="date" id="date" class="form-control date"
                                    value="">
                                <label for="date">Date<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="mq_no" id="mq_no" class="form-control"
                                    value="{{ $connectivity_requirement->FeasibilityRequirementDetail->feasibilityRequirement->mq_no }}">
                                <label for="mq_no">MQ ID<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="fr_no" id="fr_no" class="form-control fr_no"
                                    value="{{ $connectivity_requirement->fr_no }}" readonly>
                                <label for="fr_no">FR ID<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="client_gps" id="client_gps" class="form-control client_gps"
                                    value="{{ $connectivity_requirement->FeasibilityRequirementDetail->lat }} : {{ $connectivity_requirement->FeasibilityRequirementDetail->long }}">
                                <label for="client_gps">Client GPS<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="file" name="requirement" id="requirement" class="form-control requirement"
                                    value="">
                                <label for="requirement">Requirement<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="division" id="division" class="form-control division"
                                    value="{{ $connectivity_requirement->FeasibilityRequirementDetail->division->name }}">
                                <label for="division">Division<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="district" id="district" class="form-control district"
                                    value="{{ $connectivity_requirement->FeasibilityRequirementDetail->district->name }}"
                                    readonly>
                                <label for="district">District<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="thana" id="thana" class="form-control thana"
                                    value="{{ $connectivity_requirement->FeasibilityRequirementDetail->thana->name }}">
                                <label for="thana">Thana<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="location" id="location" class="form-control location"
                                    value="{{ $connectivity_requirement->FeasibilityRequirementDetail->location }}">
                                <label for="location">Location<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="file" name="survey_attached" id="survey_attached"
                                    class="form-control survey_attached" value="">
                                <label for="survey_attached">Survey Attached<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="contact_name" id="contact_name"
                                    class="form-control contact_name"
                                    value="{{ $connectivity_requirement->FeasibilityRequirementDetail->contact_name }}"
                                    readonly>
                                <label for="contact_name">Contact Name <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="designation" id="designation"
                                    class="form-control designation"
                                    value="{{ $connectivity_requirement->FeasibilityRequirementDetail->contact_designation }}">
                                <label for="designation">Designation <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="contact_no" id="contact_no" class="form-control contact_no"
                                    value="{{ $connectivity_requirement->FeasibilityRequirementDetail->contact_number }}">
                                <label for="contact_no">Contact No<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="survey_remarks" id="survey_remarks" class="form-control"
                                    value="">
                                <label for="survey_remarks">Remarks <span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12">
                            @php
                                $checkbox = ['Method Change', 'Redundant Link', 'Shifting'];
                            @endphp
                            @if ($connectivity_requirement->change_type != null)
                                @foreach (json_decode($connectivity_requirement->change_type) as $element)
                                    @if (in_array($element, $checkbox))
                                        <div class="label-main">
                                            <label class="label label-primary badge-md"
                                                style="background:linear-gradient(90deg,#BFF098 , #6FD6FF);color:rgba(0, 0, 0, 0.641)!important;font-weight:500">{{ $element }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
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
                                        @foreach ($connectivity_requirement->connectivityRequirementDetails as $key => $value)
                                            <tr>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="detail_link_type[]"
                                                            class="form-control text-center detail_link_type" readonly
                                                            value="{{ $value->link_type }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="detail_method[]"
                                                            class="form-control text-right detail_method" readonly
                                                            value="{{ $value->method }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="detail_capacity[]"
                                                            class="form-control text-center detail_capacity" readonly
                                                            value="{{ $value->connectivity_capacity }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="detail_sla[]"
                                                            class="form-control text-right detail_sla" readonly
                                                            value="{{ $value->sla }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="detail_vendor_name[]"
                                                            class="form-control text-right detail_vendor_name" readonly
                                                            value="{{ $value->vendor->name ?? '' }}">
                                                        <input type="hidden" name="detail_vendor_id[]"
                                                            class="form-control text-right detail_vendor_id" readonly
                                                            value="{{ $value->vendor_id ?? '' }}">
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
                                        @foreach ($grouped_qty as $key => $value)
                                            <tr>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="product_name[]"
                                                            class="form-control text-center product_name" readonly
                                                            value="{{ isset($grouped_current_qty[$key]) ? $grouped_current_qty[$key]->first()->product->name : $grouped_previous_qty[$key]->first()?->product?->name ?? '' }}">
                                                        <input type="hidden" name="product_id[]"
                                                            class="form-control text-center product_id" readonly
                                                            value="{{ isset($grouped_current_qty[$key]) ? $grouped_current_qty[$key]->first()->product_id : $grouped_previous_qty[$key]->first()?->product_id ?? '' }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="prev_qty[]"
                                                            class="form-control text-right prev_qty" readonly
                                                            value="{{ isset($grouped_previous_qty[$key]) ? $grouped_previous_qty[$key]->first()->capacity : 0 }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="req_qty[]"
                                                            class="form-control text-right req_qty" readonly
                                                            value="{{ isset($grouped_current_qty[$key]) ? $grouped_current_qty[$key]->first()->capacity : 0 }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="unit[]"
                                                            class="form-control text-center unit" readonly
                                                            value="{{ $value->first()?->product?->unit ?? '' }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="remarks[]"
                                                            class="form-control text-right remarks" readonly
                                                            value="">
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
                                <th>Method Change</th>
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
                                @foreach ($existingConnections as $key => $value)
                                    <tr class="product_existing_row">
                                        @if (
                                            $connectivity_requirement->change_type != null &&
                                                in_array('Method Change', json_decode($connectivity_requirement->change_type)) &&
                                                in_Array(
                                                    $value->link_type,
                                                    $connectivity_requirement->connectivityRequirementDetails->pluck('link_type')->toArray()))
                                            <td>
                                                <input type="checkbox" class="checkbox" value="method_change"
                                                    name="checked[{{ $key }}]">
                                            </td>
                                        @else
                                            <td></td>
                                        @endif
                                        <td>
                                            <div class="input-group input-group-sm input-group-primary">
                                                <input type="text" name="existing_link_type[]"
                                                    class="form-control text-center existing_link_type" readonly
                                                    value="{{ $value->link_type }}">
                                                <input type="hidden" name="existing_bbts_link_id[]"
                                                    class="form-control text-center existing_bbts_link_id" readonly
                                                    value="{{ $value->bbts_link_id }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm input-group-primary">
                                                <input type="text" name="link_status[]"
                                                    class="form-control text-right link_status" readonly value="Existing">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm input-group-primary"> 
                                                <input type="text" name="existing_vendor_name[]"
                                                    class="form-control text-center existing_vendor_name" readonly
                                                    value="{{ $value->connectivityLink->vendor->name ?? '' }}">
                                                <input type="hidden" name="existing_vendor_id[]"
                                                    class="form-control text-center existing_vendor_id"
                                                    value="{{ $value->connectivityLink->vendorid ?? '' }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm input-group-primary">
                                                <input type="text" name="existing_method[]"
                                                    class="form-control text-right existing_method" readonly
                                                    value="{{ $value->method }}">
                                                <input type="hidden" name="existing_bbts_link_id[]"
                                                    class="form-control existing_bbts_link_id" readonly
                                                    value="{{ $value->bbts_link_id }}">
                                                <input type="hidden" name="existing_fr_no[]"
                                                    class="form-control existing_fr_no" readonly
                                                    value="{{ $value->physicalConnectivity->fr_no }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm input-group-primary">
                                                <input type="text" name="existing_ldp[]"
                                                    class="form-control text-right existing_ldp" readonly
                                                    value="{{ $value->ldp }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm input-group-primary">
                                                <input type="text" name="existing_gps[]"
                                                    class="form-control text-right existing_gps" readonly
                                                    value="{{ $value->connectivityLink->gps ?? '' }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm input-group-primary">
                                                <input type="text" name="existing_distance[]"
                                                    class="form-control text-right existing_distance" readonly
                                                    value="{{ $value->physicalConnectivity->planning->finalSurveyDetail->distance ?? 0 }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm input-group-primary">
                                                <input type="text" name="existing_current_capacity[]"
                                                    class="form-control text-center existing_current_capacity" readonly
                                                    value="{{ $value->physicalConnectivity->planning->finalSurveyDetail->current_capacity ?? 0 }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm input-group-primary">
                                                <input type="text" name="existing_remarks[]"
                                                    class="form-control text-right existing_remarks" readonly
                                                    value="">
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="table-responsive">
                        <div class="tableHeading">
                            <h5> <span>
                                    &#10070;</span> New Requirement Survey <span>&#10070;</span> </h5>
                        </div>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <th>Link Type</th>
                                <th>Option</th>
                                <th>Existing / New</th>
                                <th>Method</th>
                                <th>Vendor</th>
                                <th>POP</th>
                                <th>LDP</th>
                                <th>Lat</th>
                                <th>Long</th>
                                <th>Distance</th>
                                <th>Current Capacity</th>
                                <th>Remarks</th>
                            </thead>
                            <tbody class="requirementBody">
                                @foreach ($connectivity_requirement->connectivityRequirementDetails as $key => $value)
                                    @php
                                        $type = ['Primary', 'Secondary', 'Tertiary'];
                                        $option_type = ['Option 1', 'Option 2', 'Option 3'];
                                    @endphp
                                    <tr class="requirement_details_row">
                                        @if (!in_Array($value->link_type, $existingConnections->pluck('link_type')->toArray()))
                                            <td>
                                                <select name="new_link_type[]" class="form-control new_link_type">
                                                    @foreach ($type as $key => $val)
                                                        <option value="{{ $val }}" @selected($val == $value->link_type)>
                                                            {{ $val }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="new_option[]" class="form-control new_option">
                                                    @foreach ($option_type as $key => $val)
                                                        <option value="{{ $val }}">{{ $val }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <select name="status[]" id="status" class="form-control">
                                                        <option value="">Select Status</option>
                                                        <option value="Existing">Existing</option>
                                                        <option value="New">New</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <select name="method[]" id="method" class="form-control">
                                                        <option value="">Select Method</option>
                                                        <option value="Fiber">Fiber</option>
                                                        <option value="Radio">Radio</option>
                                                        <option value="GSM">GSM</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                {{-- @dd($selected_vendors); --}}
                                                <div class="input-group input-group-sm input-group-primary"> 
                                                    <select name="vendor[]" id="vendor" class="form-control">
                                                        <option value="">Select Vendor</option>
                                                        @foreach ($vendors as $vendor)
                                                            <option value="{{ $vendor->id }}"
                                                                {{-- {{ $selected_vendors[$key] == $vendor->id ? 'selected' : '' }} --}}
                                                                >
                                                                {{ $vendor->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <select name="pop[]" class="form-control pop" title="">
                                                        <option value="">Select POP</option>
                                                        @foreach ($pops as $pop)
                                                            <option value="{{ $pop->id }}">{{ $pop->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="custom-tooltip">
                                                        {{-- <span class="custom-tooltip-text">Tooltip content</span> --}}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="ldp[]" id="ldp" class="form-control"
                                                    placeholder="LDP">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="new_lat[]"
                                                        class="form-control text-center new_lat" value="">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="new_long[]"
                                                        class="form-control text-center new_long" value="">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="new_distance[]"
                                                        class="form-control text-right new_distance" value="">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="new_current_capacity[]"
                                                        class="form-control text-right new_current_capacity"
                                                        value="{{ $value->connectivity_capacity }}">

                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="new_remarks[]"
                                                        class="form-control text-right new_remarks" value="">
                                                </div>
                                            </td>
                                        @endif
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
                $('.add_requirement_row').on('click', function() {
                    addRequirementRow();
                });
                $(document).on('click', '.remove_requirement_row', function() {
                    $(this).closest('tr').remove();
                });

                function addExistingRow() {
                    $('.product_existing_row').first().clone().appendTo('.existingBody');
                    $('.product_existing_row').last().find('input').val('').attr('readonly', false);
                    $('.product_existing_row').last().find('select').val('').attr('readonly', false);
                };

                function addRequirementRow(bbts_link_id, distance, gps, bts, vendor_id, vendor_name, method, fr_no, link_type,
                    instance) {
                    var adad = `<tr class="requirement_details_row">
                                    <td>
                                        <select name="new_link_type[]" class="form-control new_link_type">
                                            @foreach ($type as $key => $val)
                                                <option value="{{ $val }}">{{ $val }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td> 
                                        <select name="new_option[]" class="form-control new_option">
                                            @foreach ($option_type as $key => $val)
                                                <option value="{{ $val }}">{{ $val }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="new_status[]" class="form-control text-center new_status"  value="Existing">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="new_sla[]"
                                                class="form-control text-right new_sla" value="">
                                        </div>
                                    </td>
                                    <td>
                                        <input type="hidden" name="new_bbts_link_id"
                                                class="form-control text-right new_bbts_link_id" readonly value="${bbts_link_id}">
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="new_method[]"
                                                class="form-control text-right new_method" value="${method}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="new_vendor_name[]"
                                                class="form-control text-right new_vendor_name" value="${vendor_name}">
                                            <input type="hidden" name="new_vendor_id[]"
                                                class="form-control text-right new_vendor_id" value="${vendor_id}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="new_bts[]" class="form-control text-center new_bts" value="${bts}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="new_gps[]" class="form-control text-center new_gps" value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="new_distance[]"
                                                class="form-control text-right new_distance" value="${distance}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="new_remarks[]"
                                                class="form-control text-right new_remarks" value="">
                                        </div>
                                    </td>
                                </tr>`
                    $('.requirementBody').append(adad);
                    appendOption(fr_no, link_type, instance);
                    console.log($(instance).closest('tr').html());
                };


                function appendOption(fr_no, link_type, instance) {
                    $.ajax({
                        url: `changes/get-option-for-survey/${fr_no}`,
                        type: "get",
                        dataType: "json",
                        data: {
                            fr_no
                        },
                        success: function(data) {
                            if (data.length > 0) {
                                // successcallback(data);
                                console.log(data);
                            } else {
                                // if (failcallback && typeof failcallback === "function") {
                                //     failcallback();
                                // }
                            }
                            return false;
                        },
                    });

                }

                $(document).on('change', '.checkbox', function() {
                    if ($(this).prop("checked") == true) {
                        let existing_bbts_link_id = $(this).closest('tr').find('.existing_bbts_link_id').val();
                        let existing_link_type = $(this).closest('tr').find('.existing_link_type').find(':selected').val();
                        let existing_distance = $(this).closest('tr').find('.existing_distance').val();
                        let existing_bts = $(this).closest('tr').find('.existing_bts').val();
                        let existing_vendor_id = $(this).closest('tr').find('.existing_vendor_id').val();
                        let existing_vendor_name = $(this).closest('tr').find('.existing_vendor_name').val();
                        let existing_fr_no = $(this).closest('tr').find('.existing_fr_no').val();
                        let existing_method = $(this).closest('tr').find('.existing_method').val();
                        // var c = $('.requirement_details_row').each(function(){
                        //    var bbts_id = $(this).find('.new_bbts_link_id').val();
                        // })
                        addRequirementRow(existing_bbts_link_id, existing_distance, existing_gps, existing_bts,
                            existing_vendor_id, existing_vendor_name, existing_method, existing_fr_no,
                            existing_link_type, this);
                    } else {
                        var bbtd_link_id = $(this).closest('tr').find('.existing_bbts_link_id').val();
                        var c = $('.requirement_details_row').each(function(el) {
                            var bbts_id = $(this).find('.new_bbts_link_id').val();
                            if (bbtd_link_id == bbts_id) {
                                $(this).find('.new_bbts_link_id').closest('tr').remove();
                            }
                        })
                    }
                });


                $('#date, #activation_date').datepicker({
                    format: "dd-mm-yyyy",
                    autoclose: true,
                    todayHighlight: true,
                    showOtherMonths: true
                }).datepicker("setDate", new Date());
            </script>
        @endsection
