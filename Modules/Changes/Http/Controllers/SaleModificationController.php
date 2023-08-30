<?php

namespace Modules\Changes\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Services\UploadService;
use Modules\Sales\Entities\Sale;
use Modules\SCM\Entities\ScmMur;
use Modules\Sales\Entities\Offer;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;
use Modules\Sales\Entities\Costing;
use Modules\Sales\Entities\Planning;
use App\Models\Dataencoding\Division;
use App\Models\Dataencoding\Employee;
use Exception;
use Modules\Sales\Entities\SaleDetail;
use Illuminate\Database\QueryException;
use Modules\SCM\Entities\ScmRequisition;
use Modules\Sales\Entities\BillingAddress;
use Modules\Sales\Entities\SaleLinkDetail;
use Modules\Billing\Entities\BillingOtcBill;
use Modules\Sales\Entities\Client;
use Modules\Sales\Entities\CollectionAddress;
use Modules\Sales\Entities\SaleProductDetail;
use Modules\Sales\Entities\CostingLinkEquipment;
use Modules\Sales\Entities\FeasibilityRequirement;
use Modules\Sales\Entities\CostingProductEquipment;

class SaleModificationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    function __construct(private UploadService $uploadFile)
    {
    }

    public function index()
    {
        $sales = Sale::where('is_modified', 1)->get();
        return view('changes::modify_sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($connectivity_requirement_id)
    {
        $costing = Costing::with('costingProducts', 'costingProductEquipments', 'costingLinks.costingLinkEquipments')->where('connectivity_requirement_id', $connectivity_requirement_id)->first();
        $divisions = Division::latest()->get();
        return view('changes::modify_sales.create', compact('divisions', 'costing'));
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
            $data = $request->only('wo_no', 'grand_total', 'effective_date', 'contract_duration',  'remarks', 'offer_id', 'account_holder', 'client_no', 'mq_no', 'employee_id');
            $data['sla'] = $this->uploadFile->handleFile($request->sla, 'sales/sale');
            $data['work_order'] = $this->uploadFile->handleFile($request->work_order, 'sales/sale');
            $sale = Sale::create($data);
            $detailsData = $this->makeRow($request->all(), $sale->id);
            $saleDetail = SaleDetail::create($detailsData);
            $saleService = $this->makeServiceRow($request->all(), $saleDetail);
            $saleLink = $this->makeLinkRow($request->all(), $saleDetail);
            SaleLinkDetail::insert($saleLink);
            SaleProductDetail::insert($saleService);
            DB::commit();
            return redirect()->route('sales.index')->with('success', 'Sales Created Successfully');
        } catch (Exception $err) {
            DB::rollBack();
            return redirect()->back()->with('error', $err->getMessage())->withInput();
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('changes::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('changes::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

    private function makeRow($raw, $sale_id)
    {
        $data = [
            'sale_id'               => $sale_id,
            'checked'               => (isset($raw['checked']) && isset($raw['checked'])) ? 1 : 0,
            'fr_no'                 => $raw['fr_no'],
            'costing_id'            => $raw['costing_id'],
            'client_no'             => $raw['client_no'],
            'delivery_date'         => $raw['delivery_date'],
            'billing_address_id'    => $raw['billing_address_id'],
            'collection_address_id' => $raw['collection_address_id'],
            'bill_payment_date'     => $raw['bill_payment_date'],
            'payment_status'        => $raw['payment_status'],
            'mrc'                   => $raw['mrc'],
            'otc'                   => $raw['otc'],
            'total_mrc'             => $raw['total_mrc']
        ];
        return $data;
    }

    private function makeServiceRow($raw, $saleDetail, $includeCreatedAt = false)
    {
        $data = [];
        foreach ($raw['product_name'] as $key => $value) {
            $rowData = [
                'product_name'      => $raw['product_name'][$key],
                'fr_no'             => $raw['fr_no'],
                'product_id'        => $raw['product_id'][$key],
                'quantity'          => $raw['quantity'][$key],
                'unit'              => $raw['unit'][$key],
                'rate'              => $raw['rate'][$key],
                'price'             => $raw['price'][$key],
                'total_price'       => $raw['total_price'][$key],
                'vat_amount'        => $raw['vat_amount'][$key],
                'vat_percent'       => $raw['vat_percent'][$key],
                'total_amount'      => $raw['total_amount'][$key],
                'sale_id'           => $saleDetail['sale_id'],
                'sale_detail_id'    => $saleDetail['id'],
                'updated_at'        => now()
            ];
            if ($includeCreatedAt) {
                $rowData['created_at'] = now();
            }
            $data[] = $rowData;
        }
        return $data;
    }


    private function makeLinkRow($raw, $saleDetail, $includeCreatedAt = false)
    {
        $data = [];
        foreach ($raw['link_no'] as $key1 => $value) {
            $rowData = [
                'link_no'           => $raw['link_no'][$key1],
                'client_no'         => $raw['client_no'],
                'link_type'         => $raw['link_type'][$key1],
                'fr_no'             => $raw['fr_no'],
                'sale_id'           => $saleDetail['sale_id'],
                'sale_detail_id'    => $saleDetail['id'],
                'updated_at'        => now()
            ];
            if ($includeCreatedAt) {
                $rowData['created_at'] = now();
            }
            $data[] = $rowData;
        }
        return $data;
    }
}