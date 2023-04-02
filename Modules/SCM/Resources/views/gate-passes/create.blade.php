@extends('layouts.backend-layout')
@section('title', 'Gate Pass')

@php
    $is_old = old('prs_no') ? true : false;
    $form_heading = !empty($indent->id) ? 'Update' : 'Add';
    $form_url = !empty($indent->id) ? route('gate-passes.update', $indent->id) : route('gate-passes.store');
    $form_method = !empty($indent->id) ? 'PUT' : 'POST';
@endphp

@section('breadcrumb-title')
    {{ ucfirst($form_heading) }} Gate Pass
@endsection

@section('breadcrumb-button')
    <a href="{{ route('gate-passes.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
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

    <div class="row">
        @if (!empty($indent->id))
            <div class="form-group col-3">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="name">Indent No <span class="text-danger">*</span></label>
                    <input class="form-control" id="indent_no" name="indent_no" aria-describedby="indent_no"
                        value="{{ old('indent_no') ?? ($indent->indent_no ?? '') }}" readonly placeholder="Indent No">
                </div>
            </div>
        @endif
        <div class="form-group col-3">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="date">Date <span class="text-danger">*</span></label>
                <input class="form-control" id="date" name="date" aria-describedby="date"
                    value="{{ old('date') ?? ($indent->date ?? '') }}" readonly placeholder="Select a Date">
            </div>
        </div>
        <div class="form-group col-3">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="carrier_name">Carrier Name <span class="text-danger">*</span></label>
                <input class="form-control" id="carrier_name" name="carrier_name" aria-describedby="carrier_name"
                    value="{{ old('date') ?? ($indent->date ?? '') }}" placeholder="Carrier Name">
            </div>
        </div>
        <table class="table table-bordered" id="material_requisition">
            <thead>
                <tr>
                    <th> Challan No.</th>
                    <th> MIR No.</th>
                    <th> Remarks</th>
                    <th><i class="btn btn-primary btn-sm fa fa-plus add-requisition-row"></i></th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
                @php
                    $quantity = old('quantity', !empty($requisition) ? $requisition->scmRequisitiondetails->pluck('quantity') : []);
                    $brand_id = old('brand_id', !empty($requisition) ? $requisition->scmRequisitiondetails->pluck('brand_id') : []);
                    $model = old('model', !empty($requisition) ? $requisition->scmRequisitiondetails->pluck('model') : []);
                    $purpose = old('purpose', !empty($requisition) ? $requisition->scmRequisitiondetails->pluck('purpose') : []);
                @endphp
                @foreach ($quantity as $key => $requisitionDetail)
                    <tr>
                        <td>
                            <input type="text" name="unit[]" class="form-control unit" autocomplete="off" readonly
                                value="{{ $unit[$key] }}">
                        </td>
                        <td>
                            <input type="text" name="unit[]" class="form-control unit" autocomplete="off" readonly
                                value="{{ $unit[$key] }}">
                        </td>
                        <td>
                            <input type="text" name="unit[]" class="form-control unit" autocomplete="off" readonly
                                value="{{ $unit[$key] }}">
                        </td>
                        <td>
                            <input type="text" name="unit[]" class="form-control unit" autocomplete="off" readonly
                                value="{{ $unit[$key] }}">
                        </td>
                        <td>
                            <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i>
                        </td>
                    </tr>
                @endforeach
            </tfoot>
        </table>
    </div>

    <div class="row">
        <div class="offset-md-4 col-md-4 mt-2">
            <div class="input-group input-group-sm ">
                <button class="btn btn-success btn-round btn-block py-2">Submit</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section('script')
    <script>
        /* Append row */
        @if (empty($requisition) && empty(old('material_name')))
            appendCalculationRow();
        @endif
        function appendCalculationRow() {
            let row = `<tr>
                            <td>
                                <input type="text" name="challan_no[]" class="form-control challan_no" autocomplete="off">
                            </td>
                            <td>
                                <input type="text" name="mir_no[]" class="form-control mir_no" autocomplete="off">
                            </td>
                            <td>
                                <input type="text" name="remarks[]" class="form-control remarks" autocomplete="off">
                            </td>
                            <td>
                                <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i>
                            </td>
                    </tr>
                    `;
            $('#material_requisition tbody').append(row);
        }

        /* Adds and removes quantity row on click */
        $("#material_requisition")
            .on('click', '.add-requisition-row', () => {
                appendCalculationRow();
            })
            .on('click', '.remove-calculation-row', function() {
                if ($('#material_requisition tbody tr').length == 1) {
                    return;
                }
                $(this).closest('tr').remove();
            });

        $('#date').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true,
            showOtherMonths: true
        }).datepicker("setDate", new Date());
    </script>
@endsection
