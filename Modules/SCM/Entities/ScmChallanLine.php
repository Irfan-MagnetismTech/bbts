<?php

namespace Modules\SCM\Entities;

use Modules\SCM\Entities\ScmErr;
use Modules\SCM\Entities\ScmMrr;
use Modules\SCM\Entities\ScmWcr;
use Illuminate\Database\Eloquent\Model;

class ScmChallanLine extends Model
{
    protected $guarded = [];

    protected $casts = [
        'receivable_type' => 'string',
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
            default:
                return '';
        }
    }

    public function receiveable()
    {
        return $this->morphTo();
    }
}
