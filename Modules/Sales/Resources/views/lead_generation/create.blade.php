@extends('layouts.backend-layout')
@section('title', 'Lead Generation')

@php
    $is_old = old('client_name') ? true : false;
    $form_heading = !empty($lead_generation->id) ? 'Update' : 'Add';
    $form_url = !empty($lead_generation->id) ? route('lead-generation.update', $lead_generation->id) : route('lead-generation.store');
    $form_method = !empty($lead_generation->id) ? 'PUT' : 'POST';
@endphp

@section('breadcrumb-title')
    {{ ucfirst($form_heading) }} Lead Generation
@endsection

@section('breadcrumb-button')
    <a href="{{ route('lead-generation.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('style')
    <style>
        .floating-label {
            font-size: 11px;
            top: -5px;
            position: absolute;
            left: 10px;
            color: #999;
            transition: all 0.2s ease-in-out;
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

    {{-- Comparative Statement --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="tableHeading">
                    <h5> <span> &#10070; </span> Lead Generation <span>&#10070;</span> </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @php
                            $client_name = $is_old ? old('client_name') : $lead_generation->client_name ?? null;
                            $address = $is_old ? old('address') : $lead_generation->address ?? null;
                            $single_division = $is_old ? old('division') : $lead_generation->division_id ?? null;
                            $single_district = $is_old ? old('district') : $lead_generation->district_id ?? null;
                            $single_thana = $is_old ? old('thana') : $lead_generation->thana_id ?? null;
                            $landmark = $is_old ? old('landmark') : $lead_generation->landmark ?? null;
                            $lat = $is_old ? old('lat') : $lead_generation->lat ?? null;
                            $long = $is_old ? old('long') : $lead_generation->long ?? null;
                            $contact_person = $is_old ? old('contact_person') : $lead_generation->contact_person ?? null;
                            $designation = $is_old ? old('designation') : $lead_generation->designation ?? null;
                            $contact_no = $is_old ? old('contact_no') : $lead_generation->contact_no ?? null;
                            $email = $is_old ? old('email') : $lead_generation->email ?? null;
                            $client_type = $is_old ? old('client_type') : $lead_generation->client_type ?? null;
                            $business_type = $is_old ? old('business_type') : $lead_generation->business_type ?? null;
                            $current_provider = $is_old ? old('current_provider') : $lead_generation->current_provider ?? null;
                            $existing_bandwidth = $is_old ? old('existing_bandwidth') : $lead_generation->existing_bandwidth ?? null;
                            $existing_mrc = $is_old ? old('existing_mrc') : $lead_generation->existing_mrc ?? null;
                            $chance_of_business = $is_old ? old('chance_of_business') : $lead_generation->chance_of_business ?? null;
                            $potentiality = $is_old ? old('potentiality') : $lead_generation->potentiality ?? null;
                            $website = $is_old ? old('website') : $lead_generation->website ?? null;
                            $docuemnt = $is_old ? old('docuemnt') : $lead_generation->docuemnt ?? null;
                            $divisons = $divisons ?? null;
                            $thanas = $thanas ?? null;
                            $districts = $districts ?? null;
                            $remarks = $is_old ? old('remarks') : $lead_generation->remarks ?? null;
                        @endphp
                        <div class="col-xl-4 col-md-4">
                            <div class="form-item">
                                <input type="text" id="client_name" name="client_name" class="form-control"
                                    autocomplete="off" value="{{ $client_name }}" required>
                                <label for="client_name">Client Name</label>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4">
                            <div class="form-item">
                                <input type="text" id="address" name="address" class="form-control" autocomplete="off"
                                    value="{{ $address }}" required>
                                <label for="address">Address</label>
                            </div>
                        </div>
                        <div class="mt-1 col-xl-4 col-md-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <select name="division_id" id="division" class="form-control select2" required>
                                    <option>Select Division</option>
                                    @foreach ($divisons as $division)
                                        <option value="{{ $division->id }}"
                                            {{ $division->id == $single_division ? 'selected' : '' }}>
                                            {{ $division->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mt-1 col-xl-4 col-md-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <select name="district_id" id="district" class="form-control select2" required>
                                    <option value="">Select District</option>
                                    @if ($districts)
                                        @foreach ($districts as $district)
                                            <option value="{{ $district->id }}"
                                                {{ $district->id == $single_district ? 'selected' : '' }}>
                                                {{ $district->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="mt-1 col-xl-4 col-md-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <select name="thana_id" id="thana" class="form-control select2" required>
                                    <option value="">Select Thana</option>
                                    @if ($thanas)
                                        @foreach ($thanas as $thana)
                                            <option value="{{ $thana->id }}"
                                                {{ $thana->id == $single_thana ? 'selected' : '' }}>{{ $thana->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="mt-1 col-xl-4 col-md-4">
                            <div class="form-item">
                                <input type="text" id="landmark" name="landmark" class="form-control" autocomplete="off"
                                    value="{{ $landmark }}" required>
                                <label for="landmark">Landmark</label>
                            </div>
                        </div>
                        <div class="mt-1 col-xl-4 col-md-4">
                            <div class="form-item">
                                <input type="text" id="lat" name="lat" class="form-control" autocomplete="off"
                                    value="{{ $lat }}" required>
                                <label for="lat">Latitude</label>
                            </div>
                        </div>
                        <div class="mt-1 col-xl-4 col-md-4">
                            <div class="form-item">
                                <input type="text" id="long" name="long" class="form-control" autocomplete="off"
                                    value="{{ $long }}" required>
                                <label for="long">Longitude</label>
                            </div>
                        </div>
                        <div class="mt-1 col-xl-4 col-md-4">
                            <div class="form-item">
                                <input type="text" id="contact_person" name="contact_person" class="form-control"
                                    autocomplete="off" value="{{ $contact_person }}" required>
                                <label for="contact_person">Contact Person</label>
                            </div>
                        </div>
                        <div class="mt-1 col-xl-4 col-md-4">
                            <div class="form-item">
                                <input type="text" id="designation" name="designation" class="form-control"
                                    autocomplete="off" value="{{ $designation }}" required>
                                <label for="designation">Designation</label>
                            </div>
                        </div>
                        <div class="mt-1 col-xl-4 col-md-4">
                            <div class="form-item">
                                <input type="text" id="contact_no" name="contact_no" class="form-control"
                                    autocomplete="off" value="{{ $contact_no }}" required>
                                <label for="contact_no">Contact No</label>
                            </div>
                        </div>
                        <div class="mt-1 col-xl-4 col-md-4">
                            <div class="form-item">
                                <input type="text" id="email" name="email" class="form-control"
                                    autocomplete="off" value="{{ $email }}" required>
                                <label for="email">Email</label>
                            </div>
                        </div>
                        <div class="mt-1 col-xl-4 col-md-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <select name="client_type" id="client_type" class="form-control " required>
                                    <option>Client Type</option>
                                    <option value="1" {{ $client_type == 1 ? 'selected' : '' }}>Corporate</option>
                                    <option value="2" {{ $client_type == 2 ? 'selected' : '' }}>Individual</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-1 col-xl-4 col-md-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <select name="business_type" id="business_type" class="form-control select2">
                                    <option>Business Type</option>
                                    @foreach ($organizations as $organization)
                                        <option value="{{ $organization }}"
                                            {{ $organization == $business_type ? 'selected' : '' }}>{{ $organization }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mt-1 col-xl-4 col-md-4">
                            <div class="form-item">
                                <input type="text" id="current_provider" name="current_provider" class="form-control"
                                    autocomplete="off" value="{{ $current_provider }}" required>
                                <label for="current_provider">Current Provider</label>
                            </div>
                        </div>
                        <div class="mt-1 col-xl-4 col-md-4">
                            <div class="form-item">
                                <input type="text" id="existing_bandwidth" name="existing_bandwidth"
                                    class="form-control" autocomplete="off" value="{{ $existing_bandwidth }}" required>
                                <label for="existing_bandwidth">Existing Bandwidth</label>
                            </div>
                        </div>
                        <div class="mt-1 col-xl-4 col-md-4">
                            <div class="form-item">
                                <input type="text" id="existing_mrc" name="existing_mrc" class="form-control"
                                    autocomplete="off" value="{{ $existing_mrc }}">
                                <label for="existing_mrc">Existing MRC</label>
                            </div>
                        </div>
                        <div class="mt-1 col-xl-4 col-md-4">
                            <div class="form-item">
                                <input type="text" id="chance_of_business" name="chance_of_business"
                                    class="form-control" autocomplete="off" value="{{ $chance_of_business }}">
                                <label for="chance_of_business">Chance of Acquiring Business</label>
                            </div>
                        </div>
                        <div class="mt-1 col-xl-4 col-md-4">
                            <div class="form-item">
                                <input type="text" id="potentiality" name="potentiality" class="form-control"
                                    autocomplete="off" value="{{ $potentiality }}">
                                <label for="potentiality">Potentiality</label>
                            </div>
                        </div>


                        <div class="mt-1 col-xl-4 col-md-4">
                            <div class="form-item">
                                <input type="text" id="website" name="website" class="form-control"
                                    autocomplete="off" value="{{ $website }}">
                                <label for="website">Website</label>
                            </div>
                        </div>
                        <!-- doucment upload -->
                        <div class="mt-1 col-xl-4 col-md-4">
                            <div class="input-group input-group-sm input-group-primary">

                                <input class="form-control" accept=".png, .jpg, .jpeg, .pdf" id=""
                                    name="upload_file" type="file" placeholder="Upload File">

                            </div>
                        </div>
                        @if (!empty($lead_generation->document))
                            <div class="mt-1 col-xl-4 col-md-4 text-center">
                                <div class="input-group input-group-sm input-group-primary">
                                    <a href="{{ asset('storage/' . $lead_generation->document) }}" target="_blank"
                                        class="btn btn-outline-primary">View document</a>
                                </div>
                            </div>
                        @endif

                        <div class="mt-1 col-xl-12 col-md-12 ">
                            <div class="form-item">
                                <input type="text" id="remarks" name="remarks" class="form-control"
                                    autocomplete="off" value="{{ $remarks }}">
                                <label for="remarks">Remarks</label>
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
                    <button class="py-2 btn btn-success ">{{ !empty($lead_generation->id) ? 'Update' : 'Save' }}</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    @endsection

    @section('script')
        <script>
            $('#division').on('change', function() {
                var division_id = $(this).val();
                var html = '<option value="">Select District</option>';
                $.ajax({
                    url: "{{ route('get-districts') }}",
                    data: {
                        division_id: division_id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        data.forEach(element => {
                            html += '<option value="' + element.id + '">' + element.text +
                                '</option>';
                        });
                        $('#district').html(html);
                    }
                });
            });

            $('#district').on('change', function() {
                var district_id = $(this).val();
                var html = '<option value="">Select Thana</option>';
                $.ajax({
                    url: "{{ route('get-thanas') }}",
                    data: {
                        district_id: district_id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        data.forEach(element => {
                            html += '<option value="' + element.id + '">' + element.text +
                                '</option>';
                        });
                        $('#thana').html(html);
                    }
                });
            });

            // $(document).ready(function() {
            //     $('.select2').select2({
            //         placeholder: 'Select an option'
            //     });
            // });
        </script>
    @endsection
