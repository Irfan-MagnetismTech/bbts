<?php

namespace Modules\Networking\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Admin\Entities\Pop;
use Illuminate\Routing\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\Support\Renderable;
use Modules\Networking\Entities\NetPopEquipment;
use Modules\Networking\Http\Requests\NetPopEquipmentRequest;
use Modules\SCM\Entities\ScmMur;

class NetPopEquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $popEquipments = NetPopEquipment::get();
        return view('networking::pop-equipment.index', compact('popEquipments'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $pops = Pop::get();
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
        return view('networking::pop-equipment.show', compact('pop_equipment'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(NetPopEquipment $pop_equipment)
    {
        return view('networking::pop-equipment.create', compact('pop_equipment'));
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
        $data = [];
        ScmMur::query()
            ->where('pop_id', request()->pop_id)
            ->with(['lines.material', 'lines.brand'])
            ->get()->map(function ($item) use (&$data) {
                $item->lines->map(function ($line) use (&$data) {
                    $data[] = [
                        'label' => $line->material->name . ' - ' . $line->brand->name . ' - ' . $line->model . ' - ' . $line->serial_code,
                        'value' => $line->material_id,
                        'material_id' => $line->material_id,
                        'brand_id' => $line->brand_id,
                        'model' => $line->model,
                        'serial_code' => $line->serial_code,
                        'quantity' => $line->quantity,
                        'unit_price' => $line->unit_price,
                        'total_price' => $line->total_price,
                        'remarks' => $line->remarks,
                        'created_at' => $line->created_at,
                        'updated_at' => $line->updated_at,
                        'material' => $line->material->name,
                        'brand' => $line->brand->name,
                    ];
                    return $data;
                });
            });

        return response()->json($data);
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
