<?php

namespace Modules\Sales\Entities;

use Modules\Sales\Entities\Product;
use Illuminate\Database\Eloquent\Model;

class CostingProduct extends Model
{
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function saleProduct()
    {
        return $this->belongsTo(SaleProduct::class, 'product_id', 'id');
    }
}
