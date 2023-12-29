<?php

namespace Modules\Ticketing\Entities;

use Carbon\Carbon;
use Modules\Sales\Entities\Client;
use Illuminate\Database\Eloquent\Model;

class InternalFeedback extends Model
{
    protected $guarded = [];

    protected $table = 'internal_feedbacks';

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_no', 'client_no');
    }
}
