<?php

namespace Modules\Admin\Entities;

use Modules\Admin\Entities\Service;
use Modules\Sales\Entities\Product;
use Illuminate\Database\Eloquent\Model;

class ServiceLine extends Model
{
    protected $guarded = [];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
