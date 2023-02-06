<?php

namespace Modules\SCM\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\SCM\Entities\ScmRequisition;

class ScmRequisitionDetail extends Model
{
    protected $guarded = [];

    public function scmRequisition(){
        return $this->belongsTo(ScmRequisition::class);
    }
}
