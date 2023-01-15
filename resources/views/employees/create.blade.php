@extends('layouts.backend-layout')
@section('title', 'Employees')

@section('breadcrumb-title')
    @if($formType == 'edit')
        Edit Employee
    @else
        Add New Employee
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('employees') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')

    @if($formType == 'edit')
        {!! Form::open(array('url' => "employees/$employee->id",'encType' =>"multipart/form-data", 'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => "employees",'method' => 'POST','encType' =>"multipart/form-data", 'class'=>'custom-form')) !!}
    @endif
        <div class="row">
            <div class=" row col-md-12">
                <div class="col-6">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="fname">First Name</label>
                        {{Form::text('fname', old('fname') ? old('fname') : (!empty($employee->fname) ? $employee->fname : null),['class' => 'form-control','id' => 'name', 'autocomplete'=>"off",'list'=>'dataList'])}}
                    </div>
                </div>
                <div class="col-6">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="lname">Last Name</label>
                        {{Form::text('lname', old('lname') ? old('lname') : (!empty($employee->lname) ? $employee->lname : null),['class' => 'form-control','id' => 'name', 'autocomplete'=>"off"])}}
                    </div>
                </div>
                <div class="col-6">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="employee_code">Employee ID</label>
                        {{Form::text('employee_code', old('employee_code') ? old('employee_code') : (!empty($employee->employee_code) ? $employee->employee_code : null),['class' => 'form-control','id' => 'name', 'autocomplete'=>"off"])}}
                    </div>
                </div>
                <div class="col-6">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="designation_id">Department</label>
                        {{Form::select('department_id', $departments, old('department_id') ? old('department_id') : (!empty($employee->department_id) ? $employee->department_id : null),['class' => 'form-control','id' => 'department_id', 'placeholder'=>"Select Section", 'autocomplete'=>"off"])}}
                    </div>
                </div>
                <div class="col-6">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="designation_id">Designation</label>
                        {{Form::select('designation_id', $designations, old('designation_id') ? old('designation_id') : (!empty($employee->designation_id) ? $employee->designation_id : null),['class' => 'form-control','id' => 'designation_id', 'placeholder'=>"Select Section", 'autocomplete'=>"off"])}}
                    </div>
                </div>
                <div class="col-6">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="nid">NID</label>
                        {{Form::text('nid', old('nid') ? old('nid') : (!empty($employee->nid) ? $employee->nid : null),['class' => 'form-control','id' => 'nid', 'autocomplete'=>"off"])}}
                    </div>
                </div>
                <div class="col-6">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="dob"> DOB </label>
                        {{Form::text('dob', old('dob') ? old('dob') : (!empty($employee->date) ? $employee->date : now()->format('d-m-Y')),['class' => 'form-control','id' => 'date', 'autocomplete'=>"off", 'required'])}}
                    </div>
                </div>
                <div class="col-6">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="contact">Contact</label>
                        {{Form::text('contact', old('contact') ? old('contact') : (!empty($employee->contact) ? $employee->contact : null),['class' => 'form-control','id' => 'contact', 'autocomplete'=>"off"])}}
                    </div>
                </div>
                <div class="col-6">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="email">Email</label>
                        {{Form::email('email', old('email') ? old('email') : (!empty($employee->email) ? $employee->email : null),['class' => 'form-control','id' => 'email', 'autocomplete'=>"off"])}}
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
                        <label class="input-group-addon" for="permanent_address">Division</label>
                        {{Form::select('division_id',$divisions, old('division_id') ? old('division_id') : (!empty($employee->preThana->district->division_id) ? $employee->preThana->district->division_id : null),['class' => 'form-control','id' => 'division_id', 'placeholder'=>"Select Division", 'autocomplete'=>"off",'onChange'=>"loadDistrict(this)"])}}
                    </div>
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="designation_id">District<span class="text-danger">*</span></label>
                        {{Form::select('district_id', $district, old('district_id') ? old('district_id') : (!empty($employee->preThana->district_id) ? $employee->preThana->district_id : null),['class' => 'form-control','id' => 'district_id', 'placeholder'=>"Select District", 'autocomplete'=>"off",'onChange'=>"loadThana(this)"])}}
                    </div>

                    <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="permanent_address">Thana</label>
                        {{Form::select('pre_thana_id', $thanas, old('pre_thana_id') ? old('pre_thana_id') : (!empty($employee->pre_thana_id) ? $employee->pre_thana_id : null),['class' => 'form-control','id' => 'thana_id', 'placeholder'=>"Select Thana", 'autocomplete'=>"off"])}}
                        </div>
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="permanent_address">Street</label>
                            {{Form::text('pre_street_address', old('pre_street_address') ? old('pre_street_address') : (!empty($employee->pre_street_address) ? $employee->pre_street_address : null),['class' => 'form-control','id' => 'permanent_address', 'autocomplete'=>"off"])}}
                        </div>

                    </div>

                <div class="col-6">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Permanent Address </h5>
                        </div>
                        <div class="col-md-6" align="right">
                            <input class="" type="checkbox" value="" id="sameAddresschk">
                            <label class="form-check-label" for="sameAddresschk">
                                <p class="mb-0"> Same Address </p>
                            </label>
                        </div>
                    </div>
                    <br>
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="permanent_address">Division</label>
                        {{Form::select('division_id',$divisions, old('division_id') ? old('division_id') : (!empty($employee->perThana->district->division_id) ? $employee->perThana->district->division_id : null),['class' => 'form-control','id' => 'per_division_id', 'placeholder'=>"Select Division", 'autocomplete'=>"off",'onChange'=>"loadPerDistrict(this)"])}}
                    </div>
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="designation_id">District<span class="text-danger">*</span></label>
                        {{Form::select('district_id', $district, old('district_id') ? old('district_id') : (!empty($employee->perThana->district_id) ? $employee->perThana->district_id : null),['class' => 'form-control','id' => 'per_district_id', 'placeholder'=>"Select District", 'autocomplete'=>"off",'onChange'=>"loadPerThana(this)"])}}
                    </div>
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="permanent_address">Thana</label>
                        {{Form::select('per_thana_id', $thanas, old('per_thana_id') ? old('per_thana_id') : (!empty($employee->per_thana_id) ? $employee->per_thana_id : null),['class' => 'form-control','id' => 'per_thana_id', 'placeholder'=>"Select Thana", 'autocomplete'=>"off"])}}
                    </div>
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="permanent_address">Street</label>
                        {{Form::text('per_street_address', old('per_street_address') ? old('per_street_address') : (!empty($employee->per_street_address) ? $employee->per_street_address : null),['class' => 'form-control','id' => 'per_street_address', 'autocomplete'=>"off"])}}
                    </div>

                </div>
                </div>
        <div class="row col-md-12">
            <div class="col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="picture"> Photo <span class="text-danger">*</span></label>
                    {{Form::file('picture',['class' => 'form-control','id' => '',"onchange"=>"document.getElementById('photo').src = window.URL.createObjectURL(this.files[0])"])}}
                </div>
            </div>
            <div class="col-md-6">
                @if ($formType=='edit' && $employee != null && !empty($employee->picture))
                    <img src="{{asset('images/Employees/'.$employee->picture)}}" id="picture" width="40px" height="40px" alt="">
                @else
                    <img id="photo" width="40px" height="40px" alt="" />
                @endif
            </div>
    </div>


            </div>
        </div><!-- end row -->
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
        $('#date').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});

        function loadDistrict() {
            let dropdown = $('#district_id');
            dropdown.empty();
            dropdown.append('<option selected="true" disabled>Select District </option>');
            dropdown.prop('selectedIndex', 0);
            const url = '{{url("getDistricts")}}/' + $("#division_id").val();
            // Populate dropdown with list of provinces
            $.getJSON(url, function (district) {
                $.each(district, function (key, entry) {
                    dropdown.append($('<option></option>').attr('value', entry.id).text(entry.name));
                })
            });
        }
        function loadPerDistrict() {
            let dropdown = $('#per_district_id');
            dropdown.empty();
            dropdown.append('<option selected="true" disabled>Select District </option>');
            dropdown.prop('selectedIndex', 0);
            const url = '{{url("getDistricts")}}/' + $("#per_division_id").val();
            // Populate dropdown with list of provinces
            $.getJSON(url, function (perdistrict) {
                $.each(perdistrict, function (key, entry) {
                    dropdown.append($('<option></option>').attr('value', entry.id).text(entry.name));
                })
            });
        }
        function loadThana() {
            let dropdown = $('#thana_id');
            dropdown.empty();
            dropdown.append('<option selected="true" disabled>Select Thana </option>');
            dropdown.prop('selectedIndex', 0);
            const url = '{{url("getThanas")}}/' + $("#district_id").val();
            // Populate dropdown with list of provinces
            $.getJSON(url, function (thana) {
                $.each(thana, function (key, entry) {
                    dropdown.append($('<option></option>').attr('value', entry.id).text(entry.name));
                })
            });
        }
        function loadPerThana() {
            let dropdown = $('#per_thana_id');
            dropdown.empty();
            dropdown.append('<option selected="true" disabled>Select Thana </option>');
            dropdown.prop('selectedIndex', 0);
            const url = '{{url("getThanas")}}/' + $("#per_district_id").val();
            // Populate dropdown with list of provinces
            $.getJSON(url, function (thana) {
                $.each(thana, function (key, entry) {
                    dropdown.append($('<option></option>').attr('value', entry.id).text(entry.name));
                })
            });
        }

        $("#sameAddresschk").change(function() {
            if(this.checked) {
                $("#per_division_id").attr('readonly',true);
                $("#per_district_id").attr('readonly',true);
                $("#per_thana_id").attr('readonly',true);
                $("#per_street_address").attr('readonly',true);
            }else{
                $("#per_division_id").attr('readonly',false);
                $("#per_district_id").attr('readonly',false);
                $("#per_thana_id").attr('readonly',false);
                $("#per_street_address").attr('readonly',false);
            }
        });

        $(document).ready(function(){
            var isSame = '{{ !empty($employee->address_status) ? (($employee->address_status==1) ? 'same' : '') : '' }}'
            if(isSame == 'same')
            {
                $("#per_division_id").attr('readonly',true);
                $("#per_district_id").attr('readonly',true);
                $("#per_thana_id").attr('readonly',true);
                $("#per_street_address").attr('readonly',true);
            }
        })
    </script>
@endsection

