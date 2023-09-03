<?php

namespace Modules\Billing\Entities;

use Illuminate\Database\Eloquent\Model;

class BrokenDaysBill extends Model
{
    protected $guarded = [];

    public function BrokenDaysBillDetails()
    {
        return $this->hasMany(BrokenDaysBillDetail::class, 'broken_days_bill_id', 'id');
    }
}
