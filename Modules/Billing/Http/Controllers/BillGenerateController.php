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
use Modules\Billing\Entities\BillingOtcBill;
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
            DB::commit();
            $sale = Sale::with('saleDetails')->where('id', $request->sale_id)->first();
            $data = $request->only('client_no', 'date', 'billing_address_id', 'bill_type', 'amount');
            $data = [
                'client_no' => $sale->client_no,
                'date' => Carbon::parse($request->billing_date)->format('Y-m-d'),
                'billing_address_id' => $sale->saleDetails[0]->billing_address_id,
                'bill_type' => 'Broken Days Bill',
                'amount' => $sale->grand_total,
                'user_id' => Auth()->id(),
                'bill_no' => $this->billNo,
            ];

            $bill_generate = BillGenerate::create($data);
            $getRow = $this->getBrokenDaysRow($sale->saleProductDetails, $request->billing_date);
            $bill_generate->lines()->createMany($getRow);

            return response()->json(['success' => true, 'message' => 'Billing date updated successfully.']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function getBrokenDaysRow($saleProductDetails, $billing_date)
    {
        $row = [];
        foreach ($saleProductDetails as $key => $value) {
            $row[] = [
                'fr_no' => $value->fr_no,
                'otc_bill_id' => $value->otc_bill_id,
                'particular' => $value->product_name,
                'total_amount' => $value->total_price,
                'net_amount' => $value->net_amount,
                'billing_address_id' => $value->billing_address_id,
                'bill_type' => 'Broken Days Bill',
                'billing_date' => Carbon::parse($billing_date)->format('Y-m-d'),
            ];
        }
        return $row;
    }
}
