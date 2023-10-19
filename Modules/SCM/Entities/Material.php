<?php

namespace Modules\SCM\Entities;

use Modules\SCM\Entities\Unit;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $guarded = [];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function getMaterialNameWithCodeAttribute()
    {
        return $this->name . '-' . $this->code;
    }

    public function material_brand()
    {
        return $this->belongsTo(MaterialBrand::class,'id','material_id');
    }
}
