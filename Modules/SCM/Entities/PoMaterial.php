<?php

namespace Modules\SCM\Entities;

use Modules\Admin\Entities\Brand;
use Modules\SCM\Entities\Material;
use Illuminate\Database\Eloquent\Model;
use Modules\SCM\Entities\PurchaseOrderLine;

class PoMaterial extends Model
{
    protected $fillable = [
        'po_composite_key',
        'material_id',
        'brand_id',
        'quantity',
        'model',
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

    public function purchaseOrderLines()
    {
        return $this->hasMany(PurchaseOrderLine::class, 'po_composit_key', 'po_composit_key');
    }
}
