@extends('layouts.backend-layout')
@section('title', 'Zone')

@section('breadcrumb-title')
    @if ($formType == 'edit')
        Edit
    @else
        Create
    @endif
    Zone Info
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

@php
    $thana_ids = old('thana_ids', !empty($zone) ? $zone->zoneLines->pluck('thana_id')->toArray() : []);
@endphp
@section('breadcrumb-button')
    <a href="{{ route('zones.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
    <div class="container">
        <form action="{{ $formType == 'edit' ? route('zones.update', $zone->id) : route('zones.store') }}" method="post"
            class="custom-form">
            @if ($formType == 'edit')
                @method('PUT')
            @endif
            @csrf
            <div class="row">

                <div class="col-12">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="name">Zone Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Enter zone name" value="{{ old('name') ?? ($zone->name ?? '') }}" required>
                    </div>
                </div>

                <div class="col-12">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="thana_id">Thanas <span class="text-danger">*</span></label>
                        <select class="form-control select2" multiple id="thana_id" name="thana_ids[]" required>
                            @foreach (@$thanas as $key => $thana)
                                <option value="{{ $thana->id }}"
                                    {{ in_array($thana->id, $thana_ids) ? 'selected' : '' }}>
                                    {{ $thana->name }}
                                </option>
                            @endforeach
                        </select>
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
        $('.select2').select2({
            placeholder: "Search thana",
        });
    </script>
@endsection
