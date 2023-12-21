<?php

namespace Modules\SCM\Entities;

use Modules\Admin\Entities\Brand;
use Modules\SCM\Entities\Material;
use Illuminate\Database\Eloquent\Model;

class ScmWcrLine extends Model
{
    protected $guarded = [];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function wcr()
    {
        return $this->belongsTo(ScmWcr::class);
    }

    public function receivable()
    {
        return $this->belongsTo(ScmErr::class, 'receiveable_id');
    }
}
