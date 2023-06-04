<?php

namespace Modules\SCM\Entities;

use Modules\SCM\Entities\ScmWorLine;
use Illuminate\Database\Eloquent\Model;

class ScmWor extends Model
{
    protected $guarded = [];

    public function lines()
    {
        return $this->hasMany(ScmWorLine::class);
    }
}
