<?php

namespace Modules\Billing\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Sales\Entities\Client;
use Modules\Sales\Entities\SaleProductDetail;

class BrokenDaysBill extends Model
{
    protected $guarded = [];

    public function BrokenDaysBillDetails()
    {
        return $this->hasMany(BrokenDaysBillDetail::class, 'broken_days_bill_id', 'id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_no', 'client_no');
    }
}
