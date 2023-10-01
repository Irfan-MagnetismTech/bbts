<?php

namespace Modules\Billing\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Services\BbtsGlobalService;
use Exception;
use Illuminate\Support\Facades\DB;
use Modules\Billing\Entities\BillGenerate;
use Modules\Billing\Entities\BillGenerateLine;
use Modules\Billing\Entities\BrokenDaysBill;
use Modules\Networking\Entities\Connectivity;
use Modules\Sales\Entities\Client;
use Modules\Sales\Entities\Sale;
use Modules\Sales\Entities\SaleProductDetail;

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
        $datas = BrokenDaysBill::get();
        return view('billing::brokenDaysBill.index', compact('datas'));
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
        try {
            DB::beginTransaction();
            $data = $request->only('client_no', 'fr_no', 'date', 'bill_no', 'type', 'days', 'total_amount','user_id');
            $data['user_id'] = Auth()->id();
            $data['bill_no'] = $this->brokenDaysBillNo;
            $data['type'] = 'Broken Days Bill';
            $data['total_amount'] = $request->payable_amount;
            $bill = BrokenDaysBill::create($data);

            $billGenerateData = [
                'client_no' => $bill->client_no,
                'date' => $bill->date,
                'bill_no' => $bill->bill_no,
                'bill_type' => $bill->type,
                'amount' => $bill->total_amount,
                'user_id' => $bill->user_id,
            ];

            $billGenerate = BillGenerate::create($billGenerateData);

            $getProducts = [];
            $getBillGenerateProducts = [];
            foreach ($request->product_name as $key => $val) {
                $getProducts[] = $this->getProductData($request, $key);
                $getBillGenerateProducts[] = $this->getBillGenerateProductData($request, $key, $bill);
            }

            $bill->BrokenDaysBillDetails()->createMany($getProducts);
            $billGenerate->lines()->createMany($getBillGenerateProducts);

            DB::commit();
            return redirect()->route('broken-days-bills.create')->with('message', 'Data has been created successfully');
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

    public function get_client()
    {
        $items = Client::query()
            ->with('saleDetails.feasibilityRequirementDetails','billingAddress')
            ->where('client_name', 'like', '%' . request()->search . '%')
            ->get()
            ->map(fn ($item) => [
                'value'                 => $item->client_name,
                'label'                 => $item->client_name,
                'client_no'             => $item->client_no,
                'client_id'             => $item->id,
                'saleDetails' => $item->saleDetails
            ]);
        return response()->json($items);
    }

    public function get_fr_product()
    {
        $items = SaleProductDetail::query()
            ->where('fr_no', request()->fr_no)
            ->get()
            ->map(fn ($item) => [
                'product_id'                 => $item->product_id,
                'product_name'                 => $item->product_name,
                'quantity'                 => $item->quantity,
                'unit'                 => $item->unit,
                'fr_no'                 => $item->fr_no,
                'rate'                 => $item->rate,
                'price'                 => $item->price,
                'vat_amount'                 => $item->vat_amount,
                'total_price'                 => $item->total_price,
            ]);
        return response()->json($items);
    }

    public function get_fr_bill_date()
    {
        $items = Connectivity::query()
            ->where('fr_no', request()->fr_no)
            ->get()
            ->map(fn ($item) => [
                'client_no'                 => $item->client_no,
                'billing_date'                 => $item->billing_date,
            ]);
        return response()->json($items);
    }

    private function getProductData($request, $key)
    {
        return [
            'product_id'        => $request->product_id[$key],
            'quantity'          => $request->quantity[$key],
            'unit_price'          => $request->unit_price[$key],
            'vat'          => $request->vat[$key],
            'total_price'       => $request->total_price[$key],
            'total_amount'       => $request->total_amount[$key],
        ];
    }

    private function getBillGenerateProductData($request, $key, $bill)
    {
        return [
            'broken_days_bill_id'        => $bill->id,
            'fr_no'        => $bill->fr_no,
            'bill_type'        => $bill->type,
            'product_id'        => $request->product_id[$key],
            'quantity'          => $request->quantity[$key],
            'unit_price'          => $request->unit_price[$key],
            'vat'          => $request->vat[$key],
            'total_price'       => $request->total_price[$key],
            'total_amount'       => $request->total_amount[$key],
        ];
    }

    // public function getUnpaidBill(Request $request)
    // {
    //     $unpaidBills = BillGenerate::with('collection')
    //     ->withSum('collection', 'receive_amount')
    //     ->where('client_no', $request->client_no)->get();
        
    //     return $unpaidBills;
    // }
//     public function getUnpaidBill(Request $request)
// {
//     $unpaidBills = BillGenerate::with('collection')
//         ->withSum('collection', 'receive_amount')
//         ->where('client_no', $request->client_no)
//         ->get();

//     $unpaidBills->each(function ($bill) {
//         // Access the collection relationship
//         $collections = $bill->collection;

//         // Check if there are collections
//         if ($collections->isNotEmpty()) {
//             // Access the last object's previous_due
//             $lastCollection = $collections->last();
//             $previousDue = $lastCollection->previous_due;

//             // You can now use $previousDue as needed
//             $bill->last_previous_due = $previousDue;
//         }
//     });

//     return $unpaidBills;
// }
public function getUnpaidBill(Request $request)
{
    $unpaidBills = BillGenerate::with('collection')
        ->withSum('collection', 'receive_amount')
        ->where('client_no', $request->client_no)
        ->get();

        $unpaidBills->each(function ($bill) {
            // Access the collection relationship
            $collections = $bill->collection;
    
            // Check if there are collections
            if ($collections->isNotEmpty()) {
                // Access the last object's previous_due
                $lastCollection = $collections->last();
                $previousDue = $lastCollection->previous_due;
    
                // You can now use $previousDue as needed
                $bill->last_previous_due = $previousDue;
            }
        });
    
        return $unpaidBills;
    }

}
