@extends('layouts.backend-layout')
@section('title', 'Client Meeting')

@php
$is_old = old('visit_date') ? true : false;
$form_heading = !empty($meeting->id) ? 'Update' : 'Add';
$form_url = !empty($meeting->id) ? route('meeting.update', $meeting->id) : route('meeting.store');
$form_method = !empty($meeting->id) ? 'PUT' : 'POST';
@endphp

@section('breadcrumb-title')
{{ ucfirst($form_heading) }} Client Meeting
@endsection

@section('breadcrumb-button')
<a href="{{ route('meeting.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
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
                <h5> <span> &#10070; </span> Client Meeting <span>&#10070;</span> </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @php
                    $visit_date = $is_old ? old('visit_date') : (!empty($meeting->visit_date) ? $meeting->visit_date : null);
                    $sales_representative = $is_old ? old('sales_representative') : (!empty($meeting->sales_representative) ? $meeting->sales_representative : null);
                    $meeting_start_time = $is_old ? old('meeting_start_time') : (!empty($meeting->meeting_start_time) ? $meeting->meeting_start_time : null);
                    $meeting_end_time = $is_old ? old('meeting_end_time') : (!empty($meeting->meeting_end_time) ? $meeting->meeting_end_time : null);
                    $client_id = $is_old ? old('client_id') : (!empty($meeting->client_id) ? $meeting->client_id : null);
                    $contact_person = $is_old ? old('contact_person') : (!empty($meeting->client->contact_person) ? $meeting->client->contact_person : null);
                    $contact_number = $is_old ? old('contact_number') : (!empty($meeting->client->contact_no) ? $meeting->client->contact_no : null);
                    $designation = $is_old ? old('designation') : (!empty($meeting->client->designation) ? $meeting->client->designation : null);
                    $email = $is_old ? old('email') : (!empty($meeting->client->email) ? $meeting->client->email : null);
                    $purpose = $is_old ? old('purpose') : (!empty($meeting->purpose) ? $meeting->purpose : null);
                    $meeting_place = $is_old ? old('meeting_place') : (!empty($meeting->meeting_place) ? $meeting->meeting_place : null);
                    $client_type = $is_old ? old('client_type') : (!empty($meeting->client_type) ? $meeting->client_type : null);
                    @endphp
                    <div class="col-xl-4 col-md-4">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="client_name">Date of Client Visit<span class="text-danger">*</span></label>
                            {{ Form::date('visit_date', $visit_date, ['class' => 'form-control', 'id' => 'visit_date', 'autocomplete' => 'off', 'placeholder' => 'Visit Date', 'required']) }}
                        </div>
                    </div>
                    <div class="col-xl-8 col-md-8">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="address">Zone of Sale Rep.<span class="text-danger">*</span></label>
                            {{ Form::text('sales_representative', $sales_representative, ['class' => 'form-control', 'id' => 'sales_representative', 'autocomplete' => 'off', 'placeholder' => 'Sales Representative', 'required']) }}
                        </div>
                    </div>
                    <div class="mt-1 col-xl-4 col-md-4">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="remarks">Time of Work Started? </label>
                            {{ Form::time('meeting_start_time', $meeting_start_time, ['class' => 'form-control', 'id' => 'meeting_start_time', 'autocomplete' => 'off', 'placeholder' => 'Meeting Start Time']) }}
                        </div>
                    </div>
                    <div class="mt-1 col-xl-4 col-md-4">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="remarks">Time of Work Ended? </label>
                            {{ Form::time('meeting_end_time', $meeting_end_time, ['class' => 'form-control', 'id' => 'meeting_end_time', 'autocomplete' => 'off', 'placeholder' => 'Meeting End Time']) }}
                        </div>
                    </div>
                    <div class="mt-1 col-xl-4 col-md-4">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="remarks">Select Client</label>
                            <select name="client_id" id="client_id" class="form-control" rows="2">
                                <option value="">Select</option>
                                @if($clients)
                                @foreach ($clients as $client)
                                <option value="{{ $client->id }}" {{ $client->id == $client_id ? 'selected' : '' }}>{{ $client->client_name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <!-- client type with existing or new with select box -->
                    <div class="mt-1 col-xl-4 col-md-4">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="remarks">Client Type</label>
                            <select name="client_type" id="client_type" class="form-control" rows="2">
                                <option value="">Select</option>
                                <option value="existing" {{ $client_type == 'existing' ? 'selected' : '' }}>Existing</option>
                                <option value="new" {{ $client_type == 'new' ? 'selected' : '' }}>New</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-1 col-xl-12 col-md-12">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="remarks">Place of Visit</label>
                            {{ Form::text('meeting_place', $meeting_place, ['class' => 'form-control', 'id' => 'meeting_place', 'autocomplete' => 'off', 'placeholder' => 'Meeting Place', 'rows' => 2]) }}
                        </div>
                    </div>
                </div>
                <hr />
                <p class="mt-3 font-weight-bold">Contact Person</p>
                <div class="row">
                    <div class="mt-1 col-xl-4 col-md-4">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="remarks">Name</label>
                            {{ Form::text('contact_person', $contact_person, ['class' => 'form-control', 'id' => 'contact_person', 'autocomplete' => 'off', 'placeholder' => 'Contact Person', 'rows' => 2]) }}
                        </div>
                    </div>
                    <div class="mt-1 col-xl-4 col-md-4">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="remarks">Designation</label>
                            {{ Form::text('designation', $designation, ['class' => 'form-control', 'id' => 'designation', 'autocomplete' => 'off', 'placeholder' => 'Designation', 'rows' => 2]) }}
                        </div>
                    </div>
                    <div class="mt-1 col-xl-4 col-md-4">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="remarks">Contact Number</label>
                            {{ Form::text('contact_number', $contact_number, ['class' => 'form-control', 'id' => 'contact_number', 'autocomplete' => 'off', 'placeholder' => 'Contact Number', 'rows' => 2]) }}
                        </div>
                    </div>
                    <div class="mt-1 col-xl-4 col-md-4">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="remarks">Email</label>
                            {{ Form::text('email', $email, ['class' => 'form-control', 'id' => 'email', 'autocomplete' => 'off', 'placeholder' => 'Email', 'rows' => 2]) }}
                        </div>
                    </div>
                    <div class="mt-1 col-xl-8 col-md-8">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="remarks">Purpose</label>
                            {{ Form::text('purpose', $purpose, ['class' => 'form-control', 'id' => 'purpose', 'autocomplete' => 'off', 'placeholder' => 'Purpose', 'rows' => 2]) }}
                        </div>
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
            $('#contact_person').val(client.contact_person);
            $('#designation').val(client.designation);
            $('#contact_number').val(client.contact_no);
            $('#email').val(client.email);
        })
    </script>

    @endsection