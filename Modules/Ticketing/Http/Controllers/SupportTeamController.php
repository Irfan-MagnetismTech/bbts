<?php

namespace Modules\Ticketing\Http\Controllers;

use App\Models\Dataencoding\Employee;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Ticketing\Entities\SupportTeam;
use Modules\Ticketing\Http\Requests\SupportTeamRequest;

class SupportTeamController extends Controller
{
    const EMPLOYEELEVELS = [
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
        $teams = SupportTeam::select('users_id', 'departments_id')
                ->with([
                    'teamLead' => function ($query) {
                        return $query->select('id', 'name');
                    }, 'department' => function ($q) {
                        return $q->select('id', 'name');
                    },
                ])->paginate(15);
        // dd($teams);
        return view('ticketing::teams.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $formType = 'create';
        $levels   = self::EMPLOYEELEVELS;

        return view('ticketing::teams.create-edit', compact('formType', 'levels'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
       
        try {
            
            DB::transaction(function () use ($request)
            {
                
                $leader = Employee::find($request->employee_id);
                if($leader){
                    $team   = SupportTeam::create([
                        'departments_id' => $leader->departments_id,
                        'users_id'       => $request->employee_id,
                        'branches_id'    => $leader->branches_id,
                    ]);
                }else{
                    dd('not fine');
                }
                
                dd($request->all());
                $teamMembers = [];
                foreach ($request->users_id as $key => $data)
                {
                    $teamMembers[] = [
                        'users_id'    => $request->users_id[$key],
                        'type'        => $request->type[$key],
                        'branches_id' => $leader->branches_id,
                    ];
                }

                $team->teamMembers()->createMany($teamMembers);
            });

            return 'fine';

            return redirect()->route('support-teams')->with('message', 'Support Team Created Successfully');
        }
        catch (QueryException $e)
        {
            return 'not fine';
            return redirect()->route('support-teams.create')->withInput()->withErrors($e->getMessage());
        }

        

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
