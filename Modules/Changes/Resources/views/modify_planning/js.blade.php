<script>
    $(document).ready(function() {
        let html = `
        <div class="main_link">
                            <div class="row">
                                <div class="col-md-11 col-11">
                                    <h5 class="text-center mb-2">Link <span class="link_no">1</span></h5>
                                </div>
                                <div class="col-md-1 col-1">
                                    <button type="button" class="btn btn-sm btn-danger text-left removeLinkRow"
                                        onclick="removeLinkRow(this)"><i class="fas fa-trash"></i></button>
                                </div>
                                <hr / style="width: 100%; margin-bottom: 10px;">
                                <div class="md-col-3 col-3  mt-3">
                                    <div class="form-item">
                                        <select name="link_type_1" class="form-control form-control-sm link_type">
                                            <option value="">Select Type</option>
                                            <option value="Primary">Primary</option>
                                            <option value="Secondary">Secondary</option>
                                            <option value="Tertiary">Tertiary</option>
                                        </select>
                                        <label for="type">Type <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="md-col-3 col-3  mt-3">
                                    <div class="form-item">
                                        <select name="option_1" id="option"
                                            class="form-control form-control-sm option" onchange="optionChange(event)">
                                            <option value="">Select Option</option>
                                            <option value="Option 1">Option 1</option>
                                            <option value="Option 2">Option 2</option>
                                            <option value="Option 3">Option 3
                                            </option>
                                        </select>
                                        <label for="type">Option <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-3 col-md-3  mt-3">
                                    <div class="form-item">
                                        <select name="existing_infrastructure_1" id="existing_infrastructure"
                                            class="form-control form-control-sm existing_infrastructure">
                                            <option value="">Select Status</option>
                                            <option value="Existing">Existing</option>
                                            <option value="New">New</option>
                                        </select>
                                        <label for="type">Link Status</label>
                                    </div>
                                </div>
                                <div class="col-3 col-md-3 mt-3 link_list" style="display: none;">
                                    <div class="form-item">
                                        <select name="existing_infrastructure_link_1" id="existing_infrastructure_link"
                                            class="form-control form-control-sm existing_infrastructure_link">
                                            <option value="">Select Link</option>
                                        </select>
                                        <label for="type">Link List</label>
                                    </div>
                                </div>
                                <div class="md-col-3 col-3  mt-3">
                                    <div class="form-item">
                                        <input type="text" name="existing_transmission_capacity_1"
                                            id="existing_transmission_capacity"
                                            class="form-control form-control-sm existing_transmission_capacity"
                                            value="">
                                        <label for="type">Existing Transmission Capacity</label>
                                    </div>
                                </div>

                                <div class="md-col-3 col-3 mt-3">
                                    <div class="form-item">
                                        <input type="text" name="increase_capacity_1" id="increase_capacity"
                                            class="form-control form-control-sm increase_capacity" value="">
                                        <label for="type">Increase Capacity</label>
                                    </div>
                                </div>

                                <div class="md-col-3 col-3  mt-3">
                                    <div class="form-item">
                                        <select name="link_availability_status_1" id="link_availability_status"
                                            class="form-control form-control-sm link_availability_status">
                                            <option value="">Select Vendor</option>
                                            {{-- @foreach ($vendors as $vendor)
                                                <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                            @endforeach --}}
                                        </select>
                                        <label for="type">New Transmission Link</label>
                                    </div>
                                </div>

                                <div class="md-col-3 col-3  mt-3">
                                    <div class="form-item">
                                        <input type="text" name="new_transmission_capacity_1"
                                            id="new_transmission_capacity" class="form-control form-control-sm"
                                            value="">
                                        <label for="type">New Transmission Capacity</label>
                                    </div>
                                </div>

                                <div class="md-col-3 col-3  mt-3">
                                    <div class="form-item">
                                        <input type="text" name="link_remarks_1" id="link_remarks"
                                            class="form-control form-control-sm" value="">
                                        <label for="type">Remarks</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <hr />
                                    <h5 class="text-center">Survey Information</h5>
                                    <hr />
                                    <table class="table custom_table table-bordered surveyTable" style="font-size: 12px;">
                                        <tr>
                                            <th>Link Vendor</th>
                                            <td class="link_vendor" style="width:30%">
                                                <input type="text" name="link_vendor_1" id="link_vendor"
                                                    class="form-control form-control-sm link_vendor_1" value=""
                                                    style="height: 25px !important">
                                                <input type="hidden" name="link_vender_id_1" id="link_vendor_id"
                                                    class="form-control form-control-sm link_vender_id_1" value="">
                                            </td>
                                            <th>Connecting POP Running Vendor</th>
                                            <td class="running_vendor_pop" style="width:30%"></td>
                                        </tr>
                                        <tr>
                                            <th>Link Availability Status</th>
                                            <td class="availability_status" style="width:30%">
                                                <input type="text" name="availability_status_1"
                                                    id="availability_status"
                                                    class="form-control form-control-sm availability_status_1"
                                                    style="height: 25px !important" value="">
                                            </td>
                                            <th>Connecting POP Running Vendor Capacity</th>
                                            <td class="running_vendor_capacity" style="width:30%"></td>
                                        </tr>
                                        <tr>
                                            <th>Link Connectivity POP</th>
                                            <td class="link_connecting_pop" style="width:30%">
                                                <input type="text" name="link_connecting_pop_1"
                                                    id="link_connecting_pop"
                                                    class="form-control form-control-sm link_connecting_pop_1"
                                                    style="height: 25px !important" value="">
                                                <input type="hidden" name="link_connecting_pop_id_1"
                                                    id="link_connecting_pop_id" class="link_connecting_pop_id_1">
                                            </td>
                                            <th>Zone Area Running NTTN Vendor</th>
                                            <td class="nttn_vendor_zone" style="width:30%"></td>
                                        </tr>
                                        <tr>
                                            <th>Last Mile Connectivity Method</th>
                                            <td class="last_mile_connectivity_method" style="width:30%">
                                                <input type="text" name="last_mile_connectivity_method_1"
                                                    id="last_mile_connectivity_method"
                                                    class="form-control form-control-sm last_mile_connectivity_method_1"
                                                    style="height: 25px !important" value="">
                                            </td>
                                            <th>Zone Area Running NTTN BW</th>
                                            <td class="running_nttn_bw" style="width:30%"></td>
                                        </tr>
                                        <tr>
                                            <th>Last Connectivity Point Latitute</th>
                                            <td class="connectivity_lat_long" style="width:30%">
                                                <input type="text" name="connectivity_lat_1"
                                                    id="connectivity_lat_long"
                                                    class="form-control form-control-sm connectivity_lat_1"
                                                    style="height: 25px !important" value="">
                                            </td>
                                            <th>Connectivity Route</th>
                                            <td class="connectivity_route" style="width:30%"></td>
                                        </tr>
                                        <tr>
                                            <th>Last Connectivity Point Longitute</th>
                                            <td class="connectivity_lat_long" style="width:30%">
                                                <input type="text" name="connectivity_long_1"
                                                    id="connectivity_lat_long"
                                                    class="form-control form-control-sm connectivity_long_1"
                                                    style="height: 25px !important" value="">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="text-center">
                                    <hr />
                                    <h5> <span> &#10070; </span> Link Equipment <span>&#10070;</span> </h5>
                                </div>
                                <hr />
                                <div class="table-responsive">
                                    <table class="table table-bordered" style="font-size: 12px;">
                                        <thead>
                                            <tr>
                                                <th>Equipment Name</th>
                                                <th>Quantity</th>
                                                <th>Unit</th>
                                                <th>Brand</th>
                                                <th>Model</th>
                                                <th>Description</th>
                                                <th>Remarks</th>
                                                <th>
                                                    <button type="button"
                                                        class="btn btn-success btn-sm addLinkEquipmentRow"
                                                        onclick="addLinkEquipmentRow(this)">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="link_equipment_table">
                                            <tr>
                                                <td>
                                                    <select name="material_id_1[]" id="material_id"
                                                        class="form-control form-control-sm link_material_id">
                                                        <option value="">Select Equipment</option>
                                                        @foreach ($materials as $material)
                                                            <option value="{{ $material->id }}">
                                                                {{ $material->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="quantity_1[]" id="quantity"
                                                        class="form-control form-control-sm link_quantity" value="">
                                                </td>
                                                <td>
                                                    <input type="text" name="unit_1[]" id="unit"
                                                        class="form-control form-control-sm link_unit" value="">
                                                </td>
                                                <td>
                                                    <select name="brand_id_1[]" id="brand"
                                                        class="form-control form-control-sm link_brand">
                                                        <option value="">Select Brand</option>
                                                        @foreach ($brands as $brand)
                                                            <option value="{{ $brand->id }}">
                                                                {{ $brand->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="model_1[]" id="model"
                                                        class="form-control form-control-sm link_model" value="">
                                                </td>
                                                <td>
                                                    <input type="text" name="description_1[]" id="description"
                                                        class="form-control form-control-sm link_description"
                                                        value="">
                                                </td>
                                                <td>
                                                    <input type="text" name="remarks_1[]" id="remarks"
                                                        class="form-control form-control-sm link_remarks" value="">
                                                </td>
                                                <td>
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm removeLinkEquipmentRow"
                                                        onclick="removeLinkEquipmentRow(this)">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <hr />
                            </div>
                        </div> `;
        if ($('#link_container').find('.main_link').length == 0) {
            $('#link_container').append(html);
        } else {
            console.log('link_container is not empty');
        }
    });
</script>
