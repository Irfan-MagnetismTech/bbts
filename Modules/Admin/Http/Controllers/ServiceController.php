<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\Service;
use Modules\Sales\Entities\Product;
use App\Models\Dataencoding\Division;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Renderable;
use Modules\Admin\Entities\ConnectivityLink;
use Modules\Admin\Http\Requests\ServiceRequest;
use Termwind\Components\Dd;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('admin::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $formType = "create";
        $divisions = Division::latest()->get();
        $products = Product::latest()->get();

        return view('admin::services.create', compact('formType', 'divisions', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(ServiceRequest $request)
    {
        $requestData = $request->all();
        try {
            DB::beginTransaction();
            $service = Service::create($requestData);

            $serviceLines = [];
            foreach ($request->service_id as $key => $val) {
                $serviceLines[] = $this->getServiceLines($request, $key);
            }
            $service->serviceLines()->createMany($serviceLines);
            DB::commit();

            return redirect()->route('services.index')->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('admin::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('admin::edit');
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

    public function get_bbts_link_id()
    {
        $vendors = ConnectivityLink::query()
            ->where('bbts_link_id', 'like', '%' . request('search') . '%')
            ->get()
            ->map(function ($item) {
                return [
                    'value'                 => $item->bbts_link_id,
                    'label'                 => $item->bbts_link_id,
                    'id'                    => $item->id,
                    'division_id'           => $item->division->name,
                    'district_id'           => $item->district->name,
                    'thana_id'              => $item->thana->name,
                    'vendor_id'             => $item->vendor_id,
                    'vendor_name'           => $item->vendor->name,
                    'link_name'             => $item->link_name,
                    'link_type'             => $item->link_type,
                    'from_location'         => $item->from_location,
                    'to_location'           => $item->to_location,
                    'from_site'             => $item->from_site,
                    'to_site'               => $item->to_site,
                    'gps'                   => $item->gps,
                    'vendor_link_id'        => $item->vendor_link_id,
                    'remarks'               => $item->remarks,
                ];
            });
        return response()->json($vendors);
    }

    /**
     * Get product details
     * @param Request $requestData
     * @param int $key1
     * @return array
     */
    private function getServiceLines($requestData, $key1)
    {
        return  [
            'product_id'        => $requestData->service_id[$key1],
            'quantity'          => $requestData->quantity[$key1],
            'rate'              => $requestData->rate[$key1],
            'remarks'           => $requestData->remarks[$key1],
        ];
    }
}
