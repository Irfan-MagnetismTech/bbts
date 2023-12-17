<?php

namespace Modules\SCM\Http\Controllers;

use Modules\Admin\Entities\Brand;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\Branch;
use App\Services\BbtsGlobalService;
use Modules\SCM\Entities\MaterialBrand;
use Modules\SCM\Entities\MaterialModel;
use Modules\SCM\Entities\OpeningStock;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\QueryException;
use Modules\Sales\Entities\ClientDetail;
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
        $brands = Brand::get();
        $branches = Branch::get();
        $models = MaterialModel::pluck('model');
        return view('scm::opening-stocks.create', compact('brands', 'branches', 'models'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OpeningStockRequest $request)
    {
        try {
            DB::beginTransaction();
            $openingStock = OpeningStock::create($request->all());
            $brands = [];
            $models = [];
            $stockDetails = [];
            $serialCode = [];
            foreach ($request->material_id as $key => $data) {
                $stockDetails[] = [
                    'material_id' => $request->material_id[$key],
                    'brand_id' => $request->brand_id[$key],
                    'model' => $request->model[$key],
                    'quantity' => $request->quantity[$key],
                    'unit_price' => $request->unit_price[$key],
                    'total_amount' => $request->unit_price[$key] * $request->quantity[$key],
                ];
                $serialCode[] = explode(',', $request->serial_code[$key]);

                $brands[] = [
                    'material_id' => $request->material_id[$key],
                    'brand_id' => $request->brand_id[$key],
                ];
                $models[] = [
                    'material_id' => $request->material_id[$key],
                    'brand_id' => $request->brand_id[$key],
                    'model' => $request->model[$key],
                ];
                $material_brand = MaterialBrand::updateOrCreate(
                    [
                        'material_id' => $request->material_id[$key],
                        'brand_id' => $request->brand_id[$key],
                    ],
                    $brands
                );
                $material_model = MaterialModel::updateOrCreate(
                    [
                        'material_id' => $request->material_id[$key],
                        'brand_id' => $request->brand_id[$key],
                        'model' => $request->model[$key],
                    ],
                    $models
                );
            }

            $detail = $openingStock->lines()->createMany($stockDetails);

            $stock = [];
            foreach ($detail as $key => $value) {
                $value->serialCodeLines()->createMany(array_map(function ($serial) use ($request, $key, $value, $openingStock, &$stock) {
                    if ($request->material_type[$key] == 'Drum') {
                        $serial_code = 'F-' . $serial;
                        $quantity = $value->quantity;
                    } else {
                        if ($serial == '') {
                            $serial_code = Null;
                            $quantity = $value->quantity;
                        } else {
                            $serial_code = 'SL-' . $serial;
                            $quantity = 1;
                        }
                    }
                    $stock[] = [
                        'received_type'     => 'OS',
                        'material_id'       => $value->material_id,
                        'brand_id'          => $value->brand_id,
                        'branch_id'         => $request->branch_id,
                        'model'             => $value->model,
                        'quantity'          => $quantity,
                        'unit_price'        => $value->unit_price,
                        'serial_code'       => $serial_code,
                        'unit'              => $request->unit[$key],
                        'date'              => $request->date,
                    ];
                    return [
                        'serial_or_drum_key'    =>  $serial,
                        'serial_or_drum_code'   =>  $serial_code,
                    ];
                }, $serialCode[$key]));
            }
            $openingStock->stockable()->createMany($stock);

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
        $branches = Branch::latest()->get();
        $models = MaterialModel::pluck('model');
        return view('scm::opening-stocks.create', compact('openingStock', 'formType', 'brands', 'branches', 'models'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OpeningStock  $openingStock
     * @return \Illuminate\Http\Response
     */

    public function update(OpeningStockRequest $request, OpeningStock $openingStock)
    {
        try {
            DB::beginTransaction();

            $openingStock->update($request->all());
            $brands = [];
            $models = [];
            $stockDetails = [];
            $serialCode = [];
            foreach ($request->material_id as $key => $data) {
                $stockDetails[] = [
                    'material_id' => $request->material_id[$key],
                    'brand_id' => $request->brand_id[$key],
                    'model' => $request->model[$key],
                    'quantity' => $request->quantity[$key],
                    'unit_price' => $request->unit_price[$key],
                    'total_amount' => $request->unit_price[$key] * $request->quantity[$key],
                ];
                $serialCode[] = explode(',', $request->serial_code[$key]);

                $brands[] = [
                    'material_id' => $request->material_id[$key],
                    'brand_id' => $request->brand_id[$key],
                ];
                $models[] = [
                    'material_id' => $request->material_id[$key],
                    'brand_id' => $request->brand_id[$key],
                    'model' => $request->model[$key],
                ];
                $material_brand = MaterialBrand::updateOrCreate(
                    [
                        'material_id' => $request->material_id[$key],
                        'brand_id' => $request->brand_id[$key],
                    ],
                    $brands
                );
                $material_model = MaterialModel::updateOrCreate(
                    [
                        'material_id' => $request->material_id[$key],
                        'brand_id' => $request->brand_id[$key],
                        'model' => $request->model[$key],
                    ],
                    $models
                );
            }

            foreach ($openingStock->lines as $openingStockLine) {
                $openingStockLine->serialCodeLines()->delete();
            }
            $openingStock->lines()->delete();
            $openingStock->stockable()->delete();
            $detail = $openingStock->lines()->createMany($stockDetails);

            $stock = [];
            foreach ($detail as $key => $value) {
                $value->serialCodeLines()->createMany(array_map(function ($serial) use ($request, $key, $value, $openingStock, &$stock) {
                    if ($request->material_type[$key] == 'Drum') {
                        $serial_code = 'F-' . $serial;
                        $quantity = 1;
                    } else {
                        if ($serial == '') {
                            $serial_code = Null;
                            $quantity = $value->quantity;
                        } else {
                            $serial_code = 'SL-' . $serial;
                            $quantity = 1;
                        }
                    }
                    $stock[] = [
                        'received_type'     => 'OS',
                        'material_id'       => $value->material_id,
                        'brand_id'          => $value->brand_id,
                        'branch_id'         => $request->branch_id,
                        'model'             => $value->model,
                        'quantity'          => $quantity,
                        'unit_price'        => $value->unit_price,
                        'serial_code'       => $serial_code,
                        'unit'              => $request->unit[$key],
                        'date'              => $request->date,
                    ];
                    return [
                        'serial_or_drum_key'    =>  $serial,
                        'serial_or_drum_code'   =>  $serial_code,
                    ];
                }, $serialCode[$key]));
            }

            $openingStock->stockable()->createMany($stock);

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
            DB::beginTransaction();
            foreach ($openingStock->lines as $openingStockLine) {
                $openingStockLine->serialCodeLines()->delete();
            }
            $openingStock->lines()->delete();
            $openingStock->stockable()->delete();
            $openingStock->delete();
            DB::commit();

            return redirect()->route('opening-stocks.index')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $e) {
            return redirect()->route('opening-stocks.index')->withErrors($e->getMessage());
        }
    }
}
