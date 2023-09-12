<?php

namespace Modules\SCM\Entities;

use Modules\SCM\Entities\Indent;
use Illuminate\Database\Eloquent\Model;
use Modules\SCM\Entities\ScmPurchaseRequisition;

class IndentLine extends Model
{
    protected $guarded = [];

    public function indent()
    {
        return $this->belongsTo(Indent::class, 'indent_id');
    }

    public function scmPurchaseRequisition()
    {
        return $this->belongsTo(ScmPurchaseRequisition::class, 'scm_purchase_requisition_id');
    }

    // public function scmPurchaseRequisitions()
    // {
    //     return $this->hasMany(ScmPurchaseRequisition::class, 'scm_purchase_requisition_id','id');
    // }
}
