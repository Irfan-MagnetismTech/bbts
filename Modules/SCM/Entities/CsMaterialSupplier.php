<?php

namespace Modules\SCM\Entities;

use Modules\SCM\Entities\CsMaterial;
use Modules\SCM\Entities\CsSupplier;
use Illuminate\Database\Eloquent\Model;

class CsMaterialSupplier extends Model
{
    protected $guarded = [];

    public function csMaterial(){
        return $this->belongsTo(CsMaterial::class);
    }

    public function csSupplier(){
        return $this->belongsTo(CsSupplier::class);
    }    
}
