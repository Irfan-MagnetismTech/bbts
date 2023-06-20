<?php

namespace Modules\Sales\Entities;

use Modules\Sales\Entities\Client;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_no', 'client_no');
    }

    // public function offerLinks()
    // {
    //     return $this->hasMany(offerLinks::Class, 'client_no', 'client_no');
    // }
}
