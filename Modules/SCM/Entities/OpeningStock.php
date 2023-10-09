<?php

namespace Modules\SCM\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class OpeningStock extends Model
{
    protected $fillable = [
        'date',
    ];

    /**
     * @param $input
     */
    public function getDateAttribute($input)
    {
        return Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y');
    }

    /**
     * @param $input
     */
    public function setDateAttribute($input)
    {
        !empty($input) ? $this->attributes['date'] = Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }

    public function lines()
    {
        return $this->hasMany(OpeningStockLine::class);
    }
}
