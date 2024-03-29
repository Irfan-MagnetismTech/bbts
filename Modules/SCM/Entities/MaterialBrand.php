<?php

namespace Modules\SCM\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\SCM\Entities\CsMaterial;
use Modules\SCM\Entities\CsSupplier;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\Brand;
use Modules\SCM\Entities\CsMaterialSupplier;

class MaterialBrand extends Model
{
    protected $fillable = ['material_id', 'brand_id'];

    public function materials()
    {
        return $this->belongsTo(Material::class, 'material_id','id');
    }

    public function brands()
    {
        return $this->belongsTo(Brand::class, 'brand_id','id');
    }

//    public function brands(){
//        return $this->belongsToMany(Brand::class,'material_brands','material_id','brand_id');
//    }
}
