<?php

namespace Modules\SCM\Entities;

use Modules\SCM\Entities\ScmMurLine;
use Illuminate\Database\Eloquent\Model;

class ScmMur extends Model
{
    protected $fillable = [
        'type',
        'purpose',
        'client_id',
        'fr_composite_key',
        'pop_id',
        'branch_id',
        'challan_id',
        'date',
        'mur_no',
        'created_by'
    ];
    public function lines()
    {
        return $this->hasMany(ScmMurLine::class, 'scm_mur_id', 'id');
    }

    public function stockable()
    {
        return $this->morphMany(StockLedger::class, 'stockable');
    }
}
