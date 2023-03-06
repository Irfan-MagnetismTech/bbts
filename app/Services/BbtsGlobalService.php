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
}
