<?php

namespace Modules\Networking\Entities;

use Modules\Sales\Entities\Client;
use Modules\Sales\Entities\Planning;
use Illuminate\Database\Eloquent\Model;
use Modules\Sales\Entities\SurveyDetail;
use Modules\Sales\Entities\FinalSurveyDetail;
use Modules\Networking\Entities\PhysicalConnectivityLines;

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
}
