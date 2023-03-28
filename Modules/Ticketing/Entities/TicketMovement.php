<?php

namespace Modules\Ticketing\Entities;

use Modules\Admin\Entities\User;
use Illuminate\Database\Eloquent\Model;

class TicketMovement extends Model
{
    protected $guarded = [];

    public function supportTicket() {
        return $this->belongsTo(SupportTicket::class);
    }

    public function user() {
        return $this->belongsTo(User::class, 'movement_by');
    }

    public function acceptedBy() {
        return $this->belongsTo(User::class, 'accepted_by');
    }
}
