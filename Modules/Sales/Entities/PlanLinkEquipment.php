<?php

namespace Modules\Sales\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\SCM\Entities\Material;

class PlanLinkEquipment extends Model
{
    protected $guarded = [];

    public function material()
    {
        return $this->hasOne(Material::class, 'id', 'material_id');
    }
}
