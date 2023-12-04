<?php

namespace Modules\Networking\Entities;

use Carbon\Carbon;
use App\Models\Dataencoding\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Sales\Entities\FeasibilityRequirement;
use Modules\Sales\Entities\FeasibilityRequirementDetail;

class Activation extends Model
{
    protected $fillable = [
        'connectivity_id',
        'client_no',
        'fr_no',
        'is_active'
    ];
}
