<?php

namespace Modules\Admin\Entities;

use Modules\Admin\Entities\Branch;
use Illuminate\Database\Eloquent\Model;

class Pop extends Model
{
    protected $guarded = [];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
