@extends('layouts.backend-layout')
@section('title', 'Pyhsical Connectivity')

@php
    $is_old = old('type') ? true : false;
    $form_heading = !empty($physicalConnectivity) ? 'Update' : 'Add';
    $form_url = !empty($physicalConnectivity) ? route('errs.update', $physicalConnectivity->id) : route('errs.store');
    $form_method = !empty($physicalConnectivity) ? 'PUT' : 'POST';
    
    $client_name = old('client_name', !empty($physicalConnectivity) ? $physicalConnectivity?->client?->client_name : null);
    
    $client_no = old('client_no', !empty($physicalConnectivity) ? $physicalConnectivity?->client_no : null);
    
    $client_type = old('client_type', !empty($physicalConnectivity) ? $physicalConnectivity?->client?->client_type : null);
    
    $client_link_no = old('client_link_no', !empty($physicalConnectivity) ? $physicalConnectivity?->link_no : null);
    
    $connectivity_point = old('connectivity_point', !empty($physicalConnectivity) ? $physicalConnectivity->fr_no : null);
    
    $contact_person = old('contact_person', !empty($physicalConnectivity) ? $clientInfo->contact_name : null);
    $contact_number = old('contact_number', !empty($physicalConnectivity) ? $clientInfo->contact_number : null);
    $email = old('email', !empty($physicalConnectivity) ? $clientInfo->contact_email : null);
    $contact_address = old('contact_address', !empty($physicalConnectivity) ? $clientInfo->location : null);
    $lat = old('lat', !empty($physicalConnectivity) ? $clientInfo->lat : null);
    $long = old('long', !empty($physicalConnectivity) ? $clientInfo->long : null);
    $remarks = old('remarks', !empty($physicalConnectivity) ? $physicalConnectivity->remarks : null);
@endphp

@section('breadcrumb-title')
    @if (!empty($physicalConnectivity))
        Edit
    @else
        Create
    @endif
    Physical Connectivity
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
                        name="client_name" value="{{ $client_name }}" placeholder="Search...">
                    <input type="hidden" name="client_no" id="client_no" value="{{ $client_no }}">
                </div>

                <div class="form-group col-3 client_type">
                    <label for="client_type">Client Type:</label>
                    <input type="text" class="form-control" id="client_type" name="client_type"
                        aria-describedby="client_type" readonly value="{{ $client_type }}">
                </div>

                <div class="form-group col-3 connectivity_point1">
                    <label for="select2">Connectivity Point</label>
                    <select class="form-control select2" id="connectivity_point" name="connectivity_point">
                        <option value="" readonly selected>Select FR No</option>
                        @if ($form_method == 'POST')
                            <option value="{{ old('connectivity_point') }}" selected>{{ old('connectivity_point') }}
                            </option>
                        @elseif($form_method == 'PUT')
                            @forelse ($connectivity_points as $key => $value)
                                <option value="{{ $value->connectivity_point . '_' . $value->fr_no }}" @if ($connectivity_point == $value->fr_no) selected @endif>
                                    {{ $value->connectivity_point . '_' . $value->fr_no }}
                                </option>
                            @empty
                            @endforelse
                        @endif
                    </select>
                </div>

                <div class="form-group col-3 contact_person">
                    <label for="contact_person">Contact Person:</label>
                    <input type="text" class="form-control" id="contact_person" name="contact_person"
                        aria-describedby="contact_person" readonly value="{{ $contact_person }}">
                </div>

                <div class="form-group col-3 contact_number">
                    <label for="contact_number">Contact Number:</label>
                    <input type="text" class="form-control" id="contact_number" aria-describedby="contact_number"
                        name="contact_number" readonly value="{{ $contact_number }}">
                </div>

                <div class="form-group col-3 email">
                    <label for="email">Email:</label>
                    <input type="text" class="form-control" id="email" name="email" aria-describedby="email"
                        readonly value="{{ $email }}">
                </div>

                <div class="form-group col-3 contact_address">
                    <label for="contact_address">Contact Address:</label>
                    <input type="text" class="form-control" id="contact_address" name="contact_address"
                        aria-describedby="contact_address" readonly value="{{ $contact_address }}">
                </div>

                <div class="form-group col-3 lat">
                    <label for="lat">Latitude:</label>
                    <input type="text" class="form-control" id="lat" name="lat" aria-describedby="lat" readonly
                        value="{{ $lat }}">
                </div>

                <div class="form-group col-3 long">
                    <label for="long">Longitude:</label>
                    <input type="text" class="form-control" id="long" name="long" aria-describedby="long"
                        readonly value="{{ $long }}">
                </div>

                <div class="form-group col-3 remarks">
                    <label for="remarks">Remarks:</label>
                    <input type="text" class="form-control" id="remarks" name="remarks" aria-describedby="remarks"
                        value="{{ $remarks }}">
                </div>
            </div>

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
                    @if (!empty($physicalConnectivity))
                        @foreach ($physicalConnectivity->lines as $key => $physicalConnectivityLine)
                            <tr>
                                <td>
                                    <input type="text" name="link_type[]" class="form-control link_type"
                                        autocomplete="off" value="{{ $physicalConnectivityLine->link_type }}" readonly>
                                </td>
                                <td>
                                    <input type="text" name="method[]" class="form-control method" autocomplete="off"
                                        value="{{ $physicalConnectivityLine->method }}" readonly>
                                </td>
                                <td>
                                    <input type="text" name="pop[]" class="form-control pop" autocomplete="off"
                                        value="{{ $physicalConnectivityLine->pop }}" readonly>
                                </td>
                                <td>
                                    <input type="text" name="ldp[]" class="form-control ldp" autocomplete="off"
                                        value="{{ $physicalConnectivityLine->ldp }}" readonly>
                                </td>
                                <td>
                                    <input type="text" name="link_id[]" class="form-control link_id"
                                        autocomplete="off" value="{{ $physicalConnectivityLine->link_id }}" readonly>
                                </td>
                                <td>
                                    <input type="text" name="device_ip[]" class="form-control device_ip"
                                        autocomplete="off" value="{{ $physicalConnectivityLine->device_ip }}" readonly>
                                </td>
                                <td>
                                    <input type="text" name="port[]" class="form-control port" autocomplete="off"
                                        value="{{ $physicalConnectivityLine->port }}" readonly>
                                </td>
                                <td>
                                    <input type="text" name="vlan[]" class="form-control vlan" autocomplete="off"
                                        value="{{ $physicalConnectivityLine->vlan }}" readonly>
                                </td>
                                <td>
                                    <input type="text" name="connectivity_details[]"
                                        class="form-control connectivity_details" autocomplete="off"
                                        value="{{ $physicalConnectivityLine->connectivity_details }}" readonly>
                                </td>
                                <td>
                                    <input type="text" name="comment[]" class="form-control comment"
                                        autocomplete="off" value="{{ $physicalConnectivityLine->comment }}" readonly>
                                </td>
                                <td>
                                    <i class="btn btn-danger btn-sm fa fa-minus remove-network-info-row"></i>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>

            @if (!empty($physicalConnectivity))
                <h6>Material Utilizations</h6>
                @forelse (@$challanInfo as $challan)
                    <a href="{{ route('material-utilizations.create', ['challan_id' => $challan->id]) }}"
                        data-toggle="tooltip" title="Challan" class="btn btn-primary">{{ $challan->challan_no }}</a>
                @empty
                @endforelse
            @endif

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
    @include('networking::physical-connectivities.js')
@endsection
