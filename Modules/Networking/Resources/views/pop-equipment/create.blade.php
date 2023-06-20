@extends('layouts.backend-layout')
@section('title', 'Pop Wise Equipment')
@php
    $is_old = old('type') ? true : false;
    $form_heading = !empty($err) ? 'Update' : 'Add';
    $form_url = !empty($err) ? route('pop-equipment.update', $err->id) : route('pop-equipment.store');
    $form_method = !empty($err) ? 'PUT' : 'POST';
    
    $date = old('date', !empty($err) ? $err->date : null);
    $type = old('date', !empty($err) ? $err->type : null);
    $purpose = old('purpose', !empty($err) ? $err->purpose : null);
    $assigned_person = old('assigned_person', !empty($err) ? $err->assigned_person : null);
    $reason_of_inactive = old('reason_of_inactive', !empty($err) ? $err->reason_of_inactive : null);
    $equipment_type = old('equipment_type', !empty($err) ? $err?->equipment_type : null);
    $client_id = old('client_id', !empty($err) ? $err->client_id : null);
    $fr_no = old('fr_no', !empty($err) ? $err->fr_no : null);
    $client_name = old('client_name', !empty($err) ? $err?->client?->client_name : null);
    $client_no = old('client_no', !empty($err) ? $err?->client_no : null);
    $client_link_no = old('client_link_no', !empty($err) ? $err?->link_no : null);
    $client_address = old('client_address', !empty($err) ? $err?->client?->location : null);
    $branch_id = old('branch_id', !empty($err) ? $err->branch_id : null);
    $branch_name = old('branch_id', !empty($err) ? $err?->branch?->name : null);
    $pop_id = old('pop_id', !empty($err) ? $err->pop_id : null);
    $pop_name = old('pop_name', !empty($err) ? $err?->pop?->name : null);
    $pop_address = old('pop_address', !empty($err) ? $err?->pop?->address : null);
    $inactive_date = old('inactive_date', !empty($err) ? $err->inactive_date : null);
@endphp

@section('breadcrumb-title')
    {{ $form_heading }} Pop Wise Equipment
@endsection

