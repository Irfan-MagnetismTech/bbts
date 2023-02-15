<?php

namespace Modules\SCM\Http\Controllers;

use Illuminate\Http\Request;
use Modules\SCM\Entities\Cs;
use Illuminate\Routing\Controller;
use Modules\SCM\Entities\Material;
use Illuminate\Contracts\Support\Renderable;

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

        return view('procurement.comparativestatements.index', compact('all_cs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Taxes = [
            'Include','Exclude'
        ];
        $all_materials = Material::with(['unit'])->get();

        return view('scm::cs.create', compact('all_materials', 'Taxes'));
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
            $request     = $request->validated();
            $all_details = $this->getAllDetails($request);

            DB::transaction(function () use ($all_details, $request)
            {
                $cs= Cs::create($all_details['all_request']);
                $cs_materials = $cs->csMaterials()->createMany($all_details['cs_materials']);
                $cs_suppliers = $cs->csSuppliers()->createMany($all_details['cs_suppliers']);
                $cs->csMaterialsSuppliers()
                    ->createMany($this->getMaterialSuppliersDetails($cs_materials, $cs_suppliers, $request));
            });

            return redirect()->route('comparative-statements.index')->with('message', 'Comparative Statement created');

        }
        catch (QueryException $e)
        {
            return redirect()->route('comparative-statements.create')->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Cs $comparative_statement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Cs $comparative_statement)
    {
        $form_type = 'Update';
        $grades= [
            'A','B','C'
        ];

        $Taxes = [
            'Include','Exclude'
        ];
        $credit_Period = [
            'Advance',
            '10 days',
            '15 days',
            '20 days',
            '25 days',
            '30 days',
            '45 days',
            '60 days'
        ];

        $delivery_conditions = [
            'with carrying',
            'without carrying'
        ];
        $all_materials = NestedMaterial::with(['unit'])->get();

        return view('procurement.comparativestatements.create', compact('form_type', 'all_materials', 'comparative_statement','grades','Taxes','credit_Period','delivery_conditions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CsRequest $request, Cs $comparative_statement)
    {
        try {
            $request     = $request->validated();
            $all_details = $this->getAllDetails($request);

            DB::transaction(function () use ($comparative_statement, $all_details, $request)
            {
                $comparative_statement->update($all_details['all_request']);

                $comparative_statement->csMaterials()->delete();
                $cs_materials = $comparative_statement->csMaterials()->createMany($all_details['cs_materials']);

                $comparative_statement->csSuppliers()->delete();
                $cs_suppliers = $comparative_statement->csSuppliers()->createMany($all_details['cs_suppliers']);

                $comparative_statement->csMaterialsSuppliers()->delete();
                $comparative_statement->csMaterialsSuppliers()
                    ->createMany($this->getMaterialSuppliersDetails($cs_materials, $cs_suppliers, $request));
            });

            return redirect()->route('comparative-statements.index')->with('message', 'Comparative Statement created');

        }
        catch (QueryException $e)
        {
            return redirect()->route('comparative-statements.create')->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cs $comparative_statement)
    {
        try
        {
            $comparative_statement->delete();

            return redirect()->route('comparative-statements.index')->with('message', 'Data has been deleted successfully');
        }
        catch (QueryException $e)
        {
            return redirect()->route('comparative-statements.index')->withErrors($e->getMessage());
        }
    }

    /**
     * @param Cs $comparative_statement
     */
    public function getCsPdf(Cs $comparative_statement)
    {
        return \PDF::loadview('procurement.comparativestatements.pdf', compact('comparative_statement'))->setPaper('a4', 'landscape')->stream('comparative-statement.pdf');
    }

    /**
     * @param array $request
     * @return array
     */
    private function getAllDetails(array $request): array
    {
        foreach (array_keys($request['material_id']) as $material_key)
        {
            $cs_materials[] = [
                'material_id' => $request['material_id'][$material_key]
            ];
        }

        foreach (array_keys($request['supplier_id']) as $supplier_key)
        {
            $cs_suppliers[] = [
                'supplier_id'           => $request['supplier_id'][$supplier_key],
                'collection_way'        => $request['collection_way'][$supplier_key],
                'grade'                 => $request['grade'][$supplier_key],
                'vat_tax'               => $request['vat_tax'][$supplier_key],
                'tax'                   => $request['tax'][$supplier_key],
                'credit_period'         => $request['credit_period'][$supplier_key],
                'material_availability' => $request['material_availability'][$supplier_key],
                'delivery_condition'    => $request['delivery_condition'][$supplier_key],
                'required_time'         => $request['required_time'][$supplier_key],
                'is_checked'            => in_array($request['supplier_id'][$supplier_key], $request['checked_supplier']) ? true : false,
            ];
        }

        $price_index = 0;
        foreach (array_keys($request['material_id']) as $material_key)
        {
            foreach (array_keys($request['supplier_id']) as $supplier_key)
            {
                $cs_materials_suppliers[] = [
                    'material_id' => $request['material_id'][$material_key],
                    'supplier_id' => $request['supplier_id'][$supplier_key],
                    'price'       => $request['price'][$price_index++],
                ];
            }
        }

        return
            [
            'all_request'            => $request,
            'cs_materials'           => $cs_materials,
            'cs_suppliers'           => $cs_suppliers,
            'cs_materials_suppliers' => $cs_materials_suppliers,
        ];
    }

    /**
     * @param array $cs_materials
     * @param array $cs_suppliers
     * @param array $request
     * @return array
     */
    private function getMaterialSuppliersDetails($cs_materials, $cs_suppliers, $request): array
    {
        $price_index = 0;

        foreach ($cs_materials as $cs_material)
        {
            foreach ($cs_suppliers as $cs_supplier)
            {
                $cs_materials_suppliers[] = [
                    'cs_material_id' => $cs_material->id,
                    'cs_supplier_id' => $cs_supplier->id,
                    'price'          => $request['price'][$price_index++],
                ];
            }
        }

        return $cs_materials_suppliers;
    }

    public function csApproved(Cs $comparative_statement, $status)
    {
        try{
            $approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($comparative_statement) {
                $q->where([['name','CS'],['department_id',$comparative_statement->appliedBy->department_id]]);
            })->whereDoesntHave('approvals',function ($q) use($comparative_statement){
                $q->where('approvable_id',$comparative_statement->id)->where('approvable_type',Cs::class);
            })->orderBy('order_by','asc')->first();

            $data = [
                'layer_key' => $approval->layer_key,
                'user_id' => auth()->id(),
                'status' => $status,
            ];
            $comparative_statement->approval()->create($data);

            return redirect()->route('comparative-statements.index')->with('message', "Cs No $comparative_statement->reference_no approved.");
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}
