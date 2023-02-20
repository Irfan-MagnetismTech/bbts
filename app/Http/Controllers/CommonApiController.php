<?php

namespace App\Http\Controllers;

use Modules\Admin\Entities\Pop;
use Modules\Admin\Entities\Brand;
use Modules\Admin\Entities\Branch;
use Modules\Sales\Entities\Client;
use Modules\SCM\Entities\Material;
use Modules\SCM\Entities\Supplier;
use App\Models\Dataencoding\Employee;
use App\Models\Dataencoding\Department;

class CommonApiController extends Controller
{
    public function searchClient()
    {
        $results = Client::query()
            ->with('clientDetails')
            ->where('name', 'LIKE', '%' . request('search') . '%')
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

    public function searchMaterial()
    {
        $results = Material::query()
            ->where('name', 'LIKE', '%' . request('search') . '%')
            ->orWhere('code', 'LIKE', '%' . request('search') . '%')
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
            ->get()
            ->map(fn ($item) => [
                'id' => $item->id,
                'text' => $item->name,
            ]);

        return response()->json($results);
    }

    public function searchPop()
    {
        $results = Pop::query()
            ->where('branch_id', 'LIKE', '%' . request('search') . '%')
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
            ->get()
            ->map(fn ($item) => [
                'value' => $item->id,
                'label' => $item->name,
                'designation' => $item->designation->name
            ]);

        return response()->json($results);
    }

    public function searchSupplier()
    {
        // $results = Supplier::query()
        //     ->where('name', 'LIKE', '%' . request('search') . '%')
        //     ->orWhere('code', 'LIKE', '%' . request('search') . '%')
        //     ->get()
        //     ->map(fn ($item) => [
        //         'value' => $item->id,
        //         'label' => $item->name . ' - ' . $item->code,
        //         'unit' => $item->unit,
        //         'item_code' => $item->code,
        //     ]);


        $items = Supplier::where('name', 'like', '%' . request('search') . '%')->limit(10)->get();
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
}
