<?php

namespace Modules\Sales\Entities;

use Modules\Sales\Entities\Costing;
use Illuminate\Database\Eloquent\Model;
use Modules\SCM\Entities\Material;

class CostingLinkEquipment extends Model
{
    protected $guarded = [];

    public function costing()
    {
        return $this->hasMany(Costing::class, 'id', 'costing_id');
    }

    public function material()
    {
        return $this->hasOne(Material::class, 'id', 'material_id');
    } 
}
