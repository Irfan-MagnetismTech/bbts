<?php

namespace Modules\SCM\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Modules\Admin\Entities\Branch;
use Modules\Admin\Entities\Brand;
use Illuminate\Routing\Controller;
use Modules\SCM\Entities\Material;
use Modules\SCM\Entities\StockLedger;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Http\Request;

class ScmReportController extends Controller
{
    use HasRoles;

    function __construct()
    {
        $this->middleware('permission:material-view|material-create|material-edit|material-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:material-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:material-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:material-delete', ['only' => ['destroy']]);
    }

//    public function materialStockReport(Request $request)
//    {
//        $branches = Branch::get();
//        $stockTypes = [
//            'Modules\SCM\Entities\ScmMrr',
//            'Modules\SCM\Entities\ScmErr',
//            'Modules\SCM\Entities\ScmChallan',
//            'Modules\SCM\Entities\ScmMir',
//        ];
//        $branch_id = $request->branch_id;
//        if ($branch_id==null)
//        {
//            $stocks = StockLedger::whereIn('stockable_type', $stockTypes)
//                ->join('materials', 'stock_ledgers.material_id', '=', 'materials.id')
//                ->select('materials.name', 'materials.unit', 'stock_ledgers.brand_id', 'stock_ledgers.model', 'stock_ledgers.quantity')
//                ->orderBy('stock_ledgers.created_at', 'desc')
//                ->get();
//        }
//        else {
//            $stocks = StockLedger::whereIn('stockable_type', $stockTypes)
//                ->join('materials', 'stock_ledgers.material_id', '=', 'materials.id')
//                ->select('materials.name', 'materials.unit', 'stock_ledgers.brand_id', 'stock_ledgers.model', 'stock_ledgers.quantity')
//                ->orderBy('stock_ledgers.created_at', 'desc')
//                ->where('branch_id', $branch_id)
//                ->get();
//        }
//
//        // Group the stocks by material and calculate total stock for each material
//        $groupedStocks = $stocks->groupBy('name')->map(function ($items) {
//            $positiveTotal = $items->filter(function ($value) {
//                return $value->quantity > 0;
//            })->sum('quantity');
//
//            $negativeTotal = $items->filter(function ($value) {
//                return $value->quantity < 0;
//            })->sum('quantity');
//
//            $quantityStock = $positiveTotal - $negativeTotal;
//
//            return [
//                'name' => $items[0]->name,
//                'unit' => $items[0]->unit,
//                'brand' => $items[0]->brand->name,
//                'model' => $items[0]->model,
//                'quantity' => $quantityStock
//            ];
//        });
//        return view('scm::reports.material_report', compact('groupedStocks','branches','branch_id'));
//    }


    public function materialStockReport(Request $request)
    {
        $branches = Branch::get();
        $stockTypes = [
            'Modules\SCM\Entities\ScmMrr',
            'Modules\SCM\Entities\ScmErr',
            'Modules\SCM\Entities\ScmChallan',
            'Modules\SCM\Entities\ScmMir',
        ];
        $branch_id = $request->branch_id;

        if ($branch_id == null) {
            $stocks = StockLedger::whereIn('stockable_type', $stockTypes)
                ->join('materials', 'stock_ledgers.material_id', '=', 'materials.id')
                ->select('materials.name', 'materials.unit', 'stock_ledgers.brand_id', 'stock_ledgers.model', 'stock_ledgers.quantity')
                ->orderBy('stock_ledgers.created_at', 'desc')
                ->get();
        } else {
            $stocks = StockLedger::whereIn('stockable_type', $stockTypes)
                ->join('materials', 'stock_ledgers.material_id', '=', 'materials.id')
                ->select('materials.name', 'materials.unit', 'stock_ledgers.brand_id', 'stock_ledgers.model', 'stock_ledgers.quantity')
                ->orderBy('stock_ledgers.created_at', 'desc')
                ->where('branch_id', $branch_id)
                ->get();
        }

        $groupedStocks = $stocks->groupBy(function ($item) {
            return $item->name;
        })->map(function ($items) {
            return $items->groupBy('brand_id')->map(function ($item) {
                $positiveTotal = $item->filter(function ($value) {
                    return $value->quantity > 0;
                })->sum('quantity');

                $negativeTotal = $item->filter(function ($value) {
                    return $value->quantity < 0;
                })->sum('quantity');
                $quantityStock = $positiveTotal - $negativeTotal;
                return [
                    'name' => $item[0]->name,
                    'unit' => $item[0]->unit,
                    'brand' => $item[0]->brand->name,
                    'model' => $item[0]->model,
                    'quantity' => $quantityStock
                ];
            });
        });

        return view('scm::reports.material_report', compact('groupedStocks', 'branches', 'branch_id'));
    }

}



