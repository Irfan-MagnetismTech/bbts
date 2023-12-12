<?php

namespace Modules\SCM\Entities;

use Carbon\Carbon;
use Modules\Admin\Entities\Brand;
use Modules\SCM\Entities\Material;
use Illuminate\Database\Eloquent\Model;
use Modules\SCM\Entities\FiberTracking;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class StockLedger extends Model
{
    protected $guarded = [];

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
    
    public function stockable()
    {
        return $this->morphTo();
    }

    public function receiveable()
    {
        return $this->morphTo('receiveable', 'receiveable_type', 'receiveable_id');
    }

    public function fiberTracking()
    {
        return $this->hasMany(FiberTracking::class, 'serial_code', 'serial_code');
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Query the stock quantity of a specific item at a specific branch
     *
     * @param Builder $query Query builder instance
     * @param int $branch_id ID of the branch to query
     * @param stdClass $item Received item information to query for
     * @return int Total quantity of the received item at the branch
     */
    public function scopeBranchStock($query, $branch_id, $item): int
    {
        return $query->where([
            'material_id' => $item->material_id,
            'received_type' => $item->received_type,
            'receiveable_id' => $item->receiveable_id,
            'branch_id' => $branch_id
        ])
            ->when($item->brand_id, function ($query) use ($item) {
                return $query->where('brand_id', $item->brand_id);
            })
            ->when($item->model, function ($query) use ($item) {
                return $query->where('model', $item->model);
            })
            ->sum('quantity');
    }

    /**
     * Query and return a unique dropdown data list based on the provided parameters.
     *
     * @param Builder $query Query builder instance.
     * @param string $uniqueKey Unique key to filter distinct data in the list.
     * @param stdClass $material_issue Material issue instance.
     * @param bool $brand Whether to filter by brand or not.
     * @param bool $model Whether to filter by model or not.
     * @param stdClass $item Received item information to query for.
     * @return Collection Unique filtered list of data for dropdown.
     */
    public function scopeDropdownDataList($query, $uniqueKey, $material_issue, $brand, $model, $item): Collection
    {
        return $query->where([
            'material_id' => $item->material_id,
            // 'receiveable_id' => $item->receiveable_id,
            // 'receiveable_type' => $item->receiveable_type,
            'branch_id' => $material_issue->branch_id,
        ])
            ->when($brand, function ($query3) use ($item) {
                return $query3->where('brand_id', $item->brand_id);
            })
            ->when($model, function ($query2) use ($item) {
                return $query2->where('model', $item->model);
            })
            ->get()
            ->unique($uniqueKey)
            ->values();
    }

    public function scopeDropdownDataListForChallan($query, $uniqueKey, $material, $brand, $model, $item): Collection
    {
        return $query->when($material, function ($query4) use ($item) {
            return $query4->where('material_id', $item->material_id);
        })
            ->when($brand, function ($query3) use ($item) {
                return $query3->where('brand_id', $item->brand_id);
            })
            ->when($model, function ($query2) use ($item) {
                return $query2->where('model', $item->model);
            })
            ->get()
            ->unique($uniqueKey)
            ->values();
    }

    public function scopeBranchStockForChallan($query, $branch_id, $item): int
    {
        return $query->where([
            'material_id' => $item->material_id,
            'received_type' => $item->received_type,
            'receiveable_id' => $item->receiveable_id,
            'branch_id' => $branch_id
        ])
            ->sum('quantity');
    }

    public function scopeStockIn($query, $branch_id, $received_type, $item): int
    {
        return $query->where([
            'material_id' => $item->material_id,
            'received_type' => $received_type,
            'stockable_id' => $item->receiveable_id,
            'branch_id' => $branch_id
        ])->sum('quantity');
    }

    public function scopeStockOut($query, $branch_id, $received_type, $item): int
    {
        return $query->where([
            'material_id' => $item->material_id,
            'received_type' => $received_type,
            'receiveable_id' => $item->receiveable_id,
            'branch_id' => $branch_id
        ])->sum('quantity');
    }
}
