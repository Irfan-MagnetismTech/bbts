@extends('layouts.backend-layout')
@section('title', 'Equipment Restore Report')
@php
    $is_old = old('type') ? true : false;
    $form_heading = !empty($err) ? 'Update' : 'Add';
    $form_url = !empty($err) ? route('errs.update', $err->id) : route('errs.store');
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
    {{ $form_heading }} Equipment Restore Report (ERR)
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

    <table class="table table-bordered" id="errTable">
        <thead>
            <tr>
                <th>Material Name</th>
                <th>Description</th>
                <th>Provided Qty</th>
                <th>Item Code</th>
                <th>Unit</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Serial/Drum Code <br /> No</th>
                <th>Ownership</th>
                <th>Damaged</th>
                <th>Useable</th>
                <th>Quantity</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @php
                // dd($err->scmErrLines);
                $material_names = old('material_name', !empty($err) ? $err->scmErrLines->pluck('material.name') : []);
                $material_ids = old('material_id', !empty($err) ? $err->scmErrLines->pluck('material_id') : []);
                $descriptions = old('description', !empty($err) ? $err->scmErrLines->pluck('description') : []);
                $utilized_quantitys = old('utilized_quantity', !empty($err) ? $err->scmErrLines->pluck('utilized_quantity') : []);
                $item_codes = old('item_code', !empty($err) ? $err->scmErrLines->pluck('item_code') : []);
                $units = old('unit', !empty($err) ? $err->scmErrLines->pluck('material.unit') : []);
                $brand_names = old('brand_name', !empty($err) ? $err->scmErrLines->pluck('brand.name') : []);
                $brand_ids = old('brand_id', !empty($err) ? $err->scmErrLines->pluck('brand_id') : []);
                $models = old('model', !empty($err) ? $err->scmErrLines->pluck('model') : []);
                $serial_codes = old('material_id', !empty($err) ? json_decode($err->scmErrLines->pluck('serial_code')) : []);
                $bbts_ownerships = old('bbts_ownership', !empty($err) ? $err->scmErrLines->pluck('bbts_ownership') : []);
                $client_ownerships = old('client_ownership', !empty($err) ? $err->scmErrLines->pluck('client_ownership') : []);
                $bbts_damageds = old('bbts_damaged', !empty($err) ? $err->scmErrLines->pluck('bbts_damaged') : []);
                $client_damageds = old('client_damaged', !empty($err) ? $err->scmErrLines->pluck('client_damaged') : []);
                $bbts_useables = old('bbts_useable', !empty($err) ? $err->scmErrLines->pluck('bbts_useable') : []);
                $client_useables = old('client_useable', !empty($err) ? $err->scmErrLines->pluck('client_useable') : []);
                $quantitys = old('quantity', !empty($err) ? $err->scmErrLines->pluck('quantity') : []);
                $remarks = old('warranty_period', !empty($err) ? $err->scmErrLines->pluck('remarks') : []);
            @endphp

            @foreach ($material_names as $key => $material_name)
                <tr>
                    <td>
                        <input name="material_name[]" class="form-control material_name" readonly autocomplete="off"
                            type="text" value="{{ $material_name }}" readonly>
                        <input name="material_id[]" class="form-control material_id" readonly autocomplete="off"
                            type="hidden" value="{{ $material_ids[$key] }}">
                    </td>
                    <td>
                        <input name="description[]" class="form-control description" autocomplete="off" type="text"
                            value="{{ $descriptions[$key] }}">
                    </td>
                    <td>
                        <input name="utilized_quantity[]" class="form-control utilized_quantity" autocomplete="off"
                            type="text" value="{{ $utilized_quantitys[$key] }}" readonl>
                    </td>
                    <td>
                        <input name="item_code[]" class="form-control item_code" autocomplete="off" type="text"
                            value="{{ $item_codes[$key] }}" readonly>
                    </td>
                    <td>
                        <input name="unit[]" class="form-control unit" autocomplete="off" type="text"
                            value="{{ $units[$key] }}" readonly>
                    </td>
                    <td>
                        <input name="brand_name[]" class="form-control brand_name" autocomplete="off" type="text"
                            value="{{ $brand_names[$key] }}" readonly>
                        <input name="brand_id[]" class="form-control brand_id" autocomplete="off" type="hidden"
                            value="{{ $brand_ids[$key] }}">
                    </td>
                    <td>
                        <input name="model[]" class="form-control model" autocomplete="off" type="text"
                            value="{{ $models[$key] }}" readonly>
                    </td>
                    <td>
                        <input name="serial_code[]" class="form-control serial_code" autocomplete="off" type="text"
                            value="{{ $serial_codes[$key] }}" readonly>
                    </td>
                    <td>
                        <input name="bbts_ownership[]" class="form-control bbts_ownership" autocomplete="off"
                            type="text" value="{{ $bbts_ownerships[$key] }}" readonly>
                    </td>
                    <td>
                        <input name="client_ownership[]" class="form-control client_ownership" autocomplete="off"
                            type="text" value="{{ $client_ownerships[$key] }}" readonly>
                    </td>
                    <td>
                        <input name="bbts_damaged[]" class="form-control bbts_damaged" autocomplete="off" type="number"
                            value="{{ $bbts_damageds[$key] }}">
                    </td>
                    <td>
                        <input name="client_damaged[]" class="form-control client_damaged" autocomplete="off"
                            type="number" value="{{ $client_damageds[$key] }}">
                    </td>
                    <td>
                        <input name="bbts_useable[]" class="form-control bbts_useable" autocomplete="off" type="number"
                            value="{{ $bbts_useables[$key] }}">
                    </td>
                    <td>
                        <input name="client_useable[]" class="form-control client_useable" autocomplete="off"
                            type="number" value="{{ $client_useables[$key] }}">
                    </td>
                    <td>
                        <input name="quantity[]" class="form-control quantity" autocomplete="off" type="number"
                            value="{{ $quantitys[$key] }}" readonly>
                    </td>
                    <td>
                        <input name="remarks[]" class="form-control remarks" autocomplete="off"
                            value="{{ $remarks[$key] }}">
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

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

@endsection
