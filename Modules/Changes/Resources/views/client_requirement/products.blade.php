<div class="row mt-3">
    <div id="logical-table" class="md-col-12 col-12" {!! !empty($mod->connectivityProductRequirementDetails) ? 'style="display:block"' : 'style="display:none"' !!}>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th colspan="7">Product Details</th>
                    </tr>
                    <tr>
                        <th>Category</th>
                        <th>Product</th>
                        <th>Prev Quantity</th>
                        <th>Unit</th>
                        <th>Plan</th>
                        <th>Remarks</th>
                        <th>
                            <button type="button" class="btn btn-sm btn-success addProductEdit"
                                onclick="addProductEdit()"><i class="fas fa-plus"></i></button>
                        </th>
                    </tr>
                </thead>
                <tbody class="productBody">
                    @if (!empty($mod->connectivityProductRequirementDetails))
                        @foreach ($mod->connectivityProductRequirementDetails as $product)
                            <tr>
                                <td>
                                    <select name="category[]" class="form-control category">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                @if ($category->id == $product->category_id) selected @endif>
                                                {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="product[]" class="form-control product">
                                        <option value="">Select Product</option>
                                        @foreach ($products as $data)
                                            <option value="{{ $data->id }}"
                                                @if ($data->id == $product->product_id) selected @endif>
                                                {{ $data->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="prev_quantity[]" class="form-control prev_quantity"
                                        value="{{ $product->prev_quantity }}">
                                </td>
                                <td>
                                    <input type="text" name="unit[]" class="form-control unit"
                                        value="{{ $product->product->unit }}">
                                </td>
                                <td>
                                    <input type="text" name="plan[]" class="form-control plan"
                                        value="{{ $product->capacity }}">
                                </td>
                                <td>
                                    <input type="text" name="remarks[]" class="form-control remarks"
                                        value="{{ $product->remarks }}">
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-danger removeProductRow"><i
                                            class="fas fa-minus"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <div id="physical-table" class="md-col-12 col-12" {!! !empty($physicalConnectivity) ? 'style="display:block"' : 'style="display:none"' !!}>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th colspan="7">Existing Link</th>
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
                                        <option value="">Select Link Type</option>
                                        <option value="Primary" @selected($line->link_type === 'Primary')>
                                            Primary</option>
                                        <option value="Secondary" @selected($line->link_type === 'Secondary')>
                                            Secondary</option>
                                        <option value="Tertiary" @selected($line->link_type === 'Tertiary')>
                                            Tertiary</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control method">
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
                                    <input type="text" class="form-control vendor"
                                        value="{{ $line->connectivityLink->vendor->name }}">
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
</div>
