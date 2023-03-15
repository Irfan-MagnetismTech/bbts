<?php

namespace Modules\SCM\Entities;

use Modules\Admin\Entities\Brand;
use Modules\SCM\Entities\Material;
use Illuminate\Database\Eloquent\Model;

class PoMaterial extends Model
{
    protected $fillable = [
        'po_composite_key',
        'material_id',
        'brand_id',
        'quantity',
        'unit_price',
    ];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    
}
