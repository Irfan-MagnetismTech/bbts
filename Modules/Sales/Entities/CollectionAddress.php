<?php

namespace Modules\Sales\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Sales\Entities\ClientProfile;
use App\Models\Dataencoding\Division;
use App\Models\Dataencoding\District;
use App\Models\Dataencoding\Thana;

class CollectionAddress extends Model
{
    protected $guarded = [];

    public function clientProfile()
    {
        return $this->belongsTo(ClientProfile::class, 'client_profile_id', 'id');
    }

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id', 'id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }

    public function thana()
    {
        return $this->belongsTo(Thana::class, 'thana_id', 'id');
    }
}
