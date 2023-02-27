<?php

namespace Modules\Ticketing\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Renderable;
use Modules\Ticketing\Entities\TicketSource;

class TicketSourceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $complainSources = (new TicketSource())->all();
        return view('ticketing::complain-source.index', compact('complainSources'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('ticketing::complain-source.create-edit');
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
                'name' => 'required|unique:ticket_sources,name'
            ]);
            
            DB::transaction(function () use ($request)
            {
                    TicketSource::create([
                        'name' => $request->name,
                        'created_by'       => auth()->user()->id
                    ]);
                
            });

            return redirect()->route('complain-sources.index')->with('message', 'Complain Source Created Successfully');
        }
        catch (QueryException $e)
        {
            return back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        // return view('ticketing::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(TicketSource $complainSource)
    {
        return view('ticketing::complain-source.create-edit', compact('complainSource'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(TicketSource $complainSource, Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|unique:ticket_sources,name,' . $complainSource->id
            ]);
            
            DB::transaction(function () use ($request, $complainSource)
            {
                $complainSource->update([
                        'name' => $request->name,
                        'updated_by'       => auth()->user()->id
                ]);
                
            });

            return redirect()->route('complain-sources.index')->with('message', 'Complain Source Updated Successfully');
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
            TicketSource::where('id', $id)->delete();
            return redirect()->route('complain-sources.index')->with('message', 'Complain Source Deleted Successfully');
        } catch (\Throwable $th) {
            return redirect()->route('complain-sources.index')->withInput()->withErrors($th->getMessage());
        }
    }
}
