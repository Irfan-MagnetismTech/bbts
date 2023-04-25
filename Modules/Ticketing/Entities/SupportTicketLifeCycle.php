<?php

namespace Modules\Ticketing\Entities;

use Modules\Admin\Entities\User;
use Illuminate\Database\Eloquent\Model;
use Modules\Ticketing\Entities\SupportTicket;

class SupportTicketLifeCycle extends Model
{
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function ticket() {
        return $this->belongsTo(SupportTicket::class, 'support_ticket_id', 'id');
    }
}
