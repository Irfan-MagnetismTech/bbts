<?php

namespace Modules\Billing\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Billing\Entities\CollectionBill;
use Modules\Billing\Entities\CollectionLine;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Collection extends Model
{
    protected $guarded = [];

    public function lines(): HasMany
    {
        return $this->hasMany(CollectionLine::class, 'collection_id');
    }

    public function collectionLines(): HasMany
    {
        return $this->hasMany(CollectionBill::class, 'collection_id');
    }
}
