<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\Dataencoding\District;
use App\Models\Dataencoding\Division;
use App\Models\Dataencoding\Thana;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Renderable;
use Modules\Admin\Http\Requests\ThanaRequest;
use Modules\Admin\Http\Requests\ThanaUpdateRequest;

class ThanaController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $formType = "create";
        $thanas = Thana::with('district')->get();

        return view('admin::thanas.index', compact('thanas', 'formType'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $formType = "create";
        $divisions = Division::latest()->get();
        $districts = District::latest()->get();

        return view('admin::thanas.create', compact('divisions', 'districts', 'formType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data = $request->only('district_id', 'name');
            Thana::create($data);

            return redirect()->route('thanas.index')->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            return redirect()->route('thanas.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Thana  $thana
     * @return \Illuminate\Http\Response
     */
    public function show(Thana $thana)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thana  $thana
     * @return \Illuminate\Http\Response
     */
    public function edit(Thana $thana)
    {
        $formType = "edit";
        $divisions = Division::get();
        $districts = District::get();
        $districtId=$thana->district_id;
        $selectedDivision = Division::whereHas('districts', function ($query) use ($districtId) {
            $query->where('id', $districtId);
        })->get();
        return view('admin::thanas.create', compact('thana', 'divisions', 'districts','selectedDivision', 'formType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Thana  $thana
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thana $thana)
    {
        try {
            $data = $request->only('district_id', 'name');
            $thana->update($data);

            return redirect()->route('thanas.index')->with('message', 'Data has been updated successfully');
        } catch (QueryException $e) {
            return redirect()->route('thanas.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thana  $thana
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thana $thana)
    {
        try {
            $thana->delete();
            return redirect()->route('thanas.index')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $e) {
            return redirect()->route('thanas.index')->withErrors($e->getMessage());
        }
    }

    public function getDistricts()
    {
        $districts = District::where('division_id', request('division_id'))->get();
        return response()->json($districts);
    }

    public function getThanas()
    {
        $thanas = Thana::where('district_id', request('district_id'))->get();
        return response()->json($thanas);
    }
}
