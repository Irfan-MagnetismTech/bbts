<?php

namespace Modules\Networking\Entities;

use Carbon\Carbon;
use Modules\Admin\Entities\Pop;
use Modules\Sales\Entities\Client;
use Modules\Sales\Entities\Vendor;
use Illuminate\Database\Eloquent\Model;
use Modules\Networking\Entities\NetServiceRequisitionLine;
use Modules\Sales\Entities\FeasibilityRequirement;
use Modules\Sales\Entities\FeasibilityRequirementDetail;

class NetServiceRequisition extends Model
{
    protected $guarded = [];
    private $dateField = ['date', 'required_date'];

    public function lines()
    {
        return $this->hasMany(NetServiceRequisitionLine::class, 'net_service_requisition_id', 'id');
    }

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

    public function feasibilityRequirmentDetail()
    {
        return $this->belongsTo(FeasibilityRequirementDetail::class, 'fr_no','fr_no');
    }

    public function fromPop()
    {
        return $this->belongsTo(Pop::class, 'from_pop_id');
    }

    public function toPop()
    {
        return $this->belongsTo(Pop::class, 'to_pop_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_no', 'client_no');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }
}
