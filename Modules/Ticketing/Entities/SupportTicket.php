<?php

namespace Modules\Ticketing\Entities;

use Modules\Admin\Entities\User;
use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    protected $guarded = [];

    public function complainType() {
        return $this->belongsTo(SupportComplainType::class, 'complain_types_id');
    }

    public function ticketSource() {
        return $this->belongsTo(TicketSource::class, 'sources_id');
    }

    public function createdBy() {
        return $this->belongsTo(User::class, 'created_by');
    }
}
