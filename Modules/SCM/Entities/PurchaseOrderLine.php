<?php

namespace Modules\SCM\Entities;

use Carbon\Carbon;
use Modules\SCM\Entities\Cs;
use Modules\SCM\Entities\Indent;
use Modules\Admin\Entities\Brand;
use Modules\SCM\Entities\Material;
use Modules\SCM\Entities\Supplier;
use Modules\SCM\Entities\PoMaterial;
use Illuminate\Database\Eloquent\Model;
use Modules\SCM\Entities\PurchaseOrder;
use Modules\SCM\Entities\ScmPurchaseRequisition;
use Modules\SCM\Entities\ScmMrrLine;
use Modules\SCM\Http\Requests\MaterialRequest;

class PurchaseOrderLine extends Model
{
    protected $fillable = [
        'purchase_order_id', 'scm_purchase_requisition_id', 'po_composit_key', 'cs_id', 'quotation_no', 'material_id', 'brand_id', 'model', 'description', 'quantity', 'warranty_period', 'installation_cost', 'transport_cost', 'unit_price', 'vat', 'tax', 'total_amount', 'required_date'
    ];

    public function setRequiredDateAttribute($input)
    {
        $this->attributes['required_date'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }

    public function getRequiredDateAttribute($input)
    {
        $required_date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $required_date;
    }

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function scmPurchaseRequisition()
    {
        return $this->belongsTo(ScmPurchaseRequisition::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function cs()
    {
        return $this->belongsTo(Cs::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function indent()
    {
        return $this->belongsTo(Indent::class);
    }

    public function poMaterial()
    {
        return $this->belongsTo(PoMaterial::class, 'po_composit_key', 'po_composit_key');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function materialReceiveLines()
    {
        return $this->hasMany(ScmMrrLine::class, 'po_composit_key', 'po_composit_key');
    }
}
