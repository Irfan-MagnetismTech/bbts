<?php

namespace Modules\Networking\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\QueryException;
use Modules\Networking\Entities\DataType;
use Modules\Networking\Http\Requests\DataTypeRequest;

class DataTypeController extends Controller
{
    use HasRoles;
    function __construct()
    {
        // $this->middleware('permission:dataType-view|dataType-create|dataType-edit|dataType-delete', ['only' => ['index','show']]);
        // $this->middleware('permission:dataType-create', ['only' => ['create','store']]);
        // $this->middleware('permission:dataType-edit', ['only' => ['edit','update']]);
        // $this->middleware('permission:dataType-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $dataTypes = DataType::latest()->get();
        $formType = "create";
        return view('networking::data-types.create', compact('dataTypes', 'formType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = "create";
        $dataTypes = DataType::latest()->get();
        return view('networking::data-types.create', compact('dataTypes', 'formType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  DataTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DataTypeRequest $request)
    {
        try {
            $data = $request->all();
            DataType::create($data);
            return redirect()->route('data-types.create')->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            return redirect()->route('data-types.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  DataType  $dataType
     * @return \Illuminate\Http\Response
     */
    public function show(DataType $dataType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  DataType  $dataType
     * @return \Illuminate\Http\Response
     */
    public function edit(DataType $dataType)
    {
        $formType = "edit";
        $dataTypes = DataType::latest()->get();
        return view('networking::data-types.create', compact('dataType', 'dataTypes', 'formType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  DataTypeRequest  $request
     * @param  DataType  $dataType
     * @return \Illuminate\Http\Response
     */
    public function update(DataTypeRequest $request, DataType $dataType)
    {
        try {
            $data = $request->all();
            $dataType->update($data);
            return redirect()->route('data-types.create')->with('message', 'Data has been updated successfully');
        } catch (QueryException $e) {
            return redirect()->route('data-types.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DataType  $dataType
     * @return \Illuminate\Http\Response
     */
    public function destroy(DataType $dataType)
    {
        try {
            $dataType->delete();
            return redirect()->route('data-types.create')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $e) {
            return redirect()->route('data-types.create')->withErrors($e->getMessage());
        }
    }
}
