<?php

namespace Modules\Ticketing\Entities;

use Illuminate\Database\Eloquent\Model;

class SupportTeamMember extends Model
{
    protected $guarded = [];

    public function team() {
        return $this->belongsTo(SupportTeam::class, 'id', 'support_teams_id');
    }
}
