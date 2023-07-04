<?php

namespace Modules\Sales\Entities;

use Modules\Sales\Entities\Costing;
use Modules\Sales\Entities\OfferLink;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OfferDetail extends Model
{
    protected $guarded = [];

    protected $fillable = ['offer_id', 'fr_no', 'client_equipment_total', 'total_otc', 'total_roi', 'total_offer_otc', 'grand_total_otc', 'total_offer_mrc', 'product_equipment_price', 'equipment_otc', 'equipment_roi', 'equipment_offer_price', 'equipment_total_otc', 'equipment_total_mrc', 'product_amount', 'offer_product_amount', 'management_cost', 'offer_management_cost', 'grand_total'];


    public function offerLinks()
    {
        return $this->hasMany(OfferLink::class, 'offer_detail_id', 'id');
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
