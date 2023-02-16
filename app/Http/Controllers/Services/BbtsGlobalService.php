<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use App\Models\Dataencoding\Department;
use App\Models\Dataencoding\Designation;
use Illuminate\Http\Request;
use Modules\Admin\Entities\Pop;

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
}
