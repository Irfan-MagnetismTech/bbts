<?php

namespace Modules\SCM\Http\Controllers;

use Modules\Admin\Entities\Pop;
use Modules\Admin\Entities\Brand;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\Branch;
use Modules\Sales\Entities\Client;
use App\Services\BbtsGlobalService;
use Modules\SCM\Entities\OpeningStock;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\QueryException;
use Modules\Sales\Entities\ClientDetail;
use Modules\SCM\Http\Requests\SupplierRequest;
use Modules\SCM\Http\Requests\OpeningStockRequest;
use Illuminate\Http\Request;

class OpeningStockController extends Controller
{
    use HasRoles;

    function __construct(BbtsGlobalService $globalService)
    {
        $this->middleware('permission:opening-stocks-view|opening-stocks-create|opening-stocks-edit|opening-stocks-delete', ['only' => ['index', 'show', 'getCsPdf', 'getAllDetails', 'getMaterialSuppliersDetails', 'csApproved']]);
        $this->middleware('permission:opening-stocks-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:opening-stocks-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:opening-stocks-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $openingStocks = OpeningStock::latest()->get();
        return view('scm::opening-stocks.index', compact('openingStocks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = Brand::latest()->get();

        return view('scm::opening-stocks.create', compact('brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();
            $openingStock = OpeningStock::create($request);

            $stockDetails = [];
            foreach ($request->material_id as $key => $data) {
                $stockDetails[] = [
                    'material_id' => $request->material_id[$key],
                    'brand_id' => $request->brand_id[$key],
                    'model' => $request->model[$key],
                    'quantity' => $request->quantity[$key],
                    'unit_price' => $request->unit_price[$key],
                    'total_amount' => $request->unit_price[$key] * $request->quantity[$key],
                ];
            }

            $openingStock->lines()->createMany($stockDetails);
            DB::commit();

            return redirect()->route('opening-stocks.index')->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('opening-stocks.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OpeningStock  $openingStock
     * @return \Illuminate\Http\Response
     */
    public function show(OpeningStock $openingStock)
    {
        return view('scm::opening-stocks.show', compact('openingStock'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OpeningStock  $openingStock
     * @return \Illuminate\Http\Response
     */
    public function edit(OpeningStock $openingStock)
    {
        $formType = "edit";
        $brands = Brand::latest()->get();
        $branchs = Branch::latest()->get();

        return view('scm::opening-stocks.create', compact('openingStock', 'formType', 'brands', 'branchs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OpeningStock  $openingStock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OpeningStock $openingStock)
    {
        try {
            DB::beginTransaction();

            $openingStock->update($request->all());

            $stockDetails = [];
            foreach ($request->material_id as $key => $data) {
                $stockDetails[] = [
                    'material_id' => $request->material_id[$key],
                    'brand_id' => $request->brand_id[$key],
                    'model' => $request->model[$key],
                    'quantity' => $request->quantity[$key],
                    'unit_price' => $request->unit_price[$key],
                    'total_amount' => $request->unit_price[$key] * $request->quantity[$key],
                ];
            }

            $openingStock->lines()->delete();
            $openingStock->lines()->createMany($stockDetails);
            DB::commit();

            return redirect()->route('opening-stocks.index')->with('message', 'Data has been updated successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('opening-stocks.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OpeningStock  $openingStock
     * @return \Illuminate\Http\Response
     */
    public function destroy(OpeningStock $openingStock)
    {
        try {
            $openingStock->delete();
            $openingStock->lines()->delete();
            return redirect()->route('opening-stocks.index')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $e) {
            return redirect()->route('opening-stocks.index')->withErrors($e->getMessage());
        }
    }
}