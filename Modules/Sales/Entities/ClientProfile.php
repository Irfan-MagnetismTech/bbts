<?php

namespace Modules\Sales\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Models\Dataencoding\Division;
use App\Models\Dataencoding\District;
use App\Models\Dataencoding\Thana;
use Modules\Admin\Entities\User;

class ClientProfile extends Model
{
    protected $guarded = [];

    public function billingAddress()
    {
        return $this->hasOne(BillingAddress::class, 'client_profile_id', 'id');
    }

    public function collectionAddress()
    {
        return $this->hasOne(CollectionAddress::class, 'client_profile_id', 'id');
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

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
