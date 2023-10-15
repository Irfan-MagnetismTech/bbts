<?php

namespace App\Http\Controllers;

use Modules\SCM\Entities\Cs;
use Modules\Admin\Entities\Ip;
use Modules\Admin\Entities\Pop;
use Modules\Admin\Entities\User;
use Modules\SCM\Entities\Indent;
use Modules\Admin\Entities\Brand;
use App\Models\Dataencoding\Thana;
use Modules\Admin\Entities\Branch;
use Modules\Sales\Entities\Client;
use Modules\SCM\Entities\Material;
use Modules\SCM\Entities\Supplier;
use Modules\SCM\Entities\CsSupplier;
use App\Models\Dataencoding\District;
use App\Models\Dataencoding\Employee;
use Modules\SCM\Entities\StockLedger;
use App\Models\Dataencoding\Department;
use Modules\Networking\Entities\LogicalConnectivity;
use Modules\Networking\Entities\PhysicalConnectivity;
use Modules\Sales\Entities\ClientDetail;
use Modules\Sales\Entities\SaleLinkDetail;
use Modules\Ticketing\Entities\SupportTeam;
use Modules\Ticketing\Entities\SupportTicket;
use Modules\SCM\Entities\ScmPurchaseRequisition;
use Modules\Sales\Entities\FeasibilityRequirementDetail;
use Modules\Sales\Entities\Sale;
use Modules\Sales\Entities\SaleDetail;
use Modules\Sales\Entities\Vendor;
use Modules\Sales\Entities\Product;
use Modules\Sales\Entities\Category;

class CommonApiController extends Controller
{
    public function searchClient()
    {
        $results = Client::query()->with('feasibility_requirement_details')
            ->where('client_name', 'LIKE', '%' . request('search') . '%')
            ->limit(15)
            ->get()
            ->map(fn ($item) => [
                'value' => $item->client_no,
                'id' => $item->id,
                'label' => $item->client_name,
                'text' => $item->client_name,
                'client_no' => $item->client_no,
                'address' => $item->location,
                'contact_person' => $item->contact_person,
                'contact_no' => $item->contact_no,
                'email' => $item->email,
                'client_type' => $item->client_type,
                'saleDetails' => $item->saleDetails,
                'frDetails' => $item->feasibility_requirement_details->pluck('fr_no', 'fr_no'),
            ]);

        return response()->json($results);
    }

    public function getLinkNo()
    {
        $data['options'] = SaleLinkDetail::query()
            ->where(['fr_no' => request()->fr_no])
            ->get()
            ->map(fn ($item) => [
                'value' => $item->link_no,
                'label' => $item->link_no,
            ])
            ->values()
            ->all();

        return response()->json($data);
    }


    public function getClientsByLinkId()
    {
    $results = Client::query()
    ->with('feasibility_requirement_details')
    ->where(function ($query) {
        $search = request('search');
        $query->where('client_no', 'LIKE', '%' . $search . '%')
            ->orWhere('client_name', 'LIKE', '%' . $search . '%');
    })
    ->limit(15)
    ->get()
    ->map(function ($item) {
        return [
            'id' => $item->client_no,
            'text' => $item->client_no . ' - ' . $item->client_name,
            'client_name' => $item->client_name,
            'contact_person' => $item->contact_person,
            'contact_no' => $item->contact_no,
            'email' => $item->email,
            'client_type' => $item->client_type,
            'address' => $item->location,
            'fr_list' => $item->feasibility_requirement_details->pluck('fr_no', 'connectivity_point'),
        ];
    });

return response()->json($results);
    }

    public function getClientsPreviousTickets($frNo, $limit)
    {
        $limit = (abs($limit) > 5) ? 5 : abs($limit);

        $previousTickets = SupportTicket::where('fr_no', $frNo)
            ->with(['supportComplainType', 'ticketSource'])
            ->limit($limit)
            ->orderBy('id', 'desc')
            ->get(['support_complain_type_id', 'ticket_source_id', 'status', 'opening_date', 'remarks', 'id', 'ticket_no']);

        return response()->json($previousTickets);
    }

    public function searchMaterial()
    {
        $results = Material::query()
            ->where('name', 'LIKE', '%' . request('search') . '%')
            ->orWhere('code', 'LIKE', '%' . request('search') . '%')
            ->limit(15)
            ->get()
            ->map(function ($item) {
                if (request('branch_id')) {
                    $stockData = StockLedger::where('material_id', $item->id)
                        ->where('branch_id', request('branch_id'))
                        ->sum('quantity');
                }

                return [
                    'value' => $item->id,
                    'material_id' => $item->id,
                    'label' => $item->name . ' - ' . $item->code,
                    'unit' => $item->unit,
                    'item_code' => $item->code,
                    'stock_data' => $stockData ?? 0
                ];
            });

        return response()->json($results);
    }

