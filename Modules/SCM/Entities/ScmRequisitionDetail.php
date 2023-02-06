<?php

namespace Modules\SCM\Entities;

use Modules\SCM\Entities\Material;
use Illuminate\Database\Eloquent\Model;
use Modules\SCM\Entities\ScmRequisition;

class ScmRequisitionDetail extends Model
{
    protected $guarded = [];

    public function scmRequisition(){
        return $this->belongsTo(ScmRequisition::class);
    }

    public function material(){
        return $this->belongsTo(Material::class);
    }
}
