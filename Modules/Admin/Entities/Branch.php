<?php

namespace Modules\Admin\Entities;

use Modules\Admin\Entities\Pop;
use App\Models\Dataencoding\Thana;
use App\Models\Dataencoding\District;
use App\Models\Dataencoding\Division;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $guarded = [];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function thana()
    {
        return $this->belongsTo(Thana::class);
    }

    public function pop()
    {
        return $this->belongsTo(Pop::class);
    }

    public function getFormattedAddressAttribute()
    {
        $formatted = "{$this->name} ({$this->location}) - {$this->thana->name} - {$this->district->name}";

        return $formatted;
    }
}
