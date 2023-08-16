<div class="row mt-4">
    <div class="col-12">
        <div class="checkbox-fade fade-in-primary">
            <label>
                <input type="checkbox" name="change_type[]" id="temporary_inactive"
                    value="Temporary-Inactive" @checked(in_array('Temporary-Inactive', $change_types))>
                <span class="cr">
                    <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                </span>
                <span>Temporary-Inactive</span>
            </label>
        </div>
        <div class="checkbox-fade fade-in-primar  y">
            <label>
                <input type="checkbox" name="change_type[]" value="Permanent-Inactive"
                    @checked(in_array('Temporary-Inactive', $change_types))>
                <span class="cr">
                    <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                </span>
                <span>Permanent Inactive</span>
            </label>
        </div>
        <div class="checkbox-fade fade-in-primary">
            <label>
                <input type="checkbox" name="change_type[]" value="Re-Inactive"
                    @checked(in_array('Re-Inactive', $change_types))>
                <span class="cr">
                    <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                </span>
                <span>Re-Inactive</span>
            </label>
        </div>
        <div class="checkbox-fade fade-in-primary">
            <label>
                <input type="checkbox" name="change_type[]" value="B/W Increase/Decrease"
                    @checked(in_array('B/W Increase/Decrease', $change_types))>
                <span class="cr">
                    <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                </span>
                <span>B/W Increase/Decrease</span>
            </label>
        </div>
        <div class="checkbox-fade fade-in-primary">
            <label>
                <input type="checkbox" name="change_type[]" value="IP Increase/Decrease"
                    @checked(in_array('IP Increase/Decrease', $change_types))>
                <span class="cr">
                    <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                </span>
                <span>IP Increase/Decrease</span>
            </label>
        </div>
        <div class="checkbox-fade fade-in-primary">
            <label>
                <input type="checkbox" name="change_type[]" id="mrc_decrease" value="MRC-Decrease"
                    @checked(in_array('MRC-Decrease', $change_types))>
                <span class="cr">
                    <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                </span>
                <span>MRC Decrease</span>
            </label>
        </div>
        <div class="checkbox-fade fade-in-primary">
            <label>
                <input type="checkbox" name="change_type[]"
                    value="Price Increase/Decrease with BW Change" @checked(in_array('Price Increase/Decrease with BW Change', $change_types))>
                <span class="cr">
                    <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                </span>
                <span>Price Increase/Decrease with BW Change</span>
            </label>
        </div>
        <div class="checkbox-fade fade-in-primary">
            <label>
                <input type="checkbox" name="change_type[]" value="Method Change"
                    @checked(in_array('Method Change', $change_types))>
                <span class="cr">
                    <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                </span>
                <span>Method Change</span>
            </label>
        </div>
        <div class="checkbox-fade fade-in-primary">
            <label>
                <input type="checkbox" name="change_type[]" value="Redundant Link"
                    @checked(in_array('Redundant Link', $change_types))>
                <span class="cr">
                    <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                </span>
                <span>Redundant Link</span>
            </label>
        </div>
        <div class="checkbox-fade fade-in-primary">
            <label>
                <input type="checkbox" name="change_type[]" value="Shifting"
                    @checked(in_array('Shifting', $change_types))>
                <span class="cr">
                    <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                </span>
                <span>Shifting</span>
            </label>
        </div>
    </div>
</div>