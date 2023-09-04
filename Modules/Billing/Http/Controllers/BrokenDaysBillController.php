<?php

namespace Modules\Billing\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Services\BbtsGlobalService;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;
use Modules\Billing\Entities\BillGenerate;
use Modules\Billing\Entities\BillGenerateLine;
use Modules\Billing\Entities\BillingOtcBill;
use Modules\Billing\Entities\BrokenDaysBill;
use Modules\Networking\Entities\Connectivity;
use Modules\Sales\Entities\Sale;



class BrokenDaysBillController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    private $brokenDaysBillNo;


    public function __construct(BbtsGlobalService $globalService)
    {
        $this->brokenDaysBillNo = $globalService->generateUniqueId(BillGenerate::class, 'BDB');
    }

    public function index()
    {
        return view('billing::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('billing::brokenDaysBill.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('billing::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('billing::edit');
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

    public function updateBillingDate(Request $request)
    {
        try {
            DB::beginTransaction();
            $connectivity = Connectivity::find($request->connectivity_id);
            $connectivity->billing_date = Carbon::parse($request->billing_date)->format('Y-m-d');
            $connectivity->save();

            $sale = Sale::with('saleDetails')->where('id', $request->sale_id)->first();
            $billingDate = Carbon::parse($request->billing_date);

            $brokenDaysData = $this->prepareBrokenDaysData($sale, $request->fr_no, $billingDate);
            $brokenDaysBill = BrokenDaysBill::create($brokenDaysData);

            $getBrokenDaysRow = $this->getBrokenDaysRow($sale->saleProductDetails);
            $brokenDaysBill->BrokenDaysBillDetails()->createMany($getBrokenDaysRow);

            $broken_days_data = BrokenDaysBill::where('id', $brokenDaysBill->id)->with('BrokenDaysBillDetails')->first();
            $bill =  ($broken_days_data->BrokenDaysBillDetails->sum('total_amount') / $billingDate->daysInMonth) * $broken_days_data->days;
            $brokenDaysBill->total_amount = $bill;
            $brokenDaysBill->save();
            $billGenerateData = $this->prepareBillGenerateData($sale, $request->billing_date, $bill);
            $bill_generate = BillGenerate::create($billGenerateData);

            $bill_generate_lines = $this->createBillGenerateLine($request->fr_no, $brokenDaysBill, $sale->saleDetails[0]->billing_address_id, $bill_generate->id);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Billing date updated successfully.']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    private function prepareBrokenDaysData($sale, $fr_no, $billingDate)
    {
        $remainning_days = $billingDate->daysInMonth - $billingDate->day;
        return [
            'client_no' => $sale->client_no,
            'date' => $billingDate->format('Y-m-d'),
            'fr_no' => $fr_no,
            'type' => 'Broken Days Bill',
            'user_id' => auth()->id(),
            'bill_no' => $this->brokenDaysBillNo,
            'days' => $remainning_days
        ];
    }

    private function prepareBillGenerateData($sale, $billing_date, $bill)
    {
        return [
            'client_no' => $sale->client_no,
            'date' => Carbon::parse($billing_date)->format('d-m-Y'),
            'billing_address_id' => $sale->saleDetails[0]->billing_address_id,
            'bill_type' => 'Broken Days Bill',
            'amount' => $bill,
            'user_id' => auth()->id(),
            'bill_no' => $this->brokenDaysBillNo,
        ];
    }

    private function createBillGenerateLine($fr_no, $brokenDaysBill, $billing_address_id, $bill_generate_id)
    {
        $row = [
            'fr_no' => $fr_no,
            'broken_days_bill_id' => $brokenDaysBill->id,
            'total_amount' => $brokenDaysBill->total_amount,
            'net_amount' => $brokenDaysBill->total_amount,
            'billing_address_id' => $billing_address_id,
            'bill_type' => 'Broken Days Bill',
            'bill_generate_id' => $bill_generate_id,
        ];

        return BillGenerateLine::create($row);
    }

    private function getBrokenDaysRow($saleProductDetails)
    {
        $row = [];
        foreach ($saleProductDetails as $value) {
            $row[] = [
                'product_id' => $value->product_id,
                'quantity' => $value->quantity,
                'unit_price' => $value->rate,
                'total_price' => $value->total_price,
                'vat' => $value->vat_amount,
                'total_amount' => $value->vat_amount + $value->total_price,
            ];
        }
        return $row;
    }
}
