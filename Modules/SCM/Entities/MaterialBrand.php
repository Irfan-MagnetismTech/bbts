<?php

namespace Modules\SCM\Entities;

use Carbon\Carbon;
use Modules\SCM\Entities\CsMaterial;
use Modules\SCM\Entities\CsSupplier;
use Illuminate\Database\Eloquent\Model;
use Modules\SCM\Entities\CsMaterialSupplier;

class MaterialBrand extends Model
{
    protected $fillable = ['material_id', 'brand'];

    public function materials()
    {
        return $this->belongsTo(Material::class, 'material_id','id');
    }

}