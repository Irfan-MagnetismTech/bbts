<?php

namespace Modules\Networking\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Dataencoding\Employee;
use Modules\Sales\Entities\SaleDetail;
use Illuminate\Contracts\Support\Renderable;

class ConnectivityController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $salesDetails = SaleDetail::query() 
        ->with('sale', 'client', 'frDetails')
        ->latest()
        ->get();
        return view('networking::connectivities.index', compact('salesDetails'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($fr_no)
    {         
        $salesDetail = SaleDetail::query() 
        ->with('sale', 'client', 'frDetails')
        ->where('fr_no', $fr_no)
        ->first();

        $employees = Employee::latest()->get();

    return view('networking::connectivities.create', compact('salesDetail', 'employees'));
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
        return view('networking::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('networking::edit');
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
