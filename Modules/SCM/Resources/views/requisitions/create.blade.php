@extends('layouts.backend-layout')
@section('title', 'Requisitions')

@section('breadcrumb-title')
    @if ($formType == 'edit')
        Edit
    @else
        Create
    @endif
    MRS (Material Requisition Slip)
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
    <a href="{{ route('requisitions.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
    <div class="container">
        <form
            action="{{ $formType == 'edit' ? route('requisitions.update', $requisition->id) : route('requisitions.store') }}"
            method="post" class="custom-form">
            @if ($formType == 'edit')
                @method('PUT')
            @endif
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="typeSection mt-2 mb-2">
                        <div class="form-check-inline">
                            <label class="form-check-label" for="client">
                                <input type="radio" class="form-check-input rd" id="client" name="type" value="client" @checked(@$requisition->type == "client")
                                    > Client
                            </label>
                        </div>

                        <div class="form-check-inline">
                            <label class="form-check-label" for="warehouse">
                                <input type="radio" class="form-check-input rd" id="warehouse" name="type" @checked(@$requisition->type == "warehouse")
                                    value="warehouse">
                                Warehouse
                            </label>
                        </div>

                        <div class="form-check-inline">
                            <label class="form-check-label" for="pop">
                                <input type="radio" class="form-check-input rd" id="pop" name="type" value="pop" @checked(@$requisition->type == "pop")
                                >
                                POP
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-3">
                    <label for="select2">Branch Name</label>
                    <select class="form-control select2" id="branch_id" name="branch_id">
                        <option value="" disabled selected>Select Branch</option>
                        @if($formType == 'edit')
                            <option value="{{ $requisition->branch_id }}" selected>{{ $requisition->branch->name }}</option>
                        @endif
                    </select>
                </div>

                <div class="form-group col-3 client_name">
                    <label for="client_name">Client Name:</label>
                    <input type="text" class="form-control" id="client_name" aria-describedby="client_name" name="client_name"
                        value="{{ old('client_name') ?? ($requisition->client->name ?? '') }}" placeholder="Search...">
                    <input type="hidden" name="client_id" id="client_id">
                </div>
                <div class="form-group col-3 client_links">
                    <label for="select2">Client Links</label>
                    <select class="form-control select2" id="client_links" name="client_links">
                        <option value="" disabled selected>Select Client Link</option>
                        @if($formType == 'edit')
                            @foreach($clientDetails as $clientDetail)
                                <option value="{{ $clientDetail->link_name }}" @selected($clientDetail->fr_composite_key == $requisition->fr_composite_key)>{{ $clientDetail->link_name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="form-group col-3 client_no">
                    <label for="client_no">Client No:</label>
                    <input type="text" class="form-control" id="client_no" aria-describedby="client_no" name="client_no" disabled
                        value="{{ old('client_no') ?? ($requisition->client_no ?? '') }}">

                </div>

                <div class="form-group col-3 address">
                    <label for="address">Address:</label>
                    <input type="text" class="form-control" id="address" name="address" aria-describedby="address" disabled
                        value="{{ old('address') ?? ($requisition->address ?? '') }}">
                </div>
                <div class="form-group col-3 fr_id">
                    <label for="fr_id">FR ID:</label>
                    <input type="text" class="form-control" id="fr_id" name="fr_id" aria-describedby="fr_id"
                        value="{{ old('fr_id') ?? ($requisition->clientDetailsWithCompositeKey->fr_id ?? '') }}"  disabled>
                    <input type="hidden" name="fr_composite_key" id="fr_composite_key">
                </div>

                <div class="form-group col-3">
                    <label for="date">Applied Date:</label>
                    <input type="date" class="form-control" id="date" name="date" aria-describedby="date"
                        value="{{ old('date') ?? ($requisition->date ?? '') }}">
                </div>

                <div class="form-group col-3 pop_id" style="display: none">
                    <label for="select2">Pop Name</label>
                    <select class="form-control select2" id="pop_id" name="pop_id">
                        <option value="" disabled selected>Select Pop</option>
                    </select>
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
                    <tr>
                        <td>
                            <input type="text" name="material_name[]" class="form-control material_name" required
                                autocomplete="off">
                            <input type="hidden" name="material_id[]" class="form-control material_id">

                        </td>
                        <td>
                            <input type="text" name="unit[]" class="form-control unit" autocomplete="off"
                                disabled>
                        </td>
                        <td>
                            <input type="text" name="description[]" class="form-control description" autocomplete="off">
                        </td>
                        <td class="current_stock" style="display: none">
                            <input type="text" class="form-control current_stock" autocomplete="off" disabled>
                        </td>

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
                            <input type="number" name="model[]" class="form-control model" autocomplete="off">
                        </td>
                        <td>
                            <input type="text" name="purpose[]" class="form-control purpose" autocomplete="off">
                        </td>
                        <td>
                            <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i>
                        </td>
                    </tr>
                    <tr>
                    </tr>
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
    <script src="{{ asset('js/custom-function.js') }}"></script>
    <script> 

        // $(function(){
           
        // });
        /* Append row */
        function appendCalculationRow() {
            var type = $("input[name=type]:checked").val()
            let row = `<tr>
                            <td>
                                <input type="text" name="material_name[]" class="form-control material_name" required autocomplete="off">
                                <input type="hidden" name="material_id[]" class="form-control material_id">
                            </td>
                            <td>
                                <input type="text" name="unit[]" class="form-control unit" autocomplete="off" disabled>
                            </td>
                            <td>
                                <input type="text" name="description[]" class="form-control description" autocomplete="off">
                            </td>
                            ${ type === 'warehouse' || type === 'pop' ? `<td class="current_stock" style="display: block">
                                <input type="text" class="form-control current_stock" autocomplete="off" disabled>
                            </td>` : `<td class="current_stock" style="display: none">
                                <input type="text" class="form-control current_stock" autocomplete="off" disabled>
                            </td>` }                          
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
                                <input type="number" name="model[]" class="form-control model" autocomplete="off">
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
        @if($formType === 'edit')        
            client_details = {!! collect($clientInfo) !!}
        @endif
        console.log(client_details);
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
                    //map client details

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
            console.log(link_name,client_details);
            $('#fr_id').val(client.fr_id);
            $('#fr_composite_key').val(client.fr_composite_key);
        });

        function changeClintLink(){ 
            
        }

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
                            console.log(data);
                        }
                    });
                },
                select: function(event, ui) {
                    $(this).closest('tr').find('.material_name').val(ui.item.label);
                    $(this).closest('tr').find('.material_id').val(ui.item.value);
                    $(this).closest('tr').find('.unit').val(ui.item.unit);
                    return false;
                }
            });

        });

        // $(function(){
        //     onChangeRadioButton()
        // })

        $(function() { 
            onChangeRadioButton();
            $('.select2').select2();

            //using form custom function js file
            fillSelect2Options("{{ route('searchBranch') }}", '#branch_id');
            fillSelect2Options("{{ route('searchPop') }}", '#pop_id');
            associativeDropdown("{{ route('searchPop') }}", 'search', '#branch_id', '#pop_id', 'get', null)
 
            $(".rd").click(function() {
                onChangeRadioButton()
            });  
        });

        

        function onChangeRadioButton() {
                var radioValue = $("input[name='type']:checked").val();
                if (radioValue == 'client') {
                    $('.pop_id').hide('slow');
                    $('.fr_id').show('slow');
                    $('.address').show('slow');
                    $('.client_name').show('slow');
                    $('.client_no').show('slow');
                    $('.current_stock').hide('slow');
                    $('.client_links').show('slow');
                } else if (radioValue == 'warehouse') {
                    $('.pop_id').hide('slow');
                    $('.fr_id').hide('slow');
                    $('.address').hide('slow');
                    $('.client_name').hide('slow');
                    $('.client_no').hide('slow');
                    $('.current_stock').show('slow');
                    $('.client_links').hide('slow');
                } else if (radioValue == 'pop') {
                    $('.pop_id').show('slow');
                    $('.fr_id').hide('slow');
                    $('.address').hide('slow');
                    $('.client_name').hide('slow');
                    $('.client_no').hide('slow');
                    $('.current_stock').show('slow');
                    $('.client_links').hide('slow');
                }
            }
    </script>
@endsection
