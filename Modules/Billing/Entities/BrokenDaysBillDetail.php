<?php

namespace Modules\Billing\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Sales\Entities\FeasibilityRequirementDetail;
use Modules\Sales\Entities\Product;
use Modules\SCM\Entities\Material;

class BrokenDaysBillDetail extends Model
{
    protected $guarded = [];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
