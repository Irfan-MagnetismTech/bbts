<?php

namespace Modules\Billing\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Sales\Entities\Client;
use Illuminate\Database\Eloquent\Model;
use Modules\Billing\Entities\Collection;
use Modules\Sales\Entities\BillingAddress;
use Modules\Billing\Entities\CollectionBill;
use Modules\Billing\Entities\BillGenerateLine;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Sales\Entities\FeasibilityRequirementDetail;

class BillGenerate extends Model
{
    protected $guarded = [];

    /**
     * @param $input
     */
//    public function getDateAttribute($input)
//    {
////        return Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y');
//        return !empty($input) ? $this->attributes['date'] = Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
//    }

    /**
     * @param $input
     */
//    public function setDateAttribute($input)
//    {
////         !empty($input) ? $this->attributes['date'] = Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
//    }

    public function lines()
    {
        return $this->hasMany(BillGenerateLine::class, 'bill_generate_id');
    }

    public function linesGroup(string $groupColumn = null): HasMany
    {
        $lines = $this->hasMany(BillGenerateLine::class, 'bill_generate_id');

        if ($groupColumn) {
            $lines->groupBy($groupColumn);
        }

        return $lines;
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_no', 'client_no');
    }

    public function billingAddress(): BelongsTo
    {
        return $this->belongsTo(BillingAddress::class, 'billing_address_id', 'id')->latest();
    }

    public function frDetail(): BelongsTo
    {
        return $this->belongsTo(FeasibilityRequirementDetail::class, 'fr_no', 'fr_no');
    }

    public function collection(): HasMany
    {
        return $this->hasMany(CollectionBill::class, 'bill_no', 'bill_no');
    }

    public function brokenDaysBill(): BelongsTo
    {
        return $this->belongsTo(BrokenDaysBill::class, 'bill_no','bill_no');
    }
}
