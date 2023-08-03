@extends('layouts.backend-layout')
@section('title', 'Logical Connectivity')

@php
    $is_old = old('comment') ? true : false;
    $form_heading = !empty($logicalConnectivityVas) ? 'Update' : 'Add';
    $form_url = !empty($logicalConnectivityVas) ? route('errs.update', $logicalConnectivityVas->id) : route('errs.store');
    $form_method = !empty($logicalConnectivityVas) ? 'PUT' : 'POST';
    
    $comment = $is_old ? old('comment') : @$logicalConnectivityVas->comment;
    $quantity = $is_old ? old('quantity') : (!empty($logicalConnectivityVas) ? $logicalConnectivityVas->lines->pluck('quantity') : null);
    $remarks = $is_old ? old('remarks') : (!empty($logicalConnectivityVas) ? $logicalConnectivityVas->lines->pluck('remarks') : null);
    
    $sale_id = old('sale_id', !empty($physicalConnectivity) ? $physicalConnectivity->sale_id : request()->sale_id);
@endphp

@section('breadcrumb-title')
    @if (!empty($logicalConnectivityVas))
        Edit
    @else
        Create
    @endif
    Logical Connectivity For VAS Service
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
    <a href="{{ route('logical-vas-connectivities.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
    <div class="">
        <form action="{{ route('logical-vas-connectivities.store') }}" method="post" class="custom-form">
            @csrf

            <div class="row">
                <input type="hidden" name="sale_id" id="sale_id" value="{{ $sale_id }}">
                <div class="form-group col-3 client_name">
                    <label for="client_name">Client Name:</label>
                    <input type="text" class="form-control" id="client_name" aria-describedby="client_name"
                        name="client_name" value="{{ $saleDetalis->client->client_name }}" readonly>
                    <input type="hidden" name="client_no" id="client_no" value="{{ $physicalConnectivityVas->client_no }}">
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
                        value="{{ $physicalConnectivityVas->connectivity_point . '_' . $physicalConnectivityVas->fr_no }}"
                        readonly>
                    <input type="hidden" name="fr_no" id="fr_no" value="{{ $physicalConnectivityVas->fr_no }}">
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
                    @if (!empty($vasServices))
                        @foreach ($vasServices->lines as $key => $line)
                            <tr>
                                <td>
                                    <input type="text" name="product_name[]" class="form-control product_name"
                                        value="{{ $line->product->name }}" readonly>

                                    <input type="hidden" name="product_id[]" class="form-control product_id"
                                        value="{{ $line->product_id }}">
                                </td>
                                <td>
                                    <input type="text" name="description[]" class="form-control description"
                                        value="{{ $line->description }}" readonly>
                                </td>
                                <td>
                                    <input type="number" name="quantity[]" class="form-control quantity"
                                        autocomplete="off" value="{{ @$quantity[$key] }}">
                                </td>
                                <td>
                                    <input type="text" name="remarks[]" class="form-control remarks"
                                        autocomplete="off" value="{{ @$remarks[$key] }}">
                                </td>
                            </tr>
                        @endforeach
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
                    @foreach ($physicalConnectivityVas->lines as $key => $line)
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
