<?php

namespace Modules\SCM\Entities;

use Modules\SCM\Entities\ScmMrr;
use Modules\SCM\Entities\Material;
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

    public function getReceivedTypeAttribute()
    {
        switch ($this->receiveable_type) {
            case ScmMrr::class:
                return 'MRR';
            case ScmErr::class:
                return 'ERR';
            case ScmWcr::class:
                return 'WCR';
            case ScmWor::class:
                return 'WOR';
            default:
                return '';
        }
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
