<?php

namespace Modules\Networking\Entities;

use Modules\Sales\Entities\Product;
use Illuminate\Database\Eloquent\Model;
use Modules\Networking\Entities\LogicalConnectivity;

class LogicalConnectivityLine extends Model
{
    protected $guarded = [];

    public function logicalConnectivity()
    {
        return $this->belongsTo(LogicalConnectivity::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
