<?php

namespace Modules\SCM\Http\Traits;

use Modules\SCM\Entities\StockLedger;

/**
 * Trait StockLedgerTrait
 * @package Modules\SCM\Http\Traits
 *
 * @method \Illuminate\Database\Eloquent\Relations\MorphMany stockable()
 * @method \Illuminate\Database\Eloquent\Relations\MorphMany receiveable()
 * @method bool isDeleteable()
 */
trait StockLedgerTrait
{
    /**
     * Get the stock ledgers associated with the stockable entity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */

    public function stockable()
    {
        return $this->morphMany(StockLedger::class, 'stockable');
    }

    /**
     * Get the stock ledgers associated with the receiveable entity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */

    public function receiveable()
    {
        return $this->morphMany(StockLedger::class, 'receiveable');
    }

    /**
     * Check if the entity can be deleted based on related stock ledgers.
     *
     * @return bool
     */

    public function isDeleteable()
    {
        return $this->stockable->filter(function ($item) {
            return $item->receiveable()->exists();
        })->map(function ($item) {
            return $item->receiveable()->exists();
        })->first();
    }
}
