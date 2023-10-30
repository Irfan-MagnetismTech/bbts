<div id="physical-table" class="md-col-12 col-12" {!! !empty($physicalConnectivity) ? 'style="display:block"' : 'style="display:none"' !!}>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th colspan="7">Existing Link here</th>
                </tr>
                <tr>
                    <th>Link Type</th>
                    <th>Method</th>
                    <th>Vendor</th>
                    <th>BTS/POP</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="connectivityBody">
                @if (!empty($physicalConnectivity))
                    @foreach ($physicalConnectivity->lines as $line)
                        <tr class="connectivity_details_row">
                            <td>
                                <select class="form-control link_type">
                                    <option value="">Select Link Type </option>
                                    <option value="Primary" @selected($line->link_type === 'Primary')>
                                        Primary</option>
                                    <option value="Secondary" @selected($line->link_type === 'Secondary')>
                                        Secondary</option>
                                    <option value="Tertiary" @selected($line->link_type === 'Tertiary')>
                                        Tertiary</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-control method select2">
                                    <option value="">Select Method</option>
                                    <option value="Fiber" @selected($line->method === 'Fiber')>Fiber
                                    </option>
                                    <option value="Radio" @selected($line->method === 'Radio')>Radio
                                    </option>
                                    <option value="GSM" @selected($line->method === 'GSM')>GSM
                                    </option>
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control vendor select2"
                                    value="{{ $line->connectivityLink->vendor->name ?? '' }}">
                            </td>
                            <td>
                                <input type="text" class="form-control bts_pop" value="{{ $line->pop }}">
                            </td>
                            <td>
                                <a href="#" title="Edit"
                                    class="btn btn-sm btn-outline-warning physicalLinkEdit"><i
                                        class="fas fa-pen"></i></a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
