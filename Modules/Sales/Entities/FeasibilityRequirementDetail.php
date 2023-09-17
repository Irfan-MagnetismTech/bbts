<?php

namespace Modules\Sales\Entities;

use App\Models\Dataencoding\Thana;
use Modules\Sales\Entities\Survey;
use Modules\Sales\Entities\Vendor;
use Modules\Sales\Entities\Costing;
use Modules\Sales\Entities\Planning;
use App\Models\Dataencoding\District;
use App\Models\Dataencoding\Division;
use Illuminate\Database\Eloquent\Model;
use Modules\Sales\Entities\OfferDetail;
use Modules\Sales\Entities\SurveyDetail;
use Modules\Sales\Entities\SaleProductDetail;
use Modules\Sales\Entities\FeasibilityRequirement;
use Modules\Sales\Entities\ConnectivityRequirement;
use Modules\Admin\Entities\Branch;


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

    public function connectivityRequirement()
    {
        return $this->belongsTo(ConnectivityRequirement::class, 'fr_no', 'fr_no');
    }

    public function surveySum()
    {
        return $this->hasMany(Survey::class, 'fr_no', 'fr_no');
    }

    public function planningSum()
    {
        return $this->hasMany(Planning::class, 'fr_no', 'fr_no');
    }

    public function costingSum()
    {
        return $this->hasMany(Costing::class, 'fr_no', 'fr_no');
    }

    public function survey()
    {
        return $this->belongsTo(Survey::class, 'fr_no', 'fr_no');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function planning()
    {
        return $this->belongsTo(Planning::class, 'fr_no', 'fr_no');
    }

    public function costing()
    {
        return $this->belongsTo(Costing::class, 'fr_no', 'fr_no')->where('is_modified', 0);
    }

    public function offerDetail()
    {
        return $this->hasOne(OfferDetail::class, 'fr_no', 'fr_no');
    }

    public function saleProductDetails()
    {
        return $this->hasMany(SaleProductDetail::class, 'fr_no', 'fr_no');
    }

    public function branch()
    {
        return $this->hasOne(Branch::class, 'id', 'branch_id');
    }
}
