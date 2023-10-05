<?php

namespace Modules\Billing\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Sales\Entities\BillingAddress;

class MonthlyBill extends Model
{
    protected $guarded = [];

    public function billingAddress(): BelongsTo
    {
        return $this->belongsTo(BillingAddress::class, 'client_no', 'client_no');
    }
}
