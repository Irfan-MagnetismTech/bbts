<?php

namespace Modules\SCM\Http\Controllers;

use Termwind\Components\Dd;
use Illuminate\Http\Request;
use Modules\SCM\Entities\ScmErr;
use Modules\SCM\Entities\ScmMrr;
use Modules\SCM\Entities\ScmMur;
use Modules\SCM\Entities\ScmWcr;
use Modules\Admin\Entities\Brand;
use Illuminate\Routing\Controller;
use Modules\Admin\Entities\Branch;
use Modules\SCM\Entities\StockLedger;
use Modules\SCM\Entities\ScmRequisition;
use Illuminate\Contracts\Support\Renderable;
use Modules\SCM\Entities\ScmMurLine;
use Modules\SCM\Entities\ScmPurchaseRequisition;

class ScmErrController extends Controller
{
    protected $laravel;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('scm::errs.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $formType = "create";
        return view('scm::errs.create', compact('formType'));
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
        return view('scm::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('scm::edit');
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

    public function clientMurWiseMaterials()
    {
        $materials = ScmMurLine::query()
            ->when(request()->type === 'client', function ($query) {
                $query->whereHas('scmMur', function ($query) {
                    $query->where([
                        'client_no' => request()->client_no,
                        'fr_no' => request()->fr_no,
                        'equipment_type' => request()->equipment_type,
                        'type' => 'client',
                    ])->when(request()->link_no, function ($query) {
                        $query->where('link_no', request()->link_no);
                    });
                });
            })
            ->when(request()->type === 'internal', function ($query) {
                $query->whereHas('scmMur', function ($query) {
                    $query->where(['pop_id' => request()->pop_id, 'type' => 'pop']);
                });
            })
            ->get();

        return response()->json($materials);
    }
}
