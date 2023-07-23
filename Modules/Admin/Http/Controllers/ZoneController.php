<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Admin\Entities\Zone;
use App\Models\Dataencoding\Thana;
use Illuminate\Routing\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\DB;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $zones = Zone::with('zoneLines.thana')->latest()->get();
        return view('admin::zones.index', compact('zones'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $formType = "create";
        $thanas = Thana::latest()->get();
        return view('admin::zones.create', compact('thanas', 'formType'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store()
    {
        try {
            DB::beginTransaction();

            $zone = Zone::create(request()->all());
            $thana_ids = [];
            foreach (request()->thana_ids as $thana_id) {
                $thana_ids[] = ['thana_id' => $thana_id];
            }
            
            $zone->zoneLines()->createMany($thana_ids);
            DB::commit();

            return redirect()->route('zones.index')->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            DB::rollBack();

            return redirect()->route('zones.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show()
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Zone $zone)
    {
        $formType = "edit";
        $thanas = Thana::latest()->get();
        $zone = $zone->load('zoneLines');
        return view('admin::zones.create', compact('zone', 'thanas', 'formType'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Zone $zone)
    {
        try {
            DB::beginTransaction();

            $zone->update(request()->all());
            $thana_ids = [];
            foreach (request()->thana_ids as $thana_id) {
                $thana_ids[] = ['thana_id' => $thana_id];
            }
            $zone->zoneLines()->delete();
            $zone->zoneLines()->createMany($thana_ids);
            DB::commit();

            return redirect()->route('zones.index')->with('message', 'Data has been updated successfully');
        } catch (QueryException $e) {
            DB::rollBack();

            return redirect()->route('zones.create', $zone->id)->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Zone $zone)
    {
        try {
            $zone->delete();
            $zone->zoneLines()->delete();

            return redirect()->route('zones.index')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $e) {
            return redirect()->route('zones.index')->withInput()->withErrors($e->getMessage());
        }
    }
}
