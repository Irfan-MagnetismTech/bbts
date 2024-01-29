<?php

namespace Modules\Sales\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\User;

class Planning extends Model
{
    protected $guarded = [];

    public function lead_generation()
    {
        return $this->hasOne(LeadGeneration::class, 'client_no', 'client_no');
    }

    public function client()
    {
        return $this->hasOne(Client::class, 'client_no', 'client_no');
    }

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

    public function finalSurveyDetail()
    {
        return $this->hasOne(FinalSurveyDetail::class, 'planning_id', 'id');
    }

    public function costing()
    {
        return $this->hasOne(Costing::class, 'fr_no', 'fr_no');
    }

    public function ConnectivityRequirement()
    {
        return $this->hasOne(ConnectivityRequirement::class, 'id', 'connectivity_requirement_id');
    }

    public function survey()
    {
        return $this->hasOne(Survey::class, 'fr_no', 'fr_no');
    }

    public function createdBy()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
