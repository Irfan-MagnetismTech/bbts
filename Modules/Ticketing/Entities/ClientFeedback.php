<?php

namespace Modules\Ticketing\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Sales\Entities\ClientDetail;
use Modules\Ticketing\Entities\SupportTicket;

class ClientFeedback extends Model
{
    protected $guarded = [];

    protected $table = 'client_feedbacks';

    public function clientDetail() {
        return $this->belongsTo(ClientDetail::class, 'fr_composite_key', 'fr_composite_key');
    }

    public function supportTicket() {
        return $this->belongsTo(SupportTicket::class);
    }
}
