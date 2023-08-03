@extends('layouts.backend-layout')
@section('title', 'Fiber Core')

@section('breadcrumb-title')
 Material
@endsection

@section('breadcrumb-button')
    <a href="{{ url('networking/fiber-managements') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')

    @if(isset($nestedmaterial))
        {!! Form::open(array('url' => "networking/fiber-managements/$nestedmaterial->id",'method' => 'PUT','encType' =>"multipart/form-data", 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => "networking/fiber-managements",'method' => 'POST','encType' =>"multipart/form-data", 'class'=>'custom-form')) !!}
    @endif
        <div class="row">
            <div class="col-md-12 col-xl-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="pop_id">POP<span class="text-danger">*</span></label>
                    {{Form::text('pop_id', old('pop_id') ? old('pop_id') : (!empty($nestedmaterial->pop_id) ? $nestedmaterial->pop_id : null),['class' => 'form-control','id' => 'pop_id', 'autocomplete'=>"off",'placeholder'=>"POP"])}}
                </div>
            </div>
            <div class="col-md-12 col-xl-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="connectivity_point_name">Connectivity Point Name<span class="text-danger">*</span></label>
                    {{Form::text('connectivity_point_name', old('connectivity_point_name') ? old('connectivity_point_name') : (!empty($nestedmaterial->connectivity_point_name) ? $nestedmaterial->connectivity_point_name : null),['class' => 'form-control','id' => 'connectivity_point_name', 'autocomplete'=>"off",'required',])}}
                </div>
            </div>
            <div class="col-md-12 col-xl-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="cable_code">Cable Code<span class="text-danger">*</span></label>
                    {{Form::text('cable_code', old('cable_code') ? old('cable_code') : (!empty($nestedmaterial->cable_code) ? $nestedmaterial->cable_code : null),['class' => 'form-control','id' => 'cable_code', 'autocomplete'=>"off",'required','placeholder'=>"Cable Code",])}}
                </div>
            </div>

            <div class="col-md-12 col-xl-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="fiber_type">Type<span
                            class="text-danger">*</span></label>
                    <select class="form-control" id="fiber_type" name="fiber_type" required>
                        <option value="">Select division</option>
                        @foreach (config('businessinfo.fiberType') as $key => $value)
                            <option value="{{ $key }}">
                                {{ $value }}
                            </option>
                        @endforeach
                        
                        {{-- {{ (old('division_id') ?? ($branch->division_id ?? '')) == $division->id ? 'selected' : '' }} --}}
                    </select>
                </div>
            </div>
            <div class="col-md-12 col-xl-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="core_no_color">Core No Color<span
                            class="text-danger">*</span></label>
                    <select class="form-control" id="core_no_color" name="core_no_color" required>
                        @foreach (config('businessinfo.coreNoColor') as $key => $value)
                            <option value="{{ $key }}">
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-12 col-xl-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="parent_id">Core Ref ID.<span class="text-danger">*</span></label>
                    {{Form::select('parent_id', $CoreRefIds, old('parent_id') ? old('parent_id') : (!empty($nestedmaterial->parent_id) ? $nestedmaterial->parent_id : null),['class' => 'form-control','id' => 'parent_id', 'placeholder'=>"Select Account Head Name", 'autocomplete'=>"off"])}}
                </div>
            </div>
        </div><!-- end row -->
    <hr class="bg-success">
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
        fillSelect2Options("{{ route('searchPop') }}", '#pop_id');
    </script>
@endsection
