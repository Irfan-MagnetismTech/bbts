<?php

namespace Modules\SCM\Entities;

use Illuminate\Database\Eloquent\Model;

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
}
