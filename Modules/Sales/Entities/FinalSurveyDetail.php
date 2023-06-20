<?php

namespace Modules\Sales\Entities;

use Illuminate\Database\Eloquent\Model;

class FinalSurveyDetail extends Model
{
    protected $guarded = [];

    public function planLinks()
    {
        return $this->hasOne(PlanLink::class, 'id', 'plan_link_id');
    }
}
