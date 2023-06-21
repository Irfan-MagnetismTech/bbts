<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Admin\Entities\Ip;
use Modules\Admin\Entities\Zone;
use Illuminate\Routing\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Renderable;
use Modules\Admin\Http\Requests\IpRequest;

class IpController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $ips = Ip::with('zone')->latest()->get();
        return view('admin::ips.index', compact('ips'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $formType = "create";
        $zones = Zone::latest()->get();
        return view('admin::ips.create', compact('formType', 'zones'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(IpRequest $request)
    {
        try {
            Ip::create($request->all());
            return redirect()->route('ips.index')->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            return redirect()->route('ips.create')->withInput()->withErrors($e->getMessage());
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
    public function edit(Ip $ip)
    {
        $formType = "edit";
        $zones = Zone::latest()->get();
        return view('admin::ips.create', compact('formType', 'zones', 'ip'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Ip $ip, IpRequest $request)
    {
        try {
            $ip->update($request->all());
            return redirect()->route('ips.index')->with('message', 'Data has been updated successfully');
        } catch (QueryException $e) {
            return redirect()->route('ips.edit', $ip->id)->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Ip $ip)
    {
        try {
            $ip->delete();
            return redirect()->route('ips.index')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $e) {
            return redirect()->route('ips.index')->withInput()->withErrors($e->getMessage());
        }
    }
}
