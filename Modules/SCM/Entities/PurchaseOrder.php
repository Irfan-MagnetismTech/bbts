<?php

namespace Modules\SCM\Entities;

use Modules\SCM\Entities\Indent;
use Modules\SCM\Entities\Supplier;
use Illuminate\Database\Eloquent\Model;
use Modules\SCM\Entities\PurchaseOrderLine;
use Modules\SCM\Entities\ScmPurchaseRequisition;

class PurchaseOrder extends Model
{
	protected $fillable = ['po_no', 'date', 'comparative_statement_id', 'indent_id', 'remarks', 'terms_of_supply', 'terms_of_payment', 'terms_of_condition', 'delivery_location', 'created_by', 'branch_id'];

	public function purchaseOrderLines()
	{
		return $this->hasMany(PurchaseOrderLine::class);
	}

	public function supplier()
	{
		return $this->belongsTo(Supplier::class, 'supplier_id');
	}

	public function indent()
	{
		return $this->belongsTo(Indent::class);
	}

	public function scmPurchaseRequisition()
	{
		return $this->belongsTo(ScmPurchaseRequisition::class);
	}
}
