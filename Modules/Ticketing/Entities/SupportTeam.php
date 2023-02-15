<?php

namespace Modules\Ticketing\Entities;

use Modules\Admin\Entities\User;
use App\Models\Dataencoding\Employee;
use App\Models\Dataencoding\Department;
use Illuminate\Database\Eloquent\Model;

class SupportTeam extends Model
{
    protected $guarded = [];

    public function teamMembers() {
        return $this->hasMany(SupportTeamMember::class, 'support_teams_id', 'id');
    }

    public function department() {
        return $this->belongsTo(Department::class, 'departments_id', 'id');
    }

    public function teamLead() {
        return $this->belongsTo(User::class, 'users_id', 'id')->withDefault();
    }
}
