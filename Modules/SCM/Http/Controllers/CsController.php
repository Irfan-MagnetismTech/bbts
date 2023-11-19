<?php

namespace Modules\SCM\Http\Controllers;

use Modules\SCM\Entities\MaterialBrand;
use Modules\SCM\Entities\MaterialModel;
use PDF;
use App\Services\BbtsGlobalService;
use Illuminate\Http\Request;
use Modules\Sales\Entities\Client;
use Modules\Sales\Entities\FeasibilityRequirement;
use Modules\SCM\Entities\Cs;
use Modules\Admin\Entities\Brand;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\SCM\Entities\CsMaterial;
use Modules\SCM\Entities\CsSupplier;
use Modules\SCM\Entities\Indent;
use Modules\SCM\Entities\IndentLine;
use Modules\SCM\Entities\Material;
use Illuminate\Database\QueryException;
use Modules\SCM\Entities\ScmPurchaseRequisitionDetails;
use Modules\SCM\Http\Requests\CsRequest;
use Illuminate\Contracts\Support\Renderable;
use Termwind\Components\Dd;
use Spatie\Permission\Traits\HasRoles;

class CsController extends Controller
{
    protected $csNo;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct(BbtsGlobalService $globalService)
    {
        $this->csNo = $globalService->generateUniqueId(Cs::class, 'CS');

        $this->middleware('permission:scm-comparative-statement-view|scm-comparative-statement-create|scm-comparative-statement-edit|scm-comparative-statement-delete', ['only' => ['index', 'show', 'getCsPdf', 'getAllDetails', 'getMaterialSuppliersDetails', 'csApproved']]);
        $this->middleware('permission:scm-comparative-statement-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:scm-comparative-statement-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:scm-comparative-statement-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_cs = Cs::latest()->get();

        return view('scm::cs.index', compact('all_cs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Taxes = [
            'Include', 'Exclude'
        ];
        $brands = Brand::latest()->get();
        $all_materials = Material::with(['unit'])->get();
        $models = MaterialModel::pluck('model');
        return view('scm::cs.create', compact('all_materials', 'Taxes', 'brands','models'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    //   dd($request->all());
        try {
            $all_details = $this->getAllDetails($request->toArray());
            DB::beginTransaction();

            $all_details['all_request']['cs_no'] = $this->csNo;
            $all_details['all_request']['created_by'] = auth()->id();

            $cs = Cs::create($all_details['all_request']);
            $cs_materials = $cs->csMaterials()->createMany($all_details['cs_materials']);
            $cs_suppliers = $cs->csSuppliers()->createMany($all_details['cs_suppliers']);
            $cs->csMaterialsSuppliers()->createMany($this->getMaterialSuppliersDetails($cs_materials, $cs_suppliers, $request));

            DB::commit();

            return redirect()->route('cs.index')->with('success', 'CS created successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('cs.create')->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Cs $c)
    {
        $comparativestatement = $c;
        $csMaterials = CsMaterial::latest()->get();
        $csSuppliers = CsSupplier::latest()->get();

        return view('scm::cs.show', compact('comparativestatement', 'csMaterials', 'csSuppliers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Cs $c)
    {
        $cs = $c;
        $Taxes = [
            'Include', 'Exclude'
        ];
        $models = MaterialModel::pluck('model');
        $brands = Brand::latest()->get();

        $indent_id = Indent::where('indent_no', $cs->indent_no)->value('id');

        $scm_purchase_requisition_ids = IndentLine::where('indent_id', $indent_id)->pluck('scm_purchase_requisition_id');

        $material_ids = ScmPurchaseRequisitionDetails::whereIn('scm_purchase_requisition_id', $scm_purchase_requisition_ids)->pluck('material_id');


        $all_materials= Material::whereIn('id', $material_ids)
            ->get();

        return view('scm::cs.create', compact('all_materials', 'cs', 'Taxes', 'brands','models'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CsRequest $request, Cs $c)
    {
        $cs = $c;

        try {
            $all_details = $this->getAllDetails($request->toArray());

            DB::beginTransaction();

            $all_details['all_request']['created_by'] = auth()->id();
            $cs->update($all_details['all_request']);

            $cs->csMaterials()->delete();
            $cs_materials = $cs->csMaterials()->createMany($all_details['cs_materials']);

            $cs->csSuppliers()->delete();
            $cs_suppliers = $cs->csSuppliers()->createMany($all_details['cs_suppliers']);

            $cs->csMaterialsSuppliers()->delete();
            $cs->csMaterialsSuppliers()->createMany($this->getMaterialSuppliersDetails($cs_materials, $cs_suppliers, $request));

            DB::commit();

            return redirect()->route('cs.index')->with('message', 'Comparative Statement Updated');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('cs.create')->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cs $c)
    {
        $cs = $c;
        try {
            DB::beginTransaction();

            $cs->delete();
            $cs->csMaterials()->delete();
            $cs->csSuppliers()->delete();
            $cs->csMaterialsSuppliers()->delete();

            DB::commit();

            return redirect()->route('cs.index')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('cs.index')->withErrors($e->getMessage());
        }
    }

    /**
     * @param Cs $cs
     */
    public function getCsPdf(Cs $cs)
    {
        return \PDF::loadview('procurement.comparativestatements.pdf', compact('cs'))->setPaper('a4', 'landscape')->stream('comparative-statement.pdf');
    }

    /**
     * @param array $request
     * @return array
     */
    private function getAllDetails(array $request): array
    {
        $cs_materials = [];
        $brands = [];
        $models = [];
        foreach (array_keys($request['material_id']) as $material_key) {
            $cs_materials[] = [
                'material_id' => $request['material_id'][$material_key],
                'brand_id'    => $request['brand_id'][$material_key],
                'model'      => $request['model'][$material_key],
            ];
            $brands[] = [
                'material_id' => $request['material_id'][$material_key],
                'brand_id' => $request['brand_id'][$material_key],
            ];
            $models[] = [
                'material_id' => $request['material_id'][$material_key],
                'brand_id'    => $request['brand_id'][$material_key],
                'model'      => $request['model'][$material_key],
            ];
            $material_brand = MaterialBrand::updateOrCreate(
                [
                    'material_id' => $request['material_id'][$material_key],
                    'brand_id' => $request['brand_id'][$material_key],
                ],
                $brands
            );
            $material_model = MaterialModel::updateOrCreate(
                [
                    'material_id' => $request['material_id'][$material_key],
                    'brand_id'    => $request['brand_id'][$material_key],
                    'model'      => $request['model'][$material_key],
                ],
                $models
            );
        }

        $cs_suppliers = [];
        foreach (array_keys($request['supplier_id']) as $supplier_key) {
            $cs_suppliers[] = [
                'supplier_id'           => $request['supplier_id'][$supplier_key],
                'quotation_no'         => $request['quotation_no'][$supplier_key],
                'vat_tax'               => $request['vat_tax'][$supplier_key],
                'credit_period'         => $request['credit_period'][$supplier_key],
                'is_checked'            => in_array($request['supplier_id'][$supplier_key], $request['checked_supplier']) ? true : false,
            ];
        }

        return
            [
                'all_request'            => $request,
                'cs_materials'           => $cs_materials,
                'cs_suppliers'           => $cs_suppliers
            ];
    }

    /**
     * @param array $cs_materials
     * @param array $cs_suppliers
     * @param array $request
     * @return array
     */
    private function getMaterialSuppliersDetails($cs_materials, $cs_suppliers, $request)
    {
        $price_index = 0;

        foreach ($cs_materials as $cs_material) {
            foreach ($cs_suppliers as $cs_supplier) {
                $cs_materials_suppliers[] = [
                    'cs_material_id' => $cs_material->id,
                    'brand_id'       => $cs_material->brand_id,
                    'cs_supplier_id' => $cs_supplier->id,
                    'price'          => $request['price'][$price_index++],
                    'model'          => $cs_material->model,
                ];
            }
        }

        return $cs_materials_suppliers;
    }

    // public function csApproved(Cs $cs, $status)
    // {
    //     try{
    //         $approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($cs) {
    //             $q->where([['name','CS'],['department_id',$cs->appliedBy->department_id]]);
    //         })->whereDoesntHave('approvals',function ($q) use($cs){
    //             $q->where('approvable_id',$cs->id)->where('approvable_type',Cs::class);
    //         })->orderBy('order_by','asc')->first();

    //         $data = [
    //             'layer_key' => $approval->layer_key,
    //             'user_id' => auth()->id(),
    //             'status' => $status,
    //         ];
    //         $cs->approval()->create($data);

    //         return redirect()->route('cs.index')->with('message', "Cs No $cs->reference_no approved.");
    //     }catch(QueryException $e){
    //         return redirect()->back()->withInput()->withErrors($e->getMessage());
    //     }
    // }

    public function generateCsPdf($id = null)
    {
        $comparativeStatement = Cs::where('id', $id)->first();
        $csMaterials = CsMaterial::latest()->get();
        $csSuppliers = CsSupplier::latest()->get();

        return PDF::loadView('scm::cs.pdf', ['comparativeStatement' => $comparativeStatement, 'csMaterials' => $csMaterials, 'csSuppliers' => $csSuppliers], [], [
            'format'                     => 'A4',
            'orientation'                => 'L',
            'title'                      => 'CS PDF',
            'watermark'                  => 'BBTS',
            'show_watermark'             => true,
            'watermark_text_alpha'       => 0.1,
            'watermark_image_path'       => '',
            'watermark_image_alpha'      => 0.2,
            'watermark_image_size'       => 'D',
            'watermark_image_position'   => 'P',
        ])->stream('cs.pdf');
        return view('scm::cs.pdf', compact('comparativeStatement', 'csMaterials', 'csSuppliers'));
    }
    public function getIndentNo()
    {
        $items = Indent::query()
            ->where('indent_no', 'like', '%' . request()->search . '%')
            ->get()
            ->map(fn ($item) => [
                'value'                 => $item->indent_no,
                'label'                 => $item->indent_no
            ]);
        return response()->json($items);
    }
    public function searchMaterialByIndent(Request $request)
    {
        $indent_id = Indent::where('indent_no', $request->indent_no)->value('id');

        $scm_purchase_requisition_ids = IndentLine::where('indent_id', $indent_id)->pluck('scm_purchase_requisition_id');

        $material_ids = ScmPurchaseRequisitionDetails::whereIn('scm_purchase_requisition_id', $scm_purchase_requisition_ids)->pluck('material_id');


        $results= Material::whereIn('id', $material_ids)
            ->get()
            ->map(function ($item) {
                if (request('branch_id')) {
                    $stockData = StockLedger::where('material_id', $item->id)
                        ->where('branch_id', request('branch_id'))
                        ->sum('quantity');
                }

                return [
                    'value' => $item->id,
                    'material_id' => $item->id,
                    'label' => $item->name . ' - ' . $item->code,
                    'unit' => $item->unit,
                    'item_code' => $item->code,
                    'stock_data' => $stockData ?? 0
                ];
            });

        return response()->json($results);
    }
}


//$material_id = $is_old ? old('material_id')[$material_key] : $material_value->material->id;
//$material_name = $is_old ? old('material_name')[$material_key] : $material_value->material->materialNameWithCode ?? '---';
//$unit = $is_old ? old('unit')[$material_key] : $material_value->material->unit ?? '---';
//$brand_id = $is_old ? old('brand_id')[$material_key] : $material_value?->brand_id;
//$model = $is_old ? old('model')[$material_key] : $material_value->model ?? '---';
