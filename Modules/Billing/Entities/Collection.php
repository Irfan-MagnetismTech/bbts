<?php

namespace Modules\Billing\Entities;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Sales\Entities\Client;
use Illuminate\Database\Eloquent\Model;
use Modules\Billing\Entities\CollectionBill;
use Modules\Billing\Entities\CollectionLine;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Collection extends Model
{
    protected $guarded = [];

    public function lines(): HasMany
    {
        return $this->hasMany(CollectionLine::class, 'collection_id');
    }

    public function collectionBills(): HasMany
    {
        return $this->hasMany(CollectionBill::class, 'collection_id');
    }
    public function getTotalAmountAttribute()
    {
        return $this->collectionBills->sum('amount');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_no', 'client_no');
    }

    public function collectionLines(): HasMany
    {
        return $this->hasMany(CollectionLine::class, 'collection_id');
    }
}
