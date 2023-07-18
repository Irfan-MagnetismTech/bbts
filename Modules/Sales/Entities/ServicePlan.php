<?php

namespace Modules\Sales\Entities;

use Illuminate\Database\Eloquent\Model;


class ServicePlan extends Model
{
    protected $guarded = [];

    public function connectivityProductRequirementDetails()
    {
        return $this->belongsTo(ConnectivityProductRequirementDetail::class, 'connectivity_product_requirement_details_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
