@extends('layouts.backend-layout')
@section('title', 'Logical Connectivity')

@php
    $is_old = old('type') ? true : false;
    $form_heading = !empty($physicalConnectivity) ? 'Update' : 'Add';
    $form_url = !empty($physicalConnectivity) ? route('errs.update', $physicalConnectivity->id) : route('errs.store');
    $form_method = !empty($physicalConnectivity) ? 'PUT' : 'POST';
    
    $remarks = old('remarks', !empty($physicalConnectivity) ? $physicalConnectivity->remarks : null);
@endphp

@section('breadcrumb-title')
    @if (!empty($physicalConnectivity))
        Edit
    @else
        Create
    @endif
    Logical Connectivity For Data
@endsection

@section('style')
    <style>
        .input-group-addon {
            min-width: 120px;
        }

        .input-group-info .input-group-addon {
            /*background-color: #04748a!important;*/
        }
    </style>
@endsection

@section('breadcrumb-button')
    <a href="{{ route('physical-connectivities.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
    <div class="">
        <form
            action="{{ !empty($physicalConnectivity) ? route('physical-connectivities.update', @$physicalConnectivity->id) : route('physical-connectivities.store') }}"
            method="post" class="custom-form">
            @if (!empty($physicalConnectivity))
                @method('PUT')
            @endif
            @csrf

            <div class="row">
                <div class="form-group col-3 client_name">
                    <label for="client_name">Client Name:</label>
                    <input type="text" class="form-control" id="client_name" aria-describedby="client_name"
                        name="client_name" value="{{ $physicalConnectivityData->client_name }}" readonly>
                    <input type="hidden" name="client_no" id="client_no"
                        value="{{ $physicalConnectivityData->client_no }}">
                </div>

                <div class="form-group col-3 client_type">
                    <label for="client_type">Client Type:</label>
                    <input type="text" class="form-control" id="client_type" name="client_type"
                        aria-describedby="client_type" readonly value="{{ $physicalConnectivityData->client_type }}">
                </div>

                <div class="form-group col-3 connectivity_point1">
                    <label for="select2">Connectivity Point</label>
                    <input type="text" class="form-control" id="connectivity_point1" name="connectivity_point1"
                        aria-describedby="connectivity_point1"
                        value="{{ $physicalConnectivityData->connectivity_point . '_' . $physicalConnectivityData->fr_no }}"
                        readonly>
                </div>

                <div class="form-group col-3 contact_person">
                    <label for="contact_person">Contact Person:</label>
                    <input type="text" class="form-control" id="contact_person" name="contact_person"
                        aria-describedby="contact_person" readonly value="{{ $physicalConnectivityData->contact_person }}">
                </div>

                <div class="form-group col-3 contact_number">
                    <label for="contact_number">Contact Number:</label>
                    <input type="text" class="form-control" id="contact_number" aria-describedby="contact_number"
                        name="contact_number" readonly value="{{ $physicalConnectivityData->contact_number }}">
                </div>

                <div class="form-group col-3 email">
                    <label for="email">Email:</label>
                    <input type="text" class="form-control" id="email" name="email" aria-describedby="email"
                        readonly value="{{ $physicalConnectivityData->email }}">
                </div>

                <div class="form-group col-3 contact_address">
                    <label for="contact_address">Contact Address:</label>
                    <input type="text" class="form-control" id="contact_address" name="contact_address"
                        aria-describedby="contact_address" readonly
                        value="{{ $physicalConnectivityData->contact_address }}">
                </div>

                <div class="form-group col-3 remarks">
                    <label for="remarks">Remarks:</label>
                    <input type="text" class="form-control" id="remarks" name="remarks" aria-describedby="remarks"
                        value="{{ $remarks }}">
                </div>
            </div>

            <h5 class="text-center p-2">VAS SERVICE</h5>
            <table class="table table-bordered" id="vas_service">
                <thead>
                    <tr>
                        <th> Product Name</th>
                        <th> Description</th>
                        <th> Number of User</th>
                        <th> Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @foreach ($physicalConnectivityData->vas_services as $key => $vas_service)
                        <tr>
                            <td>
                                <input type="text" name="product_name[]" class="form-control product_name"
                                    autocomplete="off" value="{{ $vas_service->product_name }}" readonly>
                            </td>
                            <td>
                                <input type="text" name="description[]" class="form-control description"
                                    autocomplete="off" value="{{ $vas_service->description }}" readonly>
                            </td>
                            <td>
                                <input type="text" name="number_of_user[]" class="form-control number_of_user"
                                    autocomplete="off" value="{{ $vas_service->number_of_user }}" readonly>
                            </td>
                            <td>
                                <input type="text" name="remarks[]" class="form-control remarks" autocomplete="off"
                                    value="{{ $vas_service->remarks }}">
                            </td>
                        </tr>
                    @endforeach --}}
                </tbody>
            </table>

            <h5 class="text-center p-2">NETWORK INFORMATION</h5>
            <table class="table table-bordered" id="physical_connectivity">
                <thead>
                    <tr>
                        <th> Link Type</th>
                        <th> Method</th>
                        <th> POP</th>
                        <th>LDP</th>
                        <th> Link ID </th>
                        <th> Device IP </th>
                        <th> PORT </th>
                        <th> VLAN </th>
                        <th> Connectivity Details </th>
                        <th> Comment </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($physicalConnectivityData->lines as $key => $line)
                        <tr>
                            <td>
                                <input type="text" name="link_type[]" class="form-control link_type" autocomplete="off"
                                    value="{{ $line->link_type }}" readonly>
                            </td>
                            <td>
                                <input type="text" name="method[]" class="form-control method" autocomplete="off"
                                    value="{{ $line->method }}" readonly>
                            </td>
                            <td>
                                <input type="text" name="pop[]" class="form-control pop" autocomplete="off"
                                    value="{{ $line->pop }}" readonly>
                            </td>
                            <td>
                                <input type="text" name="ldp[]" class="form-control ldp" autocomplete="off"
                                    value="{{ $line->ldp }}" readonly>
                            </td>
                            <td>
                                <input type="text" name="link_id[]" class="form-control link_id" autocomplete="off"
                                    value="{{ $line->link_id }}" readonly>
                            </td>
                            <td>
                                <input type="text" name="device_ip[]" class="form-control device_ip"
                                    autocomplete="off" value="{{ $line->device_ip }}" readonly>
                            </td>
                            <td>
                                <input type="text" name="port[]" class="form-control port" autocomplete="off"
                                    value="{{ $line->port }}" readonly>
                            </td>
                            <td>
                                <input type="text" name="vlan[]" class="form-control vlan" autocomplete="off"
                                    value="{{ $line->vlan }}" readonly>
                            </td>
                            <td>
                                <input type="text" name="connectivity_details[]"
                                    class="form-control connectivity_details" autocomplete="off"
                                    value="{{ $line->connectivity_details }}" readonly>
                            </td>
                            <td>
                                <input type="text" name="comment[]" class="form-control comment" autocomplete="off"
                                    value="{{ $line->comment }}" readonly>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="row">
                <div class="offset-md-4 col-md-4 mt-2">
                    <div class="input-group input-group-sm ">
                        <button class="btn btn-success btn-round btn-block py-2">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
@section('script')
@endsection
