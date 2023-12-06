<?php

namespace Modules\Networking\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Sales\Entities\Client;
use Modules\Sales\Entities\Planning;
use Modules\SCM\Entities\ScmChallan;
use Illuminate\Support\Facades\Session;
use Illuminate\Contracts\Support\Renderable;
use Modules\Admin\Entities\ConnectivityLink;
use Modules\Networking\Entities\NetFiberManagement;
use Modules\Networking\Entities\PhysicalConnectivity;
use Modules\Sales\Entities\FeasibilityRequirementDetail;
use Modules\Sales\Entities\SaleDetail;
use PharIo\Manifest\Url;
use Termwind\Components\Dd;

class PhysicalConnectivityModificationController extends Controller
{

    public function create()
    {
        $connectivity_links = ConnectivityLink::latest()->get();
        Session::put('physicalConnectivityEditUrl', request()->fullUrl());

        $sale_id = request()->get('sale_id');

        if (request()->get('sale_id')) {
            $saleDetails = SaleDetail::query()
                ->with('saleLinkDetails')
                ->whereSaleIdAndFrNo(request()->get('sale_id'), request()->get('fr_no'))
                ->first();



            $physicalConnectivity = PhysicalConnectivity::query()
                ->whereFrNo($saleDetails->fr_no)
                ->with('lines')
                ->latest()
                ->first();

            // dd('physicalConnectivity', $physicalConnectivity, 'saleDetails', $saleDetails);

            $saleDetails->saleLinkDetails->map(function ($item) use ($physicalConnectivity) {
                $line = $physicalConnectivity->lines()->where('link_no', $item->link_no)->first();
                if ($line) {
                    $item->link_type = $line->link_type;
                    $item->method = $line->method;
                    $item->pop = $line->pop;
                    $item->ldp = $line->ldp;
                    $item->bbts_link_id = $line->bbts_link_id;
                    $item->device_ip = $line->device_ip;
                    $item->port = $line->port;
                    $item->vlan = $line->vlan;
                    $item->connectivity_details = $line->connectivity_details;
                    $item->comment = $line->comment;
                }
                return $item;
            });
            
            $challanInfo = ScmChallan::query()
                ->where('fr_no', $saleDetails->fr_no)
                ->get();

            $connectivity_points = FeasibilityRequirementDetail::query()
                ->where('client_no', $saleDetails->client_no)
                ->get();
   

            $fiber_cores = NetFiberManagement::latest()->get();
        }

        return view('networking::physical-connectivities.create', compact('challanInfo', 'connectivity_points', 'saleDetails', 'connectivity_links', 'fiber_cores'));
    }
}
