<?php

namespace Modules\SCM\Entities;

use Carbon\Carbon;
use Modules\Admin\Entities\Pop;
use Modules\Admin\Entities\User;
use Modules\Admin\Entities\Branch;
use Modules\Sales\Entities\Client;
use Illuminate\Database\Eloquent\Model;
use Modules\Sales\Entities\ClientDetail;
use Modules\SCM\Entities\ScmRequisitionDetail;

class ScmRequisition extends Model
{
    protected $guarded = [];

    /**
     * @param $input
     */
    public function getDateAttribute($input)
    {
        return Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y');
    }

    /**
     * @param $input
     */
    public function setDateAttribute($input)
    {
        !empty($input) ? $this->attributes['date'] = Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }

    public function scmRequisitiondetails()
    {
        return $this->hasMany(ScmRequisitionDetail::class);
    }

    public function scmRequisitiondetailsWithMaterial()
    {
        return $this->hasMany(ScmRequisitionDetail::class)->with('material', 'brand');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_no', 'client_no');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function pop()
    {
        return $this->belongsTo(Pop::class);
    }

    public function requisitionBy()
    {
        return $this->belongsTo(User::class, 'requisition_by');
    }
}
