<?php

namespace Modules\Networking\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Admin\Entities\Ip;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Sales\Entities\SaleDetail;
use Illuminate\Contracts\Support\Renderable;
use Modules\Sales\Entities\SaleProductDetail;
use Modules\Networking\Entities\ClientFacility;
use Modules\Networking\Entities\LogicalConnectivity;
use Modules\Networking\Entities\PhysicalConnectivity;
use Modules\Networking\Entities\BandwidthDestribution;
use Modules\Networking\Entities\LogicalConnectivityLine;

class LogicalConnectivityInternetController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('networking::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $saleDetalis = SaleDetail::query()
            ->whereSaleIdAndFrNo(request()->get('sale_id'), request()->get('fr_no'))
            ->with('client', 'frDetails')
            ->first();
        // dd($saleDetalis);

        @$physicalConnectivityData = PhysicalConnectivity::query()
            ->whereSaleIdAndFrNo($saleDetalis->sale_id, $saleDetalis->fr_no)
            ->with('lines')
            ->latest()
            ->first();
        // dd($physicalConnectivityData);

        $products = SaleProductDetail::query()
            ->whereHas('product.category', function ($query) use ($physicalConnectivityData) {
                $query->where('fr_no', @$physicalConnectivityData->fr_no);
            })
            ->with('product')
            ->get()
            ->unique('product_id');

        $dedicated_ipv4Ips = LogicalConnectivityLine::select('ip_ipv4')
            ->where('ip_ipv4', '!=', null)
            ->where('ip_ipv4', '!=', '')
            ->get()
            ->unique('ip_ipv4');
        $dedicated_ipv4Ips = $dedicated_ipv4Ips->pluck('ip_ipv4')->toArray();

        $dedicated_ipv6Ips = LogicalConnectivityLine::select('ip_ipv6')
            ->where('ip_ipv6', '!=', null)
            ->where('ip_ipv6', '!=', '')
            ->get()
            ->unique('ip_ipv6');
        $dedicated_ipv6Ips = $dedicated_ipv6Ips->pluck('ip_ipv6')->toArray();
        $ips = Ip::latest()->get();
        $ipv4Ips = Ip::where('ip_type', 'IPv4')->whereNotIn('address', $dedicated_ipv4Ips)->latest()->get();
        $ipv6Ips = Ip::where('ip_type', 'IPv6')->whereNotIn('address', $dedicated_ipv6Ips)->latest()->get();

        $logicalConnectivityInternet = LogicalConnectivity::query()
            ->where([
                'fr_no' => @$physicalConnectivityData->fr_no,
                'client_no' => @$physicalConnectivityData->client_no,
                'product_category' => 'Internet'
            ])
            ->with('lines.product')
            ->latest()
            ->first();

        if ($logicalConnectivityInternet) {
            $logicalConnectivityBandwidths = BandwidthDestribution::query()
                ->where('logical_connectivity_id', $logicalConnectivityInternet->id)
                ->with('ip')
                ->get();
        } else {
            $logicalConnectivityBandwidths = [];
        }

        //explode facility type
        $facilityTypes = explode(',', @$logicalConnectivityInternet->facility_type);

        $clientFacility = ClientFacility::query()
            ->where('logical_connectivity_id', @$logicalConnectivityInternet->id)
            ->first();

        return view('networking::logical-internet-connectivities.create', compact('saleDetalis', 'physicalConnectivityData', 'logicalConnectivityInternet', 'products', 'ips', 'ipv4Ips', 'ipv6Ips', 'logicalConnectivityBandwidths', 'facilityTypes', 'clientFacility'));
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

            $dataList = [];
            foreach ($request->product_id as $key => $value) {
                $dataList[] = [
                    'product_id' => $value,
                    'product_category' => 'Internet',
                    'quantity' => $request->quantity[$key],
                    'ip_ipv4' => $request->ip_ipv4[$key],
                    'ip_ipv6' => $request->ip_ipv6[$key],
                    'subnetmask' => $request->subnetmask[$key],
                    'gateway' => $request->gateway[$key],
                    'vlan' => $request->vlan[$key],
                    'mrtg_user' => $request->mrtg_user[$key],
                    'mrtg_pass' => $request->mrtg_pass[$key]
                ];
            }

            $bandwidthDataList = [];
            foreach ($request->bandwidth as $key => $value) {
                $bandwidthDataList[] = [
                    'bandwidth' => $value,
                    'ip_id' => $request->ip_address[$key],
                    'remarks' => $request->remarks[$key],
                ];
            }

            //check if facility type is checked and merge it to request data as comma separated string
            $checkboxes = ['dns_checkbox', 'vpn_checkbox', 'smtp_checkbox', 'vc_checkbox', 'bgp_checkbox'];

            $facilityTypes = collect($checkboxes)
                ->map(function ($checkbox) use ($request) {
                    return $request->has($checkbox) ? substr($checkbox, 0, -9) : null;
                })
                ->filter()
                ->implode(',');

            $request->merge([
                'facility_type' => $facilityTypes,
                'product_category' => 'Internet',
            ]);

            $logicalConnectivity = LogicalConnectivity::updateOrCreate(
                [
                    'fr_no' => $request->fr_no,
                    'client_no' => $request->client_no,
                    'product_category' => 'Internet'
                ],
                $request->all()
            );

            $logicalConnectivity->lines()->delete();
            $logicalConnectivity->lines()->createMany($dataList);

            $logicalConnectivity->bandwidths()->delete();
            $logicalConnectivity->bandwidths()->createMany($bandwidthDataList);

            $logicalConnectivity->clientFacility()->delete();
            $logicalConnectivity->clientFacility()->create($request->all());

            DB::commit();

            return redirect()->back()->with('message', 'Logical Connectivity for Internet created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('networking::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('networking::edit');
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
