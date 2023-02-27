<?php

namespace Modules\SCM\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\SCM\Entities\PurchaseOrderLine; 

class PurchaseOrder extends Model
{
	protected $fillable = ['po_no', 'date', 'comparative_statement_id', 'indent_id', 'remarks', 'terms_of_supply', 'terms_of_payment', 'terms_of_condition', 'delivery_location', 'created_by', 'branch_id'];

	public function purchaseOrderLines(){
		return $this->hasMany(PurchaseOrderLine::class);
	}
}
