<?php

namespace Modules\SCM\Entities;

use Carbon\Carbon;
use Modules\Admin\Entities\Pop;
use Modules\Admin\Entities\Branch;
use Modules\Sales\Entities\Client;
use Modules\SCM\Entities\ScmErrLine;
use Modules\SCM\Entities\StockLedger;
use Illuminate\Database\Eloquent\Model;

class ScmErr extends Model
{
    protected $guarded = [];

    public function getDateAttribute($input)
    {
        $date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $date;
    }

    public function setDateAttribute($input)
    {
        $this->attributes['date'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }

    public function getInactiveDateAttribute($input)
    {
        $date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $date;
    }

    public function setInactiveDateAttribute($input)
    {
        $this->attributes['inactive_date'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }

    public function scmErrLines()
    {
        return $this->hasMany(ScmErrLine::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_no', 'client_no');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function pop()
    {
        return $this->belongsTo(Pop::class);
    }

    public function stockable()
    {
        return $this->morphMany(StockLedger::class, 'stockable');
    }
}
