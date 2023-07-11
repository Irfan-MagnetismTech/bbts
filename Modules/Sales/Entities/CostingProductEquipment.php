<?php

namespace Modules\Sales\Entities;

use Illuminate\Database\Eloquent\Model;

class CostingProductEquipment extends Model
{
    protected $guarded = [];

    public function costing()
    {
        return $this->hasMany(Costing::class, 'id', 'costing_link_id');
    }
}
