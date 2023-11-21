<script>
    $(document).ready(function() {
        let html = `
        <div class="main_link">
                            <input type="hidden" name="plan_link_no_1" value="">
                            <div class="row">
                                <div class="col-md-10 col-10">
                                    <h5 class="text-center mb-2"> <span>&#10070;</span> Link - <span
                                            class="link_no">1</span> <span>&#10070;</span></h5>
                                </div>
                                {{-- <div class="col-md-1 col-1">
                                    <button type="button" class="btn btn-sm btn-outline-success" style="padding: 5px 10px" id="addLinkRow">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div> --}}
                                <div class="col-md-1 col-1">
                                    <nobr>
                                        <button type="button" class="btn btn-sm btn-outline-success addLinkRow"
                                            style="padding: 5px 10px">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                        <button type="button"
                                            class="btn btn-sm btn-outline-danger text-left removeLinkRow"
                                            style="padding: 5px 10px" onclick="removeLinkRow(this)"><i
                                                class="fas fa-trash"></i></button>
                                    </nobr>
                                </div>
                                {{-- <hr style="width: 100%; margin-bottom: 10px;"> --}}
                                <div class="md-col-3 col-3  mt-3">
                                    <div class="form-item">
                                        <select name="link_type_1" class="form-control form-control-sm link_type "
                                            required>
                                            <option value="">Select Type</option>
                                            <option value="Primary">Primary</option>
                                            <option value="Secondary">Secondary</option>
                                            <option value="Tertiary">Tertiary</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="md-col-3 col-3  mt-3">
                                    <div class="form-item">
                                        <select name="option_1" class="form-control form-control-sm option "
                                            onchange="optionChange(event)" required>
                                            <option value="">Select Option</option>
                                            <option value="Option 1">Option 1</option>
                                            <option value="Option 2">Option 2</option>
                                            <option value="Option 3">Option 3
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-3 col-md-3  mt-3">
                                    <div class="form-item">
                                        <select name="existing_infrastructure_1"
                                            class="form-control form-control-sm existing_infrastructure">
                                            <option value="">Select Status</option>
                                            <option value="Existing">Existing</option>
                                            <option value="New">New</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-3 col-md-3 mt-3 link_list" style="display: none">
                                    <div class="form-item">
                                        <select name="existing_infrastructure_link_1"
                                            class="form-control form-control-sm existing_infrastructure_link ">
                                            <option value="">Select Link</option>
                                        </select>
                                        <label for="type">Link List</label>
                                    </div>
                                </div>
                                <div class="md-col-3 col-3  mt-3" style="display: none">
                                    <div class="form-item">
                                        <input type="text" name="existing_transmission_capacity_1"
                                            class="form-control form-control-sm existing_transmission_capacity"
                                            value="">
                                        <label for="type">Existing T.Capacity</label>
                                    </div>
                                </div>

                                <div class="md-col-3 col-3 mt-3" style="display: none">
                                    <div class="form-item">
                                        <input type="text" name="increase_capacity_1"
                                            class="form-control form-control-sm increase_capacity" value="">
                                        <label for="type">Increase Capacity</label>
                                    </div>
                                </div>
                                <div class="md-col-3 col-3  mt-3 new_transmission_capacity_div">
                                    <div class="form-item">
                                        <input type="text" name="new_transmission_capacity_1"
                                            class="form-control form-control-sm" value="">
                                        <label for="type">New T.Capacity</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered surveyTable" style="font-size: 12px;">
                                        <tr>
                                            <th class="text-center"
                                                style="background-color: #e1e7ec !important; font-size: 14px !important;"
                                                colspan="4"> Survey Information</th>
                                        </tr>
                                        <tr>
                                            <th class="text-left table_label">Vendor</th>
                                            <td class="link_vendor" style="width:40%">
                                                <select name="link_vendor_id_1"
                                                    class="form-control form-control-sm link_vendor_id_1 select2"
                                                    style="display: none">
                                                    <option value="">Select Vendor</option>
                                                    @foreach ($vendors as $vendor)
                                                        <option value="{{ $vendor->id }}">
                                                            {{ $vendor->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <th class="text-left table_label"> POP Vendors</th>
                                            <td class="running_vendor_pop" style="width:40%"></td>
                                        </tr>
                                        <tr>
                                            <th class="text-left">POP</th>
                                            <td class="link_connecting_pop" style="width:40%">
                                                <select name="link_connecting_pop_id_1"
                                                    class="form-control form-control-sm link_connecting_pop_id_1 select2"
                                                    style="display: none">
                                                    <option value="">Select POP</option>
                                                    @foreach ($pops as $pop)
                                                        <option value="{{ $pop->id }}"> {{ $pop->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <th class="text-left"> POP Capacity</th>
                                            <td class="running_vendor_capacity" style="width:40%"></td>
                                        </tr>
                                        <tr>
                                            <th class="text-left">Method</th>
                                            <td class="last_mile_connectivity_method" style="width:40%">
                                                {{-- <input type="text" name="last_mile_connectivity_method_1"
                                                    class="form-control form-control-sm last_mile_connectivity_method_1"
                                                    style="height: 25px !important" value="" > --}}
                                                <select name="last_mile_connectivity_method_1"
                                                    class="form-control form-control-sm last_mile_connectivity_method_1">
                                                    <option value="">Select Method</option>
                                                    @foreach ($methods as $key => $method)
                                                        <option value="{{ $key }}">{{ $method }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <th class="text-left">Zone Vendors</th>
                                            <td class="nttn_vendor_zone" style="width:40%"></td>
                                        </tr>
                                        <tr>
                                            <th class="text-left">Latitude</th>
                                            <td class="connectivity_lat_long" style="width:40%">
                                                <input type="text" name="connectivity_lat_1"
                                                    class="form-control form-control-sm connectivity_lat_1"
                                                    style="height: 25px !important" value="">
                                            </td>
                                            <th class="text-left">Zone Capacity</th>
                                            <td class="running_nttn_bw" style="width:40%"></td>
                                        </tr>
                                        <tr>
                                            <th class="text-left">Longitude</th>
                                            <td class="connectivity_lat_long" style="width:40%">
                                                <input type="text" name="connectivity_long_1"
                                                    class="form-control form-control-sm connectivity_long_1"
                                                    style="height: 25px !important" value="">
                                            </td>
                                            <th class="text-left">Connectivity Route</th>
                                            <td class="connectivity_route" style="width:40%"></td>

                                        </tr>
                                        <tr>
                                            <th class="text-left">Distance</th>
                                            <td class="connectivity_lat_long" style="width:40%">
                                                <input type="text" name="distance_1"
                                                    class="form-control form-control-sm distance_1"
                                                    style="height: 25px !important" value="">
                                            </td>
                                            <th class="text-left">Remarks</th>
                                            <td class="connectivity_route" style="width:40%">
                                                <input type="text" name="link_remarks_1"
                                                    class="form-control form-control-sm" style="height: 25px !important"
                                                    value="">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered" style="font-size: 12px;">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="font-size: 14px!important" colspan="7">
                                                    <span> &#10070; </span> Link Equipment <span>&#10070;</span>
                                                </th>
                                                <th rowspan="2">
                                                    <button type="button"
                                                        class="btn btn-success btn-sm addLinkEquipmentRow"
                                                        style="padding: 5px 10px" onclick="addLinkEquipmentRow(this)">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>Equipment Name</th>
                                                <th>Quantity</th>
                                                <th>Unit</th>
                                                <th>Brand</th>
                                                <th>Model</th>
                                                <th>Description</th>
                                                <th>Remarks</th>

                                            </tr>
                                        </thead>
                                        <tbody class="link_equipment_table">
                                            <tr>
                                                <td>
                                                    <div>
                                                        <select name="material_id_1[]"
                                                            class="form-control form-control-sm link_material_id select2">
                                                            <option value="">Select Equipment</option>
                                                            @foreach ($materials as $material)
                                                                <option value="{{ $material->id }}">
                                                                    {{ $material->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="quantity_1[]"
                                                        class="form-control form-control-sm link_quantity" value="">
                                                </td>
                                                <td>
                                                    <input type="text" name="unit_1[]"
                                                        class="form-control form-control-sm link_unit" value="">
                                                </td>
                                                <td>
                                                    <div>
                                                        <select name="brand_id_1[]"
                                                            class="form-control form-control-sm link_brand select2">
                                                            <option value="">Select Brand</option>
                                                            @foreach ($brands as $brand)
                                                                <option value="{{ $brand->id }}">
                                                                    {{ $brand->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>
                                                        <input list="models" name="model_1[]" id="model_1[]"
                                                            class="form-control link_model" value="">
                                                        <datalist id="models">
                                                            @foreach ($models as $model)
                                                                <option value="{{ $model }}">
                                                            @endforeach
                                                        </datalist>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="description_1[]"
                                                        class="form-control form-control-sm link_description"
                                                        value="">
                                                </td>
                                                <td>
                                                    <input type="text" name="remarks_1[]"
                                                        class="form-control form-control-sm link_remarks" value="">
                                                </td>
                                                <td>
                                                    <button type="button"
                                                        class="btn btn-outline-danger btn-sm removeLinkEquipmentRow"
                                                        style="padding: 5px 10px" onclick="removeLinkEquipmentRow(this)">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>`;
        if ($('#link_container').find('.main_link').length == 0) {
            $('#link_container').append(html);
            $('.select2').select2();
        } else {
            console.log('link_container is not empty');
        }

        let equipment_plan = `
                <tr class="equipment_row">
                    <td>
                        <select name="equipment_id[]"
                            class="form-control form-control-sm equipment_id select2">
                            <option value="">Select Equipment</option>
                            @foreach ($materials as $material)
                                <option value="{{ $material->id }}">
                                    {{ $material->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="text" name="quantity[]"
                            class="form-control form-control-sm" value="">
                    </td>
                    <td>
                        <input type="text" name="unit[]"
                            class="form-control form-control-sm unit" value="">
                    </td>
                    <td>
                        <select name="brand_id[]"
                            class="form-control form-control-sm brand_id select2">
                            <option value="">Select Brand</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}">
                                    {{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="text" name="model[]"
                            class="form-control form-control-sm model" value="">
                    </td>
                    <td>
                        <input type="text" name="equipment_remarks[]"
                            class="form-control form-control-sm equipment_remarks" value="">
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger removeEquipmentRow"><i
                                class="fas fa-trash"></i></button>
                    </td>
                </tr>
        `;
        if ($('#EquipmentPlan').find('.equipment_row').length == 0) {
            $('#equipment_body').append(equipment_plan);
            $('.select2').select2();
        } else {
            console.log('equipment_container is not empty');
        }
    });
</script>
