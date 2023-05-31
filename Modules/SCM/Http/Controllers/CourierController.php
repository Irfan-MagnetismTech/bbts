<?php

namespace Modules\SCM\Http\Controllers;

use Illuminate\Http\Request;
use Modules\SCM\Entities\Courier;
use Illuminate\Routing\Controller;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\QueryException;
use Modules\SCM\Http\Requests\CourierRequest;

class CourierController extends Controller
{
    use HasRoles;
    function __construct()
    {
        $this->middleware('permission:courier-view|courier-create|courier-edit|courier-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:courier-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:courier-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:courier-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $couriers = Courier::latest()->get();
        $formType = "create";
        return view('scm::couriers.create', compact('couriers', 'formType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = "create";
        $couriers = Courier::latest()->get();
        return view('scm::couriers.create', compact('couriers', 'formType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourierRequest $request)
    {
        try {
            $data = $request->all();
            Courier::create($data);
            return redirect()->route('couriers.create')->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            return redirect()->route('couriers.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Courier  $courier
     * @return \Illuminate\Http\Response
     */
    public function show(Courier $courier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Courier  $courier
     * @return \Illuminate\Http\Response
     */
    public function edit(Courier $courier)
    {
        $formType = "edit";
        $couriers = Courier::latest()->get();
        return view('scm::couriers.create', compact('courier', 'couriers', 'formType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Courier  $courier
     * @return \Illuminate\Http\Response
     */
    public function update(CourierRequest $request, Courier $courier)
    {
        try {
            $data = $request->all();
            $courier->update($data);
            return redirect()->route('couriers.create')->with('message', 'Data has been updated successfully');
        } catch (QueryException $e) {
            return redirect()->route('couriers.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Courier  $courier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Courier $courier)
    {
        try {
            $courier->delete();
            return redirect()->route('couriers.create')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $e) {
            return redirect()->route('couriers.create')->withErrors($e->getMessage());
        }
    }
}
