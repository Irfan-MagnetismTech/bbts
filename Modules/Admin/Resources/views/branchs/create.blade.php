@extends('layouts.backend-layout')
@section('title', 'Branchs')

@section('breadcrumb-title')
    @if ($formType == 'edit')
        Edit
    @else
        Create
    @endif
    Branchs Info
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
    <a href="{{ route('branchs.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
    <div class="container">
        <form action="{{ $formType == 'edit' ? route('branchs.update', $branch->id) : route('branchs.store') }}"
            method="post" class="custom-form">
            @if ($formType == 'edit')
                @method('PUT')
            @endif
            @csrf
            <div class="row">

                <div class="col-12">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="name">Branch Name <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Enter branch name" value="{{ old('name') ?? ($branch->name ?? '') }}" required>
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
                                    {{ (old('division_id') ?? ($branch->division_id ?? '')) == $division->id ? 'selected' : '' }}>
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
                            @if($formType == 'edit')
                                @foreach (@$districts as $district)
                                    <option value="{{ $district->id }}"
                                        {{ (old('district_id') ?? ($branch->district_id ?? '')) == $district->id ? 'selected' : '' }}>
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
                            @if($formType == 'edit')
                                @foreach (@$thanas as $thana)
                                    <option value="{{ $thana->id }}"
                                        {{ (old('thana_id') ?? ($branch->thana_id ?? '')) == $thana->id ? 'selected' : '' }}>
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
                            placeholder="Enter branch location" value="{{ old('location') ?? ($branch->location ?? '') }}"
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
    <script src="{{ asset('js/Datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/Datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(window).scroll(function() {
            //set scroll position in session storage
            sessionStorage.scrollPos = $(window).scrollTop();
        });
        var init = function() {
            //get scroll position in session storage
            $(window).scrollTop(sessionStorage.scrollPos || 0)
        };
        window.onload = init;

        $(document).ready(function() {
            $('#dataTable').DataTable({
                stateSave: true
            });
        });

        const divisions = "{{ route('get_districts') }}"
        const thanas = "{{ route('get_thanas') }}"

        $('#division_id').on('change', function() {
            let division_id = $(this).val();
            axios.get(divisions, {
                    params: {
                        division_id: division_id
                    }
                })
                .then(function(response) {
                    $('#district_id').html('');
                    var district_options = '<option value="">Select district</option>';
                    response.data.map(function(district) {
                        district_options += `<option value="${district.id}">${district.name}</option>`;
                    });
                    $('#district_id').html(district_options);
                    console.log(response.data);

                })
                .catch(function(error) {
                    console.log(error);
                });
        });

        $('#district_id').on('change', function() {
            let district_id = $(this).val();
            axios.get(thanas, {
                    params: {
                        district_id: district_id
                    }
                })
                .then(function(response) {
                    $('#thana_id').html('');
                    var thana_options = '<option value="">Select thana</option>';
                    response.data.map(function(thana) {
                        thana_options += `<option value="${thana.id}">${thana.name}</option>`;
                    });
                    $('#thana_id').html(thana_options);
                    console.log(response.data);

                })
                .catch(function(error) {
                    console.log(error);
                });
        });
    </script>
@endsection
