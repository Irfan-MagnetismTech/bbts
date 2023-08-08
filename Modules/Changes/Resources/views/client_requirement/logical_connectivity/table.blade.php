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
                    Action
                </th>
            </tr>
        </thead>
        <tbody class="productBody">
            @foreach ($logicalConnectivity->lines as $line)
                <tr class="product_details_row">
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
                        <input type="text" name="plan[]" class="form-control unit" value="">
                    </td>
                    <td>
                        <input type="text" name="remarks[]" class="form-control remarks"
                            value="{{ $line->remarks }}">
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-success" id="addProdRow"><i
                                class="fas fa-plus"></i></button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script>
    $('#addProductRow').on('click', function() {
        alert('fine')
        addProductRow();
    });

    function addProductRow() {
        $('.product_details_row').first().clone().appendTo('.productBody');
        $('.product_details_row').last().find('input').val('');
        $('.product_details_row').last().find('select').val('');
    };
</script>
