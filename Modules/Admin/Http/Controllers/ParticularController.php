<?php

namespace Modules\Admin\Http\Controllers;

use Modules\Admin\Entities\Particular;
use Illuminate\Routing\Controller;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\QueryException;
use Modules\Admin\Http\Requests\ParticularRequest;
use Modules\Admin\Http\Requests\ParticularUpdateRequest;

class ParticularController extends Controller
{
    use HasRoles;
    function __construct()
    {
        // $this->middleware('permission:particular-view|particular-create|particular-edit|particular-delete', ['only' => ['index','show']]);
        // $this->middleware('permission:particular-create', ['only' => ['create','store']]);
        // $this->middleware('permission:particular-edit', ['only' => ['edit','update']]);
        // $this->middleware('permission:particular-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $particulars = Particular::latest()->get();
        $formType = "create";
        return view('admin::particulars.create', compact('particulars', 'formType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = "create";
        $particulars = Particular::latest()->get();
        return view('admin::particulars.create', compact('particulars', 'formType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ParticularRequest $request)
    {
        try {
            $data = $request->all();
            Particular::create($data);
            return redirect()->route('particulars.create')->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            return redirect()->route('particulars.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Particular  $particular
     * @return \Illuminate\Http\Response
     */
    public function show(Particular $particular)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Particular  $particular
     * @return \Illuminate\Http\Response
     */
    public function edit(Particular $particular)
    {
        $formType = "edit";
        $particulars = Particular::latest()->get();
        return view('admin::particulars.create', compact('particular', 'particulars', 'formType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Particular  $particular
     * @return \Illuminate\Http\Response
     */
    public function update(ParticularUpdateRequest $request, Particular $particular)
    {
        try {
            $data = $request->all();
            $particular->update($data);
            return redirect()->route('particulars.create')->with('message', 'Data has been updated successfully');
        } catch (QueryException $e) {
            return redirect()->route('particulars.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Particular  $particular
     * @return \Illuminate\Http\Response
     */
    public function destroy(Particular $particular)
    {
        try {
            $particular->delete();
            return redirect()->route('particulars.create')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $e) {
            return redirect()->route('particulars.create')->withErrors($e->getMessage());
        }
    }
}
