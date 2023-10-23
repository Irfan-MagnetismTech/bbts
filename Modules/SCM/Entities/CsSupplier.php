<?php

namespace Modules\SCM\Entities;

use Modules\SCM\Entities\Supplier;
use Illuminate\Database\Eloquent\Model;

class CsSupplier extends Model
{
    protected $guarded = [];

    /**
     * @return mixed
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id')->withDefault();
    }

    public function cs()
    {
        return $this->belongsTo(Cs::class, 'cs_id')->select('id', 'cs_no');
    }

}
