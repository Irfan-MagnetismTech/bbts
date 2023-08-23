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
use Modules\Sales\Entities\SaleDetail;
use Illuminate\Database\QueryException;
use Modules\SCM\Entities\ScmRequisition;
use Modules\Sales\Entities\BillingAddress;
use Modules\Sales\Entities\SaleLinkDetail;
use Modules\Billing\Entities\BillingOtcBill;
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
    public function index()
    {
        $sales = Sale::where('is_modified', 1)->get();
        return view('changes::modify_sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $divisions = Division::latest()->get();
        return view('changes::modify_sales.create', compact('divisions'));
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
}
