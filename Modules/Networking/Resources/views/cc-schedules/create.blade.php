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
    <a href="{{ route('logical-internet-connectivities.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
    <div class="">
        <form action="{{ route('cc-schedules.store') }}" method="post" class="custom-form">
            @csrf

            <div class="row">
                <div class="form-group col-3 client_no">
                    <label for="client_no">Client No:</label>
                    <input type="text" class="form-control" id="client_no" aria-describedby="client_no"
                        name="client_no" value="{{ $salesDetails->client->client_no }}" readonly>
                </div>

                <div class="form-group col-3 client_name">
                    <label for="client_name">Client Name:</label>
                    <input type="text" class="form-control" id="client_name" aria-describedby="client_name"
                        name="client_name" value="{{ $salesDetails->client->client_name }}" readonly>
                </div>

                <div class="form-group col-3 connectivity_point1">
                    <label for="select2">FR No and Connectivity Point</label>
                    <input type="text" class="form-control" id="connectivity_point1" name="connectivity_point1"
                        aria-describedby="connectivity_point1"
                        value="{{ $salesDetails->fr_no . '(' . $salesDetails->frDetails->connectivity_point . ')' }}"
                        readonly>
                    <input type="hidden" name="fr_no" id="fr_no" value="{{ $salesDetails->fr_no }}">
                </div>

                <div class="form-group col-3 delivery_date">
                    <label for="delivery_date">Delivery Date:</label>
                    <input type="text" class="form-control" id="delivery_date" name="delivery_date"
                        aria-describedby="delivery_date" readonly value="{{ $salesDetails->delivery_date }}">
                </div>
            </div>

            <hr>

            <div class="row mt-4">
                <div class="form-group col-2 mt-2">
                    <label>
                        <span class="font-weight-bold">PNL</span>
                    </label>
                </div>
                <div class="form-group col-2 approval_date">
                    <input type="text" class="form-control" name="approval_date" aria-describedby="approval_date"
                        id="approval_date" value="{{ !empty($salesDetails) ? $salesDetails->sale->approval_date : '' }}"
                        readonly>
                </div>
            </div>

            @php
                $client_readyness_date;
            @endphp

            <div class="row">
                <div class="form-group col-2 mt-2">
                    <div class="checkbox-fade fade-in-primary">
                        <label>
                            <input type="checkbox" name="cr_checkbox" value="cr" class="cr_checkbox"
                                @checked(!empty($logicalConnectivityInternet) ? in_array('cr', $facilityTypes) : false)>
                            <span class="cr">
                                <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                            </span>
                            <span class="font-weight-bold">Client Readyness</span>
                        </label>
                    </div>
                </div>
                <div class="form-group col-2 client_readyness_date">
                    <input type="text" class="form-control date" name="client_readyness_date" id="client_readyness_date"
                        value="">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-2 mt-2">
                    <div class="checkbox-fade fade-in-primary">
                        <label>
                            <input type="checkbox" name="nttn_checkbox" class="nttn_checkbox" value="nttn" 
                                @checked(!empty($logicalConnectivityInternet) ? in_array('nttn', $facilityTypes) : false)>
                            <span class="cr">
                                <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                            </span>
                            <span class="font-weight-bold">NTTN/Service</span>
                        </label>
                    </div>
                </div>
                <div class="form-group col-2 nttn_date">
                    <input type="text" class="form-control date" name="nttn_date" id="nttn_date" value="">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-2 mt-2">
                    <div class="checkbox-fade fade-in-primary">
                        <label>
                            <input type="checkbox" name="er_checkbox" value="er" class="er_checkbox"
                                @checked(!empty($logicalConnectivityInternet) ? in_array('er', $facilityTypes) : false)>
                            <span class="cr">
                                <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                            </span>
                            <span class="font-weight-bold">Equipment Readyness</span>
                        </label>
                    </div>
                </div>
                <div class="form-group col-2 equipment_readyness_date">
                    <input type="text" class="form-control date" name="equipment_readyness_date"
                        id="equipment_readyness_date" value="">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-2 mt-2">
                    <div class="checkbox-fade fade-in-primary">
                        <label>
                            <input type="checkbox" name="fo_checkbox" value="fo" class="fo_checkbox"
                                @checked(!empty($logicalConnectivityInternet) ? in_array('fo', $facilityTypes) : false)>
                            <span class="cr">
                                <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                            </span>
                            <span class="font-weight-bold">Client Readyness</span>
                        </label>
                    </div>
                </div>
                <div class="form-group col-2 field_operation_date">
                    <input type="text" class="form-control date" name="field_operation_date"
                        id="field_operation_date" value="">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-2 mt-2">
                    <div class="checkbox-fade fade-in-primary">
                        <label>
                            <input type="checkbox" name="schedule_checkbox" class="schedule_checkbox" value="schedule"
                                @checked(!empty($logicalConnectivityInternet) ? in_array('schedule', $facilityTypes) : false)>
                            <span class="cr">
                                <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                            </span>
                            <span class="font-weight-bold">Schedule Date</span>
                        </label>
                    </div>
                </div>
                <div class="form-group col-2 schedule_date">
                    <input type="text" class="form-control date" name="schedule_date"
                        id="schedule_date" value="">
                </div>
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
