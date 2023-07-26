<?php

namespace Modules\SCM\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Modules\SCM\Entities\ScmErr;
use Modules\SCM\Entities\ScmMrr;
use Modules\SCM\Entities\ScmWcr;
use Illuminate\Http\JsonResponse;
use Modules\Admin\Entities\Brand;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\Branch;
use Modules\Sales\Entities\Client;
use App\Services\BbtsGlobalService;
use Modules\SCM\Entities\ScmChallan;
use Modules\SCM\Entities\ScmMrrLine;
use Modules\SCM\Entities\StockLedger;
use Modules\Sales\Entities\SaleDetail;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\QueryException;
use Modules\Sales\Entities\ClientDetail;
use Modules\SCM\Entities\ScmRequisition;
use Modules\Sales\Entities\SaleLinkDetail;
use Illuminate\Contracts\Support\Renderable;
use Modules\SCM\Entities\ScmRequisitionDetail;
use Modules\SCM\Entities\ScmWor;
use Modules\SCM\Http\Requests\ScmChallanRequest;

class ScmChallanController extends Controller
{
    private $ChallanNo;
    public function __construct(BbtsGlobalService $globalService)
    {
        $this->ChallanNo = $globalService->generateUniqueId(ScmChallan::class, 'Challan');
        $this->middleware('permission:scm-challan-view|scm-challan-create|scm-challan-edit|scm-challan-delete', ['only' => ['index', 'show', 'getCsPdf', 'getAllDetails', 'getMaterialSuppliersDetails', 'csApproved']]);
        $this->middleware('permission:scm-challan-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:scm-challan-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:scm-challan-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        session()->forget('physicalConnectivityEditUrl');
        $challans = ScmChallan::with('scmChallanLines')->latest()->get();
        return view('scm::challans.index', compact('challans'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $formType = "create";
        $brands = Brand::latest()->get();
        $branchs = Branch::latest()->get();
        return view('scm::challans.create', compact('formType', 'brands', 'branchs'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(ScmChallanRequest $request)
    {
        try {
            DB::beginTransaction();
            $challan_data = $request->only('type', 'date', 'scm_requisition_id', 'purpose', 'branch_id', 'client_no', 'pop_id', 'fr_composite_key', 'link_no', 'fr_no', 'equipment_type');
            $challan_data['challan_no'] =  $this->ChallanNo;
            $challan_data['created_by'] = auth()->id();

            $challan_details = [];
            foreach ($request->material_name as $kk => $val) {
                if (isset($request->serial_code[$kk]) && count($request->serial_code[$kk])) {
                    foreach ($request->serial_code[$kk] as $key => $value) {
                        $stock_ledgers[] = $this->GetStockLedgerData($request, $kk, $key);
                    };
                } elseif (isset($request->material_name[$kk])) {
                    $stock_ledgers[] = $this->GetStockLedgerData($request, $kk);
                }
                $challan_details[] = $this->GetMrrDetails($request, $kk);
            };

            $challan = ScmChallan::create($challan_data);
            $challan->scmChallanLines()->createMany($challan_details);
            $challan->stockable()->createMany($stock_ledgers);

            DB::commit();
            return redirect()->route('challans.index')->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('challans.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(ScmChallan $challan)
    {
        $branchs = Branch::latest()->get();
        $client_links = SaleLinkDetail::where('fr_no', $challan->fr_no)->pluck('link_no');
        $fr_no_list = SaleDetail::where('client_no', $challan->client_no)->pluck('fr_no');
        $materials = [];
        $brands = [];
        $models = [];
        $serial_codes = [];
        $branch_stock = [];
        $challan->scmChallanLines->each(function ($item, $key) use (&$materials, &$brands, &$models, &$serial_codes, $challan, &$branch_stock) {
            // $materials[$key] = Stockledger::with('material')->where([
            //     'receiveable_id' => $item->receiveable_id,
            //     'receiveable_type' => $item->receiveable_type
            // ])->get()
            //     ->unique('material_id')
            //     ->values();
            // $brands[$key] = Stockledger::with('brand')->where([
            //     'receiveable_id' => $item->receiveable_id,
            //     'receiveable_type' => $item->receiveable_type,
            //     'material_id' => $item->material_id
            // ])
            //     ->get()
            //     ->unique('brand_id')
            //     ->values();

            // $models[$key] = StockLedger::query()->where([
            //     'receiveable_id' => $item->receiveable_id,
            //     'receiveable_type' => $item->receiveable_type,
            //     'material_id' => $item->material_id,
            //     'brand_id' => $item->brand_id
            // ])
            //     ->get()
            //     ->unique('model')
            //     ->values();

            // $serial_codes[$key] = StockLedger::query()->where([
            //     'receiveable_id' => $item->receiveable_id,
            //     'receiveable_type' => $item->receiveable_type,
            //     'material_id' => $item->material_id,
            //     'brand_id' => $item->brand_id,
            //     'model' => $item->model,
            // ])
            //     ->get()
            //     ->unique('serial_code')
            //     ->values();;

            $materials[$key] = Stockledger::with('material')->dropdownDataListForChallan('material_id', $material = false, $brand = false, $modal = false, $item);

            $brands[$key] = Stockledger::with('brand')->dropdownDataListForChallan('brand_id', $material = true, $brand = false, $modal = false, $item);

            $models[$key] = Stockledger::dropdownDataListForChallan('model', $material = true, $brand = true, $modal = false, $item);

            $serial_codes[$key] = Stockledger::dropdownDataListForChallan('serial_code', $material = true, $brand = true, $modal = true, $item);

            // $branch_stock[] = StockLedger::query()
            //     ->where([
            //         'material_id' => $item->material_id,
            //         'received_type' => $item->received_type,
            //         'receiveable_id' => $item->receiveable_id,
            //         'branch_id' => $challan->branch_id,
            //     ])
            //     ->sum('quantity');

            $branch_stock[] = StockLedger::query()->branchStockForChallan($challan->branch_id, $item);
        });
        return view('scm::challans.create', compact('challan', 'brands', 'branchs', 'client_links', 'materials', 'models', 'serial_codes', 'branch_stock', 'fr_no_list'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(ScmChallanRequest $request, ScmChallan $challan)
    {
        try {
            DB::beginTransaction();
            $challan_data = $request->only('type', 'equipment_type', 'date', 'scm_requisition_id', 'purpose', 'branch_id', 'client_no', 'pop_id', 'link_no', 'fr_no');

            $challan_details = [];
            foreach ($request->material_name as $kk => $val) {
                if (isset($request->serial_code[$kk]) && count($request->serial_code[$kk])) {
                    foreach ($request->serial_code[$kk] as $key => $value) {
                        $stock_ledgers[] = $this->GetStockLedgerData($request, $kk, $key);
                    };
                } elseif (isset($request->material_name[$kk])) {
                    $stock_ledgers[] = $this->GetStockLedgerData($request, $kk);
                }
                $challan_details[] = $this->GetMrrDetails($request, $kk);
            };

            $challan->update($challan_data);
            $challan->scmChallanLines()->delete();
            $challan->scmChallanLines()->createMany($challan_details);
            $challan->stockable()->delete();
            $challan->stockable()->createMany($stock_ledgers);
            DB::commit();
            return redirect()->route('challans.index')->with('message', 'Data has been updated successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('challans.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(ScmChallan $challan)
    {
        try {
            DB::beginTransaction();
            $challan->stockable()->delete();
            $challan->delete();
            DB::commit();
            return redirect()->route('challans.index')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $err) {
            DB::rollBack();
            return redirect()->route('challans.index')->withInput()->withErrors($err->getMessage());
        }
    }

    public function GetStockLedgerData($req, $key1, $key2 = NULL)
    {
        return [
            'branch_id' => $req->branch_id,
            'material_id' => $req->material_name[$key1],
            'receiveable_type' => ($req->received_type[$key1] == 'MRR') ? ScmMrr::class : (($req->received_type[$key1] == 'WCR') ? ScmWcr::class : (($req->received_type[$key1] == 'ERR') ? ScmErr::class : (($req->received_type[$key1] == 'WOR') ? ScmWor::class : Null))),
            'received_type' => $req->received_type[$key1],
            'receiveable_id' => $req->type_id[$key1],
            'item_code' => $req->item_code[$key1],
            'unit' => $req->unit[$key1],
            'brand_id' => isset($req->brand[$key1]) ? $req->brand[$key1] : NULL,
            'model' => isset($req->model[$key1]) ? $req->model[$key1] : NULL,
            'serial_code' => (isset($req->serial_code[$key1]) && isset($req->serial_code[$key1][$key2])) ? $req->serial_code[$key1][$key2] : '',
            'quantity' =>  -1 * (isset($key2) ? (($req->material_type[$key1] == "Drum") ? $req->quantity[$key1] : 1) : $req->quantity[$key1]),
        ];
    }

    public function GetMrrDetails($req, $key1)
    {
        return  [
            'receiveable_type' => ($req->received_type[$key1] == 'MRR') ? ScmMrr::class : (($req->received_type[$key1] == 'WCR') ? ScmWcr::class : (($req->received_type[$key1] == 'ERR') ? ScmErr::class : (($req->received_type[$key1] == 'WOR') ? ScmWor::class : NULL))),
            'receiveable_id' => $req->type_id[$key1],
            'item_code' => $req->item_code[$key1],
            'material_id'   => $req->material_name[$key1],
            'brand_id' => isset($req->brand[$key1]) ? $req->brand[$key1] : NULL,
            'model' => isset($req->model[$key1]) ? $req->model[$key1] : NULL,
            'serial_code' => isset($req->serial_code[$key1]) ? json_encode($req->serial_code[$key1]) : '[]',
            'unit' => $req->unit[$key1],
            'quantity' => $req->quantity[$key1],
            'remarks' => $req->remarks[$key1],
        ];
    }

    /**
     * brandWiseModels
     *
     * @return void
     */
    public function brandWiseModels()
    {
        $data['options'] = StockLedger::query()
            ->where([
                'material_id' => request()->material_id,
                'brand_id' => request()->brand_id,
                'receiveable_id' => request()->receiveable_id,
                'received_type' => request()->received_type,
                'branch_id' => request()->from_branch_id
            ])
            ->get()
            ->unique('model')
            ->map(fn ($item) => [
                'value' => $item->model,
                'label' => $item->model,
            ])
            ->values()
            ->all();

        return response()->json($data);
    }

    /**
     * Get model wise serial codes
     *
     * @return void
     */
    public function modelWiseSerialCodes()
    {
        $data['options'] = StockLedger::query()
            ->where([
                'material_id' => request()->material_id,
                'brand_id' => request()->brand_id,
                'model' => request()->model,
                'receiveable_id' => request()->receiveable_id,
                'received_type' => request()->received_type,
                'branch_id' => request()->from_branch_id
            ])
            ->get()
            ->groupBy('serial_code')
            ->flatMap(function ($item, $key) {
                $quantity = $item->sum('quantity');
                if ($quantity > 0) {
                    $serial_code[$key] = [
                        'label' => $key,
                        'value' => $key,
                    ];
                    return $serial_code;
                }
            })
            ->values();
        return response()->json($data);
    }

    /**
     * Common function for all branch stock
     *
     * @param  integer $branch branch id form request()
     * @return integer sum of stock
     */
    public function branchWiseStock($branch): int
    {
        $branch_balance = StockLedger::query()
            ->where([
                'branch_id' => $branch,
                'received_type' => request()->received_type,
                'receiveable_id' => request()->receiveable_id,
            ])
            ->when(request()->material_id, function ($query) {
                $query->where('material_id', request()->material_id);
            })
            ->when(request()->brand_id, function ($query) {
                $query->where('brand_id', request()->brand_id);
            })
            ->when(request()->model, function ($query) {
                $query->where('model', request()->model);
            })
            ->sum('quantity');

        return $branch_balance;
    }

    /**
     * Get branch wise stock for from and to branch
     *
     * @return JsonResponse
     * 
     */
    public function getMaterialStock(): JsonResponse
    {
        $data = [
            'from_branch_balance' => $this->branchWiseStock(request()->from_branch_id),
            'to_branch_balance' => $this->branchWiseStock(request()->to_branch_id),
        ];
        return response()->json($data);
    }
}
