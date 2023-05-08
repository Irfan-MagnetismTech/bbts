<?php

namespace Modules\Sales\Entities;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $guarded = [];

    public function surveyDetails()
    {
        return $this->hasMany(SurveyDetail::class);
    }

    public function finalSurveyDetails()
    {
        return $this->hasMany(FinalSurveyDetail::class);
    }

    public function lead_generation()
    {
        return $this->hasOne(LeadGeneration::class, 'client_id', 'client_id');
    }

    public function feasibilityRequirementDetails()
    {
        return $this->hasOne(FeasibilityRequirementDetail::class, 'fr_no', 'fr_no');
    }
}
