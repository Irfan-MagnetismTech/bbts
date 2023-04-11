<?php

namespace Modules\SCM\Entities;

use Carbon\Carbon;
use Modules\Admin\Entities\User;
use Modules\Admin\Entities\Branch;
use Modules\SCM\Entities\ScmMirLine;
use Modules\SCM\Entities\StockLedger;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\Pop;

class ScmMir extends Model
{
    protected $fillable = [
        'mir_no',
        'scm_requisition_id',
        'date',
        'to_branch_id',
        'pop_id',
        'courier_id',
        'courier_serial_no',
        'created_by',
        'branch_id'
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
        return $this->hasMany(ScmMirLine::class);
    }

    public function toBranch()
    {
        return $this->belongsTo(Branch::class, 'to_branch_id')->withDefault();
    }

    public function fromBranch()
    {
        return $this->belongsTo(Branch::class, 'branch_id')->withDefault();
    }

    public function pop()
    {
        return $this->belongsTo(Pop::class, 'pop_id')->withDefault();
    }

    public function courier()
    {
        return $this->belongsTo(Courier::class, 'courier_id')->withDefault();
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }

    public function scmRequisition()
    {
        return $this->belongsTo(ScmRequisition::class, 'scm_requisition_id')->withDefault();
    }

    public function stockable()
    {
        return $this->morphMany(StockLedger::class, 'stockable');
    }
}
