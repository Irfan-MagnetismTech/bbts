<?php

namespace Modules\SCM\Http\Controllers;

use Termwind\Components\Dd;
use Illuminate\Http\Request;
use Modules\Admin\Entities\Brand;
use Illuminate\Routing\Controller;
use Modules\Admin\Entities\Branch;
use Illuminate\Contracts\Support\Renderable;
use Modules\SCM\Entities\ScmMur;

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
        $brands = Brand::latest()->get();
        $branchs = Branch::latest()->get();
        return view('scm::errs.create', compact('formType', 'brands', 'branchs'));
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
        $materials = ScmMur::where('client_id', request()->client_id)->get();
        return response()->json($materials);
    }
}
