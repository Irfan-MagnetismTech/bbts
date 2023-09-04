<?php

namespace Modules\Billing\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Sales\Entities\SaleProductDetail;

class BrokenDaysBill extends Model
{
    protected $guarded = [];

    public function saleProductDetails()
    {
        return $this->hasMany(SaleProductDetail::class, 'sale_detail_id', 'id');
    }
}
