<?php

namespace Modules\Changes\Http\Controllers;

use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Sales\Entities\ConnectivityRequirement;
use Modules\Sales\Entities\Costing;
use Modules\Sales\Entities\LeadGeneration;
use Modules\Sales\Entities\Offer;
use Modules\Sales\Entities\Product;
use Modules\Sales\Entities\FeasibilityRequirement;
use Modules\Sales\Entities\FeasibilityRequirementDetail;

class OfferModificationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $offers = Offer::with('offerDetails.offerLinks')->where('is_modified', 1)->latest()->get();
        return view('changes::modify_offer.index', compact('offers'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable                                                                  
     */
    public function create($connectivity_requirement_id = null)
    {
        $connectivity_requirement = ConnectivityRequirement::with('costingByConnectivity')->where('id', $connectivity_requirement_id)->first();
        return view('changes::modify_offer.create', compact('connectivity_requirement'));
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
            return redirect()->route('offer-modification.index')->with('success', 'Offer created successfully.');
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
        $offer = Offer::with('offerDetails.offerLinks', 'connectivityRequirementModification')->find($id);
        return view('changes::modify_offer.edit', compact('offer'));
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
            $requestData['is_modified'] = 1;
            $offer = Offer::create($requestData);
            $offerDetail = $this->createOfferDetails($offer, $requestData);
            $details = $offer->offerDetails()->create($offerDetail);
            $details->offerLinks()->createMany($offerDetail['offerLinks']);
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
            $details = $offer->offerDetails()->create($offerDetails);
            $details->offerLinks()->createMany($offerDetails['offerLinks']);
            DB::commit();
            return $offer;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    function createOfferDetails($offer, $requestData)
    {
        $offerDetails = [
            'offer_id' => $offer->id,
            'fr_no' => $requestData['fr_no'],
            'client_equipment_total' => $requestData['client_equipment_total'],
            'link_invest' => $requestData['link_invest'],
            'month' => $requestData['month'],
            'capacity_amount' => $requestData['capacity_amount'],
            'operation_cost' => $requestData['operation_cost'],
            'total_otc' => $requestData['total_otc'],
            'total_roi' => $requestData['total_roi'],
            'total_offer_otc' => $requestData['total_offer_otc'],
            'grand_total_otc' => $requestData['grand_total_otc'],
            'total_offer_mrc' => $requestData['total_offer_mrc'],
            'product_equipment_price' => $requestData['product_equipment_price'],
            'equipment_otc' => $requestData['equipment_otc'],
            'equipment_roi' => $requestData['equipment_roi'],
            'equipment_offer_price' => $requestData['equipment_offer_price'],
            'equipment_total_otc' => $requestData['equipment_total_otc'],
            'equipment_total_mrc' => $requestData['equipment_total_mrc'],
            'product_amount' => $requestData['product_amount'],
            'offer_product_amount' => $requestData['offer_product_amount'],
            'management_cost' => $requestData['management_cost'],
            'offer_management_cost' => $requestData['offer_management_cost'],
            'grand_total' => $requestData['grand_total'],
        ];
        $offerLinks = $this->createOfferLinks($offer, $requestData);
        $offerDetails['offerLinks'] = $offerLinks;
        return $offerDetails;
    }

    function createOfferLinks($offer, $requestData)
    {
        $offerLinks = [];
        $linkStatuses = $requestData['link_status'] ?? [];
        if (!empty($requestData['link_no'])) {
            foreach ($requestData['link_no'] as $key => $linkNo) {
                $linkStatus = $linkStatuses[$key] ?? 0;
                $offerLinks[] = [
                    'offer_id' => $offer->id,
                    'link_no' => $requestData['link_no'][$key] ?? '',
                    'link_type' => $requestData['link_type'][$key] ?? '',
                    'link_status' => $requestData['link_status'][$key] ?? '0',
                    'option' => $requestData['option'][$key] ?? '',
                    'connectivity_status' => $requestData['connectivity_status'][$key] ?? '',
                    'method' => $requestData['method'][$key] ?? '',
                    'vendor' => $requestData['vendor'][$key] ?? '',
                    'bts_pop_ldp' => $requestData['bts_pop_ldp'][$key] ?? '',
                    'distance' => $requestData['distance'][$key] ?? '',
                    'client_equipment_amount' => $requestData['client_equipment_amount'][$key] ?? '',
                    'otc' => $requestData['otc'][$key] ?? '',
                    'mo_cost' => $requestData['mo_cost'][$key] ?? '',
                    'offer_otc' => $requestData['offer_otc'][$key] ?? '',
                    'total_cost' => $requestData['total_cost'][$key] ?? '',
                    'offer_mrc' => $requestData['offer_mrc'][$key] ?? '',
                ];
            }
        }
        return $offerLinks;
    }
}
