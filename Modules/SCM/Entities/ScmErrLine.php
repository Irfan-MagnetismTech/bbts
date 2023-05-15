<?php

namespace Modules\SCM\Entities;

use Modules\SCM\Entities\ScmErr;
use Modules\SCM\Entities\Material;
use Illuminate\Database\Eloquent\Model;

class ScmErrLine extends Model
{
    protected $guarded = [];

    public function scmErr()
    {
        return $this->belongsTo(ScmErr::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
