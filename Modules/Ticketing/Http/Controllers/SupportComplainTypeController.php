<?php

namespace Modules\Ticketing\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Renderable;
use App\Http\Controllers\Services\BbtsGlobalService;
use Modules\Ticketing\Entities\SupportComplainType;

class SupportComplainTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $complainTypes = (new BbtsGlobalService())->getComplainTypes();
        return view('ticketing::complain-types.index', compact('complainTypes'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('ticketing::complain-types.create-edit');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|unique:support_complain_types,name'
            ]);
            DB::transaction(function () use ($request)
            {
                    SupportComplainType::create([
                        'name' => $request->name,
                        'created_by'       => auth()->user()->id
                    ]);
                
            });

            return redirect()->route('support-complain-types.index')->with('message', 'Complain Type Created Successfully');
        }
        catch (QueryException $e)
        {
            return redirect()->route('support-complain-types.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        // return view('ticketing::complain-types.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(SupportComplainType $supportComplainType)
    {
        return view('ticketing::complain-types.create-edit', compact('supportComplainType'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, SupportComplainType $supportComplainType)
    {
        try {
            $request->validate([
                'name' => 'required|unique:support_complain_types,name,' . $supportComplainType->id
            ]);
            
            DB::transaction(function () use ($request, $supportComplainType)
            {
                $supportComplainType->update([
                        'name' => $request->name,
                        'updated_by'       => auth()->user()->id
                ]);
                
            });

            return redirect()->route('support-complain-types.index')->with('message', 'Complain Type Updated Successfully');
        }
        catch (QueryException $e)
        {
            return back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        try {
            SupportComplainType::where('id', $id)->delete();
            return redirect()->route('support-complain-types.index')->with('message', 'Complain Type Deleted Successfully');
        } catch (\Throwable $th) {
            return redirect()->route('support-complain-types.index')->withInput()->withErrors($th->getMessage());
        }
    }
}
