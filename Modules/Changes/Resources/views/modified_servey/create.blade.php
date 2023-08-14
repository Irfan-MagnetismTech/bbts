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
                            @php
                                $checkbox = ["Method Change","Redundant Link","Shifting"];
                            @endphp
                           @foreach (json_decode($connectivity_requirement->change_type) as $element) 
                                @if (in_array($element, $checkbox)) 
                                <div class="label-main">
                                    <label class="label label-primary badge-md" style="background:linear-gradient(90deg,#BFF098 , #6FD6FF);color:rgba(0, 0, 0, 0.641)!important;font-weight:500">{{$element}}</label>
                                </div>
                                
                                @endif
                           @endforeach
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
                                @if(in_array("Method Change", json_decode($connectivity_requirement->change_type)))
                                        <th>Method Change</th>
                                @endif
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
                                    @if(in_array("Method Change", json_decode($connectivity_requirement->change_type)))
                                        <td>
                                            <input type="checkbox" class="checkbox" value="method_change" name="checked[{{$key}}]">
                                        </td>
                                    @endif
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="product_name" class="form-control text-center"
                                                id="service_name" readonly value="{{$value->link_type}}">
                                            <input type="hidden" name="product_name" class="form-control text-center"
                                                id="service_name" readonly value="{{$value->bbts_link_id}}">
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
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="price"
                                                class="form-control text-right" readonly value="{{$value->ldp}}">
                                        </div>
                                    </td>                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="total_price"
                                                class="form-control text-right" readonly value="{{$value->connectivityLink->gps}}">
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
                                <th>BTS/POP/LDP</th>
                                <th>GPS</th>
                                <th>Distance</th>
                                <th>Current Capacity</th>
                                <th>Remarks</th>
                            </thead>
                            <tbody class="requirementBody">
                                @foreach ($connectivity_requirement->connectivityRequirementDetails as $key => $value )
                               @php
                                   $type = ['Primary','Secondary','Tertiary'];
                                   $option_type = ['Option 1'];
                               @endphp
                                <tr class="requirement_details_row">
                                    @if(!in_Array($value->link_type,$existingConnections->pluck('link_type')->toArray()))
                                    <td>
                                        <select name="" id="" class="form-control link_type">
                                            @foreach ($type as $key=>$val )
                                                <option value="{{$val}}" @selected($val==$value->link_type)>{{$val}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td> 
                                        <select name="" id="" class="form-control option_type">
                                            @foreach ($option_type as $key=>$val )
                                                <option value="{{$val}}">{{$val}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="unit" class="form-control text-center method"
                                                id="unit" value="Existing">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="rate"
                                                class="form-control text-right vendor" value="{{$value->sla}}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="price"
                                                class="form-control text-right bts" value="{{$value->method}}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="total_price"
                                                class="form-control text-right gps" value="{{$value->vendor->name}}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="product_name" class="form-control text-center distance"
                                                id="service_name" value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="unit" class="form-control text-center capacity"
                                                id="unit" value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="rate"
                                                class="form-control text-right remarks" value="{{$value->connectivity_capacity}}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="total_price"
                                                class="form-control text-right" value="">
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
                $(document).on('click','.remove_requirement_row', function() {
                    $(this).closest('tr').remove();
                });

                function addExistingRow() {
                    $('.product_existing_row').first().clone().appendTo('.existingBody');
                    $('.product_existing_row').last().find('input').val('').attr('readonly',false);
                    $('.product_existing_row').last().find('select').val('').attr('readonly',false);
                };

                function addRequirementRow() {
                               var adad = `<tr class="requirement_details_row">
                                    <td>
                                        <select name="" id="" class="form-control link_type">
                                            @foreach ($type as $key=>$val )
                                                <option value="{{$val}}">{{$val}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td> 
                                        <select name="" id="" class="form-control option_type">
                                            @foreach ($option_type as $key=>$val )
                                                <option value="{{$val}}">{{$val}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="unit" class="form-control text-center method"
                                                id="unit" value="Existing">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="rate"
                                                class="form-control text-right vendor" value="{{$value->sla}}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="price"
                                                class="form-control text-right bts" value="{{$value->method}}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="total_price"
                                                class="form-control text-right gps" value="{{$value->vendor->name}}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="product_name" class="form-control text-center distance"
                                                id="service_name" value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="unit" class="form-control text-center capacity"
                                                id="unit" value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="rate"
                                                class="form-control text-right remarks" value="{{$value->connectivity_capacity}}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="total_price"
                                                class="form-control text-right" value="">
                                        </div>
                                    </td>
                                </tr>`
                                $('.requirementBody').append(adad);
                             };

                

                $(document).on('change','.checkbox', function() {
                    if($(this).prop("checked") == true){
                        addRequirementRow();
                    }else{
                        
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
