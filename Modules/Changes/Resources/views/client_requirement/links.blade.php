<div class="row mt-3">
    <div id="physical-table-edit" class="md-col-12 col-12" {!! !empty($mod->connectivityRequirementDetails) ? 'style="display:block"' : 'style="display:none"' !!}>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th colspan="7">New / Update Connectivity Link</th>
                    </tr>
                    <tr>
                        <th>Link Type</th>
                        <th>Method</th>
                        <th>Capacity(%)</th>
                        <th>Uptime Reg/SLA</th>
                        <th>Vendor</th>
                        <th>
                            <button type="button" class="btn btn-sm btn-success addConnectivityEdit"
                                onclick="addConnectivityEdit()"><i class="fas fa-plus"></i></button>
                        </th>
                    </tr>
                </thead>
                <tbody class="connectivityEditBody">
                    @if (!empty($mod->connectivityRequirementDetails))
                        @foreach ($mod->connectivityRequirementDetails as $details)
                            <tr class="connectivity_details_row">
                                <td>
                                    <select name="link_type[]" class="form-control link_type">
                                        <option value="">Select Link Type</option>
                                        <option value="Primary" @selected($details->link_type === 'Primary')>
                                            Primary</option>
                                        <option value="Secondary" @selected($details->link_type === 'Secondary')>
                                            Secondary</option>
                                        <option value="Tertiary" @selected($details->link_type === 'Tertiary')>
                                            Tertiary</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="method[]" class="form-control method">
                                        <option value="">Select Method</option>
                                        <option value="Fiber" @selected($details->method === 'Fiber')>Fiber
                                        </option>
                                        <option value="Radio" @selected($details->method === 'Radio')>Radio
                                        </option>
                                        <option value="GSM" @selected($details->method === 'GSM')>GSM
                                        </option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="connectivity_capacity[]"
                                        class="form-control connectivity_capacity"
                                        value="{{ $details->connectivity_capacity }}">
                                </td>
                                <td>
                                    <input type="text" name="uptime_req[]" class="form-control uptime_req"
                                        value="{{ $details->sla }}">
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
                                    <button type="button" class="btn btn-sm btn-danger removeConnectivityRow"><i
                                            class="fas fa-minus"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
