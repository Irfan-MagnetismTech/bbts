<?php

namespace Modules\Sales\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Services\UploadService;
use Modules\Sales\Entities\Sale;
use Modules\SCM\Entities\ScmMur;
use Modules\Sales\Entities\Offer;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Sales\Entities\SaleLinkDetail;
use Illuminate\Contracts\Support\Renderable;
use Modules\Sales\Entities\SaleProductDetail;

class SaleController extends Controller
{
    function __construct(private UploadService $uploadFile)
    {
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $sales = Sale::all();
        return view('sales::sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('sales::sales.create');
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
            $data = $request->only('wo_no', 'grand_total', 'effective_date', 'contract_duration',  'remarks', 'offer_id', 'account_holder', 'client_no', 'mq_no');
            $data['sla'] = $this->uploadFile->handleFile($request->sla, 'sales/sale');
            $data['work_order'] = $this->uploadFile->handleFile($request->work_order, 'sales/sale');
            $sale = Sale::create($data);
            $detailsData = $this->makeRow($request->all());
            $saleDetail = $sale->saleDetails()->createMany($detailsData);
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
    public function show(Sale $sales)
    {
        return view('sales::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param Sale $sales
     * @return Renderable
     */
    public function edit(Sale $sale)
    {
        return view('sales::sales.create', compact('sale'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param Sale $sales Object
     * @return Renderable
     */
    public function update(Request $request, Sale $sale)
    {
        $data = $request->only('wo_no', 'grand_total', 'effective_date', 'contract_duration',  'remarks', 'offer_id', 'account_holder', 'client_no', 'mq_no');
        if ($request->hasFile('sla')) {
            $data['sla'] = $this->uploadFile->handleFile($request->sla, 'sales/sale', $sale->sla);
        } else {
            $data['sla'] = $sale->sla;
        }
        if ($request->hasFile('work_order')) {
            $data['work_order'] = $this->uploadFile->handleFile($request->work_order, 'sales/sale', $sale->work_order);
        } else {
            $data['work_order'] = $sale->work_order;
        }

        try {
            DB::beginTransaction();
            $sale->update($data);
            $detailsData = $this->makeRow($request->all());
            $sale->saleDetails()->delete();
            $saleDetail = $sale->saleDetails()->createMany($detailsData);
            $saleService = $this->makeServiceRow($request->all(), $saleDetail);
            $sale->saleLinkDetails()->delete();
            $sale->saleProductDetails()->delete();
            $saleLink = $this->makeLinkRow($request->all(), $saleDetail);
            SaleLinkDetail::insert($saleLink);
            SaleProductDetail::insert($saleService);
            DB::commit();
            return redirect()->route('sales.index')->with('success', 'Sales Updated Successfully');
        } catch (Exception $err) {
            DB::rollBack();
            return redirect()->back()->with('error', $err->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param Sale $sales
     * @return Renderable
     */
    public function destroy(Sale $sale)
    {
        $this->uploadFile->deleteFile($sale->sla);
        $this->uploadFile->deleteFile($sale->work_order);
        $sale->saleDetails()->delete();
        $sale->saleLinkDetails()->delete();
        $sale->saleProductDetails()->delete();
        $sale->delete();
        return redirect()->route('sales.index')->with('success', 'Sales Deleted Successfully');
    }

    private function makeRow($raw)
    {
        $data = [];
        foreach ($raw['fr_no'] as $key => $value) {
            $data[] = [
                'checked'               => $raw['checked'][$key] ? 1 : 0,
                'fr_no'                 => $raw['fr_no'][$key],
                'client_no'             => $raw['client_no'],
                'delivery_date'         => $raw['delivery_date'][$key],
                'billing_address'       => $raw['billing_address'][$key],
                'collection_address'    => $raw['collection_address'][$key],
                'bill_payment_date'     => $raw['bill_payment_date'][$key],
                'payment_status'        => $raw['payment_status'][$key],
                'mrc'                   => $raw['mrc'][$key],
                'otc'                   => $raw['otc'][$key],
                'total_mrc'             => $raw['total_mrc'][$key],
            ];
        }
        return $data;
    }

    private function makeServiceRow($raw, $saleDetail)
    {
        $data = [];
        foreach ($raw['fr_no'] as $key => $value) {
            foreach ($raw['service'][$key] as $key1 => $value) {
                $data[] = [
                    'service_name'      => $raw['service'][$key][$key1],
                    'fr_no'             => $raw['fr_no'][$key],
                    'service_name'      => $raw['service'][$key][$key1],
                    'quantity'          => $raw['quantity'][$key][$key1],
                    'unit'              => $raw['unit'][$key][$key1],
                    'rate'              => $raw['rate'][$key][$key1],
                    'price'             => $raw['price'][$key][$key1],
                    'total_price'       => $raw['total_price'][$key][$key1],
                    'sale_id'           => $saleDetail[$key]['sale_id'],
                    'sale_detail_id'    => $saleDetail[$key]['id'],
                    'created_at'        => now(),
                    'updated_at'        => now()
                ];
            }
        }
        return $data;
    }


    private function makeLinkRow($raw, $saleDetail)
    {
        $data = [];
        foreach ($raw['fr_no'] as $key => $value) {
            foreach ($raw['link_no'][$key] as $key1 => $value) {
                $data[] = [
                    'link_no'           => $raw['link_no'][$key][$key1],
                    'link_type'         => $raw['link_type'][$key][$key1],
                    'fr_no'             => $raw['fr_no'][$key],
                    'sale_id'           => $saleDetail[$key]['sale_id'],
                    'sale_detail_id'    => $saleDetail[$key]['id'],
                    'created_at'        => now(),
                    'updated_at'        => now()
                ];
            }
        }
        return $data;
    }

    public function getClientInfoForSales()
    {
        $items = Offer::query()
            ->with(['client', 'offerDetails.costing.costingProducts', 'offerDetails.frDetails', 'offerDetails.offerLink'])
            ->whereHas('client', function ($qr) {
                return $qr->where('client_name', 'like', '%' . request()->search . '%');
            })
            ->get()
            ->map(fn ($item) => [
                'value'         => $item->client->client_name,
                'label'         => $item->client->client_name . ' ( ' . ($item?->mq_no ?? '') . ' )',
                'client_no'     => $item->client_no,
                'offer_id'      => $item->id,
                'mq_no'         => $item->mq_no,
                'details'       => $item->offerDetails
            ]);
        return response()->json($items);
    }

    public function getFrsBasedOnMq()
    {
        $items = Offer::query()
            ->with(['client'])
            ->where('mq_no', 'like', '%' . request()->search . '%')
            ->get()
            ->map(fn ($item) => [
                'value'        => $item->mq_no,
                'label'        => $item->mq_no . '( ' . ($item?->client?->client_name ?? '') . ' )',
                'client_no'    => $item->client_no,
                'client_name'  => $item?->client?->client_name,
                'offer_id'     => $item->id,
                'mq_no'        => $item->mq_no
            ]);
        return response()->json($items);
    }

    private function getFrData()
    {
    }
}
