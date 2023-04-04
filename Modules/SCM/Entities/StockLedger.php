<?php

namespace Modules\SCM\Entities;

use Modules\Admin\Entities\Brand;
use Modules\SCM\Entities\Material;
use Illuminate\Database\Eloquent\Model;
use Modules\SCM\Entities\FiberTracking;

class StockLedger extends Model
{
    protected $guarded = [];

    public function stockable()
    {
        return $this->morphTo();
    }

    public function receivable()
    {
        return $this->morphTo('receivable', 'receivable_type', 'receivable_id');
    }

    public function fiberTracking()
    {
        return $this->hasMany(FiberTracking::class, 'serial_code', 'serial_code');
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
