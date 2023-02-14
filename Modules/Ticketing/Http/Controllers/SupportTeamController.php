<?php

namespace Modules\Ticketing\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Dataencoding\Employee;
use Illuminate\Contracts\Support\Renderable;

class SupportTeamController extends Controller
{
    CONST EMPLOYEELEVELS = [
            '1' => 'Level 1',
            '2' => 'Level 2',
            '3' => 'Level 3',
    ];
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('ticketing::teams.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $formType = 'create';
        $levels = self::EMPLOYEELEVELS;
        return view('ticketing::teams.create-edit', compact('formType', 'levels'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        return $request->all();
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('ticketing::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('ticketing::edit');
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
