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

    // public function getClientInfoForSalesModificationFR()
    // {
    //     $results = Client::query()
    //         ->with('feasibility_requirement.feasibilityRequirementDetails')
    //         ->where('client_name', 'LIKE', '%' . request('search') . '%')
    //         ->limit(15)
    //         ->get()
    //         ->map(function ($item) {
    //             return $item->feasibility_requirement->map(function ($fr) use ($item) {
    //                 return [
    //                     'value' => $item->client_name,
    //                     'label' => $item->client_name . ' (' . ($fr->mq_no ?? '') . ')',
    //                     'client_no' => $item->client_no,
    //                     'client_id' => $item->id,
    //                     'mq_no' => $fr->mq_no,
    //                     'details' => $fr->feasibilityRequirementDetails->pluck('fr_no', 'fr_no')
    //                 ];
    //             });
    //         })->flatten(1);


    //     return response()->json($results);

    //     //     $items = Offer::query()
    //     //     ->with(['client', 'offerDetails.costing.costingProducts.product', 'offerDetails.frDetails', 'offerDetails.offerLinks'])
    //     //     ->whereHas('client', function ($qr) {
    //     //         return $qr->where('client_name', 'like', '%' . request()->search . '%');
    //     //     })
    //     //     ->get()
    //     //     ->map(fn ($item) => [
    //     //         'value'                 => $item->client->client_name,
    //     //         'label'                 => $item->client->client_name . ' ( ' . ($item?->mq_no ?? '') . ' )',
    //     //         'client_no'             => $item->client_no,
    //     //         'client_id'             => $item->client->id,
    //     //         'offer_id'              => $item->id,
    //     //         'mq_no'                 => $item->mq_no,
    //     //         'billing_address'       => BillingAddress::where('client_no', $item->client_no)->get(),
    //     //         'collection_address'    => CollectionAddress::where('client_no', $item->client_no)->get(),
    //     //         'details'               => $item->offerDetails
    //     //     ]);
    //     // return response()->json($items);
    // }

}
