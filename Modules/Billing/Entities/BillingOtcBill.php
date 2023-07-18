<?php

namespace Modules\Billing\Entities;

use Modules\Sales\Entities\Client;
use Illuminate\Database\Eloquent\Model;
use Modules\Billing\Entities\BillingOtcBillLine;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Sales\Entities\BillingAddress;
use Modules\Sales\Entities\FeasibilityRequirementDetail;
use Modules\Sales\Entities\SaleDetail;

class BillingOtcBill extends Model
{
    protected $guarded = [];

    public function lines(): HasMany
    {
        return $this->hasMany(BillingOtcBillLine::class, 'billing_otc_bill_id', 'id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_no', 'client_no');
    }

    public function saleDetails(): BelongsTo
    {
        return $this->belongsTo(SaleDetail::class, 'fr_no', 'fr_no');
    }

    public function frDetail(): BelongsTo
    {
        return $this->belongsTo(FeasibilityRequirementDetail::class, 'fr_no', 'fr_no');
    }

    public function billingAddress(): BelongsTo
    {
        return $this->belongsTo(FeasibilityRequirementDetail::class, 'fr_no', 'fr_no')->latest();
    }
}
