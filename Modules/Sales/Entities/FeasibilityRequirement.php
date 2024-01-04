<?php

namespace Modules\Sales\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Sales\Entities\FeasibilityRequirementDetail;

class FeasibilityRequirement extends Model
{
    protected $guarded = [];
    // protected $fillable = ['client_no', 'is_existing', 'date', 'lead_generation_id', 'user_id', 'branch_id', 'is_modified'];

    public function feasibilityRequirementDetails()
    {
        return $this->hasMany(FeasibilityRequirementDetail::class, 'feasibility_requirement_id', 'id')->with('division', 'district', 'thana');
    }

    public function lead_generation()
    {
        return $this->hasOne(LeadGeneration::class, 'client_no', 'client_no');
    }

    public function offer()
    {
        return $this->hasOne(Offer::class, 'mq_no', 'mq_no');
    }

    public function client(){
        return $this->belongsTo(Client::class, 'client_no', 'client_no');
    }
}
