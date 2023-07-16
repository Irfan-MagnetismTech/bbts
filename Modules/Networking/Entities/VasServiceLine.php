<?php

namespace Modules\Networking\Entities;

use Modules\Sales\Entities\Product;
use Illuminate\Database\Eloquent\Model;
use Modules\Networking\Entities\VasService;

class VasServiceLine extends Model
{
    protected $guarded = [];

    public function vasService()
    {
        return $this->belongsTo(VasService::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
