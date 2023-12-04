<?php

namespace Modules\Networking\Entities;

use Carbon\Carbon;
use App\Models\Dataencoding\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Sales\Entities\Client;
use Modules\Sales\Entities\FeasibilityRequirement;
use Modules\Sales\Entities\FeasibilityRequirementDetail;

class Activation extends Model
{
    protected $fillable = [
        'client_no',
        'fr_no',
        'is_active'
    ];

    public function connectivities(): BelongsTo
    {
        return $this->belongsTo(Connectivity::class, 'fr_no', 'fr_no');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_no', 'client_no');
    }

    public function frDetails(): BelongsTo
    {
        return $this->belongsTo(FeasibilityRequirementDetail::class, 'fr_no', 'fr_no');
    }
}
