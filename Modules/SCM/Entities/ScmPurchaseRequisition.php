<?php

namespace Modules\SCM\Entities;

use Carbon\Carbon;
use Modules\Admin\Entities\User;
use Modules\Admin\Entities\Branch;
use Modules\Sales\Entities\Client;
use Illuminate\Database\Eloquent\Model;
use Modules\Sales\Entities\ClientDetail;
use Modules\SCM\Entities\ScmPurchaseRequisitionDetails;

class ScmPurchaseRequisition extends Model
{
    protected $fillable = [
        'prs_no',
        'prs_type',
        'type',
        'date',
        'client_no',
        'fr_no',
        'link_no',
        'assessment_no',
        'requisition_by',
        'branch_id',
    ];
    
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

    public function requisitionBy()
    {
        return $this->belongsTo(User::class, 'requisition_by');
    }

    public function scmPurchaseRequisitionDetails()
    {
        return $this->hasMany(ScmPurchaseRequisitionDetails::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_no', 'client_no');
    }
}
