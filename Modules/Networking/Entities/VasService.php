<?php

namespace Modules\Networking\Entities;

use Carbon\Carbon;
use Modules\Sales\Entities\Client;
use Modules\Sales\Entities\Vendor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Networking\Entities\VasServiceLine;

class VasService extends Model
{
    protected $fillable = [
        'client_no',
        'fr_no',
        'reference_no',
        'vendor_id',
        'date',
        'required_date',
        'remarks',
    ];

    private $dateField = ['date', 'required_date'];

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

    public function lines(): HasMany
    {
        return $this->hasMany(VasServiceLine::class);
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_no', 'client_no');
    }
}
