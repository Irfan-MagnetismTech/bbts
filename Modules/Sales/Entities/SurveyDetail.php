<?php

namespace Modules\Sales\Entities;

use Illuminate\Database\Eloquent\Model;

class SurveyDetail extends Model
{
    protected $guarded = [];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }
}
