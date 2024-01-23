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

    public function lead_generation()
    {
        return $this->hasOne(LeadGeneration::class, 'client_no', 'client_no');
    }

    public function feasibilityRequirementDetails()
    {
        return $this->hasOne(FeasibilityRequirementDetail::class, 'fr_no', 'fr_no');
    }

    public function client()
    {
        return $this->belongsTo(Client::class,'client_no', 'client_no');
    }
}
