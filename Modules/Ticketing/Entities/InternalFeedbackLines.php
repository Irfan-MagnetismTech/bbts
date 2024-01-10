<?php

namespace Modules\Ticketing\Entities;

use Carbon\Carbon;
use Modules\Sales\Entities\Client;
use Illuminate\Database\Eloquent\Model;
use Modules\Sales\Entities\FeasibilityRequirementDetail;

class InternalFeedbackLines extends Model
{
    protected $guarded = [];

    protected $table = 'internal_feedback_lines';

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_no', 'client_no');
    }

    public function feasibilityReqirementDetails()
    {
        return $this->belongsTo(FeasibilityRequirementDetail::class, 'fr_no', 'fr_no');
    }
}
