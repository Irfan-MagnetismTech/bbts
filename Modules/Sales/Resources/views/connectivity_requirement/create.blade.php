@extends('layouts.backend-layout')
@section('title', 'Connectivity Requirement')

@php
    $is_old = old() ? true : false;
    $form_heading = !empty($connectivity_requirement->id) ? 'Update' : 'Add';
    $form_url = !empty($connectivity_requirement->id) ? route('connectivity-requirement.update', $connectivity_requirement->id) : route('connectivity-requirement.store');
    $form_method = !empty($connectivity_requirement->id) ? 'PUT' : 'POST';
@endphp

@section('breadcrumb-title')
    {{ ucfirst($form_heading) }} Connectivity Requirement
@endsection

@section('breadcrumb-button')
    <a href="{{ route('connectivity-requirement.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-list"></i></a>

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
                    <h5> <span> &#10070; </span> Connectivity Requirement <span>&#10070;</span> </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @php
                            if (!empty($connectivity_requirement)) {
                                $category_data = $connectivity_requirement->connectivityProductRequirementDetails->pluck('category_id')->toArray();
                                $product_id = $connectivity_requirement->connectivityProductRequirementDetails->pluck('product_id')->toArray();
                                $capacity = $connectivity_requirement->connectivityProductRequirementDetails->pluck('capacity')->toArray();
                                $remarks = $connectivity_requirement->connectivityProductRequirementDetails->pluck('remarks')->toArray();
                                $link_type = $connectivity_requirement->connectivityRequirementDetails->pluck('link_type')->toArray();
                                $connectivity_capacity = $connectivity_requirement->connectivityRequirementDetails->pluck('connectivity_capacity')->toArray();
                                $method = $connectivity_requirement->connectivityRequirementDetails->pluck('method')->toArray();
                                $uptime_req = $connectivity_requirement->connectivityRequirementDetails->pluck('sla')->toArray();
                            }
                            
                            $client_name = $is_old ? old('client_name') : $connectivity_requirement->lead_generation->client_name ?? $fr_detail->feasibilityRequirement->lead_generation->client_name;
                            $client_id = $is_old ? old('client_id') : $connectivity_requirement->lead_generation->client_id ?? $fr_detail->feasibilityRequirement->lead_generation->client_id;
                            $date = $is_old ? old('date') : $connectivity_requirement->date ?? null;
                            $mq_no = $is_old ? old('mq_no') : $connectivity_requirement->mq_no ?? $fr_detail->feasibilityRequirement->mq_no;
                            $category_data = $is_old ? old('category_id') : $category_data ?? [];
                            $aggregation_type = $is_old ? old('aggregation_type') : $connectivity_requirement->aggregation_type ?? null;
                            $from_location = $is_old ? old('from_location') : $connectivity_requirement->from_location ?? null;
                            $link_name = $is_old ? old('link_name') : $connectivity_requirement->fromLocation->link_name ?? $fr_detail->link_name;
                            $fr_no = $is_old ? old('fr_no') : $connectivity_requirement->fr_no ?? $fr_detail->fr_no;
                            $product_id = $is_old ? old('product_id') : $product_id ?? null;
                            $capacity = $is_old ? old('capacity') : $capacity ?? null;
                            $unit = $is_old ? old('unit') : $connectivity_requirement->product_unit ?? null;
                            $link_type = $is_old ? old('link_type') : $link_type ?? null;
                            $connectivity_capacity = $is_old ? old('connectivity_capacity') : $connectivity_capacity ?? null;
                            $method = $is_old ? old('method') : $method ?? null;
                            $uptime_req = $is_old ? old('uptime_req') : $uptime_req ?? null;
                            $product_select = $is_old ? old('product_select') : $connectivity_requirement->product_select ?? null;
                        @endphp
                    </div>
                    <div class="row">
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="client_id" id="client_id" class="form-control"
                                    value="{{ $client_id }}" readonly>
                                <label for="client_id">Client ID <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="client_name" id="client_name" class="form-control"
                                    value="{{ $client_name }}" readonly>
                                <label for="client_name">Client Name <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="date" id="date" class="form-control"
                                    value="{{ $date }}" readonly>
                                <label for="date">Date <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <select name="from_location" id="from_location" class="form-control">
                                    <option value="">Select From Location</option>
                                    @foreach ($all_fr_list as $fr)
                                        <option value="{{ $fr->id }}"
                                            {{ $fr->id == $from_location ? 'selected' : '' }}>
                                            {{ $fr->fr_no }}</option>
                                    @endforeach
                                </select>
                                <label for="from_location">From Location <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <select name="aggregation_type" id="aggregation_type" class="form-control">
                                    <option value="">Select Aggregation Type</option>
                                    <option value="DR" {{ $aggregation_type == 'DR' ? 'selected' : '' }}>DR</option>
                                    <option value="DC" {{ $aggregation_type == 'DC' ? 'selected' : '' }}>IR</option>
                                    <option value="Branch" {{ $aggregation_type == 'Branch' ? 'selected' : '' }}>Branch
                                    </option>
                                </select>
                                <label for="aggregation_type">Aggregation Type <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="link_name" id="link_name" class="form-control"
                                    value="{{ $link_name }}" readonly>
                                <label for="link_name">Link Name <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="md-col-3 col-3">
                            <div class="form-item">
                                <input type="text" name="fr_no" id="fr_no" class="form-control"
                                    value="{{ $fr_no }}" readonly>
                                <label for="fr_no">FR No <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        {{-- file upload --}}
                        <div class="md-col-3 col-3">
                            <input type="file" name="file" id="file" class="form-control" title="Upload File">
                        </div>
                    </div>
                    <div class="row">


                    </div>

                    <hr />
                    <div class="text-center">
                        <h5> <span> &#10070; </span> Connectivity Details <span>&#10070;</span> </h5>
                    </div>
                    <hr />
                    {{-- create a responsive table --}}
                    <div class="row">
                        <div class="md-col-6 col-6">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th colspan="6">Product Details</th>
                                        </tr>
                                        <tr>
                                            <th>Category</th>
                                            <th>Product</th>
                                            <th>Capacity</th>
                                            <th>Unit</th>
                                            <th>Remarks</th>
                                            <th>
                                                <button type="button" class="btn btn-sm btn-success" id="addProductRow"><i
                                                        class="fas fa-plus"></i></button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="productBody">
                                        @if ($category_data)
                                            @foreach ($category_data as $key => $cat_data)
                                                <tr class="product_details_row">
                                                    <td>
                                                        <select name="category_id[]" class="form-control category_id">
                                                            <option value="">Select Category</option>
                                                            @foreach ($categories as $category)
                                                                <option value="{{ $category->id }}"
                                                                    @if ($category->id == $category_data[$key]) selected @endif>
                                                                    {{ $category->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="product_id[]" class="form-control product_id">
                                                            @if ($product_select)
                                                                @foreach ($product_select as $product)
                                                                    @foreach ($product as $pro_key => $value)
                                                                        <option value="{{ $value }}"
                                                                            @if ($value == $product_id[$key]) selected @endif>
                                                                            {{ $pro_key }}</option>
                                                                    @endforeach
                                                                @endforeach
                                                            @else
                                                                <option value="">Select Product</option>
                                                            @endif
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="capacity[]"
                                                            class="form-control capacity" value="{{ $capacity[$key] }}"
                                                            placeholder="Capacity" />
                                                    </td>
                                                    <td>
                                                        <input type="text" name="unit[]" value="{{ $unit[$key] }}"
                                                            class="form-control unit" placeholder="Unit" />
                                                    </td>
                                                    <td>
                                                        <input type="text" name="remarks[]"
                                                            value="{{ $remarks[$key] }}" class="form-control remarks"
                                                            placeholder="Remarks" />
                                                    </td>
                                                    <td>
                                                        <button type="button" producut_attr=""
                                                            class="btn btn-sm btn-danger removeProductRow"><i
                                                                class="fas fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr class="product_details_row">
                                                <td>
                                                    <select name="category_id[]" class="form-control category_id">
                                                        <option value="">Select Category</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}">{{ $category->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="product_id[]" class="form-control product_id">
                                                        <option value="">Select Product</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" name="capacity[]" class="form-control capacity"
                                                        placeholder="Capacity" />
                                                </td>
                                                <td>
                                                    <input type="text" name="unit[]" class="form-control unit"
                                                        placeholder="Unit" />
                                                </td>
                                                <td>
                                                    <input type="text" name="remarks[]" class="form-control remarks"
                                                        placeholder="Remarks" />
                                                </td>
                                                <td>
                                                    <button type="button" producut_attr=""
                                                        class="btn btn-sm btn-danger removeProductRow"><i
                                                            class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="md-col-6 col-6">
                            {{-- Connectivity Details --}}
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th colspan="6">Connectivity Details</th>
                                        </tr>
                                        <tr>
                                            <th>Link Type</th>
                                            <th>Method</th>
                                            <th>Capacity %</th>
                                            <th>Uptime Reg/SLA</th>
                                            <th>Vendor</th>
                                            <th>
                                                <button type="button" class="btn btn-sm btn-success"
                                                    id="addConnectivityRow"><i class="fas fa-plus"></i></button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="connectivityBody">
                                        @if ($link_type)
                                            @foreach ($link_type as $key => $type)
                                                <tr class="connectivity_details_row">
                                                    <td>
                                                        <select name="link_type[]" class="form-control link_type">
                                                            <option value="">Select Link Type</option>
                                                            <option value="Primary"
                                                                @if ($type == 'Primary') selected @endif>Primary
                                                            </option>
                                                            <option value="Secondary"
                                                                @if ($type == 'Secondary') selected @endif>Secondary
                                                            </option>
                                                            <option value="Tertiary"
                                                                @if ($type == 'Tertiary') selected @endif>Tertiary
                                                            </option>

                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="method[]" class="form-control method">
                                                            <option value="">Select Method</option>
                                                            <option value="Fiber"
                                                                @if ($method[$key] == 'Fiber') selected @endif>Fiber
                                                            </option>
                                                            <option value="Radio"
                                                                @if ($method[$key] == 'Radio') selected @endif>Radio
                                                            </option>
                                                            <option value="GSM"
                                                                @if ($method[$key] == 'GSM') selected @endif>GSM
                                                            </option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="connectivity_capacity[]"
                                                            class="form-control capacity"
                                                            value="{{ $connectivity_capacity[$key] }}"
                                                            placeholder="Capacity %" />
                                                    </td>
                                                    <td>
                                                        <input type="text" name="uptime_req[]" id="uptime_req"
                                                            class="form-control" value="{{ $uptime_req[$key] }}"
                                                            placeholder="Uptime Reg/SLA" />
                                                    </td>
                                                    <td>
                                                        <select name="vendor_id[]" class="form-control vendor_id">
                                                            <option value="">Select Vendor</option>
                                                            @foreach ($vendors as $vendor)
                                                                <option value="{{ $vendor->id }}"
                                                                    @if ($vendor_id[$key] == $vendor->id) selected @endif>
                                                                    {{ $vendor->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <button type="button" connectivity_attr=""
                                                            class="btn btn-sm btn-danger removeConnectivityRow"><i
                                                                class="fas fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr class="connectivity_details_row">
                                                <td>
                                                    <select name="link_type[]" class="form-control link_type">
                                                        <option value="">Select Link Type</option>
                                                        <option value="Primary">Primary</option>
                                                        <option value="Secondary">Secondary</option>
                                                        <option value="Tertiary">Tertiary</option>

                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="method[]" class="form-control method">
                                                        <option value="">Select Method</option>
                                                        <option value="Fiber">Fiber</option>
                                                        <option value="Radio">Radio</option>
                                                        <option value="GSM">GSM</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" name="connectivity_capacity[]"
                                                        class="form-control capacity" placeholder="Capacity %" />
                                                </td>
                                                <td>
                                                    <input type="text" name="uptime_req[]" id="uptime_req"
                                                        class="form-control" placeholder="Uptime Reg/SLA" />
                                                </td>
                                                <td>
                                                    <select name="vendor_id[]" class="form-control vendor_id">
                                                        <option value="">Select Vendor</option>
                                                        @foreach ($vendors as $vendor)
                                                            <option value="{{ $vendor->id }}">
                                                                {{ $vendor->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <button type="button" connectivity_attr=""
                                                        class="btn btn-sm btn-danger removeConnectivityRow"><i
                                                            class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <button
                        class="py-2 btn btn-success float-right">{{ !empty($connectivity_requirement->id) ? 'Update' : 'Save' }}</button>
                </div>
            </div>
            {!! Form::close() !!}

        @endsection

        @section('script')
            <script>
                let products;
                $(document).on('change', '.category_id', function() {
                    console.log('fine')
                    var category_id = $(this).val();
                    var row = $(this).closest('tr').find('.product_id');
                    $.ajax({
                        url: "{{ route('get-products') }}",
                        data: {
                            category_id: category_id,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            products = data;
                            let html = '<option value="">Select Product</option>';
                            $.each(data, function(key, value) {
                                html += '<option value="' + value.id + '">' + value.name + '</option>';
                            });
                            row.html(html);
                        }
                    });
                });

                $(document).on('change', '.product_id', function() {
                    var product_id = $(this).val();
                    var row = $(this).closest('tr').find('.unit');
                    products.find(function(product) {
                        if (product.id == product_id) {
                            row.val(product.unit);
                        }
                    });
                })

                $('#addProductRow').on('click', function() {
                    addProductRow();
                });

                $('#addConnectivityRow').on('click', function() {
                    addConnectivityRow();
                });

                function addProductRow() {
                    $('.product_details_row').first().clone().appendTo('.productBody');
                    $('.product_details_row').last().find('input').val('');
                    $('.product_details_row').last().find('select').val('');
                };

                function addConnectivityRow() {
                    $('.connectivity_details_row').first().clone().appendTo('.connectivityBody');
                    $('.connectivity_details_row').last().find('input').val('');
                    $('.connectivity_details_row').last().find('select').val('');
                };

                $(document).on('click', '.removeProductRow', function() {
                    let count = $('.product_details_row').length;
                    if (count > 1) {
                        $(this).closest('tr').remove();
                        //get attr_one value 
                        var attr_one = $(this).attr('product_attr');
                        //if attr_one value is not empty then delete from database
                        if (attr_one != '') {
                            $.ajax({
                                url: "{{ route('delete-product-requirement-details') }}",
                                data: {
                                    id: attr_one,
                                    _token: "{{ csrf_token() }}"
                                },
                                success: function(data) {
                                    console.log(data);
                                }
                            });
                        }
                    }
                });

                $(document).on('click', '.removeConnectivityRow', function() {
                    let count = $('.connectivity_details_row').length;
                    if (count > 1) {
                        $(this).closest('tr').remove();
                        //get attr_one value 
                        var attr_one = $(this).attr('connectivity_attr');
                        //if attr_one value is not empty then delete from database
                        if (attr_one != '') {
                            $.ajax({
                                url: "{{ route('delete-connectivity-requirement-details') }}",
                                data: {
                                    id: attr_one,
                                    _token: "{{ csrf_token() }}"
                                },
                                success: function(data) {
                                    console.log(data);
                                }
                            });
                        }
                    }
                });

                $('#date').datepicker({
                    format: "dd-mm-yyyy",
                    autoclose: true,
                    todayHighlight: true,
                    showOtherMonths: true
                }).datepicker("setDate", new Date());
            </script>
        @endsection
