<?php

namespace Modules\SCM\Entities;

use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function material_brand():HasMany
    {
        return $this->hasMany(MaterialBrand::class,'material_id','id');
    }

    public function materialBrand(){
        return $this->hasOne(MaterialBrand::class,'material_id');
    }

    public function material_model():HasMany
    {
        return $this->hasMany(MaterialModel::class,'material_id','id');
    }
}
