<?php

namespace Modules\Sales\Entities;

use Illuminate\Database\Eloquent\Model;

class ClientDetail extends Model
{
    protected $guarded = [];

    public function client() {
        return $this->belongsTo(Client::class);
    }
}
