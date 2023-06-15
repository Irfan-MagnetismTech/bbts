<?php

namespace Modules\Sales\Entities;

use Illuminate\Database\Eloquent\Model;

class Costing extends Model
{

    protected $fillable = ['client_no', 'fr_no', 'fr_id', 'connectivity_point_name', 'month', 'product_total_cost', 'total_operation_cost', 'total_cost_amount', 'product_grand_total', 'equipment_wise_total', 'client_equipment_total', 'equipment_partial_total', 'equipment_deployment_cost', 'equipment_interest', 'equipment_vat', 'equipment_tax', 'equipment_grand_total', 'equipment_otc', 'equipment_roi', 'total_investment', 'total_otc', 'total_product_cost', 'total_service_cost', 'total_mrc', 'management_perchantage', 'management_cost_amount', 'management_cost_total', 'equipment_price_for_client', 'total_otc_with_client_equipment'];
}
