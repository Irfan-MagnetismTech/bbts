<?php

namespace Modules\SCM\Entities;

use Modules\SCM\Entities\IndentLine;
use Illuminate\Database\Eloquent\Model;
use Modules\SCM\Entities\ScmPurchaseRequisition;

class Indent extends Model
{
    protected $guarded = [];

    public function indentLines()
    {
        return $this->hasMany(IndentLine::class, 'indent_id');
    }
}
