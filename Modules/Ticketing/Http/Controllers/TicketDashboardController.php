<?php

namespace Modules\Ticketing\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;
use Modules\Ticketing\Entities\TicketSource;
use Modules\Ticketing\Entities\SupportTicket;
use Modules\Ticketing\Entities\SupportTicketLifeCycle;

class TicketDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $from = $request->date_from ?? Carbon::now()->startOfMonth()->startOfDay();
        $to = $request->date_to ?? Carbon::now()->endOfMonth()->endOfDay();

        $supportTickets = SupportTicket::when(!empty($from), function($fromQuery) use($from) {
                                $fromQuery->whereDate('created_at', '>=', Carbon::parse($from)->startOfDay());
                            })
                            ->when(!empty($to), function($toQuery) use($to) {
                                $toQuery->whereDate('created_at', '<=', Carbon::parse($to)->endOfDay());
                            })
                            ->orderBy('created_at', 'desc')
                            ->get();
        
        $ticketSourcesId = $supportTickets->pluck('ticket_source_id')->unique()->values()->all();
        $sources = TicketSource::whereIn('id', $ticketSourcesId)->get();

        $supportTicketLifeCycles = SupportTicketLifeCycle::when(!empty($from), function($fromQuery) use($from) {
                            $fromQuery->whereDate('created_at', '>=', Carbon::parse($from)->startOfDay());
                        })
                        ->when(!empty($to), function($toQuery) use($to) {
                            $toQuery->whereDate('created_at', '<=', Carbon::parse($to)->endOfDay());
                        })
                        ->selectRaw('*, DATE(created_at) as date')
                        ->get();
        $recentActivities = $supportTicketLifeCycles->reverse()->take(5);

        $supportTicketLifeCycles = $supportTicketLifeCycles->groupBy('date')->map(function($item) {
                            return $item->groupBy('status');
                        });
        

        return view('ticketing::dashboard', compact('supportTickets', 'sources', 'from', 'to', 'supportTicketLifeCycles', 'recentActivities'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('ticketing::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('ticketing::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('ticketing::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
