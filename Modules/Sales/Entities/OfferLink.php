<?php

namespace Modules\Sales\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OfferLink extends Model
{
    protected $guarded = [];

    protected $fillable = ['offer_id', 'offer_details_id', 'link_id', 'link_type', 'option', 'connectivity_status', 'method', 'vendor', 'bts_pop_ldp', 'distance', 'client_equipment_amount', 'otc', 'mo_cost', 'offer_otc', 'total_cost', 'offer_mrc'];

    public function offerDetails(): HasMany
    {
        return $this->hasMany(OfferDetail::class, 'offer_details_id', 'id');
    }

    public function offer(): BelongsTo
    {
        return $this->belongsTo(Offer::class, 'id', 'offer_id');
    }
}
