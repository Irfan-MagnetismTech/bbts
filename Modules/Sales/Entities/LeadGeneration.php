<?php

namespace Modules\Sales\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Models\Dataencoding\Division;
use App\Models\Dataencoding\District;
use App\Models\Dataencoding\Thana;

class LeadGeneration extends Model
{
    protected $guarded = [];

    public function division()
    {
        return $this->hasOne(Division::class, 'id', 'division_id');
    }

    public function district()
    {
        return $this->hasOne(District::class, 'id', 'district_id');
    }

    public function thana()
    {
        return $this->hasOne(Thana::class, 'id', 'thana_id');
    }
}