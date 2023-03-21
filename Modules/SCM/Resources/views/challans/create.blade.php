@extends('layouts.backend-layout')
@section('title', 'Challan')

@section('breadcrumb-title')
    @if ($formType == 'edit')
        Edit
    @else
        Create
    @endif
    Challan
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
    <a href="{{ route('challans.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'col-12')

@section('content')
        <form
            action="{{ $formType == 'edit' ? route('challans.update', @$requisition->id) : route('challans.store') }}"
            method="post" class="custom-form">
            @if ($formType == 'edit')
                @method('PUT')
            @endif
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="typeSection mt-2 mb-4">
                        <div class="form-check-inline">
                            <label class="form-check-label" for="client">
                                <input type="radio" class="form-check-input radioButton" id="client" name="type"
                                    value="client" @checked(@$requisition->type == 'client' || old('type') == 'client')> Client
                            </label>
                        </div>

                        <div class="form-check-inline">
                            <label class="form-check-label" for="warehouse">
                                <input type="radio" class="form-check-input radioButton" id="warehouse" name="type"
                                    @checked(@$requisition->type == 'warehouse' || old('type') == 'warehouse') value="warehouse">
                                Warehouse
                            </label>
                        </div>

                        <div class="form-check-inline">
                            <label class="form-check-label" for="pop">
                                <input type="radio" class="form-check-input radioButton" id="pop" name="type"
                                    value="pop" @checked(@$requisition->type == 'pop' || old('type') == 'pop')>
                                POP
                            </label>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-3">
                    <label for="select2">Challan No</label>
                    <input type="text" class="form-control" id="challan_no" aria-describedby="challan_no"
                    name="challan_no" value="{{ old('challan_no') ?? (@$requisition->challan_no ?? '') }}"
                    placeholder="Challan No">
                </div>

                <div class="form-group col-3 date">
                    <label for="date">Applied Date:</label>
                    <input class="form-control" id="date" name="date" aria-describedby="date"
                        value="{{ old('date') ?? (@$requisition->date ?? '') }}" readonly placeholder="Select a Date">
                </div>
                <div class="form-group col-3 mrs_no">
                    <label for="select2">MRS No</label>
                    <input class="form-control" id="mrs_no" name="mrs_no" aria-describedby="mrs_no"
                        value="{{ old('mrs_no') ?? (@$requisition->mrs_no ?? '') }}" readonly placeholder="Select a MRS No">
                </div>
                <div class="form-group col-3">
                    <label for="select2">Purpose</label>
                    <select class="form-control select2" id="purpose" name="purpose">
                        <option value="" selected>Select Purpose</option>
                        @foreach ($purposes as $key => $value)
                            <option value="{{ $value }}"
                                {{ old('purpose', @$requisition->purpose) == $value ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                

                <div class="form-group col-3 client_name">
                    <label for="client_name">Client Name:</label>
                    <input type="text" class="form-control" id="client_name" aria-describedby="client_name"
                        name="client_name" value="{{ old('client_name') ?? (@$requisition->client->name ?? '') }}"
                        placeholder="Search...">
                    <input type="hidden" name="client_id" id="client_id"
                        value="{{ old('client_id') ?? @$requisition?->client->id }}">
                </div>
                <div class="form-group col-3 client_links">
                    <label for="select2">Client Links</label>
                    <select class="form-control select2" id="client_links" name="client_links">
                        <option value="" readonly selected>Select Client Link</option>
                        @if ($formType == 'create')
                            <option value="{{ old('client_links') }}" selected>{{ old('client_links') }}</option>
                        @endif
                        @if ($formType == 'edit')
                            @foreach ($clientInfos as $clientInfo)
                                <option value="{{ $clientInfo->link_name }}" @selected($clientInfo->fr_composite_key == @$requisition->fr_composite_key)>
                                    {{ $clientInfo->link_name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="form-group col-3 client_no">
                    <label for="client_no">Client No:</label>
                    <input type="text" class="form-control" id="client_no" aria-describedby="client_no" name="client_no"
                        readonly value="{{ old('client_no') ?? (@$requisition->client->client_no ?? '') }}">

                </div>

                <div class="form-group col-3 client_address">
                    <label for="client_address">Client Address:</label>
                    <input type="text" class="form-control" id="client_address" name="client_address" aria-describedby="client_address"
                        readonly value="{{ old('client_address') ?? (@$requisition->client_address ?? '') }}">
                </div>
                <div class="form-group col-3 branch_name">
                    <label for="select2">Branch Name</label>
                    <select class="form-control select2" id="branch_id" name="branch_id">
                        <option value="20" selected>Select Branch</option>
                        @foreach ($branchs as $option)
                            <option value="{{ $option->id }}"
                                {{ old('branch_id', @$requisition->branch_id) == $option->id ? 'selected' : '' }}>
                                {{ $option->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-3 pop_name" style="display: none">
                    <label for="select2">Pop Name</label>
                    <input class="form-control" id="date" name="pop_name" aria-describedby="pop_name"
                    value="{{ old('pop_name') ?? (@$requisition->pop_name ?? '') }}" readonly placeholder="Select a POP Name">
                </div>
                <div class="form-group col-3 pop_address" style="display: none">
                    <label for="select2">Pop Address</label>
                    <input class="form-control" id="date" name="pop_address" aria-describedby="pop_address"
                    value="{{ old('pop_address') ?? (@$requisition->pop_address ?? '') }}" readonly placeholder="Select a POP Address">
                </div>
            </div>

            <table class="table table-bordered" id="material_requisition">
                <thead>
                    <tr>
                        <th> Material Name</th>
                        <th> Unit</th>
                        <th> Description</th>
                        <th class="current_stock" style="display: none"> Current Stock</th>
                        <th> Requisition Qty.</th>
                        <th> Brand</th>
                        <th> Model </th>
                        <th> Purpose </th>
                        <th><i class="btn btn-primary btn-sm fa fa-plus add-requisition-row"></i></th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    @php
                        $material_name_with_code = old('material_name', !empty($requisition) ? $requisition->scmRequisitiondetails->pluck('material.materialNameWithCode') : []);
                        $material_id = old('material_id', !empty($requisition) ? $requisition->scmRequisitiondetails->pluck('material_id') : []);
                        $item_code = old('item_code', !empty($requisition) ? $requisition->scmRequisitiondetails->pluck('material.code') : []);
                        $unit = old('unit', !empty($requisition) ? $requisition->scmRequisitiondetails->pluck('material.unit') : []);
                        $description = old('description', !empty($requisition) ? $requisition->scmRequisitiondetails->pluck('description') : []);
                        $current_stock = old('current_stock', !empty($requisition) ? $requisition->scmRequisitiondetails->pluck('material.current_stock') : []);
                        $quantity = old('quantity', !empty($requisition) ? $requisition->scmRequisitiondetails->pluck('quantity') : []);
                        $brand_id = old('brand_id', !empty($requisition) ? $requisition->scmRequisitiondetails->pluck('brand_id') : []);
                        $model = old('model', !empty($requisition) ? $requisition->scmRequisitiondetails->pluck('model') : []);
                        $purpose = old('purpose', !empty($requisition) ? $requisition->scmRequisitiondetails->pluck('purpose') : []);
                    @endphp
                    @foreach ($material_name_with_code as $key => $requisitionDetail)
                        <tr>
                            <td>
                                <input type="text" name="material_name[]" class="form-control material_name" required
                                    autocomplete="off" value="{{ $material_name_with_code[$key] }}">
                                <input type="hidden" name="material_id[]" class="form-control material_id"
                                    value="{{ $material_id[$key] }}">
                                <input type="hidden" name="item_code[]" class="form-control item_code"
                                    value="{{ $item_code[$key] }}">
                            </td>
                            <td>
                                <input type="text" name="unit[]" class="form-control unit" autocomplete="off"
                                    readonly value="{{ $unit[$key] }}">
                            </td>
                            <td>
                                <input type="text" name="description[]" class="form-control description"
                                    autocomplete="off" value="{{ $description[$key] }}">
                            </td>
                            <td class="current_stock" style="display: none">
                                <input type="text" class="form-control current_stock" autocomplete="off" readonly
                                    value="{{ @$current_stock[$key] }}">
                            </td>

                            <td>
                                <input type="text" name="quantity[]" class="form-control quantity" autocomplete="off"
                                    value="{{ $quantity[$key] }}">
                            </td>
                            <td>
                                <select name="brand_id[]" class="form-control brand" autocomplete="off">
                                    <option value="">Select Brand</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}" @selected($brand->id == $brand_id[$key])>
                                            {{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" name="model[]" class="form-control model" autocomplete="off"
                                    value="{{ $model[$key] }}">
                            </td>
                            <td>
                                <input type="text" name="purpose[]" class="form-control purpose" autocomplete="off"
                                    value="{{ $purpose[$key] }}">
                            </td>
                            <td>
                                <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i>
                            </td>
                        </tr>
                    @endforeach
                </tfoot>
            </table>

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
    <script>
        $('#date').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true,
            showOtherMonths: true
        }).datepicker("setDate", new Date());;
        /* Append row */
        @if (empty($requisition) && empty(old('material_name')))
            appendCalculationRow();
        @endif
        function appendCalculationRow() {
            var type = $("input[name=type]:checked").val()
            let row = `<tr>
                            <td>
                                <input type="text" name="material_name[]" class="form-control material_name" required autocomplete="off">
                                <input type="hidden" name="material_id[]" class="form-control material_id">
                                <input type="hidden" name="item_code[]" class="form-control item_code">
                            </td>
                            <td>
                                <input type="text" name="unit[]" class="form-control unit" autocomplete="off" readonly>
                            </td>
                            <td>
                                <input type="text" name="description[]" class="form-control description" autocomplete="off">
                            </td>
                            ${ type === 'warehouse' || type === 'pop' ? 
                            `<td class="current_stock" style="display: block">
                                <input type="text" class="form-control current_stock" autocomplete="off" readonly>
                            </td>` 
                            : 
                            `<td class="current_stock" style="display: none">
                                <input type="text" class="form-control current_stock" autocomplete="off" readonly>
                            </td>` 
                            }                          
                            <td>
                                <input type="text" name="quantity[]" class="form-control quantity" autocomplete="off">
                            </td>
                            <td> 
                                <select name="brand_id[]" class="form-control brand" autocomplete="off">
                                <option value="">Select Brand</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>    
                            </td>
                            <td>
                                <input type="text" name="model[]" class="form-control model" autocomplete="off">
                            </td>
                            <td>
                                <input type="text" name="purpose[]" class="form-control purpose" autocomplete="off">
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
                $(this).closest('tr').remove();
            });

        //Search Client
        var client_details = [];
        @if ($formType === 'edit')
            client_details = {!! collect($clientInfos) !!}
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

        //Select FR key based on link name
        $('#client_links').on('change', function() {
            var link_name = $("input[name='gender']:checked").val();
            var link_name = $(this).val();
            var client_id = $('#client_id').val();
            var client = client_details.find(function(element) {
                return element.link_name == link_name;
            });
            $('#fr_id').val(client.fr_id);
            $('#fr_composite_key').val(client.fr_composite_key);
        });

        //Search Material
        $(document).on('keyup focus', '.material_name', function() {
            $(this).autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ url('search-material') }}",
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
                    $(this).closest('tr').find('.material_name').val(ui.item.label);
                    $(this).closest('tr').find('.material_id').val(ui.item.value);
                    $(this).closest('tr').find('.item_code').val(ui.item.item_code);
                    $(this).closest('tr').find('.unit').val(ui.item.unit);
                    return false;
                }
            });

        });

        $(function() {
            onChangeRadioButton();

            $('.select2').select2();

            //using form custom function js file
            fillSelect2Options("{{ route('searchBranch') }}", '#branch_id');
            associativeDropdown("{{ route('searchPop') }}", 'search', '#branch_id', '#pop_id', 'get', null)

            $(".radioButton").click(function() {
                onChangeRadioButton()
            });
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
                $('.branch_name').hide('slow');
                $('.client_links').show('slow');
                $('.current_stock').hide('slow');
            } else if (radioValue == 'warehouse') {
                $('.pop_id').hide('slow');
                $('.pop_name').hide('slow');
                $('.pop_address').hide('slow');
                $('.address').hide('slow');
                $('.client_name').hide('slow');
                $('.client_no').hide('slow');
                $('.client_address').hide('slow');
                $('.current_stock').show('slow');
                $('.branch_name').show('slow');
                $('.client_links').hide('slow');
            } else if (radioValue == 'pop') {
                $('.pop_id').show('slow');
                $('.pop_name').show('slow');
                $('.pop_address').show('slow');
                $('.address').hide('slow');
                $('.client_name').hide('slow');
                $('.branch_name').hide('slow');
                $('.client_no').hide('slow');
                $('.client_address').hide('slow');
                $('.current_stock').show('slow');
                $('.client_links').hide('slow');
            }
        }
    </script>
@endsection
