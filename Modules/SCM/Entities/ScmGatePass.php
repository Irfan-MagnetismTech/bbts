<?php

namespace Modules\SCM\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Modules\SCM\Entities\ScmGatePassLine;

class ScmGatePass extends Model
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

    public function lines()
    {
        return $this->hasMany(ScmGatePassLine::class);
    }
}
