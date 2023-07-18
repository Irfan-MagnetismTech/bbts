<?php

namespace Modules\Ticketing\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Sales\Entities\Client;
use Modules\Sales\Entities\ClientDetail;
use Modules\Ticketing\Entities\SupportTicket;

class ClientFeedback extends Model
{
    protected $guarded = [];

    protected $table = 'client_feedbacks';

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_no', 'client_no');
    }

    public function supportTicket()
    {
        return $this->belongsTo(SupportTicket::class);
    }
}
