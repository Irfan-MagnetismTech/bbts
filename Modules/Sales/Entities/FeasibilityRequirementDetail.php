<?php

namespace Modules\Sales\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Sales\Entities\FeasibilityRequirement;
use App\Models\Dataencoding\Division;
use App\Models\Dataencoding\District;
use App\Models\Dataencoding\Thana;


class FeasibilityRequirementDetail extends Model
{
    protected $guarded = [];

    public function feasibilityRequirement()
    {
        return $this->belongsTo(FeasibilityRequirement::class);
    }

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
}
