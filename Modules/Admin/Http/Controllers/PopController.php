<?php

namespace Modules\Admin\Http\Controllers;

use App\Services\UploadService;
use Modules\Admin\Entities\Pop;
use Modules\Admin\Entities\Bank;
use App\Models\Dataencoding\Thana;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\Branch;
use App\Models\Dataencoding\District;
use App\Models\Dataencoding\Division;
use Modules\Admin\Entities\Particular;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\QueryException;
use Modules\Admin\Http\Requests\PopRequest;
use Termwind\Components\Dd;

class PopController extends Controller
{
    use HasRoles;
    function __construct(private UploadService $uploadFile)
    {
        // $this->middleware('permission:pop-view|pop-create|pop-edit|pop-delete', ['only' => ['index','show']]);
        // $this->middleware('permission:pop-create', ['only' => ['create','store']]);
        // $this->middleware('permission:pop-edit', ['only' => ['edit','update']]);
        // $this->middleware('permission:pop-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $pops = Pop::with('branch')->latest()->get();
        $formType = "create";
        return view('admin::pops.index', compact('pops', 'formType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = "create";
        $pops = Pop::latest()->get();
        $branches = Branch::latest()->get();
        $divisions = Division::latest()->get();
        $particulars = Particular::get();
        $banks = Bank::latest()->get();

        return view('admin::pops.create', compact('formType', 'branches', 'pops', 'divisions', 'particulars', 'banks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PopRequest $request)
    {
        $requestData = $request->all();
        $requestData['attached_file'] = $this->uploadFile->handleFile($request->attached_file, 'admin/pop');
        try {
            DB::beginTransaction();
            $pop = Pop::create($requestData);

            $popLines = [];
            foreach ($request->particular_id as $key => $val) {
                $popLines[] = $this->getPopLines($request, $key);
            }
            $pop->popLines()->createMany($popLines);
            DB::commit();

            return redirect()->route('pops.index')->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pop  $pop
     * @return \Illuminate\Http\Response
     */
    public function show(Pop $pop)
    {
        $formType = "show";
        $branches = Branch::latest()->get();
        $divisions = Division::latest()->get();
        $districts = District::latest()->get();
        $thanas = Thana::latest()->get();
        $particulars = Particular::get();
        $banks = Bank::latest()->get();

        $pops = Pop::latest()->get();
        return view('admin::pops.show', compact('pop', 'pops', 'formType', 'branches', 'divisions', 'particulars', 'banks', 'districts', 'thanas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pop  $pop
     * @return \Illuminate\Http\Response
     */
    public function edit(Pop $pop)
    {
        $formType = "edit";
        $branches = Branch::latest()->get();
        $divisions = Division::latest()->get();
        $districts = District::latest()->get();
        $thanas = Thana::latest()->get();
        $particulars = Particular::get();
        $banks = Bank::latest()->get();

        $pops = Pop::latest()->get();
        return view('admin::pops.create', compact('pop', 'pops', 'formType', 'branches', 'divisions', 'particulars', 'banks', 'districts', 'thanas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pop  $pop
     * @return \Illuminate\Http\Response
     */
    public function update(PopRequest $request, Pop $pop)
    {
        $requestData = $request->all();
        $requestData['amount'] = array_map('intval', $request->amount);
        if ($request->hasFile('attached_file')) {
            $requestData['attached_file'] = $this->uploadFile->handleFile($request->attached_file, 'admin/pop', $pop->attached_file);
        } else {
            $requestData['attached_file'] = $pop->attached_file;
        }

        try {
            DB::beginTransaction();
            $pop->update($requestData);

            $pop->popLines()->delete();
            $popLines = [];
            foreach ($requestData['amount'] as $key => $val) {
                $popLines[] = $this->getPopLines($requestData, $key);
            }

            $pop->popLines()->createMany($popLines);
            DB::commit();

            return redirect()->route('pops.index')->with('message', 'Data has been updated successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            dd($e->getMessage());
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pop  $pop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pop $pop)
    {
        try {
            DB::beginTransaction();
            $this->uploadFile->deleteFile($pop->attached_file);
            $pop->delete();
            $pop->popLines()->delete();
            DB::commit();

            return redirect()->route('pops.index')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('pops.create')->withErrors($e->getMessage());
        }
    }

    /**
     * Get pop lines
     *
     */
    private function getPopLines($requestData, $key1)
    {
        return  [
            'particular_id'   => $requestData['particular_id'][$key1],
            'amount'          => $requestData['amount'][$key1],
        ];
    }
}
