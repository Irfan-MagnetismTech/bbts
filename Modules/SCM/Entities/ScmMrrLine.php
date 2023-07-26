<?php

namespace Modules\SCM\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\Brand;
use Modules\SCM\Entities\ScmMrrSerialCodeLine;

class ScmMrrLine extends Model
{
    protected $guarded = [];

    public function scmMrrSerialCodeLines()
    {
        return $this->hasMany(ScmMrrSerialCodeLine::class);
    }
    public function material()
    {
        return $this->belongsTo(Material::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function scmMrr()
    {
        return $this->belongsTo(ScmMrr::class);
    }
}
