<?php

namespace Modules\Sales\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\User;

class Meeting extends Model
{
    protected $guarded = [];

    public function client()
    {
        return $this->hasOne(LeadGeneration::class, 'client_no', 'client_no');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class,'created_by', 'id');
    }
}
