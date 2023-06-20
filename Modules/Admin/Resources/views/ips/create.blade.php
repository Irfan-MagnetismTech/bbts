@extends('layouts.backend-layout')
@section('title', 'Ips')

@section('breadcrumb-title')
    @if ($formType == 'edit')
        Edit
    @else
        Create
    @endif
    Ips Info
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
    <a href="{{ route('ips.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
    <div class="container">
        <form action="{{ $formType == 'edit' ? route('ips.update', $ip->id) : route('ips.store') }}"
            method="post" class="custom-form">
            @if ($formType == 'edit')
                @method('PUT')
            @endif
            @csrf
            <div class="row">

                <div class="col-12">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="name">Ip Name <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Enter ip name" value="{{ old('name') ?? ($ip->name ?? '') }}" required>
                    </div>
                </div>

                <div class="col-12">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="division_id">division <span
                                class="text-danger">*</span></label>
                        <select class="form-control" id="division_id" name="division_id" required>
                            <option value="">Select division</option>
                            @foreach (@$divisions as $division)
                                <option value="{{ $division->id }}"
                                    {{ (old('division_id') ?? ($ip->division_id ?? '')) == $division->id ? 'selected' : '' }}>
                                    {{ $division->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-12">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="district_id">district <span
                                class="text-danger">*</span></label>
                        <select class="form-control" id="district_id" name="district_id" required>
                            <option value="">Select district</option>
                            @if ($formType == 'edit')
                                @foreach (@$districts as $district)
                                    <option value="{{ $district->id }}"
                                        {{ (old('district_id') ?? ($ip->district_id ?? '')) == $district->id ? 'selected' : '' }}>
                                        {{ $district->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <div class="col-12">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="district_id">thana <span class="text-danger">*</span></label>
                        <select class="form-control" id="thana_id" name="thana_id" required>
                            <option value="">Select thana</option>
                            @if ($formType == 'edit')
                                @foreach (@$thanas as $thana)
                                    <option value="{{ $thana->id }}"
                                        {{ (old('thana_id') ?? ($ip->thana_id ?? '')) == $thana->id ? 'selected' : '' }}>
                                        {{ $thana->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <div class="col-12">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="location">Location <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="location" name="location"
                            placeholder="Enter ip location" value="{{ old('location') ?? ($ip->location ?? '') }}"
                            required>
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
    <script src="{{ asset('js/custom-function.js') }}"></script>
    <script>
        // get data by associative dropdown
        associativeDropdown("{{ route('get-districts') }}", 'division_id', '#division_id', '#district_id', 'get', null)
        associativeDropdown("{{ route('get-thanas') }}", 'district_id', '#district_id', '#thana_id', 'get', null)
        
    </script>
@endsection
