@extends('layouts.backend-layout')
@section('title', 'Survey')

@php
    $is_old = old('client_id') ? true : false;
    $form_heading = !empty($survey->id) ? 'Update' : 'Add';
    $form_url = !empty($survey->id) ? route('survey.update', $survey->id) : route('survey.store');
    $form_method = !empty($survey->id) ? 'PUT' : 'POST';
@endphp

@section('breadcrumb-title')
    {{ ucfirst($form_heading) }} Survey Requirement
@endsection

@section('breadcrumb-button')
    <a href="{{ route('survey.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')

    {!! Form::open([
        'url' => $form_url,
        'method' => $form_method,
        'class' => 'custom-form',
    ]) !!}

    {{-- Comparative Statement --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="tableHeading">
                    <h5> <span> &#10070; </span> Survey <span>&#10070;</span> </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @php
                            if (!empty($survey)) {
                                $link_types = $survey->surveyDetails->pluck('link_type')->toArray();
                                $options = $survey->surveyDetails->pluck('option')->toArray();
                                $statuses = $survey->surveyDetails->pluck('status')->toArray();
                                $methods = $survey->surveyDetails->pluck('method')->toArray();
                                $vendors = $survey->surveyDetails->pluck('vendor')->toArray();
                                $bts_pop_ldps = $survey->surveyDetails->pluck('bts_pop_ldp')->toArray();
                                $gps = $survey->surveyDetails->pluck('gps')->toArray();
                                $distances = $survey->surveyDetails->pluck('distance')->toArray();
                                $current_capacities = $survey->surveyDetails->pluck('current_capacity')->toArray();
                                $remarks = $survey->surveyDetails->pluck('remarks')->toArray();
                                $details_ids = $survey->surveyDetails->pluck('id')->toArray();
                            }
                            $client_name = $is_old ? old('client_name') : $survey->lead_generation->client_name ?? $fr_detail->feasibilityRequirement->lead_generation->client_name;
                            $client_id = $is_old ? old('client_id') : $survey->lead_generation->client_id ?? $fr_detail->feasibilityRequirement->lead_generation->client_id;
                            $date = $is_old ? old('date') : $survey->date ?? null;
                            $mq_no = $is_old ? old('mq_no') : $survey->mq_no ?? $fr_detail->feasibilityRequirement->mq_no;
                            $fr_no = $is_old ? old('fr_no') : $survey->fr_no ?? $fr_detail->fr_no;
                            $link_name = $is_old ? old('link_name') : $survey->feasibilityRequirementDetails->link_name ?? $fr_detail->link_name;
                            $link_types = $is_old ? old('link_type') : $link_types ?? [];
                            $options = $is_old ? old('option') : $options ?? [];
                            // dd($client_name);
                            $statuses = $is_old ? old('status') : $statuses ?? [];
                            $methods = $is_old ? old('method') : $methods ?? [];
                            $vendors = $is_old ? old('vendor') : $vendors ?? [];
                            $bts_pop_ldps = $is_old ? old('bts_pop_ldp') : $bts_pop_ldps ?? [];
                            $gps = $is_old ? old('gps') : $gps ?? [];
                            $distances = $is_old ? old('distance') : $distances ?? [];
                            $current_capacities = $is_old ? old('current_capacity') : $current_capacities ?? [];
                            $remarks = $is_old ? old('remarks') : $remarks ?? [];
                            $details_ids = $details_ids ?? [];
                            
                        @endphp
                        {{-- exiting or new radio button --}}
                        <div class="col-xl-4 col-md-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="client_type">Date<span
                                        class="text-danger">*</span></label>
                                <input class="form-control" id="date" name="date" aria-describedby="date"
                                    value="{{ old('date') ?? ($date ?? '') }}" readonly placeholder="Select a Date">
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="client_id">Client ID<span
                                        class="text-danger">*</span></label>
                                <input class="form-control" id="client_id" name="client_id" aria-describedby="client_id"
                                    value="{{ $client_id ?? '' }}" readonly placeholder="Client ID">
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="client_name">Client Name<span
                                        class="text-danger">*</span></label>
                                <input class="form-control" id="client_name" name="client_name"
                                    aria-describedby="client_name" value="{{ $client_name ?? '' }}" readonly
                                    placeholder="Client Name">
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="link_name">Name of the link</label>
                                <input type="text" name="link_name" id="link_name" class="form-control"
                                    placeholder="Name of the link" value="{{ $link_name }}" required>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="fr_id">FR ID</label>
                                <input type="text" name="fr_no" id="fr_no" class="form-control" placeholder="FR ID"
                                    value="{{ $fr_no }}" readonly>
                            </div>
                        </div>
                        {{-- create a responsive table --}}
                    </div>
                </div>
                <br>
                <div class="text-center"
                    style="border-top: 1px solid #d2d2d2; padding: 12px; border-bottom: 1px solid #d2d2d2;">
                    <h5> <span> &#10070; </span> Survey Details <span>&#10070;</span> </h5>
                </div>
                <br>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Link Type</th>
                                <th>Option</th>
                                <th>Status</th>
                                <th>Method</th>
                                <th>Vendor</th>
                                <th>BTS/POP/LDP</th>
                                <th>GPS</th>
                                <th>Distance</th>
                                <th>Current Capacity</th>
                                <th>Remarks</th>
                                <th>
                                    <button type="button" class="btn btn-sm btn-primary" id="addRow">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($link_types))
                                @foreach ($link_types as $key => $link_type)
                                    <tr class="feasibility_details_row">
                                        <td>
                                            <div class="input-group input-group-sm input-group-primary">
                                                @if (!empty($details_ids[$key]))
                                                    <input type="hidden" name="details_id[]"
                                                        value="{{ $details_ids[$key] }}">
                                                @endif
                                                <select name="link_type[]" id="link_type" class="form-control">
                                                    <option value="">Select Link Type</option>
                                                    <option value="Primary" {{ $link_type == 'Primary' ? 'selected' : '' }}>
                                                        Primary</option>
                                                    <option value="Secondary"
                                                        {{ $link_type == 'Secondary' ? 'selected' : '' }}>
                                                        Secondary</option>
                                                    <option value="Tertiary"
                                                        {{ $link_type == 'Tertiary' ? 'selected' : '' }}>
                                                        Tertiary</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm input-group-primary">
                                                <select name="option[]" id="option" class="form-control">
                                                    <option value="">Select Option</option>
                                                    <option value="Option 1"
                                                        {{ $options[$key] == 'Option 1' ? 'selected' : '' }}>
                                                        Option 1</option>
                                                    <option value="Option 2"
                                                        {{ $options[$key] == 'Option 2' ? 'selected' : '' }}>
                                                        Option 2</option>
                                                    <option value="Option 3"
                                                        {{ $options[$key] == 'Option 3' ? 'selected' : '' }}>
                                                        Option 3</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm input-group-primary">
                                                <select name="status[]" id="status" class="form-control">
                                                    <option value="">Select Status</option>
                                                    <option value="Existing"
                                                        {{ $statuses[$key] == 'Existing' ? 'selected' : '' }}>
                                                        Existing</option>
                                                    <option value="New"
                                                        {{ $statuses[$key] == 'New' ? 'selected' : '' }}>New</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm input-group-primary">
                                                <select name="method[]" id="method" class="form-control">
                                                    <option value="">Select Method</option>
                                                    <option value="Fiber"
                                                        {{ $methods[$key] == 'Fiber' ? 'selected' : '' }}>Fiber</option>
                                                    <option value="Radio"
                                                        {{ $methods[$key] == 'Radio' ? 'selected' : '' }}>Radio</option>
                                                    <option value="GSM"
                                                        {{ $methods[$key] == 'GSM' ? 'selected' : '' }}>GSM</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm input-group-primary">
                                                <input type="text" name="vendor[]" id="vendor"
                                                    class="form-control" placeholder="Vendor"
                                                    value="{{ $vendors[$key] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm input-group-primary">
                                                <input type="text" name="bts_pop_ldp[]" id="bts_pop_ldp"
                                                    class="form-control" placeholder="BTS/POP/LDP"
                                                    value="{{ $bts_pop_ldps[$key] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm input-group-primary">
                                                <input type="text" name="gps[]" id="gps" class="form-control"
                                                    placeholder="GPS" value="{{ $gps[$key] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm input-group-primary">
                                                <input type="text" name="distance[]" id="distance"
                                                    class="form-control" placeholder="Distance"
                                                    value="{{ $distances[$key] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm input-group-primary">
                                                <input type="text" name="current_capacity[]" id="current_capacity"
                                                    class="form-control" placeholder="Current Capacity"
                                                    value="{{ $current_capacities[$key] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm input-group-primary">
                                                <input type="text" name="remarks[]" id="remarks"
                                                    class="form-control" placeholder="Remarks"
                                                    value="{{ $remarks[$key] }}">
                                            </div>
                                        </td>
                                        <td>
                                            <button type="button"
                                                @if (!empty($details_ids[$key])) details_attr="{{ $details_ids[$key] }}" @endif
                                                class="btn btn-sm btn-danger removeRow">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="feasibility_details_row">
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <select name="link_type[]" id="link_type" class="form-control">
                                                <option value="">Select Link Type</option>
                                                <option value="Primary">Primary</option>
                                                <option value="Secondary">Secondary</option>
                                                <option value="Tertiary">Tertiary</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <select name="option[]" id="option" class="form-control">
                                                <option value="">Select Option</option>
                                                <option value="Option 1">Option 1</option>
                                                <option value="Option 2">Option 2</option>
                                                <option value="Option 3">Option 3</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <select name="status[]" id="status" class="form-control">
                                                <option value="">Select Status</option>
                                                <option value="Existing">Existing</option>
                                                <option value="New">New</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <select name="method[]" id="method" class="form-control">
                                                <option value="">Select Method</option>
                                                <option value="Fiber">Fiber</option>
                                                <option value="Radio">Radio</option>
                                                <option value="GSM">GSM</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="vendor[]" id="vendor" class="form-control"
                                                placeholder="Vendor">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="bts_pop_ldp[]" id="bts_pop_ldp"
                                                class="form-control" placeholder="BTS/POP/LDP">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="gps[]" id="gps" class="form-control"
                                                placeholder="GPS">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="distance[]" id="distance" class="form-control"
                                                placeholder="Distance">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="current_capacity[]" id="current_capacity"
                                                class="form-control" placeholder="Current Capacity">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm input-group-primary">
                                            <input type="text" name="remarks[]" id="remarks" class="form-control"
                                                placeholder="Remarks">
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger removeRow" attr_one=''><i
                                                class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <button class="py-2 btn btn-success ">{{ !empty($lead_generation->id) ? 'Update' : 'Save' }}</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section('script')
    <script>
        $('#addRow').on('click', function() {
            addRow();
        });

        function addRow() {
            $('.feasibility_details_row').first().clone().appendTo('tbody');
            $('.feasibility_details_row').last().find('input').val('');
            $('.feasibility_details_row').last().find('select').val('');
        };

        $(document).on('click', '.removeRow', function() {
            let count = $('.feasibility_details_row').length;
            if (count > 1) {

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
                $(this).closest('tr').remove();
            }
        });

        $('#client_id').on('input', function() {
            var client_id = $(this).val();
            console.log(client_id)
            $(this).autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('get-client') }}",
                        data: {
                            client_id: client_id,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                select: function(event, ui) {
                    $('#client_id').val(ui.item.label);
                    $('#client_name').val(ui.item.value);
                    $('#lead_generation_id').val(ui.item.lead_generation_id);
                    return false;
                }
            });
        });
        $('#date').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true,
            showOtherMonths: true
        }).datepicker("setDate", new Date());
    </script>
@endsection
