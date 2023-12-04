<?php

namespace Modules\SCM\Entities;

use Modules\SCM\Entities\ScmErr;
use Modules\SCM\Entities\ScmMrr;
use Modules\SCM\Entities\ScmWcr;
use Modules\SCM\Entities\OpeningStock;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\Brand;

class ScmChallanLine extends Model
{
    protected $guarded = [];

    protected $casts = [
        'receiveable_type' => 'string',
    ];

    protected $appends = [
        'received_type',
        'received_no',
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
            case ScmMir::class:
                return 'MIR';
            case OpeningStock::class:
                return 'OS';
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
                return $this->receiveable->err_no;
            case ScmWcr::class:
                return $this->receiveable->wcr_no;
            case OpeningStock::class:
                return $this->receiveable?->id;
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
