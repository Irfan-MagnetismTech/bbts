<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Modules\Admin\Entities\Pop;
use Modules\Admin\Entities\User;
use App\Http\Controllers\Controller;
use App\Models\Dataencoding\Department;
use App\Models\Dataencoding\Designation;
use Modules\Ticketing\Entities\SupportTeam;
use Modules\Ticketing\Entities\TicketSource;
use Modules\Ticketing\Entities\SupportTicket;
use Modules\Ticketing\Entities\TicketMovement;
use Modules\Ticketing\Entities\SupportTeamMember;
use Modules\Ticketing\Entities\SupportComplainType;
use Modules\Ticketing\Entities\SupportQuickSolution;

class BbtsGlobalService extends Controller
{
    public function getDepartments() {
        return Department::all();
    }

    public function getDesignations() {
        return Designation::all();
    }

    public function getPop() {
        return Pop::all();
    }

    public function getComplainTypes() {
        return SupportComplainType::all();
    }

    public function getSupportSolutions() {
        return SupportQuickSolution::all();
    }

    public function getTicketSources() {
        return TicketSource::all();
    }

    /**
     * @param model $model
     * @param string $prefix
     * @return string - unique id
     * 
     * this function is used to generate unique id for any model
     */
    public function generateUniqueId($model, $prefix): string
    {
        $lastIndentId = $model::latest()->first();
        if ($lastIndentId) {
            if (now()->format('Y') != date('Y', strtotime($lastIndentId->created_at))) {
                return strtoupper($prefix) . '-' . now()->format('Y') . '-' . 1;
            } else {
                return strtoupper($prefix) . '-' . now()->format('Y') . '-' . ($lastIndentId->id + 1);
            }
        } else {
            return strtoupper($prefix) . '-' . now()->format('Y') . '-' . 1;
        }
    }

    public function isEligibleForTicketMovement($ticketId, $movementType) {

        $supportTicket = SupportTicket::findOrFail($ticketId);

        if($supportTicket->status == 'Closed' || $supportTicket->status == 'Pending') {
            return false;
        }

        $movementTypes = config('businessinfo.ticketMovements'); // Forward, Backward, Handover

        if($movementTypes[0] == $movementType) {
            $acceptedUserId = $supportTicket->supportTicketLifeCycles->where('status', 'Accepted')->first()->user_id;

            if($acceptedUserId == auth()->user()->id) {
                return true;
            } else {
                return false;
            }
        } else if($movementTypes[1] == $movementType) {
            $forwardedTicketAccepter = TicketMovement::where('support_ticket_id', $ticketId)
                                                    ->where([
                                                        'type'=> $movementTypes[0],
                                                        'status' => 'Accepted',
                                                        'accepted_by' => auth()->user()->id
                                                        ])
                                                    ->first();


            if($forwardedTicketAccepter) {
                return true;
            } else {
                return false;
            }
        } else if($movementTypes[2] == $movementType) {
            $approved = $supportTicket->supportTicketLifeCycles->where('user_id', auth()->user()->id)->first();
            if($approved) {
                return true;
            } else {
                return false;
            }

        }


        
    }

    public function supportTeambyBranch($branchId) {
        return SupportTeam::where('branch_id', $branchId)->get();
    }

    public function getSupportTeam() {
        return SupportTeam::get();
    }

    public function getTicketMovementNotificationReceiversList($request, $inAppNotificationPermissions, $allTeamMembersId) {
        if(!empty($request->teamMemberId)) {
            $notificationReceivers = User::whereIn('id', [$request->teamMemberId])->whereHas('roles', function($q) use($inAppNotificationPermissions){
                $q->whereHas('permissions', function($q1) use($inAppNotificationPermissions) {
                  $q1->whereIn('name', $inAppNotificationPermissions);
                });
              })->get();
        } else {
            $notificationReceivers = User::whereIn('id', $allTeamMembersId)->whereHas('roles', function($q) use($inAppNotificationPermissions){
                $q->whereHas('permissions', function($q1) use($inAppNotificationPermissions) {
                  $q1->whereIn('name', $inAppNotificationPermissions);
                });
              })->get();
        }
        return $notificationReceivers;
    }

    public function filterTicketsBasedOnMovement($request, $movementType) {
        $from = $request->date_from;
        $to = $request->date_to;
        $supportTicketId = $request->ticket_no;

        $userSupportTeam = SupportTeamMember::where('user_id', auth()->user()->id)->get();
        /* 
            The line is eloquent get() method but not first(), 
            because each member might belong to multiple team as Mr. Humayun said.
        */

        $teamIds = $userSupportTeam->map(function($teamMember) {
            return $teamMember->support_team_id;
        })->toArray();
        
        $ticketNo = '';
        if(!empty($ticketNo)) {
            $ticketNo = SupportTicket::findOrFail($supportTicketId)->ticket_no;
        }

        $supportTicketMovements = TicketMovement::where(function($query) use($teamIds) {
                                        $query->where('movement_model', '\Modules\Ticketing\Entities\SupportTeam')
                                            ->whereIn('movement_to', $teamIds)
                                            ->orWhere(function($subquery) {
                                                        $subquery->where('movement_model', '\Modules\Admin\Entities\User')
                                                                ->where('movement_to', auth()->user()->id);
                                            });
                                    })
                                    ->where('type', $movementType)
                                    ->when(!empty($from), function($fromQuery) use($from) {
                                        $fromQuery->whereDate('created_at', '>=', Carbon::parse($from)->startOfDay());
                                    })
                                    ->when(!empty($to), function($toQuery) use($to) {
                                        $toQuery->whereDate('created_at', '<=', Carbon::parse($to)->endOfDay());
                                    })
                                    ->when(!empty($supportTicketId), function($ticketNoQuery) use($supportTicketId) {
                                        $ticketNoQuery->where('support_ticket_id', $supportTicketId);
                                    })
                                    ->orderBy('created_at', 'desc')
                                    ->get();
        return [ 
            'ticket' => [
                    'ticketNo' => $ticketNo,
                    'supportTicketId' => $supportTicketId
                ], 
            'supportTicketMovements' => $supportTicketMovements];
    }
}
