<?php

namespace Modules\Sales\Entities;

use Illuminate\Database\Eloquent\Model;

class CostingLink extends Model
{
    protected $guarded = [];

    public function costingLinkEquipments()
    {
        return $this->hasMany(CostingLinkEquipment::class);
    }

    public function finalSurveyDetails()
    {
        return $this->hasOne(FinalSurveyDetail::class, 'link_no', 'link_no');
    }
}
