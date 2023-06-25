<?php

namespace Modules\Sales\Entities;

use Modules\Sales\Entities\Client;
use Modules\Sales\Entities\Costing;
use Modules\Sales\Entities\OfferLink;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    public function offerDetails(): HasMany
    {
        return $this->hasMany(OfferDetail::class, 'offer_id', 'id');
    }

    public function costing(): BelongsTo
    {
        return $this->belongsTo(Costing::class, 'mq_no', 'mq_no');
    }
}
