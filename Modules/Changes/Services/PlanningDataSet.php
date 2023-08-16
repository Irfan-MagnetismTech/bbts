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
        $details = $connectivity_requirement->product_details ?? $plan->servicePlans->product_details;
        dd($details);
        $data = [
            'id' => $old ? $old['id'] : $plan->id,
            'client_no' => $old ? $old['client_no'] : $connectivity_requirement->lead_generation->client_no ?? $plan->lead_generation->client_no,
            'client_name' => $old ? $old['client_name'] : $connectivity_requirement->lead_generation->client_name ?? $plan->lead_generation->client_name,
            'client_address' => $old ? $old['client_address'] : $connectivity_requirement->lead_generation->address ?? $plan->lead_generation->address,
            'client_division' => $old ? $old['client_division'] : $connectivity_requirement->lead_generation->division->name ?? $plan->lead_generation->division->name,
            'client_district' => $old ? $old['client_district'] : $connectivity_requirement->lead_generation->district->name ?? $plan->lead_generation->district->name,
            'client_thana' => $old ? $old['client_thana'] : $connectivity_requirement->lead_generation->thana->name ?? $plan->lead_generation->thana->name,
            'client_landmark' => $old ? $old['client_landmark'] : $connectivity_requirement->lead_generation->landmark ?? $plan->lead_generation->landmark,
            'client_lat_long' => $old ? $old['client_lat_long'] : $connectivity_requirement->lead_generation->lat_long ?? $plan->lead_generation->lat_long,
            'client_contact_person' => $old ? $old['client_contact_person'] : $connectivity_requirement->lead_generation->contact_person ?? $plan->lead_generation->contact_person,
            'client_contact_no' => $old ? $old['client_contact_no'] : $connectivity_requirement->lead_generation->contact_no ?? $plan->lead_generation->contact_no,
            'client_email' => $old ? $old['client_email'] : $connectivity_requirement->lead_generation->email ?? $plan->lead_generation->email,
            'client_website' => $old ? $old['client_website'] : $connectivity_requirement->lead_generation->website ?? $plan->lead_generation->website,
            'client_document' => $old ? $old['client_document'] : $connectivity_requirement->lead_generation->document ?? $plan->lead_generation->document,
            'change_type' => $old ? $old['change_type'] : $change_type,
            'product_details' => $old ? [] : $connectivity_requirement->product_details ?? $plan->servicePlans,
            'equipment_plans' => $old ? [] : $plan->equipmentPlans,
            'plan_links' => $old ? [] : $plan->planLinks,
            'fr_no' => $old ? $old['fr_no'] : $connectivity_requirement->fr_no ?? $plan->fr_no,
            'particulars' => Product::get(),
            'materials' =>  Material::get(),
            'brands' =>  Brand::get(),
            'vendors' =>  Vendor::get(),
        ];
        return $data;
    }
}
