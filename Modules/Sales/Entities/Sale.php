<?php

namespace Modules\Sales\Entities;

use Carbon\Carbon;
use Modules\Sales\Entities\Client;
use Modules\Sales\Entities\SaleDetail;
use Illuminate\Database\Eloquent\Model;
use Modules\Sales\Entities\OfferDetail;
use Modules\Sales\Entities\SaleLinkDetail;
use Modules\Sales\Entities\SaleProductDetail;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    protected $guarded = [];

    /**
     * @param $input
     */
    public function getEffectiveDateAttribute($input)
    {
        return Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y');
    }

    /**
     * @param $input
     */
    public function setEffectiveDateAttribute($input)
    {
        !empty($input) ? $this->attributes['effective_date'] = Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class, 'sale_id', 'id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_no', 'client_no');
    }

    public function offerDetails(): HasMany
    {
        return $this->hasMany(OfferDetail::class, 'offer_id', 'id');
    }

    public function saleLinkDetails()
    {
        return $this->hasMany(SaleLinkDetail::class, 'sale_id', 'id');
    }

    public function saleProductDetails()
    {
        return $this->hasMany(SaleProductDetail::class, 'sale_id', 'id');
    }

    protected static function booted(): void
    {
        static::deleting(function (Sale $sale) {
            $sale->saleDetails()->delete();
            $sale->saleLinkDetails()->delete();
            $sale->saleProductDetails()->delete();
        });
    }
}
