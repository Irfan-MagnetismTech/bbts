<?php

namespace Modules\Sales\Entities;

use Modules\Admin\Entities\Pop;
use Illuminate\Database\Eloquent\Model;

class FinalSurveyDetail extends Model
{
    protected $guarded = [];

    public function planLinks()
    {
        return $this->hasOne(PlanLink::class, 'id', 'plan_link_id');
    }

    public function pop()
    {
        return $this->hasOne(Pop::class, 'id', 'pop_id');
    }

    public function surveyDetail()
    {
        return $this->belongsTo(SurveyDetail::class, 'survey_detail_id', 'id');
    }
}
