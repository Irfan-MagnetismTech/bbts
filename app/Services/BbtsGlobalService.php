<?php

namespace App\Services;

use Illuminate\Http\Request;
use Modules\Admin\Entities\Pop;
use App\Http\Controllers\Controller;
use App\Models\Dataencoding\Department;
use App\Models\Dataencoding\Designation;
use Modules\Ticketing\Entities\SupportTeam;
use Modules\Ticketing\Entities\TicketSource;
use Modules\Ticketing\Entities\SupportTicket;
use Modules\Ticketing\Entities\SupportComplainType;
use Modules\Ticketing\Entities\SupportQuickSolution;
use Modules\Ticketing\Entities\TicketMovement;

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
        }


        
    }

    public function supportTeambyBranch($branchId) {
        return SupportTeam::where('branch_id', $branchId)->get();
    }

    public function getSupportTeam() {
        return SupportTeam::get();
    }
}
