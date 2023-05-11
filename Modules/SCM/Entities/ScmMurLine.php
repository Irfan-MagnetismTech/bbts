<?php

namespace Modules\SCM\Entities;

use Modules\SCM\Entities\ScmMur;
use Modules\SCM\Entities\Material;
use Illuminate\Database\Eloquent\Model;

class ScmMurLine extends Model
{
    protected $guarded = [];

    public function scmMur()
    {
        return $this->belongsTo(ScmMur::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
