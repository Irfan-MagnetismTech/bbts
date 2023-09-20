<?php

namespace Modules\SCM\Entities;

use Modules\SCM\Entities\CsMaterial;
use Modules\SCM\Entities\CsSupplier;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\Brand;

class CsMaterialSupplier extends Model
{
    protected $guarded = [];

    public function csMaterial()
    {
        return $this->belongsTo(CsMaterial::class);
    }

    public function csSupplier()
    {
        return $this->belongsTo(CsSupplier::class);
    }

    public function brand()
    {
        return $this->hasOne(Brand::class, 'id', 'brand_id');
    }
}
