<?php

namespace Modules\SCM\Entities;

use Modules\Admin\Entities\Pop;
use Modules\Admin\Entities\User;
use Modules\Admin\Entities\Branch;
use Modules\Sales\Entities\Client;
use Illuminate\Database\Eloquent\Model;
use Modules\SCM\Entities\ScmRequisitionDetail;

class ScmRequisition extends Model
{
    protected $guarded = [];

    public function scmRequisitiondetails(){
        return $this->hasMany(ScmRequisitionDetail::class);
    }

    public function scmRequisitiondetailsWithMaterial(){
        return $this->hasMany(ScmRequisitionDetail::class)->with('material');
    }

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function branch(){
        return $this->belongsTo(Branch::class);
    }

    public function pop(){
        return $this->belongsTo(Pop::class);
    }

    public function requisitionBy(){
        return $this->belongsTo(User::class, 'requisition_by');
    }
}
