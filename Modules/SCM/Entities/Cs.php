<?php

namespace Modules\SCM\Entities;

use Carbon\Carbon;
use Modules\SCM\Entities\CsMaterial;
use Modules\SCM\Entities\CsSupplier;
use Illuminate\Database\Eloquent\Model;
use Modules\SCM\Entities\CsMaterialSupplier;

class Cs extends Model
{
    protected $fillable = ['cs_no', 'cs_type', 'effective_date', 'expiry_date', 'remarks', 'created_by'];

    /**
     * @var array
     */
    protected $casts = [
        'effective_date' => 'date',
        'expiry_date'    => 'date',
    ];

    /**
     * @param $input
     */
    public function getEffectiveDateAttribute($input)
    {
        return Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y');
    }

    /**
     * @param $input
     */
    public function setEffectiveDateAttribute($input)
    {
        !empty($input) ? $this->attributes['effective_date'] = Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }

    /**
     * @param $input
     */
    public function getExpiryDateAttribute($input)
    {
        return Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y');
    }

    /**
     * @param $input
     */
    public function setExpiryDateAttribute($input)
    {
        !empty($input) ? $this->attributes['expiry_date'] = Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }

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
