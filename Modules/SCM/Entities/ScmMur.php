<?php

namespace Modules\SCM\Entities;

use Modules\Admin\Entities\Pop;
use Modules\Admin\Entities\Branch;
use Modules\Sales\Entities\Client;
use Modules\SCM\Entities\ScmChallan;
use Modules\SCM\Entities\ScmMurLine;
use Modules\SCM\Entities\StockLedger;
use Illuminate\Database\Eloquent\Model;
use Modules\SCM\Http\Traits\StockLedgerTrait;

class ScmMur extends Model
{
    use StockLedgerTrait;
    protected $fillable = [
        'type',
        'purpose',
        'client_no',
        'fr_no',
        'link_no',
        'pop_id',
        'branch_id',
        'challan_id',
        'date',
        'mur_no',
        'equipment_type',
        'created_by'
    ];
    public function lines()
    {
        return $this->hasMany(ScmMurLine::class, 'scm_mur_id', 'id');
    }

    public function challan()
    {
        return $this->belongsTo(ScmChallan::class, 'challan_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_no', 'client_no');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function pop()
    {
        return $this->belongsTo(Pop::class);
    }
}
