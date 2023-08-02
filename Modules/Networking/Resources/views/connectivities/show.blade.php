@extends('layouts.backend-layout')
@section('title', ' Connectivity Details')


@section('breadcrumb-title')
    Connectivity Details
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
    {{-- <span class="text-danger">*</span> Marked are required. --}}
@endsection

@section('content-grid', null)

@section('content')
    <div class="">
        <form
            action="{{ !empty($physicalConnectivity) ? route('physical-connectivities.update', @$physicalConnectivity->id) : route('physical-connectivities.store') }}"
            method="post" class="custom-form">
            @csrf
            <br>
            <div class="row">
                <x-input-box colGrid="4" name="client_name" value="{{ $salesDetail->client->client_name }}" label="Client Name" />
                <x-input-box colGrid="4" name="client_type" value="{{ $salesDetail->frDetails->connectivity_point }}" label="Connectivity Point" />
                <x-input-box colGrid="4" name="client_type" value="{{ $salesDetail->frDetails->contact_name }}" label="Contact Person" />
                <x-input-box colGrid="4" name="client_type" value="{{ $salesDetail->frDetails->contact_number }}" label="Contact Number" />
                <x-input-box colGrid="4" name="client_type" value="{{ $salesDetail->frDetails->contact_designation }}" label="Designation" />
                <x-input-box colGrid="4" name="client_type" value="{{ $salesDetail->frDetails->contact_email }}" label="Email" />
                <x-input-box colGrid="4" name="client_type" value="{{ $salesDetail->frDetails->lat }}" label="Latitude" />
                <x-input-box colGrid="4" name="client_type" value="{{ $salesDetail->frDetails->long }}" label="Longitude" />
            </div>

            {{-- <table class="table table-bordered" id="physical_connectivity">
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
            </table>  --}}

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