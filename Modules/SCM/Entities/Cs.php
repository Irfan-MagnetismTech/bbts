<?php

namespace Modules\SCM\Entities;

use Modules\SCM\Entities\CsMaterial;
use Modules\SCM\Entities\CsSupplier;
use Illuminate\Database\Eloquent\Model;
use Modules\SCM\Entities\CsMaterialSupplier;

class Cs extends Model
{
    // protected $guarded = [];
    protected $fillable = [
        'cs_no',
        'effective_date',
        'expiry_date',
        'remarks',
        'created_by',
    ];

    public function csMaterials()
    {
        return $this->hasMany(CsMaterial::class, 'cs_id');
    }

    /**
     * @return mixed
     */
    public function csSuppliers()
    {
        return $this->hasMany(CsSupplier::class, 'cs_id', 'id');
    }

    /**
     * @return mixed
     */
    public function csMaterialsSuppliers()
    {
        return $this->hasMany(CsMaterialSupplier::class, 'cs_id');
    }

    public function selectedSuppliers()
    {
        return $this->hasMany(CsSupplier::class, 'cs_id', 'id')->where('is_checked', 1);
    }
}