@section('style')
    <style>
        .input-group-addon {
            min-width: 120px;
        }

        .input-group-info .input-group-addon {
            /*background-color: #04748a!important;*/
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice span {
            color: #b10000;
        }

        .select2_container {
            max-width: 200px;
            white-space: inherit;
        }
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('errs.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'col-12')

@section('content')
    {!! Form::open([
        'url' => $form_url,
        'method' => $form_method,
        'encType' => 'multipart/form-data',
        'class' => 'custom-form',
    ]) !!}
    <div class="row">
        <div class="form-group col-3">
            <label for="date">Applied Date:</label>
            <input class="form-control date" id="date" name="date" aria-describedby="date"
                value="{{ old('date') ?? (@$date ?? '') }}" readonly placeholder="Select a Date">
        </div>

        <div class="form-group col-3">
            <label for="select2">Purpose</label>
            <select class="form-control select2" id="purpose" name="purpose">
                <option value="" selected>Select Purpose</option>
                @foreach (config('businessinfo.errReturnFor') as $key => $value)
                    <option value="{{ $value }}" {{ old('purpose', @$purpose) == $value ? 'selected' : '' }}>
                        {{ $value }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-3">
            <label for="select2">From Branch</label>
            <select class="form-control select2" id="branch_id" name="branch_id">
                <option value="" selected>Select Branch</option>
            </select>
        </div>

        <div class="form-group col-3 assigned_person">
            <label for="assigned_person">Assigned Person:</label>
            <input type="text" class="form-control" id="assigned_person" aria-describedby="assigned_person"
                name="assigned_person" value="{{ old('assigned_person') ?? (@$assigned_person ?? '') }}">
        </div>

        <div class="form-group col-3 reason_of_inactive">
            <label for="reason_of_inactive">Reason of Inactive:</label>
            <input type="text" class="form-control" id="reason_of_inactive" aria-describedby="reason_of_inactive"
                name="reason_of_inactive" value="{{ old('reason_of_inactive') ?? (@$reason_of_inactive ?? '') }}">
        </div>

        {{-- @dd($inactive_date) --}}
        <div class="form-group col-3 inactive_date">
            <label for="inactive_date">Permanently Inactive Date:</label>
            <input class="form-control date" id="inactive_date" name="inactive_date" aria-describedby="inactive_date"
                value="{{ old('inactive_date') ?? (@$inactive_date ?? '') }}" readonly placeholder="Select a Date">
        </div>
    </div>

    <div class="row">
        <div class="form-group col-3 pop_name">
            <label for="select2">Pop Name</label>
            <input class="form-control" id="pop_name" name="pop_name" aria-describedby="pop_name"
                value="{{ old('pop_name') ?? (@$pop_name ?? '') }}" placeholder="Search a POP Name">
            <input type="hidden" class="form-control" id="pop_id" name="pop_id" aria-describedby="pop_id"
                value="{{ old('pop_id') ?? (@$pop_id ?? '') }}">
        </div>
        <div class="form-group col-3 pop_address">
            <label for="select2">Pop Address</label>
            <input class="form-control" id="pop_address" name="pop_address" aria-describedby="pop_address"
                value="{{ old('pop_address') ?? (@$pop_address ?? '') }}" readonly placeholder="Select a POP Address">
        </div>
        <div class="form-group col-3 equipment_type">
            <label for="equipment_type">Type:</label>
            <select class="form-control select2" id="equipment_type" name="equipment_type">
                <option value="Service Equipment" @if ($equipment_type == 'Service Equipment') selected @endif>Service Equipment
                </option>
                <option value="Link" @if ($equipment_type == 'Link') selected @endif>Link</option>
            </select>

        </div>
        <div class="form-group col-3 client_name">
            <label for="client_name">Client Name:</label>
            <input type="text" class="form-control" id="client_name"
                aria-describedby="client_name" name="client_name"
                value="{{ old('client_name') ?? (@$client_name ?? '') }}" placeholder="Search...">
        </div>

        <div class="form-group col-3 fr_no">
            <label for="select2">FR No</label>
            <select class="form-control select2" id="fr_no" name="fr_no">
                <option value="" readonly selected>Select FR No</option>
                @if ($form_method == 'POST')
                    <option value="{{ old('fr_no') }}" selected>{{ old('fr_no') }}</option>
                @elseif($form_method == 'PUT')
                    @forelse ($fr_nos as $key => $value)
                        <option value="{{ $value->fr_no }}" @if ($fr_no == $value->fr_no) selected @endif>
                            {{ $value->fr_no }}
                        </option>
                    @empty
                    @endforelse
                @endif
            </select>
        </div>

        <div class="form-group col-3 link_no">
            <label for="link_no">Link No:</label>
            <select class="form-control select2" id="link_no" name="link_no">
                <option value="" readonly selected>Select Link No</option>
                @if ($form_method == 'POST')
                    <option value="{{ old('link_no') }}" selected>{{ old('link_no') }}</option>
                @elseif($form_method == 'PUT')
                    @forelse ($client_links as $key => $value)
                        <option value="{{ $value->link_no }}" @if ($client_link_no == $value->link_no) selected @endif>
                            {{ $value->link_no }}
                        </option>
                    @empty
                    @endforelse
                @endif
            </select>
        </div>

        <div class="form-group col-3 client_no">
            <label for="client_no">Client No:</label>
            <input type="text" class="form-control" id="client_no" aria-describedby="client_no" name="client_no"
                readonly value="{{ old('client_no') ?? (@$client_no ?? '') }}">
        </div>

        <div class="form-group col-3 client_address">
            <label for="client_address">Client Address:</label>
            <input type="text" class="form-control" id="client_address" name="client_address"
                aria-describedby="client_address" readonly
                value="{{ old('client_address') ?? (@$client_address ?? '') }}">
        </div>
    </div>

    <div class="row">
        <div class="offset-md-4 col-md-4 mt-2">
            <div class="input-group input-group-sm ">
                <button class="btn btn-success btn-round btn-block py-2">Submit</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/search-client.js') }}"></script>
    <script>
        @if ($form_method == 'POST')
            $('.date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                showOtherMonths: true
            }).datepicker("setDate", new Date());;
        @else
            $('.date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                showOtherMonths: true
            });
        @endif

        $(function() {

            $('.select2').select2({
                maximumSelectionLength: 5,
                scrollAfterSelect: true
            });

            //using form custom function js file
            fillSelect2Options("{{ route('searchBranch') }}", '#branch_id');

         
            $("#pop_name").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('searchPop') }}",
                        type: 'get',
                        dataType: "json",
                        data: {
                            search: request.term
                        },
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                select: function(event, ui) {
                    $(this).val(ui.item.label);
                    $('#pop_id').val(ui.item.id);
                    $('#pop_address').val(ui.item.address);
                    $('#pop_id').trigger('change');

                    return false;
                }
            })
        });

        

        @if ($form_method == 'PUT')
            $(document).on('DOMNodeInserted', '#branch_id', function() {
                let selectedValue = "{{ $branch_id }}"
                $('#branch_id').val(selectedValue)
            });
        @endif

        
       
    </script>

@endsection