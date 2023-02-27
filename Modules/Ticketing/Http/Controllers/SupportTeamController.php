<?php

namespace Modules\Ticketing\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Admin\Entities\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Services\BbtsGlobalService;
use App\Models\Dataencoding\Employee;
use Illuminate\Database\QueryException;
use Modules\Ticketing\Entities\SupportTeam;
use Illuminate\Contracts\Support\Renderable;
use Modules\Ticketing\Http\Requests\SupportTeamRequest;

class SupportTeamController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $teams = SupportTeam::select('id', 'users_id', 'departments_id')
                ->with([
                    'teamLead' => function ($query) {
                        return $query->select('id', 'name', 'employees_id');
                    }, 'department' => function ($q) {
                        return $q->select('id', 'name');
                    },
                ])->paginate(15);
        return view('ticketing::teams.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $levels   = config('businessinfo.supportEmployeeLevels');
        $departments = (new BbtsGlobalService())->getDepartments();

        return view('ticketing::teams.create-edit', compact('levels', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
       
        try {
            
            $leader = User::where('id', $request->employee_id)->first();

            $teamMembers = [];
            foreach ($request->users_id as $key => $data)
            {
                $teamMembers[] = [
                    'users_id'    => $request->users_id[$key],
                    'type'        => $request->type[$key],
                    'branches_id' => $leader->employee->branches_id
                ];
            }

            DB::transaction(function () use ($request, $leader, $teamMembers)
            {
                if($leader){
                    $team   = SupportTeam::create([
                        'departments_id' => $request->departments_id,
                        'users_id'       => $request->employee_id,
                        'branches_id'    => $leader->employee->branches_id
                    ]);
                }
                
                $team->teamMembers()->createMany($teamMembers);
            });

            return redirect()->route('support-teams.index')->with('message', 'Support Team Created Successfully');
        }
        catch (QueryException $e)
        {
            return redirect()->route('support-teams.create')->withInput()->withErrors($e->getMessage());
        }

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(SupportTeam $supportTeam)
    {
        $levels   = config('businessinfo.supportEmployeeLevels');
        return view('ticketing::teams.details', compact('supportTeam', 'levels'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(SupportTeam $supportTeam)
    {
        $levels   = config('businessinfo.supportEmployeeLevels');
        $departments = (new BbtsGlobalService())->getDepartments();

        return view('ticketing::teams.create-edit', compact('supportTeam', 'levels', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(SupportTeam $supportTeam, Request $request)
    {

        try {
            
            $leader = User::where('id', $request->employee_id)->first();

            $teamMembers = [];
            foreach ($request->users_id as $key => $data)
            {
                $teamMembers[] = [
                    'users_id'    => $request->users_id[$key],
                    'type'        => $request->type[$key],
                    'branches_id' => $leader->employee->branches_id
                ];
            }

            DB::transaction(function () use ($request, $leader, $teamMembers, $supportTeam)
            {
                if($leader){
                    $supportTeam->update([
                        'departments_id' => $request->departments_id,
                        'users_id'       => $request->employee_id,
                        'branches_id'    => $leader->employee->branches_id
                    ]);
                }
                
                $supportTeam->teamMembers()->delete();
                $supportTeam->teamMembers()->createMany($teamMembers);
            });

            return redirect()->route('support-teams.index')->with('message', 'Support Team Updated Successfully');
        }
        catch (QueryException $e)
        {
            return redirect()->route('support-teams.edit')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        try {
            SupportTeam::where('id', $id)->delete();
            return redirect()->route('support-teams.index')->with('message', 'Support Team Deleted Successfully');
        } catch (\Throwable $th) {
            return redirect()->route('support-teams.index')->withInput()->withErrors($th->getMessage());
        }
    }
}