    public function searchBranch()
    {
        $results = Branch::query()
            ->where('name', 'LIKE', '%' . request('search') . '%')
            ->with('thana', 'district')
            ->limit(15)
            ->get()
            ->map(function ($item){ 
                $tana = $item->district->name ?? '';
                $data = [
                    'id' => $item->id,
                    'text' => $item->name . " (" . $item->location . ") - " .$tana. " - " . $item->district->name,
                    'value' => $item->name . " (" . $item->location . ") - " . $tana . " - " . $item->district->name,
                    'label' => $item->name . " (" . $item->location . ") - " . $tana. " - " . $item->district->name,
                ];
                return $data;
            }); 

        return response()->json($results);
    }

    public function searchPopByBranchId()
    {
        $results = Pop::query()
            ->where('branch_id', 'LIKE', '%' . request('search') . '%')
            ->limit(15)
            ->get()
            ->map(fn ($item) => [
                'id' => $item->id,
                'text' => $item->name,
                'address' => $item->address,
                'value' => $item->name,
                'label' => $item->name,
            ]);

        return response()->json($results);
    }

    public function searchPop()
    {
        $results = Pop::query()
            ->where('name', 'LIKE', '%' . request('search') . '%')
            ->limit(15)
            ->get()
            ->map(fn ($item) => [
                'id' => $item->id,
                'text' => $item->name,
                'address' => $item->address,
                'value' => $item->name,
                'label' => $item->name,
            ]);

        return response()->json($results);
    }

    public function searchPopByBranch()
    {
        $results = Pop::query()
            ->where('branch_id', request('branch_id'))
            ->where('name', 'LIKE', '%' . request('search') . '%')
            ->limit(15)
            ->get()
            ->map(fn ($item) => [
                'id' => $item->id,
                'text' => $item->name,
                'address' => $item->address,
            ]);

        return response()->json($results);
    }

    public function searchBrand()
    {
        $results = Brand::query()
            ->where('name', 'LIKE', '%' . request('search') . '%')
            ->limit(15)
            ->get()
            ->map(fn ($item) => [
                'id' => $item->id,
                'text' => $item->name,
            ]);

        return response()->json($results);
    }

    public function searchDepartment()
    {
        $results = Department::where('name', 'LIKE', '%' . request('search') . '%')
            ->limit(15)
            ->get()
            ->map(fn ($item) => [
                'value' => $item->id,
                'label' => $item->name,
            ]);

        return response()->json($results);
    }

    public function searchEmployee()
    {
        $results = Employee::select('id', 'designation_id', 'name')->with('designation')->where('name', 'LIKE', '%' . request('search') . '%')
            ->limit(15)
            ->get()
            ->map(fn ($item) => [
                'value' => $item->id,
                'label' => $item->name,
                'designation' => $item->designation->name
            ]);
    //    dd($results);
        return response()->json($results);
    }

    public function searchUser()
    {
        $results = User::select('id', 'employee_id', 'name')->with('employee')->where('name', 'LIKE', '%' . request('search') . '%')
            ->limit(15)
            ->get()
            ->map(fn ($item) => [
                'value' => $item->id,
                'label' => $item->name,
                'designation' => $item->employee->designation->name
            ]);

        return response()->json($results);
    }

    public function searchSupplier()
    {
        $items = Supplier::where('name', 'like', '%' . request('search') . '%')->limit(10)
            ->get();
        $response = [];
        foreach ($items as $item) {
            $response[] = [
                'label' => $item->name,
                'value' => $item->id,
                'address' => $item->address,
                'contact' => $item->contact,
                'account_id' => $item->supplier->account->id ?? 0,
            ];
        }

        return response()->json($response);
    }

    public function getDistricts()
    {
        $division_id = request('division_id');
        $districts = District::where('division_id', $division_id)->limit(15)
            ->get()
            ->map(fn ($item) => [
                'id' => $item->id,
                'text' => $item->name,
            ]);

        return response()->json($districts);
    }

    public function getThanas()
    {
        $district_id = request('district_id');
        $thanas = Thana::where('district_id', $district_id)->limit(15)
            ->get()
            ->map(fn ($item) => [
                'id' => $item->id,
                'text' => $item->name,
            ]);

        return response()->json($thanas);
    }

    public function getSupportTeamMembers()
    {
        $teamId = request('search');
        $team = SupportTeam::with('supportTeamMembers.user')->where('id', $teamId)->first();

        if (auth()->user()->employee->branch_id != $team->branch_id) {
            abort(404);
        }

        return response()->json($team);
    }
    public function searchPrsNo()
    {
        $results = ScmPurchaseRequisition::query()
            ->where('prs_no', 'LIKE', '%' . request('search') . '%')
            ->limit(15)
            ->get()
            ->map(fn ($item) => [
                'value' => $item->id,
                'label' => $item->prs_no,
            ]);

        return response()->json($results);
    }

