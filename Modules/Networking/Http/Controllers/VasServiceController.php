<?php

namespace Modules\Networking\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Sales\Entities\Client;
use Modules\Sales\Entities\Vendor;
use Modules\Sales\Entities\Product;
use Illuminate\Database\QueryException;
use Modules\Networking\Entities\VasService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;

class VasServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(): Renderable
    {
        $datas = VasService::query()
            ->with('client', 'vendor')
            ->latest()
            ->get();

        return view('networking::vas-services.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(): Renderable
    {
        $products = Product::whereHas('category', function ($query) {
            $query->where('name', 'VAS');
        })->get();

        return view('networking::vas-services.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return ResponseRedirect
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $linesData = [];
            foreach ($request->product_id as $key => $value) {
                $linesData[] = [
                    'product_id' => $value,
                    'unit' => $request->unit[$key],
                    'quantity' => $request->quantity[$key],
                    'rate' => $request->rate[$key],
                    'total' => $request->total[$key],
                    'description' => $request->description[$key],
                ];
            }
            $vasService = VasService::create($request->all());
            $vasService->lines()->createMany($linesData);

            DB::commit();

            return redirect()->route('vas-services.index')->with('message', 'Data has been inserted successfully');
        } catch (QueryException $err) {
            DB::rollBack();

            return redirect()->back()->withInput()->withErrors($err->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param VasService $vasService
     * @return Renderable
     */
    public function show($id): Renderable
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     * @param VasService $vasService
     * @return Renderable
     */
    public function edit(VasService $vasService): Renderable
    {
        $products = Product::whereHas('category', function ($query) {
            $query->where('name', 'VAS');
        })->get();
        $fr_nos = Client::with('saleDetails')->where('client_no', $vasService->client_no)->first()?->saleDetails ?? [];

        $vendors = Vendor::all();

        return view('networking::vas-services.create', compact('products', 'vasService', 'fr_nos', 'vendors'));
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param Request $request
     * @param VasService $vasService
     * @return RedirectResponse
     */
    public function update(Request $request, VasService $vasService): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $linesData = [];
            foreach ($request->product_id as $key => $value) {
                $linesData[] = [
                    'product_id' => $value,
                    'unit' => $request->unit[$key],
                    'quantity' => $request->quantity[$key],
                    'rate' => $request->rate[$key],
                    'total' => $request->total[$key],
                    'description' => $request->description[$key],
                ];
            }
            $vasService->update($request->all());
            $vasService->lines()->delete();
            $vasService->lines()->createMany($linesData);

            DB::commit();

            return redirect()->route('vas-services.index')->with('message', 'Data has been updated successfully');
        } catch (QueryException $err) {
            DB::rollBack();

            return redirect()->back()->withInput()->withErrors($err->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param VasService $vasService
     * @return RedirectResponse
     */
    public function destroy(VasService $vasService): RedirectResponse
    {
        try {
            $vasService->delete();
            $vasService->lines()->delete();

            return redirect()->route('vas-services.index')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $err) {
            return redirect()->back()->withInput()->withErrors($err->getMessage());
        }
    }
}
