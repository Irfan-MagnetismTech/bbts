<?php

namespace Modules\Sales\Entities;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $guarded = [];

    public function client()
    {
        return $this->hasOne(LeadGeneration::class, 'client_no', 'client_no');
    }
}
