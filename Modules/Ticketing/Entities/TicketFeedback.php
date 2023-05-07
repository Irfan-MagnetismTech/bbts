<?php

namespace Modules\Ticketing\Entities;

use Illuminate\Database\Eloquent\Model;

class TicketFeedback extends Model
{
    protected $guarded = [];

    public function feedbacks() {
        return $this->morphTo();
    }
}
