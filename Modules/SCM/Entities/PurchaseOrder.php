<?php

namespace Modules\SCM\Entities;

use Carbon\Carbon;
use Modules\SCM\Entities\Cs;
use Modules\Admin\Entities\User;
use Modules\SCM\Entities\Indent;
use Modules\Admin\Entities\Branch;
use Modules\SCM\Entities\Supplier;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Modules\SCM\Entities\PurchaseOrderLine;
use Modules\SCM\Entities\PoTermsAndCondition;
use Modules\SCM\Entities\ScmPurchaseRequisition;

class PurchaseOrder extends Model
{
	use HasRoles;
	protected $fillable = ['po_no', 'po_type', 'date', 'supplier_id', 'indent_id', 'cs_no', 'remarks', 'is_closed', 'delivery_location', 'created_by', 'branch_id'];

    protected $guarded = [];

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

	public function cs()
	{
		return $this->hasOne(Cs::class, 'cs_no', 'cs_no');
	}
}
