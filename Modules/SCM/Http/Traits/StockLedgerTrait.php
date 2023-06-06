<?php

namespace Modules\SCM\Http\Traits;

use Modules\SCM\Entities\StockLedger;

trait StockLedgerTrait
{

    public function stockable()
    {
        return $this->morphMany(StockLedger::class, 'stockable');
    }

    public function receiveable()
    {
        return $this->morphMany(StockLedger::class, 'receiveable');
    }

    public function isDeleteable()
    {
        return $this->stockable->contains(function ($item) {
            return $item->receiveable()->exists();
        });
    }
}
