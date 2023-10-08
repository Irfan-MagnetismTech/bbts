<?php

namespace Modules\Sales\Entities;

use Modules\Admin\Entities\Pop;
use Modules\Sales\Entities\PlanLink;
use Illuminate\Database\Eloquent\Model;
use Modules\Sales\Entities\SurveyDetail;

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

    public function vendor()
    {
        return $this->hasOne(Vendor::class, 'id', 'vendor_id');
    }
}
