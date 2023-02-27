<?php

namespace Modules\SCM\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderLine extends Model
{
    protected $fillable = ['purchase_requisition_id', 'material_id', 'po_composit_key', 'quantity', 'warranty_period', 'installation_cost', 'transport_cost', 'unit_price', 'vat', 'tax', 'total_amount', 'required_date'];

    public function setRequiredDateAttribute($input)
    {
        $this->attributes['required_date'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }

    public function getRequiredDateAttribute($input)
    {
        $required_date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $required_date;
    }

}
