<?php

namespace Modules\Networking\Entities;

use Illuminate\Database\Eloquent\Model;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;
use Modules\Admin\Entities\ConnectivityLink;

class PhysicalConnectivityLines extends Model
{
    protected $guarded = [];

    public function connectivityLink()
    {
        return $this->belongsTo(ConnectivityLink::class, 'bbts_link_id', 'bbts_link_id');
    }
}
