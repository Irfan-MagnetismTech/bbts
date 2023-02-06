<?php

namespace Modules\SCM\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\SCM\Entities\ScmRequisitionDetail;

class ScmRequisition extends Model
{
    protected $guarded = [];

    public function scmRequisitiondetails(){
        return $this->hasMany(ScmRequisitionDetail::class);
    }

}
