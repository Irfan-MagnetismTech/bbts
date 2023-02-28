<?php

namespace Modules\Ticketing\Entities;

use Modules\Admin\Entities\User;
use App\Models\Dataencoding\Employee;
use App\Models\Dataencoding\Department;
use Illuminate\Database\Eloquent\Model;

class SupportTeam extends Model
{
    protected $guarded = [];

    public function supportTeamMember() {
        return $this->hasMany(SupportTeamMember::class);
    }

    public function department() {
        return $this->belongsTo(Department::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
