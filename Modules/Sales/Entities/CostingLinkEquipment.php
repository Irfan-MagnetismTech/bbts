<?php

namespace Modules\Sales\Entities;

use Modules\Sales\Entities\Costing;
use Illuminate\Database\Eloquent\Model;

class CostingLinkEquipment extends Model
{
    protected $guarded = [];

    public function costing()
    {
        return $this->hasMany(Costing::class, 'id', 'costing_link_id');
    }
}
