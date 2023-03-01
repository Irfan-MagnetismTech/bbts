<?php

namespace Modules\Sales\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Sales\Entities\Followup;
use Modules\Sales\Entities\LeadGeneration;
use Modules\Sales\Http\Requests\FollowupRequest;

class FollowupController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $followups = Followup::with('meeting', 'client')->get();
        return view('sales::followup.index', compact('followups'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($meeting_id = null)
    {
        $work_nature_types = [
            '1' => 'New Client Visit / Activities for Potential Business',
            '2' => 'Rapport Building Activities for Existing Clients',
            '3' => 'Billing & Credit Control Activities',
            '4' => 'Ensure Customer Support',
            '5' => 'Office Work',
            '6' => 'Office Tour',
        ];
        $sale_types = [
            '1' => 'Physical Visit',
            '2' => 'Over the phone',
            '3' => 'Mail Correspondence',
            '4' => 'Video Conference',
        ];
        $clients = LeadGeneration::get();
        return view('sales::followup.create', compact('meeting_id', 'work_nature_types', 'sale_types', 'clients'));
    }
    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(FollowupRequest $request)
    {
        $data = $request->only('meeting_id', 'client_id', 'client_type', 'work_nature_type', 'sales_type', 'activity_date', 'work_start_time', 'work_end_time', 'potentility_amount', 'meeting_outcome');
        Followup::create($data);
        return redirect()->route('followup.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Followup $followup)
    {
        return view('sales::followup.show', compact('followup'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Followup $followup)
    {
        $work_nature_types = [
            '1' => 'New Client Visit / Activities for Potential Business',
            '2' => 'Rapport Building Activities for Existing Clients',
            '3' => 'Billing & Credit Control Activities',
            '4' => 'Ensure Customer Support',
            '5' => 'Office Work',
            '6' => 'Office Tour',
        ];
        $sale_types = [
            '1' => 'Physical Visit',
            '2' => 'Over the phone',
            '3' => 'Mail Correspondence',
            '4' => 'Video Conference',
        ];
        $clients = LeadGeneration::get();
        $meeting_id = $followup->meeting_id ?? null;
        return view('sales::followup.create', compact('followup', 'work_nature_types', 'sale_types', 'clients', 'meeting_id'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(FollowupRequest $request, Followup $followup)
    {
        $data = $request->only('meeting_id', 'client_id', 'client_type', 'work_nature_type', 'sales_type', 'activity_date', 'work_start_time', 'work_end_time', 'potentility_amount', 'meeting_outcome');
        $followup->update($data);
        return redirect()->route('followup.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Followup $followup)
    {
        $followup->delete();
        return redirect()->route('followup.index');
    }
}
