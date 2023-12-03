<?php

namespace Modules\Networking\Entities;

use Carbon\Carbon;
use App\Models\Dataencoding\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Sales\Entities\FeasibilityRequirement;
use Modules\Sales\Entities\FeasibilityRequirementDetail;

class Connectivity extends Model
{
    protected $fillable = [
        'sale_id',
        'client_no',
        'fr_no',
        'attendant_engineer',
        'commissioning_date'
    ];

    private $dateField = ['commissioning_date'];

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

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'attendant_engineer', 'id')->withDefault([
            'name' => 'No data found'
        ]);
    }
}
