<?php

namespace Modules\Sales\Entities;

use Illuminate\Database\Eloquent\Model;

class Costing extends Model
{

    protected $fillable = ['client_no', 'mq_no', 'fr_no', 'fr_id', 'connectivity_point', 'month', 'product_total_cost', 'total_operation_cost', 'total_cost_amount', 'product_grand_total', 'equipment_wise_total', 'client_equipment_total', 'equipment_partial_total', 'equipment_deployment_cost', 'equipment_interest', 'equipment_vat', 'equipment_tax', 'equipment_grand_total', 'equipment_otc', 'equipment_roi', 'total_investment', 'total_otc', 'total_product_cost', 'total_service_cost', 'total_mrc', 'management_perchantage', 'management_cost_amount', 'management_cost_total', 'equipment_price_for_client', 'total_otc_with_client_equipment'];

    public function costingProducts()
    {
        return $this->hasMany(CostingProduct::class);
    }

    public function costingProductEquipments()
    {
        return $this->hasMany(CostingProductEquipment::class);
    }

    public function costingLinks()
    {
        return $this->hasMany(CostingLink::class, 'costing_id', 'id')->where('link_status', 1);
    }

    public function lead_generation()
    {
        return $this->hasOne(LeadGeneration::class, 'client_no', 'client_no');
    }

    public function planning()
    {
        return $this->hasOne(Planning::class, 'fr_no', 'fr_no');
    }

    public function saleDetail()
    {
        return $this->hasOne(SaleDetail::class, 'fr_no', 'fr_no');
    }

    public function costingLinkEquipments()
    {
        return $this->hasMany(CostingLinkEquipment::class, 'costing_link_id', 'id');
    }
}
