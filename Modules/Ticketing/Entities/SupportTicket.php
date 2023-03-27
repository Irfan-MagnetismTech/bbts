<?php

namespace Modules\Ticketing\Entities;

use Modules\Admin\Entities\User;
use Illuminate\Database\Eloquent\Model;
use Modules\Sales\Entities\ClientDetail;

class SupportTicket extends Model
{
    protected $guarded = [];

    public function supportComplainType() {
        return $this->belongsTo(SupportComplainType::class);
    }

    public function ticketSource() {
        return $this->belongsTo(TicketSource::class);
    }

    public function createdBy() {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function clientDetail() {
        return $this->belongsTo(ClientDetail::class, 'fr_composit_key', 'id');
    }

    public function supportTicketLifeCycles() {
        return $this->hasMany(SupportTicketLifeCycle::class);
    }
}
