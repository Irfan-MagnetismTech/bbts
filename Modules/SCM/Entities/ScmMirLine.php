<?php

namespace Modules\SCM\Entities;

use Modules\SCM\Entities\ScmMrr;
use Illuminate\Database\Eloquent\Model;

class ScmMirLine extends Model
{
    protected $fillable = [
        'scm_mir_id',
        'material_id',
        'serial_code',
        'description',
        'receiveable_id',
        'receiveable_type',
        'brand_id',
        'model',
        'quantity',
        'remarks',
    ];

    public function receiveable()
    {
        return $this->morphTo();
    }
}
