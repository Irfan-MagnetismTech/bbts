<?php

namespace Modules\Sales\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\SCM\Entities\Material;

class CostingProductEquipment extends Model
{
    protected $guarded = [];

    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id', 'id');
    }
}
