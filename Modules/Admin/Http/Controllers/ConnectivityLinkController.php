<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Sales\Entities\Vendor;
use App\Models\Dataencoding\Division;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Renderable;
use Modules\Admin\Entities\ConnectivityLink;

class ConnectivityLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('admin::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $formType = "create";
        $divisions = Division::latest()->get();
        return view('admin::connectivities.create', compact('formType', 'divisions'));
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
            $connectivity_link = $request->only('division_id', 'from_location', 'bbts_link_id', 'vendor_id', 'link_name', 'link_type', 'reference', 'to_location', 'from_site', 'district_id', 'to_site', 'thana_id', 'gps', 'teck_type', 'vendor_link_id', 'vendor_vlan', 'port', 'date_of_commissioning', 'date_of_termination', 'activation_date', 'remarks', 'capacity_type', 'existing_capacity', 'new_capacity', 'terrif_per_month', 'amount', 'vat_percent', 'vat', 'total');
            ConnectivityLink::create($connectivity_link);
            DB::commit();
            dd('done');
            return redirect()->route('warranty-claims.index')->with('message', 'Data has been updated successfully');
        } catch (QueryException $err) {
            dd($err->getMessage());
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
    public function edit($id)
    {
        return view('admin::edit');
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

    public function getVendors(Request $request)
    {
        $vendors = Vendor::query()
            ->where('name', 'like', '%' . $request->search . '%')
            ->get()
            ->map(function ($item) {
                return [
                    'value' => $item->name,
                    'label' => $item->name,
                    'id'    => $item->id
                ];
            });
        return response()->json($vendors);
    }
}
