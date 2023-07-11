<?php

namespace Modules\Networking\Entities;

use Modules\Sales\Entities\Client;
use Illuminate\Database\Eloquent\Model;
use Modules\Networking\Entities\PhysicalConnectivityLines;

class PhysicalConnectivity extends Model
{
    protected $fillable = [
        'fr_no', 'connectivity_point', 'client_no', 'client_name', 'client_type', 'contact_person', 'contact_number', 'email', 'contact_address', 'remarks',
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
