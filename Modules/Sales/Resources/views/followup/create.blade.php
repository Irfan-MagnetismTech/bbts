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

@section('style')
    <style>
        .custom-form .input-group-addon {
            min-width: 130px !important;
        }

        .radio .helper {
            top: -0.4rem !important;
        }
    </style>
@endsection

@section('content-grid', null)

@section('content')
    {!! Form::open([
        'url' => $form_url,
        'method' => $form_method,
        'encType' => 'multipart/form-data',
        'class' => 'custom-form',
        'novalidate' => 'novalidate',
    ]) !!}
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
                            $client_id = $is_old ? old('client_id') : (!empty($followup->client->id) ? $followup->client->id : null);
                            $client_no = $is_old ? old('client_no') : (!empty($followup->client_no) ? $followup->client_no : null);
                            $address = $is_old ? old('address') : (!empty($followup->client->address) ? $followup->client->address : null);
                            $potentility_amount = $is_old ? old('potentility_amount') : (!empty($followup->potentility_amount) ? $followup->potentility_amount : null);
                            $meeting_outcome = $is_old ? old('meeting_outcome') : (!empty($followup->meeting_outcome) ? $followup->meeting_outcome : null);
                            $client_type = $is_old ? old('client_type') : (!empty($followup->client_type) ? $followup->client_type : null);
                        @endphp
                        <div class="col-xl-4 col-md-4">
                            <div class="form-item">
                                <input type="date" name="activity_date" class="form-control" id="activity_date"
                                    autocomplete="off" placeholder="" required value="{{ $activity_date }}">
                                <label for="activity_date">Date
                                    of Activity Report</label>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4">
                            <div class="form-item">
                                <input type="time" name="work_start_time" class="form-control" id="work_start_time"
                                    autocomplete="off" placeholder="Work Start Time" required
                                    value="{{ $work_start_time }}">
                                <label for="work_end_time">Work Start Time</label>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4">
                            <div class="form-item">
                                <input type="time" name="work_end_time" class="form-control" id="work_end_time"
                                    autocomplete="off" placeholder="Work End Time" required value="{{ $work_end_time }}">
                                <label for="work_end_time">Work End Time<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4">
                            <div class="form-item">
                                <select class="form-control" name="client_type" id="client_type">
                                    <option value="">Select Client Type</option>
                                    <option value="Existing" {{ $client_type == 'Existing' ? 'selected' : '' }}>Existing
                                    </option>
                                    <option value="New" {{ $client_type == 'New' ? 'selected' : '' }}>New</option>
                                </select>
                                @if ($errors->has('client_type'))
                                    <span class="text-danger">{{ $errors->first('client_type') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4">
                            <div class="form-item">
                                <select class="form-control" name="work_nature_type">
                                    <option value="">Select Work Nature Type</option>
                                    @if (!empty($work_nature_types))
                                        @foreach ($work_nature_types as $nature_type)
                                            <option value="{{ $nature_type }}"
                                                {{ $nature_type == $work_nature_type ? 'selected' : '' }}>
                                                {{ $nature_type }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4">
                            <div class="form-item">
                                <select class="form-control" name="sales_type">
                                    <option value="">Select Types of Sales Call</option>
                                    @if (!empty($sale_types))
                                        @foreach ($sale_types as $type)
                                            <option value="{{ $type }}"
                                                {{ $type == $sales_type ? 'selected' : '' }}>{{ $type }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4">
                            <div class="form-item">
                                <select class="form-control" name="client_no" id="client_id">
                                    <option value="">Select Client</option>
                                    @if (!empty($clients))
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}"
                                                {{ $client->id == $client_id ? 'selected' : '' }}>
                                                {{ $client->client_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4">
                            <div class="form-item">
                                <input type="text" name="address" class="form-control" id="address" autocomplete="off"
                                    placeholder="" required value="{{ $address }}">
                                <label for="address">Address<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4">
                            <div class="form-item">
                                <input type="text" name="potentility_amount" class="form-control" id="potentility_amount"
                                    autocomplete="off" placeholder="" required value="{{ $potentility_amount }}">
                                <label for="potentility_amount">Potentility Amount<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4">
                            <div class="form-item">
                                <input type="text" name="meeting_outcome" class="form-control" id="meeting_outcome"
                                    autocomplete="off" placeholder="" required value="{{ $meeting_outcome }}">
                                <label for="meeting_outcome">Meeting Outcome<span class="text-danger">*</span></label>
                            </div>
                            {{ Form::hidden('meeting_id', $meeting_id) }}
                        </div>
                        <div class="col-xl-4 col-md-4">
                            <div class="d-flex justify-content-around">
                                <button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal"
                                    data-target="#TaDaModal">
                                    TA DA
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal"
                                    data-target=".questionModal">
                                    Questions
                                </button>
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
    </div>
    @include('sales::followup.tada_modal')
    {{-- Question Modal --}}

    @include('sales::followup.question_modal')
    {!! Form::close() !!}


    {{-- TA DA Modal --}}



@endsection

@section('script')
    <script>
        $('#client_id').on('change', function() {
            var client_id = $(this).val();
            var clients = JSON.parse('{!! json_encode($clients) !!}');
            var client = clients.find(client => client.id == client_id);
            console.log('client', client)
            $('#address').val(client.address).attr('value', client.address);
        })

        $('.select2').select2();

        $('#ModalClose').on('click', function() {
            $('input[name=reason_of_switching]').val('');
            $('input[name=lan_issue]').val('');
            $('input[name="device[]"]').prop('checked', false);
            $('input[name=capability_of_bandwidth]').val('');
            $('input[name=device_connected_with_lan]').val('');
            $('input[name=mail_domain]').prop('checked', false);
            $('input[name=license_of_antivirus]').val('');
            $('input[name=client_site_it_person]').val('');
            $('input[name=vpn_requirement]').prop('checked', false);
            $('input[name=video_conferencing]').prop('checked', false);
            $('input[name=iptsp_service_usage]').prop('checked', false);
            $('input[name=software_usage]').prop('checked', false);
            $('input[name=specific_destination]').val('');
            $('input[name=uptime_capable_sla]').prop('checked', false);
            $('input[name=isp_providing]').val('');
            $('.questionModal').modal('hide');
        });
    </script>

@endsection
