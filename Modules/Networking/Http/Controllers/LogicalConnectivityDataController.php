<?php

namespace Modules\Networking\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Sales\Entities\Product;
use Modules\Sales\Entities\SaleDetail;
use Modules\Networking\Entities\DataType;
use Illuminate\Contracts\Support\Renderable;
use Modules\Admin\Entities\Ip;
use Modules\Networking\Entities\LogicalConnectivity;
use Modules\Networking\Entities\LogicalConnectivityLine;
use Modules\Networking\Entities\PhysicalConnectivity;

class LogicalConnectivityDataController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $logicalConnectivityDatas = LogicalConnectivity::query()
            ->whereProductCategory('Data')
            ->with('lines')
            ->latest()
            ->get();
        return view('networking::logical-data-connectivities.index', compact('logicalConnectivityDatas'));
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
            ->latest()
            ->first();

        $physicalConnectivityData = PhysicalConnectivity::query()
            ->whereSaleIdAndFrNo($saleDetalis->sale_id, $saleDetalis->fr_no)
            ->with('lines')
            ->latest()
            ->first();

        if (!$physicalConnectivityData) return redirect()->back()->with('message', 'Please create Physical Connectivity Data first!');

        $dataTypes = DataType::query()
            ->latest()
            ->get();

        $products = Product::whereHas('category', function ($query) {
            $query->where('name', 'Data');
        })->get();

        $dedicated_ipv4Ips = LogicalConnectivityLine::distinct('ip_ipv4')
            ->whereNotNull('ip_ipv4')
            ->where('ip_ipv4', '!=', '')
            ->pluck('ip_ipv4')
            ->toArray();

        $dedicated_ipv6Ips = LogicalConnectivityLine::distinct('ip_ipv6')
            ->whereNotNull('ip_ipv6')
            ->where('ip_ipv6', '!=', '')
            ->pluck('ip_ipv6')
            ->toArray();
        $ipv4Ips = Ip::where('ip_type', 'IPv4')->whereNotIn('address', $dedicated_ipv4Ips)->latest()->get();
        $ipv6Ips = Ip::where('ip_type', 'IPv6')->whereNotIn('address', $dedicated_ipv6Ips)->latest()->get();



        $logicalConnectivityData = LogicalConnectivity::query()
            ->where([
                'fr_no' => $physicalConnectivityData->fr_no,
                'client_no' => $physicalConnectivityData->client_no,
                'product_category' => 'Data'
            ])
            ->with('lines.product')
            ->latest()
            ->first();

        return view('networking::logical-data-connectivities.create', compact('saleDetalis', 'physicalConnectivityData', 'dataTypes', 'logicalConnectivityData', 'products', 'ipv4Ips', 'ipv6Ips'));
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
                    'product_category' => 'Data',
                    'data_type' => $request->data_type[$key],
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

            $request->merge([
                'product_category' => 'Data',
            ]);

            $logicalConnectivity = LogicalConnectivity::updateOrCreate(
                [
                    'fr_no' => $request->fr_no,
                    'client_no' => $request->client_no,
                    'product_category' => 'Data'
                ],
                $request->all()
            );

            // $logicalConnectivity->lines()->delete();
            $logicalConnectivity->lines()->createMany($dataList);

            DB::commit();

            return redirect('networking/logical-data-connectivities')->with('message', 'Logical Connectivity Data created successfully!');
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
        $logicalConnectivityData = LogicalConnectivity::query()
            ->whereId($id)
            ->with('lines.product')
            ->first();

        $physicalConnectivityData = PhysicalConnectivity::query()
            ->whereSaleIdAndFrNo($logicalConnectivityData->sale_id, $logicalConnectivityData->fr_no)
            ->with('lines')
            ->latest()
            ->first();

        $saleDetalis = SaleDetail::query()
            ->whereSaleIdAndFrNo($logicalConnectivityData->sale_id, $logicalConnectivityData->fr_no)
            ->with('client', 'frDetails')
            ->latest()
            ->first();

        $dataTypes = DataType::query()
            ->latest()
            ->get();

        $products = Product::whereHas('category', function ($query) {
            $query->where('name', 'Data');
        })->get();

        $dedicated_ipv4Ips = LogicalConnectivityLine::distinct('ip_ipv4')
            ->whereNotNull('ip_ipv4')
            ->where('logical_connectivity_id', '!=', $id)
            ->where('ip_ipv4', '!=', '')
            ->pluck('ip_ipv4')
            ->toArray();

        $dedicated_ipv6Ips = LogicalConnectivityLine::distinct('ip_ipv6')
            ->whereNotNull('ip_ipv6')
            ->where('logical_connectivity_id', '!=', $id)
            ->where('ip_ipv6', '!=', '')
            ->pluck('ip_ipv6')
            ->toArray();
        $ipv4Ips = Ip::where('ip_type', 'IPv4')->whereNotIn('address', $dedicated_ipv4Ips)->latest()->get();
        $ipv6Ips = Ip::where('ip_type', 'IPv6')->whereNotIn('address', $dedicated_ipv6Ips)->latest()->get();

        return view('networking::logical-data-connectivities.create', compact('logicalConnectivityData', 'physicalConnectivityData', 'saleDetalis', 'dataTypes', 'products', 'ipv4Ips', 'ipv6Ips'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {

        try {
            DB::beginTransaction();

            $dataList = [];
            foreach ($request->product_id as $key => $value) {
                $dataList[] = [
                    'product_id' => $value,
                    'product_category' => 'Data',
                    'data_type' => $request->data_type[$key],
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

            $request->merge([
                'product_category' => 'Data',
            ]);

            $logicalConnectivity = LogicalConnectivity::updateOrCreate(
                [
                    'id' => $id,
                ],
                $request->all()
            );

            $logicalConnectivity->lines()->delete();
            $logicalConnectivity->lines()->createMany($dataList);

            DB::commit();

            return redirect('networking/logical-data-connectivities')->with('message', 'Logical Connectivity Data updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $logicalConnectivity = LogicalConnectivity::query()
                ->whereId($id)
                ->first();

            $logicalConnectivity->lines()->delete();
            $logicalConnectivity->delete();

            DB::commit();

            return redirect()->back()->with('message', 'Logical Connectivity Data deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}
