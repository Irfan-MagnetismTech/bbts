<?php

namespace Modules\Sales\Entities;

use Illuminate\Database\Eloquent\Model;

class OfferDetail extends Model
{
    protected $guarded = [];

    protected $fillable = ['offer_id', 'fr_no', 'client_equipment_total', 'total_otc', 'total_roi', 'total_offer_otc', 'grand_total_otc', 'total_offer_mrc', 'product_equipment_price', 'equipment_otc', 'equipment_roi', 'equipment_offer_price', 'equipment_total_otc', 'equipment_total_mrc', 'product_amount', 'offer_product_amount', 'management_cost', 'offer_management_cost', 'grand_total'];

    public function offerLinks()
    {
        return $this->hasMany(OfferLink::class);
    }
}
