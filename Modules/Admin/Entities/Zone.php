<?php

namespace Modules\Admin\Entities;

use Modules\Admin\Entities\ZoneLine;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    protected $fillable = ['name'];

    public function zoneLines()
    {
        return $this->hasMany(ZoneLine::class);
    }
}
