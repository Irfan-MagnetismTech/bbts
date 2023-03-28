@extends('layouts.backend-layout')
@section('title', 'Follow Up')

@php
$is_old = old('activity_date') ? true : false;
$form_heading = !empty($followup->id) ? 'Update' : 'Add';
$form_url = !empty($followup->id) ? route('followup.update', $followup->id) : route('followup.store');
$form_method = !empty($followup->id) ? 'PUT' : 'POST';
@endphp

@section('breadcrumb-title')
{{ ucfirst($form_heading) }} Follow Up
@endsection

@section('breadcrumb-button')
<a href="{{ route('followup.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
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
<style>
    .custom-form .input-group-addon {
        min-width: 130px !important;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="tableHeading">
                <h5> <span> &#10070; </span> Follow Up <span>&#10070;</span> </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @php
                    $activity_date = $is_old ? old('activity_date') : (!empty($followup->activity_date) ? $followup->activity_date : date('Y-m-d'));
                    $work_start_time = $is_old ? old('work_start_time') : (!empty($followup->work_start_time) ? $followup->work_start_time : null);
                    $work_end_time = $is_old ? old('work_end_time') : (!empty($followup->work_end_time) ? $followup->work_end_time : null);
                    $work_nature_type = $is_old ? old('work_nature_type') : (!empty($followup->work_nature_type) ? $followup->work_nature_type : null);
                    $sales_type = $is_old ? old('sales_type') : (!empty($followup->sales_type) ? $followup->sales_type : null);
                    $client_id = $is_old ? old('client_id') : (!empty($followup->client_id) ? $followup->client_id : null);
                    $address = $is_old ? old('address') : (!empty($followup->client->address) ? $followup->client->address : null);
                    $potentility_amount = $is_old ? old('potentility_amount') : (!empty($followup->potentility_amount) ? $followup->potentility_amount : null);
                    $meeting_outcome = $is_old ? old('meeting_outcome') : (!empty($followup->meeting_outcome) ? $followup->meeting_outcome : null);
                    $client_type = $is_old ? old('client_type') : (!empty($followup->client_type) ? $followup->client_type : null);
                    @endphp
                    <div class="col-xl-4 col-md-4">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="activity_date">Date of Activity Report<span class="text-danger">*</span></label>
                            {{ Form::date('activity_date', $activity_date, ['class' => 'form-control', 'id' => 'activity_date', 'autocomplete' => 'off', 'placeholder' => 'Activity Date', 'required']) }}
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="work_end_time">Work Start Time<span class="text-danger">*</span></label>
                            {{ Form::time('work_start_time', $work_start_time, ['class' => 'form-control', 'id' => 'work_start_time', 'autocomplete' => 'off', 'placeholder' => 'Work Start Time', 'required']) }}
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="work_end_time">Work End Time<span class="text-danger">*</span></label>
                            {{ Form::time('work_end_time', $work_end_time, ['class' => 'form-control', 'id' => 'work_end_time', 'autocomplete' => 'off', 'placeholder' => 'Work End Time', 'required']) }}
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="work_nature_type">Client Type<span class="text-danger">*</span></label>
                            {{ Form::select('client_type', ['' => 'Select Work Nature Type', 'Existing' => 'Existing', 'New' => 'New'], $client_type, ['class' => 'form-control', 'id' => 'client_type', 'autocomplete' => 'off', 'placeholder' => 'Client Type', 'required']) }}
                            @if ($errors->has('client_type'))
                            <span class="text-danger">{{ $errors->first('client_type') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="work_nature_type">Work Nature Type<span class="text-danger">*</span></label>
                            <select class="form-control" name="work_nature_type">
                                @if(!empty($work_nature_types))
                                @foreach($work_nature_types as $nature_type)
                                <option value="{{ $nature_type }}" {{ $nature_type == $work_nature_type ? 'selected' : '' }}>{{ $nature_type }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="sales_type">Types of Sales Call<span class="text-danger">*</span></label>
                            <select class="form-control" name="sales_type">
                                @if(!empty($sale_types))
                                @foreach($sale_types as $type)
                                <option value="{{ $type }}" {{ $type == $sales_type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="client_name">Client Name<span class="text-danger">*</span></label>
                            <select class="form-control" name="client_id" id="client_id">
                                <option value="">Select Client</option>
                                @if(!empty($clients))
                                @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ $client->id == $client_id ? 'selected' : '' }}>{{ $client->client_name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="address">Address<span class="text-danger">*</span></label>
                            {{ Form::text('address', $address, ['class' => 'form-control', 'id' => 'address', 'autocomplete' => 'off', 'placeholder' => 'Address', 'required']) }}
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="potentility_amount">Potentility Amount<span class="text-danger">*</span></label>
                            {{ Form::text('potentility_amount', $potentility_amount, ['class' => 'form-control', 'id' => 'potentility_amount', 'autocomplete' => 'off', 'placeholder' => 'Potentility Amount', 'required']) }}
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="meeting_outcome">Meeting Outcome<span class="text-danger">*</span></label>
                            {{ Form::text('meeting_outcome', $meeting_outcome, ['class' => 'form-control', 'id' => 'meeting_outcome', 'autocomplete' => 'off', 'placeholder' => 'Meeting Outcome', 'required']) }}
                        </div>
                        {{ Form::hidden('meeting_id', $meeting_id) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="mt-2 offset-md-4 col-md-4">
            <div class="input-group input-group-sm ">
                <button class="py-2 btn btn-success ">{{ !empty($meeting->id) ? 'Update' : 'Save'; }}</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    @endsection

    @section('script')
    <script>
        $('#client_id').on('change', function() {
            var client_id = $(this).val();
            var clients = JSON.parse('{!! json_encode($clients) !!}');
            var client = clients.find(client => client.id == client_id);
            console.log('client', client)
            $('#address').val(client.address);
        })
    </script>

    @endsection