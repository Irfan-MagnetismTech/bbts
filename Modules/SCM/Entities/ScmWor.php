<?php

namespace Modules\SCM\Entities;

use Carbon\Carbon;
use Modules\Admin\Entities\User;
use Modules\Admin\Entities\Branch;
use Modules\SCM\Entities\Supplier;
use Modules\SCM\Entities\ScmWorLine;
use Modules\SCM\Entities\StockLedger;
use Illuminate\Database\Eloquent\Model;
use Modules\SCM\Entities\PurchaseOrder;

class ScmWor extends Model
{
    protected $fillable = [
        'wor_no', 'supplier_id', 'purchase_order_id', 'date', 'branch_id', 'status', 'created_by'
    ];

    public function getDateAttribute($input)
    {
        $date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $date;
    }

    public function setDateAttribute($input)
    {
        $this->attributes['date'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }

    public function lines()
    {
        return $this->hasMany(ScmWorLine::class, 'scm_wor_id', 'id');
    }

    public function stockable()
    {
        return $this->morphMany(StockLedger::class, 'stockable');
    }

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
