<?php

namespace Modules\Networking\Entities;

use Modules\Sales\Entities\Client;
use Modules\Sales\Entities\Planning;
use Illuminate\Database\Eloquent\Model;
use Modules\Sales\Entities\SurveyDetail;
use Modules\Sales\Entities\FinalSurveyDetail;
use Modules\Networking\Entities\PhysicalConnectivityLines;
use Modules\Sales\Entities\FeasibilityRequirementDetail;

class PhysicalConnectivity extends Model
{
    protected $fillable = [
        'sale_id', 'fr_no', 'connectivity_point', 'client_no', 'remarks', 'connectivity_requirement_id', 'is_modified'
    ];

    public function lines()
    {
        return $this->hasMany(PhysicalConnectivityLines::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_no', 'client_no');
    }

    public function planning()
    {
        return $this->belongsTo(Planning::class, 'fr_no', 'fr_no');
    }

    public function logicalConnectivity()
    {
        return $this->hasOne(LogicalConnectivity::class, 'fr_no', 'fr_no')->where('is_modified', '0');
    }

    public function connectivity()
    {
        return $this->hasOne(Connectivity::class, 'fr_no', 'fr_no')->where('is_modify', '0');
    }

    public function feasibilityRequirementDetail()
    {
        return $this->hasOne(FeasibilityRequirementDetail::class, 'fr_no', 'fr_no');
    }
}
