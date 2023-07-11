<?php

namespace Modules\Billing\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BillingOtcBill extends Model
{
    protected $guarded = [];

    public function lines(): HasMany
    {
        return $this->hasMany(BillingOtcBillLine::class, 'billing_otc_bill_id', 'id');
    }
}
