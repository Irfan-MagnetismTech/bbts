<?php

namespace Modules\Billing\Entities;

use Carbon\Carbon;
use Modules\Sales\Entities\Client;
use Illuminate\Database\Eloquent\Model;
use Modules\Billing\Entities\Collection;
use Modules\Sales\Entities\BillingAddress;
use Modules\Billing\Entities\CollectionBill;
use Modules\Billing\Entities\BillGenerateLine;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Sales\Entities\FeasibilityRequirementDetail;
use Modules\SCM\Entities\Supplier;

class BillRegister extends Model
{
    protected $guarded = [];

    public function supplier()
    {
        return $this->hasOne(Supplier::class,'id');
    }
}
