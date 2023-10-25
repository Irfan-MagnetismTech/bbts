<?php

namespace Modules\SCM\Services;

use Modules\SCM\Entities\ScmWcr;
use Modules\SCM\Entities\ScmWcrLine;
use Modules\SCM\Entities\StockLedger;

class GetTypeNo
{
    public static function receiveTypeWiseList($received_type = null, $material_id = null, $brand_id = null,  $branch_id = null)
    {
        $received_type = $received_type ?? request()->received_type;
        $material_id = $material_id ?? request()->material_id;
        $brand_id = $brand_id ?? request()->brand_id;
        $branch_id = $branch_id ?? request()->branch_id;

        $data = StockLedger::query()
            ->where('received_type', $received_type)
            ->when($material_id, function ($query) use ($material_id) {
                $query->where('material_id', $material_id);
            })
            ->when($brand_id, function ($query) use ($brand_id) {
                $query->where('brand_id', $brand_id);
            })
            ->when($branch_id, function ($query) use ($branch_id) {
                $query->where('branch_id', $branch_id);
            })
            ->get()
            ->unique('stockable_id')
            ->map(function ($item) use ($received_type, $branch_id) {
                $total_stock = StockLedger::query()
                    ->where('stockable_id', $item->stockable_id)
                    ->where('stockable_type', $item->stockable_type)
                    ->where('received_type', $received_type)
                    ->where('branch_id', $branch_id)
                    ->where('material_id', $item->material_id)
                    ->where('brand_id', $item->brand_id)
                    ->sum('quantity');
                $out_stock = StockLedger::query()
                    ->where('receiveable_id', $item->stockable_id)
                    ->where('stockable_type', $item->stockable_type)
                    ->where('received_type', $received_type)
                    ->where('branch_id', $branch_id)
                    ->where('material_id', $item->material_id)
                    ->where('brand_id', $item->brand_id)
                    ->where('quantity', '<', 0)
                    ->sum('quantity');
                if (($total_stock - $out_stock) >= 0) {
                    if ($item->stockable->mrr_no) {
                        return [
                            'id' => $item->stockable_id,
                            'type_no' => $item->stockable->mrr_no,
                        ];
                    }
                }
            })
            ->values();
        $data = array_filter($data->toArray());
        if (request()->material_id) {
            return response()->json($data);
        } else {
            return $data;
        }
    }
}
