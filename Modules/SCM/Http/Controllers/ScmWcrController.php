<?php

namespace Modules\SCM\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\SCM\Entities\ScmErr;
use Modules\SCM\Entities\ScmMrr;
use Modules\SCM\Entities\ScmWcr;
use Modules\Admin\Entities\Brand;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\Branch;
use App\Services\BbtsGlobalService;
use Modules\SCM\Entities\ScmMrrLine;
use Modules\SCM\Entities\StockLedger;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Renderable;
use Modules\SCM\Entities\ScmMrrSerialCodeLine;
use Illuminate\Support\Facades\Schema;

class ScmWcrController extends Controller
{
    private $wcrNo;

    public function __construct(BbtsGlobalService $globalService)
    {
        $this->wcrNo = $globalService->generateUniqueId(ScmWcr::class, 'WCR');
        $this->middleware('permission:scm-wcr-view|scm-wcr-create|scm-wcr-edit|scm-wcr-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:scm-wcr-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:scm-wcr-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:scm-wcr-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $ScmDatas = ScmWcr::latest()->get();
        return view('scm::wcrs.index', compact('ScmDatas'));
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
        return view('scm::wcrs.create', compact('formType', 'brands', 'branchs'));
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
            $scm_wcr = $request->only('type', 'date', 'supplier_id', 'branch_id', 'client_no');
            $scm_wcr['wcr_no'] = $this->wcrNo;
            $scm_wcr['created_by'] = auth()->user()->id;
            $wcr = ScmWcr::create($scm_wcr);
            $stock = [];
            $wcr_lines = [];
            foreach ($request->material_name as $key => $val) {
                $wcr_lines[] = $this->getLineData($request, $key, $wcr->id);
                $stock[] = $this->getStockData($request, $key, $wcr->id);
            };
            $wcr->lines()->createMany($wcr_lines);
            $wcr->stockable()->createMany($stock);
            DB::commit();
            return redirect()->route('warranty-claims.index')->with('message', 'Data has been created successfully');
        } catch (QueryException $err) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($err->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(ScmWcr $warranty_claim)
    {
        return view('scm::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(ScmWcr $warranty_claim)
    {
        $formType = "edit";
        $brands = Brand::latest()->get();
        $branchs = Branch::latest()->get();
        return view('scm::wcrs.create', compact('formType', 'brands', 'branchs', 'warranty_claim'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, ScmWcr $warranty_claim)
    {
        try {
            DB::beginTransaction();
            $scm_wcr = $request->only('type', 'date', 'supplier_id', 'branch_id', 'client_no');
            $scm_wcr['wcr_no'] = $this->wcrNo;
            $scm_wcr['created_by'] = auth()->user()->id;
            $warranty_claim->update($scm_wcr);
            $stock = [];
            $wcr_lines = [];
            foreach ($request->material_name as $key => $val) {
                $wcr_lines[] = $this->getLineData($request, $key, $warranty_claim->id);
                $stock[] = $this->getStockData($request, $key, $warranty_claim->id);
            };
            $warranty_claim->lines()->delete();
            $warranty_claim->lines()->createMany($wcr_lines);
            $warranty_claim->stockable()->delete();
            $warranty_claim->stockable()->createMany($stock);
            DB::commit();
            return redirect()->route('warranty-claims.index')->with('message', 'Data has been updated successfully');
        } catch (QueryException $err) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($err->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(ScmWcr $warranty_claim)
    {
        try {
            DB::beginTransaction();
            $warranty_claim->stockable()->delete();
            $warranty_claim->delete();
            DB::commit();
            return redirect()->route('warranty-claims.index')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $err) {
            DB::rollBack();
            return redirect()->route('warranty-claims.index')->withInput()->withErrors($err->getMessage());
        }
    }

    public function sentToSupplier(ScmWcr $wcr)
    {
        try {
            DB::beginTransaction();
            $wcr->update([
                'sent_by' => auth()->user()->id,
                'sending_date' => request()->date,
                'Status'    => 'sent'
            ]);
            DB::commit();
            return redirect()->route('warranty-claims.index')->with('message', 'Product has been sent successfully');
        } catch (QueryException $err) {
            DB::rollBack();
            return redirect()->route('warranty-claims.index')->withInput()->withErrors($err->getMessage());
        }
    }


    private function getLineData($req, $ke, $id)
    {
        return [
            'material_id'               => $req->material_id[$ke] ?? null,
            'description'               => $req->description[$ke] ?? null,
            'item_code'                 => $req->item_code[$ke] ?? null,
            'model'                     => $req->model[$ke]  ?? null,
            'serial_code'               => $req->serial_code[$ke] ?? null,
            'brand_id'                  => $req->brand_id[$ke] ?? null,
            'receiving_date'            => $req->receiving_date[$ke] ?? null,
            'warranty_period'           => $req->warranty_period[$ke] ?? null,
            'remaining_days'            => $req->remaining_days[$ke] ?? null,
            'challan_no'                => $req->challan_no[$ke] ?? null,
            'receiveable_id'            => $req->receiveable_id[$ke] ?? null,
            'received_type'             => strtoupper($req->received_type[$ke]) ?? null,
            'warranty_composite_key'    => $id . '-' . $req->serial_code[$ke],
        ];
    }

    private function getStockData($req, $ke, $id)
    {
        return [
            'received_type'     => strtoupper($req->received_type[$ke]) ?? NULL,
            'receiveable_id'    => $req->receiveable_id[$ke] ?? NULL,
            'receiveable_type'  => (strtoupper($req->received_type[$ke]) == 'MRR') ? ScmMrr::class : ((strtoupper($req->received_type[$ke]) == 'WCR') ? ScmWcr::class : ((strtoupper($req->received_type[$ke]) == 'ERR') ? ScmErr::class : NULL)),
            'material_id'       => $req->material_id[$ke] ?? null,
            'stockable_type'    => ScmWcr::class,
            'stockable_id'      => $id ?? null,
            'brand_id'          => $req->brand_id[$ke] ?? null,
            'branch_id'         => $req->branch_id ?? null,
            'model'             => $req->model[$ke] ?? null,
            'quantity'          => -1,
            'item_code'         => $req->item_code[$ke] ?? null,
            'serial_code'       => $req->serial_code[$ke] ?? null,
            'unit'              => $req->unit[$ke] ?? null,
        ];
    }

    public function searchSerialForWcr(Request $request)
    {
        $data = StockLedger::whereHas('material', function ($item) use ($request) {
            $item->where('name', 'like', '%' . $request->search . '%');
        })->whereHasMorph('stockable', [ScmMrr::class], function ($item) use ($request) {
            return $item->where('supplier_id', request()->customQueryFields['supplier_id']);
        })
            ->where('quantity', '<=', 1)
            ->pluck('serial_code')
            ->toArray();
        $receive_type = ($request->customQueryFields['type'] == 'MRR') ? ScmMrr::class : (($request->customQueryFields['type'] == 'WCR') ? ScmWcr::class : (($request->customQueryFields['type'] == 'ERR') ? ScmErr::class : NULL));
        $items = StockLedger::query()
            ->with(['material', 'brand'])
            ->whereIn('serial_code', $data)
            ->where('branch_id', request()->customQueryFields['branch_id'])
            ->when(request()->customQueryFields['type'] == 'client', function ($qr) use ($request) {
                $qr->whereHasMorph('stockable', [ScmErr::class], function ($item) use ($request) {
                    return $item->where('client_no', request()->customQueryFields['client_no']);
                });
            })
            ->get()
            ->groupBy(['serial_code'])
            ->map(function ($group) {
                return $group->last();
            })
            ->filter(function ($item) use ($receive_type) {
                return $item->stockable_type == $receive_type;
            })
            ->flatten()
            ->map(fn ($item) => [
                'value' => $item->material->name,
                'label' => $item->material->name . ' - ' . $item->serial_code . ' - ' . $item->brand->name . ' - ' . $item->model,
                'material_id' => $item->material_id,
                'serial_code' => $item->serial_code,
                'brand_id' => $item->brand_id,
                'brand_name' => $item->brand->name,
                'model' => $item->model,
                'unit' => $item->material->unit,
                'item_code' => $item->material->code,
                'item_type' => $item->material->type,
                'receiving_date' => ScmMrrSerialCodeLine::where('serial_or_drum_code', $item->serial_code)->get()->first()->scmMrrLines->scmMrr->date,
                'warranty_period' => ScmMrrSerialCodeLine::where('serial_or_drum_code', $item->serial_code)->get()->first()->scmMrrLines->warranty_period,
                'remaining_days' => (((ScmMrrSerialCodeLine::where('serial_or_drum_code', $item->serial_code)->get()->first()->scmMrrLines->warranty_period) - (Carbon::now()->diffInDays(Carbon::parse(ScmMrrSerialCodeLine::where('serial_or_drum_code', $item->serial_code)->get()->first()->scmMrrLines->scmMrr->date)))) > 0) ? ((ScmMrrSerialCodeLine::where('serial_or_drum_code', $item->serial_code)->get()->first()->scmMrrLines->warranty_period) - (Carbon::now()->diffInDays(Carbon::parse(ScmMrrSerialCodeLine::where('serial_or_drum_code', $item->serial_code)->get()->first()->scmMrrLines->scmMrr->date))))  : 0,
                'challan_no' => ScmMrrSerialCodeLine::where('serial_or_drum_code', $item->serial_code)->get()->first()->scmMrrLines->scmMrr->challan_no,
                'receiveable_id' => $item->receiveable_id
            ]);
        return response()->json($items);
    }
}
