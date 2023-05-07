<?php

namespace Modules\SCM\Entities;

use Modules\SCM\Entities\ScmChallan;
use Illuminate\Database\Eloquent\Model;
use Modules\SCM\Entities\ScmChallanLine;

class ScmGatePassLine extends Model
{
    protected $guarded = [];

    public function challan()
    {
        return $this->belongsTo(ScmChallan::class, 'challan_id', 'id');
    }
    public function mir()
    {
        return $this->belongsTo(ScmMir::class, 'mir_id', 'id');
    }
}
