<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\Branch;
use Modules\Sales\Entities\Vendor;
use App\Models\Dataencoding\Division;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Renderable;
use Modules\Admin\Entities\ConnectivityLink;
use Modules\Admin\Entities\Pop;

class ConnectivityLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $datas = ConnectivityLink::get()->groupBy('bbts_link_id')->map(function ($item) {
            return $item->last();
        })->flatten();
        return view('admin::connectivities.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $formType = "create";
        $divisions = Division::latest()->get();
        $branches = Branch::latest()->get();
        return view('admin::connectivities.create', compact('formType', 'divisions','branches'));
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
            $connectivity_link = $request->only('division_id', 'from_location', 'from_pop_id', 'branch_id','cost_center', 'to_pop_id', 'bbts_link_id', 'vendor_id', 'link_name', 'link_type', 'reference', 'to_location', 'from_site', 'district_id', 'to_site', 'thana_id', 'gps', 'teck_type', 'vendor_link_id', 'vendor_vlan', 'port', 'date_of_commissioning', 'date_of_termination', 'activation_date', 'remarks', 'capacity_type', 'existing_capacity', 'new_capacity', 'terrif_per_month', 'amount', 'vat_percent', 'vat', 'total', 'status', 'link_from','link_to');
            if ($request->link_type == 'new') {
                $connectivity_link['bbts_link_id'] = $this->generateUniqueId(ConnectivityLink::class, 'LINK');
            }
            ConnectivityLink::create($connectivity_link);
            DB::commit();
            return redirect()->route('connectivity.index')->with('message', 'Data has been created successfully');
        } catch (QueryException $err) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($err->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('admin::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(ConnectivityLink $connectivity)
    {
        $formType = "edit";
        $branches = Branch::latest()->get();
        $divisions = Division::latest()->get();
        return view('admin::connectivities.create', compact('formType', 'divisions', 'connectivity','branches'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, ConnectivityLink $connectivity)
    {
        try {
            DB::beginTransaction();
            $connectivity_link = $request->only('division_id', 'from_location', 'from_pop_id', 'branch_id','cost_center', 'to_pop_id', 'bbts_link_id', 'vendor_id', 'link_name', 'link_type', 'reference', 'to_location', 'from_site', 'district_id', 'to_site', 'thana_id', 'gps', 'teck_type', 'vendor_link_id', 'vendor_vlan', 'port', 'date_of_commissioning', 'date_of_termination', 'activation_date', 'remarks', 'capacity_type', 'existing_capacity', 'new_capacity', 'terrif_per_month', 'amount', 'vat_percent', 'vat', 'total', 'status', 'link_from','link_to');
            $connectivity->update($connectivity_link);
            DB::commit();
            return redirect()->route('connectivity.index')->with('message', 'Data has been updated successfully');
        } catch (QueryException $err) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($err->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(ConnectivityLink $connectivity)
    {
        try {
            $connectivity->delete();
            return redirect()->back()->with('success', 'Data has been updated successfully');
        } catch (QueryException $err) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($err->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function getConnectivityLinkLog($link_name)
    {
        $datas = ConnectivityLink::query()->where('link_name', $link_name)->get();
        return view('admin::connectivities.log', compact('datas'));
    }

    public function getVendors(Request $request)
    {
        $vendors = Vendor::query()
            ->where('name', 'like', '%' . $request->search . '%')
            ->get()
            ->map(function ($item) {
                return [
                    'value' => $item->name,
                    'label' => $item->name,
                    'id'    => $item->id,
                ];
            });
        return response()->json($vendors);
    }
    public function getPop(Request $request)
    {
        $vendors = Pop::query()
            ->where('name', 'like', '%' . $request->search . '%')
            ->get()
            ->map(function ($item) {
                return [
                    'value' => $item->name,
                    'label' => $item->name,
                    'id'    => $item->id,
                ];
            });
        return response()->json($vendors);
    }

    public function getLinkSite(Request $request)
    {
        $vendors = ConnectivityLink::query()
            ->where('from_site', 'like', '%' . $request->search . '%')
            ->get()
            ->map(function ($item) {
                return [
                    'value' => $item->from_site,
                    'label' => $item->from_site,
                    'id'    => $item->id,
                ];
            });
        return response()->json($vendors);
    }

    public function getLocationInfoForLink(Request $request)
    {
        $vendors = ConnectivityLink::query()
            ->where('link_name', 'like', '%' . $request->search . '%')
            ->get()
            ->map(function ($item) {
                return [
                    'value'                 => $item->from_location,
                    'label'                 => $item->from_location,
                    'id'                    => $item->id,
                    'data'                  => $item
                ];
            });
        return response()->json($vendors);
    }


    public function generateUniqueId($model, $prefix): string
    {
        $lastIndentData = $model::where('link_type', 'new')->latest()->first();
        if ($lastIndentData) {
            if (now()->format('Y') != date('Y', strtotime($lastIndentData->created_at))) {
                return strtoupper($prefix) . '-' . now()->format('Y') . '-' . 1;
            } else {
                $data = explode('-', $lastIndentData->bbts_link_id);
                return strtoupper($prefix) . '-' . now()->format('Y') . '-' . $data[2] + 1;
            }
        } else {
            return strtoupper($prefix) . '-' . now()->format('Y') . '-' . 1;
        }
    }
}
