<?php

namespace Modules\Networking\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Admin\Entities\Ip;
use Illuminate\Routing\Controller;
use App\Models\Dataencoding\Employee;
use Carbon\Carbon;
use Modules\Networking\Entities\Activation;
use Modules\Sales\Entities\SaleDetail;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\Pop;
use Modules\Sales\Entities\SaleProductDetail;
use Modules\Networking\Entities\ClientFacility;
use Modules\Networking\Entities\LogicalConnectivity;
use Modules\Networking\Entities\PhysicalConnectivity;
use Modules\Networking\Entities\BandwidthDestribution;
use Modules\Networking\Entities\Connectivity;
use Modules\Networking\Entities\PhysicalConnectivityLines;
use Modules\SCM\Entities\ScmMur;

class ConnectivityController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $salesDetails = SaleDetail::query()
            ->with('sale', 'client', 'frDetails', 'saleProductDetails')
            ->latest()
            ->get();

        return view('networking::connectivities.index', compact('salesDetails'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($fr_no = null)
    {
        // dd(request()->all());
        $salesDetail = SaleDetail::query()
            ->with('sale', 'client', 'frDetails')
            ->where('fr_no', $fr_no)
            ->first();
        // dd($salesDetail);

        $employees = Employee::latest()->get();

        $physicalConnectivity = PhysicalConnectivity::query()
            ->whereSaleIdAndFrNo($salesDetail->sale_id, $salesDetail->fr_no)
            ->with('lines')
            ->latest()
            ->first();

        $logicalConnectivities = LogicalConnectivity::with(['lines.product'])
            ->forProductCategories(['VAS', 'Data', 'Internet'])
            ->whereClientNoAndFrNo(@$physicalConnectivity->client_no, @$physicalConnectivity->fr_no)
            ->latest()
            ->get()
            ->keyBy('product_category');

        $facilityTypes = explode(',', $logicalConnectivities->get('Internet')?->facility_type);

        $logicalConnectivityBandwidths = BandwidthDestribution::query()
            ->where('logical_connectivity_id', $logicalConnectivities->get('Internet')?->id)
            ->with('ip')
            ->get();

        $clientFacility = ClientFacility::query()
            ->where('logical_connectivity_id', $logicalConnectivities->get('Internet')?->id)
            ->first();

        $connectivity = Connectivity::query()
            ->with('employee')
            ->where('fr_no', $fr_no)
            ->where('is_modify', '0')
            ->first();
        return view('networking::connectivities.create', compact('salesDetail', 'employees', 'physicalConnectivity', 'logicalConnectivityBandwidths', 'logicalConnectivities', 'facilityTypes', 'clientFacility', 'connectivity'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store()
    {
        try {
            $connectivity = Connectivity::create(request()->all());
            $data = request()->only('client_no', 'fr_no', 'is_active');
            $data['connectivity_id'] = $connectivity->id;
            Activation::create($data);
            return redirect()->back()->with('message', 'Data has been inserted successfully');
        } catch (\Exception $e) {
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

    public function activeClientsReport()
    {
        $activations = Activation::where('is_active', 'Active')->get();
        $fr_nos = $activations->pluck('fr_no')->toArray();
        $sale_ids = Connectivity::whereIn('fr_no', $fr_nos)->pluck('sale_id');
        $sale_detail_ids = SaleDetail::whereIn('sale_id', $sale_ids)->pluck('id');
        $products = SaleProductDetail::whereIn('sale_detail_id', $sale_detail_ids)->pluck('product_name');
        return view('networking::reports.active_clients', compact('activations', 'products'));
    }

    public function activeClientsReportDetails($fr_no)
    {
        $salesDetail = SaleDetail::query()
            ->with('sale', 'client', 'frDetails')
            ->where('fr_no', $fr_no)
            ->first();

        $employees = Employee::latest()->get();

        $physicalConnectivity = PhysicalConnectivity::query()
            ->whereSaleIdAndFrNo($salesDetail->sale_id, $salesDetail->fr_no)
            ->with('lines')
            ->latest()
            ->first();

        $logicalConnectivities = LogicalConnectivity::with(['lines.product'])
            ->forProductCategories(['VAS', 'Data', 'Internet'])
            ->whereClientNoAndFrNo(@$physicalConnectivity->client_no, @$physicalConnectivity->fr_no)
            ->latest()
            ->get()
            ->keyBy('product_category');

        $facilityTypes = explode(',', $logicalConnectivities->get('Internet')?->facility_type);

        $logicalConnectivityBandwidths = BandwidthDestribution::query()
            ->where('logical_connectivity_id', $logicalConnectivities->get('Internet')?->id)
            ->with('ip')
            ->get();

        $clientFacility = ClientFacility::query()
            ->where('logical_connectivity_id', $logicalConnectivities->get('Internet')?->id)
            ->first();

        $connectivity = Connectivity::query()
            ->with('employee')
            ->whereSaleId($salesDetail->sale_id)
            ->first();

        return view('networking::reports.active_client_details', compact('salesDetail', 'employees', 'physicalConnectivity', 'logicalConnectivityBandwidths', 'logicalConnectivities', 'facilityTypes', 'clientFacility', 'connectivity'));
    }

    public function popWiseClientReport()
    {
        if (request()->has('pop_id')) {
            $pop_id = request()->pop_id;
            $datas = PhysicalConnectivity::query()
                ->whereHas('lines', function ($query) use ($pop_id) {
                    $query->where('pop_id', $pop_id);
                })
                ->with('lines', 'client', 'logicalConnectivity')
                ->get()
                ->groupBy('client_no');
            $pop_wise_clients = [];
            foreach ($datas as $client) {
                $pop_wise_clients[$client->first()->client_no] = [
                    'client_name' => $client->first()->client->client_name,
                    'client_no' => $client->first()->client_no,
                    'physical' => $client->first()->lines,
                    'logical' => $client->first()->logicalConnectivity->lines,
                ];
            }

            $pops = Pop::latest()->get();
            return view('networking::reports.pop-wise-client-report', compact('pop_wise_clients', 'pops'));
        } else {
            $pops = Pop::latest()->get();
            $pop_wise_clients = '';
            return view('networking::reports.pop-wise-client-report', compact('pops', 'pop_wise_clients'));
        }
    }

    public function popWiseEquipmentReport()
    {
        $data = [];
        ScmMur::query()
            ->where('pop_id', request()->pop_id)
            ->with(['lines.material', 'lines.brand'])
            ->get()->map(function ($item) use (&$data) {
                $item->lines->map(function ($line) use (&$data) {
                    $data[] = [
                        'label' => $line->material->name . ' - ' . $line->brand->name . ' - ' . $line->model . ' - ' . $line->serial_code,
                        'value' => $line->material_id,
                        'material_id' => $line->material_id,
                        'brand_id' => $line->brand_id,
                        'model' => $line->model,
                        'serial_code' => $line->serial_code,
                        'quantity' => $line->quantity,
                        'unit_price' => $line->unit_price,
                        'total_price' => $line->total_price,
                        'remarks' => $line->remarks,
                        'created_at' => $line->created_at,
                        'updated_at' => $line->updated_at,
                        'material' => $line->material->name,
                        'brand' => $line->brand->name,
                    ];
                    return $data;
                });
            });
    }
}
