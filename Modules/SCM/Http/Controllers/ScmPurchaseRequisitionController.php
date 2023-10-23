<?php

namespace Modules\SCM\Http\Controllers;

use Modules\Admin\Entities\Pop;
use Modules\Admin\Entities\Brand;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\Branch;
use Modules\Sales\Entities\Client;
use App\Services\BbtsGlobalService;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\QueryException;
use Modules\Sales\Entities\ClientDetail;
use Modules\SCM\Http\Requests\SupplierRequest;
use Modules\SCM\Entities\ScmPurchaseRequisition;
use Modules\SCM\Http\Requests\ScmPurchaseRequisitionRequest;
use Illuminate\Http\Request;

class ScmPurchaseRequisitionController extends Controller
{
    use HasRoles;

    private $purchaseRequisitionNo;

    function __construct(BbtsGlobalService $globalService)
    {
        $this->purchaseRequisitionNo = $globalService->generateUniqueId(ScmPurchaseRequisition::class, 'PRS');

        $this->middleware('permission:scm-prs-view|scm-prs-create|scm-prs-edit|scm-prs-delete', ['only' => ['index', 'show', 'getCsPdf', 'getAllDetails', 'getMaterialSuppliersDetails', 'csApproved']]);
        $this->middleware('permission:scm-prs-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:scm-prs-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:scm-prs-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $purchaseRequisitions = ScmPurchaseRequisition::with('requisitionBy')->latest()->get();

        return view('scm::purchase-requisitions.index', compact('purchaseRequisitions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = Brand::latest()->get();

        return view('scm::purchase-requisitions.create', compact('brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ScmPurchaseRequisitionRequest $request)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();
            $fr_no = json_encode($request->fr_no);
            // dd($fr_no);
            if (request()->type == 'client') {
                $requestData = $request->only('type', 'prs_type', 'client_no', 'date','link_no', 'assessment_no');
                $requestData['fr_no'] = $fr_no;
            } else {
                $requestData = $request->only('type', 'prs_type', 'date');
            }

            $lastMRSId = ScmPurchaseRequisition::latest()->first();
            if ($lastMRSId) {
                $requestData['prs_no'] = 'PRS-' . now()->format('Y') . '-' . $lastMRSId->id + 1;
            } else {
                $requestData['prs_no'] = 'PRS-' . now()->format('Y') . '-' . 1;
            }
            $requestData['requisition_by'] = auth()->id();
            $purchaseRequisition = ScmPurchaseRequisition::create($requestData);

            $requisitionDetails = [];
            foreach ($request->material_id as $key => $data) {
                $requisitionDetails[] = [
                    'material_id' => $request->material_id[$key],
                    'item_code' => $request->item_code[$key],
                    'brand_id' => $request->brand_id[$key],
                    'model' => $request->model[$key],
                    'req_key' => $purchaseRequisition->id . '-' . $request->item_code[$key],
                    'quantity' => $request->quantity[$key],
                    'unit_price' => $request->unit_price[$key],
                    'total_amount' => $request->unit_price[$key] * $request->quantity[$key],
                    'purpose' => $request->purpose[$key],
                    'remarks' => $request->remarks[$key],
                ];
            }

            $purchaseRequisition->scmPurchaseRequisitionDetails()->createMany($requisitionDetails);
            DB::commit();

            return redirect()->route('purchase-requisitions.index')->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('purchase-requisitions.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ScmPurchaseRequisition  $purchaseRequisition
     * @return \Illuminate\Http\Response
     */
    public function show(ScmPurchaseRequisition $purchaseRequisition)
    {
        return view('scm::purchase-requisitions.show', compact('purchaseRequisition'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ScmPurchaseRequisition  $purchaseRequisition
     * @return \Illuminate\Http\Response
     */
    public function edit(ScmPurchaseRequisition $purchaseRequisition)
    {
        $formType = "edit";
        $brands = Brand::latest()->get();
        $branchs = Branch::latest()->get();
        $pops = Pop::latest()->get();
        $clients = Client::latest()->get();
        $fr_nos = Client::with('saleDetails')->where('client_no', $purchaseRequisition->client_no)->first()?->saleDetails ?? [];
        $client_links = Client::with('saleLinkDetails')->where('client_no', $purchaseRequisition->client_no)->first()?->saleLinkDetails ?? [];

        return view('scm::purchase-requisitions.create', compact('purchaseRequisition', 'formType', 'brands', 'pops', 'clients', 'fr_nos', 'client_links', 'branchs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ScmPurchaseRequisition  $purchaseRequisition
     * @return \Illuminate\Http\Response
     */
    public function update(SupplierRequest $request, ScmPurchaseRequisition $purchaseRequisition)
    {
        try {
            DB::beginTransaction();
                $fr_no = json_encode($request->fr_no);
            if (request()->type == 'client') {
                $requestData = $request->only('type', 'prs_type', 'client_no', 'date', 'link_no', 'assessment_no');
                $requestData['fr_no'] = $fr_no;
            } else {
                $requestData = $request->only('type', 'prs_type', 'date');
            }
            $requestData['requisition_by'] = auth()->id();

            $purchaseRequisition->update($requestData);

            $requisitionDetails = [];
            foreach ($request->material_id as $key => $data) {
                $requisitionDetails[] = [
                    'material_id' => $request->material_id[$key],
                    'item_code' => $request->item_code[$key],
                    'brand_id' => $request->brand_id[$key],
                    'model' => $request->model[$key],
                    'req_key' => $purchaseRequisition->id . '-' . $request->item_code[$key],
                    'quantity' => $request->quantity[$key],
                    'unit_price' => $request->unit_price[$key],
                    'total_amount' => $request->unit_price[$key] * $request->quantity[$key],
                    'purpose' => $request->purpose[$key],
                    'remarks' => $request->remarks[$key],
                ];
            }

            $purchaseRequisition->scmPurchaseRequisitionDetails()->delete();
            $purchaseRequisition->scmPurchaseRequisitionDetails()->createMany($requisitionDetails);
            DB::commit();

            return redirect()->route('purchase-requisitions.index')->with('message', 'Data has been updated successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('purchase-requisitions.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ScmPurchaseRequisition  $purchaseRequisition
     * @return \Illuminate\Http\Response
     */
    public function destroy(ScmPurchaseRequisition $purchaseRequisition)
    {
        try {
            $purchaseRequisition->delete();
            $purchaseRequisition->scmPurchaseRequisitionDetails()->delete();
            return redirect()->route('purchase-requisitions.index')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $e) {
            return redirect()->route('purchase-requisitions.index')->withErrors($e->getMessage());
        }
    }
}
