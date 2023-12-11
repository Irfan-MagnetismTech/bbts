<?php

namespace Modules\SCM\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\SCM\Entities\ScmMur;
use PDF;
use Illuminate\Validation\ValidationException;
use Modules\Admin\Entities\Branch;
use Modules\Admin\Entities\Brand;
use Illuminate\Routing\Controller;
use Modules\SCM\Entities\Material;
use Modules\SCM\Entities\ScmChallan;
use Modules\SCM\Entities\ScmMir;
use Modules\SCM\Entities\StockLedger;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Http\Request;
use Modules\SCM\Entities\OpeningStock;
use Modules\SCM\Entities\ScmErr;
use Modules\SCM\Entities\ScmMrr;

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

    public function materialStockReport(Request $request)
    {
        $branch_id = $request->branch_id;
        if ($request->type === 'pdf') {
            $stockTypes = [
                ScmMrr::class, ScmErr::class, ScmChallan::class, ScmMir::class, OpeningStock::class
            ];

            if ($branch_id == null) {
                $stocks = StockLedger::whereIn('stockable_type', $stockTypes)
                    ->select('stock_ledgers.material_id', 'stock_ledgers.brand_id', 'stock_ledgers.model', 'stock_ledgers.quantity')
                    ->orderBy('stock_ledgers.created_at', 'desc')
                    ->get();
            } else {
                $stocks = StockLedger::whereIn('stockable_type', $stockTypes)
                    ->select('stock_ledgers.material_id', 'stock_ledgers.brand_id', 'stock_ledgers.model', 'stock_ledgers.quantity')
                    ->orderBy('stock_ledgers.created_at', 'desc')
                    ->where('branch_id', $branch_id)
                    ->get();
            }

            $groupedStocks = $stocks->groupBy(function ($item) {
                return $item->material_id;
            })->map(function ($items) {
                return $items->groupBy('brand_id')->map(function ($brandItems) {
                    return $brandItems->groupBy('model')->map(function ($modelItems) {
                        $quantityStock = $modelItems->filter(function ($value) {
                            return $value->quantity;
                        })->sum('quantity');

                        return [
                            'name' => $modelItems[0]->material->name,
                            'unit' => $modelItems[0]->material->unit,
                            'brand' => $modelItems[0]->brand->name,
                            'model' => $modelItems[0]->model,
                            'quantity' => $quantityStock
                        ];
                    });
                });
            });

            return PDF::loadView('scm::reports.material_stock_pdf', ['groupedStocks' => $groupedStocks, 'branch_id' => $branch_id], [], [
                'format' => 'A4',
                'orientation' => 'L',
                'title' => 'Material Stock PDF',
                'watermark' => 'BBTS',
                'show_watermark' => true,
                'watermark_text_alpha' => 0.1,
                'watermark_image_path' => '',
                'watermark_image_alpha' => 0.2,
                'watermark_image_size' => 'D',
                'watermark_image_position' => 'P',
            ])->stream('material_stock.pdf');
            return view('scm::reports.material_stock_pdf', compact('groupedStocks', 'branch_id'));
        } else {
            $branches = Branch::get();
            $stockTypes = [
                ScmMrr::class, ScmErr::class, ScmChallan::class, ScmMir::class, OpeningStock::class
            ];
            $branch_id = $request->branch_id;

            if ($branch_id == null) {
                $stocks = StockLedger::whereIn('stockable_type', $stockTypes)
                    ->select('stock_ledgers.material_id', 'stock_ledgers.brand_id', 'stock_ledgers.model', 'stock_ledgers.quantity')
                    ->orderBy('stock_ledgers.created_at', 'desc')
                    ->get();
            } else {
                $stocks = StockLedger::whereIn('stockable_type', $stockTypes)
                    ->select('stock_ledgers.material_id', 'stock_ledgers.brand_id', 'stock_ledgers.model', 'stock_ledgers.quantity')
                    ->orderBy('stock_ledgers.created_at', 'desc')
                    ->where('branch_id', $branch_id)
                    ->get();
            }

            $groupedStocks = $stocks->groupBy(function ($item) {
                return $item->material_id;
            })->map(function ($items) {
                return $items->groupBy('brand_id')->map(function ($brandItems) {
                    return $brandItems->groupBy('model')->map(function ($modelItems) {
                        $quantityStock = $modelItems->filter(function ($value) {
                            return $value->quantity;
                        })->sum('quantity');

                        return [
                            'name' => $modelItems[0]->material->name,
                            'unit' => $modelItems[0]->material->unit,
                            'brand' => $modelItems[0]->brand->name,
                            'model' => $modelItems[0]->model,
                            'quantity' => $quantityStock
                        ];
                    });
                });
            });
            return view('scm::reports.material_stock_report', compact('groupedStocks', 'branches', 'branch_id'));
        }
    }

    public function scmReport(Request $request)
    {
        $branch_id = $request->branch_id;
        if ($request->type === 'pdf') {
            $stockTypes = [
                ScmMrr::class, ScmErr::class, ScmMir::class, OpeningStock::class, ScmMur::class
            ];
            if ($branch_id == null) {
                $stocks = StockLedger::whereIn('stockable_type', $stockTypes)
                    ->select('stock_ledgers.material_id', 'stock_ledgers.quantity', 'stock_ledgers.stockable_type')
                    ->orderBy('stock_ledgers.created_at', 'desc')
                    ->get();
            }else{
                $stocks = StockLedger::whereIn('stockable_type', $stockTypes)
                    ->select('stock_ledgers.material_id', 'stock_ledgers.quantity', 'stock_ledgers.stockable_type')
                    ->orderBy('stock_ledgers.created_at', 'desc')
                    ->where('branch_id', $branch_id)
                    ->get();
            }
            $groupedStocks = $stocks->groupBy('material_id')->map(function ($items) use ($stockTypes) {
                $totalQuantity = $items->sum('quantity');
                $result = [
                    'material_id' => $items[0]->material->name,
                    'unit' => $items[0]->material->unit,
                    'total' => $totalQuantity,
                ];

                foreach ($stockTypes as $stockType) {
                    if ($stockType === ScmMir::class) {
                        $mirQuantity = $items->where('stockable_type', $stockType)
                            ->where('quantity', '<', 0)
                            ->sum('quantity');

                        $transferQuantity = $items->where('stockable_type', $stockType)
                            ->where('quantity', '>', 0)
                            ->sum('quantity');

                        $result['scm_mir_qty'] = $mirQuantity;
                        $result['transfer_qty'] = $transferQuantity;
                    } else {
                        $typeItems = $items->where('stockable_type', $stockType)->sum('quantity');
                        $result[Str::snake(class_basename($stockType)) . '_qty'] = $typeItems;
                    }
                }
                return $result;
            });

            return PDF::loadView('scm::reports.scm_pdf', ['groupedStocks' => $groupedStocks, 'branch_id' => $branch_id], [], [
                'format' => 'A4',
                'orientation' => 'L',
                'title' => 'SCM PDF',
                'watermark' => 'BBTS',
                'show_watermark' => true,
                'watermark_text_alpha' => 0.1,
                'watermark_image_path' => '',
                'watermark_image_alpha' => 0.2,
                'watermark_image_size' => 'D',
                'watermark_image_position' => 'P',
            ])->stream('scm.pdf');
            return view('scm::reports.scm_pdf', compact('groupedStocks', 'branch_id'));
        } else {
            $branch_id = $request->branch_id;
            $branches = Branch::get();

            $stockTypes = [
                ScmMrr::class, ScmErr::class, ScmMir::class, OpeningStock::class, ScmMur::class
            ];
            if ($branch_id == null) {
                $stocks = StockLedger::whereIn('stockable_type', $stockTypes)
                    ->select('stock_ledgers.material_id', 'stock_ledgers.quantity', 'stock_ledgers.stockable_type')
                    ->orderBy('stock_ledgers.created_at', 'desc')
                    ->get();
            }else{
                $stocks = StockLedger::whereIn('stockable_type', $stockTypes)
                    ->select('stock_ledgers.material_id', 'stock_ledgers.quantity', 'stock_ledgers.stockable_type')
                    ->orderBy('stock_ledgers.created_at', 'desc')
                    ->where('branch_id', $branch_id)
                    ->get();
            }
            $groupedStocks = $stocks->groupBy('material_id')->map(function ($items) use ($stockTypes) {
                $totalQuantity = $items->sum('quantity');
                $result = [
                    'material_id' => $items[0]->material->name,
                    'unit' => $items[0]->material->unit,
                    'total' => $totalQuantity,
                ];

                foreach ($stockTypes as $stockType) {
                    if ($stockType === ScmMir::class) {
                        $mirQuantity = $items->where('stockable_type', $stockType)
                            ->where('quantity', '<', 0)
                            ->sum('quantity');

                        $transferQuantity = $items->where('stockable_type', $stockType)
                            ->where('quantity', '>', 0)
                            ->sum('quantity');

                        $result['scm_mir_qty'] = $mirQuantity;
                        $result['transfer_qty'] = $transferQuantity;
                    } else {
                        $typeItems = $items->where('stockable_type', $stockType)->sum('quantity');
                        $result[Str::snake(class_basename($stockType)) . '_qty'] = $typeItems;
                    }
                }
                return $result;
            });
            return view('scm::reports.scm_report', compact('groupedStocks', 'branches', 'branch_id'));
        }
    }
}
