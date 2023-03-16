<?php

namespace Modules\Ticketing\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\User;

class SupportTeamMember extends Model
{
    protected $guarded = [];

    public function supportTeam() {
        return $this->belongsTo(SupportTeam::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
