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
        return view('networking::net-fiber-management.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $CoreRefIds = NetFiberManagement::orderBy('id')->get('id', 'cable_code');
        return view('networking::net-fiber-management.create', compact('CoreRefIds'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        dd($request->all());
        try {
            $material_data = $request->only('core_no_color', 'parent_id', 'fiber_type', 'cable_code', 'connectivity_point_name', 'pop_id');
            DB::transaction(function () use ($material_data) {
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
        return view('networking::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, NetFiberManagement $fiberManagement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(NetFiberManagement $fiberManagement)
    {
        //
    }
}
