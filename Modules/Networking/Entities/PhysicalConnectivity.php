<?php

namespace Modules\Networking\Entities;

use Modules\Sales\Entities\Client;
use Illuminate\Database\Eloquent\Model;
use Modules\Networking\Entities\PhysicalConnectivityLines;

class PhysicalConnectivity extends Model
{
    protected $fillable = [
        'sale_id', 'fr_no', 'connectivity_point', 'client_no', 'remarks',
    ];

    public function lines()
    {
        return $this->hasMany(PhysicalConnectivityLines::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_no', 'client_no');
    }
}
