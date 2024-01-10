<?php

namespace Modules\Sales\Http\Controllers;

use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Sales\Entities\Costing;
use Modules\Sales\Entities\LeadGeneration;
use Modules\Sales\Entities\Offer;
use Modules\Sales\Entities\Product;
use Modules\Sales\Entities\FeasibilityRequirement;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    function __construct()
    {
        $this->middleware('permission:offer-view|offer-create|offer-edit|offer-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:offer-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:offer-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:offer-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $from_date = request()->from_date ? date('Y-m-d', strtotime(request()->from_date)) : '';
        $to_date =  request()->to_date ? date('Y-m-d', strtotime(request()->to_date)) : '';
        $offers = Offer::with('offerDetails.offerLinks')->where('is_modified', 0)
            ->when($from_date, function ($query, $from_date) {
                return $query->whereDate('created_at', '>=', $from_date);
            })
            ->when($to_date, function ($query, $to_date) {
                return $query->whereDate('created_at', '<=', $to_date);
            })
            ->latest()
            ->get();
        return view('sales::offers.index', compact('offers'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($mq_no = null)
    {
        $feasibility_requirement = FeasibilityRequirement::with('feasibilityRequirementDetails.costing')->where('mq_no', $mq_no)->first();
        return view('sales::offers.create', compact('feasibility_requirement'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $data = $request->all();
        try {

            $offer = $this->createOffer($data);
            return redirect()->route('offers.index')->with('success', 'Offer created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('sales::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $offer = Offer::with('offerDetails.offerLinks')->find($id);
        return view('sales::offers.edit', compact('offer'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        try {
            $offer = $this->updateOffer($data, $id);
            return redirect()->route('offers.index')->with('success', 'Offer created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Offer $offer)
    {
        try {
            if ($offer->sale()->exists()) {
                return redirect()->route('offers.index')->with('message', 'Please delete Sales Data first');
            } else {
                $offer->delete();
            }

            return redirect()->route('offers.index')->with('message', 'Offer Deleted Successfully');
        } catch (Exception $err) {
            return redirect()->back()->with('error', $err->getMessage())->withInput();
        }
    }

    public function clientWiseMq(Request $request)
    {
        $client_id = $request->client_id;
        $mq = FeasibilityRequirement::where('client_id', $client_id)->pluck('mq_no');
        return $mq;
    }

    function createOffer($requestData)
    {
        $offer = null;

        try {
            DB::beginTransaction();

            $offer = Offer::create($requestData);
            $offerDetails = $this->createOfferDetails($offer, $requestData);
            $details = $offer->offerDetails()->createMany($offerDetails)->each(function ($offerDetail, $key) use ($offerDetails) {
                $offerDetail->offerLinks()->createMany($offerDetails[$key]['offerLinks']);
            });
            DB::commit();

            return $offer;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    function updateOffer($requestData, $id)
    {
        $offer = null;

        try {
            DB::beginTransaction();

            $offer = Offer::find($id);
            $offer->update($requestData);
            $offerDetails = $this->createOfferDetails($offer, $requestData);

            $details = $offer->offerDetails()->delete();
            $details = $offer->offerDetails()->createMany($offerDetails)->each(function ($offerDetail, $key) use ($offerDetails) {
                $offerDetail->offerLinks()->delete();
                $offerDetail->offerLinks()->createMany($offerDetails[$key]['offerLinks']);
            });
            DB::commit();

            return $offer;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    function createOfferDetails($offer, $requestData)
    {
        $offerDetails = [];
        for ($i = 1; $i <= $requestData['row_no']; $i++) {
            $offerDetails[] = [
                'offer_id' => $offer->id,
                'fr_no' => $requestData['fr_no_' . $i],
                'client_equipment_total' => $requestData['client_equipment_total_' . $i],
                'total_otc' => $requestData['total_otc_' . $i],
                'total_roi' => $requestData['total_roi_' . $i],
                'total_offer_otc' => $requestData['total_offer_otc_' . $i],
                'grand_total_otc' => $requestData['grand_total_otc_' . $i],
                'total_offer_mrc' => $requestData['total_offer_mrc_' . $i],
                'product_equipment_price' => $requestData['product_equipment_price_' . $i],
                'equipment_otc' => $requestData['equipment_otc_' . $i],
                'equipment_roi' => $requestData['equipment_roi_' . $i],
                'equipment_offer_price' => $requestData['equipment_offer_price_' . $i],
                'equipment_total_otc' => $requestData['equipment_total_otc_' . $i],
                'equipment_total_mrc' => $requestData['equipment_total_mrc_' . $i],
                'product_amount' => $requestData['product_amount_' . $i],
                'offer_product_amount' => $requestData['offer_product_amount_' . $i],
                'management_cost' => $requestData['management_cost_' . $i],
                'offer_management_cost' => $requestData['offer_management_cost_' . $i],
                'grand_total' => $requestData['grand_total_' . $i],
            ];
            $offerLinks = $this->createOfferLinks($offer, $requestData, $i);
            $offerDetails[$i - 1]['offerLinks'] = $offerLinks;
        }
        return $offerDetails;
    }

    function createOfferLinks($offer, $requestData, $index)
    {
        $offerLinks = [];
        $linkStatuses = $requestData['link_status' . "_" . $index] ?? [];
        if (!empty($requestData['link_no' . '_' . $index])) {
            foreach ($requestData['link_no' . '_' . $index] as $key => $linkNo) {

                $linkStatus = $linkStatuses[$key] ?? 0;

                $offerLinks[] = [
                    'offer_id' => $offer->id,
                    'link_no' => $requestData['link_no' . '_' . $index][$key] ?? '',
                    'link_type' => $requestData['link_type' . "_" . $index][$key] ?? '',
                    'link_status' => $requestData['link_status' . "_" . $index][$key] ?? '0',
                    'option' => $requestData['option' . "_" . $index][$key] ?? '',
                    'connectivity_status' => $requestData['connectivity_status' . "_" . $index][$key] ?? '',
                    'method' => $requestData['method' . "_" . $index][$key] ?? '',
                    'vendor' => $requestData['vendor' . "_" . $index][$key] ?? '',
                    'bts_pop_ldp' => $requestData['bts_pop_ldp' . "_" . $index][$key] ?? '',
                    'distance' => $requestData['distance' . "_" . $index][$key] ?? '',
                    'client_equipment_amount' => $requestData['client_equipment_amount' . "_" . $index][$key] ?? '',
                    'otc' => $requestData['otc' . "_" . $index][$key] ?? '',
                    'mo_cost' => $requestData['mo_cost' . "_" . $index][$key] ?? '',
                    'offer_otc' => $requestData['offer_otc' . "_" . $index][$key] ?? '',
                    'total_cost' => $requestData['total_cost' . "_" . $index][$key] ?? '',
                    'offer_mrc' => $requestData['offer_mrc' . "_" . $index][$key] ?? '',
                ];
            }
        }
        return $offerLinks;
    }

    public function modifiedList()
    {
        $offers = Offer::with('offerDetails.offerLinks')
            ->where('is_modified', 1)
            ->latest()
            ->get();
        return view('sales::offers.modification_list', compact('offers'));
    }
}
