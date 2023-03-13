<?php

namespace Modules\SCM\Entities;

use Carbon\Carbon;
use Modules\SCM\Entities\Cs;
use Modules\Admin\Entities\User;
use Modules\SCM\Entities\Indent;
use Modules\SCM\Entities\Supplier;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\Branch;
use Modules\SCM\Entities\PurchaseOrderLine;
use Modules\SCM\Entities\PoTermsAndCondition;
use Modules\SCM\Entities\ScmPurchaseRequisition;

class PurchaseOrder extends Model
{
	protected $fillable = ['po_no', 'date', 'supplier_id', 'indent_id', 'remarks', 'delivery_location', 'created_by', 'branch_id'];

	public function getDateAttribute($input)
	{
		$date = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
		return $date;
	}

	public function setDateAttribute($input)
	{
		$this->attributes['date'] = !empty($input) ? Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
	}

	public function purchaseOrderLines()
	{
		return $this->hasMany(PurchaseOrderLine::class);
	}

	public function poTermsAndConditions()
	{
		return $this->hasMany(PoTermsAndCondition::class);
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

	public function createdBy()
	{
		return $this->belongsTo(User::class, 'created_by');
	}

	public function branch()
	{
		return $this->belongsTo(Branch::class, 'branch_id');
	}
}
