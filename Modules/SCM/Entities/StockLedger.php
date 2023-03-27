<?php

namespace Modules\SCM\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\SCM\Entities\FiberTracking;

class StockLedger extends Model
{
    protected $guarded = [];

    public function stockable()
    {
        return $this->morphTo();
    }

    public function receivable()
    {
        return $this->morphTo();
    }

    public function fiberTracking()
    {
        return $this->hasMany(FiberTracking::class, 'serial_code', 'serial_code');
    }
}
