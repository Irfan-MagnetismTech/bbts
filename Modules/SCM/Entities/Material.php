<?php

namespace Modules\SCM\Entities;

use Modules\Admin\Entities\Unit;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $guarded = [];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
