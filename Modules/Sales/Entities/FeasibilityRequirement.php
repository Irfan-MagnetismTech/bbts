<?php

namespace Modules\Sales\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Sales\Entities\FeasibilityRequirementDetail;

class FeasibilityRequirement extends Model
{
    protected $guarded = [];

    public function feasibilityRequirementDetails()
    {
        return $this->hasMany(FeasibilityRequirementDetail::class)->with('division', 'district', 'thana');
    }

    public function lead_generation()
    {
        return $this->hasOne(LeadGeneration::class, 'client_id', 'client_id');
    }

}
