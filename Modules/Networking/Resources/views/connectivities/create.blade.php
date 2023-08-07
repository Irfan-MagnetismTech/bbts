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
                <x-input-box colGrid="4" name="client_name" value="{{ $salesDetail->client->client_name }}"
                    label="Client Name" />
                <x-input-box colGrid="4" name="client_type" value="{{ $salesDetail->frDetails->connectivity_point }}"
                    label="Connectivity Point" />
                <x-input-box colGrid="4" name="client_type" value="{{ $salesDetail->frDetails->contact_name }}"
                    label="Contact Person" />
                <x-input-box colGrid="4" name="client_type" value="{{ $salesDetail->frDetails->contact_number }}"
                    label="Contact Number" />
                <x-input-box colGrid="4" name="client_type" value="{{ $salesDetail->frDetails->contact_designation }}"
                    label="Designation" />
                <x-input-box colGrid="4" name="client_type" value="{{ $salesDetail->frDetails->contact_email }}"
                    label="Email" />
                <x-input-box colGrid="4" name="client_type" value="{{ $salesDetail->frDetails->lat }}"
                    label="Latitude" />
                <x-input-box colGrid="4" name="client_type" value="{{ $salesDetail->frDetails->long }}"
                    label="Longitude" />
                <div class="form-group col-4">
                    <div class="form-item">
                        <select class="form-control select2" name="attendant_engineer" id="attendant_engineer">
                            <option value="">Select Engineer</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <x-input-box colGrid="4" name="commissioning_Date" class="date" value=""
                    label="Commissioning Date" />
            </div>

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
                                    <input type="text" name="link_id[]" class="form-control link_id" autocomplete="off"
                                        value="{{ $physicalConnectivityLine->link_id }}" readonly>
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
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>

            <h5 class="text-center p-2">INTERNET SERVICE</h5>

            <table class="table table-bordered" id="data_service">
                <thead>
                    <tr>
                        <th> Product Name</th>
                        <th>Bandwidth</th>
                        <th>IP Adress ipv4</th>
                        <th>IP Adress ipv6</th>
                        <th> Subnet Mask</th>
                        <th> Gateway</th>
                        <th> VLAN</th>
                        <th> User ID</th>
                        <th> Password</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($logicalConnectivityInternet))
                        @forelse ($logicalConnectivityInternet?->lines as $key => $line)
                            <tr>
                                <td>
                                    <input type="text" name="product_name[]" class="form-control product_name"
                                        autocomplete="off" value="{{ $line->product->name }}" readonly>
                                </td>
                                <td>
                                    <input type="text" name="quantity[]" class="form-control quantity"
                                        autocomplete="off" value="{{ $line->quantity }}" readonly>
                                </td>
                                <td>
                                    <input type="text" name="ip_ipv4[]" class="form-control ip_ipv4"
                                        autocomplete="off" value="{{ $line->ip_ipv4 }}" readonly>
                                </td>
                                <td>
                                    <input type="text" name="ip_ipv6[]" class="form-control ip_ipv6"
                                        autocomplete="off" value="{{ $line->ip_ipv6 }}" readonly>
                                </td>
                                <td>
                                    <input type="text" name="subnetmask[]" class="form-control subnetmask"
                                        autocomplete="off" value="{{ $line->subnetmask }}" readonly>
                                </td>
                                <td>
                                    <input type="text" name="gateway[]" class="form-control gateway"
                                        autocomplete="off" value="{{ $line->gateway }}" readonly>
                                </td>
                                <td>
                                    <input type="text" name="vlan[]" class="form-control vlan" autocomplete="off"
                                        value="{{ $line->vlan }}" readonly>
                                </td>
                                <td>
                                    <input type="text" name="mrtg_user[]" class="form-control mrtg_user"
                                        autocomplete="off" value="{{ $line->mrtg_user }}" readonly>
                                </td>
                                <td>
                                    <input type="text" name="mrtg_pass[]" class="form-control mrtg_pass"
                                        autocomplete="off" value="{{ $line->mrtg_pass }}" readonly>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    @endif
                </tbody>
            </table>

            <h5 class="text-center p-2">Bandwidth Distribution </h5>

            <table class="table table-bordered" id="bandwidth_distribution">
                <thead>
                    <tr>
                        <th> IP Address</th>
                        <th> Bandwidth</th>
                        <th> Remarks </th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($logicalConnectivityInternet))
                        @forelse ($logicalConnectivityBandwidths as $key => $bandwidth)
                            <tr>
                                <td>
                                    <input type="text" name="ip_address[]" class="form-control ip_address"
                                        autocomplete="off" value="{{ $bandwidth->ip->address }}" readonly>
                                </td>
                                <td>
                                    <input type="text" name="bandwidth[]" class="form-control bandwidth"
                                        autocomplete="off" value="{{ $bandwidth->bandwidth }}" readonly>
                                </td>
                                <td>
                                    <input type="text" name="remarks[]" class="form-control remarks"
                                        autocomplete="off" value="{{ $bandwidth->remarks }}" readonly>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    @endif
                </tbody>
            </table>
            
            <h5 class="text-center p-2">VAS SERVICE</h5>
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
                    @forelse ($physicalConnectivityData->lines as $key => $line)
                        <tr>
                            <td>
                                <input type="text" name="link_type[]" class="form-control link_type"
                                    autocomplete="off" value="{{ $line->link_type }}" readonly>
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
                                <input type="text" class="form-control comment" autocomplete="off"
                                    value="{{ $line->comment }}" readonly>
                            </td>
                        </tr>
                    @empty
                    @endforelse
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
    @include('networking::connectivities.js')
@endsection
