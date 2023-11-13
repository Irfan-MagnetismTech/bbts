<?php

namespace Modules\SCM\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Modules\Admin\Entities\Brand;
use Modules\SCM\Entities\MaterialBrand;
use Modules\SCM\Entities\MaterialModel;
use Modules\SCM\Entities\Unit;
use Illuminate\Routing\Controller;
use Modules\SCM\Entities\Material;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\QueryException;
use Modules\SCM\Entities\ScCategory;
use Modules\SCM\Http\Requests\MaterialRequest;
use Illuminate\Http\Request;
use Modules\SCM\Entities\CsMaterial;

class MaterialController extends Controller
{
    use HasRoles;

    function __construct()
    {
        $this->middleware('permission:material-view|material-create|material-edit|material-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:material-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:material-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:material-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
//        $materials = Material::with('unit','materialBrand')->get()
//        ->map(function ($material, $key) {
//            $brand = $material->materialBrand?->brand;
//            $brandArray = str_getcsv($brand);
//            $material->brand = Brand::whereIn('id',$brandArray)->get()->toArray();
//            return $material;
//        });
        $materials = Material::with('unit','material_brand')->get();
        return view('scm::materials.index', compact('materials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = "create";
        $materials = Material::get();
        $units = Unit::get();
        $brands = Brand::get();
        $material_models = MaterialModel::pluck('model');
        $types = ['Drum', 'Item'];
        $categories = ScCategory::latest()->get();

        return view('scm::materials.create', compact('materials', 'formType', 'types', 'units', 'categories', 'brands','material_models'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(MaterialRequest $request)
    {
        try {
            $material_data = $request->only('name', 'unit', 'type', 'code', 'category_id', 'min_qty');

            $material = Material::create($material_data);

            $brands = [];
            $models = [];
            foreach ($request->brand_id as $key => $value) {
                $brands[] = [
                    'material_id' => $material->id,
                    'brand_id' => $request->brand_id[$key],
                ];
                $models[] = [
                    'material_id' => $material->id,
                    'brand_id' => $request->brand_id[$key],
                    'model' => $request->model[$key],
                ];
            }
            $brand_detail = $material->material_brand()->createMany($brands);
            $model_detail = $material->material_model()->createMany($models);

            return redirect()->route('materials.index')->with('message', 'Data has been inserted successfully');
        } catch (ValidationException $e) {
            return redirect()->route('materials.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Material $material
     * @return \Illuminate\Http\Response
     */
    public function show(Material $material)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Material $material
     * @return \Illuminate\Http\Response
     */
    public function edit(Material $material)
    {
        $formType = "edit";
        $materials = Material::get();
        $units = Unit::get();
        $brands = Brand::get();
        $material_brands = MaterialBrand::where('material_id', $material->id)->pluck('brand_id');
        $material_models = MaterialModel::where('material_id', $material->id)->pluck('model');

        $types = ['Drum', 'Item'];
        $categories = ScCategory::latest()->get();
        return view('scm::materials.create', compact('material', 'materials', 'formType', 'types', 'units', 'categories', 'brands', 'material_brands','material_models'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Material $material
     * @return \Illuminate\Http\Response
     */

    public function update(MaterialRequest $request, Material $material, MaterialBrand $materialBrand)
    {
        try {
            $material_data = $request->only('name', 'unit', 'type', 'code', 'category_id', 'min_qty');
            $material->update($material_data);

            $selectedBrandIds = $request->input('brand_id');

            $selectedBrandIdsString = implode(',', $selectedBrandIds);

            $materialBrand->where('material_id', $material->id)->delete(); // Delete existing records

            $material_brand = $request->only('material_id', 'brand_id');
            $material_brand['material_id'] = $material->id;
            $material_brand['brand_id'] = $selectedBrandIdsString;
            MaterialBrand::create($material_brand);

            return redirect()->route('materials.index')->with('message', 'Data has been updated successfully');
        } catch (QueryException $e) {
            return redirect()->route('materials.edit', $material->id)->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Material $material
     * @return \Illuminate\Http\Response
     */
    public function destroy(Material $material)
    {
        try {
            $material->delete();
            $material->material_brand->delete();
            return redirect()->route('materials.index')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $e) {
            return redirect()->route('materials.index')->withErrors($e->getMessage());
        }
    }

    public function getUniqueCode(Request $request)
    {
        $category = ScCategory::find($request->id);
        $short_code = $category->short_code;
        try {
            $lastRecord = Material::where('category_id', $request->id)->latest()->first();
            if (isset($lastRecord)) {
                if (preg_match('/\d+/', $lastRecord->code, $matches)) {
                    $extractedNumber = $matches[0];
                    $finalNumber = $extractedNumber + 1;
                    $result = $short_code . '-' . str_pad($finalNumber, 4, '0', STR_PAD_LEFT);
                }
            } else {
                $result = $short_code . '-' . '0001';
            }
        } catch (\Exception $e) {
            // Handle the exception (e.g., log it or return an error response)
        }
        return $result;
    }

}
