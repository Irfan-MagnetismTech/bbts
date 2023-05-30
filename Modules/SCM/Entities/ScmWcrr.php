<?php

namespace Modules\SCM\Entities;

use Carbon\Carbon;
use Modules\Admin\Entities\Branch;
use Modules\SCM\Entities\ScmWcrrLine;
use Modules\SCM\Entities\StockLedger;
use Illuminate\Database\Eloquent\Model;

class ScmWcrr extends Model
{
    protected $guarded = [];

    public function lines()
    {
        return $this->hasMany(ScmWcrrLine::class, 'scm_wcrr_id', 'id');
    }
    public function getDateAttribute($input)
    {
        $date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $date;
    }

    public function setDateAttribute($input)
    {
        $this->attributes['date'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }

    public function stockable()
    {
        return $this->morphMany(StockLedger::class, 'stockable');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function wcr()
    {
        return $this->belongsTo(ScmWcr::class, 'wcr_id', 'id');
    }
}
