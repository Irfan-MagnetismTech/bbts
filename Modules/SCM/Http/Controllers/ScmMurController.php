<?php

namespace Modules\SCM\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Admin\Entities\Brand;
use Illuminate\Routing\Controller;
use Modules\Admin\Entities\Branch;
use Modules\SCM\Entities\ScmRequisition;
use Illuminate\Contracts\Support\Renderable;
use Modules\SCM\Entities\ScmChallan;

class ScmMurController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('scm::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $challanData = ScmChallan::find(request()->challan_id);
        if ($challanData) {
            $challanData->load('scmRequisition', 'client');
        }

        $formType = "create";
        $brands = Brand::latest()->get();
        $branchs = Branch::latest()->get();
        $purposes = [
            'activation' => 'Activation',
            'maintenance' => 'Maintenance',
            'shifting' => 'Shifting',
            'own_use' => 'Own Use',
            'stolen' => 'Stolen',
        ];
        $out_from = ['mrr', 'err', 'wcr'];
        return view('scm::mur.create', compact('formType', 'brands', 'branchs', 'purposes', 'out_from', 'challanData'));
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
}
