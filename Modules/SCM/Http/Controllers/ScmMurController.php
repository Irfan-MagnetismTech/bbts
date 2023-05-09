<?php

namespace Modules\SCM\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Modules\SCM\Entities\ScmMur;
use Modules\Admin\Entities\Brand;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\Branch;
use App\Services\BbtsGlobalService;
use Modules\SCM\Entities\ScmChallan;
use Modules\Sales\Entities\ClientDetail;
use Modules\SCM\Entities\ScmRequisition;
use Modules\Sales\Entities\SaleLinkDetail;
use Illuminate\Contracts\Support\Renderable;

class ScmMurController extends Controller
{
    private $murNo;

    public function __construct(BbtsGlobalService $globalService)
    {
        $this->murNo = $globalService->generateUniqueId(ScmMur::class, 'MUR');
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $scmMurs = ScmMur::latest()->get();
        return view('scm::mur.index', compact('scmMurs'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $challanData = ScmChallan::find(request()->challan_id);
        if ($challanData) {
            $challanData->load('scmRequisition', 'client', 'scmChallanLines');
        }

        $formType = "create";
        $brands = Brand::latest()->get();
        $branchs = Branch::latest()->get();
        $client_links = SaleLinkDetail::where('fr_no', $challanData->fr_no)->pluck('link_no');
        $challanLines = [];
        foreach ($challanData->scmChallanLines as $key => $value) {
            $serial_count = count(json_decode($value->serial_code));
            if ($serial_count) {
                foreach (json_decode($value->serial_code) as $key1 => $value1) {
                    $challanLines[] = [
                        'material_id' => $value->material_id,
                        'material_name' => $value->material->name,
                        'description' => $value->description,
                        'item_code' => $value->material->code,
                        'unit' => $value->material->unit,
                        'brand_id' => $value->brand_id,
                        'brand_name' => $value->brand->name,
                        'model' => $value->model,
                        'serial_code' => $value1,
                        'quantity' => ($value->material->type == 'Drum') ? $value->quantity : 1,
                    ];
                }
            } else {
                $challanLines[] = [
                    'material_id' => $value->material_id,
                    'material_name' => $value->material->name,
                    'description' => $value->description,
                    'item_code' => $value->material->code,
                    'unit' => $value->material->unit,
                    'brand_id' => $value->brand_id,
                    'brand_name' => $value->brand->name,
                    'model' => $value->model,
                    'serial_code' => '',
                    'quantity' => $value->quantity,
                ];
            }
        }
        $challanLines = collect($challanLines);
        return view('scm::mur.create', compact('formType', 'brands', 'branchs', 'challanData', 'challanLines'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $challan_data = ScmChallan::find($request->challan_id);
            $stock_data = $challan_data->stockable;
            $receivable_id = $stock_data->first()->receiveable_id;
            $receivable_type = $stock_data->first()->receiveable_type;
            $mur_data = $request->all();
            $mur_data['mur_no'] = $this->murNo;
            $mur_data['created_by'] = auth()->user()->id;
            $mur = ScmMur::create($mur_data);
            $stock = [];
            $mur_lines = [];
            foreach ($request->material_name as $key => $val) {
                $mur_lines[] = [
                    'material_id' => $request->material_id[$key],
                    'description' => $request->description[$key],
                    'brand_id' => $request->brand_id[$key],
                    'model' => $request->model[$key],
                    'serial_code' => $request->model[$key],
                    'quantity' => $request->quantity[$key],
                    'utilized_quantity' => $request->utilized_quantity[$key],
                    'client_ownership' => $request->client_ownership[$key],
                    'bbts_ownership' => $request->bbts_ownership[$key],
                    'remarks' => $request->remarks[$key],
                ];

                $stock[] = [
                    'received_type'     => 'MRR',
                    'stockable_type'    => ScmMur::class,
                    'receiveable_id'    => $receivable_id,
                    'receiveable_type'  => $receivable_type,
                    'material_id'       => $request->material_id[$key],
                    'stockable_type'    => ScmMur::class,
                    'stockable_id'      => $mur->id,
                    'brand_id'          => $request->brand_id[$key],
                    'branch_id'         => $request->branch_id,
                    'model'             => $request->model[$key],
                    'quantity'          => -1 * ($request->utilized_quantity[$key]),
                    'item_code'         => $request->item_code[$key],
                    'serial_code'       =>  $request->serial_code[$key],
                    'unit'              => $request->unit[$key],
                ];
            };
            $mur->lines()->createMany($mur_lines);
            $challan_data->stockable()->delete();
            $mur->stockable()->createMany($stock);
            DB::commit();
            return redirect()->route('material-utilizations.index')->with('message', 'Data has been updated successfully');
        } catch (Exception $err) {
            DB::rollBack();
            return redirect()->route('material-utilizations.index')->withInput()->withErrors($err->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show()
    {
        return view('scm::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(ScmMur $material_utilization)
    {
        dd($material_utilization);
        return view('scm::edit');
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

    public function searchChallanNo()
    {
        $data = ScmChallan::query()
            ->where('challan_no', 'like', '%' . request()->search . '%')
            ->get()
            ->take(10)
            ->map(fn ($item) => [
                'value'     => $item->challan_no,
                'label'     => $item->challan_no,
                'id'        => $item->id,
                'date'      => $item->date,
            ])
            ->values()
            ->all();

        return response()->json($data);
    }
}
