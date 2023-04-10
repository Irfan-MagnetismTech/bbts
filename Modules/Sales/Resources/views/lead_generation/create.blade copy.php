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

    </style>
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
                            $lat_long = $is_old ? old('lat_long') : $lead_generation->lat_long ?? null;
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
                            $thanas = $thanas ?? null;
                            $districts = $districts ?? null;
                            $remarks = $is_old ? old('remarks') : $lead_generation->remarks ?? null;
                        @endphp
                        <div class="col-xl-4 col-md-4">
                            <div class="form-item">
                                <input type="text" id="client_name" autocomplete="off" value="{{ $client_name }}"
                                    required>
                                <label for="client_name">Client Name</label>
                            </div>
                        </div>
                        <div class="col-xl-8 col-md-8">
                            <div class="form-item">
                                <input type="text" id="address" autocomplete="off" value="{{ $address }}" required>
                                <label for="address">Address</label>
                            </div>
                        </div>
                        <div class="mt-1 col-xl-4 col-md-4">
                            
                        </div>
                        <div class="mt-1 col-xl-4 col-md-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="remarks">District</label>
                                <select name="district_id" id="district" class="form-control">
                                    <option value="">Select</option>
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
                                <label class="input-group-addon" for="remarks">Thana</label>
                                <select name="thana_id" id="thana" class="form-control">
                                    <option value="">Select</option>
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
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="remarks">Landmark</label>
                                {{ Form::text('landmark', $landmark, ['class' => 'form-control', 'id' => 'landmark', 'autocomplete' => 'off', 'placeholder' => 'landmark', 'rows' => 2]) }}
                            </div>
                        </div>
                        <div class="mt-1 col-xl-4 col-md-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="remarks">Lat Long</label>
                                {{ Form::text('lat_long', $lat_long, ['class' => 'form-control', 'id' => 'lat_long', 'autocomplete' => 'off', 'placeholder' => 'lat_long', 'rows' => 2]) }}
                            </div>
                        </div>
                        <div class="mt-1 col-xl-4 col-md-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="remarks">Contact Person</label>
                                {{ Form::text('contact_person', $contact_person, ['class' => 'form-control', 'id' => 'contact_person', 'autocomplete' => 'off', 'placeholder' => 'contact_person', 'rows' => 2]) }}
                            </div>
                        </div>
                        <div class="mt-1 col-xl-4 col-md-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="remarks">Designation</label>
                                {{ Form::text('designation', $designation, ['class' => 'form-control', 'id' => 'designation', 'autocomplete' => 'off', 'placeholder' => 'designation', 'rows' => 2]) }}
                            </div>
                        </div>
                        <div class="mt-1 col-xl-4 col-md-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="remarks">Contact No</label>
                                {{ Form::text('contact_no', $contact_no, ['class' => 'form-control', 'id' => 'contact_no', 'autocomplete' => 'off', 'placeholder' => 'Contact No', 'rows' => 2]) }}
                            </div>
                        </div>
                        <div class="mt-1 col-xl-4 col-md-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="remarks">Email</label>
                                {{ Form::text('email', $email, ['class' => 'form-control', 'id' => 'email', 'autocomplete' => 'off', 'placeholder' => 'Email', 'rows' => 2]) }}
                            </div>
                        </div>
                        <div class="mt-1 col-xl-4 col-md-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="remarks">Client Type</label>
                                <select name="client_type" id="client_type" class="form-control">
                                    <option value="">Select</option>
                                    <option value="1" {{ $client_type == 1 ? 'selected' : '' }}>Corporate</option>
                                    <option value="2" {{ $client_type == 2 ? 'selected' : '' }}>Individual</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-1 col-xl-4 col-md-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="remarks">Business Type</label>
                                <select name="business_type" id="business_type" class="form-control">
                                    <option value="">Select</option>
                                    @foreach ($organizations as $organization)
                                        <option value="{{ $organization }}"
                                            {{ $organization == $business_type ? 'selected' : '' }}>{{ $organization }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mt-1 col-xl-4 col-md-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="remarks">Current Provide</label>
                                {{ Form::text('current_provide', $current_provider, ['class' => 'form-control', 'id' => 'current_provide', 'autocomplete' => 'off', 'placeholder' => 'Current Provide', 'rows' => 2]) }}
                            </div>
                        </div>
                        <div class="mt-1 col-xl-4 col-md-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="remarks">Existing Bandwidth</label>
                                {{ Form::text('existing_bandwidth', $existing_bandwidth, ['class' => 'form-control', 'id' => 'existing_bandwidth', 'autocomplete' => 'off', 'placeholder' => 'Existing Bandwidth', 'rows' => 2]) }}
                            </div>
                        </div>
                        <div class="mt-1 col-xl-4 col-md-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="remarks">Existing MRC</label>
                                {{ Form::text('existing_mrc', $existing_mrc, ['class' => 'form-control', 'id' => 'existing_mrc', 'autocomplete' => 'off', 'placeholder' => 'Existing MRC', 'rows' => 2]) }}
                            </div>
                        </div>
                        <div class="mt-1 col-xl-4 col-md-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="remarks">Chance of Business</label>
                                {{ Form::text('chance_of_business', $chance_of_business, ['class' => 'form-control', 'id' => 'chance_of_business', 'autocomplete' => 'off', 'placeholder' => 'Chance of Business', 'rows' => 2]) }}
                            </div>
                        </div>
                        <div class="mt-1 col-xl-4 col-md-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="remarks">Potentiality</label>
                                {{ Form::text('potentiality', $potentiality, ['class' => 'form-control', 'id' => 'potentiality', 'autocomplete' => 'off', 'placeholder' => 'Potentiality', 'rows' => 2]) }}
                            </div>
                        </div>


                        <div class="mt-1 col-xl-4 col-md-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="remarks">Website</label>
                                {{ Form::text('website', $website, ['class' => 'form-control', 'id' => 'website', 'autocomplete' => 'off', 'placeholder' => 'Website', 'rows' => 2]) }}
                            </div>
                        </div>
                        <!-- doucment upload -->
                        <div class="mt-1 col-xl-4 col-md-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="upload_file"> Upload Document</label>
                                <input class="form-control" accept=".png, .jpg, .jpeg, .pdf" id=""
                                    name="upload_file" type="file">
                            </div>
                        </div>
                        <div class="mt-1 col-xl-12 col-md-12">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="remarks">Remarks</label>
                                {{ Form::textarea('remarks', $remarks, ['class' => 'form-control', 'id' => 'remarks', 'autocomplete' => 'off', 'placeholder' => 'Remarks', 'rows' => 2]) }}
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
                $.ajax({
                    url: "{{ route('get-districts') }}",
                    data: {
                        division_id: division_id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        $('#district').html(data);
                    }
                });
            });

            $('#district').on('change', function() {
                var district_id = $(this).val();
                $.ajax({
                    url: "{{ route('get-thanas') }}",
                    data: {
                        district_id: district_id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        $('#thana').html(data);
                    }
                });
            });
        </script>
    @endsection
