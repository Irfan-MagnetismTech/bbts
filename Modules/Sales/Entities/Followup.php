<?php

namespace Modules\Sales\Entities;

use Illuminate\Database\Eloquent\Model;

class Followup extends Model
{
    protected $guarded = [];

    public function meeting()
    {
        return $this->hasOne(Meeting::class, 'id', 'meeting_id');
    }

    public function client()
    {
        return $this->hasOne(LeadGeneration::class, 'id', 'client_no');
    }

    public function clientQuestion()
    {
        return $this->hasOne(ClientQuestion::class, 'followup_id', 'id');
    }

    public function tada()
    {
        return $this->hasOne(Tada::class, 'followup_id', 'id');
    }
}
