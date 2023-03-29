<?php

namespace Modules\Sales\Entities;

use Illuminate\Database\Eloquent\Model;

class ConnectivityProductRequirementDetail extends Model
{
    protected $guarded = [];

    public function connectivityRequirement()
    {
        return $this->belongsTo(ConnectivityRequirement::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
