@extends('layouts.backend-layout')
@section('title', 'Logical Connectivity')

@php
    $is_old = old('comment') ? true : false;
    $form_heading = !empty($logicalConnectivityInternet) ? 'Update' : 'Add';
    $form_url = !empty($logicalConnectivityInternet) ? route('errs.update', $logicalConnectivityInternet->id) : route('errs.store');
    $form_method = !empty($logicalConnectivityInternet) ? 'PUT' : 'POST';
    
    $comment = $is_old ? old('comment') : @$logicalConnectivityInternet->comment;
    $quantity = $is_old ? old('quantity') : (!empty($logicalConnectivityInternet) ? $logicalConnectivityInternet->lines->pluck('quantity') : null);
    $remarks = $is_old ? old('remarks') : (!empty($logicalConnectivityInternet) ? $logicalConnectivityInternet->lines->pluck('remarks') : null);
    
    $effective_date = $is_old ? old('effective_date') : $sale->effective_date ?? today()->format('d-m-Y');
    $sale_id = old('sale_id', !empty($logicalConnectivityInternet) ? $logicalConnectivityInternet->sale_id : request()->sale_id);
@endphp

@section('breadcrumb-title')
    {{-- @if (!empty($   ))
        Edit
    @else
        Create
    @endif --}}
    Logical Connectivity For Internet Service
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
    <a href="{{ route('logical-internet-connectivities.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
    <div class="">
        <form action="{{ route('logical-internet-connectivities.store') }}" method="post" class="custom-form">
            @csrf

            <div class="row">
                <input type="hidden" name="sale_id" id="sale_id" value="{{ $sale_id }}">
                
                <div class="form-group col-3 client_name">
                    <label for="client_name">Client Name:</label>
                    <input type="text" class="form-control" id="client_name" aria-describedby="client_name"
                        name="client_name" value="{{ $saleDetalis->client->client_name }}" readonly>
                    <input type="hidden" name="client_no" id="client_no"
                        value="{{ @$physicalConnectivityData->client_no }}">
                </div>

                <div class="form-group col-3 client_type">
                    <label for="client_type">Client Type:</label>
                    <input type="text" class="form-control" id="client_type" name="client_type"
                        aria-describedby="client_type" readonly value="{{ $saleDetalis->client->client_type }}">
                </div>

                <div class="form-group col-3 connectivity_point1">
                    <label for="select2">Connectivity Point And FR</label>
                    <input type="text" class="form-control" id="connectivity_point1" name="connectivity_point1"
                        aria-describedby="connectivity_point1"
                        value="{{ @$physicalConnectivityData->connectivity_point . '_' . @$physicalConnectivityData->fr_no }}"
                        readonly>
                    <input type="hidden" name="fr_no" id="fr_no" value="{{ @$physicalConnectivityData->fr_no }}">
                </div>

                <div class="form-group col-3 contact_person">
                    <label for="contact_person">Contact Person:</label>
                    <input type="text" class="form-control" id="contact_person" name="contact_person"
                        aria-describedby="contact_person" readonly value="{{ $saleDetalis->frDetails->contact_name }}">
                </div>

                <div class="form-group col-3 contact_number">
                    <label for="contact_number">Contact Number:</label>
                    <input type="text" class="form-control" id="contact_number" aria-describedby="contact_number"
                        name="contact_number" readonly value="{{ $saleDetalis->frDetails->contact_number }}">
                </div>

                <div class="form-group col-3 email">
                    <label for="email">Email:</label>
                    <input type="text" class="form-control" id="email" name="email" aria-describedby="email"
                        readonly value="{{ $saleDetalis->frDetails->contact_email }}">
                </div>

                <div class="form-group col-3 contact_address">
                    <label for="contact_address">Contact Address:</label>
                    <input type="text" class="form-control" id="contact_address" name="contact_address"
                        aria-describedby="contact_address" readonly
                        value="{{ $saleDetalis->frDetails->location }}">
                </div>

                <div class="form-group col-3 comment">
                    <label for="comment">Comment:</label>
                    <input type="text" class="form-control" id="comment" name="comment" aria-describedby="comment"
                        value="{{ $comment }}">
                </div>
            </div>

            <h5 class="text-center p-2">INTERNET SERVICE</h5>

            <div class="container mb-2">
                <div class="row justify-content-end">
                    <div class="col-auto">
                        <div class="">
                            <input class="" type="radio" name="shared_type" id="dedicatedRadio" value="dedicated"
                                @checked(@$logicalConnectivityInternet->shared_type == 'dedicated' || old('shared_type') == 'dedicated') required>
                            <label class="form-check-label" for="dedicatedRadio">Dedicated</label>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="">
                            <input class="" type="radio" name="shared_type" id="sharedRadio" value="shared"
                                @checked(@$logicalConnectivityInternet->shared_type == 'shared' || old('shared_type') == 'shared') required>
                            <label class="form-check-label" for="sharedRadio">Shared</label>
                        </div>
                    </div>
                </div>
            </div>

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
                        <th> Action </th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($logicalConnectivityInternet))
                        @forelse ($logicalConnectivityInternet?->lines as $key => $line)
                            <tr>
                                <td>
                                    <select name="product_id[]" class="form-control product_id select2" readonly>
                                        <option value="">Select Product</option>
                                        @foreach ($products as $data)
                                            <option value="{{ $data->product->id }}" @selected($line->product_id == $data->product->id)>
                                                {{ $data->product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="quantity[]" class="form-control quantity"
                                        autocomplete="off" value="{{ $line->quantity }}">
                                </td>
                                <td>
                                    <input type="text" name="ip_ipv4[]" class="form-control ip_ipv4"
                                        autocomplete="off" value="{{ $line->ip_ipv4 }}">
                                </td>
                                <td>
                                    <input type="text" name="ip_ipv6[]" class="form-control ip_ipv6"
                                        autocomplete="off" value="{{ $line->ip_ipv6 }}">
                                </td>
                                <td>
                                    <input type="text" name="subnetmask[]" class="form-control subnetmask"
                                        autocomplete="off" value="{{ $line->subnetmask }}">
                                </td>
                                <td>
                                    <input type="text" name="gateway[]" class="form-control gateway"
                                        autocomplete="off" value="{{ $line->gateway }}">
                                </td>
                                <td>
                                    <input type="text" name="vlan[]" class="form-control vlan" autocomplete="off"
                                        value="{{ $line->vlan }}">
                                </td>
                                <td>
                                    <input type="text" name="mrtg_user[]" class="form-control mrtg_user"
                                        autocomplete="off" value="{{ $line->mrtg_user }}">
                                </td>
                                <td>
                                    <input type="text" name="mrtg_pass[]" class="form-control mrtg_pass"
                                        autocomplete="off" value="{{ $line->mrtg_pass }}">
                                </td>
                                @if ($loop->first)
                                    <td>
                                        <button type="button"
                                            class="btn btn-success btn-sm fa fa-plus add-internet-service-row"></button>
                                    </td>
                                @else
                                    <td>
                                        <button type="button"
                                            class="btn btn-danger btn-sm fa fa-minus remove-internet-service-row"></button>
                                    </td>
                                @endif
                            </tr>
                        @empty
                        @endforelse
                    @endif
                </tbody>
            </table>

            <h5 class="text-center p-2">Bandwidth Distribution</h5>

            <table class="table table-bordered" id="bandwidth_distribution">
                <thead>
                    <tr>
                        <th> IP Address</th>
                        <th> Bandwidth</th>
                        <th> Remarks </th>
                        <th> Action </th>
                    </tr>
                </thead>
                @php
                    $ip_address = $is_old ? old('ip_address') : (!empty($logicalConnectivityInternet) ? $logicalConnectivityInternet->bandwidths->pluck('ip.id') : null);
                @endphp
                <tbody>
                    @if (!empty($logicalConnectivityInternet))
                        @forelse ($logicalConnectivityBandwidths as $key => $bandwidth)
                            <tr>
                                <td>
                                    <select name="ip_address[]" class="form-control select2" required>
                                        <option value="" slected disable>Select IP Address</option>
                                        @foreach ($ips as $ip)
                                            <option value="{{ $ip->id }}" @selected($ip_address[$key] == $ip->id)>
                                                {{ $ip->address }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="bandwidth[]" class="form-control bandwidth"
                                        autocomplete="off" value="{{ $bandwidth->bandwidth }}">
                                </td>
                                <td>
                                    <input type="text" name="remarks[]" class="form-control remarks"
                                        autocomplete="off" value="{{ $bandwidth->remarks }}">
                                </td>
                                @if ($loop->first)
                                    <td>
                                        <button type="button"
                                            class="btn btn-success btn-sm fa fa-plus add-bandwidth-distribution-row"></button>
                                    </td>
                                @else
                                    <td>
                                        <button type="button"
                                            class="btn btn-danger btn-sm fa fa-minus remove-bandwidth-distribution-row"></button>
                                    </td>
                                @endif
                            </tr>
                        @empty
                        @endforelse
                    @endif
                </tbody>
            </table>

            <hr>

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
                    @forelse (@$physicalConnectivityData?->lines as $key => $line)
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
                                <input type="text" name="bbts_link_id[]" class="form-control bbts_link_id" autocomplete="off"
                                    value="{{ $line->bbts_link_id }}" readonly>
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

            <hr>

            <div class="row mt-4">
                <div class="form-group col-1">
                    <label for="total_bandwidth">&nbsp;</label>
                    <div class="client_name">
                        <div class="checkbox-fade fade-in-primary">
                            <label>
                                <input type="checkbox" name="dns_checkbox" name='dns_checkbox' value="dns"
                                    class="dns_checkbox" @checked(!empty($logicalConnectivityInternet) ? in_array('dns', $facilityTypes) : false)
                                    onclick="checkboxChange1(this, dns_input_fields)">
                                <span class="cr">
                                    <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                </span>
                                <span class="font-weight-bold">DNS</span>
                            </label>
                        </div>
                    </div>
                </div>
                    <div class="form-group col-2 dns_domain input-field-1 d-none">
                        <label for="dns_domain">Domain Name</label>
                        <input type="text" class="form-control" name="dns_domain" aria-describedby="dns_domain" disabled
                            id="dns_domain"
                            value="{{ old('dns_domain') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->dns_domain : '') }}">
                    </div>
    
                    <div class="form-group col-2 dns_mx_record input-field-1 d-none">
                        <label for="dns_mx_record">Mx Record</label>
                        <input type="text" class="form-control" name="dns_mx_record" aria-describedby="dns_mx_record"
                            value="{{ old('dns_mx_record') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->dns_mx_record : '') }}"
                            disabled id="dns_mx_record">
                    </div>
    
                    <div class="form-group col-2 dns_a_record input-field-1 d-none">
                        <label for="dns_a_record">A Record</label>
                        <input type="text" class="form-control" name="dns_a_record" aria-describedby="dns_a_record"
                            value="{{ old('dns_a_record') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->dns_a_record : '') }}"
                            disabled id="dns_a_record">
                    </div>
    
                    <div class="form-group col-2 dns_reverse_record input-field-1 d-none">
                        <label for="dns_reverse_record">Reverse Record</label>
                        <input type="text" class="form-control" name="dns_reverse_record"
                            aria-describedby="dns_reverse_record" disabled
                            value="{{ old('dns_reverse_record') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->dns_reverse_record : '') }}"
                            id="dns_reverse_record">
                    </div>
    
                    <div class="form-group col-2 dns_ip_address input-field-1 d-none">
                        <label for="dns_ip_address">IP Address</label>
                        <input type="text" class="form-control" name="dns_ip_address" aria-describedby="dns_ip_address"
                            value="{{ old('dns_ip_address') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->dns_ip_address : '') }}"
                            disabled id="dns_ip_address">
                    </div>

            </div>

            <hr>

            <div class="row">
                <div class="form-group col-1">
                    <label for="total_bandwidth">&nbsp;</label>
                    <div class="client_name">
                        <div class="checkbox-fade fade-in-primary">
                            <label>
                                <input type="checkbox" name="smtp_checkbox" name='smtp_checkbox' value="smtp"
                                    class="smtp_checkbox" @checked(!empty($logicalConnectivityInternet) ? in_array('smtp', $facilityTypes) : false)
                                    onclick="checkboxChange2(this, smtp_input_fields)">
                                <span class="cr">
                                    <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                </span>
                                <span class="font-weight-bold">SMTP</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group col-2 smtp_domain input-field-2 d-none">
                    <label for="smtp_domain">Domain Name</label>
                    <input type="text" class="form-control" name="smtp_domain" aria-describedby="smtp_domain"
                        value="{{ old('smtp_domain') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->smtp_domain : '') }}"
                        disabled id="smtp_domain">
                </div>

                <div class="form-group col-2 smtp_server input-field-2 d-none">
                    <label for="smtp_server">Server Name</label>
                    <input type="text" class="form-control" name="smtp_server" aria-describedby="smtp_server"
                        value="{{ old('smtp_server') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->smtp_server : '') }}"
                        disabled id="smtp_server">
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="form-group col-1">
                    <label for="total_bandwidth">&nbsp;</label>
                    <div class="client_name">
                        <div class="checkbox-fade fade-in-primary">
                            <label>
                                <input type="checkbox" name="vpn_checkbox" name='vpn_checkbox' value="vpn"
                                    class="vpn_checkbox" @checked(!empty($logicalConnectivityInternet) ? in_array('vpn', $facilityTypes) : false)
                                    onclick="checkboxChange3(this, vpn_input_fields)">
                                <span class="cr">
                                    <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                </span>
                                <span class="font-weight-bold">VPN</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group col-2 vpn_purpose input-field-3 d-none">
                    <label for="vpn_purpose">Purpose Of Using VPN</label>
                    <input type="text" class="form-control" name="vpn_purpose" aria-describedby="vpn_purpose"
                        value="{{ old('vpn_purpose') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->vpn_purpose : '') }}"
                        disabled id="vpn_purpose">
                </div>

                <div class="form-group col-2 vpn_source_ip input-field-3 d-none">
                    <label for="vpn_source_ip">Source IP</label>
                    <input type="text" class="form-control" name="vpn_source_ip" aria-describedby="vpn_source_ip"
                        value="{{ old('vpn_source_ip') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->vpn_source_ip : '') }}"
                        disabled id="vpn_source_ip">
                </div>

                <div class="form-group col-2 vpn_destination_ip input-field-3 d-none">
                    <label for="vpn_destination_ip">Destination IP</label>
                    <input type="text" class="form-control" name="vpn_destination_ip"
                        aria-describedby="vpn_destination_ip" disabled
                        value="{{ old('vpn_destination_ip') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->vpn_destination_ip : '') }}"
                        id="vpn_destination_ip">
                </div>

                <div class="form-group col-2 vpn_bandwidth input-field-3 d-none">
                    <label for="vpn_bandwidth">VPN Bandwidth (Mbps)</label>
                    <input type="text" class="form-control" name="vpn_bandwidth" aria-describedby="vpn_bandwidth"
                        value="{{ old('vpn_bandwidth') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->vpn_bandwidth : '') }}"
                        disabled id="vpn_bandwidth">
                </div>

                <div class="form-group col-2 vpn_iig_name input-field-3 d-none">
                    <label for="vpn_iig_name">IIG Name</label>
                    <input type="text" class="form-control" name="vpn_iig_name" aria-describedby="vpn_iig_name"
                        value="{{ old('vpn_iig_name') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->vpn_iig_name : '') }}"
                        disabled id="vpn_iig_name">
                </div>

                <div class="form-group offset-md-1 col-2 vpn_tunnel_active_date input-field-3 d-none">
                    <label for="vpn_tunnel_active_date">VPN Tunnel Active Date</label>
                    <input type="text" class="form-control date" name="vpn_tunnel_active_date"
                        aria-describedby="vpn_tunnel_active_date" disabled
                        value="{{ old('vpn_tunnel_active_date') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->vpn_tunnel_active_date : '') }}"
                        id="vpn_tunnel_active_date">
                </div>

                <div class="form-group col-2 vpn_submission_date input-field-3 d-none">
                    <label for="vpn_submission_date">Submission Date</label>
                    <input type="text" class="form-control date" name="vpn_submission_date"
                        aria-describedby="vpn_submission_date" disabled
                        value="{{ old('vpn_submission_date') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->vpn_submission_date : '') }}"
                        id="vpn_submission_date">
                </div>

                <div class="form-group col-2 vpn_remarks input-field-3 d-none">
                    <label for="vpn_remarks">Remarks</label>
                    <input type="text" class="form-control" name="vpn_remarks" aria-describedby="vpn_remarks"
                        value="{{ old('vpn_remarks') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->vpn_remarks : '') }}"
                        disabled id="vpn_remarks">
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="form-group col-1">
                    <label for="total_bandwidth">&nbsp;</label>
                    <div class="client_name">
                        <div class="checkbox-fade fade-in-primary">
                            <label>
                                <input type="checkbox" name="vc_checkbox" name='vc_checkbox' value="vc"
                                    class="vc_checkbox" @checked(!empty($logicalConnectivityInternet) ? in_array('vc', $facilityTypes) : false)
                                    onclick="checkboxChange4(this, vc_input_fields)">
                                <span class="cr">
                                    <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                </span>
                                <span class="font-weight-bold">VC</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group col-2 vc_issued_date input-field-4 d-none">
                    <label for="vc_issued_date">Issued Date</label>
                    <input type="text" class="form-control date" name="vc_issued_date"
                        aria-describedby="vc_issued_date" disabled
                        value="{{ old('vc_issued_date') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->vc_issued_date : '') }}"
                        id="vc_issued_date">
                </div>

                <div class="form-group col-2 vc_source_ip input-field-4 d-none">
                    <label for="vc_source_ip">Source IP</label>
                    <input type="text" class="form-control" name="vc_source_ip" aria-describedby="vc_source_ip"
                        value="{{ old('vc_source_ip') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->vc_source_ip : '') }}"
                        disabled id="vc_source_ip">
                </div>

                <div class="form-group col-2 vc_destination_ip input-field-4 d-none">
                    <label for="vc_destination_ip">Destination IP</label>
                    <input type="text" class="form-control" name="vc_destination_ip"
                        aria-describedby="vc_destination_ip" disabled
                        value="{{ old('vc_destination_ip') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->vc_destination_ip : '') }}"
                        id="vc_destination_ip">
                </div>

                <div class="form-group col-2 vc_iig_name input-field-4 d-none">
                    <label for="vc_iig_name">IIG Name</label>
                    <input type="text" class="form-control" name="vc_iig_name" aria-describedby="vc_iig_name"
                        value="{{ old('vc_iig_name') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->vc_iig_name : '') }}"
                        disabled id="vc_iig_name">
                </div>

                <div class="form-group col-2 vc_itc_name input-field-4 d-none">
                    <label for="vc_itc_name">ITC Name</label>
                    <input type="text" class="form-control" name="vc_itc_name" aria-describedby="vc_itc_name"
                        value="{{ old('vc_itc_name') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->vc_itc_name : '') }}"
                        disabled id="vc_itc_name">
                </div>

                <div class="form-group offset-md-1 col-2 vc_renewal_date input-field-4 d-none">
                    <label for="vc_renewal_date">Renewal Date</label>
                    <input type="text" class="form-control date" name="vc_renewal_date"
                        aria-describedby="vc_renewal_date" disabled
                        value="{{ old('vc_renewal_date') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->vc_renewal_date : '') }}"
                        id="vc_renewal_date">
                </div>

                <div class="form-group col-2 vc_remarks input-field-4 d-none">
                    <label for="vc_remarks">Remarks</label>
                    <input type="text" class="form-control" name="vc_remarks" aria-describedby="vc_remarks" disabled
                        value="{{ old('vc_remarks') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->vc_remarks : '') }}"
                        id="vc_remarks">
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="form-group col-1">
                    <label for="total_bandwidth">&nbsp;</label>
                    <div class="client_name">
                        <div class="checkbox-fade fade-in-primary">
                            <label>
                                <input type="checkbox" name="bgp_checkbox" name='bgp_checkbox' value="bgp"
                                    class="bgp_checkbox" @checked(!empty($logicalConnectivityInternet) ? in_array('bgp', $facilityTypes) : false)
                                    onclick="checkboxChange5(this, bgp_input_fields)">
                                <span class="cr">
                                    <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                </span>
                                <span class="font-weight-bold">BGP</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group col-2 bgp_primary_peering input-field-5 d-none">
                    <label for="bgp_primary_peering">Primary Peering</label>
                    <input type="text" class="form-control" name="bgp_primary_peering"
                        aria-describedby="bgp_primary_peering" disabled
                        value="{{ old('bgp_primary_peering') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->bgp_primary_peering : '') }}"
                        id="bgp_primary_peering">
                </div>

                <div class="form-group col-2 bgp_secondary_peering input-field-5 d-none">
                    <label for="bgp_secondary_peering">Secondary Peering</label>
                    <input type="text" class="form-control" name="bgp_secondary_peering"
                        aria-describedby="bgp_secondary_peering" disabled
                        value="{{ old('bgp_secondary_peering') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->bgp_secondary_peering : '') }}"
                        id="bgp_secondary_peering">
                </div>

                <div class="form-group col-2 bgp_client_prefix input-field-5 d-none">
                    <label for="bgp_client_prefix">Client Prefix</label>
                    <input type="text" class="form-control" name="bgp_client_prefix"
                        aria-describedby="bgp_client_prefix" disabled
                        value="{{ old('bgp_client_prefix') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->bgp_client_prefix : '') }}"
                        id="bgp_client_prefix">
                </div>

                <div class="form-group col-2 bgp_client_as input-field-5 d-none">
                    <label for="bgp_client_as">Client As</label>
                    <input type="text" class="form-control" name="bgp_client_as" aria-describedby="bgp_client_as"
                        value="{{ old('bgp_client_as') ?? (!empty($logicalConnectivityInternet) ? $clientFacility->bgp_client_as : '') }}"
                        disabled id="bgp_client_as">
                </div>
            </div>         

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
    @include('networking::logical-internet-connectivities.js')
@endsection
