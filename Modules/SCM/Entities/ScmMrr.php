<?php

namespace Modules\SCM\Entities;

use Carbon\Carbon;
use Modules\Admin\Entities\User;
use Modules\Admin\Entities\Branch;
use Modules\SCM\Entities\Supplier;
use Modules\SCM\Entities\ScmMrrLine;
use Modules\SCM\Entities\StockLedger;
use Illuminate\Database\Eloquent\Model;
use Modules\SCM\Entities\PurchaseOrder;
use Modules\SCM\Http\Traits\StockLedgerTrait;

class ScmMrr extends Model
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

    public function getChallanDateAttribute($input)
    {
        $date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $date;
    }

    public function setChallanDateAttribute($input)
    {
        $this->attributes['challan_date'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }
    public function scmMrrLines()
    {
        return $this->hasMany(ScmMrrLine::class);
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
}
