<?php

namespace Modules\Ticketing\Http\Controllers;

use App\Http\Controllers\Services\BbtsGlobalService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use PhpParser\Node\Stmt\TryCatch;

class SupportTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('ticketing::support-tickets.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $complainTypes = (new BbtsGlobalService())->getComplainTypes();
        return view('ticketing::support-tickets.create-edit', compact('complainTypes'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        

        try {
            $time = decrypt($request->opening_date);
        } catch (\Throwable $th) {
            
        }
        
        return ['opening_date' => decrypt("eyJpdiI6IkRDaW4ybmY5ejk4UER5WmgvaHVZcWc9PSIsInZhbHVlIjoiYnZScnVsTkplWG1sYnBqTUFEY0d1WXM4QWNMZjR5UjQ1ZVcyeUxjMC9lST0iLCJtYWMiOiJlYTk1M2QzYTcxMDY5ZTIxZmJmOTdmMWViYWQwMGNkZTU0Mjg5MGEyNGM5N2FiNjNmMmJiODNlYzc0ZDg5MWQ3IiwidGFnIjoiIn0=")];
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
        $complainTypes = (new BbtsGlobalService())->getComplainTypes();
        return view('ticketing::support-tickets.create-edit', compact('complainTypes'));
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
