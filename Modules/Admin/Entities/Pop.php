<?php

namespace Modules\Admin\Entities;

use Carbon\Carbon;
use Modules\Admin\Entities\Branch;
use Modules\Admin\Entities\PopLine;
use Illuminate\Database\Eloquent\Model;

class Pop extends Model
{
    protected $fillable = [
        'name', 'type', 'division_id', 'district_id', 'thana_id', 'address', 'branch_id', 'lat_long', 'owners_name', 'contact_person', 'designation', 'contact_no', 'email', 'description', 'approval_date', 'btrc_approval_date', 'commissioning_date', 'termination_date', 'website_published_date', 'signboard', 'advance_amount', 'rent', 'advance_reduce', 'monthly_rent', 'paymet_method', 'bank_id', 'account_no', 'payment_date', 'routing_no', 'remarks', 'attached_file',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function popLines()
    {
        return $this->hasMany(PopLine::class);
    }

    private $dateAttributes = ['approval_date', 'btrc_approval_date', 'commissioning_date', 'termination_date', 'website_published_date', 'payment_date'];

    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->dateAttributes)) {
            $value = !empty($value) ? Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d') : null;
        }

        parent::setAttribute($key, $value);
    }

    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        if (in_array($key, $this->dateAttributes)) {
            $value = !empty($value) ? Carbon::createFromFormat('Y-m-d', $value)->format('d-m-Y') : null;
        }

        return $value;
    }
}
