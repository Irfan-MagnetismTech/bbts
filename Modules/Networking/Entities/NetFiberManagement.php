<?php

namespace Modules\Networking\Entities;

use Illuminate\Database\Eloquent\Model;

class NetFiberManagement extends Model
{
    protected $guarded = [];

    public function getCoreRefIdAttribute()
    {
        return $this->connectivity_point_name . '-' . $this->cable_code . '-' . $this->core_no_color;
    }
}
