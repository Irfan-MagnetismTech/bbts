@extends('layouts.backend-layout')
@section('title', 'Challan')
@php
    $is_old = old('type') ? true : false;
    $form_heading = !empty($challan) ? 'Update' : 'Add';
    $form_url = !empty($challan) ? route('challans.update', $challan->id) : route('challans.store');
    $form_method = !empty($challan) ? 'PUT' : 'POST';
    
    $date = old('date', !empty($challan) ? $challan->date : null);
    $type = old('date', !empty($challan) ? $challan->type : null);
    $scm_requisition_id = old('scm_requisition_id', !empty($challan) ? $challan->scm_requisition_id : null);
    $scm_requisition_no = old('mrs_no', !empty($challan) ? $challan->scmRequisition->mrs_no : null);
    $purpose = old('purpose', !empty($challan) ? $challan->purpose : null);
    $client_id = old('client_id', !empty($challan) ? $challan->client_id : null);
    $client_name = old('client_name', !empty($challan) ? $challan?->client?->name : null);
    $client_fr_composite_key = old('client_name', !empty($challan) ? $challan?->client_fr_composite_key : null);
    $client_no = old('client_no', !empty($challan) ? $challan?->client?->client_no : null);
    $client_address = old('client_address', !empty($challan) ? $challan?->client?->address : null);
    $branch_id = old('branch_id', !empty($challan) ? $challan->branch_id : null);
    $branch_name = old('branch_id', !empty($challan) ? $challan?->branch?->name : null);
    $pop_id = old('pop_id', !empty($challan) ? $challan->pop_id : null);
    $pop_name = old('pop_name', !empty($challan) ? $challan?->pop?->name : null);
    $pop_address = old('pop_address', !empty($challan) ? $challan?->pop?->address : null);
    
@endphp

