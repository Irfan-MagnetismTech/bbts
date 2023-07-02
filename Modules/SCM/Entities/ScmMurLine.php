<?php

namespace Modules\SCM\Entities;

use Modules\SCM\Entities\ScmMur;
use Modules\Admin\Entities\Brand;
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

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
