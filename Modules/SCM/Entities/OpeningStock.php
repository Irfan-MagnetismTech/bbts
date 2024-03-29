<?php

namespace Modules\SCM\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Admin\Entities\Branch;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\SCM\Http\Traits\StockLedgerTrait;


class OpeningStock extends Model
{
    use StockLedgerTrait;
    protected $guarded = [];

    protected $fillable = ['date','branch_id'];

    /**
     * @param $input
     */
    public function getDateAttribute($input)
    {
        return Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y');
    }

    /**
     * @param $input
     */
    public function setDateAttribute($input)
    {
        !empty($input) ? $this->attributes['date'] = Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }

    public function lines():HasMany
    {
        return $this->hasMany(OpeningStockLine::class,'opening_stock_id','id');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class,'branch_id','id');
    }
}
