<?php

namespace Modules\Sales\Entities;

use Modules\Sales\Entities\Costing;
use Modules\Sales\Entities\OfferLink;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OfferDetail extends Model
{
    protected $guarded = [];

    public function offerLink(): BelongsTo
    {
        return $this->belongsTo(OfferLink::class, 'id', 'offer_details_id');
    }


    public function costing(): BelongsTo
    {
        return $this->belongsTo(Costing::class, 'fr_no', 'fr_no');
    }

    public function frDetails(): BelongsTo
    {
        return $this->belongsTo(FeasibilityRequirementDetail::class, 'fr_no', 'fr_no');
    }
}
