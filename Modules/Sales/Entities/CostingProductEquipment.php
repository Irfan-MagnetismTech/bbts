<?php

namespace Modules\Sales\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\SCM\Entities\Material;

class CostingProductEquipment extends Model
{
    protected $guarded = [];

    protected $table = 'costing_product_equipments';

    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id', 'id');
    }
    public function costing()
    {
        return $this->hasMany(Costing::class, 'id', 'costing_id');
    }
}
