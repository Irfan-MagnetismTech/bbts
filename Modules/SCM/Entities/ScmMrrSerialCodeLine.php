<?php

namespace Modules\SCM\Entities;

use Modules\SCM\Entities\ScmMrrLine;
use Illuminate\Database\Eloquent\Model;

class ScmMrrSerialCodeLine extends Model
{
    protected $guarded = [];

    public function scmMrrLines()
    {
        return $this->belongsTo(ScmMrrLine::class,'scm_mrr_line_id');
    }

    public function openingStockLines()
    {
        return $this->belongsTo(OpeningStockLine::class,'opening_stock_line_id');
    }
}
