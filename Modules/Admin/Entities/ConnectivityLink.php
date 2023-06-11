<?php

namespace Modules\Admin\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ConnectivityLink extends Model
{
    protected $guarded = [];


    public function getDateOfCommissioningAttribute($input)
    {
        $date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $date;
    }

    public function setDateOfCommissioningAttribute($input)
    {
        $this->attributes['date_of_commissioning'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }
    public function getdateOfTerminationAttribute($input)
    {
        $date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $date;
    }

    public function setdateOfTerminationAttribute($input)
    {
        $this->attributes['date_of_termination'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }
    public function getactivationDateAttribute($input)
    {
        $date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $date;
    }

    public function setactivationDateAttribute($input)
    {
        $this->attributes['activation_date'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }
}
