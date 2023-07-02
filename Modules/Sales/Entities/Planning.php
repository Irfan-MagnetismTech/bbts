<?php

namespace Modules\Sales\Entities;

use Illuminate\Database\Eloquent\Model;

class Planning extends Model
{
    protected $guarded = [];

    public function feasibilityRequirementDetail()
    {
        return $this->hasOne(FeasibilityRequirementDetail::class, 'fr_no', 'fr_no');
    }

    public function equipmentPlans()
    {
        return $this->hasMany(EquipmentPlan::class, 'planning_id', 'id');
    }

    public function servicePlans()
    {
        return $this->hasMany(ServicePlan::class, 'planning_id', 'id');
    }

    public function planLinks()
    {
        return $this->hasMany(PlanLink::class, 'planning_id', 'id');
    }


    public function finalSurveyDetails()
    {
        return $this->hasMany(FinalSurveyDetail::class, 'planning_id', 'id');
    }
}
