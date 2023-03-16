<?php

namespace Modules\SCM\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\SCM\Entities\ScmMrrSerialCodeLine;

class ScmMrrLine extends Model
{
    protected $guarded = [];

    public function scmMrrSerialCodeLines()
    {
        return $this->hasMany(ScmMrrSerialCodeLine::class);
    }
}
