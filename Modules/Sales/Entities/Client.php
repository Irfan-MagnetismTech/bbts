<?php

namespace Modules\Sales\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Sales\Entities\ClientDetail;

class Client extends Model
{
    protected $guarded = [];

    public function clientDetails(){
        return $this->hasMany(ClientDetail::class);
    }
}
