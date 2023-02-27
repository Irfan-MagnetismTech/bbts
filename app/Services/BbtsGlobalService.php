<?php

namespace App\Services;

use Illuminate\Http\Request;
use Modules\Admin\Entities\Pop;
use App\Http\Controllers\Controller;
use App\Models\Dataencoding\Department;
use App\Models\Dataencoding\Designation;
use Modules\Ticketing\Entities\TicketSource;
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
}
