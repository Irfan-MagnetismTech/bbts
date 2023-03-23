<?php

namespace Modules\SCM\Entities;

use Modules\Admin\Entities\Brand;
use Modules\SCM\Entities\Material;
use Illuminate\Database\Eloquent\Model;

class StockLedger extends Model
{
    protected $guarded = [];

    public function stockable()
    {
        return $this->morphTo();
    }

    public function receivable()
    {
        return $this->morphTo();
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
