<?php

namespace Modules\SCM\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    protected $guarded = [];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ScCategory::class, 'category_id', 'id');
    }

    public function csSuppliers():HasMany
    {
        return $this->hasMany(CsSupplier::class,'supplier_id','id');
    }
}
