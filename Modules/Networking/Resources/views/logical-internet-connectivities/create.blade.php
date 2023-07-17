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
@endphp

@section('breadcrumb-title')
    @if (!empty($logicalConnectivityInternet))
        Edit
    @else
        Create
    @endif
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
    <a href="{{ route('logical-data-connectivities.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
    <div class="">
        <form action="{{ route('logical-data-connectivities.store') }}" method="post" class="custom-form">
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
                    <label for="select2">Connectivity Point And FR</label>
                    <input type="text" class="form-control" id="connectivity_point1" name="connectivity_point1"
                        aria-describedby="connectivity_point1"
                        value="{{ $physicalConnectivityData->connectivity_point . '_' . $physicalConnectivityData->fr_no }}"
                        readonly>
                    <input type="hidden" name="fr_no" id="fr_no" value="{{ $physicalConnectivityData->fr_no }}">
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
                            <input class="" type="radio" name="shared_type" id="dedicatedRadio"
                                value="dedicated" required>
                            <label class="form-check-label" for="dedicatedRadio">Dedicated</label>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="">
                            <input class="" type="radio" name="shared_type" id="sharedRadio"
                                value="shared" required>
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
                                            <option value="{{ $data->product->id }}" @selected($line->product_id)>
                                                {{ $data->product->name }}</option>
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
                                            class="btn btn-success btn-sm fa fa-plus add-data-service-row"></button>
                                    </td>
                                @else
                                    <td>
                                        <button type="button"
                                            class="btn btn-danger btn-sm fa fa-minus remove-data-service-row"></button>
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
                <tbody>
                    @if (!empty($logicalConnectivityInternet))
                        @forelse ($logicalConnectivityBandwidth?->lines as $key => $line)
                            <tr>
                                <td>
                                    <input type="text" name="ip_address[]" class="form-control ip_address"
                                        autocomplete="off" value="{{ $line->ip_address }}">
                                </td>
                                <td>
                                    <input type="text" name="bandwidth[]" class="form-control bandwidth"
                                        autocomplete="off" value="{{ $line->bandwidth }}">
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
    @include('networking::logical-internet-connectivities.js')
@endsection
