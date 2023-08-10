<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th colspan="7">Product Details</th>
            </tr>
            <tr>
                <th style="width:25%">Category</th>
                <th style="width:25%">Product</th>
                <th>Prev Quantity</th>
                <th>Unit</th>
                <th>Plan</th>
                <th>Remarks</th>
                <th>
                    <button type="button" class="btn btn-sm btn-success" id="addProductRow"><i
                            class="fas fa-plus"></i></button>
                </th>
            </tr>
        </thead>
        <tbody class="productBody">
            @foreach ($logicalConnectivity->lines as $line)
                <tr>
                    <td>
                        <input type="text" name="product_category[]" class="form-control product_category"
                            value="{{ $line->product_category }}">
                    </td>
                    <td>
                        <input type="text" name="product[]" class="form-control product"
                            value="{{ $line->product->name }}">
                    </td>
                    <td>
                        <input type="text" name="capacity[]" class="form-control capacity"
                            value="{{ $line->quantity }}">
                    </td>
                    <td>
                        <input type="text" name="unit[]" class="form-control unit"
                            value="{{ $line->product->unit }}">
                    </td>
                    <td>
                        <input type="text" name="=plan[]" class="form-control unit" value="=">
                    </td>
                    <td>
                        <input type="text" name="remarks[]" class="form-control remarks"
                            value="{{ $line->remarks }}">
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger removeProductRow"><i
                                class="fas fa-minus"></i></button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
