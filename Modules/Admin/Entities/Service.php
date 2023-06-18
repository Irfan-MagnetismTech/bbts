<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\ServiceLine;
use Modules\Admin\Entities\ConnectivityLink;

class Service extends Model
{
    protected $fillable = [
        'reference',
        'bbts_link_id',
        'service_type',
        'service_status',
        'total',
    ];

    public function serviceLines()
    {
        return $this->hasMany(ServiceLine::class);
    }

    public function bbtsLink()
    {
        return $this->belongsTo(ConnectivityLink::class, 'bbts_link_id', 'bbts_link_id');
    }
}
