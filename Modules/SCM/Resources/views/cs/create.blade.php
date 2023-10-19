@extends('layouts.backend-layout')
@section('title', 'Comparative Statements')

@php
    $is_old = old('effective_date') ? true : false;
    $form_heading = !empty($cs->id) ? 'Update' : 'Add';
    $form_url = !empty($cs->id) ? route('cs.update', $cs->id) : route('cs.store');
    $form_method = !empty($cs->id) ? 'PUT' : 'POST';
@endphp

@section('breadcrumb-title')
    {{ ucfirst($form_heading) }} Comparative Statement & Supplier
@endsection

@section('breadcrumb-button')
    <a href="{{ route('cs.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
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

    {{-- Comparative Statement --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="tableHeading">
                    <h5> <span> &#10070; </span> Comparative Statement <span>&#10070;</span> </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @php
                            $cs_no = $is_old ? old('cs_no') : $cs->cs_no ?? null;
                            $effective_date = $is_old ? old('effective_date') : $cs->effective_date ?? null;
                            /*$expiry_date = $is_old ? old('expiry_date') : $cs->expiry_date ?? null;*/
                            $indent_no = $is_old ? old('indent_no') : $cs->indent_no ?? null;
                            $remarks = $is_old ? old('remarks') : $cs->remarks ?? null;
                        @endphp
                        @if (!empty($cs_no))
                            <div class="col-xl-4 col-md-4">
                                <div class="input-group input-group-sm input-group-primary">
                                    <label class="input-group-addon" for="cs_no">CS NO</label>
                                    {{ Form::text('cs_no', $cs_no, ['class' => 'form-control', 'id' => 'cs_no', 'readonly']) }}
                                </div>
                            </div>
                        @endif

                        {{-- <div class="col-xl-4 col-md-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="cs_type">CS Type <span
                                        class="text-danger">*</span></label>
                                <select class="form-control" name="cs_type" id="cs_type" required>
                                    <option value="" disabled selected>Select PRS Type</option>
                                    <option value="Purchase Order" @selected('Purchase Order' == @$cs->cs_type)>Purchase Order</option>
                                    <option value="Work Order" @selected('Work Order' == @$cs->cs_type)>Work Order</option>
                                </select>
                            </div>
                        </div> --}}

                        <div class="col-xl-4 col-md-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="effective_date">Effective Date<span
                                        class="text-danger">*</span></label>
                                {{ Form::text('effective_date', $effective_date, ['class' => 'form-control', 'id' => 'effective_date', 'autocomplete' => 'off', 'placeholder' => 'Effective Date', 'required', 'readonly']) }}
                            </div>
                        </div>
                        {{-- <div class="col-xl-4 col-md-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="expiry_date">Expiry Date<span
                                        class="text-danger">*</span></label>
                                {{ Form::text('expiry_date', $expiry_date, ['class' => 'form-control', 'id' => 'expiry_date', 'autocomplete' => 'off', 'placeholder' => 'Expiry Date', 'required', 'readonly']) }}
                            </div>
                        </div> --}}
                        <div class="col-xl-4 col-md-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="indent_no">Indent No<span
                                        class="text-danger">*</span></label>
                                {{ Form::text('indent_no', $indent_no, ['class' => 'form-control', 'id' => 'indent_no', 'autocomplete' => 'off', 'placeholder' => 'Indent No', 'required']) }}
                            </div>
                        </div>
                        <div class="mt-1 col-xl-12 col-md-12">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="remarks">Remarks</label>
                                {{ Form::textarea('remarks', $remarks, ['class' => 'form-control', 'id' => 'remarks', 'autocomplete' => 'off', 'placeholder' => 'Remarks', 'rows' => 2]) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div id="cs">
        {{-- Projects & Materials --}}
        <div class="mt-4 row">
            <div class="col-md-12">
                <div class="tableHeading">
                    <h5> <span>&#10070;</span>Materials<span>&#10070;</span> </h5>
                </div>
                <div class="table-responsive">
                    <table id="materialTable" class="table text-center table-striped table-sm table-bordered">
                        <thead>
                        <tr>
                            <th>Material Name<span class="text-danger">*</span></th>
                            <th>Unit</th>
                            <th>Brand</th>
                            <th>Model</th>
                            <th><i class="btn btn-primary btn-sm fa fa-plus addMaterial"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $materials = $is_old ? old('material_id') ?? [] : $cs->csMaterials ?? [];
                        @endphp
                        @forelse ($materials as $material_key => $material_value)
                            @php
                                $material_id = $is_old ? old('material_id')[$material_key] : $material_value->material->id;
                                $material_name = $is_old ? old('material_name')[$material_key] : $material_value->material->materialNameWithCode ?? '---';
                                $unit = $is_old ? old('unit')[$material_key] : $material_value->material->unit ?? '---';
                                $brand_id = $is_old ? old('brand_id')[$material_key] : $material_value?->brand_id;
                                $model = $is_old ? old('model')[$material_key] : $material_value->model ?? '---';
                            @endphp
                            <tr>
                                <td>
                                    <input type="hidden" name="material_id[]" value="{{ $material_id }}"
                                           class="material_id">
                                    <input type="text" name="material_name[]" value="{{ $material_name }}"
                                           class="form-control material_name text-center" autocomplete="off" required>
                                </td>
                                <td>
                                    <input type="text" name="unit[]" value="{{ $unit }}"
                                           class="form-control unit text-center" readOnly tabindex="-1">
                                </td>
                                <td>
                                    <select name="brand_id[]" class="form-control brand text-center" autocomplete="off">
                                        <option value="">Select Brand</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}" @selected($brand->id == $brand_id)>
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="model[]" value="{{ $model }}"
                                           class="form-control model text-center" autocomplete="off">
                                </td>
                                <td>
                                    <i class="btn btn-danger btn-sm fa fa-minus deleteItem"></i>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <hr>
        {{-- Suppliers --}}
        <div class="mt-4 row">
            <div class="col-md-12">
                <div class="tableHeading">
                    <h5> <span>&#10070;</span>Suppliers<span>&#10070;</span> </h5>
                </div>
                <div class="table-responsive">
                    <table id="supplierTable" class="table text-center table-striped table-sm table-bordered">
                        <thead>
                        <tr>
                            <th width="300px"> Supplier Name<span class="text-danger">*</span><br>
                                <a href="{{ route('suppliers.create') }}" target="_blank" style="color: white">
                                    <u>Click Here to Add New Supplier</u>
                                </a>
                                <span style="font-size: 12px">
                                        <i class="fas fa-external-link-square-alt"></i>
                                    </span>
                            </th>
                            <th> Supplier Info </th>
                            <th> Quotation No. <span class="text-danger">*</span></th>
                            <th> Vat/Tax <span class="text-danger">*</span></th>
                            <th> Credit Period <span class="text-danger">*</span></th>
                            <th><i class="btn btn-primary btn-sm fa fa-plus addSupplier"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $suppliers = $is_old ? old('supplier_id') ?? [] : $cs->csSuppliers ?? [];
                        @endphp
                        @forelse (@$suppliers as $supplier_key => $supplier_value)

                            @php
                                $supplier_id = $is_old ? old('supplier_id')[$supplier_key] : $supplier_value->supplier->id;
                                $supplier_name = $is_old ? old('supplier_name')[$supplier_key] : $supplier_value->supplier->name;
                                $checked_supplier = $is_old ? isset(old('checked_supplier')[$supplier_key]) ?? false : $supplier_value->is_checked ?? false;
                                $address = $is_old ? old('address')[$supplier_key] : $supplier_value->supplier->address ?? '---';
                                $quotation_no = $is_old ? old('quotation_no')[$supplier_key] : $supplier_value->quotation_no;
                                $vat_tax = $is_old ? old('vat_tax')[$supplier_key] : $supplier_value->vat_tax;
                                $credit_period = $is_old ? old('credit_period')[$supplier_key] : $supplier_value->credit_period;
                            @endphp
                            <tr>
                                <td>
                                    <input type="hidden" name="supplier_id[]" value="{{ $supplier_id }}"
                                           class="supplier_id">
                                    <div class="form-check">
                                        <input name="checked_supplier[]"
                                               @if ($checked_supplier) checked @endif
                                               value="{{ $supplier_id }}" class="form-check-input checked_supplier_id"
                                               type="checkbox" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Mark as selected
                                        </label>
                                    </div>
                                    <input type="text" value="{{ $supplier_name }}" name="supplier_name[]"
                                           class="form-control supplier_name" autocomplete="off" required>
                                </td>
                                <td>
                                    <input type="text" name="address[]" value="{{ $address }}"
                                           class="form-control address" hidden tabindex="-1">
                                    <div>
                                        <span><b>Address : </b></span>
                                        <span class="address_div"> {{ $address }} </span>
                                    </div>
                                </td>
                                <td>
                                    <input type="text" name="quotation_no[]" value="{{ $quotation_no }}"
                                           class="form-control quotation_no text-center" placeholder="Quotation No"
                                           autocomplete="off" required>
                                </td>
                                <td>
                                    <select name="vat_tax[]" id="vat_tax" class="form-control vat_tax text-center"
                                            required>
                                        @foreach ($Taxes as $data)
                                            <option value="{{ $data }}"
                                                    @if ($vat_tax == $data) Selected @endif>{{ $data }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="credit_period[]" value="{{ $credit_period }}"
                                           class="form-control credit_period text-center" placeholder="Credit Period"
                                           autocomplete="off" required>
                                </td>
                                <td>
                                    <i class="btn btn-danger btn-sm fa fa-minus deleteItem"></i>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <hr>

    {{-- Comparative Statement Details --}}
    <div id="cs_details">
        <div class="mt-4 row">
            <div class="col-md-12">
                <div class="tableHeading">
                    <h5> <span>&#10070;</span>Comparative Statement Details<span>&#10070;</span> </h5>
                </div>
                <div class="table-responsive">
                    <table id="csDetailsTable" class="table text-center table-striped table-sm table-bordered">
                        <thead>
                        <tr>
                            <th>Materials</th>
                            <th>Brand</th>
                            <th>Model</th>
                            @forelse ($suppliers as $supplier_key => $supplier_value)
                                <th>
                                    {{ $is_old ? old('supplier_name')[$supplier_key] : $supplier_value->supplier->name }}
                                </th>
                            @empty
                            @endforelse
                        </tr>
                        </thead>
                        <tbody>
                        @php $price_index = 0; @endphp
                        @forelse ($materials as $material_key => $material_value)
                            @forelse ($suppliers as $supplier_key => $supplier_value)
                                @if ($loop->first)
                                    <tr>
                                        <td class="cs_material text-center">
                                            {{ $is_old ? old('material_name')[$material_key] : $material_value->material->materialNameWithCode }}
                                        </td>
                                        <td class="cs_brand text-center">
                                            {{ $is_old ? old('cs_brand_name')[$material_key] : $material_value?->brand?->name ?? 'Null' }}
                                        </td>
                                        <input type="hidden" name="cs_brand_name[]" class="cs_brand_name"
                                               value="{{ $is_old ? old('cs_brand_name')[$material_key] : $material_value?->brand?->name ?? 'Null' }}">
                                        <td class="cs_model text-center">
                                            {{ $is_old ? old('model')[$material_key] : $material_value->model ?? 'Null' }}
                                        </td>
                                        @endif
                                        <td>
                                            <input type="text" name="price[]"
                                                   value="{{ $is_old
                                                ? old('price')[$price_index++]
                                                : $cs->csMaterialsSuppliers->where('cs_material_id', $material_value->id)->where('cs_supplier_id', $supplier_value->id)->first()->price }}"
                                                   class="form-control text-center" placeholder="Pricez" required />
                                        </td>
                                        @if ($loop->last)
                                    </tr>
                                @endif
                            @empty
                            @endforelse
                        @empty
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="mt-2 offset-md-4 col-md-4">
            <div class="input-group input-group-sm ">
                <button class="py-2 btn btn-success btn-round btn-block">Save</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section('script')
    <script>
        let is_confirmed = false;

        function addMaterial() {
            $('#materialTable tbody').append(
                `<tr>
                    <td>
                        <input type="hidden" name="material_id[]" value="" class="material_id">
                        <input type="text" name="material_name[]" class="form-control material_name text-center" autocomplete="off" required>
                    </td>
                    <td>
                        <input type="text" name="unit[]" class="form-control unit text-center" readOnly tabindex="-1">
                    </td>
                    <td>
                        <select name="brand_id[]" class="form-control brand text-center" autocomplete="off">
                            <option value="">Select Brand</option>
                            @foreach ($brands as $brand)
                <option value="{{ $brand->id }}" @selected($brand->id == @$brand_id[$key])>{{ $brand->name }}</option>
                            @endforeach
                </select>
            </td>
            <td>
                <input type="text" name="model[]" class="form-control model text-center" autocomplete="off">
            </td>
            <td>
                <i class="btn btn-danger btn-sm fa fa-minus deleteItem"></i>
            </td>
        </tr>`
            );
        }

        function addSupplier() {
            $('#supplierTable tbody').append(
                `<tr>
                    <td>
                        <input type="hidden" name="supplier_id[]" class="supplier_id">
                        <div class="form-check">
                            <input name="checked_supplier[]" class="form-check-input checked_supplier_id" type="checkbox" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Mark as selected
                            </label>
                        </div>
                        <input type="text" class="form-control supplier_name" name="supplier_name[]" autocomplete="off" required>
                    </td>
                    <td>
                        <input type="text" name="address[]" class="form-control address" hidden tabindex="-1">
                        <div>
                            <span><b>Address : </b></span>
                            <span class="address_div">---</span>
                        </div>
                    </td>
                    <td>
                        <input type="text" name="quotation_no[]"  class="form-control text-center quotation_no" placeholder="Quotation No." autocomplete="off" required>
                    </td>
                    <td>
                        <select name="vat_tax[]" id="vat_tax" class="form-control vat_tax text-center" required>
                            @foreach ($Taxes as $data)
                <option value="{{ $data }}">{{ $data }}</option>
                            @endforeach
                </select>
            </td>
            <td>
                <input type="text" name="credit_period[]"  class="form-control credit_period text-center" placeholder="Credit Period" autocomplete="off" required>
            </td>
            <td>
                <i class="btn btn-danger btn-sm fa fa-minus deleteItem"></i>
            </td>
        </tr>`
            );
        }

        // Function for populating dropdowns
        function populateDropDown(dropdown, data, key_name, type) {
            dropdown.empty();

            dropdown.append(`<option selected="true" value>Select ${type}</option>`);
            dropdown.prop('selectedIndex', 0);

            $.each(data, function(key, value) {
                dropdown.append($(`<option></option>`).attr('value', value[key_name]).text(value[key_name]));
            });
        }

        // Cs Details Row
        function changeCsRow(column, material_name, brand) {

            let cs_details_table_body = $('#csDetailsTable tbody');
            cs_details_table_body.children(`tr:eq(${column.index()})`).find(".cs_material").html(material_name);
            cs_details_table_body.children(`tr:eq(${column.index()})`).find(".cs_brand_name").val(brand);
            cs_details_table_body.children(`tr:eq(${column.index()})`).find(".cs_brand").html(brand);
        }

        //on change brand
        $(document).on('change', '.brand', function() {
            let brand = $(this).find('option:selected').text();
            let material_name = $(this).closest('tr').find('.material_name').val();
            let column = $(this).closest('tr');
            changeCsRow(column, material_name, brand);
        });



        function changeCsRowModel(column, model) {
            let cs_details_table_body = $('#csDetailsTable tbody');
            cs_details_table_body.children(`tr:eq(${column.index()})`).find(".cs_model").html(model);
        }
        //on change model
        $(document).on('keyup', '.model', function() {
            let column = $(this).closest('tr');
            let model = ($(this).val());
            changeCsRowModel(column, model);
        });


        function addCsRow() {
            let cs_details_table_tbody = $('#csDetailsTable tbody');
            let count_supplier = $('.supplier_name').length ? 0 : $('.supplier_name').length;
            let table_data =
                `<tr><td colspan="${count_supplier}" class="cs_material">Select a Material</td><td colspan="${count_supplier}" class="cs_brand">Select a Brand</td>
                <input type="hidden" name="cs_brand_name[]" class="cs_brand_name">
                <td colspan="${count_supplier}" class="cs_model">Model</td>`;

            $('.supplier_name').each(function() {
                table_data +=
                    `<td> <input type="number" name="price[]" class="form-control" placeholder="Price" step="0.01" required/> </td>`;
            });

            cs_details_table_tbody.append(table_data += `</tr>`);
        }

        function removeCsRow(index) {
            let cs_details_table_body = $('#csDetailsTable tbody');
            cs_details_table_body.children(`tr:eq(${index})`).remove();
        }

        // Cs Details Column
        function changeCsColumn(column, supplier_name) {
            let cs_details_table_head = $('#csDetailsTable thead tr');
            let th = cs_details_table_head.children(`th:eq(${column.index() + 3})`).html(supplier_name);
        }

        function addCsColumn() {
            let cs_details_table_head = $('#csDetailsTable thead tr');
            cs_details_table_head.append(`<th>Supplier Name</th>`);

            let cs_details_table_body = $('#csDetailsTable tbody');
            $("#csDetailsTable tbody tr").each(function() {
                $(this).append(
                    `<td> <input type="number" name="price[]" class="form-control" placeholder="Price" step="0.01" required/> </td>`
                );
            });
        }

        function removeCsColumn(index) {
            let cs_details_table_head = $('#csDetailsTable thead tr');
            cs_details_table_head.children(`th:eq(${index + 2})`).remove();

            let cs_details_table_body = $('#csDetailsTable tbody');
            $("#csDetailsTable tbody tr").each(function() {
                $(this).children(`td:eq(${index + 2})`).remove();
            });
        }

        $(function() {
            $(document).on('keyup', ".supplier_name", function() {
                $(this).autocomplete({
                    source: function(request, response) {
                        $.ajax({
                            url: "{{ route('searchSupplier') }}",
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
                        $(this).closest('tr').find('.supplier_name').val(ui.item.label);
                        $(this).closest('tr').find('.supplier_id').val(ui.item.value);
                        $(this).closest('tr').find('.checked_supplier_id').val(ui.item.value);
                        $(this).closest('tr').find('.address').val(ui.item.address);
                        $(this).closest('tr').find('.address_div').html(ui.item.address);
                        $(this).closest('tr').find('.contact_div').html(ui.item.contact);

                        changeCsColumn($(this).closest('tr'), ui.item.label);
                        return false;
                    }
                });
            });

            //Search Material
            $(document).on('keyup focus', '.material_name', function() {
                $(this).autocomplete({
                    source: function(request, response) {
                        var indentNo = $("#indent_no").val();
                        $.ajax({
                            url: "{{ url('scm/search-material-by-indent') }}",
                            type: 'get',
                            dataType: "json",
                            data: {
                                search: request.term,
                                indent_no: indentNo
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

            $("#materialTable").on('click', '.addMaterial', function() {
                addMaterial();
                addCsRow();
            }).on('click', '.deleteItem', function() {
                removeCsRow($(this).closest('tr').index());
                $(this).closest('tr').remove();
            });

            $("#supplierTable").on('click', '.addSupplier', function() {
                addSupplier();
                addCsColumn();
            }).on('click', '.deleteItem', function() {
                removeCsColumn($(this).closest('tr').index() + 1);
                $(this).closest('tr').remove();
            });

            // $('#expiry_date,#effective_date').datepicker({
            //     format: "dd-mm-yyyy",
            //     autoclose: true,
            //     todayHighlight: true,
            //     showOtherMonths: true
            // });
            $('#effective_date').datepicker({
                format: "yyyy-mm-dd",
                autoclose: true,
                todayHighlight: true,
                showOtherMonths: true
            }).datepicker("setDate", new Date());
        }); // document.ready

        var select_all_projects = function() {
            if ($("#select_all_projects").is(":checked")) {
                $('#plus').prop('disabled', true);
            } else {
                $('#plus').prop('disabled', false);
            }
        };

        $(select_all_projects);
        $("#select_all_projects").change(select_all_projects);
    </script>
    <script src="{{ asset('js/get-indent-no.js') }}"></script>
@endsection
