<?php

namespace Modules\Billing\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollectionBill extends Model
{
    protected $guarded = [];

    public function billGenerate(): BelongsTo
    {
        return $this->belongsTo(BillGenerate::class, 'bill_no', 'bill_no');
    }
}