@section('breadcrumb-title')
{{ $form_heading }} Challan
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

        .select2_container{
            max-width: 200px;
            white-space: inherit;
        }

    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('challans.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-database"></i></a>
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
                <div class="col-md-12">
                    <div class="
                     mt-2 mb-4">
                        <div class="form-check-inline">
                            <label class="form-check-label" for="client">
                                <input type="radio" class="form-check-input radioButton" id="client" name="type"
                                    value="client" @checked(@$type == 'client' || ($form_method == 'POST' && !old()))> Client
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label" for="pop">
                                <input type="radio" class="form-check-input radioButton" id="pop" name="type"
                                    value="pop" @checked(@$type == 'pop')>
                                POP
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label" for="general">
                                <input type="radio" class="form-check-input radioButton" id="general" name="type"
                                    value="general" @checked(@$type == 'general')>
                                General
                            </label>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-3 date">
                    <label for="date">Applied Date:</label>
                    <input class="form-control" id="date" name="date" aria-describedby="date"
                        value="{{ old('date') ?? (@$date ?? '') }}" readonly placeholder="Select a Date">
                </div>
                <div class="form-group col-3 mrs_no">
                    <label for="select2">MRS No</label>
                    <input class="form-control" id="mrs_no" name="mrs_no" aria-describedby="mrs_no"
                        value="{{ old('mrs_no') ?? (@$scm_requisition_no ?? '') }}" placeholder="Search a MRS No">
                        <input class="form-control" id="scm_requisition_id" name="scm_requisition_id" aria-describedby="scm_requisition_id"
                        value="{{ old('scm_requisition_id') ?? (@$scm_requisition_id ?? '')}}" type="hidden">
                </div>
                <div class="form-group col-3">
                    <label for="select2">Purpose</label>
                    <select class="form-control select2" id="purpose" name="purpose">
                        <option value="" selected>Select Purpose</option>
                        @foreach (config('businessinfo.challanPurpose') as $key => $value)
                            <option value="{{ $value }}"
                                {{ old('purpose', @$purpose) == $value ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-3 branch_name">
                    <label for="select2">From Branch</label>
                    <select class="form-control select2" id="branch_id" name="branch_id">
                        <option value="" selected>Select Branch</option>
                        @foreach ($branchs as $option)
                            <option value="{{ $option->id }}"
                                {{ $branch_id == $option->id ? 'selected' : '' }}>
                                {{ $option->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
           
            <div class="row">
                

                <div class="form-group col-3 client_name">
                    <label for="client_name">Client Name:</label>
                    <input type="text" class="form-control" id="client_name" aria-describedby="client_name"
                        name="client_name" value="{{ old('client_name') ?? (@$client_name ?? '') }}"
                        placeholder="Search...">
                    <input type="hidden" name="client_id" id="client_id"
                        value="{{ old('client_id') ?? @$client_id }}">
                </div>
                <div class="form-group col-3 client_links">
                    <label for="select2">Client Links</label>
                    <select class="form-control select2" id="client_links" name="client_links">
                        <option value="" readonly selected>Select Client Link</option>
                        @if ($form_method == 'POST')
                            <option value="{{ old('client_links') }}" selected>{{ old('client_links') }}</option>
                        @endif
                        @if ($form_method == 'PUT')
                            @foreach ($client_links as $clientInfo)
                                <option value="{{ $clientInfo->link_name }}" @selected($clientInfo->fr_composite_key == @$client_fr_composite_key)>
                                    {{ $clientInfo->link_name }}</option>
                            @endforeach
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
                    <input type="text" class="form-control" id="client_address" name="client_address" aria-describedby="client_address"
                        readonly value="{{ old('client_address') ?? (@$client_address ?? '') }}">
                </div>
                
                <div class="form-group col-3 pop_name" style="display: none">
                    <label for="select2">Pop Name</label>
                    <input class="form-control" id="pop_name" name="pop_name" aria-describedby="pop_name"
                    value="{{ old('pop_name') ?? (@$pop_name ?? '') }}" placeholder="Search a POP Name">
                    <input type="hidden" class="form-control" id="pop_id" name="pop_id" aria-describedby="pop_id"
                    value="{{ old('pop_id') ?? (@$pop_id ?? '') }}">
                </div>
                <div class="form-group col-3 pop_address" style="display: none">
                    <label for="select2">Pop Address</label>
                    <input class="form-control" id="pop_address" name="pop_address" aria-describedby="pop_address"
                    value="{{ old('pop_address') ?? (@$pop_address ?? '') }}" readonly placeholder="Select a POP Address">
                </div>
            </div>

            <table class="table table-bordered" id="challan">
                <thead>
                    <tr>
                        <th>Received Type</th>
                        <th>Type No</th>
                        <th>Material Name</th>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Serial/Drum Code <br /> No</th>
                        <th>Unit</th>
                        <th>Available</th>
                        <th>Issued Qty</th>
                        <th>Remarks</th>
                        <th><i class="btn btn-primary btn-sm fa fa-plus add-challan-row"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $Challan_Lines = old('material_id', !empty($challan) ? $challan->scmChallanLines->pluck('material_id') : []);
                        $received_type = old('received_type', !empty($challan) ? $challan->scmChallanLines->pluck('received_type') : []);
                        $received_no = old('type_no', !empty($challan) ? $challan->scmChallanLines->pluck('received_no') : []);
                        $receiveable_id = old('type_id', !empty($challan) ? $challan->scmChallanLines->pluck('receiveable_id') : []);
                        $type_id = old('type_id', !empty($challan) ? $challan->scmChallanLines->pluck('type_id') : []);
                        $item_code = old('item_code', !empty($challan) ? $challan->scmChallanLines->pluck('material.code') : []);
                        $material_type = old('material_type', !empty($challan) ? $challan->scmChallanLines->pluck('material.type') : []);
                        $brand_id = old('brand_id', !empty($challan) ? $challan->scmChallanLines->pluck('brand_id') : []);
                        $model = old('model', !empty($challan) ? $challan->scmChallanLines->pluck('model') : []);
                        $material_id = old('material_id', !empty($challan) ? $challan->scmChallanLines->pluck('material_id') : []);
                        $serial_code = old('material_id', !empty($challan) ? json_decode($challan->scmChallanLines->pluck('serial_code')) : []);
                       
                        $unit = old('unit', !empty($challan) ? $challan->scmChallanLines->pluck('material.unit') : []);
                        $quantity = old('final_mark', !empty($challan) ? $challan->scmChallanLines->pluck('quantity') : []);
                        $remarks = old('warranty_period', !empty($challan) ? $challan->scmChallanLines->pluck('remarks') : []);
                       
                    @endphp
                    @foreach ($Challan_Lines as $key => $Challan_Line)
               
                        <tr>
                            <td>
                                <select name="received_type[{{$key}}]" class="form-control received_type" autocomplete="off">
                                    <option value="">Select Out From</option>
                                    @foreach (config('businessinfo.receivedTypes') as $typeKey => $typevalue)
                                        <option value="{{ $typevalue }}" @selected(($received_type[$key] == $typevalue))>{{ strToUpper($typevalue) }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" name="type_no[{{$key}}]" class="form-control type_no" autocomplete="off" value="{{ $received_no[$key] }}">
                                <input type="hidden" name="type_id[{{$key}}]" class="form-control type_id" autocomplete="off" value="{{ $receiveable_id[$key] }}">
                            </td>
                            <td class="form-group">
                                <select class="form-control material_name select2" name="material_name[{{$key}}]">
                                    <option value="" readonly selected>Select Material</option>
                                    @foreach ($materials[$key] as $key1 => $value)
                                        <option value="{{ $value->material->id }}" data-type="{{$value->material->type}}" data-unit="{{$value->material->unit}}" data-code="{{$value->material->code}}" readonly @selected($material_id[$key] == $value->material->id)>
                                            {{ $value->material->name }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="item_code[{{$key}}]" class="form-control item_code" autocomplete="off"
                                    value="{{ $item_code[$key] }}">
                                <input type="hidden" name="material_type[{{$key}}]" class="form-control material_type"
                                    autocomplete="off" value="{{ $material_type[$key] }}">
                            </td>
        
                            <td>
                                <select name="brand_id[{{$key}}]" class="form-control brand select2" autocomplete="off">
                                    <option value="">Select Brand</option>
                                    @foreach ($brands[$key] as $key1 => $value)
                                        <option value="{{ $value->brand->id }}" @selected($value->brand->id == $brand_id[$key])>
                                            {{ $value->brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
        
                            <td>
                                <select class="form-control model select2" name="model[{{$key}}]">
                                    <option value="" readonly selected>Select Model</option>
                                    @foreach ($models[$key] as $key1 => $value)
                                    <option value="{{ $value->model }}" @selected($value->model == $model[$key])>
                                        {{ $value->model }}
                                    </option>
                                @endforeach
                                </select>
                            </td>
                            <td class="select2_container">
                                <select class="form-control select2 serial_code" multiple name="serial_code[{{$key}}][]">
                                    @foreach($serial_codes[$key] as $key1 => $value)
                                        <option value="{{ $value->serial_code }}"
                                            @selected(in_array($value->serial_code,json_decode($serial_code[$key])))>
                                            {{ $value->serial_code }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input name="unit[{{$key}}]" class="form-control unit" readonly autocomplete="off" type="text" value="{{ $unit[$key] }}">
                            </td> 
                            <td>
                                <input name="avaiable_quantity[{{$key}}]" class="form-control avaiable_quantity" autocomplete="off" value="{{ $branch_stock[$key] }}">
                            </td>
                            <td>
                                <input name="quantity[{{$key}}]" class="form-control quantity" autocomplete="off" @if($material_type[$key] == 'Item' && !empty(json_decode($serial_code[$key]))) readonly @endif value="{{ $quantity[$key] }}">
                            </td>
                            <td>
                                <input name="remarks[{{$key}}]" class="form-control remarks" autocomplete="off" value="{{ $remarks[$key] }}">
                            </td>
                            <td>
                                <i class="btn btn-danger btn-sm fa fa-minus remove-challan-row"></i>
                            </td>
                        </tr>
                    @endforeach
        
                </tbody>
                <tfoot>
                </tfoot>
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
    <script>
        const CSRF_TOKEN = "{{ csrf_token() }}";
        $('#date').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true,
            showOtherMonths: true
        }).datepicker("setDate", new Date());;
        /* Append row */
        $(document).ready(function(){
            @if (empty($challan) && empty(old('material_name')))
                appendCalculationRow();
            @endif
        })
        var indx = 0;
        @if ($form_method == 'PUT')
            indx = {{count($Challan_Lines)}}
        @endif
        function appendCalculationRow() {
            let row = `<tr>
                            <td>
                                <select name="received_type[${indx}]" class="form-control received_type" autocomplete="off">
                                    <option value="">Select Out From</option>
                                    @foreach (config('businessinfo.receivedTypes') as $value)
                                        <option value="{{ $value }}">{{ strToUpper($value) }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" name="type_no[${indx}]" class="form-control type_no" autocomplete="off">
                                <input type="hidden" name="type_id[${indx}]" class="form-control type_id" autocomplete="off">
                            </td>
                            <td class="form-group">
                                <select class="form-control material_name select2" name="material_name[${indx}]">
                                    <option value="" readonly selected>Select Material</option>                  
                                </select>
                                <input type="hidden" name="item_code[${indx}]" class="form-control item_code" autocomplete="off"> 
                                <input type="hidden" name="material_type[${indx}]" class="form-control material_type" autocomplete="off"> 
                            </td>                            
                            <td>
                                <select class="form-control brand select2" name="brand[${indx}]">
                                    <option value="" readonly selected>Select Brand</option>

                                </select>
                            </td>
                            <td>
                                <select class="form-control model select2" name="model[${indx}]">
                                    <option value="" readonly selected>Select Model</option>

                                </select>
                            </td>
                            <td class="select2_container">
                                <select class="form-control serial_code select2" name='serial_code[${indx}][]' multiple="multiple">

                                </select>
                            </td>
                            <td>
                                <input name="unit[${indx}]" class="form-control unit" readonly autocomplete="off" type="text">
                            </td> 
                            <td>
                                <input class="form-control available_quantity" name="available_quantity[${indx}]" aria-describedby="available_quantity" readonly>
                            </td>
                            <td>
                                <input name="quantity[${indx}]" class="form-control quantity" autocomplete="off">
                            </td>
                            <td>
                                <input name="remarks[${indx}]" class="form-control remarks" autocomplete="off">
                            </td>
                            <td>
                                <i class="btn btn-danger btn-sm fa fa-minus remove-challan-row"></i>
                            </td>
                        </tr>
                    `;
                    indx++;
            $('#challan tbody').append(row);
            $('.select2').select2({
            });
            $('.select2.serial_code').select2({
                multiple: true,
            });
        }

        /* Adds and removes quantity row on click */
        $("#challan")
            .on('click', '.add-challan-row', () => {
                appendCalculationRow();
            })
            .on('click', '.remove-challan-row', function() {
                $(this).closest('tr').remove();
            });

        //Search Client
        var client_details = [];
        @if ($form_method === 'PUT')
            client_details = {!! collect($client_links) !!}
        @endif
        $(document).on('keyup focus', '#client_name', function() {
            $(this).autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ url('search-client') }}",
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
                    $('#client_name').val(ui.item.label);
                    $('#client_id').val(ui.item.value);
                    $('#client_no').val(ui.item.client_no);

                    $('#client_links').html('');
                    var link_options = '<option value="">Select link</option>';

                    ui.item.details.forEach(function(element) {
                        link_options +=
                            `<option value="${element.link_name}">${element.link_name}</option>`;
                    });
                    client_details = ui.item.details;
                    $('#client_links').html(link_options);

                    return false;
                }
            });
        });

       

       

        $(function() {
            onChangeRadioButton();

            $('.select2').select2({
                maximumSelectionLength: 5,
                scrollAfterSelect: true
        });

            //using form custom function js file
            fillSelect2Options("{{ route('searchBranch') }}", '#branch_id');
            associativeDropdown("{{ route('searchPop') }}", 'search', '#branch_id', '#pop_name', 'get', null)

            $(".radioButton").click(function() {
                onChangeRadioButton()
            });


            $("#mrs_no").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('search_mrs_no') }}",
                        type: 'get',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term
                        },
                        success: function(data) {
                            if (data.length > 0) {
                                response(data);
                            } else {
                                response([{
                                    label: 'No Result Found',
                                    value: -1,
                                }]);
                            }
                        }
                    });
                },
                select: function(event, ui) {
                    if (ui.item.value == -1) {
                        $(this).val('');
                        return false;
                    }
                    $('#scm_requisition_id').val(ui.item.scm_requisition_id);
                    $('#mrs_no').val(ui.item.label);
                    return false;
                }
            })
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
                    return false;
                }
            })

        });

        function onChangeRadioButton() {
            var radioValue = $("input[name='type']:checked").val();
            if (radioValue == 'client') {
                $('.pop_id').hide('slow');
                $('.pop_name').hide('slow');
                $('.pop_address').hide('slow');
                $('.address').show('slow');
                $('.client_name').show('slow');
                $('.client_no').show('slow');
                $('.client_address').show('slow');
                $('.client_links').show('slow');
            } else if (radioValue == 'pop') {
                $('.pop_id').show('slow');
                $('.pop_name').show('slow');
                $('.pop_address').show('slow');
                $('.address').hide('slow');
                $('.client_name').hide('slow');
                $('.client_no').hide('slow');
                $('.client_address').hide('slow');
                $('.client_links').hide('slow');
            }else if (radioValue == 'general') {
                $('.pop_id').hide('slow');
                $('.pop_name').hide('slow');
                $('.pop_address').hide('slow');
                $('.address').hide('slow');
                $('.client_name').hide('slow');
                $('.client_no').hide('slow');
                $('.client_address').hide('slow');
                $('.client_links').hide('slow');
            }
        }







        $(document).on('keyup', '.type_no', function() {
                var event_this = $(this).closest('tr');
                ClearNext($(this));
                let myObject = {
                    type: event_this.find('.received_type').val().toUpperCase(),
                }
                jquaryUiAjax(this, "{{ route('searchTypeNo') }}", uiList, myObject);

                function uiList(item) {
                    event_this.find('.type_no').val(item.label);
                    event_this.find('.type_id').val(item.id);
                    getMaterials(event_this)
                    return false;
                }
            })

            function ClearNext(selector) {
                let sib = $(selector).parent().nextAll('td');
                // loop siblings
                sib.each(function() {
                    let input = $(this).find('input');
                    let select = $(this).find('select');
                    if (!input.hasClass('unit')) {
                        input.val('');
                    }
                    select.empty();
                });
            }
            $(document).on('change', '.received_type', function() {
                var event_this = $(this).closest('tr');
                ClearNext($(this));
            })

        function getMaterials(event_this) {

                    let scm_requisition_id = $('#scm_requisition_id').val();
                    let received_type = event_this.find('.received_type').val().toUpperCase();
                    let receiveable_id = event_this.find('.type_id').val();
                    let material_name = event_this.find('.material_name');
                    populateDropdownByAjax("{{ route('mrsAndTypeWiseMaterials') }}", {
                        scm_requisition_id: scm_requisition_id,
                        received_type: received_type,
                        receiveable_id: receiveable_id,
                        from_branch: $('#branch_id').val(),
                        to_branch: $('#branch_id').val(),
                    }, material_name, 'value', 'label', {
                        'data-type': 'type',
                        'data-unit': 'unit',
                        'data-code': 'code',
                    })
                 }

                $(document).on('change', '.material_name', function() {
                    checkUniqueMaterial(this);
                    var event_this = $(this).closest('tr');
                    ClearNext($(this));
                    let material_id = $(this).val();
                    let scm_requisition_id = $('#scm_requisition_id').val();
                    let received_type = event_this.find('.received_type').val().toUpperCase();
                    let receiveable_id = event_this.find('.type_id').val();
                    let brand = $(this).closest('tr').find('.brand');
                    
                   event_this.find('.unit').val($(this).closest('tr').find('.material_name').find(':selected').data('unit'));
                   event_this.find('.item_code').val($(this).closest('tr').find('.material_name').find(':selected').data('code'));
                   event_this.find('.material_type').val($(this).closest('tr').find('.material_name').find(':selected').data('type'));

                    populateDropdownByAjax("{{ route('materialWiseBrands') }}", {
                        material_id: material_id,
                        received_type: received_type,
                        receiveable_id: receiveable_id,
                        from_branch_id: $('#branch_id').val(),
                    }, brand, 'value', 'label');
                })

                $(document).on('change', '.brand', function() {
                    checkUniqueMaterial(this);
                    var event_this = $(this).closest('tr');
                    ClearNext($(this));
                    let brand_id = $(this).val();
                    let material_id = event_this.find('.material_name').val();
                    let scm_requisition_id = $('#scm_requisition_id').val();
                    let received_type = event_this.find('.received_type').val().toUpperCase();
                    let receiveable_id = event_this.find('.type_id').val();
                    let model = $(this).closest('tr').find('.model');

                    populateDropdownByAjax("{{ route('brandWiseModels') }}", {
                        brand_id: brand_id,
                        material_id: material_id,
                        received_type: received_type,
                        receiveable_id: receiveable_id,
                        from_branch_id: $('#branch_id').val(),
                    }, model, 'value', 'label');
                });

                $(document).on('change', '.model', function() {
                    checkUniqueMaterial(this);
                    var event_this = $(this).closest('tr');
                    ClearNext($(this));
                    let model = $(this).val();
                    let material_id = event_this.find('.material_name').val();
                    let scm_requisition_id = $('#scm_requisition_id').val();
                    let received_type = event_this.find('.received_type').val().toUpperCase();
                    let receiveable_id = event_this.find('.type_id').val();
                    let brand_id = event_this.find('.brand').val();
                    let serial_code = $(this).closest('tr').find('.serial_code');
                    let material_type = $(this).closest('tr').find('.material_name').find(':selected').data(
                        'type');

                   
                    populateDropdownByAjax("{{ route('modelWiseSerialCodes') }}", {
                        model: model,
                        material_id: material_id,
                        brand_id: brand_id,
                        received_type: received_type,
                        receiveable_id: receiveable_id,
                        from_branch_id: $('#branch_id').val(),
                    }, serial_code, 'value', 'label',null,false);
                 });

                 $(document).on('change', '.serial_code', function() {
                    let material_type = $(this).closest('tr').find('.material_name').find(':selected').data('type');
                    if (material_type == 'Item') {
                        $(this).closest('tr').find('.quantity').val($(this).val().length);
                    }
                 })

                 function checkUniqueMaterial(currentValue) {
                var current_selector = $(currentValue);
                var current_material = $(currentValue).closest('tr').find('.material_name').val();
                var current_value_brand = $(currentValue).closest('tr').find('.brand').val();
                var current_value_model = $(currentValue).closest('tr').find('.model').val();
                var current_key = `${current_material}_${current_value_brand}_${current_value_model}`;
                console.log(current_key);
                var count_row = $('#challan tbody tr').length;
                var thisMaterial = $(currentValue).closest('tr').find('.material_name');
                let material_list = $('.material_name').not($(thisMaterial));

                material_list.each(function() {
                    var material_name = $(this).val();
                    var brand = $(this).closest('tr').find('.brand').val();
                    var model = $(this).closest('tr').find('.model').val();
                    var key = `${material_name}_${brand}_${model}`;
                    console.log(key);
                    if (key === current_key && count_row > 1) {
                        swal.fire({
                            title: "Material Already Selected",
                            type: "warning",
                        }).then(function() {
                            $(current_selector).val($(current_selector).find('option:first').val())
                                .trigger('change.select2');
                        });
                        return false;
                    }
                });
            }

            $(document).on('change', '.serial_code', function() {
                let elemmtn = $(this).closest('tr');
                let material_type = (elemmtn).find('.material_name').find(':selected').data(
                    'type');
                if (material_type == 'Item') {
                    (elemmtn).find('.quantity').attr('readonly', true);
                    (elemmtn).find('.quantity').val($(this).val().length);
                } else {
                    (elemmtn).find('.quantity').attr('readonly', false);
                }
            });

            $(document).on('change', '.received_type', function() {
                var event_this = $(this).closest('tr');
                ClearNext($(this));
                if ($('#branch_id').val() == '') {
                    $(this).val('');
                    swal.fire({
                        title: "Please Select From Branch",
                        type: "warning",
                    }).then(function() {
                        $('#branch_id').focus();
                    });
                    return false;
                }

               
            })
            $(document).on('change', '.model, .material_name, .brand', function() {
                var elemmtn = $(this);
                $.ajax({
                    url: "{{ route('getMaterialStock') }}",
                    type: 'get',
                    dataType: "json",
                    data: {
                        material_id: (elemmtn).closest('tr').find('.material_name').val(),
                        brand_id: (elemmtn).closest('tr').find('.brand').val(),
                        model: (elemmtn).closest('tr').find('.model').val(),
                        received_type: (elemmtn).closest('tr').find('.received_type').val()
                            .toUpperCase(),
                        receiveable_id : (elemmtn).closest('tr').find('.type').val(),
                        from_branch_id: $('#branch_id').val(),
                        to_branch_id: null
                    },
                    success: function(data) {
                        (elemmtn).closest('tr').find('.available_quantity').val(data
                            .from_branch_balance);
                    }
                })
            })

              //issued quantity cannot be greater than avaiable_quantity
              $(document).on('keyup', '.quantity', function() {
                let elemmtn = $(this).closest('tr');
                let avaiable_quantity = parseFloat((elemmtn).find('.available_quantity').val());
                let quantity = parseFloat((elemmtn).find('.quantity').val());
                if (quantity > avaiable_quantity) {
                    swal.fire({
                        title: "Issued Quantity Cannot Be Greater Than Avaiable Quantity",
                        type: "warning",
                    }).then(function() {
                        (elemmtn).find('.quantity').val(avaiable_quantity);
                    });
                }
            });

            // $(document).on('change', '.serial_code', function() {
            //     var elemmtn = $(this);
            //     let global_fianl_mark = $(this).find(':selected').data('final_mark');
            //     let material_name = (elemmtn).find(':selected').data('material_name');
            //     let brand = (elemmtn).find(':selected').data('brand');
            //     let model = (elemmtn).find(':selected').data('model');
            //     let unit = (elemmtn).find(':selected').data('unit');
            //     let type = $(this).find(':selected').data('type');
            //     let initial_mark = $(this).find(':selected').data('initial_mark');
            //     let final_mark = global_fianl_mark;

            //     (elemmtn).closest('tr').find('.material_name').val(material_name);
            //     (elemmtn).closest('tr').find('.brand').val(brand);
            //     (elemmtn).closest('tr').find('.model').val(model);
            //     (elemmtn).closest('tr').find('.unit').val(unit);

            //     (elemmtn).closest('tr').find('.initial_mark').attr('readonly', true).val(null);
            //     (elemmtn).closest('tr').find('.final_mark').attr('readonly', true).val(null);
            //     if (type == 'Drum') {
            //         (elemmtn).closest('tr').find('.initial_mark').attr('readonly', true).val(initial_mark);
            //         (elemmtn).closest('tr').find('.final_mark').attr('readonly', false).val(final_mark);
            //         $(document).on('keyup', '.final_mark', function() {
            //             var elemmtn = $(this);
            //             let initial_mark = (elemmtn).closest('tr').find('.initial_mark').val();
            //             let final_mark = (elemmtn).closest('tr').find('.final_mark').val();
            //             if (final_mark < initial_mark) {
            //                 alert('Final Mark can not be smaller than Initial Mark');
            //                 (elemmtn).closest('tr').find('.final_mark').val(global_fianl_mark);
            //             } else if (final_mark > global_fianl_mark) {
            //                 alert('Final Mark can not be bigger than ' + global_fianl_mark);
            //                 (elemmtn).closest('tr').find('.final_mark').val(global_fianl_mark);
            //             }
            //         })
            //     } else {
            //         (elemmtn).closest('tr').find('.initial_mark').attr('readonly', true).val(null);
            //         (elemmtn).closest('tr').find('.final_mark').attr('readonly', true).val(null);
            //     };

            //     $.ajax({
            //         url: "{{ route('getMaterialStock') }}",
            //         type: 'get',
            //         dataType: "json",
            //         data: {
            //             material_id: $(this).val(),
            //             from_branch_id: $('#from_branch_id').val(),
            //             to_branch_id: $('#to_branch_id').val(),
            //             type: type
            //         },
            //         success: function(data) {
            //             // (elemmtn).closest('tr').find('.stock').val(data.stock);
            //             console.log(data);
            //             (elemmtn).closest('tr').find('.opening_balance').val(data
            //                 .to_branch_balance);
            //             (elemmtn).closest('tr').find('.avaiable_quantity').val(data
            //                 .from_branch_balance);
            //         }
            //     })
            // })
    </script>
@endsection
