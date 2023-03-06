<?php

namespace Modules\SCM\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\SCM\Entities\PurchaseOrder;

class PoTermsAndCondition extends Model
{
    protected $fillable = ['purchase_order_id', 'particular'];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }
}
