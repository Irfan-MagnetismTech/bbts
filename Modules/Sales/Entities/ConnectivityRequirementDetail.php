<?php

namespace Modules\Sales\Entities;

use Illuminate\Database\Eloquent\Model;

class ConnectivityRequirementDetail extends Model
{
    protected $guarded = [];

    public function connectivityRequirement()
    {
        return $this->belongsTo(ConnectivityRequirement::class);
    }
}