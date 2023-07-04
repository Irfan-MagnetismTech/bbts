<?php

namespace Modules\Sales\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\Pop;

class SurveyDetail extends Model
{
    protected $guarded = [];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function vendor()
    {
        return $this->hasOne(Vendor::class, 'id', 'vendor_id');
    }

    public function pop()
    {
        return $this->hasOne(Pop::class, 'id', 'pop_id');
    }
}
