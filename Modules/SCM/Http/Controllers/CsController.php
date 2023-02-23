<?php

namespace Modules\SCM\Http\Controllers;

use Illuminate\Http\Request;
use Modules\SCM\Entities\Cs;
use Modules\Admin\Entities\Brand;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\SCM\Entities\Material;
use Illuminate\Database\QueryException;
use Modules\SCM\Http\Requests\CsRequest;
use Illuminate\Contracts\Support\Renderable;
use Termwind\Components\Dd;

class CsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        // $this->middleware('permission:comparative-statement-view|comparative-statement-create|comparative-statement-edit|comparative-statement-delete', ['only' => ['index','show', 'getCsPdf', 'getAllDetails', 'getMaterialSuppliersDetails', 'csApproved']]);
        // $this->middleware('permission:comparative-statement-create', ['only' => ['create','store']]);
        // $this->middleware('permission:comparative-statement-edit', ['only' => ['edit','update']]);
        // $this->middleware('permission:comparative-statement-delete', ['only' => ['destroy']]);
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

        return view('scm::cs.create', compact('all_materials', 'Taxes', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CsRequest $request)
    {
        try {
            $all_details = $this->getAllDetails($request->toArray());

            DB::beginTransaction();

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
        // dd($c);
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
        $brands = Brand::latest()->get();
        $all_materials = Material::with(['unit'])->get();

        return view('scm::cs.create', compact('all_materials', 'cs', 'Taxes', 'brands'));
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

            return redirect()->route('cs.index')->with('message', 'Comparative Statement created');
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
        foreach (array_keys($request['material_id']) as $material_key) {
            $cs_materials[] = [
                'material_id' => $request['material_id'][$material_key],
                'brand_id'    => $request['brand_id'][$material_key],
            ];
        }

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
}
