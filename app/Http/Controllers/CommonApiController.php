<?php

namespace App\Http\Controllers;

use Modules\Admin\Entities\Pop;
use Modules\Admin\Entities\Brand;
use Modules\Admin\Entities\Branch;
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

    public function searchBranch()
    {
        $results = Branch::query()
            ->where('name', 'LIKE', request('search') . '%')
            ->get()
            ->map(fn ($item) => [
                'id' => $item->id,
                'text' => $item->name,
            ]);

        return response()->json($results);
    }

    public function searchPop()
    {
        $results = Pop::query()
            ->where('name', 'LIKE', request('search') . '%')
            ->get()
            ->map(fn ($item) => [
                'value' => $item->id,
                'label' => $item->name,
                'address' => $item->address,
            ]);

        return response()->json($results);
    }

    public function searchBrand()
    {
        $results = Brand::query()
            ->where('name', 'LIKE', request('search') . '%')
            ->get()
            ->map(fn ($item) => [
                'id' => $item->id,
                'text' => $item->name,
            ]);

        return response()->json($results);
    }
}
