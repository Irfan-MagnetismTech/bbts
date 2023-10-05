@extends('layouts.backend-layout')
@section('title', 'Employees')

@section('breadcrumb-title')
    @if ($formType == 'edit')
        Edit Employees
    @else
        Add New Employees
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('dataencoding/employees') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')

    @if ($formType == 'edit')
        {!! Form::open([
            'url' => "dataencoding/employees/$employee->id",
            'encType' => 'multipart/form-data',
            'method' => 'PUT',
            'class' => 'custom-form',
        ]) !!}
    @else
        {!! Form::open([
            'url' => 'dataencoding/employees',
            'method' => 'POST',
            'encType' => 'multipart/form-data',
            'class' => 'custom-form',
        ]) !!}
    @endif
    <div class="row">
        <div class="row col-md-12">
            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="name"> Name<span class="text-danger">*</span></label>
                    {{ Form::text('name', old('name') ? old('name') : (!empty($employee->name) ? $employee->name : null), ['class' => 'form-control', 'id' => 'name', 'autocomplete' => 'off','required', 'list' => 'dataList']) }}
                </div>
            </div>

        </div>
        <div class=" row col-md-12">
            <div class="col-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="designation_id">Department<span
                            class="text-danger">*</span></label>
                    {{ Form::select('department_id', $departments, old('department_id') ? old('department_id') : (!empty($employee->department_id) ? $employee->department_id : null), ['class' => 'form-control', 'id' => 'department_id', 'placeholder' => 'Select Department', 'autocomplete' => 'off','required']) }}
                </div>
            </div>
            <div class="col-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="designation_id">Designation<span
                            class="text-danger">*</span></label>
                    {{ Form::select('designation_id', $designations, old('designation_id') ? old('designation_id') : (!empty($employee->designation_id) ? $employee->designation_id : null), ['class' => 'form-control', 'id' => 'designation_id', 'placeholder' => 'Select Designation', 'autocomplete' => 'off', 'required']) }}
                </div>
            </div>
        </div>
        <div class=" row col-md-12">
            <div class="col-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="nid">NID<span class="text-danger">*</span></label>
                    {{ Form::text('nid', old('nid') ? old('nid') : (!empty($employee->nid) ? $employee->nid : null), ['class' => 'form-control', 'id' => 'nid', 'autocomplete' => 'off', 'required']) }}
                </div>
            </div>
            <div class="col-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="dob"> DOB <span class="text-danger">*</span></label>
                    {{ Form::date('dob', old('dob') ? old('dob') : (!empty($employee->dob) ? $employee->dob : null), ['class' => 'form-control', 'id' => 'date', 'autocomplete' => 'off', 'required']) }}
                </div>
            </div>
        </div>
        <div class=" row col-md-12">
            <div class="col-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="contact">Contact<span class="text-danger">*</span></label>
                    {{ Form::text('contact', old('contact') ? old('contact') : (!empty($employee->contact) ? $employee->contact : null), ['class' => 'form-control', 'id' => 'contact', 'autocomplete' => 'off','required']) }}
                </div>
            </div>
            <div class="col-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="email">Email<span class="text-danger">*</span></label>
                    {{ Form::email('email', old('email') ? old('email') : (!empty($employee->email) ? $employee->email : null), ['class' => 'form-control', 'id' => 'email', 'autocomplete' => 'off', 'required']) }}
                </div>
            </div>
        </div>
        <div class=" row col-md-12">
            <div class="col-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="blood">Blood Group<span class="text-danger">*</span></label>
                    {{ Form::select('blood_group', $bloodgroups, old('blood_group') ? old('blood_group') : (!empty($employee->blood_group) ? $employee->blood_group : null), ['class' => 'form-control', 'id' => 'blood', 'placeholder' => 'Select Blood Group', 'autocomplete' => 'off', 'required']) }}
                </div>
            </div>
            <div class="col-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="emergency">Emergency Contact<span
                            class="text-danger">*</span></label>
                    {{ Form::text('emergency', old('emergency') ? old('emergency') : (!empty($employee->emergency) ? $employee->emergency : null), ['class' => 'form-control', 'id' => 'emergency', 'autocomplete' => 'off', 'required']) }}
                </div>
            </div>
        </div>
        <div class=" row col-md-12">
            <div class="col-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="father">Father Name<span class="text-danger">*</span></label>
                    {{ Form::text('father', old('father') ? old('father') : (!empty($employee->father) ? $employee->father : null), ['class' => 'form-control', 'id' => 'father', 'placeholder' => "Father's Name", 'autocomplete' => 'off','required']) }}
                </div>
            </div>
            <div class="col-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="mother">Mother Name<span class="text-danger">*</span></label>
                    {{ Form::text('mother', old('mother') ? old('mother') : (!empty($employee->mother) ? $employee->mother : null), ['class' => 'form-control', 'id' => 'mother', 'placeholder' => "Mother's Name", 'autocomplete' => 'off','required']) }}
                </div>
            </div>
        </div>
        <div class=" row col-md-12">
            <div class="col-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="blood">Joining Date<span class="text-danger">*</span></label>
                    {{ Form::date('joining_date', old('joining_date') ? old('blood_group') : (!empty($employee->joining_date) ? $employee->joining_date : null), ['class' => 'form-control', 'id' => 'joining_date', 'placeholder' => 'Joining Date', 'autocomplete' => 'off','required']) }}
                </div>
            </div>
            <div class="col-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="blood">Reference<span class="text-danger">*</span></label>
                    {{ Form::text('reference', old('reference') ? old('blood_group') : (!empty($employee->reference) ? $employee->reference : null), ['class' => 'form-control', 'id' => 'reference', 'placeholder' => 'Reference', 'autocomplete' => 'off']) }}
                </div>
            </div>
        </div>
        <div class=" row col-md-12">
            <div class="col-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="blood">Job Experience<span class="text-danger">*</span></label>
                    {{ Form::textarea('job_experience', old('job_experience') ? old('blood_group') : (!empty($employee->job_experience) ? $employee->job_experience : null), ['class' => 'form-control', 'id' => 'job_experience', 'placeholder' => 'Job Experience', 'autocomplete' => 'off','required', 'rows' => '3']) }}
                </div>
            </div>
        </div>
    </div>
    <br>
    <hr>
    <div class="row">
        <div class="row col-md-12">
            <div class="col-6">
                <h5>Present Address </h5>

                <br>
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="permanent_address">Address</label>
                    {{ Form::textarea('pre_street_address', old('pre_street_address') ? old('pre_street_address') : (!empty($employee->pre_street_address) ? $employee->pre_street_address : null), ['class' => 'form-control', 'id' => 'permanent_address', 'autocomplete' => 'off','required', 'rows' => 2]) }}
                </div>
                @if ($formType == 'create')
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="permanent_address">Division</label>
                        {{ Form::select('pre_division_id', $divisions, old('division_id') ? old('division_id') : (!empty($employee->preThana->district->division_id) ? $employee->preThana->district->division_id : null), ['class' => 'form-control', 'id' => 'division_id', 'placeholder' => 'Select Division', 'autocomplete' => 'off','required', 'onChange' => 'loadDistrict(this)']) }}
                    </div>
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="designation_id">District<span
                                class="text-danger">*</span></label>
                        {{ Form::select('pre_district_id', $predistrict, old('district_id') ? old('district_id') : (!empty($employee->preThana->district_id) ? $employee->preThana->district_id : null), ['class' => 'form-control', 'id' => 'district_id', 'placeholder' => 'Select District', 'autocomplete' => 'off','required', 'onChange' => 'loadThana(this)']) }}
                    </div>
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="permanent_address">Thana</label>
                        {{ Form::select('pre_thana_id', $prethanas, old('pre_thana_id') ? old('pre_thana_id') : (!empty($employee->pre_thana_id) ? $employee->pre_thana_id : null), ['class' => 'form-control', 'id' => 'thana_id', 'placeholder' => 'Select Thana', 'autocomplete' => 'off','required']) }}
                    </div>
                @else
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="permanent_address">Division</label>
                        {{ Form::select('pre_division_id', $divisions, $employee->pre_division_id ?? null, [
                            'class' => 'form-control',
                            'id' => 'division_id',
                            'placeholder' => 'Select Division',
                            'autocomplete' => 'off','required',
                            'onChange' => 'loadDistrict(this)',
                        ]) }}
                    </div>
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="designation_id">District<span
                                class="text-danger">*</span></label>
                        {{ Form::select('pre_district_id', $districts, $employee->pre_district_id ?? null, [
                            'class' => 'form-control',
                            'id' => 'district_id',
                            'placeholder' => 'Select District',
                            'autocomplete' => 'off','required',
                            'onChange' => 'loadThana(this)',
                        ]) }}
                    </div>
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="permanent_address">Thana</label>
                        {{ Form::select('pre_thana_id', $thanas, $employee->pre_thana_id ?? null, [
                            'class' => 'form-control',
                            'id' => 'thana_id',
                            'placeholder' => 'Select Thana',
                            'autocomplete' => 'off','required',
                        ]) }}

                    </div>
                @endif





            </div>

            <div class="col-6">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Permanent Address </h5>
                    </div>
                    <div class="col-md-6" align="right">
                        <input class="" type="checkbox" value="1" name="address_status" id="sameAddresschk"
                            {{ !empty($employee->address_status) ? ($employee->address_status == 1 ? 'checked' : '') : '' }}>
                        <label class="form-check-label" for="sameAddresschk">
                            <p> Same Address</p>

                        </label>
                    </div>
                </div>
                <br>
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="permanent_address">Address</label>
                    {{ Form::textarea('per_street_address', old('per_street_address') ? old('per_street_address') : (!empty($employee->per_street_address) ? $employee->per_street_address : null), ['class' => 'form-control', 'id' => 'per_street_address', 'autocomplete' => 'off', 'rows' => 2]) }}
                </div>

                @if ($formType == 'create')
                    <div class="input-group input-group-sm input-group-primary" id="">
                        <label class="input-group-addon" for="permanent_address">Division</label>
                        {{ Form::select('per_division_id', $divisions, old('division_id') ? old('division_id') : (!empty($employee->perThana->district->division_id) ? $employee->perThana->district->division_id : null), ['class' => 'form-control', 'id' => 'per_division_id', 'placeholder' => 'Select Division', 'autocomplete' => 'off', 'onChange' => 'loadPerDistrict(this)']) }}
                    </div>
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="designation_id">District<span
                                class="text-danger">*</span></label>
                        {{ Form::select('per_district_id', $perdistrict, old('district_id') ? old('district_id') : (!empty($employee->perThana->district_id) ? $employee->perThana->district_id : null), ['class' => 'form-control', 'id' => 'per_district_id', 'placeholder' => 'Select District', 'autocomplete' => 'off', 'onChange' => 'loadPerThana(this)']) }}
                    </div>
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="permanent_address">Thana </label>
                        {{ Form::select('per_thana_id', $perthanas, old('per_thana_id') ? old('per_thana_id') : (!empty($employee->per_thana_id) ? $employee->per_thana_id : null), ['class' => 'form-control', 'id' => 'per_thana_id', 'placeholder' => 'Select Thana', 'autocomplete' => 'off']) }}
                    </div>
                @else
                    <div class="input-group input-group-sm input-group-primary" id="">
                        <label class="input-group-addon" for="permanent_address">Division</label>
                        {{ Form::select('per_division_id', $divisions, $employee->per_division_id ?? null, [
                            'class' => 'form-control',
                            'id' => 'per_division_id',
                            'placeholder' => 'Select Division',
                            'autocomplete' => 'off',
                            'onChange' => 'loadPerDistrict(this)',
                        ]) }}
                    </div>
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="designation_id">District<span
                                class="text-danger">*</span></label>
                        {{ Form::select('per_district_id', $districts, $employee->per_district_id ?? null, [
                            'class' => 'form-control',
                            'id' => 'per_district_id',
                            'placeholder' => 'Select District',
                            'autocomplete' => 'off',
                            'onChange' => 'loadPerThana(this)',
                        ]) }}

                    </div>
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="permanent_address">Thana </label>
                        {{ Form::select('per_thana_id', $thanas, $employee->per_thana_id ?? null, [
                            'class' => 'form-control',
                            'id' => 'per_thana_id',
                            'placeholder' => 'Select Thana',
                            'autocomplete' => 'off',
                        ]) }}

                    </div>
                @endif






            </div>
        </div>
        <div class="row col-md-12">
            <div class="col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="picture"> Photo <span class="text-danger">*</span></label>
                    {{ Form::file('picture', ['class' => 'form-control', 'id' => '', 'onchange' => "document.getElementById('photo').src = window.URL.createObjectURL(this.files[0])"]) }}
                </div>
            </div>
            <div class="col-md-6">
                @if (!empty($employee))
                    <img src="{{ asset('images/Employees/' . $employee->picture) }}" id="photo" width="120px"
                        height="60px" alt="">
                @else
                    <img id="photo" width="120px" height="60px" alt="" />
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="offset-md-4 col-md-4 mt-2">
            <div class="input-group input-group-sm ">
                <button class="btn btn-success btn-round btn-block py-2">Submit</button>
            </div>
        </div>
    </div> <!-- end row -->
    {!! Form::close() !!}
