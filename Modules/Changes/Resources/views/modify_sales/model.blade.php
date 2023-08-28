<div class="overflow-container" style="width: 100%!important; white-space: nowrap!important;padding: 10px!important;">
    <div class="md-modal md-effect-13" id="modal-13"
        style="width: 100%!important;important;white-space: nowrap!important;padding: 10px!important;">
        <div class="md-content">
            <h3 id="title"></h3>
            <div>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>Client No</td>
                            <td><input type="text" id="client_no_add" name="client_no_add" value="{{ $client_no }}"
                                    class="modal_data form-control form-control-sm" /></td>
                            <input type="hidden" name="client_id" id="client_id" value="{{ $client_id }}"
                                class="modal_data">
                            <input type="hidden" name="update_type" id="update_type" class="modal_data">
                            <input type="hidden" name="fr" id="fr" class="modal_data">
                        </tr>
                        <tr>
                            <td>Contact Person</td>
                            <td>
                                <input type="text" id="contact_person_add" name="contact_person_add"
                                    class="modal_data form-control form-control-sm" />
                            </td>
                        </tr>
                        <tr>
                            <td>Designation</td>
                            <td>
                                <input type="text" id="designation_add" name="designation_add"
                                    class="modal_data form-control form-control-sm" />
                            </td>
                        </tr>
                        <tr>
                            <td>Phone</td>
                            <td>
                                <input type="text" id="phone_add" name="phone_add"
                                    class="modal_data form-control form-control-sm" />
                            </td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>
                                <input type="text" id="email_add" name="email_add"
                                    class="modal_data form-control form-control-sm" />
                            </td>
                        </tr>
                        <tr>
                            <td>Division</td>
                            <td>
                                <div class="input-group input-group-sm input-group-primary">
                                    <select class="form-control form-control-sm modal_data" id="division_id"
                                        name="division_id">
                                        <option value="">Select division</option>
                                        @foreach (@$divisions as $division)
                                            <option value="{{ $division->id }}">
                                                {{ $division->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>District</td>
                            <td>
                                <div class="input-group input-group-sm input-group-primary">
                                    <select class="form-control form-control-sm modal_data" id="district_id"
                                        name="district_id">
                                        <option value="">Select district</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Thana</td>
                            <td>
                                <div class="input-group input-group-sm input-group-primary">
                                    <select class="form-control form-control-sm modal_data" id="thana_id"
                                        name="thana_id">
                                        <option value="">Select thana</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Address</td>0
                            <td>
                                <input type="text" id="address_add" name="address_add"
                                    class="modal_data form-control form-control-sm" />
                            </td>
                        </tr> 
                        <tr>
                            <td>Payment Method</td>
                            <td>
                                <input type="text" id="payment_method_add" name="payment_method_add"
                                    class="modal_data form-control form-control-sm" />
                            </td>
                        </tr>
                        <tr>
                            <td>Payment Date</td>
                            <td>
                                <input type="text" id="payment_date_add" name="payment_date_add"
                                    class="modal_data form-control form-control-sm" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <button type="button" class="btn btn-primary col-2 offset-col-4" onClick="updateAddress()">Add</button>
                <button type="button" class="btn btn-primary col-2" onClick="HideModal()">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="md-overlay"></div>
