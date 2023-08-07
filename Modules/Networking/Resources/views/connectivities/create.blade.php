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
            <table class="table table-bordered" id="vas_service">
                <thead>
                    <tr>
                        <th> Product Name</th>
                        <th> Number of User</th>
                        <th> Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($logicalConnectivityVas))
                        @foreach ($logicalConnectivityVas->lines as $key => $line)
                            <tr>
                                <td>
                                    <input type="text" name="product_name[]" class="form-control product_name"
                                        value="{{ $line->product->name }}" readonly>
                                </td>
                                <td>
                                    <input type="number" name="quantity[]" class="form-control quantity"
                                        autocomplete="off" value="{{ $line->quantity }}" readonly>
                                </td>
                                <td>
                                    <input type="text" name="remarks[]" class="form-control remarks"
                                        autocomplete="off" value="{{ $line->remarks }}" readonly>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>

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
                    @if (!empty($logicalConnectivityData))
                        @forelse ($logicalConnectivityData?->lines as $key => $line)
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

            @if (in_array('dns', $facilityTypes))
                <div class="row mt-4">
                    <div class="form-group col-1">
                        <label for="total_bandwidth">&nbsp;</label>
                        <div class="client_name">
                            <div class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" name="dns_checkbox" name='dns_checkbox' value="dns"
                                        class="dns_checkbox" disabled @checked(!empty($logicalConnectivityInternet) ? in_array('dns', $facilityTypes) : false)
                                        onclick="checkboxChange(this, dns_input_fields)">
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span class="font-weight-bold">DNS</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-2 dns_domain">
                        <label for="dns_domain">Domain Name</label>
                        <input type="text" class="form-control" name="dns_domain" aria-describedby="dns_domain"
                            disabled id="dns_domain"
                            value="{{ old('dns_domain') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->dns_domain : '') }}">
                    </div>

                    <div class="form-group col-2 dns_mx_record">
                        <label for="dns_mx_record">Mx Record</label>
                        <input type="text" class="form-control" name="dns_mx_record" aria-describedby="dns_mx_record"
                            value="{{ old('dns_mx_record') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->dns_mx_record : '') }}"
                            disabled id="dns_mx_record">
                    </div>

                    <div class="form-group col-2 dns_a_record">
                        <label for="dns_a_record">A Record</label>
                        <input type="text" class="form-control" name="dns_a_record" aria-describedby="dns_a_record"
                            value="{{ old('dns_a_record') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->dns_a_record : '') }}"
                            disabled id="dns_a_record">
                    </div>

                    <div class="form-group col-2 dns_reverse_record">
                        <label for="dns_reverse_record">Reverse Record</label>
                        <input type="text" class="form-control" name="dns_reverse_record"
                            aria-describedby="dns_reverse_record" disabled
                            value="{{ old('dns_reverse_record') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->dns_reverse_record : '') }}"
                            id="dns_reverse_record">
                    </div>

                    <div class="form-group col-2 dns_ip_address">
                        <label for="dns_ip_address">IP Address</label>
                        <input type="text" class="form-control" name="dns_ip_address"
                            aria-describedby="dns_ip_address"
                            value="{{ old('dns_ip_address') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->dns_ip_address : '') }}"
                            disabled id="dns_ip_address">
                    </div>
                </div>
            @endif
            <hr>

            @if (in_array('smtp', $facilityTypes))
                <div class="row">
                    <div class="form-group col-1">
                        <label for="total_bandwidth">&nbsp;</label>
                        <div class="client_name">
                            <div class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" name="smtp_checkbox" name='smtp_checkbox' value="smtp"
                                        class="smtp_checkbox" disabled @checked(!empty($logicalConnectivityInternet) ? in_array('smtp', $facilityTypes) : false)
                                        onclick="checkboxChange(this, smtp_input_fields)">
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span class="font-weight-bold">SMTP</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-2 smtp_domain">
                        <label for="smtp_domain">Domain Name</label>
                        <input type="text" class="form-control" name="smtp_domain" aria-describedby="smtp_domain"
                            value="{{ old('smtp_domain') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->smtp_domain : '') }}"
                            disabled id="smtp_domain">
                    </div>

                    <div class="form-group col-2 smtp_server">
                        <label for="smtp_server">Server Name</label>
                        <input type="text" class="form-control" name="smtp_server" aria-describedby="smtp_server"
                            value="{{ old('smtp_server') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->smtp_server : '') }}"
                            disabled id="smtp_server">
                    </div>
                </div>
            @endif

            <hr>

            @if (in_array('vpn', $facilityTypes))
                <div class="row">
                    <div class="form-group col-1">
                        <label for="total_bandwidth">&nbsp;</label>
                        <div class="client_name">
                            <div class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" name="vpn_checkbox" name='vpn_checkbox' value="vpn"
                                        class="vpn_checkbox" disabled @checked(!empty($logicalConnectivityInternet) ? in_array('vpn', $facilityTypes) : false)
                                        onclick="checkboxChange(this, vpn_input_fields)">
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span class="font-weight-bold">VPN</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-2 vpn_purpose">
                        <label for="vpn_purpose">Purpose Of Using VPN</label>
                        <input type="text" class="form-control" name="vpn_purpose" aria-describedby="vpn_purpose"
                            value="{{ old('vpn_purpose') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->vpn_purpose : '') }}"
                            disabled id="vpn_purpose">
                    </div>

                    <div class="form-group col-2 vpn_source_ip">
                        <label for="vpn_source_ip">Source IP</label>
                        <input type="text" class="form-control" name="vpn_source_ip" aria-describedby="vpn_source_ip"
                            value="{{ old('vpn_source_ip') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->vpn_source_ip : '') }}"
                            disabled id="vpn_source_ip">
                    </div>

                    <div class="form-group col-2 vpn_destination_ip">
                        <label for="vpn_destination_ip">Destination IP</label>
                        <input type="text" class="form-control" name="vpn_destination_ip"
                            aria-describedby="vpn_destination_ip" disabled
                            value="{{ old('vpn_destination_ip') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->vpn_destination_ip : '') }}"
                            id="vpn_destination_ip">
                    </div>

                    <div class="form-group col-2 vpn_bandwidth">
                        <label for="vpn_bandwidth">VPN Bandwidth (Mbps)</label>
                        <input type="text" class="form-control" name="vpn_bandwidth" aria-describedby="vpn_bandwidth"
                            value="{{ old('vpn_bandwidth') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->vpn_bandwidth : '') }}"
                            disabled id="vpn_bandwidth">
                    </div>

                    <div class="form-group col-2 vpn_iig_name">
                        <label for="vpn_iig_name">IIG Name</label>
                        <input type="text" class="form-control" name="vpn_iig_name" aria-describedby="vpn_iig_name"
                            value="{{ old('vpn_iig_name') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->vpn_iig_name : '') }}"
                            disabled id="vpn_iig_name">
                    </div>

                    <div class="form-group offset-md-1 col-2 vpn_tunnel_active_date">
                        <label for="vpn_tunnel_active_date">VPN Tunnel Active Date</label>
                        <input type="text" class="form-control date" name="vpn_tunnel_active_date"
                            aria-describedby="vpn_tunnel_active_date" disabled
                            value="{{ old('vpn_tunnel_active_date') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->vpn_tunnel_active_date : '') }}"
                            id="vpn_tunnel_active_date">
                    </div>

                    <div class="form-group col-2 vpn_submission_date">
                        <label for="vpn_submission_date">Submission Date</label>
                        <input type="text" class="form-control date" name="vpn_submission_date"
                            aria-describedby="vpn_submission_date" disabled
                            value="{{ old('vpn_submission_date') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->vpn_submission_date : '') }}"
                            id="vpn_submission_date">
                    </div>

                    <div class="form-group col-2 vpn_remarks">
                        <label for="vpn_remarks">Remarks</label>
                        <input type="text" class="form-control" name="vpn_remarks" aria-describedby="vpn_remarks"
                            value="{{ old('vpn_remarks') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->vpn_remarks : '') }}"
                            disabled id="vpn_remarks">
                    </div>
                </div>
            @endif

            <hr>

            @if (in_array('vc', $facilityTypes))
                <div class="row">
                    <div class="form-group col-1">
                        <label for="total_bandwidth">&nbsp;</label>
                        <div class="client_name">
                            <div class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" name="vc_checkbox" name='vc_checkbox' value="vc"
                                        class="vc_checkbox" disabled @checked(!empty($logicalConnectivityInternet) ? in_array('vc', $facilityTypes) : false)
                                        onclick="checkboxChange(this, vc_input_fields)">
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span class="font-weight-bold">VC</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-2 vc_issued_date">
                        <label for="vc_issued_date">Issued Date</label>
                        <input type="text" class="form-control date" name="vc_issued_date"
                            aria-describedby="vc_issued_date" disabled
                            value="{{ old('vc_issued_date') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->vc_issued_date : '') }}"
                            id="vc_issued_date">
                    </div>

                    <div class="form-group col-2 vc_source_ip">
                        <label for="vc_source_ip">Source IP</label>
                        <input type="text" class="form-control" name="vc_source_ip" aria-describedby="vc_source_ip"
                            value="{{ old('vc_source_ip') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->vc_source_ip : '') }}"
                            disabled id="vc_source_ip">
                    </div>

                    <div class="form-group col-2 vc_destination_ip">
                        <label for="vc_destination_ip">Destination IP</label>
                        <input type="text" class="form-control" name="vc_destination_ip"
                            aria-describedby="vc_destination_ip" disabled
                            value="{{ old('vc_destination_ip') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->vc_destination_ip : '') }}"
                            id="vc_destination_ip">
                    </div>

                    <div class="form-group col-2 vc_iig_name">
                        <label for="vc_iig_name">IIG Name</label>
                        <input type="text" class="form-control" name="vc_iig_name" aria-describedby="vc_iig_name"
                            value="{{ old('vc_iig_name') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->vc_iig_name : '') }}"
                            disabled id="vc_iig_name">
                    </div>

                    <div class="form-group col-2 vc_itc_name">
                        <label for="vc_itc_name">ITC Name</label>
                        <input type="text" class="form-control" name="vc_itc_name" aria-describedby="vc_itc_name"
                            value="{{ old('vc_itc_name') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->vc_itc_name : '') }}"
                            disabled id="vc_itc_name">
                    </div>

                    <div class="form-group offset-md-1 col-2 vc_renewal_date">
                        <label for="vc_renewal_date">Renewal Date</label>
                        <input type="text" class="form-control date" name="vc_renewal_date"
                            aria-describedby="vc_renewal_date" disabled
                            value="{{ old('vc_renewal_date') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->vc_renewal_date : '') }}"
                            id="vc_renewal_date">
                    </div>

                    <div class="form-group col-2 vc_remarks">
                        <label for="vc_remarks">Remarks</label>
                        <input type="text" class="form-control" name="vc_remarks" aria-describedby="vc_remarks"
                            disabled
                            value="{{ old('vc_remarks') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->vc_remarks : '') }}"
                            id="vc_remarks">
                    </div>
                </div>
            @endif

            <hr>

            @if (in_array('bgp', $facilityTypes))
                <div class="row">
                    <div class="form-group col-1">
                        <label for="total_bandwidth">&nbsp;</label>
                        <div class="client_name">
                            <div class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" name="bgp_checkbox" name='bgp_checkbox' value="bgp"
                                        class="bgp_checkbox" disabled @checked(!empty($logicalConnectivityInternet) ? in_array('bgp', $facilityTypes) : false)
                                        onclick="checkboxChange(this, bgp_input_fields)">
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span class="font-weight-bold">BGP</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-2 bgp_primary_peering">
                        <label for="bgp_primary_peering">Primary Peering</label>
                        <input type="text" class="form-control" name="bgp_primary_peering"
                            aria-describedby="bgp_primary_peering" disabled
                            value="{{ old('bgp_primary_peering') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->bgp_primary_peering : '') }}"
                            id="bgp_primary_peering">
                    </div>

                    <div class="form-group col-2 bgp_secondary_peering">
                        <label for="bgp_secondary_peering">Secondary Peering</label>
                        <input type="text" class="form-control" name="bgp_secondary_peering"
                            aria-describedby="bgp_secondary_peering" disabled
                            value="{{ old('bgp_secondary_peering') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->bgp_secondary_peering : '') }}"
                            id="bgp_secondary_peering">
                    </div>

                    <div class="form-group col-2 bgp_client_prefix">
                        <label for="bgp_client_prefix">Client Prefix</label>
                        <input type="text" class="form-control" name="bgp_client_prefix"
                            aria-describedby="bgp_client_prefix" disabled
                            value="{{ old('bgp_client_prefix') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->bgp_client_prefix : '') }}"
                            id="bgp_client_prefix">
                    </div>

                    <div class="form-group col-2 bgp_client_as">
                        <label for="bgp_client_as">Client As</label>
                        <input type="text" class="form-control" name="bgp_client_as" aria-describedby="bgp_client_as"
                            value="{{ old('bgp_client_as') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->bgp_client_as : '') }}"
                            disabled id="bgp_client_as">
                    </div>
                </div>
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
    @include('networking::connectivities.js')
@endsection
