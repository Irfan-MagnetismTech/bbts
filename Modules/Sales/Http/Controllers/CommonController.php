<?php

namespace Modules\Sales\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Admin\Entities\ConnectivityLink;
use Modules\Admin\Entities\Pop;

class CommonController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function getPopDetails(Request $request)
    {
        $pop_id = $request->pop_id;
        $connectivity_links = ConnectivityLink::with('vendor')->where('to_pop_id', 11)->latest()->get();
        $links = $connectivity_links->map(function ($connectivity_link, $key) {
            return [
                'vendor_name' => $connectivity_link?->vendor?->name,
                'from_pop_name' => Pop::where('id', $connectivity_link->from_pop_id)->first()?->name,
                'capacity' => $connectivity_link->new_capacity,
            ];
        })->toArray();
        return response()->json([
            'connectivity_links' => $links,
        ]);
    }

    public function getExistingLinkList(Request $request)
    {
        $pop_id = $request->pop_id;

        $connectivity_links = ConnectivityLink::with('vendor')->where('to_pop_id', $pop_id)->orWhere('from_pop_id', $pop_id)->latest()->get();
        $connectivity_links = $connectivity_links->map(function ($connectivity_link, $key) {
            return [
                'bbts_link_id' => $connectivity_link->bbts_link_id,
                'capacity' => $connectivity_link->new_capacity,
                'created_at' => $connectivity_link->created_at->format('d-m-Y'),
            ];
        });
        return response()->json([
            'connectivity_links' => $connectivity_links,
        ]);
    }
}
