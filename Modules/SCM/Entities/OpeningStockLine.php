<?php

namespace Modules\SCM\Entities;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Admin\Entities\Brand;
use Modules\SCM\Entities\Material;
use Illuminate\Database\Eloquent\Model;
use Modules\SCM\Entities\ScmPurchaseRequisition;

class OpeningStockLine extends Model
{
    protected $guarded = [];

    public function openingStock()
    {
        return $this->belongsTo(OpeningStock::class);
    }

    public function material(){
        return $this->belongsTo(Material::class);
    }

    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function serialCodeLines():HasMany
    {
        return $this->hasMany(ScmMrrSerialCodeLine::class,'opening_stock_line_id','id');
    }
}
