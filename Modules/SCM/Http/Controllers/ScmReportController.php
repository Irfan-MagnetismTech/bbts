<?php

namespace Modules\SCM\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Modules\Admin\Entities\Brand;
use Modules\SCM\Entities\MaterialBrand;
use Modules\SCM\Entities\Unit;
use Illuminate\Routing\Controller;
use Modules\SCM\Entities\Material;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\QueryException;
use Modules\SCM\Entities\ScCategory;
use Modules\SCM\Http\Requests\MaterialRequest;
use Illuminate\Http\Request;
use Modules\SCM\Entities\CsMaterial;

class ScmReportController extends Controller
{
    use HasRoles;

    function __construct()
    {
        $this->middleware('permission:material-view|material-create|material-edit|material-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:material-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:material-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:material-delete', ['only' => ['destroy']]);
    }

    public function materialReport(){
        $materials = Material::with('unit','materialBrand')->get()
            ->map(function ($material, $key) {
                $brand = $material->materialBrand?->brand;
                $brandArray = str_getcsv($brand);
                $material->brand = Brand::whereIn('id',$brandArray)->get()->toArray();
                return $material;
            });
        // dd($materials->brand);
        return view('scm::reports.material_report', compact('materials'));
    }

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
