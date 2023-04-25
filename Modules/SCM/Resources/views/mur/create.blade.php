@extends('layouts.backend-layout')
@section('title', 'Material Utilization')

@section('breadcrumb-title')
    @if ($formType == 'edit')
        Edit
    @else
        Create
    @endif
    Material Utilization Report (MUR)
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
    <a href="{{ route('material-utilizations.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'col-12')

@section('content')
        <form
            action="{{ $formType == 'edit' ? route('material-utilizations.update', @$requisition->id) : route('material-utilizations.store') }}"
            method="post" class="custom-form">
            @if ($formType == 'edit')
                @method('PUT')
            @endif
            @csrf
            <div class="row">
                <div class="form-group col-3 date">
                    <label for="date">Applied Date:</label>
                    <input class="form-control" id="date" name="date" aria-describedby="date"
                        value="{{ old('date') ?? (@$requisition->date ?? '') }}" readonly placeholder="Select a Date" readonly>
                </div>
                <div class="form-group col-3 mrs_no">
                    <label for="select2">MRS No</label>
                    <input class="form-control" id="mrs_no" name="mrs_no" aria-describedby="mrs_no"
                        value="{{ old('mrs_no') ?? (@$challanData->scmRequisition->mrs_no ?? '') }}" placeholder="Search a MRS No">
                        <input class="form-control" id="scm_requisition_id" name="scm_requisition_id" aria-describedby="scm_requisition_id"
                        value="{{ old('scm_requisition_id') ?? (@$challanData->scm_requisition_id ?? '')}}" type="hidden">
                </div>
                <div class="form-group col-3">
                    <label for="select2">Purpose</label>
                    <select class="form-control select2" id="purpose" name="purpose">
                        <option value="" selected>Select Purpose</option>
                        @foreach ($purposes as $key => $value)
                            <option value="{{ $value }}"
                                {{ old('purpose', @$challanData->purpose) == $value ? 'selected' : '' }}>
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
                        name="client_name" value="{{ old('client_name') ?? (@$challanData->client->name ?? '') }}"
                        placeholder="Search...">
                    <input type="hidden" name="client_id" id="client_id"
                        value="{{ old('client_id') ?? @$challanData?->client->id }}">
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
                <div class="form-group col-3 branch_name" style="">
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
                <div class="form-group col-3 challan_no" style="">
                    <label for="select2">Challan No</label>
                    <input class="form-control" id="challan_no" name="challan_no" aria-describedby="challan_no"
                    value="{{ old('challan_no') ?? (@$requisition->challan_no ?? '') }}" placeholder="Search a Challan Name">
                    <input type="hidden" class="form-control" id="challan_id" name="challan_id" aria-describedby="challan_id"
                    value="{{ old('challan_id') ?? (@$requisition->challan_id ?? '') }}">
                </div>
                <div class="form-group col-3 challan_date" style="">
                    <label for="select2">Challan Date</label>
                    <input class="form-control" id="challan_date" name="challan_date" aria-describedby="challan_date"
                    value="{{ old('challan_date') ?? (@$requisition->challan_date ?? '') }}" readonly>
                </div>
            </div>

            <table class="table table-bordered" id="material_requisition">
                <thead>
                    <tr>
                        <th>Received Type</th>
                        <th>Type No</th>
                        <th>Serial/Drum Code <br /> No</th>
                        <th>Material Name</th>
                        <th>Opening Balance</th>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Initial Mark</th>
                        <th>Final Mark</th>
                        <th>Unit</th>
                        <th>Avaliable Qty</th>
                        <th>Issued Qty</th>
                        <th>Remarks</th>
                        <th><i class="btn btn-primary btn-sm fa fa-plus add-requisition-row"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $mrr_lines = old('material_id', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('material_id') : []);
                        $material_id = old('material_id', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('material_id') : []);
                        $item_code = old('item_code', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('material.code') : []);
                        $material_type = old('item_code', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('material.type') : []);
                        $brand_id = old('brand_id', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('brand_id') : []);
                        $model = old('model', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('model') : []);
                        $description = old('description', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('description') : []);
                        $sl_code = old(
                            'sl_code',
                            !empty($materialReceive)
                                ? $materialReceive->scmMrrLines->map(function ($item) {
                                    return implode(',', $item->scmMrrSerialCodeLines->pluck('serial_or_drum_key')->toArray());
                                })
                                : '',
                        );
                        
                        $initial_mark = old('initial_mark', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('initial_mark') : []);
                        $final_mark = old('final_mark', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('final_mark') : []);
                        $warranty_period = old('warranty_period', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('warranty_period') : []);
                        $unit = old('unit', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('material.unit') : []);
                        
                        $quantity = old('quantity', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('quantity') : []);
                        $unit_price = old('unit_price', !empty($materialReceive) ? $materialReceive->scmMrrLines->pluck('unit_price') : []);
                        $amount = old(
                            'amount',
                            !empty($materialReceive)
                                ? collect($quantity)
                                    ->map(function ($value, $key) use ($unit_price) {
                                        return $value * $unit_price[$key];
                                    })
                                    ->toArray()
                                : [],
                        );
                    @endphp
                    @foreach ($mrr_lines as $key => $requisitionDetail)
                        <tr>
                            <td>
                                <select name="out_from[]" class="form-control out_from" autocomplete="off">
                                    <option value="">Select Out From</option>
                                    @foreach ($out_from as $key1 => $value)
                                        <option value="{{ $value }}" @selected($out_from[$key] == $value)>{{ $key1 }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="form-group">
                                <select class="form-control material_name" name="material_id[]">
                                    <option value="" readonly selected>Select Material</option>
                                    @foreach ($material_list as $key1 => $value)
                                        <option value="{{ $value }}" readonly @selected($material_id[$key] == $value)>
                                            {{ $key1 }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="item_code[]" class="form-control item_code" autocomplete="off"
                                    value="{{ $item_code[$key] }}">
                                <input type="hidden" name="material_type[]" class="form-control material_type"
                                    autocomplete="off" value="{{ $material_type[$key] }}">
                            </td>
        
                            <td>
                                <select name="brand_id[]" class="form-control brand" autocomplete="off">
                                    <option value="">Select Brand</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}" @selected($brand->id == $brand_id[$key])>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
        
                            <td>
                                <input type="text" name="model[]" class="form-control model" autocomplete="off"
                                    value="{{ $model[$key] }}">
                            </td>
                            <td>
                                <input type="text" name="description[]" class="form-control description" autocomplete="off"
                                    value="{{ $description[$key] }}">
                            </td>
                            <td>
                                <div class="tags_add_multiple">
                                    <input class="" type="text" name="sl_code[]" value="{{ $sl_code[$key] }}"
                                        data-role="tagsinput">
                                </div>
                            </td>
        
                            <td>
                                <input type="text" name="initial_mark[]" class="form-control initial_mark" autocomplete="off"
                                    value="{{ $initial_mark[$key] }}">
                            </td>
                            <td>
                                <input type="text" name="final_mark[]" class="form-control final_mark" autocomplete="off"
                                    value="{{ $final_mark[$key] }}">
                            </td>
                            <td>
                                <input type="text" name="warranty_period[]" class="form-control warranty_period"
                                    autocomplete="off" value="{{ $warranty_period[$key] }}">
                            </td>
                            <td>
                                <input type="text" name="unit[]" class="form-control unit" autocomplete="off"
                                    value="{{ $unit[$key] }}" readonly>
                            </td>
                            <td>
                                <input class="form-control quantity" name="quantity[]" aria-describedby="date"
                                    value="{{ $quantity[$key] }}">
                            </td>
                            <td>
                                <input name="unit_price[]" class="form-control unit_price" autocomplete="off" readonly
                                    value="10" value="{{ $unit_price[$key] }}">
                            </td>
                            <td>
                                <input name="amount[]" class="form-control amount" autocomplete="off" readonly
                                    value="{{ $amount[$key] }}">
                            </td>
                            <td>
                                <i class="btn btn-danger btn-sm fa fa-minus remove-requisition-row"></i>
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
        </form>
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
        @if (empty($requisition) && empty(old('material_name')))
            appendCalculationRow();
        @endif
        function appendCalculationRow() {
            var type = $("input[name=type]:checked").val()
            let row = `<tr>
                            <td>
                                <select name="out_from[]" class="form-control received_type" autocomplete="off">
                                    <option value="">Select Out From</option>
                                    @foreach ($out_from as $value)
                                        <option value="{{ $value }}">{{ strToUpper($value) }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" name="type_no[]" class="form-control type_no" autocomplete="off">
                                <input type="hidden" name="type_id[]" class="form-control type_id" autocomplete="off">
                                </td>
                            <td class="form-group">
                                <select class="form-control serial_code select2" name="serial_code[]">                      
                                </select>
                                <input type="hidden" name="item_code[]" class="form-control item_code" autocomplete="off"> 
                                <input type="hidden" name="material_type[]" class="form-control material_type" autocomplete="off"> 
                            </td>
                            <td>
                                <input type="text" name="material_name[]" class="form-control material_name" readonly>
                            </td>
                            <td>
                                <input type="text" name="opening_balance[]" class="form-control opening_balance" readonly>
                            </td>
                            <td>
                                <input type="text" name="brand[]" class="form-control brand" readonly>
                            </td>
                            <td>
                                <input type="text" name="model[]" class="form-control model" readonly>
                            </td>
                            <td>
                                <input name="unit[]" class="form-control unit" autocomplete="off" readonly>
                            </td>
                            <td>
                                <input type="text" name="initial_mark[]" class="form-control initial_mark" autocomplete="off" readonly>
                            </td>
                            <td>
                                <input type="number" name="final_mark[]" class="form-control final_mark" autocomplete="off" readonly>
                            </td>                                                  
                            <td>
                                <input class="form-control avaiable_quantity" name="avaiable_quantity[]" aria-describedby="date" value="{{ old('required_date') ?? (@$materialReceive->required_date ?? '') }}" >
                            </td>
                            <td>
                                <input name="unit_price[]" class="form-control unit_price" autocomplete="off" readonly value="10">
                            </td>
                            <td>
                                <input name="amount[]" class="form-control amount" autocomplete="off" readonly>
                            </td>
                            <td>
                                <i class="btn btn-danger btn-sm fa fa-minus remove-requisition-row"></i>
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

            $('.select2').select2();

            //using form custom function js file
            fillSelect2Options("{{ route('searchBranch') }}", '#branch_id');
            associativeDropdown("{{ route('searchPop') }}", 'search', '#branch_id', '#pop_name', 'get', null)

            


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
          

        });










        $(document).on('change keyup', '.type_no', function() {
                var event_this = $(this).closest('tr');
                let myObject = {
                    type: event_this.find('.received_type').val().toUpperCase(),
                }
                jquaryUiAjax('.type_no', "{{ route('searchTypeNo') }}", uiList, myObject);

                function uiList(item) {
                    console.log(item)
                    event_this.find('.type_no').val(item.label);
                    event_this.find('.type_id').val(item.id);
                    getMaterials(event_this)
                    return false;
                }
            })

            function getMaterials(event_this) {
                let scm_requisition_id = $('#scm_requisition_id').val();

                let received_type = event_this.find('.received_type').val().toUpperCase();
                let receivable_id = event_this.find('.type_id').val();
                console.log(scm_requisition_id,received_type,receivable_id);
                $.ajax({
                    url: "{{ route('mrsAndTypeWiseMaterials') }}",
                    type: 'get',
                    dataType: "json",
                    data: {
                        scm_requisition_id: scm_requisition_id,
                        received_type: received_type,
                        receivable_id: receivable_id,
                        from_branch: $('#from_branch_id').val(),
                        to_branch: $('#to_branch_id').val(),
                    },
                    success: function(data) {
                        let dropdown;

                        dropdown = event_this.find('.serial_code');
                        dropdown.empty();
                        dropdown.append('<option selected disabled>Select Material</option>');
                        dropdown.prop('selectedIndex', 0);
                        data.materials.map(function(item) {
                            console.log(item)
                            dropdown.append($('<option></option>')
                                .attr('value', item.material.id)
                                .attr('data-material_name', item.material.name)
                                .attr('data-brand', item.brand.name)
                                .attr('data-model', item.model)
                                .attr('data-unit', item.unit)
                                .attr('data-type', item.material.type)
                                .attr('data-initial_mark', item.initial_mark)
                                .attr('data-final_mark', item.final_mark)
                                .text(item.material.name + '-' + item.serial_code)
                            )
                        });
                        dropdown.select2()
                    }
                })
            }

            $(document).on('change', '.serial_code', function() {
                var elemmtn = $(this);
                let global_fianl_mark = $(this).find(':selected').data('final_mark');
                let material_name = (elemmtn).find(':selected').data('material_name');
                let brand = (elemmtn).find(':selected').data('brand');
                let model = (elemmtn).find(':selected').data('model');
                let unit = (elemmtn).find(':selected').data('unit');
                let type = $(this).find(':selected').data('type');
                let initial_mark = $(this).find(':selected').data('initial_mark');
                let final_mark = global_fianl_mark;

                (elemmtn).closest('tr').find('.material_name').val(material_name);
                (elemmtn).closest('tr').find('.brand').val(brand);
                (elemmtn).closest('tr').find('.model').val(model);
                (elemmtn).closest('tr').find('.unit').val(unit);

                (elemmtn).closest('tr').find('.initial_mark').attr('readonly', true).val(null);
                (elemmtn).closest('tr').find('.final_mark').attr('readonly', true).val(null);
                if (type == 'Drum') {
                    (elemmtn).closest('tr').find('.initial_mark').attr('readonly', true).val(initial_mark);
                    (elemmtn).closest('tr').find('.final_mark').attr('readonly', false).val(final_mark);
                    $(document).on('keyup', '.final_mark', function() {
                        var elemmtn = $(this);
                        let initial_mark = (elemmtn).closest('tr').find('.initial_mark').val();
                        let final_mark = (elemmtn).closest('tr').find('.final_mark').val();
                        if (final_mark < initial_mark) {
                            alert('Final Mark can not be smaller than Initial Mark');
                            (elemmtn).closest('tr').find('.final_mark').val(global_fianl_mark);
                        } else if (final_mark > global_fianl_mark) {
                            alert('Final Mark can not be bigger than ' + global_fianl_mark);
                            (elemmtn).closest('tr').find('.final_mark').val(global_fianl_mark);
                        }
                    })
                } else {
                    (elemmtn).closest('tr').find('.initial_mark').attr('readonly', true).val(null);
                    (elemmtn).closest('tr').find('.final_mark').attr('readonly', true).val(null);
                };

                $.ajax({
                    url: "{{ route('getMaterialStock') }}",
                    type: 'get',
                    dataType: "json",
                    data: {
                        material_id: $(this).val(),
                        from_branch_id: $('#from_branch_id').val(),
                        to_branch_id: $('#to_branch_id').val(),
                        type: type
                    },
                    success: function(data) {
                        // (elemmtn).closest('tr').find('.stock').val(data.stock);
                        console.log(data);
                        (elemmtn).closest('tr').find('.opening_balance').val(data
                            .to_branch_balance);
                        (elemmtn).closest('tr').find('.avaiable_quantity').val(data
                            .from_branch_balance);
                    }
                })
            })
    </script>
@endsection
