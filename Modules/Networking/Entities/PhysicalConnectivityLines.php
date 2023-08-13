<?php

namespace Modules\Networking\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\ConnectivityLink;
use Modules\Sales\Entities\FinalSurveyDetail;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Networking\Entities\PhysicalConnectivity;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;

class PhysicalConnectivityLines extends Model
{
    protected $guarded = [];

    public function connectivityLink()
    {
        return $this->belongsTo(ConnectivityLink::class, 'bbts_link_id', 'bbts_link_id');
    }

    public function physicalConnectivity(): BelongsTo
    {
        return $this->belongsTo(PhysicalConnectivity::class);
    }
}
