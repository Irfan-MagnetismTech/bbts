<?php

namespace Modules\Sales\Entities;

use Carbon\Carbon;
use Modules\Sales\Entities\Sale;
use Modules\Sales\Entities\Client;
use Modules\Sales\Entities\Costing;
use Illuminate\Database\Eloquent\Model;
use Modules\Sales\Entities\OfferDetail;
use Modules\Sales\Entities\BillingAddress;
use Modules\Sales\Entities\SaleLinkDetail;
use Modules\Networking\Entities\CCSchedule;
use Modules\Sales\Entities\CollectionAddress;
use Modules\Sales\Entities\SaleProductDetail;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Networking\Entities\Activation;
use Modules\Networking\Entities\Connectivity;
use Modules\Networking\Entities\LogicalConnectivity;
use Modules\Networking\Entities\PhysicalConnectivity;
use Modules\Sales\Entities\FeasibilityRequirementDetail;

class SaleDetail extends Model
{
    protected $guarded = [];

    /**
     * @param $input
     */
    public function getDeliveryDateAttribute($input)
    {
        if (!empty($input)) {
            return Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') ?: null;
        }
    }

    /**
     * @param $input
     */
    public function setDeliveryDateAttribute($input)
    {
        !empty($input) ? $this->attributes['delivery_date'] = Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }

    public function saleLinkDetails()
    {
        return $this->hasMany(SaleLinkDetail::class, 'sale_detail_id', 'id');
    }

    public function connectivities()
    {
        return $this->hasOne(Connectivity::class, 'fr_no', 'fr_no')->where('is_modify', '0');
    }

    public function connectivitiesModify()
    {
        return $this->hasOne(Connectivity::class, 'connectivity_requirement_id', 'connectivity_requirement_id');
    }

    public function activation()
    {
        return $this->hasOne(Activation::class, 'fr_no', 'fr_no');
    }

    public function saleProductDetails()
    {
        return $this->hasMany(SaleProductDetail::class, 'sale_detail_id', 'id');
    }

    public function frDetails(): BelongsTo
    {
        return $this->belongsTo(FeasibilityRequirementDetail::class, 'fr_no', 'fr_no');
    }

    public function offerDetails(): BelongsTo
    {
        return $this->belongsTo(OfferDetail::class, 'fr_no', 'fr_no');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_no', 'client_no');
    }

    public function feasibilityRequirementDetails()
    {
        return $this->hasOne(FeasibilityRequirementDetail::class, 'fr_no', 'fr_no');
    }

    public function costing()
    {
        return $this->belongsTo(Costing::class, 'fr_no', 'fr_no')->where('is_modified', '0');
    }

    public function planning()
    {
        return $this->belongsTo(Planning::class, 'fr_no', 'fr_no')->where('is_modified', '0');
    }

    public function billingAddress()
    {
        return $this->belongsTo(BillingAddress::class, 'billing_address_id', 'id');
    }

    public function collectionAddress()
    {
        return $this->belongsTo(CollectionAddress::class, 'collection_address_id', 'id');
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }

    public function ccSchedule()
    {
        return $this->hasOne(CCSchedule::class, 'fr_no', 'fr_no');
    }

    public function survey()
    {
        return $this->hasOne(Survey::class, 'fr_no', 'fr_no');
    }

    public function costingByConnectivity()
    {
        return $this->hasOne(Costing::class, 'connectivity_requirement_id', 'id');
    }

    public function physicalConnectivity()
    {
        return $this->hasOne(PhysicalConnectivity::class, 'fr_no', 'fr_no')->where('is_modified', 0);
    }

    public function physicalConnectivityModify()
    {
        return $this->hasOne(PhysicalConnectivity::class, 'connectivity_requirement_id', 'connectivity_requirement_id');
    }

    public function logicalConnectivity()
    {
        return $this->hasOne(LogicalConnectivity::class, 'fr_no', 'fr_no')->where('is_modified', 0);
    }

    public function logicalConnectivityInternet()
    {
        return $this->hasOne(LogicalConnectivity::class, 'fr_no', 'fr_no')->where('is_modified', 0)->where('product_category', 'Internet');
    }

    public function logicalConnectivityData()
    {
        return $this->hasOne(LogicalConnectivity::class, 'fr_no', 'fr_no')->where('is_modified', 0)->where('product_category', 'Data');
    }

    public function logicalConnectivityVAS()
    {
        return $this->hasOne(LogicalConnectivity::class, 'fr_no', 'fr_no')->where('is_modified', 0)->where('product_category', 'VAS');
    }



    public function logicalConnectivityInternetModify()
    {
        return $this->hasOne(LogicalConnectivity::class, 'connectivity_requirement_id', 'connectivity_requirement_id')->where('product_category', 'Internet');
    }

    public function logicalConnectivityDataModify()
    {
        return $this->hasOne(LogicalConnectivity::class, 'connectivity_requirement_id', 'connectivity_requirement_id')->where('product_category', 'Data');
    }

    public function logicalConnectivityVASModify()
    {
        return $this->hasOne(LogicalConnectivity::class, 'connectivity_requirement_id', 'connectivity_requirement_id')->where('product_category', 'VAS');
    }
}
