<?php

namespace Modules\SCM\Entities;

use Modules\SCM\Entities\ScmMur;
use Illuminate\Database\Eloquent\Model;

class ScmMurLine extends Model
{
    protected $guarded = [];

    public function scmMur()
    {
        return $this->belongsTo(ScmMur::class);
    }
}
