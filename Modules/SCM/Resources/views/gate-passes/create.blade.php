@extends('layouts.backend-layout')
@section('title', 'Gate Pass')

@php
    $is_old = old('prs_no') ? true : false;
    $form_heading = !empty($gate_pass->id) ? 'Update' : 'Add';
    $form_url = !empty($gate_pass->id) ? route('gate-passes.update', $gate_pass->id) : route('gate-passes.store');
    $form_method = !empty($gate_pass->id) ? 'PUT' : 'POST';
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

        <div class="col-md-12">
            <div class="typeSection mt-2 mb-4">
                <div class="form-check-inline">
                    <label class="form-check-label" for="challan">
                        <input type="radio" class="form-check-input radioButton" id="challan" name="type"
                            value="challan" @checked(@$gate_pass->type == 'challan' || old('type') == 'challan' || $form_method == "POST" )> Challan
                    </label>
                </div>

                <div class="form-check-inline">
                    <label class="form-check-label" for="mir">
                        <input type="radio" class="form-check-input radioButton" id="mir" name="type"
                            @checked(@$gate_pass->type == 'mir' || old('type') == 'mir') value="mir">
                        MIR
                    </label>
                </div>
            </div>
        </div>
        @if (!empty($gate_pass->id))
        <div class="form-group col-3">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="name">Gate Pass No <span class="text-danger">*</span></label>
                <input class="form-control" id="gate_pass_no" name="gate_pass_no" aria-describedby="gate_pass_no"
                    value="{{ old('gate_pass_no') ?? ($gate_pass->gate_pass_no ?? '') }}" readonly placeholder="gate_pass No">
            </div>
        </div>
        @endif
        <div class="form-group col-3">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="date">Date <span class="text-danger">*</span></label>
                <input class="form-control" id="date" name="date" aria-describedby="date"
                    value="{{ old('date') ?? ($gate_pass->date ?? '') }}" readonly placeholder="Select a Date">
            </div>
        </div>
        <div class="form-group col-3">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="carrier_name">Carrier Name <span class="text-danger">*</span></label>
                <input class="form-control" id="carrier_name" name="carrier_name" aria-describedby="carrier_name"
                    value="{{ old('carrier_name') ?? ($gate_pass->carrier ?? '') }}" placeholder="Carrier Name">
            </div>
        </div>
        <table class="table table-bordered" id="gate_pass">
            <thead>
                <tr>
                    <th class="challan" style="display: none"> Challan No.</th>
                    <th class="mir" style="display: none"> MIR No.</th>
                    <th> Remarks</th>
                    <th><i class="btn btn-primary btn-sm fa fa-plus add-gate-pass"></i></th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
                @php
                    $challan_no = old('challan_no', !empty($gate_pass) ? $gate_pass->lines->pluck('challan.challan_no') : []);
                    $challan_id = old('challan_id', !empty($gate_pass) ? $gate_pass->lines->pluck('challan_id') : []);
                    $mir_no = old('challan_no', !empty($gate_pass) ? $gate_pass->lines->pluck('mir.mir_no') : []);
                    $mir_id = old('challan_id', !empty($gate_pass) ? $gate_pass->lines->pluck('mir_id') : []);
                    $remarks = old('brand_id', !empty($gate_pass) ? $gate_pass->lines->pluck('remarks') : []);
                @endphp
                @foreach ($remarks as $key => $requisitionDetail)
                    <tr>
                        <td class="challan">
                            <input type="text" name="challan_no[]" class="form-control challan_no" autocomplete="off" value="{{$challan_no[$key]}}">
                            <input type="hidden" name="challan_id[]" class="form-control challan_id" autocomplete="off" value="{{$challan_id[$key]}}">
                        </td>
                        <td class="mir">
                            <input type="text" name="mir_no[]" class="form-control mir_no" autocomplete="off" value="{{$mir_no[$key]}}">
                            <input type="hidden" name="mir_id[]" class="form-control mir_id" autocomplete="off" value="{{$mir_id[$key]}}">
                        </td>
                        <td>
                            <input type="text" name="remarks[]" class="form-control remarks" autocomplete="off" readonly
                                value="{{ $remarks[$key] }}">
                        </td>
                        <td class="text-center">
                            <i class="btn btn-danger btn-sm fa fa-minus remove-gate-pass"></i>
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

        function appendCalculationRow() {
            var type = $("input[name=type]:checked").val()
            console.log(type)
            let row = `<tr>
                            ${ type === 'mir' ?
                            `<td class="mir">
                                <input type="text" name="mir_no[]" class="form-control mir_no" autocomplete="off">
                                <input type="hidden" name="mir_id[]" class="form-control mir_id" autocomplete="off">
                            </td>
                            <td class="challan" style="display: none">
                                <input type="text" name="challan_no[]" class="form-control challan_no" autocomplete="off">
                                <input type="hidden" name="challan_id[]" class="form-control challan_id" autocomplete="off">
                            </td>
                            `
                            :
                            `<td class="challan">
                                <input type="text" name="challan_no[]" class="form-control challan_no" autocomplete="off">
                                <input type="hidden" name="challan_id[]" class="form-control challan_id" autocomplete="off">
                            </td>
                            <td class="mir" style="display: none">
                                <input type="text" name="mir_no[]" class="form-control mir_no" autocomplete="off">
                                <input type="hidden" name="mir_id[]" class="form-control mir_id" autocomplete="off">
                            </td>
                            `
                             }
                            <td>
                                <input type="text" name="remarks[]" class="form-control remarks" autocomplete="off">
                            </td>
                            <td>
                                <i class="btn btn-danger btn-sm fa fa-minus remove-gate-pass"></i>
                            </td>
                    </tr>`;
            $('#gate_pass tbody').append(row);
        }

        /* Adds and removes quantity row on click */
        $("#gate_pass")
            .on('click', '.add-gate-pass', () => {
                appendCalculationRow();
            })
            .on('click', '.remove-gate-pass', function() {

                $(this).closest('tr').remove();
            });
            $(document).on('keyup','.challan_no',function(){
                var event_this_challan = $(this).closest('tr');
                let myObject = {
                    challan_no: event_this_challan.find('.challan_no').val(),
                }

                jquaryUiAjax($(this), "{{ route('searchChallanNo') }}", uiList, myObject);

                function uiList(item) {
                    event_this_challan.find('.challan_id').val(item.id);
                    event_this_challan.find('.challan_no').val(item.value);
                    return false;
                }

            })

            $(document).on('keyup','.mir_no',function(){
                var event_this_mir = $(this).closest('tr');
                let myObject = {
                    mir_no: event_this_mir.find('.mir_no').val(),
                }

                jquaryUiAjax($(this), "{{ route('searchMirNo') }}", uiList, myObject);

                function uiList(item) {
                    event_this_mir.find('.mir_id').val(item.id);
                    event_this_mir.find('.mir_no').val(item.value);
                    return false;
                }

            })

        // $('#date').datepicker({
        //     format: "dd-mm-yyyy",
        //     autoclose: true,
        //     todayHighlight: true,
        //     showOtherMonths: true
        // }).datepicker("setDate", new Date());

        if ($('#date').val() != null)
        {
            $('#date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                showOtherMonths: true
            });
        }else {
            $('#date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                showOtherMonths: true
            }).datepicker("setDate", new Date());
        }

        $(function() {
            onChangeRadioButton();
            @if (empty($gate_pass) && empty(old('material_name')))
            appendCalculationRow();
        @endif
        $(".radioButton").click(function() {
                onChangeRadioButton()
            });
        });

        function onChangeRadioButton() {
            var radioValue = $("input[name='type']:checked").val();
            if (radioValue == 'challan') {
                $('.mir').hide('slow');
                $('.challan').show('slow');
            } else if (radioValue == 'mir') {
                $('.mir').show('slow');
                $('.challan').hide('slow');
            }
        }
    </script>
@endsection
