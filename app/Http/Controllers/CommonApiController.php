<?php

namespace App\Http\Controllers;

use Modules\Admin\Entities\Pop;
use Modules\Admin\Entities\User;
use Modules\Admin\Entities\Brand;
use App\Models\Dataencoding\Thana;
use Modules\Admin\Entities\Branch;
use Modules\Sales\Entities\Client;
use Modules\SCM\Entities\Material;
use Modules\SCM\Entities\Supplier;
use App\Models\Dataencoding\District;
use App\Models\Dataencoding\Employee;
use App\Models\Dataencoding\Department;
use Modules\Sales\Entities\ClientDetail;
use Modules\Ticketing\Entities\SupportTeam;
use Modules\SCM\Entities\ScmPurchaseRequisition;
use Modules\SCM\Entities\Cs;
use Modules\SCM\Entities\CsSupplier;
use Modules\SCM\Entities\Indent;
use Modules\Ticketing\Entities\SupportTicket;

class CommonApiController extends Controller
{
    public function searchClient()
    {
        $results = Client::query()
            ->with('clientDetails')
            ->where('name', 'LIKE', '%' . request('search') . '%')
            ->limit(15)
            ->get()
            ->map(fn ($item) => [
                'value' => $item->id,
                'label' => $item->name,
                'client_no' => $item->client_no,
                'address' => $item->address,
                'details' => $item->clientDetails,
            ]);

        return response()->json($results);
    }

    public function getClientsByLinkId()
    {
        $results = ClientDetail::query()
            ->with('client')
            ->where('link_id', 'LIKE', '%' . request('search') . '%')
            ->limit(15)
            ->get()
            ->map(fn ($item) => [
                'value' => $item->id,
                'label' => $item->link_id,
                'client' => $item->client,
                'id' => $item->id,
                'text' => $item->link_id,
                'fr_composite_key' => $item->fr_composite_key
            ]);

        return response()->json($results);
    }

    public function getClientsPreviousTickets($clientId, $limit)
    {
        $clientId = abs($clientId);
        $limit = (abs($limit) > 5) ? 5 : abs($limit);

        $client = Client::find($clientId);
        $previousTickets = $client->supportTickets()
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
            ->map(fn ($item) => [
                'value' => $item->id,
                'material_id' => $item->id,
                'label' => $item->name . ' - ' . $item->code,
                'unit' => $item->unit,
                'item_code' => $item->code,
            ]);

        return response()->json($results);
    }

    public function searchBranch()
    {
        $results = Branch::query()
            ->where('name', 'LIKE', '%' . request('search') . '%')
            ->with('thana', 'district')
            ->limit(15)
            ->get()
            ->map(fn ($item) => [
                'id' => $item->id,
                'text' => $item->name . " (" . $item->location . ") - " . $item->thana->name . " - " . $item->district->name,
                'value' => $item->name . " (" . $item->location . ") - " . $item->thana->name . " - " . $item->district->name,
                'label' => $item->name . " (" . $item->location . ") - " . $item->thana->name . " - " . $item->district->name,
            ]);

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

    public function getSupportTeamMembers() {
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

    public function getSupportTicket() {
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
}
