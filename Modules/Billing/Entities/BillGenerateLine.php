<?php

namespace Modules\Billing\Entities;

use Modules\SCM\Entities\Material;
use Illuminate\Database\Eloquent\Model;
use Modules\Sales\Entities\BillingAddress;
use Modules\Billing\Entities\BillingOtcBill;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Sales\Entities\FeasibilityRequirementDetail;

class BillGenerateLine extends Model
{
    protected $guarded = [];

    public function billingOtcBill(): BelongsTo
    {
        return $this->belongsTo(BillingOtcBill::class, 'otc_bill_id', 'id');
    }

    public function billingAddress(): BelongsTo
    {
        return $this->belongsTo(BillingAddress::class, 'child_billing_address_id', 'id')->latest();
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function frDetail(): BelongsTo
    {
        return $this->belongsTo(FeasibilityRequirementDetail::class, 'fr_no', 'fr_no');
    }
}
