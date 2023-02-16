<?php

namespace Modules\Ticketing\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Renderable;
use App\Http\Controllers\Services\BbtsGlobalService;
use Illuminate\Support\Facades\Redis;
use Modules\Ticketing\Entities\SupportQuickSolution;

class SupportQuickSolutionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $supportSolutions = (new BbtsGlobalService())->getSupportSolutions();
        return view('ticketing::quick-sloutions.index', compact('supportSolutions'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('ticketing::quick-sloutions.create-edit');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {
            
            DB::transaction(function () use ($request)
            {
                    SupportQuickSolution::create([
                        'name' => $request->name,
                        'created_by'       => auth()->user()->id
                    ]);
                
            });

            return redirect()->route('support-solutions.index')->with('message', 'Solution Created Successfully');
        }
        catch (QueryException $e)
        {
            return redirect()->route('support-solutions.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(SupportQuickSolution $supportSolution)
    {
        // return view('ticketing::quick-sloutions.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(SupportQuickSolution $supportSolution)
    {
        return view('ticketing::quick-sloutions.create-edit', compact('supportSolution'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(SupportQuickSolution $supportSolution, Request $request)
    {
        try {
            
            DB::transaction(function () use ($request, $supportSolution)
            {
                $supportSolution->update([
                        'name' => $request->name,
                        'updated_by'       => auth()->user()->id
                ]);
                
            });

            return redirect()->route('support-solutions.index')->with('message', 'Support Solution Updated Successfully');
        }
        catch (QueryException $e)
        {
            return redirect()->route('support-solutions.edit')->withInput()->withErrors($e->getMessage());
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
            SupportQuickSolution::where('id', $id)->delete();
            return redirect()->route('support-solutions.index')->with('message', 'Support Solution Deleted Successfully');
        } catch (\Throwable $th) {
            return redirect()->route('support-solutions.index')->withInput()->withErrors($th->getMessage());
        }
    }
}
