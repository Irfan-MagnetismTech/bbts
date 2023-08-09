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
                                <input type="text" name="client_id" id="client_id" class="form-control" value="">
                                <label for="client_id">Client ID <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="client_name" id="client_name" class="form-control"
                                    value="" readonly>
                                <label for="client_name">Client Name <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="name_of_the_link" id="name_of_the_link" class="form-control" value="">
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
                                <input type="text" name="mq_id" id="mq_id" class="form-control" value="">
                                <label for="mq_id">MQ ID<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="fr_id" id="fr_id" class="form-control"
                                    value="" readonly>
                                <label for="fr_id">FR ID<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="client_gps" id="client_gps" class="form-control" value="">
                                <label for="client_gps">Client GPS<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="requirement" id="requirement" class="form-control"
                                    value="">
                                <label for="requirement">Requirement<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="division" id="division" class="form-control" value="">
                                <label for="division">Division<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="district" id="district" class="form-control"
                                    value="" readonly>
                                <label for="district">District<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="thana" id="thana" class="form-control" value="">
                                <label for="thana">Thana<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="location" id="location" class="form-control"
                                    value="">
                                <label for="location">Location<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="surevey_attached" id="surevey_attached" class="form-control" value="">
                                <label for="surevey_attached">Survey Attached<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="contact_name" id="contact_name" class="form-control"
                                    value="" readonly>
                                <label for="contact_name">Contact Name <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="designation" id="designation" class="form-control" value="">
                                <label for="designation">Designation <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="contact_no" id="contact_no" class="form-control"
                                    value="">
                                <label for="contact_no">Contact No<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <select name="remarks" id="remarks" class="form-control">
                                    <option value="">Select FR No</option>
                                </select>
                                <label for="remarks">Remarks <span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" name="change_type[]" value="Temporary-Inactive">
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span>Method Change</span>
                                </label>
                            </div>
                            <div class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" name="change_type[]" value="Permanent Inactive">
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span>Redundant Link</span>
                                </label>
                            </div>
                            <div class="checkbox-fade fade-in-primary">
                                <label>
                                    <input type="checkbox" name="change_type[]" value="Re-Inactive">
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span>Shifting</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    {{-- create a responsive table --}}
                    <div class="row">
                        <div class="col-6">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <th>Product/Service</th>
                                        <th>Quantity</th>
                                        <th>Unit</th>
                                        <th>Price</th>
                                        <th>Total Price</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="product_name[][]" class="form-control text-center"
                                                        id="service_name" readonly value="">
                                                    <input type="hidden" name="product_id[][]" class="form-control text-center"
                                                        id="service" readonly value="">
                                                </div>
                                            </td>
                                            <td> 
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="quantity[][]" class="form-control text-right"
                                                        id="quantity" readonly value="">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="unit[][]" class="form-control text-center"
                                                        id="unit" readonly value="">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="rate[][]"
                                                        class="form-control text-right" readonly value="">
                                                </div>
                                            </td>
                                            <td class="d-none">
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="price[][]"
                                                        class="form-control text-right" readonly value="">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="total_price[][]"
                                                        class="form-control text-right" readonly value="">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="product_name[][]" class="form-control text-center"
                                                        id="service_name" readonly value="">
                                                    <input type="hidden" name="product_id[][]" class="form-control text-center"
                                                        id="service" readonly value="">
                                                </div>
                                            </td>
                                            <td> 
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="quantity[][]" class="form-control text-right"
                                                        id="quantity" readonly value="">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="unit[][]" class="form-control text-center"
                                                        id="unit" readonly value="">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="rate[][]"
                                                        class="form-control text-right" readonly value="">
                                                </div>
                                            </td>
                                            <td class="d-none">
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="price[][]"
                                                        class="form-control text-right" readonly value="">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="total_price[][]"
                                                        class="form-control text-right" readonly value="">
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <th>Product/Service</th>
                                        <th>Quantity</th>
                                        <th>Unit</th>
                                        <th>Price</th>
                                        <th>Total Price</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="product_name[][]" class="form-control text-center"
                                                        id="service_name" readonly value="">
                                                    <input type="hidden" name="product_id[][]" class="form-control text-center"
                                                        id="service" readonly value="">
                                                </div>
                                            </td>
                                            <td> 
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="quantity[][]" class="form-control text-right"
                                                        id="quantity" readonly value="">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="unit[][]" class="form-control text-center"
                                                        id="unit" readonly value="">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="rate[][]"
                                                        class="form-control text-right" readonly value="">
                                                </div>
                                            </td>
                                            <td class="d-none">
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="price[][]"
                                                        class="form-control text-right" readonly value="">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="total_price[][]"
                                                        class="form-control text-right" readonly value="">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="product_name[][]" class="form-control text-center"
                                                        id="service_name" readonly value="">
                                                    <input type="hidden" name="product_id[][]" class="form-control text-center"
                                                        id="service" readonly value="">
                                                </div>
                                            </td>
                                            <td> 
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="quantity[][]" class="form-control text-right"
                                                        id="quantity" readonly value="">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="unit[][]" class="form-control text-center"
                                                        id="unit" readonly value="">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="rate[][]"
                                                        class="form-control text-right" readonly value="">
                                                </div>
                                            </td>
                                            <td class="d-none">
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="price[][]"
                                                        class="form-control text-right" readonly value="">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="total_price[][]"
                                                        class="form-control text-right" readonly value="">
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <th>Product/Service</th>
                                <th>Quantity</th>
                                <th>Unit</th>
                                <th>Price</th>
                                <th>Total Price</th>
                                <th>Product/Service</th>
                                <th>Quantity</th>
                                <th>Unit</th>
                                <th>Price</th>
                                <th>Total Price</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="product_name" class="form-control text-center"
                                                id="service_name" readonly value="">
                                            <input type="hidden" name="product_id" class="form-control text-center"
                                                id="service" readonly value="">
                                        </div>
                                    </td>
                                    <td> 
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="quantity" class="form-control text-right"
                                                id="quantity" readonly value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="unit" class="form-control text-center"
                                                id="unit" readonly value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="rate"
                                                class="form-control text-right" readonly value="">
                                        </div>
                                    </td>
                                    <td class="d-none">
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="price"
                                                class="form-control text-right" readonly value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="total_price"
                                                class="form-control text-right" readonly value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="product_name" class="form-control text-center"
                                                id="service_name" readonly value="">
                                            <input type="hidden" name="product_id" class="form-control text-center"
                                                id="service" readonly value="">
                                        </div>
                                    </td>
                                    <td> 
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="quantity" class="form-control text-right"
                                                id="quantity" readonly value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="unit" class="form-control text-center"
                                                id="unit" readonly value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="rate"
                                                class="form-control text-right" readonly value="">
                                        </div>
                                    </td>
                                    <td class="d-none">
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="price"
                                                class="form-control text-right" readonly value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="total_price"
                                                class="form-control text-right" readonly value="">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="product_name" class="form-control text-center"
                                                id="service_name" readonly value="">
                                            <input type="hidden" name="product_id" class="form-control text-center"
                                                id="service" readonly value="">
                                        </div>
                                    </td>
                                    <td> 
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="quantity" class="form-control text-right"
                                                id="quantity" readonly value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="unit" class="form-control text-center"
                                                id="unit" readonly value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="rate"
                                                class="form-control text-right" readonly value="">
                                        </div>
                                    </td>
                                    <td class="d-none">
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="price"
                                                class="form-control text-right" readonly value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="total_price"
                                                class="form-control text-right" readonly value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="product_name" class="form-control text-center"
                                                id="service_name" readonly value="">
                                            <input type="hidden" name="product_id" class="form-control text-center"
                                                id="service" readonly value="">
                                        </div>
                                    </td>
                                    <td> 
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="quantity" class="form-control text-right"
                                                id="quantity" readonly value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="unit" class="form-control text-center"
                                                id="unit" readonly value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="rate"
                                                class="form-control text-right" readonly value="">
                                        </div>
                                    </td>
                                    <td class="d-none">
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="price"
                                                class="form-control text-right" readonly value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="total_price"
                                                class="form-control text-right" readonly value="">
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <th>Product/Service</th>
                                <th>Quantity</th>
                                <th>Unit</th>
                                <th>Price</th>
                                <th>Total Price</th>
                                <th>Product/Service</th>
                                <th>Quantity</th>
                                <th>Unit</th>
                                <th>Price</th>
                                <th>Total Price</th>
                                <th>Total Price</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="product_name" class="form-control text-center"
                                                id="service_name" readonly value="">
                                            <input type="hidden" name="product_id" class="form-control text-center"
                                                id="service" readonly value="">
                                        </div>
                                    </td>
                                    <td> 
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="quantity" class="form-control text-right"
                                                id="quantity" readonly value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="unit" class="form-control text-center"
                                                id="unit" readonly value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="rate"
                                                class="form-control text-right" readonly value="">
                                        </div>
                                    </td>
                                    <td class="d-none">
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="price"
                                                class="form-control text-right" readonly value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="total_price"
                                                class="form-control text-right" readonly value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="product_name" class="form-control text-center"
                                                id="service_name" readonly value="">
                                            <input type="hidden" name="product_id" class="form-control text-center"
                                                id="service" readonly value="">
                                        </div>
                                    </td>
                                    <td> 
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="quantity" class="form-control text-right"
                                                id="quantity" readonly value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="unit" class="form-control text-center"
                                                id="unit" readonly value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="rate"
                                                class="form-control text-right" readonly value="">
                                        </div>
                                    </td>
                                    <td class="d-none">
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="price"
                                                class="form-control text-right" readonly value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="total_price"
                                                class="form-control text-right" readonly value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="total_price"
                                                class="form-control text-right" readonly value="">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="product_name" class="form-control text-center"
                                                id="service_name" readonly value="">
                                            <input type="hidden" name="product_id" class="form-control text-center"
                                                id="service" readonly value="">
                                        </div>
                                    </td>
                                    <td> 
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="quantity" class="form-control text-right"
                                                id="quantity" readonly value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="unit" class="form-control text-center"
                                                id="unit" readonly value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="rate"
                                                class="form-control text-right" readonly value="">
                                        </div>
                                    </td>
                                    <td class="d-none">
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="price"
                                                class="form-control text-right" readonly value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="total_price"
                                                class="form-control text-right" readonly value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="product_name" class="form-control text-center"
                                                id="service_name" readonly value="">
                                            <input type="hidden" name="product_id" class="form-control text-center"
                                                id="service" readonly value="">
                                        </div>
                                    </td>
                                    <td> 
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="quantity" class="form-control text-right"
                                                id="quantity" readonly value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="unit" class="form-control text-center"
                                                id="unit" readonly value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="rate"
                                                class="form-control text-right" readonly value="">
                                        </div>
                                    </td>
                                    <td class="d-none">
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="price"
                                                class="form-control text-right" readonly value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="total_price"
                                                class="form-control text-right" readonly value="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="total_price"
                                                class="form-control text-right" readonly value="">
                                        </div>
                                    </td>
                                </tr>
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
                // let products;
                // $(document).on('change', '.category_id', function() {
                //     console.log('fine')
                //     var category_id = $(this).val();
                //     var row = $(this).closest('tr').find('.product_id');
                //     $.ajax({
                //         url: "{{ route('get-products') }}",
                //         data: {
                //             category_id: category_id,
                //             _token: "{{ csrf_token() }}"
                //         },
                //         success: function(data) {
                //             products = data;
                //             let html = '<option value="">Select Product</option>';
                //             $.each(data, function(key, value) {
                //                 html += '<option value="' + value.id + '">' + value.name + '</option>';
                //             });
                //             row.html(html);
                //         }
                //     });
                // });

                /* $(document).on('change', '.product_id', function() {
                    var product_id = $(this).val();
                    var row = $(this).closest('tr').find('.unit');
                    products.find(function(product) {
                        if (product.id == product_id) {
                            row.val(product.unit);
                        }
                    });
                }) */

                $('#addProductRow').on('click', function() {
                    addProductRow();
                });

                $('#addConnectivityRow').on('click', function() {
                    addConnectivityRow();
                });

                function addProductRow() {
                    $('.product_details_row').first().clone().appendTo('.productBody');
                    $('.product_details_row').last().find('input').val('');
                    $('.product_details_row').last().find('select').val('');
                };

                function addConnectivityRow() {
                    $('.connectivity_details_row').first().clone().appendTo('.connectivityBody');
                    $('.connectivity_details_row').last().find('input').val('');
                    $('.connectivity_details_row').last().find('select').val('');
                };

                $('#client_id').on('input', function() {
                    var client_id = $(this).val();
                    var html = '<option value="">Select Fr No</option>';
                    $(this).autocomplete({
                        source: function(request, response) {
                            $.ajax({
                                url: "{{ route('searchClient') }}",
                                data: {
                                    client_id: client_id,
                                    _token: "{{ csrf_token() }}"
                                },
                                success: function(data) {
                                    response(data);
                                }
                            });
                        },
                        select: function(event, ui) {
                            $('#client_id').val(ui.item.value).attr('value', ui.item.value);
                            $('#client_name').val(ui.item.label).attr('value', ui.item.label);
                            //foreach loop for fr no
                            $.each(ui.item.frDetails, function(key, value) {
                                html += '<option value="' + value + '">' + value +
                                    '</option>';
                            });
                            $('#fr_no').html(html);
                            return false;
                        }
                    });
                });

                $('#fr_no').on('change', function() {
                    var fr_no = $(this).val();
                    var client_no = $('#client_id').val();
                    $.ajax({
                        url: "{{ route('getLogicalConnectivityData') }}",
                        data: {
                            fr_no: fr_no,
                            client_no: client_no,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            $('#logical-table').html(data.logical_table_data);
                            $('#physical-table').html(data.physical_table_data);
                        }
                    });
                });


                $('#date, #activation_date').datepicker({
                    format: "dd-mm-yyyy",
                    autoclose: true,
                    todayHighlight: true,
                    showOtherMonths: true
                }).datepicker("setDate", new Date());
            </script>
        @endsection
