<?php

namespace Modules\Admin\Http\Controllers;

use Termwind\Components\Dd;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\Service;
use Modules\Sales\Entities\Product;
use App\Models\Dataencoding\Division;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Modules\Admin\Entities\ConnectivityLink;
use Modules\Admin\Http\Requests\ServiceRequest;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return Renderable
     */
    public function index()
    {
        $services = Service::latest()->get();
        return view('admin::services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     * 
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
     * 
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
     * 
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     * 
     * @param int $id
     * @return Renderable
     */
    public function edit(Service $service)
    {
        $formType = "edit";
        $divisions = Division::latest()->get();
        $products = Product::latest()->get();
        return view('admin::services.create', compact('formType', 'divisions', 'products', 'service'));
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(ServiceRequest $request, Service $service)
    {
        $requestData = $request->all();
        try {
            DB::beginTransaction();
            $service->update($requestData);

            $serviceLines = [];
            foreach ($request->service_id as $key => $val) {
                $serviceLines[] = $this->getServiceLines($request, $key);
            }
            $service->serviceLines()->delete();
            $service->serviceLines()->createMany($serviceLines);
            DB::commit();

            return redirect()->route('services.index')->with('message', 'Data has been updated successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param Service $service Object
     * @return Renderable
     */
    public function destroy(Service $service)
    {
        try {
            $service->delete();
            $service->serviceLines()->delete();

            return redirect()->route('services.index')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Get BBTS Link ID
     * 
     * @return JsonResponse
     */
    public function get_bbts_link_id(): JsonResponse
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
                    'vendor_link_id'        => $item->vendor_link_id,
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
     * Prepare Service Lines
     * 
     * @param Request $requestData Request Data
     * @param int $key1 Key
     * 
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

    public function existingServices()
    {
        return response()->json(Service::query()
            ->with('serviceLines.product')
            ->where('bbts_link_id', request('bbts_link_id'))
            ->last());
    }
}
