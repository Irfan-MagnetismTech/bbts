<?php

namespace Modules\Billing\Http\Controllers;

use Illuminate\Database\QueryException;
use PDF;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Services\BbtsGlobalService;
use Modules\Sales\Entities\SaleDetail;
use Modules\Billing\Entities\MonthlyBill;
use Modules\Billing\Entities\BillGenerate;
use Illuminate\Contracts\Support\Renderable;

class MonthlyBillController extends Controller
{
    private $billNo;


    public function __construct(BbtsGlobalService $globalService)
    {
        $this->billNo = $globalService->generateUniqueId(BillGenerate::class, 'MRC');
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $datas = BillGenerate::where('bill_type', 'Monthly Bill')->get();
        return view('billing::monthlyBills.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('billing::monthlyBills.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {
            $datas = SaleDetail::with(['sale.saleProductDetails', 'sale.saleLinkDetails'])
            ->where('checked', 1)
            ->distinct('fr_no')
            ->whereHas('activation', function ($query) use ($request) {
                $query->where('is_active', '=', 'Active');
            })->latest()
            ->get()->groupBy('billing_address_id');
            // dd($datas);
            foreach ($datas as $key => $val) {
                $child = [];
                $parent = [
                    'client_no'             => $val->first()->sale->client_no,
                    'billing_address_id'    => $key,
                    'date'                  => $request->date,
                    'bill_type'             => "Monthly Bill",
                    'month'                 => $request->month,
                    'bill_no'               => (new BbtsGlobalService)->generateUniqueId(BillGenerate::class, 'MRC'),
                    'user_id'               => auth()->id(),
                ];
                $net_amount = 0;
                foreach ($val as $key1 => $val2) {
                    foreach ($val2->sale->saleProductDetails as $kk => $vv) {
                        $child[] = [
                            "fr_no"                    => $vv->fr_no,
                            "product_id"               => $vv->product_id,
                            "quantity"                 => $vv->quantity,
                            "unit_price"               => $vv->price,
                            "total_price"              => $vv->quantity * $vv->price,
                            'vat'                      => $vv->vat_amount,
                            "total_amount"             => ($vv->quantity * $vv->price) - $vv->vat_amount,
                            "total_product_price"      => $vv->quantity * $vv->price,
                            "penalty"                  => 0,
                            "net_amount"               => ($vv->quantity * $vv->price) - $vv->vat_amount,
                            'bill_type'                => "Monthly Bill",
                        ];
                        $net_amount += ($vv->quantity * $vv->price);
                    }
                }
                $parent['amount'] = $net_amount;
                $data = BillGenerate::create($parent);
                $data->lines()->createMany($child);
            }
            DB::commit();
            return redirect()->route('monthly-bills.index')->with('message', 'Data has been created successfully');
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
    public function edit(int $id)
    {
        $monthlyBill = BillGenerate::find($id);
        $groupedLines = $monthlyBill->lines->groupBy('fr_no');
        return view('billing::monthlyBills.edit', compact('monthlyBill', 'groupedLines'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, int $id)
    {
        try {
            DB::beginTransaction();
            $monthlyBill = BillGenerate::find($id);
            $data = $request->only('penalty');
            $monthlyBill->update($data);

            DB::commit();
            return redirect()->route('monthly-bills.index')->with('message', 'Data has been updated successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('monthly-bills.create')->withInput()->withErrors($e->getMessage());
        }
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

    public function mrc_bill(Request $request)
    {
        $selectedOptions = $request->input('selectedOptions');
        $id = $request->input('id');
        // Convert the comma-separated string to an array
        $selectedOptionsArray = explode(',', $selectedOptions);

        // Check if 'with_due' is in the selectedOptions array
        $withDue = in_array('with_due', $selectedOptionsArray) ? 1 : 0;

        // Check if 'with_pad' is in the selectedOptions array
        $withPad = in_array('with_pad', $selectedOptionsArray) ? 1 : 0;

        $monthlyBill = BillGenerate::find($id);
        $groupedLines = $monthlyBill->lines->groupBy('fr_no');
        return PDF::loadView('billing::monthlyBills.mrcBill', ['monthlyBill' => $monthlyBill, 'groupedLines' => $groupedLines, 'selectedOptions' => $selectedOptions, 'withDue' => $withDue, 'withPad' => $withPad], [], [
            'format'                     => 'A4',
            'orientation'                => 'L',
            'title'                      => 'MRC Bill',
            'watermark'                  => 'BBTS',
            'show_watermark'             => true,
            'watermark_text_alpha'       => 0.1,
            'watermark_image_path'       => '',
            'watermark_image_alpha'      => 0.2,
            'watermark_image_size'       => 'D',
            'watermark_image_position'   => 'P',
        ])->stream('bill.pdf');
        return view('billing::monthlyBills.mrcBill', compact('monthlyBill', 'groupedLines','selectedOptions','withDue','withPad'));
    }

    public function mrc_bill_summary(Request $request)
    {
        $selectedOptions = $request->input('selectedOptions');
        $id = $request->input('id');
        // Convert the comma-separated string to an array
        $selectedOptionsArray = explode(',', $selectedOptions);

        // Check if 'with_due' is in the selectedOptions array
        $withDue = in_array('with_due', $selectedOptionsArray) ? 1 : 0;

        // Check if 'with_pad' is in the selectedOptions array
        $withPad = in_array('with_pad', $selectedOptionsArray) ? 1 : 0;

        $monthlyBill = BillGenerate::find($id);
        $groupedLines = $monthlyBill->lines->groupBy('fr_no');
        return PDF::loadView('billing::monthlyBills.mrcBillSummary', ['monthlyBill' => $monthlyBill, 'groupedLines' => $groupedLines, 'selectedOptions' => $selectedOptions, 'withDue' => $withDue, 'withPad' => $withPad], [], [
            'format'                     => 'A4',
            'orientation'                => 'L',
            'title'                      => 'MRC Bill (Summary)',
            'watermark'                  => 'BBTS',
            'show_watermark'             => true,
            'watermark_font'             => 'sans-serif',
            'watermark_text_alpha'       => 0.1,
            'watermark_image_path'       => '',
            'watermark_image_alpha'      => 0.1,
            'watermark_image_size'       => 'D',
            'watermark_image_position'   => 'P',
        ])->stream('bill.pdf');
        return view('billing::monthlyBills.mrcBillSummary', compact('monthlyBill', 'groupedLines','selectedOptions','withDue','withPad'));
    }

//    public function mrc_bill_except_penalty($id)
//    {
//        $monthlyBill = BillGenerate::findOrFail($id);
//        $groupedLines = $monthlyBill->lines->groupBy('fr_no');
//        return PDF::loadView('billing::monthlyBills.mrcBillExceptPenalty', ['monthlyBill' => $monthlyBill, 'groupedLines' => $groupedLines], [], [
//            'format'                     => 'A4',
//            'orientation'                => 'L',
//            'title'                      => 'MRC Bill',
//            'watermark'                  => 'BBTS',
//            'show_watermark'             => true,
//            'watermark_text_alpha'       => 0.1,
//            'watermark_image_path'       => '',
//            'watermark_image_alpha'      => 0.2,
//            'watermark_image_size'       => 'D',
//            'watermark_image_position'   => 'P',
//        ])->stream('bill.pdf');
//        return view('billing::monthlyBills.mrcBillExceptPenalty', compact('monthlyBill', 'groupedLines'));
//    }
//
//    public function mrc_bill_summary_except_penalty($id)
//    {
//        $monthlyBill = BillGenerate::findOrFail($id);
//        $groupedLines = $monthlyBill->lines->groupBy('fr_no');
//        return PDF::loadView('billing::monthlyBills.mrcBillExceptPenaltySummary', ['monthlyBill' => $monthlyBill, 'groupedLines' => $groupedLines], [], [
//            'format'                     => 'A4',
//            'orientation'                => 'L',
//            'title'                      => 'MRC Bill',
//            'watermark'                  => 'BBTS',
//            'show_watermark'             => true,
//            'watermark_font'             => 'sans-serif',
//            'watermark_text_alpha'       => 0.1,
//            'watermark_image_path'       => '',
//            'watermark_image_alpha'      => 0.1,
//            'watermark_image_size'       => 'D',
//            'watermark_image_position'   => 'P',
//        ])->stream('bill.pdf');
//        return view('billing::monthlyBills.mrcBillExceptPenaltySummary', compact('monthlyBill', 'groupedLines'));
//    }
//
//    public function mrc_bill_except_due($id)
//    {
//        $monthlyBill = BillGenerate::findOrFail($id);
//        $groupedLines = $monthlyBill->lines->groupBy('fr_no');
//        return PDF::loadView('billing::monthlyBills.mrcBillExceptDue', ['monthlyBill' => $monthlyBill, 'groupedLines' => $groupedLines], [], [
//            'format'                     => 'A4',
//            'orientation'                => 'L',
//            'title'                      => 'MRC Bill',
//            'watermark'                  => 'BBTS',
//            'show_watermark'             => true,
//            'watermark_text_alpha'       => 0.1,
//            'watermark_image_path'       => '',
//            'watermark_image_alpha'      => 0.2,
//            'watermark_image_size'       => 'D',
//            'watermark_image_position'   => 'P',
//        ])->stream('bill.pdf');
//        return view('billing::monthlyBills.mrcBillExceptDue', compact('monthlyBill', 'groupedLines'));
//    }
//
//    public function mrc_bill_with_pad($id)
//    {
//        $monthlyBill = BillGenerate::findOrFail($id);
//        $groupedLines = $monthlyBill->lines->groupBy('fr_no');
//        return PDF::loadView('billing::monthlyBills.mrcBillWithPad', ['monthlyBill' => $monthlyBill, 'groupedLines' => $groupedLines], [], [
//            'format'                     => 'A4',
//            'orientation'                => 'L',
//            'title'                      => 'MRC Bill',
//            'watermark'                  => 'BBTS',
//            'show_watermark'             => true,
//            'watermark_text_alpha'       => 0.1,
//            'watermark_image_path'       => '',
//            'watermark_image_alpha'      => 0.2,
//            'watermark_image_size'       => 'D',
//            'watermark_image_position'   => 'P',
//        ])->stream('bill.pdf');
//        return view('billing::monthlyBills.mrcBillWithPad', compact('monthlyBill', 'groupedLines'));
//    }

    public function generate_mrc_detail_pdf($id)
    {
        $format='detail';
        return view('billing::monthlyBills.checkboxDialog',compact('id','format'));
    }

    public function generate_mrc_summary_pdf($id)
    {
        $format='summary';
        return view('billing::monthlyBills.checkboxDialog',compact('id','format'));
    }
}
