<?php

namespace Modules\Ticketing\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Services\BbtsGlobalService;
use Carbon\Carbon;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Support\Facades\DB;
use Modules\Sales\Entities\Client;
use Modules\Sales\Entities\FeasibilityRequirementDetail;
use Modules\Ticketing\Entities\clientTicketOpen;
use Modules\Ticketing\Entities\SupportTicket;

class ClientTicketOpenController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('ticketing::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        // dd('ff');
        $complainTypes = (new BbtsGlobalService())->getComplainTypes();
        return view('ticketing::client-ticket-opens.create',compact('complainTypes'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {
            // $clientInfo = Client::where('client_no', $request->client_no)->first(); 

            $lastTicketOfThisMonth = SupportTicket::where('created_at', '>=', Carbon::now()->startOfMonth())
                ->orderBy('created_at', 'desc')
                ->first();

            if (empty($lastTicketOfThisMonth)) {
                $ticketIno = Carbon::now()->format('ymd') . '-000001';
            } else {
                $ticketIno = (int) substr($lastTicketOfThisMonth->ticket_no, 7) + 1; // substring 6 character because ymd takes 6 character space
                $ticketIno = Carbon::now()->format('ymd') . '-' . str_pad($ticketIno, 6, '0', STR_PAD_LEFT);
            }

            $frInfo = FeasibilityRequirementDetail::where('fr_no', $request->fr_no)->first();

            $ticketInfo = $request->only([ 'fr_no', 'client_no','support_complain_type_id', 'description' ]);
            $ticketInfo['ticket_no'] = $ticketIno;
            $ticketInfo['opening_date'] = now()->format('Y-m-d H:i:s');
            $ticketInfo['complain_time'] = now()->format('Y-m-d H:i:s');
            $ticketInfo['pop_id'] = 2;
            if(!empty($frInfo)){
                $ticketInfo['branch_id'] = $frInfo->branch_id;
                $ticketInfo['division_id'] = $frInfo->division_id;
                $ticketInfo['district_id'] = $frInfo->district_id;
                $ticketInfo['thana_id'] = $frInfo->thana_id;
            } 

            $ticketInfo['ticket_source_id'] = 4;
            
            // dd($ticketInfo);
            DB::transaction(function () use ($ticketInfo) {
                SupportTicket::create($ticketInfo);

            });

            return back()->with('message', 'Ticket Create Successfully');
        } catch (QueryException $e) {
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
