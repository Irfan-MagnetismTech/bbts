<?php

namespace Modules\Sales\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Sales\Entities\ClientDetail;
use Modules\Ticketing\Entities\SupportTicket;

class Client extends Model
{
    protected $guarded = [];

    public function clientDetails(){
        return $this->hasMany(ClientDetail::class);
    }

    public function previousTickets() {
        return $this->hasMany(SupportTicket::class, 'clients_id', 'id');
    }
}
