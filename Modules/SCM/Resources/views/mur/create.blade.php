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
       <link rel="stylesheet" type="text/css" href="{{ asset('css/switchery.min.css') }}">
       <link rel="stylesheet" type="text/css" href="{{ asset('/css/style.css') }}">
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
            @php
            $challan_id = old('challan_id', !empty($challanData) ? $challanData->id: null);
            
        @endphp
            @csrf
            <div class="row">
                <div class="col-md-3">
                    <div class="
                     mt-2 mb-4">
                        
                        <label for="type">Type:</label>
                    <input class="form-control" id="type" name="type" aria-describedby="type"
                        value="{{ old('type') ?? (@$challanData->type ?? '') }}" readonly>
                    </div>
                </div>
            </div>
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
                    <label for="purpose">Purpose</label>
                    <input type="text" class="form-control" id="purpose" aria-describedby="purpose"
                        name="purpose" value="{{ old('purpose') ?? (@$challanData->purpose ?? '') }}"
                        placeholder="Search...">
                    {{-- <select class="form-control select2" id="purpose" name="purpose">
                        <option value="" selected>Select Purpose</option>
                        @foreach (config('businessinfo.challanPurpose') as $key => $value)
                            <option value="{{ $value }}"
                                {{ old('purpose', @$challanData->purpose) == $value ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select> --}}
                </div>
            </div>
            <div class="row">
                

                <div class="form-group col-3 client_name client">
                    <label for="client_name">Client Name:</label>
                    <input type="text" class="form-control" id="client_name" aria-describedby="client_name"
                        name="client_name" value="{{ old('client_name') ?? (@$challanData->client->name ?? '') }}"
                        placeholder="Search...">
                    <input type="hidden" name="client_id" id="client_id"
                        value="{{ old('client_id') ?? @$challanData?->client->id }}">
                </div>
                <div class="form-group col-3 client_links client">
                    <label for="select2">Client Links</label>
                    <input type="text" class="form-control" id="link_name" aria-describedby="link_name"
                    name="client_name" value="{{ old('link_name') ?? (@$challanData->clientDetails->link_name ?? '') }}"
                    placeholder="Search...">
                </div>

                <div class="form-group col-3 client_no client">
                    <label for="client_no">Client No:</label>
                    <input type="text" class="form-control" id="client_no" aria-describedby="client_no" name="client_no"
                        readonly value="{{ old('client_no') ?? (@$challanData->clientDetails->client->client_no ?? '') }}">
                </div>
                <div class="form-group col-3 client_fr_id client">
                    <label for="client_fr_id">Client Fr:</label>
                    <input type="text" class="form-control" id="client_fr_id" aria-describedby="client_fr_id" name="client_fr_id"
                        readonly value="{{ old('client_fr') ?? (@$challanData->clientDetails->fr_id ?? '') }}">
                    <input type="hidden" class="form-control" id="fr_composite_key" aria-describedby="fr_composite_key" name="fr_composite_key"
                        readonly value="{{ old('fr_composite_key') ?? (@$challanData->clientDetails->fr_composite_key ?? '') }}">
                </div>

                <div class="form-group col-3 client_address client">
                    <label for="client_address">Client Address:</label>
                    <input type="text" class="form-control" id="client_address" name="client_address" aria-describedby="client_address"
                        readonly value="{{ old('client_address') ?? (@$challanData->clientDetails->client->address ?? '') }}">
                </div>
                <div class="form-group col-3 pop_name pop">
                    <label for="pop_name">POP Name:</label>
                    <input type="text" class="form-control" id="pop_name" name="pop_name" aria-describedby="pop_name"
                        readonly value="{{ old('pop_name') ?? (@$challanData->pop->name ?? '') }}">
                        <input type="hidden" class="form-control" id="pop_id" name="pop_id" aria-describedby="pop_id"
                        readonly value="{{ old('pop_id') ?? (@$challanData->pop_id ?? '') }}" >
                </div>
                <div class="form-group col-3 pop_address pop">
                    <label for="pop_address">POP Address:</label>
                    <input type="text" class="form-control" id="pop_address" name="pop_address" aria-describedby="pop_address"
                        readonly value="{{ old('pop_address') ?? (@$challanData->pop->address ?? '') }}">
                </div>
                <div class="form-group col-3 branch_name" style="">
                    <label for="branch_id">Branch Name</label>
                    <input class="form-control" id="branch_id" name="branch_id" aria-describedby="branch_id"
                    value="{{ old('branch_id') ?? (@$challanData->branch_id ?? '') }}" type="hidden">
                    <input class="form-control" id="branch_name" name="branch_name" aria-describedby="branch_name"
                    value="{{ old('branch_name') ?? (@$challanData->branch->name ?? '') }}">
                </div>
                <div class="form-group col-3 challan_no" style="">
                    <label for="select2">Challan No</label>
                    <input class="form-control" id="challan_no" name="challan_no" aria-describedby="challan_no"
                    value="{{ old('challan_no') ?? (@$challanData->challan_no ?? '') }}" placeholder="Search a Challan Name">
                    <input class="form-control" id="challan_id" name="challan_id" aria-describedby="challan_id"
                    value="{{ old('challan_id') ?? ($challan_id ?? '')}}" type="hidden">
                </div>
                <div class="form-group col-3 challan_date" style="">
                    <label for="select2">Challan Date</label>
                    <input class="form-control" id="challan_date" name="challan_date" aria-describedby="challan_date"
                    value="{{ old('challan_date') ?? (@$challanData->date ?? '') }}" readonly>
                </div>
            </div>
                {{-- @dd($challanData->scmChallanLines) --}}
            <table class="table table-bordered" id="material_requisition">
                <thead>
                    <tr>
                        <th>Material Name</th>
                        <th>Description</th>
                        <th>Item Code</th>
                        <th>Unit</th>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Serial/Drum Code <br /> No</th>
                        <th>Provided Quantity</th>
                        <th>Utilized Quantity</th>
                        <th>BBTS Ownership</th>
                        <th>Clien Ownership</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($challanLines as $item)
                    @php
                        $item = collect($item);
                    @endphp
                    <tr>
                        <td>
                            <input type="material_name" name="material_name[]" class="form-control type_no" autocomplete="off" value="{{ $item['material_name'] }}">
                            <input type="hidden" name="material_id[]" class="form-control material_id" autocomplete="off" value="{{ $item['material_id'] }}">
                            </td>
                        <td class="form-group">
                            <input type="text" name="description[]" class="form-control description">  
                        </td>
                        <td>
                            <input type="text" name="item_code[]" class="form-control item_code" readonly value="{{ $item['item_code'] }}">
                        </td>
                        <td>
                            <input type="text" name="unit[]" class="form-control unit" readonly value="{{ $item['unit'] }}">
                        </td>
                        <td>
                            <input type="text" name="brand_name[]" class="form-control brand_name" readonly value="{{ $item['brand_name'] }}">
                            <input type="hidden" name="brand_id[]" class="form-control brand_id" readonly value="{{ $item['brand_id'] }}">
                        </td>
                        <td>
                            <input type="text" name="model[]" class="form-control model" readonly value="{{ $item['model'] }}">
                        </td>
                        <td>
                            <input name="serial_code[]" class="form-control serial_code" autocomplete="off" readonly value="{{ $item['serial_code'] }}">
                        </td>                                        
                        <td>
                            <input name="quantity[]" class="form-control quantity" autocomplete="off" readonly value="{{ $item['quantity'] }}">
                        </td>
                        <td>
                            <input name="utilized_quantity[]" class="form-control utilized_quantity" autocomplete="off" value="{{ $item['quantity'] }}">
                        </td>
                        <td>
                            <input name="bbts_ownership[]" class="form-control bbts_ownership" autocomplete="off" value="">
                        </td>
                        <td>
                            <input name="client_ownership[]" class="form-control client_ownership" autocomplete="off" value="">
                        </td>
                        <td>
                            <input class="form-control remarks" name="remarks[]" aria-describedby="remarks">
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
    <script src="{{ asset('/js/switchery.min.js')}}"></script>
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
            // appendCalculationRow();
        @endif
        function appendCalculationRow() {
            var type = $("input[name=type]").val()
            let row = `<tr>
                            <td>
                                <input type="text" name="type_no[]" class="form-control type_no" autocomplete="off">
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
            // fillSelect2Options("{{ route('searchBranch') }}", '#branch_id');
            // associativeDropdown("{{ route('searchPop') }}", 'search', '#branch_id', '#pop_name', 'get', null)

            


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


            $(document).on('keyup', '#challan_no', function() {
                var event_this = $(this).closest('tr');
                let myObject = {
                    type: null
                }
                jquaryUiAjax('#challan_no', "{{ route('searchChallanNo') }}", uiList, myObject);

                function uiList(item) {
                    console.log(item)
                    $('#challan_no').val(item.label);
                    $('#challan_id').val(item.id);
                    $('#challan_date').val(item.date);
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
            $(document).ready(function(){
                onChangeRadioButton();
                switchInitialization();
            })
            function onChangeRadioButton() {
            var radioValue = $("input[name='type']").val();
            if (radioValue == 'client') {
                $('.client').show('slow');
                $('.pop').hide('slow');
            } else if (radioValue == 'pop') {
                $('.pop').show('slow');
                $('.client').hide('slow');
            }
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

            function switchInitialization(){
                var elemprimary = document.querySelectorAll('.js-primary');
	            elemprimary.forEach(function(checkbox) {
                    new Switchery(checkbox, { color: '#4099ff', jackColor: '#fff', size: 'small' });
                });
            }

            $('.utilized_quantity').on('keyup',function(){
                let utilized_qty = $(this).val();
                let challan_qty = $(this).closest('tr').find('.quantity').val();

                if(utilized_qty > challan_qty){
                    alert('utilized quantity can not be greater than challan quantity');
                    $(this).val(challan_qty);   
                }
            })
    </script>
@endsection
