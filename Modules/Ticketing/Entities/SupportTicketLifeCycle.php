<?php

namespace Modules\Ticketing\Entities;

use Modules\Admin\Entities\User;
use Illuminate\Database\Eloquent\Model;

class SupportTicketLifeCycle extends Model
{
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
