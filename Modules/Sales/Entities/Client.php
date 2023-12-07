<?php

namespace Modules\Sales\Entities;

use Modules\Admin\Entities\Branch;
use Modules\Admin\Entities\User;
use App\Models\Dataencoding\Thana;
use App\Models\Dataencoding\District;
use App\Models\Dataencoding\Division;
use Modules\Networking\Entities\Connectivity;
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

    public function billingAddres()
    {
        return $this->hasOne(BillingAddress::class, 'client_id', 'id')->orderBy('id','asc');
    }

    public function collectionAddress()
    {
        return $this->hasMany(CollectionAddress::class, 'client_id', 'id');
    }

    public function collectionAddres()
    {
        return $this->hasOne(CollectionAddress::class, 'client_id', 'id')->orderBy('id','asc');
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

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function feasibility_requirement_details()
    {
        return $this->hasMany(FeasibilityRequirementDetail::class, 'client_no', 'client_no');
    }

    public function connectivities()
    {
        return $this->hasMany(Connectivity::class, 'client_no', 'client_no');
    }

    public function feasibility_requirement()
    {
        return $this->hasMany(FeasibilityRequirement::class, 'client_no', 'client_no');
    }
}
