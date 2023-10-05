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
                            $client_no = $is_old ? old('client_id') : (!empty($meeting->client_no) ? $meeting->client_no : null);
                            $contact_person = $is_old ? old('contact_person') : (!empty($meeting->client->contact_person) ? $meeting->client->contact_person : null);
                            $contact_number = $is_old ? old('contact_number') : (!empty($meeting->client->contact_no) ? $meeting->client->contact_no : null);
                            $designation = $is_old ? old('designation') : (!empty($meeting->client->designation) ? $meeting->client->designation : null);
                            $email = $is_old ? old('email') : (!empty($meeting->client->email) ? $meeting->client->email : null);
                            $purpose = $is_old ? old('purpose') : (!empty($meeting->purpose) ? $meeting->purpose : null);
                            $meeting_place = $is_old ? old('meeting_place') : (!empty($meeting->meeting_place) ? $meeting->meeting_place : null);
                            $client_type = $is_old ? old('client_type') : (!empty($meeting->client_type) ? $meeting->client_type : null);
                        @endphp
                        <div class="col-xl-4 col-md-4">
                            <div class="form-item">
                                <input type="date" name="visit_date" id="visit_date" class="form-control"
                                    value="{{ $visit_date }}" required>
                                <label for="visit_date">Date of Client Visit</label>
                            </div>
                        </div>
                        <div class="col-xl-8 col-md-8">
                            <div class="form-item">
                                <input type="text" name="sales_representative" id="sales_representative"
                                    class="form-control" value="{{ $sales_representative }}" required>
                                <label for="sales_representative">Zone of Sale Rep</label>
                            </div>
                        </div>
                        <div class="mt-1 col-xl-3 col-md-3">
                            <div class="form-item">
                                <input type="time" name="meeting_start_time" id="meeting_start_time" class="form-control"
                                    value="{{ $meeting_start_time }}" required>
                                <label for="meeting_start_time">Time of Work Started? </label>
                            </div>
                        </div>
                        <div class="mt-1 col-xl-3 col-md-3">
                            <div class="form-item">
                                <input type="time" name="meeting_end_time" id="meeting_end_time" class="form-control"
                                    value="{{ $meeting_end_time }}" required>
                                <label for="meeting_end_time">Time of Work Ended? </label>
                            </div>
                        </div>
                        <div class="mt-1 col-xl-3 col-md-3">
                            <div class="form-item">
                                <select name="client_no" id="client_id" class="form-control select2" rows="2">
                                    <option value="">Select Client</option>
                                    @if ($clients)
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->client_no }}"
                                                {{ $client->client_no == $client_no ? 'selected' : '' }}>
                                                {{ $client->client_name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <!-- client type with existing or new with select box -->
                        <div class="mt-1 col-xl-3 col-md-3">
                            <div class="form-item">
                                <select name="client_type" id="client_type" class="form-control" rows="2">
                                    <option value="">Select Client Type</option>
                                    <option value="existing" {{ $client_type == 'existing' ? 'selected' : '' }}>Existing
                                    </option>
                                    <option value="new" {{ $client_type == 'new' ? 'selected' : '' }}>New</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-1 col-xl-12 col-md-12">
                            <div class="form-item">
                                <input type="text" name="meeting_place" id="meeting_place" class="form-control"
                                    value="{{ $meeting_place }}" required>
                                <label for="meeting_place">Place of Visit</label>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <p class="mt-3 font-weight-bold">Contact Person</p>
                    <div class="row">
                        <div class="mt-1 col-xl-3 col-md-3">
                            <div class="form-item">
                                <input type="text" name="contact_person" id="contact_person" class="form-control"
                                    value="{{ $contact_person }}" required>
                                <label for="contact_person">Name</label>
                            </div>
                        </div>
                        <div class="mt-1 col-xl-3 col-md-3">
                            <div class="form-item">
                                <input type="text" name="designation" id="designation" class="form-control"
                                    value="{{ $designation }}" required>
                                <label for="designation">Designation</label>
                            </div>
                        </div>
                        <div class="mt-1 col-xl-3 col-md-3">
                            <div class="form-item">
                                <input type="text" name="contact_number" id="contact_number" class="form-control"
                                    value="{{ $contact_number }}" required>
                                <label for="remarks">Contact Number</label>
                            </div>
                        </div>
                        <div class="mt-1 col-xl-3 col-md-3">
                            <div class="form-item">
                                <input type="text" name="email" id="email" class="form-control"
                                    value="{{ $email }}" required>
                                <label for="remarks">Email</label>
                            </div>
                        </div>
                        <div class="mt-1 col-xl-12 col-md-12">
                            <div class="form-item">
                                <input type="text" name="purpose" id="purpose" class="form-control"
                                    value="{{ $purpose }}" required>
                                <label for="remarks">Purpose</label>
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
                    <button class="py-2 btn btn-success ">{{ !empty($meeting->id) ? 'Update' : 'Save' }}</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    @endsection

    @section('script')
        <script>
            $('#client_id').on('change', function() {
                var client_no = $(this).val();
                var clients = JSON.parse('{!! json_encode($clients) !!}');
                var client = clients.find(client => client.client_no == client_no);
                $('#contact_person').val(client.contact_person).attr('value', client.contact_person)
                $('#designation').val(client.designation).attr('value', client.designation)
                $('#contact_number').val(client.contact_no).attr('value', client.contact_no)
                $('#email').val(client.email).attr('value', client.email)
            })
            $('.select2').select2();
        </script>

    @endsection
