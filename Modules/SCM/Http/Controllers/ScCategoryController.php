<?php

namespace Modules\SCM\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SCM\Entities\ScCategory;
use Illuminate\Database\QueryException;
use Modules\SCM\Http\Requests\ScCategoryRequest;

class ScCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $categories = ScCategory::latest()->get();
        // dd($categories);

        return view('scm::sc-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $formType = "create";
        return view('scm::sc-categories.create', compact('formType'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(ScCategoryRequest $request)
    {
        try {
            $data = $request->all();
            ScCategory::create($data);
            return redirect()->route('sc-categories.index')->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            return redirect()->route('sc-categories.create')->withInput()->withErrors($e->getMessage());
        }
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
        $category = ScCategory::findOrfail($id);
        $formType = "edit";
        $categories = ScCategory::latest()->get();

        return view('scm::sc-categories.create', compact('formType', 'categories', 'category'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(ScCategoryRequest $request, $id)
    {
      $category = ScCategory::findOrfail($id);
      try {
        $data = $request->all();
        $category->update($data);
        return redirect()->route('sc-categories.index')->with('message', 'Data has been updated successfully');
    } catch (QueryException $e) {
        return redirect()->route('sc-categories.create')->withInput()->withErrors($e->getMessage());
    }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $category = ScCategory::findOrfail($id);
        try {
            $category->delete();
            return redirect()->route('sc-categories.index')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $e) {
            return redirect()->route('sc-categories.index')->withErrors($e->getMessage());
        }
    }
}
