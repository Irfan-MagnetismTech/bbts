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

@php
    $is_old = old('commissioning_Date') ? true : false;
    $form_heading = !empty($connectivity) ? 'Update' : 'Add';
    $form_url = !empty($connectivity) ? '' : route('connectivities.store');
    $form_method = !empty($connectivity) ? 'PUT' : 'POST';
    
    $sale_id = old('sale_id', !empty($connectivity) ? $connectivity->sale_id : $salesDetail->sale_id);
    $commissioning_date = old('commissioning_date', !empty($connectivity) ? $connectivity->commissioning_date : today()->format('d-m-Y'));
    
@endphp

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
        <form action="{{ $form_url }}" method="{{ $form_method }}" class="custom-form">
            @csrf
            <br>
            <div class="row">
                <input type="hidden" name="sale_id" id="sale_id" value="{{ $sale_id }}">

                <x-input-box colGrid="4" name="client_name" value="{{ $salesDetail->client->client_name }}"
                    label="Client Name" attr="disabled" />
                <input type="hidden" value="{{ $salesDetail->client->client_no }}" name="client_no">
                <x-input-box colGrid="4" name="client_type" value="{{ $salesDetail->frDetails->connectivity_point }}"
                    label="Connectivity Point" attr="disabled" />
                <input type="hidden" value="{{ $salesDetail->fr_no }}" name="fr_no">
                <x-input-box colGrid="4" name="client_type" value="{{ $salesDetail->frDetails->contact_name }}"
                    label="Contact Person" attr="disabled" />
                <x-input-box colGrid="4" name="client_type" value="{{ $salesDetail->frDetails->contact_number }}"
                    label="Contact Number" attr="disabled" />
                <x-input-box colGrid="4" name="client_type" value="{{ $salesDetail->frDetails->contact_designation }}"
                    label="Designation" attr="disabled" />
                <x-input-box colGrid="4" name="client_type" value="{{ $salesDetail->frDetails->contact_email }}"
                    label="Email" attr="disabled" />
                <x-input-box colGrid="4" name="client_type" value="{{ $salesDetail->frDetails->lat }}" label="Latitude"
                    attr="disabled" />
                <x-input-box colGrid="4" name="client_type" value="{{ $salesDetail->frDetails->long }}"
                    label="Longitude" attr="disabled" />
                <div class="form-group col-4">
                    <div class="form-item">
                        <select class="form-control select2" name="attendant_engineer" id="attendant_engineer" required
                            @if (!empty($connectivity)) disabled @endif>
                            <option value="">Select Engineer</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}"
                                    @if (!empty($connectivity->attendant_engineer)) @selected($connectivity->attendant_engineer == $employee->id) @endif>
                                    {{ $employee->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <x-input-box colGrid="4" name="commissioning_date" class="date" value="{{ $commissioning_date }}"
                    label="Commissioning Date" attr="{{ !empty($connectivity) ? 'disabled' : '' }}" />
            </div>

            @if (!empty($physicalConnectivity))
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
                        @foreach ($physicalConnectivity->lines as $key => $physicalConnectivityLine)
                            <tr>
                                <td>
                                    <input type="text" class="form-control"
                                        value="{{ $physicalConnectivityLine->link_type }}" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control"
                                        value="{{ $physicalConnectivityLine->method }}" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" value="{{ $physicalConnectivityLine->pop }}"
                                        readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" value="{{ $physicalConnectivityLine->ldp }}"
                                        readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control"
                                        value="{{ $physicalConnectivityLine->bbts_link_id }}" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control"
                                        value="{{ $physicalConnectivityLine->device_ip }}" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control"
                                        value="{{ $physicalConnectivityLine->port }}" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control"
                                        value="{{ $physicalConnectivityLine->vlan }}" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control"
                                        value="{{ $physicalConnectivityLine->connectivity_details }}" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control"
                                        value="{{ $physicalConnectivityLine->comment }}" readonly>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            @if (!empty($logicalConnectivities->get('Internet')))
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
                        @forelse ($logicalConnectivityBandwidths as $key => $bandwidth)
                            <tr>
                                <td>
                                    <input type="text" class="form-control" value="{{ $bandwidth->ip->address }}"
                                        readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" value="{{ $bandwidth->bandwidth }}"
                                        readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" value="{{ $bandwidth->remarks }}"
                                        readonly>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            @endif

            @if (!empty($logicalConnectivities->get('VAS')))
                <h5 class="text-center p-2">VAS SERVICE</h5>
                <table class="table table-bordered" id="vas_service">
                    <thead>
                        <tr>
                            <th> Product Name</th>
                            <th> Number of User</th>
                            <th> Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logicalConnectivities->get('VAS')->lines as $key => $line)
                            <tr>
                                <td>
                                    <input type="text" class="form-control" value="{{ $line->product->name }}"
                                        readonly>
                                </td>
                                <td>
                                    <input type="number" class="form-control" autocomplete="off"
                                        value="{{ $line->quantity }}" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" autocomplete="off"
                                        value="{{ $line->remarks }}" readonly>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            @if (!empty($logicalConnectivities->get('Data')))
                <h5 class="text-center p-2">DATA SERVICE</h5>
                <table class="table table-bordered" id="data_service">
                    <thead>
                        <tr>
                            <th> Product Name</th>
                            <th>Data Type</th>
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
                        @forelse ($logicalConnectivities->get('Data')?->lines as $key => $line)
                            <tr>
                                <td>
                                    <input type="text" class="form-control" value="{{ $line->product->name }}"
                                        readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" value="{{ $line->data_type }}" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" value="{{ $line->quantity }}" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" value="{{ $line->ip_ipv4 }}" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" value="{{ $line->ip_ipv6 }}" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" value="{{ $line->subnetmask }}" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" value="{{ $line->gateway }}" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" value="{{ $line->vlan }}" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" value="{{ $line->mrtg_user }}" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" value="{{ $line->mrtg_pass }}" readonly>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            @endif

            @if (!empty($logicalConnectivities->get('Internet')))
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
                        @forelse ($logicalConnectivities->get('Internet')?->lines as $key => $line)
                            <tr>
                                <td>
                                    <input type="text" class="form-control" value="{{ $line->product->name }}"
                                        readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" value="{{ $line->quantity }}" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" value="{{ $line->ip_ipv4 }}" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" value="{{ $line->ip_ipv6 }}" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" value="{{ $line->subnetmask }}" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" value="{{ $line->gateway }}" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" value="{{ $line->vlan }}" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" value="{{ $line->mrtg_user }}" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" value="{{ $line->mrtg_pass }}" readonly>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            @endif

            @if (!empty($facilityTypes))
                @if (in_array('dns', $facilityTypes))
                    <div class="row mt-4">
                        <div class="form-group col-1">
                            <label>&nbsp;</label>
                            <div class="client_name">
                                <div class="checkbox-fade fade-in-primary">
                                    <label>
                                        <input type="checkbox" value="dns" class="dns_checkbox" disabled
                                            @checked(in_array('dns', $facilityTypes)) onclick="checkboxChange(this, dns_input_fields)">
                                        <span class="cr">
                                            <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                        </span>
                                        <span class="font-weight-bold">DNS</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-2 dns_domain">
                            <label>Domain Name</label>
                            <input type="text" class="form-control" disabled
                                value="{{ $clientFacility->dns_domain ?? '' }}">
                        </div>

                        <div class="form-group col-2 dns_mx_record">
                            <label>Mx Record</label>
                            <input type="text" class="form-control"
                                value="{{ $clientFacility->dns_mx_record ?? '' }}" disabled>
                        </div>

                        <div class="form-group col-2 dns_a_record">
                            <label>A Record</label>
                            <input type="text" class="form-control" value="{{ $clientFacility->dns_a_record ?? '' }}"
                                disabled>
                        </div>

                        <div class="form-group col-2 dns_reverse_record">
                            <label>Reverse Record</label>
                            <input type="text" class="form-control" disabled
                                value="{{ $clientFacility->dns_reverse_record ?? '' }}">
                        </div>

                        <div class="form-group col-2 dns_ip_address">
                            <label>IP Address</label>
                            <input type="text" class="form-control"
                                value="{{ $clientFacility->dns_ip_address ?? '' }}" disabled>
                        </div>
                    </div>
                    <hr>
                @endif

                @if (in_array('smtp', $facilityTypes))
                    <div class="row">
                        <div class="form-group col-1">
                            <label>&nbsp;</label>
                            <div class="client_name">
                                <div class="checkbox-fade fade-in-primary">
                                    <label>
                                        <input type="checkbox" value="smtp" class="smtp_checkbox" disabled
                                            @checked(in_array('smtp', $facilityTypes)) onclick="checkboxChange(this, smtp_input_fields)">
                                        <span class="cr">
                                            <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                        </span>
                                        <span class="font-weight-bold">SMTP</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-2 smtp_domain">
                            <label>Domain Name</label>
                            <input type="text" class="form-control" value="{{ $clientFacility->smtp_domain ?? '' }}"
                                disabled>
                        </div>

                        <div class="form-group col-2 smtp_server">
                            <label>Server Name</label>
                            <input type="text" class="form-control" value="{{ $clientFacility->smtp_server ?? '' }}"
                                disabled>
                        </div>
                    </div>
                    <hr>
                @endif

                @if (in_array('vpn', $facilityTypes))
                    <div class="row">
                        <div class="form-group col-1">
                            <label>&nbsp;</label>
                            <div class="client_name">
                                <div class="checkbox-fade fade-in-primary">
                                    <label>
                                        <input type="checkbox" value="vpn" class="vpn_checkbox" disabled
                                            @checked(in_array('vpn', $facilityTypes)) onclick="checkboxChange(this, vpn_input_fields)">
                                        <span class="cr">
                                            <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                        </span>
                                        <span class="font-weight-bold">VPN</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-2 vpn_purpose">
                            <label>Purpose Of Using VPN</label>
                            <input type="text" class="form-control" value="{{ $clientFacility->vpn_purpose ?? '' }}"
                                disabled>
                        </div>

                        <div class="form-group col-2 vpn_source_ip">
                            <label>Source IP</label>
                            <input type="text" class="form-control"
                                value="{{ $clientFacility->vpn_source_ip ?? '' }}" disabled>
                        </div>

                        <div class="form-group col-2 vpn_destination_ip">
                            <label>Destination IP</label>
                            <input type="text" class="form-control" disabled
                                value="{{ $clientFacility->vpn_destination_ip ?? '' }}">
                        </div>

                        <div class="form-group col-2 vpn_bandwidth">
                            <label>VPN Bandwidth (Mbps)</label>
                            <input type="text" class="form-control"
                                value="{{ $clientFacility->vpn_bandwidth ?? '' }}" disabled>
                        </div>

                        <div class="form-group col-2 vpn_iig_name">
                            <label>IIG Name</label>
                            <input type="text" class="form-control" value="{{ $clientFacility->vpn_iig_name ?? '' }}"
                                disabled>
                        </div>

                        <div class="form-group offset-md-1 col-2 vpn_tunnel_active_date">
                            <label>VPN Tunnel Active Date</label>
                            <input type="text" class="form-control" disabled
                                value="{{ $clientFacility->vpn_tunnel_active_date ?? '' }}">
                        </div>

                        <div class="form-group col-2 vpn_submission_date">
                            <label>Submission Date</label>
                            <input type="text" class="form-control" disabled
                                value="{{ $clientFacility->vpn_submission_date ?? '' }}">
                        </div>

                        <div class="form-group col-2 vpn_remarks">
                            <label>Remarks</label>
                            <input type="text" class="form-control" value="{{ $clientFacility->vpn_remarks ?? '' }}"
                                disabled>
                        </div>
                    </div>
                    <hr>
                @endif

                @if (in_array('vc', $facilityTypes))
                    <div class="row">
                        <div class="form-group col-1">
                            <label>&nbsp;</label>
                            <div class="client_name">
                                <div class="checkbox-fade fade-in-primary">
                                    <label>
                                        <input type="checkbox" value="vc" class="vc_checkbox" disabled
                                            @checked(in_array('vc', $facilityTypes)) onclick="checkboxChange(this, vc_input_fields)">
                                        <span class="cr">
                                            <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                        </span>
                                        <span class="font-weight-bold">VC</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-2 vc_issued_date">
                            <label>Issued Date</label>
                            <input type="text" class="form-control" disabled
                                value="{{ $clientFacility->vc_issued_date ?? '' }}">
                        </div>

                        <div class="form-group col-2 vc_source_ip">
                            <label>Source IP</label>
                            <input type="text" class="form-control" value="{{ $clientFacility->vc_source_ip ?? '' }}"
                                disabled>
                        </div>

                        <div class="form-group col-2 vc_destination_ip">
                            <label>Destination IP</label>
                            <input type="text" class="form-control" disabled
                                value="{{ $clientFacility->vc_destination_ip ?? '' }}">
                        </div>

                        <div class="form-group col-2 vc_iig_name">
                            <label>IIG Name</label>
                            <input type="text" class="form-control" value="{{ $clientFacility->vc_iig_name ?? '' }}"
                                disabled>
                        </div>

                        <div class="form-group col-2 vc_itc_name">
                            <label>ITC Name</label>
                            <input type="text" class="form-control" value="{{ $clientFacility->vc_itc_name ?? '' }}"
                                disabled>
                        </div>

                        <div class="form-group offset-md-1 col-2 vc_renewal_date">
                            <label>Renewal Date</label>
                            <input type="text" class="form-control" disabled
                                value="{{ $clientFacility->vc_renewal_date ?? '' }}">
                        </div>

                        <div class="form-group col-2 vc_remarks">
                            <label>Remarks</label>
                            <input type="text" class="form-control" disabled
                                value="{{ $clientFacility->vc_remarks ?? '' }}">
                        </div>
                    </div>
                    <hr>
                @endif

                @if (in_array('bgp', $facilityTypes))
                    <div class="row">
                        <div class="form-group col-1">
                            <label>&nbsp;</label>
                            <div class="client_name">
                                <div class="checkbox-fade fade-in-primary">
                                    <label>
                                        <input type="checkbox" value="bgp" class="bgp_checkbox" disabled
                                            @checked(in_array('bgp', $facilityTypes)) onclick="checkboxChange(this, bgp_input_fields)">
                                        <span class="cr">
                                            <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                        </span>
                                        <span class="font-weight-bold">BGP</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-2 bgp_primary_peering">
                            <label>Primary Peering</label>
                            <input type="text" class="form-control" disabled
                                value="{{ $clientFacility->bgp_primary_peering ?? '' }}">
                        </div>

                        <div class="form-group col-2 bgp_secondary_peering">
                            <label>Secondary Peering</label>
                            <input type="text" class="form-control" disabled
                                value="{{ $clientFacility->bgp_secondary_peering ?? '' }}">
                        </div>

                        <div class="form-group col-2 bgp_client_prefix">
                            <label>Client Prefix</label>
                            <input type="text" class="form-control" disabled
                                value="{{ $clientFacility->bgp_client_prefix ?? '' }}">
                        </div>

                        <div class="form-group col-2 bgp_client_as">
                            <label>Client As</label>
                            <input type="text" class="form-control"
                                value="{{ $clientFacility->bgp_client_as ?? '' }}" disabled>
                        </div>
                    </div>
                @endif
            @endif

            @if (empty($connectivity))
                <div class="row">
                    <div class="offset-md-4 col-md-4 mt-2">
                        <div class="input-group input-group-sm ">
                            <button class="btn btn-success btn-round btn-block py-2">Submit</button>
                        </div>
                    </div>
                </div>
            @endif
        </form>
    </div>

@endsection
@section('script')
    @include('networking::connectivities.js')
@endsection
