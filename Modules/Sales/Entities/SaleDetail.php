<?php

namespace Modules\Sales\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Modules\Sales\Entities\SaleLinkDetail;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Sales\Entities\FeasibilityRequirementDetail;

class SaleDetail extends Model
{
    protected $guarded = [];

    /**
     * @param $input
     */
    public function getDeliveryDateAttribute($input)
    {
        return Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y');
    }

    /**
     * @param $input
     */
    public function setDeliveryDateAttribute($input)
    {
        !empty($input) ? $this->attributes['delivery_date'] = Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }

    public function saleLinkDetails()
    {
        return $this->hasMany(SaleLinkDetail::class, 'sale_detail_id', 'id');
    }

    public function frDetails(): BelongsTo
    {
        return $this->belongsTo(FeasibilityRequirementDetail::class, 'fr_no', 'fr_no');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_no', 'client_no');
    }
}
