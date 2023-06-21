<?php

namespace Modules\Sales\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OfferDetail extends Model
{
    protected $guarded = [];

    public function offerLink(): BelongsTo
    {
        return $this->belongsTo(OfferLink::class, 'id', 'offer_details_id');
    }
}
