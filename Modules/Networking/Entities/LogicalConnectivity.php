<?php

namespace Modules\Networking\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Networking\Entities\ClientFacility;
use Modules\Networking\Entities\BandwidthDestribution;
use Modules\Networking\Entities\LogicalConnectivityLine;
use Modules\Sales\Entities\Client;

class LogicalConnectivity extends Model
{
    protected $fillable = [
        'sale_id',
        'client_no',
        'fr_no',
        'product_category',
        'shared_type',
        'facility_type',
        'comment',
    ];

    public function lines()
    {
        return $this->hasMany(LogicalConnectivityLine::class);
    }

    public function bandwidths()
    {
        return $this->hasMany(BandwidthDestribution::class);
    }

    public function clientFacility()
    {
        return $this->hasOne(ClientFacility::class);
    }

    public function scopeForProductCategories($query, array $categories)
    {
        return $query->whereIn('product_category', $categories);
    }
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_no', 'client_no');
    }
}
