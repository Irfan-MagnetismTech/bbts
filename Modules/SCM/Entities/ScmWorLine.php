<?php

namespace Modules\SCM\Entities;

use Modules\SCM\Entities\ScmWor;
use Illuminate\Database\Eloquent\Model;

class ScmWorLine extends Model
{
    protected $guarded = [];

    public function wor()
    {
        return $this->belongsTo(ScmWor::class);
    }
}
