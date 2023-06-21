<?php

namespace Modules\Sales\Entities;

use Modules\Sales\Entities\Client;
use Modules\Sales\Entities\OfferLink;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Offer extends Model
{
    protected $guarded = [];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_no', 'client_no');
    }

    public function offerLinks(): HasMany
    {
        return $this->hasMany(OfferLink::class, 'offer_id', 'id');
    }
}
