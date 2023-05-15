<?php

namespace Modules\SCM\Entities;

use Carbon\Carbon;
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

    public function scmErrLines()
    {
        return $this->hasMany(ScmErrLine::class);
    }
}
