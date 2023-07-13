<?php

namespace Modules\Networking\Entities;

use Modules\Sales\Entities\Product;
use Illuminate\Database\Eloquent\Model;
use Modules\Networking\Entities\LogicalConnectivity;

class LogicalConnectivityLine extends Model
{
    protected $fillable = [
        'logical_connectivity_id',
        'product_category',
        'product_id',
        'quantity',
        'ip_ipv4',
        'ip_ipv6',
        'subnetmask',
        'gateway',
        'vlan',
        'mrtg_user',
        'mrtg_pass',
        'remarks',
    ];

    public function logicalConnectivity()
    {
        return $this->belongsTo(LogicalConnectivity::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
