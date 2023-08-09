<?php

namespace Modules\Sales\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Sales\Entities\ConnectivityRequirementDetail;
use Modules\Sales\Entities\ConnectivityProductRequirementDetail;
use Modules\Sales\Entities\LeadGeneration;
use Modules\Sales\Entities\FeasibilityRequirement;
use Modules\Sales\Entities\FeasibilityRequirementDetail;

class ConnectivityRequirement extends Model
{
    protected $guarded = [];

    public function connectivityRequirementDetails()
    {
        return $this->hasMany(ConnectivityRequirementDetail::class);
    }

    public function connectivityProductRequirementDetails()
    {
        return $this->hasMany(ConnectivityProductRequirementDetail::class);
    }

    public function lead_generation()
    {
        return $this->belongsTo(LeadGeneration::class, 'client_no', 'client_no');
    }

    public function FeasibilityRequirementDetail()
    {
        return $this->belongsTo(FeasibilityRequirementDetail::class, 'fr_no', 'fr_no');
    }

    public function fromLocation()
    {
        return $this->belongsTo(FeasibilityRequirementDetail::class, 'from_location', 'id');
    }

    public function scopeUnmodified($query)
    {
        return $query->where('is_modified', 0);
    }

    public function scopeModified($query)
    {
        return $query->where('is_modified', 1);
    }
}
