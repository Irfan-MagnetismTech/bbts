<?php

namespace Modules\SCM\Entities;

use Illuminate\Database\Eloquent\Model;

class ScmMirLine extends Model
{
    protected $fillable = [
        'scm_mir_id',
        'material_id',
        'item_code',
        'description',
        'receiveable_id',
        'receiveable_type',
        'brand_id',
        'model',
        'quantity',
        'remarks',
    ];
}
