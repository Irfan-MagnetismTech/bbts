<?php

namespace Modules\Billing\Http\Controllers;

use Illuminate\Database\QueryException;
use Modules\Billing\Entities\BillRegister;
use Modules\Sales\Entities\Client;
use Modules\SCM\Entities\Supplier;
use PDF;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Services\BbtsGlobalService;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;

class BillRegisterController extends Controller
{

//    private $billNo;
//
//
//    public function __construct(BbtsGlobalService $globalService)
//    {
//        $this->billNo = $globalService->generateUniqueId(BillRegister::class, 'BR');
//    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $datas = BillRegister::get();
        return view('billing::billRegister.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('billing::billRegister.create');
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
            $data = $request->only('bill_no', 'supplier_id', 'amount');
            $bill_register = BillRegister::create($data);
            DB::commit();
            return redirect()->route('bill-register.create')->with('message', 'Data has been created successfully');
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
    public function show(BillRegister $billRegister)
    {
        return view('billing::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(BillRegister $billRegister)
    {
        return view('billing::billRegister.create', compact('billRegister'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, BillRegister $billRegister)
    {
        try {
            DB::beginTransaction();
            $data = $request->only('bill_no', 'supplier_id','amount');
            $billRegister->update($data);

            DB::commit();
            return redirect()->route('bill-register.index')->with('message', 'Data has been updated successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('bill-register.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(BillRegister $billRegister)
    {
        try {
            $billRegister->delete();
            return redirect()->route('bill-register.index')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $err) {
            return redirect()->route('bill-register.index')->withInput()->withErrors($err->getMessage());
        }
    }

    public function get_supplier()
    {
        $items = Supplier::query()
            ->where('name', 'like', '%' . request()->search . '%')
            ->get()
            ->map(fn($item) => [
                'value' => $item->name,
                'label' => $item->name,
                'supplier_id' => $item->id
            ]);
        return response()->json($items);
    }

//    public function pdf($id)
//    {
//        $billData = BillGenerate::findOrFail($id);
//        $billData->load('lines.billingOtcBill.lines');
//        return PDF::loadView('billing::billGenerate.pdf', ['billData' => $billData], [], [
//            'format'                     => 'A4',
//            'orientation'                => 'L',
//            'title'                      => 'OTC Bill',
//        ])->stream('bill.pdf');
//        return view('billing::billGenerate.pdf', compact('billData'));
//    }
}
