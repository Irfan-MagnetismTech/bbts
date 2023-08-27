<?php

namespace Modules\Sales\Entities;

use Modules\Admin\Entities\User;
use App\Models\Dataencoding\Thana;
use App\Models\Dataencoding\District;
use App\Models\Dataencoding\Division;
use Modules\Sales\Entities\SaleDetail;
use Illuminate\Database\Eloquent\Model;
use Modules\Sales\Entities\ClientDetail;
use Modules\Sales\Entities\BillingAddress;
use Modules\Sales\Entities\SaleLinkDetail;
use Modules\Sales\Entities\CollectionAddress;
use Modules\Ticketing\Entities\SupportTicket;

class Client extends Model
{
    protected $guarded = [];

    // public function clientDetails()
    // {
    //     return $this->hasMany(ClientDetail::class);
    // }

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class, 'client_no', 'client_no');
    }

    public function saleLinkDetails()
    {
        return $this->hasMany(SaleLinkDetail::class, 'client_no', 'client_no');
    }

    public function supportTickets()
    {
        return $this->hasMany(SupportTicket::class, 'client_no', 'client_no');
    }

    public function billingAddress()
    {
        return $this->hasMany(BillingAddress::class, 'client_id', 'id');
    }

    public function collectionAddress()
    {
        return $this->hasMany(CollectionAddress::class, 'client_id', 'id');
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

    public function feasibility_requirement_details()
    {
        return $this->hasMany(FeasibilityRequirementDetail::class, 'client_no', 'client_no');
    }

    public function feasibility_requirement()
    {
        return $this->hasMany(FeasibilityRequirement::class, 'client_no', 'client_no');
    }
}