    public function searchIndentNo()
    {
        $items = Indent::with('indentLines.scmPurchaseRequisition')->where('indent_no', 'like', '%' . request('search') . '%')->limit(10)
            ->get();
        $response = [];
        foreach ($items as $item) {
            $response[] = [
                'label' => $item->indent_no,
                'value' => $item->id,
                'indent_no' => $item->indent_no,
                'requisition_nos' => $item->indentLines->map(fn ($item) => [
                    'requisition_no' => $item->scmPurchaseRequisition->prs_no ?? '',
                    'purchase_requisition_id' => $item->scmPurchaseRequisition->id ?? '',
                ]),
                'cs_no' => Cs::select('id', 'cs_no')->where('indent_no', $item->indent_no)->get() ?? '',
            ];
        }

        return response()->json($response);
    }

    public function searchCsNo($supplierId)
    {
        $results = Cs::query()
            ->where('cs_no', 'LIKE', '%' . request('search') . '%')
            ->whereHas('selectedSuppliers', function ($query) use ($supplierId) {
                $query->where('supplier_id', $supplierId);
            })
            ->limit(15)
            ->get()
            ->map(fn ($item) => [
                'value' => $item->id,
                'label' => $item->cs_no,
            ]);

        return response()->json($results);
    }

    public function getSupportTicket()
    {
        $results = SupportTicket::query()
            ->where('ticket_no', 'LIKE', '%' . request('search') . '%')
            ->limit(15)
            ->get()
            ->map(fn ($item) => [
                'id' => $item->id,
                'text' => $item->ticket_no,
                'value' => $item->id,
                'label' => $item->ticket_no,
            ]);

        return response()->json($results);
    }

    public function searchIp()
    {
        $results = Ip::query()
            ->where('address', 'LIKE', '%' . request('search') . '%')
            ->limit(15)
            ->get()
            ->map(fn ($item) => [
                'id' => $item->id,
                'text' => $item->address,
                'value' => $item->id,
                'label' => $item->address,
            ]);

        return response()->json($results);
    }

    public function searchClientWithFrDetails()
    {
        $results = Client::query()
            ->with('feasibility_requirement_details')
            ->where('client_name', 'LIKE', '%' . request('search') . '%')
            ->limit(15)
            ->get()
            ->map(fn ($item) => [
                'value' => $item->id,
                'id' => $item->id,
                'label' => $item->client_name,
                'text' => $item->client_name,
                'client_no' => $item->client_no,
                'client_type' => $item->client_type,
                'frDetails' => $item->feasibility_requirement_details,
            ]);

        return response()->json($results);
    }

    public function getFrDetailsData()
    {
        $feasibility_details = FeasibilityRequirementDetail::with('feasibilityRequirement')->where('fr_no', request('fr_no'))->first();

        $results = SaleDetail::query()
            ->whereSaleId(request('sale_id'))
            ->with('frDetails', 'saleLinkDetails.finalSurveyDetails.pop')
            ->whereHas('saleLinkDetails.finalSurveyDetails.surveyDetail.survey', function ($query) use ($feasibility_details) {
                $query->whereFrNoAndMqNo(request('fr_no'), $feasibility_details->feasibilityRequirement->mq_no);
            })
            ->first();

        return response()->json($results);
    }

    public function getLinksByFr($client_no, $fr_no)
    {
        $results = PhysicalConnectivity::with('lines')->where('client_no', $client_no)->where('fr_no', $fr_no)->first();
        return response()->json($results);
    }
    public function searchVendor()
    {
        $results = Vendor::query()
            ->where('name', 'LIKE', '%' . request('search') . '%')
            ->limit(10)
            ->get()
            ->map(fn ($item) => [
                'id' => $item->id,
                'text' => $item->name,
                'value' => $item->id,
                'label' => $item->name,
            ]);

        return response()->json($results);
    }

    public function getLogicalConnectivityData()
    {
        $logicalConnectivity = LogicalConnectivity::query()
            ->with('lines.product')
            ->whereClientNoAndFrNo(request('client_no'), request('fr_no'))
            ->orderBy('sale_id', 'desc')
            ->first();

        $physicalConnectivity = PhysicalConnectivity::query()
            ->with('lines.connectivityLink.vendor')
            ->whereClientNoAndFrNo(request('client_no'), request('fr_no'))
            ->orderBy('sale_id', 'desc')
            ->first();

        return response()->json([
            'logical_connectivity' => $logicalConnectivity,
            'physical_connectivity' => $physicalConnectivity,
        ]);
    }
}
