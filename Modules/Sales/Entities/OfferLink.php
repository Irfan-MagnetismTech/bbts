<?php

namespace Modules\Sales\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OfferLink extends Model
{
    protected $guarded = [];

    public function offerDetails(): HasMany
    {
        return $this->hasMany(OfferDetail::class, 'offer_details_id', 'id');
    }

    public function offer(): BelongsTo
    {
        return $this->belongsTo(Offer::class, 'id', 'offer_id');
    }
}