@endsection
@section('script')

    <script>
        //$('#date').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});
        //$('#joining_date').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});

        function loadDistrict() {
            let dropdown = $('#district_id');
            dropdown.empty();
            dropdown.append('<option selected="true" disabled>Select District </option>');
            dropdown.prop('selectedIndex', 0);
            const url = '{{ url('admin/get_districts') }}?division_id=' + $("#division_id").val();
            // Populate dropdown with list of provinces
            $.getJSON(url, function(district) {
                $.each(district, function(key, entry) {
                    // console.log(entry);
                    dropdown.append($('<option></option>').attr('value', entry.id).text(entry.name));
                })
            });
        }

        function loadPerDistrict() {
            let dropdown = $('#per_district_id');
            dropdown.empty();
            dropdown.append('<option selected="true" disabled>Select District </option>');
            dropdown.prop('selectedIndex', 0);
            const url = '{{ url('admin/get_districts') }}?division_id=' + $("#per_division_id").val();
            // Populate dropdown with list of provinces
            $.getJSON(url, function(perdistrict) {
                $.each(perdistrict, function(key, entry) {
                    dropdown.append($('<option></option>').attr('value', entry.id).text(entry.name));
                })
            });
        }



        function loadThana() {
            let dropdown = $('#thana_id');
            dropdown.empty();
            dropdown.append('<option selected="true" disabled>Select Thana </option>');
            dropdown.prop('selectedIndex', 0);
            // const url = '{{ url('admin/get_thanas') }}/' + $("#district_id").val();
            const url = '{{ url('admin/get_thanas') }}?district_id=' + $("#district_id").val();
            // Populate dropdown with list of provinces
            $.getJSON(url, function(thana) {
                $.each(thana, function(key, entry) {
                    console.log(entry);
                    dropdown.append($('<option></option>').attr('value', entry.id).text(entry.name));
                })
            });
        }


        function loadPerThana() {
            let dropdown = $('#per_thana_id');
            dropdown.empty();
            dropdown.append('<option selected="true" disabled>Select Thana </option>');
            dropdown.prop('selectedIndex', 0);
            // const url = '{{ url('admin/get_thanas') }}/' + $("#per_district_id").val();
            const url = '{{ url('admin/get_thanas') }}?district_id=' + $("#per_district_id").val();
            // Populate dropdown with list of provinces
            $.getJSON(url, function(thana) {
                $.each(thana, function(key, entry) {
                    dropdown.append($('<option></option>').attr('value', entry.id).text(entry.name));
                })
            });
        }
        $("#sameAddresschk").change(function() {
            if (this.checked) {
                $("#per_division_id").attr('readonly', true);
                $("#per_district_id").attr('readonly', true);
                $("#per_thana_id").attr('readonly', true);
                $("#per_street_address").attr('readonly', true);
            } else {
                $("#per_division_id").attr('readonly', false);
                $("#per_district_id").attr('readonly', false);
                $("#per_thana_id").attr('readonly', false);
                $("#per_street_address").attr('readonly', false);
            }
        });

        $(document).ready(function() {
            var isSame =
                '{{ !empty($employee->address_status) ? ($employee->address_status == 1 ? 'same' : '') : '' }}'
            if (isSame == 'same') {
                $("#per_division_id").attr('readonly', true);
                $("#per_district_id").attr('readonly', true);
                $("#per_thana_id").attr('readonly', true);
                $("#per_street_address").attr('readonly', true);
            }
        })
    </script>
@endsection
