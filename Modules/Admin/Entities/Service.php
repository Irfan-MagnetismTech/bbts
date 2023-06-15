<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\ServiceLine;

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
}
