<?php

namespace Modules\Sales\Entities;

use Modules\Sales\Entities\PlanLink;
use Illuminate\Database\Eloquent\Model;

class SaleLinkDetail extends Model
{
    protected $guarded = [];

    public function planLinkDetail()
    {
        return $this->belongsTo(PlanLink::class, 'link_no', 'link_no');
    }

    public function finalSurveyDetails()
    {
        return $this->hasOne(FinalSurveyDetail::class, 'link_no', 'link_no');
    }
}
