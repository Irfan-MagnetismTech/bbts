<?php

namespace Modules\Sales\Entities;

use Modules\Sales\Entities\SaleDetail;
use Illuminate\Database\Eloquent\Model;
use Modules\Sales\Entities\ClientDetail;
use Modules\Ticketing\Entities\SupportTicket;

class Client extends Model
{
    protected $guarded = [];

    public function clientDetails()
    {
        return $this->hasMany(ClientDetail::class);
    }

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class, 'client_no', 'client_no');
    }

    public function supportTickets()
    {
        return $this->hasMany(SupportTicket::class);
    }
}
