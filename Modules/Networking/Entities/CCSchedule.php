<?php

namespace Modules\Networking\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CCSchedule extends Model
{
    protected $fillable = [
        'fr_no',
        'client_no',
        'approved_type',
        'client_readyness_date',
        'nttn_date',
        'equipment_readyness_date',
        'field_operation_date',
        'schedule_date',
    ];

    private $dateField = ['client_readyness_date', 'nttn_date', 'equipment_readyness_date', 'field_operation_date', 'schedule_date'];

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
}
