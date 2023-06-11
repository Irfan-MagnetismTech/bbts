<?php

namespace Modules\Admin\Http\Controllers;

use Modules\Admin\Entities\Bank;
use Illuminate\Routing\Controller;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\QueryException;
use Modules\Admin\Http\Requests\BankRequest;

class BankController extends Controller
{
    use HasRoles;
    function __construct()
    {
        // $this->middleware('permission:bank-view|bank-create|bank-edit|bank-delete', ['only' => ['index','show']]);
        // $this->middleware('permission:bank-create', ['only' => ['create','store']]);
        // $this->middleware('permission:bank-edit', ['only' => ['edit','update']]);
        // $this->middleware('permission:bank-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $banks = Bank::latest()->get();
        $formType = "create";
        return view('admin::banks.create', compact('banks', 'formType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = "create";
        $banks = Bank::latest()->get();
        return view('admin::banks.create', compact('banks', 'formType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BankRequest $request)
    {
        try {
            $data = $request->all();
            Bank::create($data);
            return redirect()->route('banks.create')->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            return redirect()->route('banks.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function show(Bank $bank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function edit(Bank $bank)
    {
        $formType = "edit";
        $banks = Bank::latest()->get();
        return view('admin::banks.create', compact('bank', 'banks', 'formType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function update(BankRequest $request, Bank $bank)
    {
        try {
            $data = $request->all();
            $bank->update($data);
            return redirect()->route('banks.create')->with('message', 'Data has been updated successfully');
        } catch (QueryException $e) {
            return redirect()->route('banks.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bank $bank)
    {
        try {
            $bank->delete();
            return redirect()->route('banks.create')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $e) {
            return redirect()->route('banks.create')->withErrors($e->getMessage());
        }
    }
}
