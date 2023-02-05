<?php

namespace App\Http\Controllers;

use Modules\Sales\Entities\Client;
use Modules\SCM\Entities\Material;

class CommonApiController extends Controller
{
    public function searchClient()
    {
        $results = Client::query()
            ->with('clientDetails')
            ->where('name', 'LIKE', request('search') . '%')
            ->get()
            ->map(fn ($item) => [
                'value' => $item->id,
                'label' => $item->name,
                'client_no' => $item->client_no,
                'address' => $item->address,
                'details' => $item->clientDetails,
            ]);

        return response()->json($results);
    }

    public function searchMaterial()
    {
        $results = Material::query()
            ->where('name', 'LIKE', request('search') . '%')
            ->get()
            ->map(fn ($item) => [
                'value' => $item->id,
                'label' => $item->name,
                'unit' => $item->unit,
            ]);

        return response()->json($results);
    }
}
