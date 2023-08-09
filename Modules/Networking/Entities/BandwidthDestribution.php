<?php

namespace Modules\Networking\Entities;

use Modules\Admin\Entities\Ip;
use Illuminate\Database\Eloquent\Model;

class BandwidthDestribution extends Model
{
    protected $guarded = [];

    public function ip()
    {
        return $this->belongsTo(Ip::class)->withDefault([
            'ip' => 'No data found',
            'address' => 'No data found',
        ]);
    }
}
