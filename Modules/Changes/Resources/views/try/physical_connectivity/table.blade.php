<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th colspan="7">Existing Link</th>
            </tr>
            <tr>
                <th style="width:15%">Link Type</th>
                <th style="width:25%">Link Status</th>
                <th>Method</th>
                <th>Vendor</th>
                <th>BTS/POP</th>
                <th>Distance</th>
                <th>
                    <button type="button" class="btn btn-sm btn-success" id="addConnectivityRow"><i
                            class="fas fa-plus"></i></button>
                </th>
            </tr>
        </thead>
        <tbody class="connectivityBody">
            @foreach ($physicalConnectivity->lines as $line)
                <tr>
                    <td>
                        <input type="text" name="link_type[]" class="form-control link_type"
                            value="{{ $line->link_type }}">
                    </td>
                    <td>
                        <input type="text" name="link_status[]" class="form-control link_status"
                            value="{{ $line->link_status }}">
                    </td>
                    <td>
                        <input type="text" name="method[]" class="form-control method" value="{{ $line->method }}">
                    </td>
                    <td>
                        <input type="text" name="vendor[]" class="form-control vendor" value="{{ $line->vendor }}">
                    </td>
                    <td>
                        <input type="text" name="bts_pop[]" class="form-control bts_pop" value="{{ $line->pop }}">
                    </td>
                    <td>
                        <input type="text" name="distance[]" class="form-control distance"
                            value="{{ $line->distance }}">
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger removeConnectivityRow"><i
                                class="fas fa-minus"></i></button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
