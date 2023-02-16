<?php

namespace Modules\Ticketing\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\User;

class SupportTeamMember extends Model
{
    protected $guarded = [];

    public function team() {
        return $this->belongsTo(SupportTeam::class, 'id', 'support_teams_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
}
