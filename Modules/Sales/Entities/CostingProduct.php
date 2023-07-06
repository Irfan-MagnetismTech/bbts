<?php

namespace Modules\Sales\Entities;

use Illuminate\Database\Eloquent\Model;

class CostingProduct extends Model
{
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function saleProduct()
    {
        return $this->belongsTo(SaleProduct::class , 'product_id', 'id');
    }
}
