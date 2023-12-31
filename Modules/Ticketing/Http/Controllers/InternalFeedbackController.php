<?php

namespace Modules\Ticketing\Http\Controllers;

use Illuminate\Support\Str;
use App\Services\SmsService;
use Illuminate\Http\Request;
use App\Services\EmailService;
use Illuminate\Support\Carbon;
use Modules\Admin\Entities\Brand;
use Modules\Admin\Entities\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Services\BbtsGlobalService;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Notification;
use Modules\Ticketing\Entities\InternalFeedback;
use Modules\Ticketing\Entities\SupportTicket;
use Modules\Ticketing\Entities\TicketMovement;
use App\Notifications\TicketMovementNotification;
use Exception;
use Modules\Sales\Entities\Client;
use Modules\Sales\Entities\FeasibilityRequirementDetail;
use Modules\Ticketing\Entities\SupportTeamMember;
use Modules\Ticketing\Entities\SupportQuickSolution;
use Modules\Ticketing\Http\Requests\SupportTicketRequest;
use Termwind\Components\Dd;

class InternalFeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $feedbacks = InternalFeedback::get();
        return view('ticketing::internal-feedbacks.index', compact('feedbacks'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $clients = Client::get();
        $brands = Brand::get();
        return view('ticketing::internal-feedbacks.create', compact('clients','brands'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->only('date', 'client_no', 'remarks');
            $internal_feedback = InternalFeedback::create($data);
            DB::commit();
            return redirect()->route('internal-feedbacks.index')->with('message', 'Data has been created successfully');
        } catch (Exception $error) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($error->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(InternalFeedback $feedback)
    {
        return view('ticketing::internal-feedbacks.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(InternalFeedback $feedback)
    {
        return view('ticketing::internal-feedbacks.create', compact('feedback'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(InternalFeedback $feedback, Request $request)
    {
        $clients = Client::get();
        $brands = FeasibilityRequirementDetail::where()->get();
        try {
            DB::beginTransaction();
            $data = $request->only('date', 'client_no', 'remarks');
            $feedback->delete();
            $feedback->update($data);

            DB::commit();
            return redirect()->route('internal-feedbacks.index')->with('message', 'Data has been updated successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('internal-feedbacks.create',compact('clients','brands'))->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(InternalFeedback $feedback)
    {
        try {
            $feedback->delete();
            return redirect()->route('internal-feedbacks.index')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $err) {
            return redirect()->route('internal-feedbacks.index')->withInput()->withErrors($err->getMessage());
        }
    }

    public function getClientInfo()
    {
        $items = Client::query()
            ->with('saleDetails.feasibilityRequirementDetails', 'billingAddress')
            ->where('client_no', 'like', '%' . request()->search . '%')
            ->get()
            ->map(fn ($item) => [
                'value'                 => $item->client_name,
                'label'                 => $item->client_name,
                'client_no'             => $item->client_no,
                'client_id'             => $item->id,
                'saleDetails' => $item->saleDetails
            ]);
        return response()->json($items);
    }
}
