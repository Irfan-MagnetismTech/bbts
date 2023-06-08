<?php

namespace Modules\SCM\Entities;

use Modules\SCM\Entities\ScmErr;
use Modules\SCM\Entities\ScmMrr;
use Modules\SCM\Entities\ScmWcr;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\Brand;

class ScmChallanLine extends Model
{
    protected $guarded = [];

    protected $casts = [
        'receiveable_type' => 'string',
    ];

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

    public function getReceivedNoAttribute()
    {
        switch ($this->receiveable_type) {
            case ScmMrr::class:
                return $this->receiveable->mrr_no;
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

    public function receiveable()
    {
        return $this->morphTo();
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
