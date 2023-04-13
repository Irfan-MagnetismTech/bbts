<?php

namespace Modules\SCM\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Modules\Admin\Entities\Brand;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\Branch;
use App\Services\BbtsGlobalService;
use Modules\SCM\Entities\ScmChallan;
use Modules\SCM\Entities\ScmMrrLine;
use Modules\SCM\Entities\StockLedger;
use Illuminate\Database\QueryException;
use Modules\Sales\Entities\ClientDetail;
use Modules\SCM\Entities\ScmRequisition;
use Illuminate\Contracts\Support\Renderable;
use Modules\SCM\Entities\ScmErr;
use Modules\SCM\Entities\ScmMrr;
use Modules\SCM\Entities\ScmRequisitionDetail;
use Modules\SCM\Entities\ScmWcr;

class ScmChallanController extends Controller
{
    private $ChallanNo;
    public function __construct(BbtsGlobalService $globalService)
    {
        $this->ChallanNo = $globalService->generateUniqueId(ScmChallan::class, 'Challan');
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
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
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $challan_data = $request->only('type', 'date', 'scm_requisition_id', 'purpose', 'branch_id', 'client_id', 'pop_id');
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
        return view('scm::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(ScmChallan $challan)
    {
        $branchs = Branch::latest()->get();
        $client_links = ClientDetail::where('client_id', $challan->client_id)->get();
        $materials = [];
        $brands = [];
        $models = [];
        $serial_codes = [];
        $challan->scmChallanLines->each(function ($item, $key) use (&$materials, &$brands, &$models, &$serial_codes) {
            $materials[$key] = Stockledger::with('material')->where([
                'receivable_id' => $item->receiveable_id,
                'receivable_type' => $item->receiveable_type
            ])->get()
                ->unique('material_id')
                ->values();
            $brands[$key] = Stockledger::with('brand')->where([
                'receivable_id' => $item->receiveable_id,
                'receivable_type' => $item->receiveable_type,
                'material_id' => $item->material_id
            ])
                ->get()
                ->unique('brand_id')
                ->values();
            $models[$key] = StockLedger::query()->where([
                'receivable_id' => $item->receiveable_id,
                'receivable_type' => $item->receiveable_type,
                'material_id' => $item->material_id,
                'brand_id' => $item->brand_id
            ])
                ->get()
                ->unique('model')
                ->values();

            $serial_codes[$key] = StockLedger::query()->where([
                'receivable_id' => $item->receiveable_id,
                'receivable_type' => $item->receiveable_type,
                'material_id' => $item->material_id,
                'brand_id' => $item->brand_id,
                'model' => $item->model,
            ])
                ->get();
        });
        return view('scm::challans.create', compact('challan', 'brands', 'branchs', 'client_links', 'materials', 'models', 'serial_codes'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, ScmChallan $challan)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();
            $challan_data = $request->only('type', 'date', 'scm_requisition_id', 'purpose', 'branch_id', 'client_id', 'pop_id');

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

            // $challan->update($challan_data);
            // $challan->scmChallanLines()->delete();
            // $challan->scmChallanLines()->createMany($challan_details);
            // $challan->stockable()->delete();
            // $challan->stockable()->createMany($stock_ledgers);
            dd($challan_details, $stock_ledgers);
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
    public function destroy($id)
    {
    }

    public function GetStockLedgerData($req, $key1, $key2 = null)
    {
        return [
            'branch_id' => $req->branch_id,
            'material_id' => $req->material_name[$key1],
            'item_code' => $req->item_code[$key1],
            'unit' => $req->unit[$key1],
            'brand_id' => isset($req->brand[$key1]) ? $req->brand[$key1] : null,
            'model' => isset($req->model[$key1]) ? $req->model[$key1] : null,
            'serial_code' => (isset($req->serial_code[$key1]) && isset($req->serial_code[$key1][$key2])) ? $req->serial_code[$key1][$key2] : null,
            'quantity' =>  -1 * (isset($key2) ? (($req->material_type[$key1] == "Drum") ? $req->quantity[$key1] : 1) : $req->quantity[$key1]),
        ];
    }

    public function GetMrrDetails($req, $key1)
    {
        return  [
            'receiveable_type' => ($req->received_type[$key1] == 'MRR') ? ScmMrr::class : (($req->received_type[$key1] == 'WCR') ? ScmWcr::class : (($req->received_type[$key1] == 'ERR') ? ScmErr::class : null)),
            'receiveable_id' => $req->type_id[$key1],
            'item_code' => $req->item_code[$key1],
            'material_id'   => $req->material_name[$key1],
            'brand_id' => isset($req->brand[$key1]) ? $req->brand[$key1] : null,
            'model' => isset($req->model[$key1]) ? $req->model[$key1] : null,
            'serial_code' => isset($req->serial_code[$key1]) ? json_encode($req->serial_code[$key1]) : null,
            'unit' => $req->unit[$key1],
            'quantity' => $req->quantity[$key1],
            'remarks' => $req->remarks[$key1],
        ];
    }
}
