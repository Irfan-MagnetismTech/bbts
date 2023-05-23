<?php

namespace Modules\SCM\Entities;

use Carbon\Carbon;
use Modules\SCM\Entities\ScmWcrLine;
use Modules\SCM\Entities\StockLedger;
use Illuminate\Database\Eloquent\Model;

class ScmWcr extends Model
{
    protected $guarded = [];

    public function lines()
    {
        return $this->hasMany(ScmWcrLine::class, 'scm_wcr_id', 'id');
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
}
