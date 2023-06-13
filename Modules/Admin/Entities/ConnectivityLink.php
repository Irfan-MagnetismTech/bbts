<?php

namespace Modules\Admin\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ConnectivityLink extends Model
{
    protected $fillable = ['division_id', 'from_location', 'bbts_link_id', 'vendor_id', 'link_name', 'link_type', 'reference', 'to_location', 'from_site', 'district_id', 'to_site', 'thana_id', 'gps', 'teck_type', 'vendor_link_id', 'vendor_vlan', 'port', 'date_of_commissioning', 'date_of_termination', 'activation_date', 'remarks', 'capacity_type', 'existing_capacity', 'new_capacity', 'terrif_per_month', 'amount', 'vat_percent', 'vat', 'total', 'increament_type'];

    private $dateField = ['date_of_commissioning', 'date_of_termination', 'activation_date'];

    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->dateField)) {
            $value = !empty($value) ? Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d') : null;
        }

        parent::setAttribute($key, $value);
    }

    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        if (in_array($key, $this->dateField)) {
            $value = !empty($value) ? Carbon::createFromFormat('Y-m-d', $value)->format('d-m-Y') : null;
        }

        return $value;
    }
}
