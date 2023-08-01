<?php

namespace Modules\Sales\Entities;

use Illuminate\Database\Eloquent\Model;

class PlanLink extends Model
{
    protected $guarded = [];

    protected $table = 'plan_links';

    public function planning()
    {
        return $this->belongsTo(Planning::class, 'planning_id', 'id');
    }

    public function PlanLinkEquipments()
    {
        return $this->hasMany(PlanLinkEquipment::class, 'plan_link_id', 'id');
    }

    public function finalSurveyDetails()
    {
        return $this->hasOne(FinalSurveyDetail::class, 'plan_link_id', 'id');
    }
}
