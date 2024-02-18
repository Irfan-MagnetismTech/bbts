<?php

namespace Modules\Sales\Entities;

use Modules\Sales\Entities\Product;
use Illuminate\Database\Eloquent\Model;

class SaleProductDetail extends Model
{
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id', 'id');
    }
}
