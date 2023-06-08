<?php

namespace Modules\SCM\Entities;

use Modules\SCM\Entities\ScmWor;
use Modules\Admin\Entities\Brand;
use Modules\SCM\Entities\Material;
use Illuminate\Database\Eloquent\Model;

class ScmWorLine extends Model
{
    protected $guarded = [];

    public function wor()
    {
        return $this->belongsTo(ScmWor::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id', 'id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }
}
