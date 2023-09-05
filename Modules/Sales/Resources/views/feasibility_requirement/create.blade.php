@extends('layouts.backend-layout')
@section('title', 'Feasibility Requirement')

@php
    $is_old = old('client_id') ? true : false;
    $form_heading = !empty($feasibility_requirement->id) ? 'Update' : 'Add';
    $form_url = !empty($feasibility_requirement->id) ? route('feasibility-requirement.update', $feasibility_requirement->id) : route('feasibility-requirement.store');
    $form_method = !empty($feasibility_requirement->id) ? 'PUT' : 'POST';
@endphp

@section('breadcrumb-title')
    {{ ucfirst($form_heading) }} Feasibility Requirement
@endsection

@section('breadcrumb-button')
    <a href="{{ route('export-feasibility-requirement') }}" class="btn btn-out-dashed btn btn-sm btn-danger"><i
            class="fas fa-file-excel"></i> Download template</a>
    <a href="{{ route('feasibility-requirement.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-database"></i></a>
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
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="tableHeading">
                    <h5> <span> &#10070; </span> Feasibility Requirement <span>&#10070;</span> </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @php
                            $client_name = $is_old ? old('client_name') : $feasibility_requirement->lead_generation->client_name ?? null;
                            $client_id = $is_old ? old('client_id') : $feasibility_requirement->client_no ?? null;
                            $is_existing = $is_old ? old('is_existing') : $feasibility_requirement->is_existing ?? null;
                            $date = $is_old ? old('date') : $feasibility_requirement->date ?? null;
                        @endphp
                        {{-- exiting or new radio button --}}
                        <div class="col-xl-3 col-md-3">
                            <div class="row" style="justify-content: space-evenly">
                                <div>
                                    <input type="radio" name="is_existing" id="is_new" value="New"
                                        {{ $is_existing == 'New' ? 'checked' : '' }} autocomplete="off" required>
                                    <label style="font-size: 15px; margin-left:5px;" for="is_new">New</label>
                                </div>
                                <div>
                                    <input type="radio" name="is_existing" id="is_existing" value="Existing"
                                        {{ $is_existing == 'Existing' ? 'checked' : '' }} autocomplete="off" required>
                                    <label style="font-size: 15px; margin-left:5px;" for="is_existing">Existing</label>
                                </div>

                            </div>
                        </div>
                        <div class="col-xl-3 col-md-3">
                            <div class="form-item">
                                <input type="text" class="form-control" name="client_no" id="client_id"
                                    value="{{ $client_id }}" autocomplete="off" required>
                                <label for="client_id">Client ID<span class="text-danger">*</span></label>
                                <input type="hidden" name="lead_generation_id" id="lead_generation_id" value="">
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-3">
                            <div class="form-item">
                                <input type="text" class="form-control" name="client_name" id="client_name"
                                    value="{{ $client_name }}" autocomplete="off" required>
                                <label for="client_name">Client Name<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-3">
                            <div class="form-item">
                                <input type="date" name="date" id="date" class="form-control"
                                    value="{{ $date ? $date : now()->format('Y-m-d') }}" autocomplete="off">
                                <label for="client_type">Date<span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <hr>
                            <div class="text-center">
                                <h5> <span> &#10070; </span> Feasibility Requirement <span>&#10070;</span> </h5>
                            </div>
                            <hr>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped feasibility-requirement">
                                <thead>
                                    <tr>
                                        <th rowspan="2">Name of the Link hh</th>
                                        <th rowspan="2">Agreegation Type</th>
                                        <th colspan="6">Connectivity Address</th>
                                        <th colspan="5">Local Contact Details</th>
                                    </tr>
                                    <tr>
                                        <th>Division</th>
                                        <th>District</th>
                                        <th>Thana</th>
                                        <th>Location</th>
                                        <th>Latitue</th>
                                        <th>Longitude</th>
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th>Con. No.</th>
                                        <th>Email</th>
                                        <th>
                                            <button type="button" class="btn btn-sm btn-warning" id="addRow"><i
                                                    class="fas fa-plus"></i></button>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="feasibiltyBody">
                                    @if (!empty($feasibility_requirement))
                                        @foreach ($feasibility_requirement->feasibilityRequirementDetails as $item)
                                            <tr class="feasibility_details_row">
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">

                                                        <input type="text" name="connectivity_point[]"
                                                            class="form-control" value="{{ $item->connectivity_point }}"
                                                            autocomplete="off" placeholder="Connectivity Point">
                                                        <input type="hidden" name="detail_id[]"
                                                            value="{{ $item->id }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <select name="aggregation_type[]" class="form-control"
                                                            autocomplete="off" placeholder="Select Aggregation Type">
                                                            <option value="">Select Aggregation Type</option>
                                                            <option value="DC"
                                                                {{ $item->aggregation_type == 'DC' ? 'selected' : '' }}>
                                                                DC</option>
                                                            <option value="DR"
                                                                {{ $item->aggregation_type == 'DR' ? 'selected' : '' }}>
                                                                DR</option>
                                                            <option value="Branch"
                                                                {{ $item->aggregation_type == 'Branch' ? 'selected' : '' }}>
                                                                Branch</option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <select name="division_id[]" class="form-control division"
                                                            id="division" autocomplete="off"
                                                            placeholder="Select Division">
                                                            <option value="">Select Division</option>
                                                            @foreach ($divisions as $division)
                                                                <option value="{{ $division->id }}"
                                                                    {{ $item->division_id == $division->id ? 'selected' : '' }}>
                                                                    {{ $division->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <select name="district_id[]" class="form-control district_name"
                                                            autocomplete="off" placeholder="Select District">
                                                            <option value="">Select District</option>
                                                            @if ($item->division_id)
                                                                @foreach ($districts as $district)
                                                                    <option value="{{ $district->id }}"
                                                                        {{ $item->district_id == $district->id ? 'selected' : '' }}>
                                                                        {{ $district->name }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <select name="thana_id[]" class="form-control thana"
                                                            id="thana" autocomplete="off" placeholder="Select Thana">
                                                            @if ($item->thana_id)
                                                                @foreach ($thanas as $thana)
                                                                    <option value="{{ $thana->id }}"
                                                                        {{ $item->thana_id == $thana->id ? 'selected' : '' }}>
                                                                        {{ $thana->name }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="location[]" class="form-control"
                                                            value="{{ $item->location }}" autocomplete="off"
                                                            placeholder="Location">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="lat[]" class="form-control"
                                                            value="{{ $item->lat }}" autocomplete="off"
                                                            placeholder="Latitue">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="long[]" class="form-control"
                                                            value="{{ $item->long }}" autocomplete="off"
                                                            placeholder="Longitude">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="contact_name[]" class="form-control"
                                                            value="{{ $item->contact_name }}" autocomplete="off"
                                                            placeholder="Name">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="contact_designation[]"
                                                            class="form-control" value="{{ $item->contact_designation }}"
                                                            autocomplete="off" placeholder="Designation">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="contact_number[]"
                                                            class="form-control" value="{{ $item->contact_number }}"
                                                            autocomplete="off" placeholder="Con. No.">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm input-group-primary">
                                                        <input type="text" name="contact_email[]" class="form-control"
                                                            value="{{ $item->contact_email }}" autocomplete="off"
                                                            placeholder="Email">
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" attr_one="{{ $item->id }}"
                                                        class="btn btn-sm btn-danger removeRow"><i
                                                            class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr class="feasibility_details_row">
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="connectivity_point[]"
                                                        class="form-control" id="connectivity_point" autocomplete="off"
                                                        placeholder="Connectivity Point">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <select name="aggregation_type[]" class="form-control"
                                                        autocomplete="off" placeholder="Select Aggregation Type">
                                                        <option value="">Select Aggregation Type</option>
                                                        <option value="DC">DC</option>
                                                        <option value="DR">DR</option>
                                                        <option value="Branch">Branch</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <select name="division_id[]" class="form-control division"
                                                        id="division" autocomplete="off" placeholder="Select Division">
                                                        <option value="">Select Division</option>
                                                        @foreach ($divisions as $division)
                                                            <option value="{{ $division->id }}">
                                                                {{ $division->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <select name="district_id[]" class="form-control district_name"
                                                        autocomplete="off" placeholder="Select District">
                                                        <option value="">Select District</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <select name="thana_id[]" class="form-control thana" id="thana"
                                                        autocomplete="off" placeholder="Select Thana">
                                                        <option value="">Select Thana</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="location[]" class="form-control"
                                                        id="location" autocomplete="off" placeholder="Location">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="lat[]" class="form-control"
                                                        id="latlong" autocomplete="off" placeholder="Latitute">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="long[]" class="form-control"
                                                        id="latlong" autocomplete="off" placeholder="Longitute">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="contact_name[]" class="form-control"
                                                        id="name" autocomplete="off" placeholder="Name">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="contact_designation[]"
                                                        class="form-control" id="designation" autocomplete="off"
                                                        placeholder="Designation">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="text" name="contact_number[]" class="form-control"
                                                        id="contact" autocomplete="off" placeholder="Contact">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm input-group-primary">
                                                    <input type="email" name="contact_email[]" class="form-control"
                                                        id="email" autocomplete="off" placeholder="Email">
                                                </div>
                                            </td>
                                            <td>
                                                <button type="button" attr_one=""
                                                    class="btn btn-sm btn-danger removeRow"><i
                                                        class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <input id="csv-file" type="file" name="file" class="form-control d-none" />

                        <button class="mt-2 py-2 btn btn-danger mr-3" id="toggle-csv" type="button">Upload Csv</button>
                        <button class="mt-2 py-2 btn btn-danger mr-3 d-none" id="upload-via-table" type="button">Upload
                            via table</button>
                        <button
                            class=" mt-2 py-2 btn btn-success ">{{ !empty($lead_generation->id) ? 'Update' : 'Save' }}</button>
                    </div>
                    {!! Form::close() !!}
                    {{-- <div class="mt-3">
                    <form method="POST" encType="multipart/form-data" action="{{route('import-feasibility-requirement')}}">
                        <input type="file">
                    </form>
                    <button type="submit" class="mt-3 btn btn-success">Submit</button> --}}
                </div>
            @endsection

            @section('script')
                <script>
                    // $('#division').on('change', function() {
                    //     var division_id = $(this).val();
                    //     $.ajax({
                    //         url: "{{ route('get-districts') }}",
                    //         data: {
                    //             division_id: division_id,
                    //             _token: "{{ csrf_token() }}"
                    //         },
                    //         success: function(data) {
                    //             $('#district').html(data);
                    //         }
                    //     });
                    // });

                    //get districts by last class selected division
                    $(document).on('change', '.division', function() {
                        var division_id = $(this).val();
                        var row = $(this).closest('tr').find('select[name="district_id[]"]').val('');
                        $.ajax({
                            url: "{{ route('get-districts') }}",
                            data: {
                                division_id: division_id,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(data) {
                                row.empty();
                                row.append('<option value="">Select District</option>');
                                data.forEach(element => {
                                    row.append('<option value="' + element.id + '">' + element.text +
                                        '</option>');
                                });
                            }
                        });
                    });

                    //get thanas by last class selected district
                    $(document).on('change', '.district_name', function() {
                        var district_id = $(this).val();
                        var row = $(this).closest('tr').find('select[name="thana_id[]"]');
                        $.ajax({
                            url: "{{ route('get-thanas') }}",
                            data: {
                                district_id: district_id,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(data) {
                                row.empty();
                                row.append('<option value="">Select District</option>');
                                data.forEach(element => {
                                    row.append('<option value="' + element.id + '">' + element.text +
                                        '</option>');
                                });
                            }
                        });
                    });



                    $('#addRow').on('click', function() {
                        addRow();
                    });

                    function addRow() {
                        $('.feasibility_details_row').first().clone().appendTo('.feasibiltyBody');
                        $('.feasibility_details_row').last().find('input').val('');
                        $('.feasibility_details_row').last().find('select').val('');
                    };

                    $(document).keydown(function(event) {
                        if (event.ctrlKey && event.key === 'Insert') {
                            event.preventDefault();
                            addRow();
                        }
                    });

                    $(document).keydown(function(event) {
                        if (event.ctrlKey && event.key === 'Delete') {
                            event.preventDefault();
                            if ($('.feasibility_details_row').length > 1) {
                                $('.feasibility_details_row').last().remove();
                            }
                        }
                    });

                    $(document).on('click', '.removeRow', function() {
                        let count = $('.feasibility_details_row').length;
                        if (count > 1) {
                            $(this).closest('tr').remove();
                            //get attr_one value 
                            var attr_one = $(this).attr('attr_one');
                            //if attr_one value is not empty then delete from database
                            if (attr_one != '') {
                                $.ajax({
                                    url: "{{ route('delete-feasibility-requirement-details') }}",
                                    data: {
                                        id: attr_one,
                                        _token: "{{ csrf_token() }}"
                                    },
                                    success: function(data) {
                                        console.log(data);
                                    }
                                });
                            }
                        }
                    });

                    $('#client_id, #client_name').on('input', function() {
                        var search = $(this).val();
                        console.log(search)
                        $(this).autocomplete({
                            source: function(request, response) {
                                $.ajax({
                                    url: "{{ route('get-client') }}",
                                    data: {
                                        search: search,
                                        _token: "{{ csrf_token() }}"
                                    },
                                    success: function(data) {
                                        response(data);
                                    }
                                });
                            },
                            select: function(event, ui) {
                                $('#client_id').val(ui.item.client_no).attr('value', ui.item.client_no);
                                $('#client_name').val(ui.item.client_name).attr('value', ui.item.client_name);
                                $('#lead_generation_id').val(ui.item.lead_generation_id).attr('value', ui.item
                                    .lead_generation_id);
                                return false;
                            }
                        });
                    });
                    $('#toggle-csv').click(function() {
                        $('.feasibility-requirement').addClass('d-none');
                        $('#csv-file').removeClass('d-none');
                        $('#upload-via-table').removeClass('d-none');
                        $('#toggle-csv').addClass('d-none');
                        console.log('Button clicked! Logging to console.');
                    });
                    $('#upload-via-table').click(function() {
                        $('.feasibility-requirement').removeClass('d-none');
                        $('#csv-file').addClass('d-none');
                        $('#upload-via-table').addClass('d-none');
                        $('#toggle-csv').removeClass('d-none');
                        console.log('Button clicked! Logging to console.');
                    });
                </script>
            @endsection
