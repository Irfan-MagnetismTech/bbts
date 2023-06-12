<?php

namespace Modules\Admin\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ConnectivityLink extends Model
{
    protected $fillable = ['division_id', 'from_location', 'bbts_link_id', 'vendor_id', 'link_name', 'link_type', 'reference', 'to_location', 'from_site', 'district_id', 'to_site', 'thana_id', 'gps', 'teck_type', 'vendor_link_id', 'vendor_vlan', 'port', 'date_of_commissioning', 'date_of_termination', 'activation_date', 'remarks', 'capacity_type', 'existing_capacity', 'new_capacity', 'terrif_per_month', 'amount', 'vat_percent', 'vat', 'total'];


    // public function getDateOfCommissioningAttribute($input)
    // {
    //     $date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
    //     return $date;
    // }

    // public function setDateOfCommissioningAttribute($input)
    // {
    //     $this->attributes['date_of_commissioning'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    // }
    // public function getdateOfTerminationAttribute($input)
    // {
    //     $date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
    //     return $date;
    // }

    // public function setdateOfTerminationAttribute($input)
    // {
    //     $this->attributes['date_of_termination'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    // }
    // public function getactivationDateAttribute($input)
    // {
    //     $date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
    //     return $date;
    // }

    // public function setactivationDateAttribute($input)
    // {
    //     $this->attributes['activation_date'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    // }

}
