<?php

namespace Modules\Admin\Entities;

use Modules\Admin\Entities\Zone;
use Illuminate\Database\Eloquent\Model;

class Ip extends Model
{
    protected $fillable = ['address', 'type', 'purpose', 'vlan_id', 'zone_id'];

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }
}
