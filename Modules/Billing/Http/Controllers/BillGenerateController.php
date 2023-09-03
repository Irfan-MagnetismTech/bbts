<?php

namespace Modules\Billing\Http\Controllers;

use PDF;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Services\BbtsGlobalService;
use Carbon\Carbon;
use Modules\Billing\Entities\BillGenerate;
use Modules\Sales\Entities\BillingAddress;
use Illuminate\Contracts\Support\Renderable;
use Modules\Billing\Entities\BillGenerateLine;
use Modules\Billing\Entities\BillingOtcBill;
use Modules\Billing\Entities\BrokenDaysBill;
use Modules\Networking\Entities\Connectivity;
use Modules\Sales\Entities\Sale;

class BillGenerateController extends Controller
{

    private $billNo;


    public function __construct(BbtsGlobalService $globalService)
    {
        $this->billNo = $globalService->generateUniqueId(BillGenerate::class, 'OTC');
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $datas = BillGenerate::where('bill_type', 'OTC')->get();
        return view('billing::billGenerate.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($client_no)
    {
        $BillLocations = BillingOtcBill::where('client_no', $client_no)->get();
        // dd($BillLocations);
        $BillingAddresses = BillingAddress::where('client_no', $client_no)->orderBy('created_at')->get();
        return view('billing::billGenerate.create', compact('BillLocations', 'BillingAddresses'));
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
            $data = $request->only('client_no', 'date', 'billing_address_id', 'bill_type', 'amount');
            $data['user_id'] = Auth()->id();
            $data['bill_no'] = $this->billNo;
            $bill_generate = BillGenerate::create($data);
            $getRow = $this->getRow($request);
            $bill_generate->lines()->createMany($getRow);
            DB::commit();
            return redirect()->route('bill-generate.index')->with('message', 'Data has been created successfully');
        } catch (Exception $error) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($error->getMessage());
        }
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

    public function pdf($id)
    {
        $billData = BillGenerate::findOrFail($id);
        $billData->load('lines.billingOtcBill.lines');
        return PDF::loadView('billing::billGenerate.pdf', ['billData' => $billData], [], [
            'format'                     => 'A4',
            'orientation'                => 'L',
            'title'                      => 'OTC Bill',
        ])->stream('bill.pdf');
        return view('billing::billGenerate.pdf', compact('billData'));
    }


    public function generate_bill($id)
    {
        $billData = BillGenerate::findOrFail($id);
        $billData->load('lines.billingOtcBill.lines');
        return view('billing::billGenerate.bill', compact('billData'));
    }


    public function getRow($req)
    {
        $row = [];
        foreach ($req->connectivity_point as $key => $value) {
            if ((isset($req['checked']) && isset($req['checked'][$key]))) {
                $row[] = [
                    'fr_no' => $req->fr_no[$key],
                    'otc_bill_id' => $req->otc_bill_id[$key],
                    'particular' => $req->particular[$key],
                    'total_amount' => $req->total_amount[$key],
                    'net_amount' => $req->net_amount[$key],
                    'billing_address_id' => $req->child_billing_address_id[$key],
                    'bill_type' => $req->bill_type,
                ];
            }
        }
        return $row;
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
            'bill_no' => $this->billNo,
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
            'bill_no' => $this->billNo,
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
