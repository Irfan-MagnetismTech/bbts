<?php

namespace Modules\Networking\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\SCM\Entities\Material;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Renderable;
use Modules\Networking\Entities\NetFiberManagement;

class NetFiberManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $datas = NetFiberManagement::get();
        return view('networking::net-fiber-management.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $CoreRefIds = NetFiberManagement::orderBy('id')->get(['connectivity_point_name', 'cable_code', 'fiber_type', 'core_no_color', 'id'])->pluck('coreRefId', 'id');
        return view('networking::net-fiber-management.create', compact('CoreRefIds'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {
            $material_data = $request->only('core_no_color', 'parent_id', 'fiber_type', 'cable_code', 'connectivity_point_name', 'pop_id');
            DB::transaction(function () use ($material_data) {
                $material_data['composite_key'] = $material_data['connectivity_point_name'] . '-' . $material_data['cable_code'] . '-' . $material_data['core_no_color'];
                NetFiberManagement::create($material_data);
            });
            return redirect()->route('fiber-managements.index')->with('success', 'Material has been inserted successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(NetFiberManagement $fiberManagement)
    {
        return view('networking::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(NetFiberManagement $fiberManagement)
    {
        $CoreRefIds = NetFiberManagement::whereNot('id', $fiberManagement->id)->orderBy('id')->get(['connectivity_point_name', 'cable_code', 'fiber_type', 'core_no_color', 'id'])->pluck('coreRefId', 'id');
        return view('networking::net-fiber-management.create', compact('CoreRefIds', 'fiberManagement'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, NetFiberManagement $fiberManagement)
    {
        try {
            $material_data = $request->only('core_no_color', 'parent_id', 'fiber_type', 'cable_code', 'connectivity_point_name', 'pop_id');
            DB::transaction(function () use ($material_data, $fiberManagement) {
                $fiberManagement->update($material_data);
            });
            return redirect()->route('fiber-managements.index')->with('success', 'Material has been updated successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(NetFiberManagement $fiberManagement)
    {
        try {
            if (count($fiberManagement->descendants)) {
                return redirect()->back()->with('error', 'Material has ' . count($fiberManagement->descendants) . ' descendents.Please Delete them first');
            }
            $fiberManagement->delete();
            return redirect()->route('fiber-managements.index')->with('message', 'Material has been deleted successfully.');
        } catch (QueryException $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
