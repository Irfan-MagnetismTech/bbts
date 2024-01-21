<?php

namespace Modules\Networking\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Admin\Entities\Branch;
use Modules\Admin\Entities\Ip;
use Illuminate\Routing\Controller;
use App\Models\Dataencoding\Employee;
use Carbon\Carbon;
use PDF;
use Modules\Networking\Entities\Activation;
use Modules\Networking\Entities\LogicalConnectivityLine;
use Modules\Sales\Entities\FeasibilityRequirementDetail;
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
use Modules\Networking\Entities\NetPopEquipment;
use Modules\Networking\Entities\PhysicalConnectivityLines;
use Modules\Networking\Http\Requests\ConnectivityRequest;
use Modules\Sales\Entities\Client;
use Modules\Sales\Entities\ConnectivityRequirement;
use Modules\SCM\Entities\ScmErr;
use Modules\SCM\Entities\ScmMur;
use Modules\SCM\Entities\StockLedger;

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

    public function ipReport(Request $request)
    {
        $branch_id = $request->branch_id;
        $ip_address = $request->ip_address;
        $branches = Branch::get();

        if ($branch_id == null && $ip_address != null) {
            $logical_connectivities = LogicalConnectivity::with('lines')
                ->whereHas('lines', function ($query) use ($ip_address) {
                    $query->where('ip_ipv4', $ip_address)
                        ->orWhere('ip_ipv6', $ip_address);
                })->get();
        } elseif ($branch_id != null && $ip_address == null) {
            $logical_connectivities = LogicalConnectivity::with('feasibilityRequirementDetails')
                ->whereHas('feasibilityRequirementDetails.branch', function ($query) use ($branch_id) {
                    $query->where('id', $branch_id);
                })->get();
        } elseif ($branch_id != null && $ip_address != null) {
            $logical_connectivities = LogicalConnectivity::with(['feasibilityRequirementDetails', 'lines'])
                ->whereHas('feasibilityRequirementDetails.branch', function ($query) use ($branch_id) {
                    $query->where('id', $branch_id);
                })
                ->whereHas('lines', function ($query) use ($ip_address) {
                    $query->where('ip_ipv4', $ip_address)
                        ->orWhere('ip_ipv6', $ip_address);
                })->get();
        } else {
            $logical_connectivities = LogicalConnectivity::get();
        }
        if ($request->type === 'pdf') {
            return PDF::loadView('networking::reports.ip_report_pdf', ['logical_connectivities' => $logical_connectivities, 'branches' => $branches, 'branch_id' => $branch_id, 'ip_address' => $ip_address], [], [
                'format' => 'A4',
                'orientation' => 'L',
                'title' => 'IP Report PDF',
                'watermark' => 'BBTS',
                'show_watermark' => true,
                'watermark_text_alpha' => 0.1,
                'watermark_image_path' => '',
                'watermark_image_alpha' => 0.2,
                'watermark_image_size' => 'D',
                'watermark_image_position' => 'P',
            ])->stream('ip_report.pdf');
            return view('networking::reports.ip_report_pdf', compact('logical_connectivities', 'branches', 'branch_id', 'ip_address'));
        } else {
            return view('networking::reports.ip_report', compact('logical_connectivities', 'branches', 'branch_id', 'ip_address'));
        }
    }

    public function vlanReport(Request $request)
    {
        $branch_id = $request->branch_id;
        $vlan_address = $request->vlan_address;
        $branches = Branch::get();

        if ($branch_id == null && $vlan_address != null) {
            $logical_connectivities = LogicalConnectivity::with('lines')
                ->whereHas('lines', function ($query) use ($vlan_address) {
                    $query->where('vlan', $vlan_address);
                })->get();
        } elseif ($branch_id != null && $vlan_address == null) {
            $logical_connectivities = LogicalConnectivity::with('feasibilityRequirementDetails')
                ->whereHas('feasibilityRequirementDetails.branch', function ($query) use ($branch_id) {
                    $query->where('id', $branch_id);
                })->get();
        } elseif ($branch_id != null && $vlan_address != null) {
            $logical_connectivities = LogicalConnectivity::with(['feasibilityRequirementDetails', 'lines'])
                ->whereHas('feasibilityRequirementDetails.branch', function ($query) use ($branch_id) {
                    $query->where('id', $branch_id);
                })
                ->whereHas('lines', function ($query) use ($vlan_address) {
                    $query->where('vlan', $vlan_address);
                })->get();
        } else {
            $logical_connectivities = LogicalConnectivity::get();
        }

        if ($request->type === 'pdf') {
            return PDF::loadView('networking::reports.vlan_report_pdf', ['logical_connectivities' => $logical_connectivities, 'branches' => $branches, 'branch_id' => $branch_id, 'vlan_address' => $vlan_address], [], [
                'format' => 'A4',
                'orientation' => 'L',
                'title' => 'VLAN Report PDF',
                'watermark' => 'BBTS',
                'show_watermark' => true,
                'watermark_text_alpha' => 0.1,
                'watermark_image_path' => '',
                'watermark_image_alpha' => 0.2,
                'watermark_image_size' => 'D',
                'watermark_image_position' => 'P',
            ])->stream('vlan_report.pdf');
            return view('networking::reports.vlan_report_pdf', compact('logical_connectivities', 'branches', 'branch_id', 'vlan_address'));
        } else {
            return view('networking::reports.vlan_report', compact('logical_connectivities', 'branches', 'branch_id', 'vlan_address'));
        }
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
            foreach ($datas as $data) {
                $pop_wise_clients[$data->first()->client_no] = [
                    'client_name' => $data->first()->client->client_name,
                    'client_no' => $data->first()->client_no,
                    'physical' => $data->first()->lines,
                    'logical' => $data->first()->logicalConnectivity->lines,
                ];
            }
            $pops = Pop::latest()->get();
            if (request('type') == 'PDF') {
                $pdf = PDF::loadView('networking::pdf.pop-wise-client-report', ['pop_wise_clients' => $pop_wise_clients], [], [
                    'format' => 'A4',
                    'orientation' => 'L'
                ]);
                return $pdf->stream('pop-wise-client-report.pdf');
            } else {
                return view('networking::reports.pop-wise-client-report', compact('pop_wise_clients', 'pops'));
            }
        } else {
            $pops = Pop::latest()->get();
            $pop_wise_clients = '';
            return view('networking::reports.pop-wise-client-report', compact('pops', 'pop_wise_clients'));
        }
    }

    public function popWiseEquipmentReport()
    {
        $pop_wise_equipments = [];

        $data = NetPopEquipment::query()
            ->when(!empty(request()->pop_id), function ($query) {
                $query->where('pop_id', request()->pop_id);
            })
            ->with('pop', 'material', 'ip') // Assuming 'ip' is the relationship for the 'ip' table
            ->get()
            ->groupBy(function ($item) {
                return $item->pop->name;
            })
            ->map(function ($group, $popName) use (&$pop_wise_equipments) {
                $pop_wise_equipments[] = [
                    'pop_name' => $popName,
                    'location' => $group->first()->pop->address,
                    'equipments' => $group->map(function ($item) {
                        return [
                            'pop_id' => $item->pop_id ?? '',
                            'material' => $item->material ?? '',
                            'brand' => $item->brand ?? '',
                            'model' => $item->model ?? '',
                            'ip_address' => $item->ip->address ?? '',
                            'subnet_mask' => $item->subnet_mask ?? '',
                            'gateway' => $item->gateway ?? '',
                            'remarks' => $item->remarks ?? '',
                        ];
                    })->toArray(),
                ];
            });
        $pops = Pop::latest()->get();


        if (request('type') == 'PDF') {
            $pdf = PDF::loadView('networking::pdf.pop-wise-equipment-report', ['pop_wise_equipments' => $pop_wise_equipments], [], [
                'format' => 'A4',
                'orientation' => 'L'
            ]);
            return $pdf->stream('pop-wise-equipment-report.pdf');
        } else {
            return view('networking::reports.pop-wise-equipment-report', compact('pop_wise_equipments', 'pops'));
        }
    }



    public function clientWiseEquipmentReport()
    {
        $data = ScmMur::query()
            ->when(!empty(request()->client_no), function ($query) {
                $query->where('client_no', request()->client_no);
            })
            ->with('client', 'feasibilityRequirementDetail', 'lines')
            ->get()
            ->groupBy(['client_no', 'fr_no']);
        $data = $data->filter(function ($item, $key) {
            return $key != null;
        });

        $client_wise_unique_materials = [];

        foreach ($data as $client_no => $client_no_group) {
            foreach ($client_no_group as $fr_no => $fr_group) {
                foreach ($fr_group as $mur) {
                    foreach ($mur->lines as $key => $line) {
                        $compositeKey = $line->material_id . '-' . $line->brand_id;

                        if (!isset($client_wise_unique_materials[$client_no][$fr_no][$compositeKey])) {
                            $client_wise_unique_materials[$client_no][$fr_no][$compositeKey] = [
                                'material_id' => $line->material_id,
                                'material_name' => optional($line->material)->name,
                                'brand_id' => $line->brand_id,
                                'brand_name' => optional($line->brand)->name,
                                'model' => $line->model ?? '',
                                'quantity' => $line->quantity ?? '',
                                'serial_code' => $line->serial_code ?? '',
                            ];
                        } else {
                            $client_wise_unique_materials[$client_no][$fr_no][$compositeKey]['quantity'] += $line->quantity;
                        }
                    }
                }
            }
        }

        // $client_wise_unique_materials = array_values($client_wise_unique_materials);
        //check ScmErr is exit by client_no and fr_no and if exit minus the quantity from client_wise_unique_materials and if it's zero then unset the array
        foreach ($client_wise_unique_materials as $client_no => $client_no_group) {
            foreach ($client_no_group as $fr_no => $fr_group) {
                foreach ($fr_group as $key => $material) {
                    $scm_err = ScmErr::with('scmErrLines')->where('client_no', $client_no)->where('fr_no', $fr_no)->first();
                    if ($scm_err) {
                        foreach ($scm_err->scmErrLines as $scm_err_line) {
                            if ($scm_err_line->material_id == $material['material_id'] && $scm_err_line->brand_id == $material['brand_id']) {
                                $quantity = $client_wise_unique_materials[$client_no][$fr_no][$key]['quantity'];
                                $client_wise_unique_materials[$client_no][$fr_no][$key]['quantity'] = $quantity != '' ? $quantity - $scm_err_line->quantity : 0;
                                if ($client_wise_unique_materials[$client_no][$fr_no][$key]['quantity'] == 0) {
                                    unset($client_wise_unique_materials[$client_no][$fr_no][$key]);
                                }
                            }
                        }
                    }
                }
            }
        }

        $clients = Client::latest()->get();
        if (request('type') == 'PDF') {
            $pdf = PDF::loadView('networking::pdf.client-wise-equipment-report', ['client_wise_unique_materials' => $client_wise_unique_materials], [], [
                'format' => 'A4',
                'orientation' => 'L'
            ]);
            return $pdf->stream('client-wise-equipment-report.pdf');
        }
        return view('networking::reports.client-wise-equipment-report', compact('client_wise_unique_materials', 'clients'));
    }

    public function clientWiseNetIpReport()
    {
        $client_no = request()->client_no;
        $from_date = Carbon::parse(request()->date_from)->format('Y-m-d');
        $to_date = Carbon::parse(request()->date_to)->format('Y-m-d');

        $datas = PhysicalConnectivity::query()
            ->with('lines', 'client', 'logicalConnectivity', 'connectivity', 'feasibilityRequirementDetail') // Assuming 'ip' is the relationship for the 'ip' table
            ->when(!empty($client_no), function ($query) use ($client_no) {
                $query->where('client_no', $client_no);
            })
            ->when(!empty($from_date), function ($query) use ($from_date) {
                $query->whereHas('connectivity', function ($query) use ($from_date) {
                    $query->where('created_at', '>=', $from_date);
                });
            })
            ->when(!empty($to_date), function ($query) use ($to_date) {
                $query->whereHas('connectivity', function ($query) use ($to_date) {
                    $query->where('created_at', '<=', $to_date);
                });
            })
            ->get()
            ->groupBy('client_no');
        $client_ip_infos = [];
        foreach ($datas as $data) {
            $client_ip_infos[$data?->first()->client_no] = [
                'client_name' => $data->first()->client->client_name,
                'client_no' => $data?->first()->client_no,
                'activation_date' => $data?->first()?->connectivity?->commissioning_date,
                'connectivity_point' => $data?->first()?->feasibilityRequirementDetail?->connectivity_point,
                'physical' => $data?->first()->lines,
                'logical' => $data->first()->logicalConnectivity->lines ?? [],
            ];
        }
        $clients = Client::latest()->get();
        if (request('type') == 'PDF') {
            $pdf = PDF::loadView('networking::pdf.pop-wise-client-report', ['client_ip_infos' => $client_ip_infos], [], [
                'format' => 'A4',
                'orientation' => 'L'
            ]);
            return $pdf->stream('pop-wise-client-report.pdf');
        } else {
            return view('networking::reports.client-wise-net-ip-report', compact('client_ip_infos', 'clients'));
        }
    }

    public function permanentlyInactiveClients()
    {
        $permanently_inactive_clients = [];
        $activations = Activation::where('is_active', 'Inactive')->get();
        $fr_nos = $activations->pluck('fr_no')->toArray();
        //get latest connectivity_requirement_id by wherein fr_nos
        $connectivity_requirements = ConnectivityRequirement::whereIn('fr_no', $fr_nos)->latest()->get();
        //remove same fr_no from connectivity_requirements
        $connectivity_requirements = $connectivity_requirements->unique('fr_no');
        foreach ($connectivity_requirements as $connectivity_requirement) {
            $permanently_inactive_clients[] = [
                'client_no' => $connectivity_requirement->client_no,
                'client_name' => $connectivity_requirement->client->client_name,
                'thana' => $connectivity_requirement->client->thana->name ?? '',
                'fr_no' => $connectivity_requirement->fr_no,
                'connectivity_requirement_id' => $connectivity_requirement->id,
                'connectivity_requirement_date' => $connectivity_requirement->created_at,
                'connectivity_requirement_details' => $connectivity_requirement->connectivityRequirementDetails,
                'scm_err' => $connectivity_requirement?->scmErr->scmErrLines->load('material') ?? [],
                'sale_product_details' => $connectivity_requirement->saleDetail->last()->load('saleProductDetails')->saleProductDetails,
                'account_holder' => $connectivity_requirement->saleDetail->last()->sale->account_holder,
                'reason' => $connectivity_requirement->scmErr->reason ?? '',
                'branch' => $connectivity_requirement->FeasibilityRequirementDetail->branch->name ?? '',
                'connectivity_point' => $connectivity_requirement->FeasibilityRequirementDetail->connectivity_point ?? '',
                'otc' => $connectivity_requirement->saleDetail->last()->otc,
                'mrc' => $connectivity_requirement->saleDetail->last()->mrc,
            ];
        }


        return view('networking::reports.permanent-inactive-client-report', compact('permanently_inactive_clients'));
    }
}
