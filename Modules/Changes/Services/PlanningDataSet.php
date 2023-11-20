<?php

namespace Modules\Changes\Services;

use Modules\Sales\Entities\Vendor;
use Modules\SCM\Entities\Material;
use Modules\Sales\Entities\Product;
use Modules\Admin\Entities\Brand;

class PlanningDataSet
{
    public static function setData($old, $connectivity_requirement, $plan)
    {
        $change_type = $connectivity_requirement ? json_decode($connectivity_requirement->change_type) : json_decode($plan->ConnectivityRequirement->change_type);

        $details = [];
        if ($connectivity_requirement) {
            foreach ($connectivity_requirement->connectivityProductRequirementDetails as $key => $value) {
                $details[$key]['id'] = '';
                $details[$key]['product_id'] = $value->product_id;
                $details[$key]['prev_quantity'] = $value->prev_quantity;
                $details[$key]['product_name'] = $value->product->name;
                $details[$key]['category_id'] = $value->category_id;
                $details[$key]['capacity'] = $value->capacity;
                $details[$key]['remarks'] = $value->remarks;
                $details[$key]['plan'] = '';
                $details[$key]['connectivity_product_requirement_details_id'] = $value->id;
            }
        } elseif ($plan) {
            foreach ($plan->servicePlans as $key => $value) {
                $details[$key]['id'] = $value->id;
                $details[$key]['product_id'] = $value->connectivityProductRequirementDetails->product_id;
                $details[$key]['prev_quantity'] = $value->connectivityProductRequirementDetails->prev_quantity;
                $details[$key]['product_name'] = $value->connectivityProductRequirementDetails->product->name;
                $details[$key]['category_id'] = $value->connectivityProductRequirementDetails->category_id;
                $details[$key]['capacity'] = $value->connectivityProductRequirementDetails->capacity;
                $details[$key]['remarks'] = $value->connectivityProductRequirementDetails->remarks;
                $details[$key]['plan'] = $value->plan;
                $details[$key]['connectivity_product_requirement_details_id'] = $value->connectivity_product_requirement_details_id;
            }
        }
        $lead_generation = $connectivity_requirement ? $connectivity_requirement->lead_generation : $plan->lead_generation;
        $equipement_plan = $connectivity_requirement ? $connectivity_requirement->equipement_plan : $plan->equipmentPlans;
        // dd($equipement_plan);
        $planLinks = $connectivity_requirement ? $connectivity_requirement->planLinks : $plan->planLinks;
        $data = [
            'id' => $plan ? $plan->id : '',
            'connectivity_requirement_id' =>  $connectivity_requirement->id ?? $plan->connectivity_requirement_id,
            'type' => $connectivity_requirement ? 'create' : 'edit',
            'client_no' => $old ? $old['client_no'] : $lead_generation->client_no ?? '',
            'client_name' => $old ? $old['client_name'] : $lead_generation->client_name ?? '',
            'client_address' => $old ? $old['client_address'] : $connectivity_requirement->feasibilityRequirementDetail->location ?? '',
            'client_division' => $old ? $old['client_division'] : $lead_generation->division->name ?? '',
            'client_district' => $old ? $old['client_district'] : $lead_generation->district->name ?? '',
            'client_thana' => $old ? $old['client_thana'] : $lead_generation->thana->name ?? '',
            'branch' => $old ? $old['branch'] : $connectivity_requirement->feasibilityRequirementDetail->branch->name ?? '',
            'connectivity_point' => $old ? $old['connectivity_point'] : $connectivity_requirement->feasibilityRequirementDetail->connectivity_point ?? '',
            'client_landmark' => $old ? $old['client_landmark'] : $lead_generation->client_landmark ?? '',
            'client_lat' => $old ? $old['client_lat'] : $connectivity_requirement->feasibilityRequirementDetail->lat ?? '',
            'client_long' => $old ? $old['client_long'] : $connectivity_requirement->feasibilityRequirementDetail->long ?? '',
            'client_contact_person' => $old ? $old['client_contact_person'] : $lead_generation->contact_person ?? '',
            'client_contact_no' => $old ? $old['client_contact_no'] : $lead_generation->contact_no ?? '',
            'client_email' => $old ? $old['client_email'] : $lead_generation->email ?? '',
            'client_website' => $old ? $old['client_website'] : $lead_generation->website ?? '',
            'client_document' => $old ? $old['client_document'] : $lead_generation->document ?? '',
            'remarks' => $old ? $old['remarks'] : $lead_generation->remarks ?? '',
            'change_type' => $old ? $old['change_type'] : $change_type,
            'product_details' => $old ? [] : $details,
            'equipment_plans' => $old ? [] : $equipement_plan,
            'plan_links' => $old ? [] : $planLinks,
            'fr_no' => $old ? $old['fr_no'] : $connectivity_requirement->fr_no ?? $plan->fr_no,
            'particulars' => Product::get(),
            'materials' =>  Material::get(),
            'brands' =>  Brand::get(),
            'vendors' =>  Vendor::get(),
        ];
        return $data;
    }
}
