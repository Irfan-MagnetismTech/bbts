<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\Dataencoding\District;
use App\Models\Dataencoding\Division;
use App\Models\Dataencoding\Thana;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Admin\Entities\Branch;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Renderable;
use Modules\Admin\Http\Requests\BranchRequest;
use Termwind\Components\Dd;

use function Psy\info;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $formType = "create";
        $branchs = Branch::with('division', 'district', 'thana')->latest()->get();
        return view('admin::branchs.index', compact('branchs', 'formType'));
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
        $thanas = Thana::latest()->get();

        return view('admin::branchs.create', compact('divisions', 'districts', 'thanas', 'formType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BranchRequest $request)
    {
        try {
            $data = $request->all();
            Branch::create($data);

            return redirect()->route('branchs.index')->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            return redirect()->route('branchs.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Branch  $Branch
     * @return \Illuminate\Http\Response
     */
    public function show(Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Branch  $Branch
     * @return \Illuminate\Http\Response
     */
    public function edit(Branch $branch)
    {
        $formType = "edit";
        $divisions = Division::latest()->get();
        $districts = District::where('division_id', $branch->division_id)->get();
        $thanas = Thana::where('district_id', $branch->district_id)->latest()->get();

        return view('admin::branchs.create', compact('branch', 'divisions', 'districts', 'thanas', 'formType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Branch  $Branch
     * @return \Illuminate\Http\Response
     */
    public function update(BranchRequest $request, Branch $branch)
    {
        try {
            $data = $request->all();
            $branch->update($data);
            
            return redirect()->route('branchs.index')->with('message', 'Data has been updated successfully');
        } catch (QueryException $e) {
            return redirect()->route('branchs.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Branch  $Branch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Branch $branch)
    {
        try {
            $branch->delete();
            return redirect()->route('branchs.index')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $e) {
            return redirect()->route('branchs.index')->withErrors($e->getMessage());
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
