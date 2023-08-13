<?php

namespace Modules\Sales\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Sales\Entities\LeadGeneration;
use Modules\Sales\Entities\FeasibilityRequirementDetail;
use Modules\Sales\Entities\ConnectivityRequirementDetail;
use Modules\Sales\Entities\ConnectivityProductRequirementDetail;

class ConnectivityRequirement extends Model
{
    protected $fillable = [
        'client_no', 'fr_no', 'from_date', 'to_date', 'existing_mrc', 'decrease_mrc', 'connectivity_remarks', 'user_id', 'branch_id', 'date', 'change_type', 'activation_date', 'is_modified'
    ];

    private $dateField = ['activation_date', 'date', 'to_date', 'from_date'];

    public function setAttribute($key, $value): void
    {
        if (in_array($key, $this->dateField)) {
            $value = !empty($value) ? Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d') : null;
        }

        parent::setAttribute($key, $value);
    }

    public function getAttribute($key): mixed
    {
        $value = parent::getAttribute($key);

        if (in_array($key, $this->dateField)) {
            $value = !empty($value) ? Carbon::createFromFormat('Y-m-d', $value)->format('d-m-Y') : null;
        }

        return $value;
    }

    public function connectivityRequirementDetails(): HasMany
    {
        return $this->hasMany(ConnectivityRequirementDetail::class);
    }

    public function connectivityProductRequirementDetails(): HasMany
    {
        return $this->hasMany(ConnectivityProductRequirementDetail::class);
    }

    public function lead_generation(): BelongsTo
    {
        return $this->belongsTo(LeadGeneration::class, 'client_no', 'client_no');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_no', 'client_no');
    }

    public function FeasibilityRequirementDetail(): BelongsTo
    {
        return $this->belongsTo(FeasibilityRequirementDetail::class, 'fr_no', 'fr_no');
    }

    public function fromLocation(): BelongsTo
    {
        return $this->belongsTo(FeasibilityRequirementDetail::class, 'from_location', 'id');
    }

    public function scopeUnmodified($query): mixed
    {
        return $query->where('is_modified', 0);
    }

    public function scopeModified($query): mixed
    {
        return $query->where('is_modified', 1);
    }
}
