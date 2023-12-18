<?php

namespace Modules\SCM\Http\Controllers;

use Carbon\Carbon;
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
                            'name' => $modelItems[0]->material->name ?? '',
                            'unit' => $modelItems[0]->material->unit ?? '',
                            'brand' => $modelItems[0]->brand->name ?? '',
                            'model' => $modelItems[0]->model ?? '',
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
                            'name' => $modelItems[0]->material->name ?? '',
                            'unit' => $modelItems[0]->material->unit ?? '',
                            'brand' => $modelItems[0]->brand->name ?? '',
                            'model' => $modelItems[0]->model ?? '',
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
        $openingStocks=[];
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        if ($from_date != null && $to_date != null)
        {
            $from_date = Carbon::createFromFormat('d-m-Y', $request->from_date)->format('Y-m-d');
            $to_date = Carbon::createFromFormat('d-m-Y', $request->to_date)->format('Y-m-d');
        }
        $branch_id = $request->branch_id;

        if ($request->type === 'pdf') {
            $stockTypes = [
                ScmMrr::class, ScmErr::class, ScmMir::class, OpeningStock::class, ScmMur::class
            ];
            if ($branch_id == null && $from_date == null && $to_date == null) {
                $stocks = StockLedger::whereIn('stockable_type', $stockTypes)
                    ->select('stock_ledgers.material_id', 'stock_ledgers.quantity', 'stock_ledgers.stockable_type')
                    ->orderBy('stock_ledgers.created_at', 'desc')
                    ->get();
            }else if ($branch_id != null && $from_date == null && $to_date == null){
                $stocks = StockLedger::whereIn('stockable_type', $stockTypes)
                    ->select('stock_ledgers.material_id', 'stock_ledgers.quantity', 'stock_ledgers.stockable_type')
                    ->orderBy('stock_ledgers.created_at', 'desc')
                    ->where('branch_id', $branch_id)
                    ->get();
            }else if ($branch_id != null && $from_date != null && $to_date != null){
                $stocks = StockLedger::whereIn('stockable_type', $stockTypes)
                    ->where('branch_id', $branch_id)
                    ->whereBetween('date', [$from_date, $to_date])
                    ->select('stock_ledgers.material_id', 'stock_ledgers.quantity', 'stock_ledgers.stockable_type')
                    ->orderBy('stock_ledgers.created_at', 'desc')
                    ->get();

                $previousStocks = StockLedger::whereIn('stockable_type', $stockTypes)
                    ->where('branch_id', $branch_id)
                    ->where('date', '<', $from_date)
                    ->select('stock_ledgers.material_id', 'stock_ledgers.quantity', 'stock_ledgers.stockable_type')
                    ->orderBy('stock_ledgers.created_at', 'desc')
                    ->get();

                $combinedStocks = $stocks->concat($previousStocks);

                $openingStocks = $combinedStocks->groupBy('material_id')->map(function ($items) use ($stockTypes) {
                    $totalQuantity = $items->sum('quantity');
                    $result = [
                        'material_id' => $items[0]->material->name,
                        'unit' => $items[0]->material->unit,
                        'total' => $totalQuantity,
                    ];

                    foreach ($stockTypes as $stockType) {
                        if ($stockType === OpeningStock::class) {
                            $typeItems = $items->where('stockable_type', $stockType)->sum('quantity');
                            $result[Str::snake(class_basename($stockType)) . '_qty'] = $typeItems;
                        }
                    }
                    return $result;
                });
            }else if ($branch_id == null && $from_date != null && $to_date != null){
                $stocks = StockLedger::whereIn('stockable_type', $stockTypes)
                    ->whereBetween('date', [$from_date, $to_date])
                    ->select('stock_ledgers.material_id', 'stock_ledgers.quantity', 'stock_ledgers.stockable_type')
                    ->orderBy('stock_ledgers.created_at', 'desc')
                    ->get();

                $previousStocks = StockLedger::whereIn('stockable_type', $stockTypes)
                    ->where('date', '<', $from_date)
                    ->select('stock_ledgers.material_id', 'stock_ledgers.quantity', 'stock_ledgers.stockable_type')
                    ->orderBy('stock_ledgers.created_at', 'desc')
                    ->get();

                $combinedStocks = $stocks->concat($previousStocks);

                $openingStocks = $combinedStocks->groupBy('material_id')->map(function ($items) use ($stockTypes) {
                    $totalQuantity = $items->sum('quantity');
                    $result = [
                        'material_id' => $items[0]->material->name,
                        'unit' => $items[0]->material->unit,
                        'total' => $totalQuantity,
                    ];

                    foreach ($stockTypes as $stockType) {
                        if ($stockType === OpeningStock::class) {
                            $typeItems = $items->where('stockable_type', $stockType)->sum('quantity');
                            $result[Str::snake(class_basename($stockType)) . '_qty'] = $typeItems;
                        }
                    }
                    return $result;
                });
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
            $from_date = $request->from_date;
            $to_date = $request->to_date;
            return PDF::loadView('scm::reports.scm_pdf', ['groupedStocks' => $groupedStocks, 'openingStocks' => $openingStocks, 'branch_id' => $branch_id, 'from_date' => $from_date, 'to_date' => $to_date], [], [
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
            return view('scm::reports.scm_pdf', compact('groupedStocks','openingStocks', 'branch_id','from_date','to_date'));
        } else {
            $branch_id = $request->branch_id;
            $branches = Branch::get();

            $stockTypes = [
                ScmMrr::class, ScmErr::class, ScmMir::class, OpeningStock::class, ScmMur::class
            ];
            if ($branch_id == null && $from_date == null && $to_date == null) {
                $stocks = StockLedger::whereIn('stockable_type', $stockTypes)
                    ->select('stock_ledgers.material_id', 'stock_ledgers.quantity', 'stock_ledgers.stockable_type')
                    ->orderBy('stock_ledgers.created_at', 'desc')
                    ->get();
            }else if ($branch_id != null && $from_date == null && $to_date == null){
                $stocks = StockLedger::whereIn('stockable_type', $stockTypes)
                    ->where('branch_id', $branch_id)
                    ->select('stock_ledgers.material_id', 'stock_ledgers.quantity', 'stock_ledgers.stockable_type')
                    ->orderBy('stock_ledgers.created_at', 'desc')
                    ->get();
            }else if ($branch_id != null && $from_date != null && $to_date != null){
                $stocks = StockLedger::whereIn('stockable_type', $stockTypes)
                    ->where('branch_id', $branch_id)
                    ->whereBetween('date', [$from_date, $to_date])
                    ->select('stock_ledgers.material_id', 'stock_ledgers.quantity', 'stock_ledgers.stockable_type')
                    ->orderBy('stock_ledgers.created_at', 'desc')
                    ->get();

                $previousStocks = StockLedger::whereIn('stockable_type', $stockTypes)
                    ->where('branch_id', $branch_id)
                    ->where('date', '<', $from_date)
                    ->select('stock_ledgers.material_id', 'stock_ledgers.quantity', 'stock_ledgers.stockable_type')
                    ->orderBy('stock_ledgers.created_at', 'desc')
                    ->get();

                $combinedStocks = $stocks->concat($previousStocks);

                $openingStocks = $combinedStocks->groupBy('material_id')->map(function ($items) use ($stockTypes) {
                    $totalQuantity = $items->sum('quantity');
                    $result = [
                        'material_id' => $items[0]->material->name,
                        'unit' => $items[0]->material->unit,
                        'total' => $totalQuantity,
                    ];

                    foreach ($stockTypes as $stockType) {
                        if ($stockType === OpeningStock::class) {
                            $typeItems = $items->where('stockable_type', $stockType)->sum('quantity');
                            $result[Str::snake(class_basename($stockType)) . '_qty'] = $typeItems;
                        }
                    }
                    return $result;
                });
            }else if ($branch_id == null && $from_date != null && $to_date != null){
                $stocks = StockLedger::whereIn('stockable_type', $stockTypes)
                    ->whereBetween('date', [$from_date, $to_date])
                    ->select('stock_ledgers.material_id', 'stock_ledgers.quantity', 'stock_ledgers.stockable_type')
                    ->orderBy('stock_ledgers.created_at', 'desc')
                    ->get();

                $previousStocks = StockLedger::whereIn('stockable_type', $stockTypes)
                    ->where('date', '<', $from_date)
                    ->select('stock_ledgers.material_id', 'stock_ledgers.quantity', 'stock_ledgers.stockable_type')
                    ->orderBy('stock_ledgers.created_at', 'desc')
                    ->get();

                $combinedStocks = $stocks->concat($previousStocks);

                $openingStocks = $combinedStocks->groupBy('material_id')->map(function ($items) use ($stockTypes) {
                    $totalQuantity = $items->sum('quantity');
                    $result = [
                        'material_id' => $items[0]->material->name,
                        'unit' => $items[0]->material->unit,
                        'total' => $totalQuantity,
                    ];

                    foreach ($stockTypes as $stockType) {
                        if ($stockType === OpeningStock::class) {
                            $typeItems = $items->where('stockable_type', $stockType)->sum('quantity');
                            $result[Str::snake(class_basename($stockType)) . '_qty'] = $typeItems;
                        }
                    }
                    return $result;
                });
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
            $from_date = $request->from_date;
            $to_date = $request->to_date;
            return view('scm::reports.scm_report', compact('groupedStocks', 'openingStocks','branches', 'branch_id','from_date','to_date'));
        }
    }

    public function scmItemReport(Request $request)
    {
        $branch_id = $request->branch_id;
        $material_id = $request->material_id;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        if ($from_date != null && $to_date != null)
        {
            $from_date = Carbon::createFromFormat('d-m-Y', $request->from_date)->format('Y-m-d');
            $to_date = Carbon::createFromFormat('d-m-Y', $request->to_date)->format('Y-m-d');
        }
        $stockItems=[];
        if ($request->type === 'pdf') {
            if ($branch_id == null && $material_id == null && $from_date == null && $to_date == null) {
                $stockItems = StockLedger::orderBy('stock_ledgers.created_at', 'desc')->get();

            }elseif ($branch_id == null && $material_id != null && $from_date == null && $to_date == null){
                $stockItems = StockLedger::orderBy('stock_ledgers.created_at', 'desc')
                    ->where('material_id', $material_id)
                    ->get();
            }elseif ($branch_id != null && $material_id == null && $from_date == null && $to_date == null){
                $stockItems = StockLedger::orderBy('stock_ledgers.created_at', 'desc')
                    ->where('branch_id', $branch_id)
                    ->get();
            }elseif ($branch_id != null && $material_id != null && $from_date != null && $to_date != null){
                $stockItems = StockLedger::orderBy('stock_ledgers.created_at', 'desc')
                    ->where('branch_id', $branch_id)
                    ->where('material_id', $material_id)
                    ->whereBetween('date', [$from_date, $to_date])
                    ->get();

            }elseif ($branch_id == null && $material_id == null && $from_date != null && $to_date != null){
                $stockItems = StockLedger::orderBy('stock_ledgers.created_at', 'desc')
                    ->whereBetween('date', [$from_date, $to_date])
                    ->get();
            }
            $stocks = $stockItems->map(function ($stock) {
                return [
                    'date' => $stock->date ?? '',
                    'branch' => $stock->branch->name ?? '',
                    'name' => $stock->material->name ?? '',
                    'unit' => $stock->material->unit ?? '',
                    'brand' => $stock->brand->name ?? '',
                    'model' => $stock->model ?? '',
                    'type' => $stock->stockable_type ?? '',
                    'quantity' => $stock->quantity ?? '',
                    'rate' => $stock->unit_price ?? '',
                    'serial' => $stock->serial_code ?? '',
                    'client' => $stock->stockable->client->client_name ?? '',
                    'client_no' => $stock->stockable->client->client_no ?? '',
                    'location' => $stock->stockable->client->feasibilityRequirementDetail->connectivity_point ?? '',
                    'challan_no' => $stock->stockable->challan_no ?? '',
                    'issue_purpose' => $stock->stockable->purpose ?? '',
                    'to_branch' => $stock->stockable->toBranch->name ?? '',
                    'invoice_no' => $stock->stockable->bill_reg_no ?? '',
                    'indent_no' => $stock->stockable->purchaseOrder->indent->indent_no ?? '',
                    'po_no' => $stock->stockable->purchaseOrder->po_no ?? '',
                    'supplier' => $stock->stockable->purchaseOrder->supplier->name ?? '',
                    'prs_no' => $stock->stockable->purchaseOrder->scmPurchaseRequisition->prs_no ?? '',
                ];
            })->toArray();


            return PDF::loadView('scm::reports.item_report_pdf', ['stocks' => $stocks, 'branch_id' => $branch_id, 'material_id' => $material_id, 'from_date' => $from_date, 'to_date' => $to_date], [], [
                'format' => 'A4',
                'orientation' => 'L',
                'title' => 'Item Report PDF',
                'watermark' => 'BBTS',
                'show_watermark' => true,
                'watermark_text_alpha' => 0.1,
                'watermark_image_path' => '',
                'watermark_image_alpha' => 0.2,
                'watermark_image_size' => 'D',
                'watermark_image_position' => 'P',
            ])->stream('item_report.pdf');
            return view('scm::reports.item_report_pdf', compact('stocks', 'branch_id','material_id','from_date','to_date'));
        } else {
            $branches = Branch::get();
            $materials = Material::get();

            if ($branch_id == null && $material_id == null && $from_date == null && $to_date == null) {
                $stockItems = StockLedger::orderBy('stock_ledgers.created_at', 'desc')
                    ->get();

            }elseif ($branch_id == null && $material_id != null && $from_date == null && $to_date == null){
                    $stockItems = StockLedger::orderBy('stock_ledgers.created_at', 'desc')
                        ->where('material_id', $material_id)
                        ->get();
            }elseif ($branch_id != null && $material_id == null && $from_date == null && $to_date == null){
                $stockItems = StockLedger::orderBy('stock_ledgers.created_at', 'desc')
                    ->where('branch_id', $branch_id)
                    ->get();
            }elseif ($branch_id != null && $material_id != null && $from_date != null && $to_date != null){
                $stockItems = StockLedger::orderBy('stock_ledgers.created_at', 'desc')
                    ->where('branch_id', $branch_id)
                    ->where('material_id', $material_id)
                    ->whereBetween('date', [$from_date, $to_date])
                    ->get();

            }elseif ($branch_id == null && $material_id == null && $from_date != null && $to_date != null){
                $stockItems = StockLedger::orderBy('stock_ledgers.created_at', 'desc')
                    ->whereBetween('date', [$from_date, $to_date])
                    ->get();
            }
            $stocks = $stockItems->map(function ($stock) {
                return [
                    'date' => $stock->date ?? '',
                    'branch' => $stock->branch->name ?? '',
                    'name' => $stock->material->name ?? '',
                    'unit' => $stock->material->unit ?? '',
                    'brand' => $stock->brand->name ?? '',
                    'model' => $stock->model ?? '',
                    'type' => $stock->stockable_type ?? '',
                    'quantity' => $stock->quantity ?? '',
                    'rate' => $stock->unit_price ?? '',
                    'serial' => $stock->serial_code ?? '',
                    'client' => $stock->stockable->client->client_name ?? '',
                    'client_no' => $stock->stockable->client->client_no ?? '',
                    'location' => $stock->stockable->client->feasibilityRequirementDetail->connectivity_point ?? '',
                    'challan_no' => $stock->stockable->challan_no ?? '',
                    'issue_purpose' => $stock->stockable->purpose ?? '',
                    'to_branch' => $stock->stockable->toBranch->name ?? '',
                    'invoice_no' => $stock->stockable->bill_reg_no ?? '',
                    'indent_no' => $stock->stockable->purchaseOrder->indent->indent_no ?? '',
                    'po_no' => $stock->stockable->purchaseOrder->po_no ?? '',
                    'supplier' => $stock->stockable->purchaseOrder->supplier->name ?? '',
                    'prs_no' => $stock->stockable->purchaseOrder->scmPurchaseRequisition->prs_no ?? '',
                ];
            })->toArray();

            $from_date = $request->from_date;
            $to_date = $request->to_date;
            return view('scm::reports.item_report', compact('stocks', 'materials','branches', 'branch_id', 'material_id','from_date','to_date'));
        }
    }
}
