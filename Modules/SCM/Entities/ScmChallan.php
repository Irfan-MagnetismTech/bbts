<?php

namespace Modules\SCM\Entities;

use Carbon\Carbon;
use Modules\Admin\Entities\Pop;
use Modules\Admin\Entities\User;
use Modules\Sales\Entities\BillingAddress;
use Modules\SCM\Entities\ScmMur;
use Modules\Admin\Entities\Branch;
use Modules\Sales\Entities\Client;
use Modules\SCM\Entities\StockLedger;
use Illuminate\Database\Eloquent\Model;
use Modules\Sales\Entities\ClientDetail;
use Modules\Sales\Entities\FeasibilityRequirementDetail;
use Modules\SCM\Entities\ScmChallanLine;
use Modules\SCM\Entities\ScmRequisition;
use Modules\SCM\Http\Traits\StockLedgerTrait;

class ScmChallan extends Model
{
    use StockLedgerTrait;

    protected $guarded = [];

    public function getDateAttribute($input)
    {
        $date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $date;
    }

    public function setDateAttribute($input)
    {
        $this->attributes['date'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }

    public function scmChallanLines()
    {
        return $this->hasMany(ScmChallanLine::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_no', 'client_no');
    }

    public function feasibilityRequirementDetail()
    {
        return $this->belongsTo(FeasibilityRequirementDetail::class, 'fr_no', 'fr_no');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function pop()
    {
        return $this->belongsTo(Pop::class);
    }

    public function scmRequisition()
    {
        return $this->belongsTo(ScmRequisition::class);
    }

    public function clientDetails()
    {
        return $this->belongsTo(ClientDetail::class, 'fr_composite_key', 'fr_composite_key');
    }

    public function mur()
    {
        return $this->hasOne(ScmMur::class, 'challan_id');
    }

    public function challanBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function billingAddress()
    {
        return $this->hasOne(BillingAddress::class, 'client_no', 'client_no');
    }
}
