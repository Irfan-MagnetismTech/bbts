<?php

namespace Modules\Networking\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Networking\Entities\LogicalConnectivityLine;

class LogicalConnectivity extends Model
{
    protected $fillable = [
        'client_no',
        'fr_no',
        'product_category',
        'shared_type',
        'feasility_type',
        'comment',
    ];

    public function lines()
    {
        return $this->hasMany(LogicalConnectivityLine::class);
    }
}
