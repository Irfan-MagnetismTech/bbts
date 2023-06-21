<?php

namespace Modules\Networking\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Admin\Entities\Pop;
use Illuminate\Routing\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Renderable;
use Modules\Networking\Entities\NetPopEquipment;
use Modules\Networking\Http\Requests\NetPopEquipmentRequest;

class NetPopEquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('networking::pop-equipment.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $pops = Pop::latest()->get();
        return view('networking::pop-equipment.create', compact('pops'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(NetPopEquipmentRequest $request)
    {
        try {
            NetPopEquipment::create($request->all());
            return redirect()->route('pop-equipments.index')->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            return redirect()->route('pop-equipments.create')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(NetPopEquipment $pop_equipment)
    {
        abort(404);
        return view('networking::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(NetPopEquipment $pop_equipment)
    {
        return view('networking::pop-equipment.create');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(NetPopEquipmentRequest $request, NetPopEquipment $pop_equipment)
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

    public function getPopEquipments()
    {
        $pop_equipments = NetPopEquipment::with('pop')->latest()->get();
        return datatables()->of($pop_equipments)
            ->addColumn('action', function ($pop_equipment) {
                return view('networking::pop-equipment.action', compact('pop_equipment'))->render();
            })
            ->addColumn('pop_name', function ($pop_equipment) {
                return $pop_equipment->pop->pop_name;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Get model wise serial codes
     *
     * @return void
     */
    public function modelWiseSerialCodes()
    {
        $data['options'] = StockLedger::query()
            ->where([
                'material_id' => request()->material_id,
                'brand_id' => request()->brand_id,
                'model' => request()->model,
                'receiveable_id' => request()->receiveable_id,
                'received_type' => request()->received_type,
                'branch_id' => request()->from_branch_id
            ])
            ->get()
            ->groupBy('serial_code')
            ->flatMap(function ($item, $key) {
                $quantity = $item->sum('quantity');
                if ($quantity > 0) {
                    $serial_code[$key] = [
                        'label' => $key,
                        'value' => $key,
                    ];
                    return $serial_code;
                }
            })
            ->values();
        return response()->json($data);
    }

    public function brandWiseModels()
    {
        $data['options'] = StockLedger::query()
            ->where([
                'material_id' => request()->material_id,
                'brand_id' => request()->brand_id,
                'receiveable_id' => request()->receiveable_id,
                'received_type' => request()->received_type,
                'branch_id' => request()->from_branch_id
            ])
            ->get()
            ->unique('model')
            ->map(fn ($item) => [
                'value' => $item->model,
                'label' => $item->model,
            ])
            ->values()
            ->all();

        return response()->json($data);
    }

    public function mrsAndTypeWiseMaterials()
    {
        $data['options'] = StockLedger::query()
            ->with('material')
            ->whereIn('material_id', function ($q) {
                return $q->select('material_id')
                    ->from('scm_requisition_details')
                    ->where('scm_requisition_id', request()->scm_requisition_id);
            })
            ->where(['receiveable_id' => request()->receiveable_id, 'received_type' => request()->received_type, 'branch_id' => request()->from_branch])
            ->get()
            ->unique('material_id')
            ->map(fn ($item) => [
                'value' => $item->material->id,
                'label' => $item->material->name,
                'type' => $item->material->type,
                'unit' => $item->material->unit,
                'code' => $item->material->code,
            ])
            ->values()
            ->all();

        return response()->json($data);
    }
}
